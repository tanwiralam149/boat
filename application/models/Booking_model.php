<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // public function get_all_boat_booking_detail(){
    //     $this->db->select('
    //     bb.id AS booking_id,
    //     b.boat_name,
    //     ba.availability_type,
    //     bb.customer_name,
    //     bb.customer_phone,
    //     bb.customer_email,
    //     bb.booking_date,
    //     ba.booking_start_time,
    //     ba.booking_end_time,
    //     bb.bookig_status
    // ');
    // $this->db->from('boat_bookings bb');
    // $this->db->join('boats b', 'bb.boat_id = b.id');
    // $this->db->join('boat_availability ba', 'bb.availability_id = ba.id');
    // $this->db->order_by('bb.booking_date', 'DESC');

    // return $this->db->get()->result_array(); // Returns array of booking data
    // }

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
}
