<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function cek_role($roles = []) {
    $ci =& get_instance();
    if (!$ci->session->userdata('id_user')) {
        redirect('Auth');
    }
    if (!empty($roles) && !in_array($ci->session->userdata('level'), $roles)) {
        show_error('Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.', 403);
    }
}

function role_label($level) {
    $labels = [
        'admin' => 'HRD',
        'atasan' => 'Atasan',
        'pelamar' => 'Pelamar',
    ];
    return $labels[$level] ?? ucfirst($level);
}

function is_pelamar() {
    $ci =& get_instance();
    $ci->load->model('Pelamar_model', 'pelamar_model');
    $id_user = $ci->session->userdata('id_user');
    $level = $ci->session->userdata('level');
    if ($level !== 'pelamar') return false;
    $alternatif = $ci->pelamar_model->get_by_user($id_user);
    return $alternatif ? $alternatif->id_alternatif : false;
}
