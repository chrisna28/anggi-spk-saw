<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model', 'auth_model');
        $this->load->model('Alternatif_model', 'alternatif_model');
    }

    public function index() {
        if ($this->session->userdata('id_user')) {
            redirect('Dashboard');
        }
        $this->load->view('login');
    }

    public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->auth_model->check_login($username);

        if ($user) {
            if (password_verify($password, $user->password)) {
                $data = [
                    'id_user' => $user->id_user,
                    'username' => $user->username,
                    'nama' => $user->nama,
                    'level' => $user->level
                ];
                $this->session->set_userdata($data);
                redirect('Dashboard');
            } else {
                $this->session->set_flashdata('error', 'Password salah!');
                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Username tidak ditemukan!');
            redirect('Auth');
        }
    }

    public function register() {
        if ($this->session->userdata('id_user')) {
            redirect('Dashboard');
        }

        if ($this->input->method() === 'post') {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $nama = $this->input->post('nama');

            $existing = $this->auth_model->check_login($username);
            if ($existing) {
                $this->session->set_flashdata('error', 'Username sudah digunakan!');
                redirect('Auth/register');
            }

            $user_data = [
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'nama' => $nama,
                'level' => 'pelamar'
            ];
            $this->db->insert('users', $user_data);
            $id_user = $this->db->insert_id();

            $alternatif_data = [
                'id_user' => $id_user,
                'nama_alternatif' => $nama,
            ];
            $this->alternatif_model->insert($alternatif_data);

            $this->session->set_userdata([
                'id_user' => $id_user,
                'username' => $username,
                'nama' => $nama,
                'level' => 'pelamar'
            ]);
            redirect('Pelamar');
        }

        $this->load->view('register');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('Auth');
    }
}
