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

    function get_kuantitatif_by_user($init_id){
        $this->db->select('*');
        if($init_id){
            foreach ($init_id as $row) {
                $this->db->or_where('init_code', $row);
            }
        }
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
    
    function get_kuantitatif_with_update($init_id){
        $this->db->select('*');
        if($init_id){
            foreach ($init_id as $row) {
                $this->db->or_where('init_code', $row);
            }
        }
    	$query = $this->db->get('kuantitatif');
    	$arr = array(); $i=0;
        $progs = $query->result();
        foreach($progs as $prog){
        	$arr[$i]['prog'] = $prog;
            $arr[$i]['update'] = $this->get_kuantitatif_update($prog->id);
            $arr[$i]['percentage'] = $this->get_total_kuantitatif_by_id($prog->id);
        	$i++;
        }
        return $arr;
    }

    function get_total_kuantatif($init_id){
        $this->db->select('*');
        if($init_id){
            foreach ($init_id as $row) {
                $this->db->or_where('init_code', $row);
            }
        }
        //$this->db->where('init_code','1b');
        $query = $this->db->get('kuantitatif');
        $arr = array(); $init="";
        $progs = $query->result();
        foreach($progs as $prog){
           if(!isset($arr[$prog->init_code])){
            $arr[$prog->init_code]=0;
           }
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
            $total=(($realisasi/$res->target)*100);
        }
        else if($res->target==0)
        {
            $total=0;
        }
        else{
            $realisasi=$res->realisasi;
            $total=(($realisasi/$res->target)*100);
        }
        
        return $total;
    }

    function get_init_code_on_kuantitatif(){
        $this->db->distinct();
        $this->db->select('init_code');
        $query = $this->db->get('kuantitatif');
        $arr = array(); $i=0;
        $progs = $query->result();
        foreach($progs as $prog){
            $arr[$i]['code'] = $prog;
            $arr[$i]['count_code'] = $this->get_count_init_code($prog->init_code);
            $i++;
        }
        return $arr;
    }

    function get_count_init_code($ic){
        $this->db->select('init_code');
        $this->db->where('init_code',$ic);
        $query = $this->db->get('kuantitatif');
        return count($query->result());
    }

    function get_last_data_kuantitatif(){
        return $this->db->select('*')->order_by('id',"desc")->limit(1)->get('kuantitatif');
    }

    function get_target_year_kuantitatif(){
        $this->db->distinct();
        $this->db->select('target_year');
        $this->db->order_by('target_year','desc');
        $query = $this->db->get('kuantitatif');
        return $query->result()[0];
    }
    
    function get_all_programs_with_segment($segment){
    	$this->db->order_by('code', 'asc');
    	if($segment != 'all'){
    		$this->db->where('segment', $segment);
    	}
    	$query = $this->db->get('program');
    	return $query->result();
    }

    //UPDATE FUNCTION
    
    function update_kuantitatif($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('kuantitatif', $program);
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
    // -- afil --
    function getKuantitatifByInitCode($init_code)
    {
        $this->db->select('title, init_code');
        $this->db->where('init_code',$init_code);
        $this->db->group_by('init_code');
        $this->db->order_by('title', 'asc');
        $query = $this->db->get('kuantitatif');

        $result = $query->result();
        return $result;
    }

    function getKuantitatifDetailByInitCode($init_code)
    {
        $this->db->select('*');
        $this->db->where('init_code', $init_code);
        $this->db->order_by('init_code', 'asc');
        $query = $this->db->get('kuantitatif');

        $result = $query->result();
        return $result;
    }
}
