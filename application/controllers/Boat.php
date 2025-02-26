<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boat extends CI_Controller {

    public function __construct() {
        parent::__construct();
       
        $this->load->model('Boat_model');

       
    }
	public function index()
	{
        $data['boats']=$this->Boat_model->get_boats(['status'=>0]);
		$this->load->view('boat_booking_front',$data);
	}
}
