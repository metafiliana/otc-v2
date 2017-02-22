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
class Mlogact extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
    
    
    function insert_logact($program){
        return $this->db->insert('logact', $program);
    }
    
    //GET FUNCTION
    
    function get_logact(){
    	$this->db->select('logact.*'/*,initiative.title as init_tit, initiative.code as init_code, program.title as prog_tit, program.code as prog_code, program.segment as segment'*/);
    	//$this->db->join('initiative', 'initiative.id = logact.initiative_id');
    	//$this->db->join('program', 'program.id = initiative.program_id');
    	$this->db->order_by('date','desc');
    	$result = $this->db->get('logact');
    	return $result->result();
    }
    
    //UPDATE FUNCTION
    function update_initiative($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('initiative', $program);
    }
    
    function check_initiative_status(){
    	$datenow = date("Y-m-d");
    	$initiatives = $this->get_all_initiatives("",'all');
    	foreach($initiatives as $int){
    		foreach($int['wbs'] as $wb){
    			$ms['status'] = "Delay";
    			$this->db->where('workblock_id', $wb->id);
    			$this->db->where('end <', $datenow);
    			$this->db->where('status !=', 'Completed');
    			$this->db->update('milestone', $ms);
    		}
    	}
    }
    
    
    //DELETE FUNCTION
    function delete_agenda($id){
    	$this->db->where('id',$id);
    	$this->db->delete('agenda');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return true;
    	}
    }
    
    function delete_program(){
    	$id = $this->input->post('id');
    	$this->db->where('id',$id);
    	$this->db->delete('program');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    
    function delete_initiative(){
    	$id = $this->input->post('id');
    	$this->db->where('id',$id);
    	$this->db->delete('initiative');
    	if($this->db->affected_rows()>0){
    		$wbs = $this->get_all_workblock_initiative($id);
    		if($wbs){
				foreach($wbs as $wb){
					$this->delete_milestone_workblock($wb->id);
				}
    		}
    		return $this->delete_workblock_initiative($id);
    	}
    	else{
    		return false;
    	}
    }
    
    function delete_milestone_workblock($id){
    	$this->db->where('workblock_id',$id);
    	$this->db->delete('milestone');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return true;
    	}
    }
    
    function get_all_workblock_initiative($id){
    	$this->db->where('initiative_id', $id);
    	$query = $this->db->get('workblock');
        return $query->result();
    }
    
    // OTHER FUNCTION
}
