<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Boat_model');
        $this->load->model('Booking_model');
    }
	public function index()
	{
        $data['boats']=$this->Boat_model->get_boats(['status'=>0]);
		$this->load->view('boat_booking_front',$data);
	}

    public function check_availability_type_time_acc_to_date(){
        $booking_date=$this->input->post('bookingDate');
        $boat_id=$this->input->post('boatId');

        $day_of_week=date("N",strtotime($booking_date)); // 1 = Monday, 7 = Sunday
        $availability_type=($day_of_week >=6) ?  'weekend' : 'weekdays'; // Determine availability type

        $result=$this->Booking_model->check_availability_type_time_acc_to_date($booking_date,$boat_id);
        if($result){
            echo json_encode(['data'=>$result,'success'=>true,'message'=>'Data found.','availability_type'=>$availability_type,'date'=>$booking_date,'day_of_week'=>$day_of_week]);
        }else{
            echo json_encode(['data'=>[],'success'=>false,'message'=>'Data not found.','availability_type'=>$availability_type,'date'=>$booking_date,'day_of_week'=>$day_of_week]);
        }
    }
}
