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
class Magenda extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //INSERT or CREATE FUNCTION

    function insert_agenda($program){
        if($this->db->insert('agenda', $program)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function update_agenda($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('agenda', $program);
    }

    //GET FUNCTION

    function get_all_agenda_month($month, $year){
    	$sumdate = date("t", mktime(0,0,0, $month, 1, $year));
    	$arragenda = array();
    	for($i=1;$i<=$sumdate;$i++){
    		$datetoget = $year."-".$month."-".$i;
    		$arragenda[$i] = $this->get_agenda_by_date($datetoget);
    	}
    	return $arragenda;
    }

    function get_agenda_by_date($date){
    	$this->db->select('*');
    	$this->db->where('DATE(start)',$date);
    	$result = $this->db->get('agenda');
    	return $result->result();
    }

    function get_agenda_by_id($id){
    	$this->db->select('*');
    	$this->db->where('id',$id);
    	$result = $this->db->get('agenda');
    	return $result->row(0);
    }

    function get_last_agenda($limit){
        $this->db->select('*');
        $this->db->order_by('id','desc');
        if($limit){
            $this->db->limit($limit);
        }
        $this->db->where('start >=',date('Y-m-d'));
        $result = $this->db->get('agenda');
        return $result->result();
    }

    function get_all_programs(){
    	//$this->db->where('role', 3);
    	$this->db->order_by('code', 'asc');
    	$query = $this->db->get('program');
    	$arr = array(); $i=0;
        $progs = $query->result();
        foreach($progs as $prog){
        	$arr[$i]['prog'] = $prog;
        	$code = explode('.',$prog->code);
        	$arr[$i]['code'] = ($code[0]*100)+$code[1];
        	$arr[$i]['date'] = $this->get_initiative_minmax_date($prog->id);

        	$initiatives = $this->get_all_program_initiatives($prog->id);
        	$status = "";
        	foreach($initiatives as $int){
        		$res_status = $this->get_initiative_status($int->id)['status'];
        		if($status){
					if($res_status == "Delay"){$status = "Delay";}
					else{
						if($status != "Delay"){
							if($res_status == "In Progress"){$status = "In Progress";}
							elseif($status=="Completed" && $res_status == "Not Started Yet"){$status = "In Progress";}
							elseif($res_status=="Completed" && $status == "Not Started Yet"){$status = "In Progress";}
						}
					}
				}
				else{$status = $res_status;}
        	}
        	$arr[$i]['status'] = $status;
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

    function get_all_initiatives($user_initiative, $segment){
    	//$this->db->where('role', 3);
    	$this->db->select('initiative.*, program.title as program, program.code as progcode');
    	$this->db->join('program', 'program.id = initiative.program_id');
    	$this->db->order_by('initiative.code', 'asc');
    	if($user_initiative){
    		$this->db->where_in('initiative.code', $user_initiative);
    	}
    	if($segment != 'all'){
    		$this->db->where('program.segment', $segment);
    	}
    	$query = $this->db->get('initiative');
        $res = $query->result();
        $arr = array(); $i=0;
        foreach($res as $int){
        	$arr[$i]['int']=$int;
        	$code = explode('.',$int->code);
        	$arr[$i]['code'] = ($code[0]*10000)+$code[1]*100+(ord($code[2])-96);
        	$arr[$i]['stat']=$this->get_initiative_status($int->id)['status'];
        	$arr[$i]['wb']=$this->get_initiative_status($int->id)['sumwb'];
        	$arr[$i]['wbs']=$this->get_initiative_status($int->id)['wb'];
        	$arr[$i]['pic']=$this->get_initiative_pic($int->code);
        	$i++;
        }
        return $arr;
    }

    function get_all_just_initiatives(){
    	//$this->db->where('role', 3);
    	$this->db->select('initiative.*, program.title as program');
    	$this->db->join('program', 'program.id = initiative.program_id');
    	$this->db->order_by('initiative.code', 'asc');
    	$query = $this->db->get('initiative');
        $res = $query->result();
        return $res;
    }

    function get_all_program_initiatives($id){
    	$this->db->where('program_id', $id);
    	$this->db->select('initiative.*');
    	$query = $this->db->get('initiative');
        $res = $query->result();
        return $res;
    }

    function get_initiative_by_id($id){
    	$this->db->select('initiative.*, program.title as program, program.code as program_code, program.segment as segment');
        $this->db->join('program', 'program.id = initiative.program_id');
        $this->db->where('initiative.id',$id);
        $result = $this->db->get('initiative');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function get_initiative_status($id){
    	$this->db->where('initiative_id', $id);
    	//$this->db->order_by('status', 'asc');
    	$query = $this->db->get('workblock');
        $result = $query->result();
        $status = ""; $arr = array();
        foreach($result as $res){
        	$res_status = $this->get_workblock_status($res->id);
        	if($status){
        		if($res_status == "Delay"){$status = "Delay";}
        		else{
        			if($status != "Delay"){
        				if($res_status == "In Progress"){$status = "In Progress";}
        				elseif($status=="Completed" && $res_status == "Not Started Yet"){$status = "In Progress";}
        				elseif($res_status=="Completed" && $status == "Not Started Yet"){$status = "In Progress";}
        			}
        		}
        	}
        	else{$status = $res_status;}
        }
        $arr['status']=$status;
        $arr['sumwb']=count($result);
        $arr['wb']=$result;
        return $arr;
    }

    function get_initiative_pic($code){
    	$this->db->like('initiative',$code);
    	$this->db->order_by('jabatan', 'desc');
    	$query = $this->db->get('user');
        return $query->result();
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

    function get_initiative_minmax_date($id){
    	$this->db->select('MAX(end) max_end, MIN(start) min_start');
    	$this->db->where('program_id', $id);
    	$query = $this->db->get('initiative');
        return $query->row(0);
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
