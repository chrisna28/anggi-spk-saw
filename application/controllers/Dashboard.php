<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('Auth');
        }
    }

    public function index() {
        $level = $this->session->userdata('level');

        if ($level === 'pelamar') {
            redirect('Pelamar');
        }

        if ($level === 'atasan') {
            redirect('Atasan');
        }

        $data['title'] = 'Dashboard';

        $data['count_kriteria'] = $this->db->count_all('kriteria');
        $data['count_alternatif'] = $this->db->count_all('alternatif');
        $data['count_sub'] = $this->db->count_all('sub_kriteria');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('dashboard', $data);
        $this->load->view('layouts/footer');
    }
}
