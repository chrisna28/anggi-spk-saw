<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AturanSkoring extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cek_role(['admin']);
        $this->load->model('Aturan_skoring_model', 'aturan_model');
        $this->load->model('Kriteria_model', 'kriteria_model');
        $this->load->model('Sub_Kriteria_model', 'sub_kriteria_model');
    }

    public function index() {
        $data['title'] = 'Aturan Skoring';
        $data['aturan'] = $this->aturan_model->get_all();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('aturan_skoring/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambah() {
        $data['title'] = 'Tambah Aturan Skoring';
        $data['kriteria'] = $this->kriteria_model->get_all();

        if ($this->input->method() === 'post') {
            $insert = [
                'id_kriteria' => $this->input->post('id_kriteria'),
                'id_sub' => $this->input->post('id_sub'),
                'sumber_data' => $this->input->post('sumber_data'),
                'field_sumber' => $this->input->post('field_sumber'),
                'operator' => $this->input->post('operator'),
                'nilai_min' => $this->input->post('nilai_min'),
                'nilai_max' => $this->input->post('nilai_max'),
            ];
            $this->aturan_model->insert($insert);
            $this->session->set_flashdata('success', 'Aturan skoring berhasil ditambahkan');
            redirect('AturanSkoring');
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('aturan_skoring/tambah', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id) {
        $data['title'] = 'Edit Aturan Skoring';
        $data['aturan'] = $this->aturan_model->get_by_id($id);
        if (!$data['aturan']) show_404();
        $data['kriteria'] = $this->kriteria_model->get_all();
        $data['sub_kriteria'] = $this->sub_kriteria_model->get_by_kriteria($data['aturan']->id_kriteria);

        if ($this->input->method() === 'post') {
            $update = [
                'id_kriteria' => $this->input->post('id_kriteria'),
                'id_sub' => $this->input->post('id_sub'),
                'sumber_data' => $this->input->post('sumber_data'),
                'field_sumber' => $this->input->post('field_sumber'),
                'operator' => $this->input->post('operator'),
                'nilai_min' => $this->input->post('nilai_min'),
                'nilai_max' => $this->input->post('nilai_max'),
            ];
            $this->aturan_model->update($id, $update);
            $this->session->set_flashdata('success', 'Aturan skoring berhasil diubah');
            redirect('AturanSkoring');
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('aturan_skoring/edit', $data);
        $this->load->view('layouts/footer');
    }

    public function hapus($id) {
        $this->aturan_model->delete($id);
        $this->session->set_flashdata('success', 'Aturan skoring berhasil dihapus');
        redirect('AturanSkoring');
    }

    public function get_sub_by_kriteria() {
        $id_kriteria = $this->input->get('id_kriteria');
        if ($id_kriteria) {
            $sub = $this->sub_kriteria_model->get_by_kriteria($id_kriteria);
            echo json_encode($sub);
        }
    }

    public function get_field_by_sumber() {
        $sumber = $this->input->get('sumber_data');
        $fields = [
            'pengalaman_kerja' => [
                ['value' => 'total_tahun', 'label' => 'Total Tahun Pengalaman'],
            ],
            'organisasi' => [
                ['value' => 'jumlah', 'label' => 'Jumlah Organisasi'],
            ],
            'pendidikan' => [
                ['value' => 'jenjang', 'label' => 'Jenjang Pendidikan Tertinggi'],
            ],
            'berkas' => [
                ['value' => 'jumlah_valid', 'label' => 'Jumlah Berkas Valid'],
                ['value' => 'jenis_berkas', 'label' => 'Jenis Berkas'],
            ],
            'profil' => [
                ['value' => 'jarak_rumah', 'label' => 'Jarak Rumah (km)'],
                ['value' => 'riwayat_penyakit', 'label' => 'Riwayat Penyakit'],
            ],
        ];
        echo json_encode($fields[$sumber] ?? []);
    }
}
