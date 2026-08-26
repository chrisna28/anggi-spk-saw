<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ValidasiBerkas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cek_role(['admin']);
        $this->load->model('Pelamar_model', 'pelamar_model');
    }

    public function index() {
        $data['title'] = 'Validasi Berkas Pelamar';
        $data['berkas'] = $this->pelamar_model->get_all_berkas_with_pelamar();

        $total_berkas = count($data['berkas']);
        $total_valid = 0;
        $total_invalid = 0;
        $total_pending = 0;
        foreach ($data['berkas'] as $b) {
            if ($b->status_validasi == 'valid') $total_valid++;
            elseif ($b->status_validasi == 'invalid') $total_invalid++;
            else $total_pending++;
        }
        $data['summary'] = [
            'total' => $total_berkas,
            'valid' => $total_valid,
            'invalid' => $total_invalid,
            'pending' => $total_pending,
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('validasi_berkas/index', $data);
        $this->load->view('layouts/footer');
    }

    public function validasi($id) {
        $berkas = $this->pelamar_model->get_berkas_by_id($id);
        if (!$berkas) show_404();

        if ($this->input->method() === 'post') {
            $status = $this->input->post('status');
            $catatan = $this->input->post('catatan');

            if (!in_array($status, ['valid', 'invalid'])) {
                $this->session->set_flashdata('error', 'Status tidak valid');
                redirect('ValidasiBerkas');
            }

            $this->pelamar_model->update_status_validasi($id, $status, $catatan);
            $this->session->set_flashdata('success', 'Berkas berhasil divalidasi');
            redirect('ValidasiBerkas');
        }

        show_404();
    }
}
