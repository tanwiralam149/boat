<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->model('Auth_model');

        if ($this->session->userdata('user_id')) {
            redirect('add');
        }
    }

    public function login() {
       
        $this->load->view('login_view');
    }

    public function do_login() {
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->Auth_model->check_login($username, $password);

            if ($user) {
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'name' => $user->name,
                    'logged_in' => TRUE
                ]);
                $this->session->set_flashdata('success', 'Login Success');
                redirect('add');
            } else {
                $this->session->set_flashdata('error', 'Invalid username or password');
                redirect('admin');
            }
        }

        $this->load->view('login_view');
    }

 
}
