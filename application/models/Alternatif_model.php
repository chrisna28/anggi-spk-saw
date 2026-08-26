<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alternatif_model extends CI_Model {

    public function get_all() {
        return $this->db->get('alternatif')->result();
    }

    public function get_by_id($id) {
        $this->db->where('id_alternatif', $id);
        return $this->db->get('alternatif')->row();
    }

    public function insert($data) {
        return $this->db->insert('alternatif', $data);
    }

    public function update($id, $data) {
        $this->db->where('id_alternatif', $id);
        return $this->db->update('alternatif', $data);
    }

    public function delete($id) {
        $this->db->where('id_alternatif', $id);
        return $this->db->delete('alternatif');
    }

    public function get_all_pelamar() {
        $this->db->select('alternatif.*, users.username');
        $this->db->join('users', 'users.id_user = alternatif.id_user', 'left');
        $this->db->where('users.level', 'pelamar');
        return $this->db->get('alternatif')->result();
    }
}
