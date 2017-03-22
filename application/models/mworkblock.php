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
class Mworkblock extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
    
    function insert_workblock($program){
        return $this->db->insert('workblock', $program);
    }
    
    //GET FUNCTION
    
    function get_count_workblock(){
    $this->db->select('*');
    $this->db->from('workblock');
    $query = $this->db->get();
    $res = count($query->result());
    return $res;
    }

    function get_all_initiative_workblock($initiative_id){
    	$this->db->where('initiative_id', $initiative_id);
    	$this->db->order_by('id', 'asc');
    	$query = $this->db->get('workblock');
        $res = $query->result();
        $arr = array(); $i=0;
        foreach($res as $wb){
        	$arr[$i]['wb']=$wb;
        	$arr[$i]['stat']=$this->get_workblock_status($wb->id);
        	//$arr[$i]['ms']=$this->get_all_workblock_milestone($wb->id);
        	//$arr[$i]['date'] = $this->get_milestone_minmax_date($wb->id);
        	$i++;
        }
        return $arr;
    }
    
    function get_milestone_minmax_date($id){
    	$this->db->select('MAX(end) max_end, MIN(start) min_start');
    	$this->db->where('workblock_id', $id);
    	$query = $this->db->get('milestone');
        return $query->row(0);
    }
    
    function get_all_workblock_milestone($workblock_id){
    	$this->db->where('workblock_id', $workblock_id);
    	$this->db->order_by('id', 'asc');
    	$query = $this->db->get('milestone');
        return $query->result();
    }
    
    function get_workblock_by_id($id){
    	$this->db->select('workblock.*,initiative.code as code, initiative.title as initiative, program.title as program, program.code as program_code, program.segment as segment');
        $this->db->join('initiative', 'initiative.id = workblock.initiative_id');
        $this->db->join('program', 'program.id = initiative.program_id');
        $this->db->where('workblock.id',$id);
        $result = $this->db->get('workblock');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_workblock_by_code($code){
        $this->db->where('code',$code);
        $result = $this->db->get('workblock');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_workblock_status($id){
    	$this->db->where('workblock_id', $id);
    	$this->db->order_by('status', 'asc');
    	$query = $this->db->get('milestone');
        $result = $query->result();
        $status = "";
        foreach($result as $res){
        	if($status){
        		if($res->status == "Delay"){$status = "Delay";}
        		else{
        			if($status != "Delay"){
        				if($res->status == "In Progress"){$status = "In Progress";}
        				elseif($status=="Completed" && $res->status == "Not Started Yet"){$status = "In Progress";}
        			}
        		}
        	}
        	else{$status = $res->status;}
        }
        return $status;
    }
    
    //UPDATE FUNCTION
    function update_workblock($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('workblock', $program);
    }
    
    //DELETE FUNCTION
    
    function delete_workblock(){
    	$id = $this->input->post('id');
    	$this->db->where('id',$id);
    	$this->db->delete('workblock');
    	if($this->db->affected_rows()>0){
    		return true;
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

    
    // afil
    function get_summary_all($status){
        if (empty($status)){
            $status = 'Not Started Yet';
        }

        $sql = 'SELECT b.title AS b_title, a.title AS w_title, a.status, a.`start`, a.`end` FROM workblock AS a RIGHT JOIN initiative AS b ON b.id = a.`initiative_id` WHERE a.`status` = "'.$status.'"';

        $result = $this->db->query($sql);

        if($result->num_rows>0){
            return $result->result_array();
        }else{
            return false;
        }
    }

    // function get_summary_pmo($status){
    //     if (empty($status)){
    //         $status = 'Not Started Yet';
    //     }

    //     $sql = 'SELECT b.title AS b_title, a.title AS w_title, a.status, a.`start`, a.`end` FROM workblock AS a RIGHT JOIN initiative AS b ON b.id = a.`initiative_id` WHERE a.`status` = "'.$status.'"';

    //     $result = $this->db->query($sql);

    //     if($result->num_rows>0){
    //         return $result->result_array();
    //     }else{
    //         return false;
    //     }
    // }

    function insertStatus() //untuk insert db workblock status
    {
        $sql = 'SELECT * from workblock where status = ""';

        $result = $this->db->query($sql);
        $data = $result->result_array();

        foreach ($data as $key => $value) {
            if ($value['end'] < date('Y-m-d')){
                $this->db->update('workblock', array('status'=>'Delay'), array('id'=>$value['id']));
            }else{
                $this->db->update('workblock', array('status'=>'Not Started Yet'), array('id'=>$value['id']));
            }
        }
        exit();
    }

    function getCompleteByCode($code)
    {
        $sql = 'SELECT id from workblock where status = "Completed" AND code = "'.$code.'"';

        $result = $this->db->query($sql);
        return count($result->result_array);
    }

    function getAllByCode($code)
    {
        $sql = 'SELECT * from workblock where code = "'.$code.'"';

        $result = $this->db->query($sql);
        return $result->result_array;
    }

    //role = pmo_head
    //role = dir_spon
    //role = Co-PMO
    function presentaseByRole($nama, $role = null)
    {
        if ($role == 'pmo_head'){
            $nama = $this->mprogram->get_all_pmo_head();
        }elseif($role == 'dir_spon'){
            $nama = $this->mprogram->get_all_dir_spon();
        }elseif ($role == 'Co-PMO') {
            # code...
        }

        if ($role != null){
            
            foreach ($nama as $key => $value) {
                $completed = $this->getCompleteByCode($value['init_code']);
                $jumlah_wb = count($this->getAllByCode($value['init_code']));
            }


            $hasil = ($completed / $jumlah_wb) * 100;
            return $hasil;
        }else{
            return false;
        }
    }

    function getWorkblocksByInitiativeId($id)
    {
        $this->db->select('*');
        $this->db->where('initiative_id',$id);
        $this->db->order_by('title', 'asc');
        $query = $this->db->get('workblock');

        $result = $query->result();
        return $result;
    }
    
}
