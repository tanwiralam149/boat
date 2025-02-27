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

    public function check_boat_availability() {
        
       // print_r($this->input->post());

        $boat_id = $this->input->post('boat_id');
        $booking_date = $this->input->post('booking_date');
        $start_time = $this->input->post('start_time',TRUE);
        $end_time = $this->input->post('end_time',TRUE);

        // Convert times to timestamps
        $start = strtotime($start_time);
        $end = strtotime($end_time);
        // Calculate the difference in seconds
        $difference = $end - $start;
        // Convert seconds to hours and minutes
        $hours = floor($difference / 3600); // Total hours
        $minutes = floor(($difference % 3600) / 60); // Remaining minutes
        $hours_minutes='';
         
        if($hours < 2 ){
            echo json_encode(['success' => false, 'message' => 'Minimum 2-hour booking duration ','hours'=>$hours]);
        }else{
                  
            $is_available = $this->Booking_model->check_boat_availability($boat_id, $booking_date, $start_time, $end_time);

            if ($is_available) {
                echo json_encode(['success' =>true, 'message' => 'Boat is available for booking.','hours'=>$hours]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Boat is already booked or unavailable at this time.','hours'=>$hours]);
            }
        }
    }


    /* CREATE BOAT BOOKING FOR CUSTOMER  */

    public function create_boat_booking(){
        
      $name=$this->input->post('name');
      $email=$this->input->post('email');
      $phone=$this->input->post('phone');
      $boat_id=$this->input->post('boat_id');
      $booking_date=$this->input->post('booking_date');
      $start_time=$this->input->post('start_time');
      $end_time=$this->input->post('end_time');
      $availability_id=$this->input->post('end_time');
        
       $result=$this->Booking_model->create_boat_booking([
                'customer_name' =>$name,
                'customer_email' =>$email,
                'customer_phone' =>$phone,
                'boat_id' =>$boat_id,
                'booking_date' =>date('Y-m-d',strtotime($booking_date)),
                'availability_id' =>$availability_id,
                'booking_start_time' =>$start_time,
                'booking_end_time' =>$end_time,
        ]);

        if ($result) {
            $this->session->set_flashdata('success', 'Booking created successfully.');
            echo json_encode(['success' => true, 'message' => 'Booking created successfully.']);
        } else {
            $this->session->set_flashdata('success', 'Booking booking failed.');
            echo json_encode(['success' => false, 'message' => 'Booking booking failed']);
        }
       
    }
}
