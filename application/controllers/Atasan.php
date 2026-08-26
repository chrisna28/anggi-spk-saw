<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atasan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cek_role(['atasan']);
        $this->load->model('Alternatif_model', 'alternatif_model');
        $this->load->model('Kriteria_model', 'kriteria_model');
        $this->load->model('Sub_Kriteria_model', 'sub_kriteria_model');
        $this->load->model('Penilaian_model', 'penilaian_model');
        $this->load->model('Pelamar_model', 'pelamar_model');
    }

    public function index() {
        $data['title'] = 'Dashboard Atasan';
        $data['count_alternatif'] = $this->db->count_all('alternatif');
        $data['count_kriteria'] = $this->db->count_all('kriteria');

        $ranking = $this->_get_ranking();
        $data['ranking_top'] = array_slice($ranking, 0, 3);
        $data['total_pelamar'] = count($ranking);

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('atasan/dashboard', $data);
        $this->load->view('layouts/footer');
    }

    public function pelamar() {
        $data['title'] = 'Data Pelamar';
        $data['pelamar'] = $this->alternatif_model->get_all_pelamar();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('atasan/pelamar', $data);
        $this->load->view('layouts/footer');
    }

    public function detail_pelamar($id) {
        $data['title'] = 'Detail Pelamar';
        $data['alternatif'] = $this->alternatif_model->get_by_id($id);
        if (!$data['alternatif']) show_404();
        $data['pengalaman'] = $this->pelamar_model->get_pengalaman($id);
        $data['pendidikan'] = $this->pelamar_model->get_pendidikan($id);
        $data['organisasi'] = $this->pelamar_model->get_organisasi($id);
        $data['berkas'] = $this->pelamar_model->get_berkas($id);

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('atasan/detail_pelamar', $data);
        $this->load->view('layouts/footer');
    }

    public function penilaian() {
        $data['title'] = 'Data Penilaian';

        $this->db->select('p.id_penilaian, a.nama_alternatif, k.kode_kriteria, k.nama_kriteria, sn.nama_sub, sn.nilai');
        $this->db->from('penilaian p');
        $this->db->join('alternatif a', 'a.id_alternatif = p.id_alternatif');
        $this->db->join('kriteria k', 'k.id_kriteria = p.id_kriteria');
        $this->db->join('sub_kriteria sn', 'sn.id_sub = p.id_sub');
        $this->db->order_by('a.nama_alternatif, k.kode_kriteria');
        $data['penilaian'] = $this->db->get()->result();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('atasan/penilaian', $data);
        $this->load->view('layouts/footer');
    }

    public function perhitungan() {
        $data['title'] = 'Data Perhitungan';

        $kriteria = $this->kriteria_model->get_all();
        $alternatif = $this->alternatif_model->get_all();
        $penilaian = $this->db->get('penilaian')->result();
        $sub = $this->db->get('sub_kriteria')->result();

        // Build matrix X
        $matrix_x = [];
        $max_min = [];
        foreach ($alternatif as $a) {
            foreach ($kriteria as $k) {
                $nilai = 0;
                foreach ($penilaian as $p) {
                    if ($p->id_alternatif == $a->id_alternatif && $p->id_kriteria == $k->id_kriteria) {
                        foreach ($sub as $s) {
                            if ($s->id_sub == $p->id_sub) {
                                $nilai = $s->nilai;
                                break;
                            }
                        }
                        break;
                    }
                }
                $matrix_x[$a->id_alternatif][$k->id_kriteria] = $nilai;
                if (!isset($max_min[$k->id_kriteria])) {
                    $max_min[$k->id_kriteria] = ['max' => $nilai, 'min' => $nilai];
                } else {
                    $max_min[$k->id_kriteria]['max'] = max($max_min[$k->id_kriteria]['max'], $nilai);
                    $max_min[$k->id_kriteria]['min'] = min($max_min[$k->id_kriteria]['min'], $nilai);
                }
            }
        }

        // Normalize R
        $matrix_r = [];
        foreach ($alternatif as $a) {
            foreach ($kriteria as $k) {
                $x = $matrix_x[$a->id_alternatif][$k->id_kriteria];
                if ($k->jenis == 'Benefit') {
                    $matrix_r[$a->id_alternatif][$k->id_kriteria] = $max_min[$k->id_kriteria]['max'] > 0 ? $x / $max_min[$k->id_kriteria]['max'] : 0;
                } else {
                    $matrix_r[$a->id_alternatif][$k->id_kriteria] = $x > 0 ? $max_min[$k->id_kriteria]['min'] / $x : 0;
                }
            }
        }

        // Calculate V
        $nilai_v = [];
        foreach ($alternatif as $a) {
            $total = 0;
            foreach ($kriteria as $k) {
                $total += $matrix_r[$a->id_alternatif][$k->id_kriteria] * ($k->bobot / 100);
            }
            $nilai_v[$a->id_alternatif] = $total;
        }

        $data['kriteria'] = $kriteria;
        $data['alternatif'] = $alternatif;
        $data['matrix_x'] = $matrix_x;
        $data['matrix_r'] = $matrix_r;
        $data['nilai_v'] = $nilai_v;

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('atasan/perhitungan', $data);
        $this->load->view('layouts/footer');
    }

    public function hasil() {
        $data['title'] = 'Hasil Akhir';
        $data['ranking'] = $this->_get_ranking();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('atasan/hasil', $data);
        $this->load->view('layouts/footer');
    }

    private function _get_ranking() {
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
