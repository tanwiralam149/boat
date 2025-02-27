<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookingController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Booking_model');
    }
	
	public function booking_list()
	{  
        $data['bookings']=$this->Booking_model->get_all_boat_booking_detail();
        // print_r($data['bookings']);
        // exit();
        $this->load->view('inc/header_view');
		$this->load->view('booking/booking_list',$data);
        $this->load->view('inc/footer_view');
	}

    public function booking_delete(){
       $booking_id=$this->input->post('bookingId');
       $result=$this->Booking_model->delete_booking_data($booking_id);
       if($result){
         echo json_encode(['success'=>true,'message'=>'Booking deleted successfully']);
       }else{
        echo json_encode(['success'=>false,'message'=>'Failed to delete booking']);
       }
    }
}
