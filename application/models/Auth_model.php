<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function check_login($username) {
        $this->db->where('username', $username);
        return $this->db->get('users')->row();
    }
}
