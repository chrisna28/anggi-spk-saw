<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelamar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cek_role(['pelamar']);
        $this->load->model('Pelamar_model', 'pelamar_model');
        $this->id_alternatif = is_pelamar();
        if (!$this->id_alternatif) {
            show_error('Profil pelamar belum lengkap.', 400);
        }
    }

    public function index() {
        $data['title'] = 'Dashboard Pelamar';
        $data['alternatif'] = $this->pelamar_model->get_by_user($this->session->userdata('id_user'));
        $data['count_pengalaman'] = count($this->pelamar_model->get_pengalaman($this->id_alternatif));
        $data['count_pendidikan'] = count($this->pelamar_model->get_pendidikan($this->id_alternatif));
        $data['count_organisasi'] = count($this->pelamar_model->get_organisasi($this->id_alternatif));
        $data['count_berkas'] = count($this->pelamar_model->get_berkas($this->id_alternatif));

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('pelamar/dashboard', $data);
        $this->load->view('layouts/footer');
    }

    public function profil() {
        $data['title'] = 'Biodata Saya';
        $data['alternatif'] = $this->pelamar_model->get_by_user($this->session->userdata('id_user'));

        if ($this->input->method() === 'post') {
            $riwayat = $this->input->post('riwayat_penyakit');
            $update = [
                'nama_alternatif' => $this->input->post('nama_alternatif'),
                'email' => $this->input->post('email'),
                'no_telp' => $this->input->post('no_telp'),
                'alamat' => $this->input->post('alamat'),
                'jarak_rumah' => $this->input->post('jarak_rumah'),
                'riwayat_penyakit' => $riwayat,
                'riwayat_penyakit_detail' => $riwayat === 'Ya' ? $this->input->post('riwayat_penyakit_detail') : null,
            ];
            $this->pelamar_model->update_profil($this->id_alternatif, $update);
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
            redirect('Pelamar/profil');
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('pelamar/profil', $data);
        $this->load->view('layouts/footer');
    }

    public function pengalaman() {
        $data['title'] = 'Pengalaman Kerja';
        $data['pengalaman'] = $this->pelamar_model->get_pengalaman($this->id_alternatif);

        if ($this->input->method() === 'post') {
            $insert = [
                'id_alternatif' => $this->id_alternatif,
                'nama_perusahaan' => $this->input->post('nama_perusahaan'),
                'posisi' => $this->input->post('posisi'),
                'tahun_mulai' => $this->input->post('tahun_mulai'),
                'tahun_selesai' => $this->input->post('tahun_selesai') ?: null,
                'deskripsi' => $this->input->post('deskripsi'),
            ];
            $this->pelamar_model->insert_pengalaman($insert);
            $this->session->set_flashdata('success', 'Pengalaman kerja berhasil ditambahkan');
            redirect('Pelamar/pengalaman');
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('pelamar/pengalaman', $data);
        $this->load->view('layouts/footer');
    }

    public function edit_pengalaman($id) {
        $item = $this->pelamar_model->get_pengalaman_by_id($id);
        if (!$item || $item->id_alternatif != $this->id_alternatif) show_404();
        $update = [
            'nama_perusahaan' => $this->input->post('nama_perusahaan'),
            'posisi' => $this->input->post('posisi'),
            'tahun_mulai' => $this->input->post('tahun_mulai'),
            'tahun_selesai' => $this->input->post('tahun_selesai') ?: null,
            'deskripsi' => $this->input->post('deskripsi'),
        ];
        $this->pelamar_model->update_pengalaman($id, $update);
        $this->session->set_flashdata('success', 'Pengalaman kerja berhasil diubah');
        redirect('Pelamar/pengalaman');
    }

    public function hapus_pengalaman($id) {
        $item = $this->pelamar_model->get_pengalaman_by_id($id);
        if (!$item || $item->id_alternatif != $this->id_alternatif) show_404();
        $this->pelamar_model->delete_pengalaman($id);
        $this->session->set_flashdata('success', 'Pengalaman kerja berhasil dihapus');
        redirect('Pelamar/pengalaman');
    }

    public function pendidikan() {
        $data['title'] = 'Riwayat Pendidikan';
        $data['pendidikan'] = $this->pelamar_model->get_pendidikan($this->id_alternatif);

        if ($this->input->method() === 'post') {
            $insert = [
                'id_alternatif' => $this->id_alternatif,
                'jenjang' => $this->input->post('jenjang'),
                'nama_sekolah' => $this->input->post('nama_sekolah'),
                'jurusan' => $this->input->post('jurusan'),
                'tahun_masuk' => $this->input->post('tahun_masuk'),
                'tahun_lulus' => $this->input->post('tahun_lulus') ?: null,
                'ipk' => $this->input->post('ipk'),
            ];
            $this->pelamar_model->insert_pendidikan($insert);
            $this->session->set_flashdata('success', 'Pendidikan berhasil ditambahkan');
            redirect('Pelamar/pendidikan');
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('pelamar/pendidikan', $data);
        $this->load->view('layouts/footer');
    }

    public function edit_pendidikan($id) {
        $item = $this->pelamar_model->get_pendidikan_by_id($id);
        if (!$item || $item->id_alternatif != $this->id_alternatif) show_404();
        $update = [
            'jenjang' => $this->input->post('jenjang'),
            'nama_sekolah' => $this->input->post('nama_sekolah'),
            'jurusan' => $this->input->post('jurusan'),
            'tahun_masuk' => $this->input->post('tahun_masuk'),
            'tahun_lulus' => $this->input->post('tahun_lulus') ?: null,
            'ipk' => $this->input->post('ipk'),
        ];
        $this->pelamar_model->update_pendidikan($id, $update);
        $this->session->set_flashdata('success', 'Pendidikan berhasil diubah');
        redirect('Pelamar/pendidikan');
    }

    public function hapus_pendidikan($id) {
        $item = $this->pelamar_model->get_pendidikan_by_id($id);
        if (!$item || $item->id_alternatif != $this->id_alternatif) show_404();
        $this->pelamar_model->delete_pendidikan($id);
        $this->session->set_flashdata('success', 'Pendidikan berhasil dihapus');
        redirect('Pelamar/pendidikan');
    }

    public function organisasi() {
        $data['title'] = 'Riwayat Organisasi';
        $data['organisasi'] = $this->pelamar_model->get_organisasi($this->id_alternatif);

        if ($this->input->method() === 'post') {
            $insert = [
                'id_alternatif' => $this->id_alternatif,
                'nama_organisasi' => $this->input->post('nama_organisasi'),
                'jabatan' => $this->input->post('jabatan'),
                'tahun_mulai' => $this->input->post('tahun_mulai'),
                'tahun_selesai' => $this->input->post('tahun_selesai') ?: null,
            ];
            $this->pelamar_model->insert_organisasi($insert);
            $this->session->set_flashdata('success', 'Organisasi berhasil ditambahkan');
            redirect('Pelamar/organisasi');
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('pelamar/organisasi', $data);
        $this->load->view('layouts/footer');
    }

    public function edit_organisasi($id) {
        $item = $this->pelamar_model->get_organisasi_by_id($id);
        if (!$item || $item->id_alternatif != $this->id_alternatif) show_404();
        $update = [
            'nama_organisasi' => $this->input->post('nama_organisasi'),
            'jabatan' => $this->input->post('jabatan'),
            'tahun_mulai' => $this->input->post('tahun_mulai'),
            'tahun_selesai' => $this->input->post('tahun_selesai') ?: null,
        ];
        $this->pelamar_model->update_organisasi($id, $update);
        $this->session->set_flashdata('success', 'Organisasi berhasil diubah');
        redirect('Pelamar/organisasi');
    }

    public function hapus_organisasi($id) {
        $item = $this->pelamar_model->get_organisasi_by_id($id);
        if (!$item || $item->id_alternatif != $this->id_alternatif) show_404();
        $this->pelamar_model->delete_organisasi($id);
        $this->session->set_flashdata('success', 'Organisasi berhasil dihapus');
        redirect('Pelamar/organisasi');
    }

    public function berkas() {
        $data['title'] = 'Berkas Saya';
        $data['berkas'] = $this->pelamar_model->get_berkas($this->id_alternatif);

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('pelamar/berkas', $data);
        $this->load->view('layouts/footer');
    }

    public function upload_berkas() {
        $config['upload_path'] = FCPATH . 'uploads/berkas/' . $this->id_alternatif;
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }
        $config['allowed_types'] = 'pdf|jpg|jpeg|png|doc|docx';
        $config['max_size'] = 5120;
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file_berkas')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('Pelamar/berkas');
        }

        $upload_data = $this->upload->data();
        $insert = [
            'id_alternatif' => $this->id_alternatif,
            'nama_berkas' => $this->input->post('nama_berkas'),
            'jenis_berkas' => $this->input->post('jenis_berkas'),
            'file_path' => 'berkas/' . $this->id_alternatif . '/' . $upload_data['file_name'],
            'file_type' => $upload_data['file_type'],
        ];
        $this->pelamar_model->insert_berkas($insert);
        $this->session->set_flashdata('success', 'Berkas berhasil diupload');
        redirect('Pelamar/berkas');
    }

    public function hapus_berkas($id) {
        $item = $this->pelamar_model->get_berkas_by_id($id);
        if (!$item || $item->id_alternatif != $this->id_alternatif) show_404();
        $this->pelamar_model->delete_berkas($id);
        $this->session->set_flashdata('success', 'Berkas berhasil dihapus');
        redirect('Pelamar/berkas');
    }

    public function hasil() {
        $data['title'] = 'Hasil Rekomendasi';
        $ranking = $this->pelamar_model->get_ranking();
        $posisi = 0;
        $data['hasil'] = null;
        foreach ($ranking as $i => $r) {
            if ($r->id_alternatif == $this->id_alternatif) {
                $posisi = $i + 1;
                $data['hasil'] = $r;
                break;
            }
        }
        $data['posisi'] = $posisi;
        $data['total'] = count($ranking);

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('layouts/topbar');
        $this->load->view('pelamar/hasil', $data);
        $this->load->view('layouts/footer');
    }
}
