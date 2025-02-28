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
        $availability_type=($day_of_week >=6) ?  'weekends' : 'weekdays'; // Determine availability type
        $this->db->where("boat_id",$boat_id);
        $this->db->where("availability_type",$availability_type);
        $this->db->order_by('UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)', 'DESC');
        $this->db->limit(1); // Limit to 1 row
        $query=$this->db->get("boat_availability");
        $availability_data=$query->row_array();

        if (!$availability_data) {
            return null; // Return null if no availability record is found
        }

        // // Query to fetch all bookings for the given boat_id and booking_date
        $this->db->select('*');
        $this->db->from('boat_bookings');
        $this->db->where('boat_id', $boat_id);
        $this->db->where('booking_date', $booking_date);
        $bookings_query = $this->db->get();
        $bookings_data = $bookings_query->result_array(); // Get all bookings





             // Convert start and end times to timestamps
             $start_time = strtotime($availability_data['start_time']);
             $end_time = strtotime($availability_data['end_time']);
     
             // Create an array to store booked time slots
             $booked_slots = [];
     
             // Loop through bookings and add booked slots to the array
             foreach ($bookings_data as $booking) {
                 $booking_start = strtotime($booking['booking_start_time']);
                 $booking_end = strtotime($booking['booking_end_time']);
     
                 // Add all 30-minute intervals within the booking range to the booked_slots array
                 for ($time = $booking_start; $time < $booking_end; $time += 1800) { // 1800 seconds = 30 minutes
                     $booked_slots[] = date("H:i:s", $time);
                 }
             }
     
             // Generate all possible 30-minute slots between start_time and end_time
             $all_slots = [];
             for ($time = $start_time; $time < $end_time; $time += 1800) { // 1800 seconds = 30 minutes
                 $all_slots[] = date("H:i:s", $time);
             }
     
             // Remove booked slots from all slots to get available slots
             $available_slots = array_diff($all_slots, $booked_slots);
     
             // Convert the result to an array (array_diff returns an associative array)
             $available_slots = array_values($available_slots);
     
           //  return $available_slots;
        // Combine availability and bookings data
        $response = [
            'availability' => $availability_data,
            'bookings' => $bookings_data,
            'available_slots'=>$available_slots
        ];
         
        return $response;


         // Query to fetch all bookings for the given boat_id and booking_date
  /*  $this->db->select('*');
    $this->db->from('boat_bookings');
    $this->db->where('boat_id', $boat_id);
    $this->db->where('booking_date', $booking_date);
    $this->db->order_by('booking_start_time', 'ASC'); // Order bookings by start_time
    $bookings_query = $this->db->get();

    $bookings_data = $bookings_query->result_array(); // Get all bookings

    // Initialize new_start_time and new_end_time with availability times
    $new_start_time = $availability_data['start_time'];
    $new_end_time = $availability_data['end_time'];

    // Adjust availability based on bookings and 90-minute buffer
    foreach ($bookings_data as $booking) {
        $booking_start = strtotime($booking['booking_start_time']);
        $booking_end = strtotime($booking['booking_end_time']);
        $buffer_end = $booking_end + (90 * 60); // Add 90 minutes buffer

        // If booking overlaps with current availability, adjust new_start_time and new_end_time
        if ($booking_start < strtotime($new_end_time) && $booking_end > strtotime($new_start_time)) {
            if ($booking_start <= strtotime($new_start_time)) {
                $new_start_time = date('H:i:s', $buffer_end); // Move start_time after buffer
            } else {
                $new_end_time = date('H:i:s', $booking_start); // Move end_time before booking
            }
        }

    }

    // Add new_start_time and new_end_time to availability data
    $availability_data['new_start_time'] = $new_start_time;
    $availability_data['new_end_time'] = $new_end_time;

    // Combine availability and bookings data
    $response = [
        'availability' => $availability_data,
        'bookings' => $bookings_data
    ];

    return $response;  */
   }



   public function check_boat_availability($boat_id, $booking_date, $start_time, $end_time) {
    $day_of_week = date('N', strtotime($booking_date)); // 1 = Monday, 7 = Sunday
    $availability_type = ($day_of_week >= 6) ? 'weekends' : 'weekdays';

    //  Check if the boat is already booked
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
    $booking_conflict = ($query1->num_rows() > 0) ? $query1->row()->total : 0;

    if ($booking_conflict > 0) {
        return false; //  Boat is already booked
    }

    //  Check if the selected time is within the boat's availability
    $this->db->select('COUNT(*) as total');
    $this->db->from('boat_availability');
    $this->db->where('boat_id', $boat_id);
    $this->db->where('availability_type', $availability_type);
    $this->db->where('start_time <=', $start_time);
    $this->db->where('end_time >=', $end_time);

    $query2 = $this->db->get();
    $schedule_conflict = ($query2->num_rows() > 0) ? $query2->row()->total : 0;
   

    // echo $schedule_conflict;
    if ($schedule_conflict > 0) {
        return false; //  Boat is not available in this schedule
    }


    // Ensure 90-minute buffer after last booking
        $this->db->select('booking_end_time');
        $this->db->from('boat_bookings');
        $this->db->where('boat_id', $boat_id);
        $this->db->where('booking_date', $booking_date);
        $this->db->order_by('booking_end_time', 'DESC');
        $this->db->limit(1);

        $query3 = $this->db->get();
        $last_booking = $query3->row();
            // echo $this->db->last_query();
        if ($last_booking) {
            $last_end_time = $last_booking->booking_end_time;
            // Convert time to timestamps for proper comparison
            $last_end_timestamp = strtotime($last_end_time);
            $start_timestamp = strtotime($start_time);
            // Check if the difference is less than 90 minutes
            if (($start_timestamp - $last_end_timestamp) < (90 * 60)) {
                return false; //  Less than 90 min gap after last booking
            }
        }

        //  Minimum 2-hour booking check
        $duration = strtotime($end_time) - strtotime($start_time);
        if ($duration < 2 * 60 * 60) {
            return false; 
        }  

    return true; //  Boat is available!
}





 

 /* Create Boat Booking */

  public function create_boat_booking($data){
     $this->db->insert('boat_bookings', $data);
     $insert_id = $this->db->insert_id();
     return  $insert_id;
  }


}
