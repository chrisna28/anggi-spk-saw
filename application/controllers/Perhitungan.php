<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perhitungan extends CI_Controller {

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
        $data['title'] = 'Data Perhitungan';
        $alternatif = $this->alternatif_model->get_all();
        $kriteria = $this->kriteria_model->get_all();
        
        $data['empty'] = empty($alternatif) || empty($kriteria);

        // 1. Matriks Keputusan (X)
        $matrix = [];
        $max_min = []; // Stores max/min for normalization
        
        foreach ($alternatif as $a) {
            foreach ($kriteria as $k) {
                $p = $this->penilaian_model->get_penilaian_by_kriteria($a->id_alternatif, $k->id_kriteria);
                if ($p) {
                    $sub = $this->db->get_where('sub_kriteria', ['id_sub' => $p->id_sub])->row();
                    $val = $sub ? $sub->nilai : 0;
                } else {
                    $val = 0;
                }
                $matrix[$a->id_alternatif][$k->id_kriteria] = $val;
                
                // Initialize max_min
                if (!isset($max_min[$k->id_kriteria])) {
                    $max_min[$k->id_kriteria] = ['max' => $val, 'min' => $val];
                } else {
                    if ($val > $max_min[$k->id_kriteria]['max']) $max_min[$k->id_kriteria]['max'] = $val;
                    if ($val < $max_min[$k->id_kriteria]['min']) $max_min[$k->id_kriteria]['min'] = $val;
                }
            }
        }

        // 2. Normalisasi Matriks (R)
        $normal = [];
        foreach ($alternatif as $a) {
            foreach ($kriteria as $k) {
                $val = $matrix[$a->id_alternatif][$k->id_kriteria];
                if ($k->jenis == 'Benefit') {
                    $normal[$a->id_alternatif][$k->id_kriteria] = ($max_min[$k->id_kriteria]['max'] != 0) ? $val / $max_min[$k->id_kriteria]['max'] : 0;
                } else {
                    $normal[$a->id_alternatif][$k->id_kriteria] = ($val != 0) ? $max_min[$k->id_kriteria]['min'] / $val : 0;
                }
            }
        }

        // 3. Perhitungan Nilai Preferensi (V)
        $preferensi = [];
        foreach ($alternatif as $a) {
            $total = 0;
            foreach ($kriteria as $k) {
                $total += $normal[$a->id_alternatif][$k->id_kriteria] * ($k->bobot / 100); // Assuming weight is in percentage
            }
            $preferensi[$a->id_alternatif] = [
                'nama' => $a->nama_alternatif,
                'nilai' => $total
            ];
        }

        $data['kriteria'] = $kriteria;
        $data['alternatif'] = $alternatif;
        $data['matrix'] = $matrix;
        $data['normal'] = $normal;
        $data['preferensi'] = $preferensi;

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('perhitungan/index', $data);
        $this->load->view('layouts/footer');
    }
}
