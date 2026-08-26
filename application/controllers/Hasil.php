<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil extends CI_Controller {

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
        $data['title'] = 'Data Hasil Akhir';
        $alternatif = $this->alternatif_model->get_all();
        $kriteria = $this->kriteria_model->get_all();

        $data['empty'] = empty($alternatif) || empty($kriteria);

        // 1. Matriks Keputusan (X)
        $matrix = [];
        $max_min = [];
        
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
                
                if (!isset($max_min[$k->id_kriteria])) {
                    $max_min[$k->id_kriteria] = ['max' => $val, 'min' => $val];
                } else {
                    if ($val > $max_min[$k->id_kriteria]['max']) $max_min[$k->id_kriteria]['max'] = $val;
                    if ($val < $max_min[$k->id_kriteria]['min']) $max_min[$k->id_kriteria]['min'] = $val;
                }
            }
        }

        // 2. Normalisasi & Perhitungan V
        $hasil = [];
        foreach ($alternatif as $a) {
            $total = 0;
            foreach ($kriteria as $k) {
                $val = $matrix[$a->id_alternatif][$k->id_kriteria];
                if ($k->jenis == 'Benefit') {
                    $r = ($max_min[$k->id_kriteria]['max'] != 0) ? $val / $max_min[$k->id_kriteria]['max'] : 0;
                } else {
                    $r = ($val != 0) ? $max_min[$k->id_kriteria]['min'] / $val : 0;
                }
                $total += $r * ($k->bobot / 100);
            }
            $hasil[] = [
                'id_alternatif' => $a->id_alternatif,
                'nama' => $a->nama_alternatif,
                'nilai' => $total
            ];
        }

        // Sort by Nilai DESC
        usort($hasil, function($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });

        $data['hasil'] = $hasil;
        $data['matrix'] = $matrix;

        // Data untuk cetak laporan
        $data['kriteria'] = $kriteria;
        $data['total_alternatif'] = count($alternatif);
        $data['nama_perusahaan'] = 'CV Ello Albasindo Perkasa';
        $data['periode'] = date('Y');
        $data['tanggal_cetak'] = date('d F Y');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('hasil/index', $data);
        $this->load->view('layouts/footer');
    }
}
