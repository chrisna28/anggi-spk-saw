<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_Kriteria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cek_role(['admin']);
        $this->load->model([
            'Sub_Kriteria_model' => 'sub_kriteria_model', 
            'Kriteria_model' => 'kriteria_model'
        ]);
    }

    public function index() {
        $data['title'] = 'Data Sub Kriteria';
        $data['kriteria'] = $this->kriteria_model->get_all();
        
        $sub = [];
        foreach($data['kriteria'] as $k) {
            $sub[$k->id_kriteria] = $this->sub_kriteria_model->get_by_kriteria($k->id_kriteria);
        }
        $data['sub'] = $sub;

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('sub_kriteria/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambah($id_kriteria) {
        $data = [
            'id_kriteria' => $id_kriteria,
            'nama_sub' => $this->input->post('nama_sub'),
            'nilai' => $this->input->post('nilai')
        ];
        $this->sub_kriteria_model->insert($data);
        $this->session->set_flashdata('success', 'Sub kriteria berhasil ditambahkan');
        redirect('Sub_Kriteria');
    }

    public function edit($id) {
        $data = [
            'nama_sub' => $this->input->post('nama_sub'),
            'nilai' => $this->input->post('nilai')
        ];
        $this->sub_kriteria_model->update($id, $data);
        $this->session->set_flashdata('success', 'Sub kriteria berhasil diubah');
        redirect('Sub_Kriteria');
    }

    public function hapus($id) {
        $this->sub_kriteria_model->delete($id);
        $this->session->set_flashdata('success', 'Sub kriteria berhasil dihapus');
        redirect('Sub_Kriteria');
    }
}
