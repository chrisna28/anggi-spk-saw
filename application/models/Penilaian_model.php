<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian_model extends CI_Model {

    public function get_penilaian($id_alternatif) {
        $this->db->where('id_alternatif', $id_alternatif);
        return $this->db->get('penilaian')->result();
    }

    public function get_penilaian_by_kriteria($id_alternatif, $id_kriteria) {
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->where('id_kriteria', $id_kriteria);
        return $this->db->get('penilaian')->row();
    }

    public function save($data) {
        $this->db->where('id_alternatif', $data['id_alternatif']);
        $this->db->where('id_kriteria', $data['id_kriteria']);
        $check = $this->db->get('penilaian')->row();

        if ($check) {
            $this->db->where('id_penilaian', $check->id_penilaian);
            return $this->db->update('penilaian', ['id_sub' => $data['id_sub']]);
        } else {
            return $this->db->insert('penilaian', $data);
        }
    }
}
