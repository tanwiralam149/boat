<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /* Booking section Banckend */
    public function get_all_boat_booking_detail(){
         $this->db->select("bb.id AS booking_id,b.boat_name,ba.availability_type,bb.customer_name,bb.customer_phone,
         bb.customer_email,bb.booking_date,bb.booking_start_time,bb.booking_end_time,bb.booking_status");
         $this->db->from("boat_bookings bb");
         $this->db->join("boats b","bb.boat_id=b.id");
         $this->db->join("boat_availability ba","bb.availability_id=ba.id");
         $this->db->order_by("bb.booking_date","desc");
         return $this->db->get()->result_array();
    }
   public function delete_booking_data($booking_id){
        $this->db->trans_start();
        $this->db->where('id',$booking_id);
        $this->db->delete("boat_bookings");
        $this->db->trans_complete(); 
        return $this->db->trans_status();
   }

   /* Booking for Frontend */
   public function check_availability_type_time_acc_to_date($booking_date,$boat_id){
        //Boat Availability Type from Date
        $day_of_week=date("N",strtotime($booking_date)); // 1 = Monday, 7 = Sunday
        $availability_type=($day_of_week >=6) ?  'weekend' : 'weekdays'; // Determine availability type
         
        $this->db->where("boat_id",$boat_id);
        $this->db->where("availability_type",$availability_type);
        $query=$this->db->get("boat_availability");
        return $query->result_array();
   }


   public function check_boat_availability($boat_id, $booking_date, $start_time, $end_time) {
     $day_of_week = date('N', strtotime($booking_date)); // 1 = Monday, 7 = Sunday
     $availability_type = ($day_of_week >= 6) ? 'weekend' : 'weekday'; // Determine availability type

     // Check if the boat is already booked
     $this->db->select('COUNT(*) as total');
     $this->db->from('boat_bookings');
     $this->db->where('boat_id', $boat_id);
     $this->db->where('booking_date', $booking_date);
     $this->db->where("(
         (booking_start_time BETWEEN '$start_time' AND '$end_time') 
         OR (booking_end_time BETWEEN '$start_time' AND '$end_time') 
         OR ('$start_time' BETWEEN booking_start_time AND booking_end_time)
         OR ('$end_time' BETWEEN booking_start_time AND booking_end_time)
     )", NULL, FALSE);
     $booking_conflict = $this->db->get()->row()->total;
    
     // Check if the selected time is within the boat's available schedule
     $this->db->select('COUNT(*) as total');
     $this->db->from('boat_availability');
     $this->db->where('boat_id', $boat_id);
     $this->db->where('availability_type', $availability_type);
     $this->db->where('start_time <=', $start_time);
     $this->db->where('end_time >=', $end_time);
     $schedule_conflict = $this->db->get()->row()->total;
    
     // Ensure 90-minute gap after last booking
     $this->db->select('booking_end_time');
     $this->db->from('boat_bookings');
     $this->db->where('boat_id', $boat_id);
     $this->db->where('booking_date', $booking_date);
     $this->db->order_by('booking_end_time', 'DESC');
     $this->db->limit(1);
     $last_booking = $this->db->get()->row();
    
     if ($last_booking) {
         $last_end_time = $last_booking->end_time;
         $time_difference = strtotime($start_time) - strtotime($last_end_time);
         if ($time_difference < 90 * 60) { // Less than 90 minutes
             return false;
         }
     }
     //return $this->db->last_query();
     return ($booking_conflict == 0 && $schedule_conflict > 0);
 }

 /* Create Boat Booking */

  public function create_boat_booking($data){
     $this->db->insert('boat_bookings', $data);
     $insert_id = $this->db->insert_id();
     return  $insert_id;
  }


}
