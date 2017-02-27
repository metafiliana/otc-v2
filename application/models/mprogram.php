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
class Mprogram extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('minitiative');
    }
    
    //INSERT or CREATE FUNCTION
    
    
    function insert_program($program){
        return $this->db->insert('program', $program);
    }
    
    //GET FUNCTION
    
    function get_program_by_id($id){
        $this->db->where('id',$id);
        $result = $this->db->get('program');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_program_by_code($code){
        $this->db->where('code',$code);
        $result = $this->db->get('program');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_segment_programs($segment,$init_id){
    	//$this->db->where('role', 3);
    	if($segment){
        $this->db->where('category', $segment);
        }
        if($init_id){
            foreach ($init_id as $row) {
                $this->db->or_where('init_code', $row);
            }
        }
    	$this->db->order_by('init_code', 'asc');
        $this->db->order_by('code', 'asc');
    	$query = $this->db->get('program');
    	$arr = array(); $i=0;
        $progs = $query->result();
        foreach($progs as $prog){
        	$arr[$i]['prog'] = $prog;
        	$code = explode('.',$prog->code);
        	$arr[$i]['code'] = ($code[0]*100)+$code[1];
        	$arr[$i]['date'] = $this->minitiative->get_initiative_minmax_date($prog->id);
        	
        	$arr[$i]['status'] = $this->get_program_status($prog->id);
        	$i++;
        }
        return $arr;
    }
    
    function get_all_programs_with_segment($segment){
    	$this->db->order_by('code', 'asc');
    	if($segment != 'all'){
    		$this->db->where('segment', $segment);
    	}
    	$query = $this->db->get('program');
    	return $query->result();
    }
    
    function get_program_status($program_id){
    	$allstat = return_arr_status();
    	$arr_status = array();
    	foreach($allstat as $each){$arr_status[$each]=0;}
    	$this->db->where('program_id', $program_id);
    	$this->db->select('initiative.*, program.segment');
    	$this->db->join('program','initiative.program_id = program.id');
    	$query = $this->db->get('initiative');
    	$inits = $query->result();
    	foreach($inits as $init){
    		$status = $this->minitiative->get_initiative_status_only($init);
    		if(!$status){
    			if($init->status){$status=$init->status;}
    			else{$status = "Not Started Yet";}
    		}
    		$arr_status[$status] = $arr_status[$status]+1;
    	}
    	return $arr_status;
    }
    
    //UPDATE FUNCTION
    
    function update_program($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('program', $program);
    }
    
    //DELETE FUNCTION
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
    
    // OTHER FUNCTION
}
