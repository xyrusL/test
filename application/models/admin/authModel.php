<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model {
    public function verify_login($username_email) {
        $this->db->where('email', $username_email);
        $this->db->or_where('name', $username_email);
        $query = $this->db->get('admin');
        return $query->row();
    }

    public function get_admin_by_id($admin_id) {
        $this->db->where('id', $admin_id);
        $query = $this->db->get('admin');
        return $query->row();
    }
}