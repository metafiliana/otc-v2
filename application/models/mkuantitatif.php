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

    function insert_kuantitatif_update($program){
        if($this->db->insert('kuantitatif_update', $program)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    
    
    //GET FUNCTION
    
    function get_kuantitatif_by_id($id){
        $this->db->where('id',$id);
        $result = $this->db->get('kuantitatif');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function get_kuantitatif_update($id){
        $this->db->where('id_kuan',$id);
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('kuantitatif_update');
        if($result){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_kuantitatif_with_update(){
        $this->db->select('*');
    	$query = $this->db->get('kuantitatif');
    	$arr = array(); $i=0;
        $progs = $query->result();
        foreach($progs as $prog){
        	$arr[$i]['prog'] = $prog;
            $arr[$i]['update'] = $this->get_kuantitatif_update($prog->id);
        	$i++;
        }
        return $arr;
    }

    function get_total_kuantatif(){
        $this->db->select('*');
        $query = $this->db->get('kuantitatif');
        $arr = array(); //$init=""; $total=0; $realisasi=0; $j=0; $total_all=0; $i=0;
        $progs = $query->result();
        foreach($progs as $prog){
           $arr[$prog->init_code] += $this->get_total_kuantitatif_by_id($prog->id);
        }
        return $arr;
    }

    function get_total_kuantitatif_by_id($id){
        $total=0;$realisasi=0;
        $this->db->select('*');
        $this->db->where('id',$id);
        $query = $this->db->get('kuantitatif');
        $res = $query->row();
        if($this->get_kuantitatif_update($id))
        {
            $realisasi=$this->get_kuantitatif_update($id)->amount;
        }
        else{
            $realisasi=$res->realisasi;
        }
        $total=(($realisasi/$res->target)*100);
        return $total;
    }

    function get_last_data_kuantitatif(){
        return $this->db->select('*')->order_by('id',"desc")->limit(1)->get('kuantitatif');
    }

    function get_init_code_kuantitatif(){
        $this->db->distinct();
        $this->db->select('init_code');
        $query = $this->db->get('kuantitatif');
        return $query->result();
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
