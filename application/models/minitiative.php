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
class Minitiative extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
    
    
    function insert_program($program){
        return $this->db->insert('program', $program);
    }
    
    function insert_initiative($program){
        return $this->db->insert('initiative', $program);
    }
    
    function insert_remark($program){
    	return $this->db->insert('remark', $program);
    }
    
    //GET FUNCTION

    function get_initiatives($distinct = false)
    {
        if ($distinct)
            $this->db->distinct();
        $result = $this->db->get('initiative');

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
        		$res_status = $this->get_initiative_status($int->id,$int->end)['status'];
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
        	//if(count($code)>3){$code3 = $code[3];}else{$code3 = 0;}
        	//$arr[$i]['code'] = ($code[0]*1000000)+$code[1]*10000/*+(ord($code[2])-96)*100*/;
        	
        	$status_initiative_all = $this->get_initiative_status($int->id,$int->end);
        	$arr[$i]['stat']=$status_initiative_all['status'];
        	if(!$arr[$i]['stat']){$arr[$i]['stat'] = $int->status;}
        	$arr[$i]['wb']=$status_initiative_all['sumwb'];
        	$arr[$i]['wbs']=$status_initiative_all['wb'];
        	
        	$arr[$i]['pic']=$this->get_initiative_pic($int->code);
        	$arr[$i]['child']=$this->get_initiative_child($int->code);
        	$i++;
        }
        return $arr;
    }
    
    
    function get_program_initiatives($user_initiative, $program_id){
    	$this->db->select('initiative.*, program.title as program, program.code as progcode');
    	$this->db->join('program', 'program.id = initiative.program_id');
    	$this->db->order_by('initiative.code', 'asc');
    	/*if($user_initiative){
    		$this->db->where_in('initiative.code', $user_initiative);
    	}*/
    	$this->db->where('program_id',$program_id);
    	$query = $this->db->get('initiative');
        $res = $query->result();
        $arr = array(); $i=0;
        foreach($res as $int){
        	$arr[$i]['int']=$int;
        	/*$code = explode('.',$int->code);
        	if(count($code)>3){$code3 = $code[3];}else{$code3 = 0;}
        	$arr[$i]['code'] = ($code[0]*1000000)+$code[1]*10000+(ord($code[2])-96)*100+$code3;
        	*/
        	$status_initiative_all = $this->get_initiative_status($int->id,$int->end);
        	$arr[$i]['stat']=$status_initiative_all['status'];
        	if(!$arr[$i]['stat']){$arr[$i]['stat'] = $int->status;}
        	$arr[$i]['wb']=$status_initiative_all['sumwb'];
        	$arr[$i]['wbs']=$status_initiative_all['wb'];
            $arr[$i]['wb_status'] = $this->get_init_workblocks_status($int->id);
            $arr[$i]['wb_total'] = count($this->get_wb_total($int->id));
        	
        	$arr[$i]['pic']=$this->get_initiative_pic($int->code);
        	$arr[$i]['child']=$this->get_initiative_child($int->code);
        	$i++;
        }
        return $arr;
    }
    
    function get_init_workblocks_status($init_id = null){
    	$arr = array();
    	
    	$arr['inprog'] = count($this->get_wb_status_sum('In Progress', $init_id));
    	$arr['notyet'] = count($this->get_wb_status_sum('Not Started Yet', $init_id));
    	$arr['complete'] = count($this->get_wb_status_sum('Completed', $init_id));
    	$arr['delay'] = count($this->get_wb_status_sum('Delay', $init_id));
    	
    	return $arr;
    }

    function get_wb_status_sum($status, $init){
        $this->db->where('status', $status);
        if ($init != null){
            $this->db->where('initiative_id', $init);
        }
        $query = $this->db->get('workblock');
        $res = $query->result();
        return $res;
    }

    function get_init_workblocks_status_new($init_id){
        $arr = array();
        
        $arr['inprog'] = count($this->get_wb_status_sum_new('In Progress', $init_id));
        $arr['notyet'] = count($this->get_wb_status_sum_new('Not Started Yet', $init_id));
        $arr['complete'] = count($this->get_wb_status_sum_new('Completed', $init_id));
        $arr['delay'] = count($this->get_wb_status_sum_new('Delay', $init_id));
        
        return $arr;
    }
    
    function get_wb_status_sum_new($status, $program_id){
    	$this->db->select('workblock.status as wbstat');
        $this->db->where('workblock.status', $status);
    	$this->db->where('program_id', $program_id);
        $this->db->join('workblock', 'workblock.initiative_id = initiative.id');
    	$query = $this->db->get('initiative');
        $res = $query->result();
        return $res;
    }

    function get_init_workblocks_status_init_code($init_id){
        $arr = array();
        
        $arr['inprog'] = count($this->get_wb_status_sum_init_code('In Progress', $init_id));
        $arr['notyet'] = count($this->get_wb_status_sum_init_code('Not Started Yet', $init_id));
        $arr['complete'] = count($this->get_wb_status_sum_init_code('Completed', $init_id));
        $arr['delay'] = count($this->get_wb_status_sum_init_code('Delay', $init_id));
        
        return $arr;
    }
    
    function get_wb_status_sum_init_code($status, $program_id){
        $this->db->select('workblock.status as wbstat');
        $this->db->where('workblock.status', $status);
        $this->db->where('code', $program_id);
        //$this->db->join('workblock', 'workblock.initiative_id = initiative.id');
        $query = $this->db->get('workblock');
        $res = $query->result();
        return $res;
    }

    function get_wb_total($init){
        $this->db->where('initiative_id', $init);
        $query = $this->db->get('workblock');
        $res = $query->result();
        return $res;
    }
    
    function get_initiative_child($code){
    	$this->db->where('parent_code', $code);
    	$query = $this->db->get('initiative');
        $res = $query->result();
        return $res;
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
	$this->db->select('initiative.*, program.title as program, program.code as program_code, program.segment as segment, program.*, initiative.title as init_title');
        $this->db->join('program', 'program.id = initiative.program_id');
        $this->db->where('initiative.id',$id);
        $result = $this->db->get('initiative');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_initiative_by_code($code){
    	$this->db->select('initiative.*, program.title as program, program.code as program_code, program.segment as segment');
        $this->db->join('program', 'program.id = initiative.program_id');
        $this->db->where('initiative.code',$code);
        $result = $this->db->get('initiative');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function get_initiative_by_program_id($id){
        $this->db->select('*');
        $this->db->where('program_id',$id);
        $result = $this->db->get('initiative');
        $res = $result->result();
        
        return $res;
    }
    
    /*function get_initiative_status($id){
    	$this->db->where('initiative_id', $id);
    	//$this->db->order_by('status', 'asc');
    	$query = $this->db->get('workblock');
        $result = $query->result();
        $status = ""; $arr = array();
        if($result){
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
        }
        $arr['status']=$status;
        $arr['sumwb']=count($result);
        $arr['wb']=$result;
        return $arr;
    }*/
    
    function get_initiative_status_only($init){
        $status =  $this->get_initiative_status($init->id,$init->end)['status'];
        if(!$status){$status = $init->status;}
        return $status;
    }

    function get_initiative_status_only_by_id($id){
        $status =  $this->get_initiative_status($id,'')['status'];
        if(!$status){$status = $init->status;}
        return $status;
    }

    function get_initiative_status($id,$end){
    	$this->db->where('initiative_id', $id);
    	$this->db->order_by('status', 'asc');
    	$query = $this->db->get('workblock');
        $result = $query->result();
        $status = ""; $arr = array();
        if($result){
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
        	if($status == "Delay"){if($end>date("Y-m-d")){$status="At Risk";}}
        }
        $arr['status']=$status;
        $arr['sumwb']=count($result);
        $arr['wb']=$result;
        return $arr;
        
    }

    function get_initiative_status_by_init_code($id,$end){
        $this->db->where('code', $id);
        $this->db->order_by('status', 'asc');
        $query = $this->db->get('workblock');
        $result = $query->result();
        $status = ""; $arr = array();
        if($result){
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
            if($status == "Delay"){if($end>date("Y-m-d")){$status="At Risk";}}
        }
        $arr['status']=$status;
        $arr['sumwb']=count($result);
        $arr['wb']=$result;
        return $arr;
        
    }

    function get_status_only_by_prog_id($init,$id){
        $status =  $this->get_initiative_status_by_prog_id($id,$init->end)['status'];
        if(!$status){$status = $init->status;}
        return $status;
    }

    function get_initiative_status_by_prog_id($id,$end){
        $this->db->select('workblock.*');
        $this->db->where('program_id', $id);
        $this->db->join('workblock', 'workblock.initiative_id = initiative.id');
        $this->db->order_by('workblock.status', 'asc');
        $query = $this->db->get('initiative');
        $result = $query->result();
        $status = ""; $arr = array();
        if($result){
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
            if($status == "Delay"){if($end>date("Y-m-d")){$status="At Risk";}}
        }
        $arr['status']=$status;
        $arr['sumwb']=count($result);
        $arr['wb']=$result;
        return $arr;
        
    }

    function get_total_wb_by_init($init){
        $sumwb =  $this->get_initiative_status($init->id,$init->end)['sumwb'];
        return $sumwb;
    }

    function get_total_wb_by_init_code($init){
        $sumwb =  $this->get_initiative_status_by_init_code($init->code,'')['sumwb'];
        return $sumwb;
    }
    
    function get_info_initiative_by_id($id){
    	$arr = array();
    	$arr['init'] = $this->get_initiative_by_id($id);
    	$arr['ko'] = $this->get_initiative_depen($arr['init']->kickoff);
    	$arr['cp'] = $this->get_initiative_depen($arr['init']->completion);
    	return $arr;
    }
    
    function get_initiative_depen($depens){
    	$depen = explode(',',$depens);
    	$this->db->where_in('code',$depen);
    	$query = $this->db->get('initiative');
        $result = $query->result();
        $arr = array(); $i=0;
        
        foreach($result as $res){
        	$arr[$i]['init'] = $res;
        	$arr[$i]['stat'] = $this->get_initiative_status_only($res);
        	$i++;
        }
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

    function get_initiative_last_update($id){
        $this->db->select('*');
        $this->db->where('program_id', $id);
        $query = $this->db->get('initiative');
        return $query->row(0);
    }
    
    function get_all($segment){
    	$this->db->select('program.title as program, initiative.title as initiative, workblock.title as workblock, milestone.title as milestone');
    	$this->db->where('segment', $segment);
    	$this->db->join('initiative', 'program.id = initiative.program_id');
    	$this->db->join('workblock', 'initiative.id = workblock.initiative_id');
    	$this->db->join('milestone', 'workblock.id = milestone.workblock_id');
    	$this->db->order_by('program.code', 'asc');
    	$this->db->order_by('initiative.code', 'asc');
    	$this->db->order_by('workblock.id', 'asc');
    	$this->db->order_by('milestone.id', 'asc');
    	$query = $this->db->get('program');
        return $query->result();
    }
    
    function get_remarks_by_init_id($id){
    	$this->db->select('remark.*, user.name as user_name');
    	$this->db->join('user','remark.user_id = user.id');
    	$this->db->where('initiative_id', $id);
    	$this->db->order_by('created', 'desc');
    	$query = $this->db->get('remark');
    	return $query->result();
    }
    
    function get_all_segments_status(){
    	$arr = array();
    	$status = return_arr_status();
    	$segments = return_all_segments();
    	
    	foreach($segments as $segment){
    		$arr[$segment]['name'] = $segment;
    		$arr[$segment]['stat'] = $this->get_segment_status($status,$segment);
    	}
    	return $arr;
    }
    
    function get_one_segment_status($segment){
    	$status = return_arr_status();
    	$arr = $this->get_segment_status($status,$segment);

    	return $arr;
    }
    
    function get_segment_status($allstat, $segment){
    	$arr_status = array();
    	foreach($allstat as $each){$arr_status[$each]=0;}
    	$this->db->select('initiative.*, program.segment');
    	$this->db->join('program','initiative.program_id = program.id');
    	$this->db->where('segment',$segment);
    	$query = $this->db->get('initiative');
    	$inits = $query->result();
    	foreach($inits as $init){
    		$status = $this->get_initiative_status_only($init);
    		if(!$status){
    			if($init->status){$status=$init->status;}
    			else{$status = "Not Started Yet";}
    		}
    		$arr_status[$status] = $arr_status[$status]+1;
    	}
    	return $arr_status;
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
    			$this->db->where('workblock_id', $wb->id);
    			$this->db->where('end <', $datenow);
    			$this->db->where('status !=', 'Completed');
    			$this->db->where('status !=', 'Delay');
    			$mss = $this->db->get('milestone');
    			$mss = $mss->result();
    			foreach($mss as $ms){
    				$ms_upd['status'] = "Delay";
    				$ms_upd['last_status'] = $ms->status;
    				
    				$this->db->where('id',$ms->id);
    				$this->db->update('milestone', $ms_upd);	
    			}
    		}
    	}
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
    
    function delete_workblock_initiative($id){
    	$this->db->where('initiative_id',$id);
    	$this->db->delete('workblock');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return true;
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

    //afil
    function getInitiativeByProgramId($id)
    {
        $this->db->select('t.*, (select count(a.id) from workblock a where a.initiative_id = t.id) as total_w, (select count(a.id) from workblock a where a.status = "Completed" AND a.initiative_id = t.id) as total_c');
        $this->db->where('program_id',$id);
        $this->db->order_by('title', 'asc');
        $query = $this->db->get('initiative t');

        $result = $query->result();
        return $result;
    }

    function getDataChartDeliverable()
    {
        $query = 'SELECT title, STATUS FROM initiative GROUP BY title';
        $result = $this->db->query($query)->result_array();

        return $result;
    }

    function getAllInitiative(){
        $sql = 'SELECT a.init_code as nama, a.init_code, (((select count(b.id) from workblock b where b.status = "Completed" AND b.code = a.init_code)) / ((select count(c.id) from workblock c where c.code = a.init_code))) as persenan from program a ORDER BY init_code';

        $result = $this->db->query($sql);

        $item = $result->result_array();
        // var_dump($item);die;
        $data = array();
        $nama = '';
        $completed = 0.0;
        $total_completed = 0.0;
        $length = count($result->result_array());

        $j = 0; // counter array $data
        $k = 0; // counter completed
        for ($i=0; $i < $length; $i++) { 
            if ($i == 0){
                $nama = $item[$i]['nama'];
                $ci = $item[$i]['init_code'];
                $k = 0; 
            }else{
                if ($item[$i]['nama'] != "$nama"){
                        if ($item[$i]['init_code'] != $ci){
                            $k++;
                            $ci = $item[$i]['init_code'];
                        }
                    $data[$j]['nama'] = $nama;
                    $k = ($k != 0) ? $k : 1;
                    $data[$j]['total_initiative'] = $k;
                    $total_completed = $completed / $k;
                    // $data[$j]['total_completed'] = round($total_completed, 2);
                    $data[$j]['total_completed'] = 0;
                    $j++;
                    $nama = $item[$i]['nama'];

                    $k = 0;
                }else{
                    $completed = $completed + $item[$i]['persenan'];
                    if ($item[$i]['init_code'] != $ci){
                        $k++;
                        $ci = $item[$i]['init_code'];
                    }
                }
            }
        }

        $role = 'dir_spon';
        foreach ($data as $key => $value) {
            if ($value['nama'] != null){
                $sql1 = 'select t.id, t.title, t.code, t.init_code, t.segment, (SELECT COUNT(a.STATUS) FROM workblock a WHERE a.STATUS = "Completed" AND a.code = t.`init_code`) AS status_c, (SELECT COUNT(b.STATUS) FROM workblock b WHERE b.STATUS = "In Progress" AND b.code = t.`init_code`) AS status_i, (SELECT COUNT(c.STATUS) FROM workblock c WHERE c.STATUS = "Delay" AND c.code = t.`init_code`) AS status_d, (SELECT COUNT(d.STATUS) FROM workblock d WHERE d.STATUS = "Not Started Yet" AND d.code = t.`init_code`) AS status_n, (SELECT COUNT(STATUS) FROM workblock z WHERE z.code = t.`init_code`) total_init from program t where t.init_code = "'.$value['nama'].'" group by t.init_code';
                $result1 = $this->db->query($sql1)->result_array();

                // $total_completed = 0;
                $total_initiative = 0;
                $percent_parsial = 0;
                if (!empty($result1)){       
                    foreach ($result1 as $key1 => $value1) {
                        // $total_completed = $total_completed + $value1['status_c'];
                        $total_initiative++;
                        if ($value1['total_init'] != 0)
                            $percent_parsial = $percent_parsial + ($value1['status_c']/ $value1['total_init']) * 100;
                    }
                    if ($total_initiative != 0){
                        $percent_raw = (float)($percent_parsial/ $total_initiative);
                        $percent = round((float)$percent_raw, 2);
                        // $value['total_completed'] = $percent;
                        $data[$key]['total_completed'] = $percent;
                    }else{
                        $data[$key]['total_completed'] = 0;
                    }
                        //keperluan penghitungan kuantitatif
                    $arr_initcode= explode(";",$data[$key]['nama']);
                    $hitung_kuantitatif = 0;
                    $hitung_kuantitatif = $this->mkuantitatif->get_total_kuantatif($arr_initcode);
                    
                    $data[$key]['total_kuantitatif'] = 0;
                    if (!empty($hitung_kuantitatif)){
                        $counter = 0;
                        $jumlah_kuantitatif = 0;
                        foreach ($hitung_kuantitatif as $key2 => $value2) {
                            $jumlah_kuantitatif = $this->mkuantitatif->get_count_init_code($key2);
                            $hitung_total_kuantitatif[$counter] = $value2 / $jumlah_kuantitatif;

                            $counter = $counter +1;
                        }

                        $total_kuantitatif = array_sum($hitung_total_kuantitatif);
                        $jumlah_total_kuantitatif = $total_kuantitatif / count($hitung_total_kuantitatif);

                        $kuantitatif_percent = round((float)$jumlah_total_kuantitatif, 2);
                        $data[$key]['total_kuantitatif'] = $kuantitatif_percent;
                    }
                }
            }
        }
        
        // delete null data
        array_splice($data, array_search('null', $data), 1);

        foreach ($data as $key => $row) {
            // replace 0 with the field's index/key for sorting compare
            $arsort[$key]  = $row['total_completed'];
        }

        array_multisort($arsort, SORT_DESC, $data);

        return $data;
    }
}
