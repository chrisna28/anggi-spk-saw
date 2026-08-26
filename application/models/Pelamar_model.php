<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelamar_model extends CI_Model {

    public function get_by_user($id_user) {
        $this->db->where('id_user', $id_user);
        return $this->db->get('alternatif')->row();
    }

    public function update_profil($id, $data) {
        $this->db->where('id_alternatif', $id);
        return $this->db->update('alternatif', $data);
    }

    // Pengalaman Kerja
    public function get_pengalaman($id_alternatif) {
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->order_by('tahun_mulai', 'DESC');
        return $this->db->get('pengalaman_kerja')->result();
    }

    public function insert_pengalaman($data) {
        return $this->db->insert('pengalaman_kerja', $data);
    }

    public function get_pengalaman_by_id($id) {
        return $this->db->get_where('pengalaman_kerja', ['id_pengalaman' => $id])->row();
    }

    public function update_pengalaman($id, $data) {
        $this->db->where('id_pengalaman', $id);
        return $this->db->update('pengalaman_kerja', $data);
    }

    public function delete_pengalaman($id) {
        $this->db->where('id_pengalaman', $id);
        return $this->db->delete('pengalaman_kerja');
    }

    // Pendidikan
    public function get_pendidikan($id_alternatif) {
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->order_by('tahun_masuk', 'DESC');
        return $this->db->get('pendidikan')->result();
    }

    public function insert_pendidikan($data) {
        return $this->db->insert('pendidikan', $data);
    }

    public function get_pendidikan_by_id($id) {
        return $this->db->get_where('pendidikan', ['id_pendidikan' => $id])->row();
    }

    public function update_pendidikan($id, $data) {
        $this->db->where('id_pendidikan', $id);
        return $this->db->update('pendidikan', $data);
    }

    public function delete_pendidikan($id) {
        $this->db->where('id_pendidikan', $id);
        return $this->db->delete('pendidikan');
    }

    // Organisasi
    public function get_organisasi($id_alternatif) {
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->order_by('tahun_mulai', 'DESC');
        return $this->db->get('organisasi')->result();
    }

    public function insert_organisasi($data) {
        return $this->db->insert('organisasi', $data);
    }

    public function get_organisasi_by_id($id) {
        return $this->db->get_where('organisasi', ['id_organisasi' => $id])->row();
    }

    public function update_organisasi($id, $data) {
        $this->db->where('id_organisasi', $id);
        return $this->db->update('organisasi', $data);
    }

    public function delete_organisasi($id) {
        $this->db->where('id_organisasi', $id);
        return $this->db->delete('organisasi');
    }

    // Berkas
    public function get_berkas($id_alternatif) {
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->order_by('uploaded_at', 'DESC');
        return $this->db->get('berkas')->result();
    }

    public function get_all_berkas_with_pelamar() {
        $this->db->select('berkas.*, alternatif.nama_alternatif, alternatif.email');
        $this->db->join('alternatif', 'alternatif.id_alternatif = berkas.id_alternatif');
        $this->db->order_by('berkas.uploaded_at', 'DESC');
        return $this->db->get('berkas')->result();
    }

    public function insert_berkas($data) {
        return $this->db->insert('berkas', $data);
    }

    public function get_berkas_by_id($id) {
        return $this->db->get_where('berkas', ['id_berkas' => $id])->row();
    }

    public function update_status_validasi($id, $status, $catatan = null) {
        $data = ['status_validasi' => $status];
        if ($catatan !== null) {
            $data['catatan_hrd'] = $catatan;
        }
        $this->db->where('id_berkas', $id);
        return $this->db->update('berkas', $data);
    }

    public function delete_berkas($id) {
        $berkas = $this->get_berkas_by_id($id);
        if ($berkas && file_exists(FCPATH . 'uploads/' . $berkas->file_path)) {
            unlink(FCPATH . 'uploads/' . $berkas->file_path);
        }
        $this->db->where('id_berkas', $id);
        return $this->db->delete('berkas');
    }

    // Hasil untuk pelamar
    public function get_ranking() {
        $query = $this->db->query("
            SELECT a.id_alternatif, a.nama_alternatif,
                SUM(IF(k.jenis='Benefit', sn.nilai / sm.max_nilai, sm.min_nilai / sn.nilai) * (k.bobot/100)) as nilai
            FROM alternatif a
            CROSS JOIN kriteria k
            LEFT JOIN penilaian p ON p.id_alternatif = a.id_alternatif AND p.id_kriteria = k.id_kriteria
            LEFT JOIN sub_kriteria sn ON sn.id_sub = p.id_sub
            LEFT JOIN (
                SELECT p2.id_kriteria,
                    MAX(sn2.nilai) as max_nilai,
                    MIN(sn2.nilai) as min_nilai
                FROM penilaian p2
                JOIN sub_kriteria sn2 ON sn2.id_sub = p2.id_sub
                GROUP BY p2.id_kriteria
            ) sm ON sm.id_kriteria = k.id_kriteria
            GROUP BY a.id_alternatif
            ORDER BY nilai DESC
        ");
        return $query->result();
    }
}
