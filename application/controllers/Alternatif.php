<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alternatif extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cek_role(['admin']);
        $this->load->model('Alternatif_model', 'alternatif_model');
        $this->load->model('Pelamar_model', 'pelamar_model');
    }

    public function index() {
        $data['title'] = 'Data Alternatif';
        $data['alternatif'] = $this->alternatif_model->get_all();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('alternatif/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambah() {
        $data = [
            'nama_alternatif' => $this->input->post('nama_alternatif')
        ];
        $this->alternatif_model->insert($data);
        $this->session->set_flashdata('success', 'Data berhasil ditambahkan');
        redirect('Alternatif');
    }

    public function edit($id) {
        $data = [
            'nama_alternatif' => $this->input->post('nama_alternatif')
        ];
        $this->alternatif_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data berhasil diubah');
        redirect('Alternatif');
    }

    public function detail($id) {
        $data['title'] = 'Detail Alternatif';
        $data['alternatif'] = $this->alternatif_model->get_by_id($id);
        if (!$data['alternatif']) show_404();
        $data['pengalaman'] = $this->pelamar_model->get_pengalaman($id);
        $data['pendidikan'] = $this->pelamar_model->get_pendidikan($id);
        $data['organisasi'] = $this->pelamar_model->get_organisasi($id);
        $data['berkas'] = $this->pelamar_model->get_berkas($id);

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('alternatif/detail', $data);
        $this->load->view('layouts/footer');
    }

    public function hapus($id) {
        $this->alternatif_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus');
        redirect('Alternatif');
    }
}
