<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria_model extends CI_Model {

    public function get_all() {
        $this->db->order_by('kode_kriteria', 'ASC');
        return $this->db->get('kriteria')->result();
    }

    public function insert($data) {
        return $this->db->insert('kriteria', $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where('kriteria', ['id_kriteria' => $id])->row();
    }

    public function update($id, $data) {
        $this->db->where('id_kriteria', $id);
        return $this->db->update('kriteria', $data);
    }

    public function delete($id) {
        $this->db->where('id_kriteria', $id);
        return $this->db->delete('kriteria');
    }
}
