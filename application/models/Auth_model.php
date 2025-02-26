<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function check_login($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', $password); // Use hashing in production
        $query = $this->db->get('users');
        return $query->row(); // Return user data if found
    }
}
