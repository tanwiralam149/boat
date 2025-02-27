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
        // return $this->db->last_query();
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
    $availability_type = ($day_of_week >= 6) ? 'weekend' : 'weekday';

    // 🚀 Check if the boat is already booked
    $this->db->select('COUNT(*) as total');
    $this->db->from('boat_bookings');
    $this->db->where('boat_id', $boat_id);
    $this->db->where('booking_date', $booking_date);
    $this->db->where("(
        (booking_start_time BETWEEN '{$start_time}' AND '{$end_time}') 
        OR (booking_end_time BETWEEN '{$start_time}' AND '{$end_time}') 
        OR ('{$start_time}' BETWEEN booking_start_time AND booking_end_time)
        OR ('{$end_time}' BETWEEN booking_start_time AND booking_end_time)
    )", NULL, FALSE);

    $query1 = $this->db->get();
    //echo "Booking Conflict Query: " . $this->db->last_query() . "<br>";

    $booking_conflict = ($query1->num_rows() > 0) ? $query1->row()->total : 0;

    if ($booking_conflict > 0) {
        //echo "🚫 Boat is already booked!";
        return false;
    }

    // ✅ Check if the selected time is within the boat's availability
    $this->db->select('COUNT(*) as total');
    $this->db->from('boat_availability');
    $this->db->where('boat_id', $boat_id);
    $this->db->where('availability_type', $availability_type);
    $this->db->where('start_time <=', $start_time);
    $this->db->where('end_time >=', $end_time);

    $query2 = $this->db->get();
   // echo "Availability Query: " . $this->db->last_query() . "<br>";

    $schedule_conflict = ($query2->num_rows() > 0) ? $query2->row()->total : 0;
    if ($schedule_conflict == 0) {
        //echo "🚫 Boat is  available in this schedule!";
        return true;
    }

    // ✅ Ensure 90-minute gap after last booking
    $this->db->select('booking_end_time');
    $this->db->from('boat_bookings');
    $this->db->where('boat_id', $boat_id);
    $this->db->where('booking_date', $booking_date);
    $this->db->order_by('booking_end_time', 'DESC');
    $this->db->limit(1);

    $query3 = $this->db->get();
    //echo "Last Booking Query: " . $this->db->last_query() . "<br>";

    $last_booking = $query3->row();
    $last_end_time = $last_booking ? $last_booking->booking_end_time : null;

    if ($last_end_time && (strtotime($start_time) - strtotime($last_end_time) < 90 * 60)) {
       // echo "🚫 90-minute gap required after last booking!";
        return false;
    }

    // ✅ Minimum 2-hour booking check
    $duration = strtotime($end_time) - strtotime($start_time);
    if ($duration < 2 * 60 * 60) {
       // echo "🚫 Minimum booking time is 2 hours!";
        return false;
    }

    //echo "✅ Boat is available!";
    return true;
}

 

 /* Create Boat Booking */

  public function create_boat_booking($data){
     $this->db->insert('boat_bookings', $data);
     $insert_id = $this->db->insert_id();
     return  $insert_id;
  }


}
