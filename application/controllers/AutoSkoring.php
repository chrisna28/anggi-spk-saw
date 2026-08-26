<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AutoSkoring extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cek_role(['admin']);
        $this->load->model('Aturan_skoring_model', 'aturan_model');
        $this->load->model('Alternatif_model', 'alternatif_model');
        $this->load->model('Penilaian_model', 'penilaian_model');
    }

    public function index() {
        $data['title'] = 'Auto Skoring';
        $data['alternatif'] = $this->alternatif_model->get_all_pelamar();
        $data['aturan_count'] = $this->db->count_all('aturan_skoring');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('auto_skoring/index', $data);
        $this->load->view('layouts/footer');
    }

    public function generate() {
        $this->load->model('Aturan_skoring_model', 'aturan_model');
        $pelamar = $this->alternatif_model->get_all_pelamar();
        $aturan_count = $this->db->count_all('aturan_skoring');

        if ($aturan_count == 0) {
            $this->session->set_flashdata('error', 'Tidak ada aturan skoring. Buat aturan terlebih dahulu.');
            redirect('AutoSkoring');
        }

        $log = [];
        $tersimpan = 0;

        foreach ($pelamar as $p) {
            $hasil = $this->aturan_model->evaluate($p->id_alternatif);

            // Hapus penilaian existing untuk alternatif ini
            $this->db->where('id_alternatif', $p->id_alternatif);
            $this->db->delete('penilaian');

            foreach ($hasil as $id_kriteria => $id_sub) {
                $this->penilaian_model->save([
                    'id_alternatif' => $p->id_alternatif,
                    'id_kriteria' => $id_kriteria,
                    'id_sub' => $id_sub,
                ]);
                $tersimpan++;
            }

            $kriteria_terpenuhi = array_keys($hasil);
            $kriteria_nama = [];
            if (!empty($kriteria_terpenuhi)) {
                $this->db->where_in('id_kriteria', $kriteria_terpenuhi);
                $q = $this->db->get('kriteria');
                foreach ($q->result() as $k) {
                    $kriteria_nama[] = $k->kode_kriteria;
                }
            }
            $log[] = [
                'nama' => $p->nama_alternatif,
                'kriteria' => implode(', ', $kriteria_nama) ?: '(tidak ada aturan cocok)',
                'total' => count($hasil),
            ];
        }

        $data['title'] = 'Hasil Auto Skoring';
        $data['log'] = $log;
        $data['total_tersimpan'] = $tersimpan;
        $data['total_pelamar'] = count($pelamar);

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('auto_skoring/hasil', $data);
        $this->load->view('layouts/footer');
    }
}
