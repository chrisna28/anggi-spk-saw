<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cek_role(['admin']);
        $this->load->model('Kriteria_model', 'kriteria_model');
    }

    public function index() {
        $data['title'] = 'Data Kriteria';
        $data['kriteria'] = $this->kriteria_model->get_all();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('kriteria/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambah() {
        $data = [
            'kode_kriteria' => $this->input->post('kode_kriteria'),
            'nama_kriteria' => $this->input->post('nama_kriteria'),
            'bobot' => $this->input->post('bobot'),
            'jenis' => $this->input->post('jenis')
        ];
        $this->kriteria_model->insert($data);
        $this->session->set_flashdata('success', 'Data berhasil ditambahkan');
        redirect('Kriteria');
    }

    public function edit($id) {
        $data = [
            'kode_kriteria' => $this->input->post('kode_kriteria'),
            'nama_kriteria' => $this->input->post('nama_kriteria'),
            'bobot' => $this->input->post('bobot'),
            'jenis' => $this->input->post('jenis')
        ];
        $this->kriteria_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data berhasil diubah');
        redirect('Kriteria');
    }

    public function hapus($id) {
        $this->kriteria_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus');
        redirect('Kriteria');
    }
}
