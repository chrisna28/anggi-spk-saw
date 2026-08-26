<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aturan_skoring_model extends CI_Model {

    public function get_all() {
        $this->db->select('aturan_skoring.*, kriteria.kode_kriteria, kriteria.nama_kriteria, sub_kriteria.nama_sub, sub_kriteria.nilai');
        $this->db->join('kriteria', 'kriteria.id_kriteria = aturan_skoring.id_kriteria');
        $this->db->join('sub_kriteria', 'sub_kriteria.id_sub = aturan_skoring.id_sub');
        $results = $this->db->get('aturan_skoring')->result();

        usort($results, function ($a, $b) {
            $cmp = strcmp($a->kode_kriteria, $b->kode_kriteria);
            if ($cmp !== 0) return $cmp;
            return (float)$b->nilai_min - (float)$a->nilai_min;
        });

        return $results;
    }

    public function get_by_id($id) {
        return $this->db->get_where('aturan_skoring', ['id_aturan' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('aturan_skoring', $data);
    }

    public function update($id, $data) {
        $this->db->where('id_aturan', $id);
        return $this->db->update('aturan_skoring', $data);
    }

    public function delete($id) {
        $this->db->where('id_aturan', $id);
        return $this->db->delete('aturan_skoring');
    }

    public function get_by_kriteria($id_kriteria) {
        $this->db->where('id_kriteria', $id_kriteria);
        $this->db->order_by('nilai_min DESC');
        return $this->db->get('aturan_skoring')->result();
    }

    public function evaluate($id_alternatif) {
        $aturan = $this->get_all();
        $hasil = [];

        $total_pengalaman = $this->_hitung_total_pengalaman($id_alternatif);
        $total_organisasi = $this->_hitung_total_organisasi($id_alternatif);
        $jenjang_tertinggi = $this->_jenjang_tertinggi($id_alternatif);
        $berkas_list = $this->_jenis_berkas($id_alternatif);
        $jumlah_berkas_valid = $this->_hitung_berkas_valid($id_alternatif);
        $profil = $this->db->get_where('alternatif', ['id_alternatif' => $id_alternatif])->row();

        foreach ($aturan as $a) {
            $nilai_sumber = null;
            switch ($a->sumber_data) {
                case 'pengalaman_kerja':
                    if ($a->field_sumber === 'total_tahun') {
                        $nilai_sumber = $total_pengalaman;
                    }
                    break;
                case 'organisasi':
                    if ($a->field_sumber === 'jumlah') {
                        $nilai_sumber = $total_organisasi;
                    }
                    break;
                case 'pendidikan':
                    if ($a->field_sumber === 'jenjang') {
                        $nilai_sumber = $jenjang_tertinggi;
                    }
                    break;
                case 'berkas':
                    if ($a->field_sumber === 'jenis_berkas') {
                        $nilai_sumber = in_array($a->nilai_min, $berkas_list) ? $a->nilai_min : null;
                    } elseif ($a->field_sumber === 'jumlah_valid') {
                        $nilai_sumber = $jumlah_berkas_valid;
                    }
                    break;
                case 'profil':
                    if ($profil && isset($profil->{$a->field_sumber})) {
                        $nilai_sumber = $profil->{$a->field_sumber};
                    }
                    break;
            }

            if ($nilai_sumber === null) continue;

            $cocok = false;
            switch ($a->operator) {
                case '>=':
                    $cocok = (float)$nilai_sumber >= (float)$a->nilai_min;
                    break;
                case '<=':
                    $cocok = (float)$nilai_sumber <= (float)$a->nilai_min;
                    break;
                case '=':
                    $cocok = (string)$nilai_sumber === (string)$a->nilai_min;
                    break;
                case '>':
                    $cocok = (float)$nilai_sumber > (float)$a->nilai_min;
                    break;
                case '<':
                    $cocok = (float)$nilai_sumber < (float)$a->nilai_min;
                    break;
                case 'between':
                    $cocok = (float)$nilai_sumber >= (float)$a->nilai_min && (float)$nilai_sumber < (float)$a->nilai_max;
                    break;
            }

            if ($cocok && !isset($hasil[$a->id_kriteria])) {
                $hasil[$a->id_kriteria] = $a->id_sub;
            }
        }

        return $hasil;
    }

    private function _hitung_total_pengalaman($id_alternatif) {
        $q = $this->db->query("
            SELECT COALESCE(SUM(
                CASE
                    WHEN tahun_selesai IS NOT NULL THEN (tahun_selesai - tahun_mulai)
                    ELSE (YEAR(CURDATE()) - tahun_mulai)
                END
            ), 0) as total
            FROM pengalaman_kerja WHERE id_alternatif = ?
        ", [$id_alternatif]);
        return (float)$q->row()->total;
    }

    private function _hitung_total_organisasi($id_alternatif) {
        $this->db->where('id_alternatif', $id_alternatif);
        return $this->db->count_all_results('organisasi');
    }

    private function _jenjang_tertinggi($id_alternatif) {
        $urutan = ['SD' => 1, 'SMP' => 2, 'SMA' => 3, 'D3' => 4, 'S1' => 5, 'S2' => 6, 'S3' => 7];
        $this->db->where('id_alternatif', $id_alternatif);
        $q = $this->db->get('pendidikan');
        $tertinggi = null;
        $skor = 0;
        foreach ($q->result() as $r) {
            $s = $urutan[$r->jenjang] ?? 0;
            if ($s > $skor) {
                $jenis_ijazah = 'Ijazah ' . $r->jenjang;
                if ($this->_berkas_valid($id_alternatif, $jenis_ijazah)) {
                    $skor = $s;
                    $tertinggi = $r->jenjang;
                }
            }
        }
        return $tertinggi;
    }

    private function _berkas_valid($id_alternatif, $jenis_berkas) {
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->where('jenis_berkas', $jenis_berkas);
        $this->db->where('status_validasi !=', 'invalid');
        return $this->db->count_all_results('berkas') > 0;
    }

    private function _jenis_berkas($id_alternatif) {
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->where('status_validasi !=', 'invalid');
        $q = $this->db->get('berkas');
        $list = [];
        foreach ($q->result() as $r) {
            if ($r->jenis_berkas) $list[] = $r->jenis_berkas;
        }
        return $list;
    }

    private function _hitung_berkas_valid($id_alternatif) {
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->where('status_validasi !=', 'invalid');
        return $this->db->count_all_results('berkas');
    }
}
