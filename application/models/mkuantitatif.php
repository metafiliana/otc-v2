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
class Mkuantitatif extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('minitiative');
    }
    
    //INSERT or CREATE FUNCTION

    function get_kuantitatif(){
        $query = $this->db->get('kuantitatif');
        return $query;
    }

    function get_kuantitatif_by_user($user){
        $this->db->select('*');
        $this->db->join('user','user.initiative = kuantitatif.init_code');
        $this->db->where('user.username',$user);
        $query = $this->db->get('kuantitatif');
        return $query;
    }

    function insert_kuantitatif($program){
        if($this->db->insert('kuantitatif', $program)){
            return $this->db->insert_id();
        }else{
            return false;
        }
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
    
    function get_segment_programs($segment,$init_id,$dir_spon,$pmo_head){
    	//$this->db->where('role', 3);
    	if($segment){
        $this->db->where('category', $segment);
        }
        if($dir_spon){
        $this->db->where('dir_spon', $dir_spon);
        }
        if($pmo_head){
        $this->db->where('pmo_head', $pmo_head);
        }
        if($init_id){
            foreach ($init_id as $row) {
                $this->db->or_where('init_code', $row);
            }
        }
    	$this->db->order_by('id', 'asc');
        $this->db->select('program.*, initiative.id as init_id');
        $this->db->join('initiative','initiative.id = program.id');
        //$this->db->order_by('code', 'asc');
    	$query = $this->db->get('program');
    	$arr = array(); $i=0;
        $progs = $query->result();
        foreach($progs as $prog){
        	$arr[$i]['prog'] = $prog;
        	$code = explode('.',$prog->code);
            $init_id=$prog->init_id;
        	$arr[$i]['code'] = ($code[0]*100)+$code[1];
        	$arr[$i]['date'] = $this->minitiative->get_initiative_minmax_date($prog->id);
        	$arr[$i]['lu'] = $this->minitiative->get_initiative_last_update($prog->id);
            $arr[$i]['init'] = $this->minitiative->get_initiative_by_id($init_id);
            $arr[$i]['init_status'] = $this->minitiative->get_status_only_by_prog_id($arr[$i]['init'],$prog->id);
            //$arr[$i]['wb_status'] = $this->minitiative->get_init_workblocks_status($init_id);
            $arr[$i]['wb_status'] = $this->minitiative->get_init_workblocks_status_new($prog->id);
            //$arr[$i]['wb_total'] = count($this->minitiative->get_wb_total($init_id));

        	$arr[$i]['status'] = $this->get_program_status($prog->id);
            $arr[$i]['wb_total']= $this->get_total_wb_by_program($prog->id);
            $arr[$i]['sub_init_total'] = count($this->minitiative->get_all_program_initiatives($prog->id));
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
    
    function get_total_wb_by_program($program_id){
        $this->db->where('program_id', $program_id);
        $this->db->select('initiative.*, program.segment');
        $this->db->join('program','initiative.program_id = program.id');
        $query = $this->db->get('initiative');
        $inits = $query->result();
        $status=""; $total="";
        foreach($inits as $init){
            $status = $this->minitiative->get_total_wb_by_init($init);
            $total += $status;
        }
        return $total;
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
