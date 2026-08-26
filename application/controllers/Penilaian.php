<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cek_role(['admin']);
        $this->load->model([
            'Penilaian_model' => 'penilaian_model',
            'Alternatif_model' => 'alternatif_model',
            'Kriteria_model' => 'kriteria_model',
            'Sub_Kriteria_model' => 'sub_kriteria_model'
        ]);
    }

    public function index() {
        $data['title'] = 'Data Penilaian';
        $data['alternatif'] = $this->alternatif_model->get_all();
        $data['kriteria'] = $this->kriteria_model->get_all();
        
        $penilaian = [];
        foreach($data['alternatif'] as $a) {
            foreach($data['kriteria'] as $k) {
                $penilaian[$a->id_alternatif][$k->id_kriteria] = $this->penilaian_model->get_penilaian_by_kriteria($a->id_alternatif, $k->id_kriteria);
            }
        }
        $data['penilaian'] = $penilaian;

        // Get all sub criteria for the modals
        $sub = [];
        foreach($data['kriteria'] as $k) {
            $sub[$k->id_kriteria] = $this->sub_kriteria_model->get_by_kriteria($k->id_kriteria);
        }
        $data['sub'] = $sub;

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('penilaian/index', $data);
        $this->load->view('layouts/footer');
    }

    public function simpan() {
        $id_alternatif = $this->input->post('id_alternatif');
        $kriteria = $this->kriteria_model->get_all();

        foreach($kriteria as $k) {
            $id_sub = $this->input->post('kriteria_'.$k->id_kriteria);
            if ($id_sub) {
                $data = [
                    'id_alternatif' => $id_alternatif,
                    'id_kriteria' => $k->id_kriteria,
                    'id_sub' => $id_sub
                ];
                $this->penilaian_model->save($data);
            }
        }

        $this->session->set_flashdata('success', 'Penilaian berhasil disimpan');
        redirect('Penilaian');
    }
}
