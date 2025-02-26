<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BoatController extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Boat_model');
    }
	public function boat_list()
	{  
        $data['all_boats']=$this->Boat_model->get_all_boats_with_availability();
        
        // echo "<pre>";
        // print_r($data['all_boats']);
      

        $this->load->view('inc/header_view');
		$this->load->view('boat/boat_list',$data);
        $this->load->view('inc/footer_view');
	}

    public function boat_add()
	{
        $this->load->view('inc/header_view');
		$this->load->view('boat/boat_add');
        $this->load->view('inc/footer_view');
	}


 
    public function store(){
        $this->form_validation->set_rules('boat_name', 'Boat Name', 'required|trim|min_length[3]');
        if ($this->form_validation->run() == FALSE) {
            $this->add();
        } else {
            
            $availability_data = [];
            $boat_name = $this->input->post('boat_name');
            $counter = $this->input->post('counter');
             
            if($this->Boat_model->boat_exists($boat_name)){
                $this->session->set_flashdata('error','Boat Already Exists');
                redirect('list'); 
            }

            for($i=0;$i<=$counter;$i++){
                if (isset($_POST['availability_type_' . $i])) {
                    $availability_data[] = [
                        'availability_type' => $this->input->post('availability_type_' . $i),
                        'start_time'        => $this->input->post('start_time_' . $i),
                        'end_time'          => $this->input->post('end_time_' . $i),
                    ];
                }
            }

            $result = $this->Boat_model->insert_boat_with_availability($boat_name, $availability_data);
            $message = $result ? 'Boat and Availability Added Successfully!' : 'Error: Duplicate Availability!';

            $this->session->set_flashdata($result ? 'success' : 'error', $message);
            redirect('list');
        }
    }

    public function update_status(){
       
        $boatId = $this->input->post('boat_id');
        $newStatus = $this->input->post('status');

        // Validate input
        if (!is_numeric($boatId) || !in_array($newStatus, [0, 1])) {
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
            return;
        }

        // Update status in the database
        $result = $this->Boat_model->update_boat_status($boatId, $newStatus);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed']);
        }
    }

    

    public function edit($id){
        $data['boat']= $this->Boat_model->get_boat_with_availability($id);
        if($data['boat']){
            $this->load->view('inc/header_view');
            $this->load->view('boat/boat_edit',$data);
            $this->load->view('inc/footer_view');
        }else{
            redirect('add');
        }
       
    }

    public function update_boat(){

       
        $availability_data = [];
        $boat_name = $this->input->post('boat_name');
        $boat_id = $this->input->post('boat_id');
        $counter = $this->input->post('counter');
        $availability_data = [];

        // $check_boat=$this->Boat_model->check_boat_exits($boat_id);
        // if(!empty($check_boat)){
            for($i=1;$i<=$counter;$i++){
                if (isset($_POST['availability_type_' . $i])) {
                    $availability_data[] = [
                        'availability_type' => $this->input->post('availability_type_' . $i),
                        'start_time'        => $this->input->post('start_time_' . $i),
                        'end_time'          => $this->input->post('end_time_' . $i),
                        'boat_id'          => $boat_id,
                    ];
                }
            }
    
            $result = $this->Boat_model->update_boat_with_availability($boat_name,$boat_id,$availability_data);
            if($result){
                $this->session->set_flashdata('success', 'Boat updated successfully.');
            }else{
                $this->session->set_flashdata('error', 'Failed to update boat.');
            }
        // }else{
        //     $this->session->set_flashdata('error', 'Invalid data.');
        // }
    
        redirect('list');
    }

    public function boat_delete($id){
        //Check these boat is assign in future date if yes not allowed to delete it

        $this->db->where('booking_date > ' ,'CURDATE()',FALSE);
        $this->db->where('boat_id',$id);
        $query=$this->db->get('boat_bookings');
        if($query->num_rows() > 0 ){
            $this->session->set_flashdata('error', 'Delete is not allowed , because boat is assign for future booking.');
        }else{
            if($this->Boat_model->delete_boat($id)){
                $this->session->set_flashdata('success', 'Boat deleted successfully.');
            }else{
                $this->session->set_flashdata('error', 'Failed to delete boat.');
            }
        } 
       
       redirect('list');
    }
}
