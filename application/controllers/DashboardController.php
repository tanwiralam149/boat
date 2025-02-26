<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('user_id')) {
            redirect('admin');
        }
    }

    public function index() {
        $this->load->view('inc/header_view');
        $this->load->view('boat/boat_add');
        $this->load->view('inc/footer_view');
    }



    public function logout() {
        $this->session->sess_destroy();
        redirect('admin');
    }
}
