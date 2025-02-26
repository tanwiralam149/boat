<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boat_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //$this->load->database();
    }

    public function get_boats($data){
        $query=$this->db->get_where("boats",$data);
        return $query->result_array();
    }

    public function boat_exists($boat_name){
        $this->db->where("boat_name",$boat_name);
        return $this->db->count_all_results('boats') > 0;
    }

    public function get_all_boats_with_availability() {
        $this->db->select('boats.id AS boat_id, boats.boat_name,boats.status, boat_availability.id AS availability_id, boat_availability.availability_type, boat_availability.start_time, boat_availability.end_time');
        $this->db->from('boats');
        $this->db->join('boat_availability', 'boat_availability.boat_id = boats.id', 'left');
        $this->db->order_by('boats.id, boat_availability.availability_type'); // Order by boat and type
        $query = $this->db->get();
       // return $query->result_array();
        $boats = [];
        foreach ($query->result_array() as $row) {
            $boat_id = $row['boat_id'];

            if (!isset($boats[$boat_id])) {
                $boats[$boat_id] = [
                    'boat_id' => $row['boat_id'],
                    'boat_name' => $row['boat_name'],
                    'status' => $row['status'],
                    'availabilities' => []
                ];
            }

            if ($row['availability_id']) { // If availability exists
                $boats[$boat_id]['availabilities'][] = [
                    'availability_id' => $row['availability_id'],
                    'availability_type' => $row['availability_type'],
                    'start_time' => $row['start_time'],
                    'end_time' => $row['end_time']
                ];
            }
        }

        return array_values($boats); // Reset array index
    }


    public function insert_boat_with_availability($boat_name, $availability_data){
        $this->db->trans_start(); // Start transaction

         // Insert into boats table
         $this->db->insert('boats', ['boat_name' => $boat_name]);
         $boat_id = $this->db->insert_id(); // Get last inserted ID
 
         // Insert availability data
         foreach ($availability_data as $availability) {
             $data = [
                 'boat_id'          => $boat_id,
                 'availability_type' => $availability['availability_type'],
                 'start_time'       => $availability['start_time'],
                 'end_time'         => $availability['end_time']
             ];
             $this->db->insert('boat_availability', $data);
         }
 
         $this->db->trans_complete(); // Commit or rollback transaction
 
         return $this->db->trans_status(); // Returns true if successful, false otherwise
    }

  
    public function update_boat_status($boatId, $newStatus) {
        $this->db->where('id', $boatId);
        return $this->db->update('boats', ['status' => $newStatus]);
    }

  

    public function get_boat_with_availability($id) {
        $boat = $this->db->get_where('boats', ['id' => $id])->row_array();
        if ($boat) {
            $this->db->where('boat_id', $id);
            $boat['availabilities'] = $this->db->get('boat_availability')->result_array();
        }
        return $boat;
    }

    public function update_boat_with_availability($boat_name,$boat_id,$availability_data){
        $this->db->trans_start();
        //Boat Update Boat
        $this->db->where('id',$boat_id);
        $this->db->update('boats',['boat_name'=>$boat_name]);
        //Delete Old Availability
        $this->db->where('boat_id',$boat_id);
        $this->db->delete('boat_availability');
        //Insert New Availability
        
        foreach ($availability_data as $data) {
            $this->db->insert('boat_availability', $data);
        }
        $this->db->trans_complete(); // Complete transaction
        return $this->db->trans_status(); // Return transaction status (TRUE or FALSE)
    }

    public function check_boat_exits($boat_id){
        $this->db->where('boat_id',$boat_id);
        $query=$this->db->get("boats");
        return $query->row();
    }

    public function delete_boat($id){
        //NOTE : Before Delete any Data Must check future booking records

        $this->db->trans_start();
        //Delete All Records of Avalability First
        $this->db->where('boat_id',$id);
        $this->db->delete('boat_availability');
        //Boat Table Records Delete
        $this->db->where('id',$id);
        $this->db->delete('boats');

        $this->db->trans_complete(); // Complete transaction
        // Check if transaction was successful
        return $this->db->trans_status();
    }
}
