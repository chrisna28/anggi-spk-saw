<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_Kriteria_model extends CI_Model {

    public function get_by_kriteria($id_kriteria) {
        $this->db->where('id_kriteria', $id_kriteria);
        $this->db->order_by('id_sub', 'ASC');
        return $this->db->get('sub_kriteria')->result();
    }

    public function insert($data) {
        return $this->db->insert('sub_kriteria', $data);
    }

    public function update($id, $data) {
        $this->db->where('id_sub', $id);
        return $this->db->update('sub_kriteria', $data);
    }

    public function delete($id) {
        $this->db->where('id_sub', $id);
        return $this->db->delete('sub_kriteria');
    }
}
