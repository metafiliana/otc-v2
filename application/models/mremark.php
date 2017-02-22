<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admins
 *
 * @author Maulnick
 */
class Mremark extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
    
    function insert_remark($program){
    	return $this->db->insert('remark', $program);
    }
    
    //GET FUNCTION
    
    function get_remarks_by_init_id($id){
    	$this->db->select('remark.*, user.name as user_name');
    	$this->db->join('user','remark.user_id = user.id');
    	$this->db->where('initiative_id', $id);
    	$this->db->order_by('created', 'desc');
    	$query = $this->db->get('remark');
    	return $query->result();
    }
    
    function get_remark_by_id($id){
    	$this->db->select('remark.*,initiative.code as code, initiative.title as initiative, program.title as program, program.code as program_code, program.segment as segment');
        $this->db->join('initiative', 'initiative.id = remark.initiative_id');
        $this->db->join('program', 'program.id = initiative.program_id');
        $this->db->where('remark.id',$id);
        $result = $this->db->get('remark');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    //UPDATE FUNCTION
    
    function update_remark($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('remark', $program);
    }
    
    //DELETE FUNCTION
    
    function delete_remark(){
    	$id = $this->input->post('id');
    	$this->db->where('id',$id);
    	$this->db->delete('remark');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    
    // OTHER FUNCTION
}
