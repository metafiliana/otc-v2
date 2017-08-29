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
        return $this->db->insert('m_action', $program);
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

        // $sql = 'SELECT b.title AS b_title, a.title AS w_title, a.status, a.`start`, a.`end`, a.`code` FROM workblock AS a RIGHT JOIN initiative AS b ON b.id = a.`initiative_id` WHERE a.`status` = "'.$status.'" GROUP BY b_title ORDER BY code ASC';
        $sql = 'SELECT segment AS b_title, segment AS w_title, status, start, end, init_code as code FROM summary_initiative WHERE status = "'.$status.'" ORDER BY init_code ASC';

        $result = $this->db->query($sql);

        // if($result->num_rows>0){
            return $result->result_array();
        // }else{
        //     return false;
        // }
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

    function getDataChartAction()
    {
        $query = 'SELECT t.status, COUNT(t.status) as percent FROM (SELECT * FROM workblock GROUP BY title) AS t GROUP BY t.status';
        $result = $this->db->query($query)->result_array();

        return $result;
    }

    function getCountDataChartAction()
    {
        $query = 'SELECT id FROM workblock GROUP BY title';
        $result = count($this->db->query($query)->result_array());

        return $result;
    }

    function get_summary_action_all($status){
        if (empty($status)){
            $status = 'Not Started Yet';
        }

        $sql = 'SELECT a.title as b_title, a.initiative_id, a.`status`, a.`start`, a.`end`, a.`code` FROM workblock a where a.status = "'.$status.'"';

        $result = $this->db->query($sql);

        if($result->num_rows>0){
            return $result->result_array();
        }else{
            return false;
        }
    }

    function getDataChartWorkstream()
    {
        $query = 'SELECT t.title, t.status, COUNT(t.STATUS) as percent FROM (SELECT b.title, a.initiative_id, a.`status` FROM workblock a RIGHT JOIN program AS b ON b.init_code = a.`initiative_id`) AS t GROUP BY t.status';

        $result = $this->db->query($query)->result_array();

        return $result;
    }

    function getCountDataChartWorkstream()
    {
        $query = 'SELECT a.title, t.STATUS FROM workblock t RIGHT JOIN program AS a ON a.init_code = t.`initiative_id` WHERE t.status IS NOT NULL';
        $result = count($this->db->query($query)->result_array());

        return $result;
    }

    function get_summary_workstream_all($status){
        if (empty($status)){
            $status = 'Not Started Yet';
        }

        // $sql = 'SELECT a.title as b_title, b.initiative_id, b.`status`, b.`start`, b.`end`, b.`code` FROM program a RIGHT JOIN workblock AS b ON a.init_code = b.`initiative_id` where b.status = "'.$status.'" GROUP BY a.title';
        $sql = 'SELECT title AS b_title, title AS w_title, status, start, end, program_id as code, program_id as initiative_id FROM summary_workstream WHERE status = "'.$status.'" ORDER BY program_id ASC';

        $result = $this->db->query($sql);

        // if($result->num_rows>0){
            return $result->result_array();
        // }else{
            // return false;
        // }
    }

    function getDataChartDeliverable()
    {
        $query = 'SELECT t.title, t.status, COUNT(t.status) as percent FROM (SELECT DISTINCT c.title as title, b.initiative_id, b.`status` as status, b.`start`, b.`end`, b.`code` FROM initiative c RIGHT JOIN workblock AS b ON c.id = b.`initiative_id`) AS t GROUP BY t.status';
        $result = $this->db->query($query)->result_array();

        return $result;
    }

    function getCountDataChartDeliverable()
    {
        $query = 'SELECT id FROM initiative GROUP BY title';
        $result = count($this->db->query($query)->result_array());

        return $result;
    }

    function get_summary_deliverable_all($status){
        if (empty($status)){
            $status = 'Not Started Yet';
        }

        // $sql = 'SELECT DISTINCT c.title as b_title, b.initiative_id, b.`status`, b.`start`, b.`end`, b.`code` FROM initiative c RIGHT JOIN workblock AS b ON c.id = b.`initiative_id` where b.status = "'.$status.'" GROUP BY b_title';
        $sql = 'SELECT title AS b_title, title AS w_title, status, start, end, initiative_id as code, initiative_id FROM summary_deliverable WHERE status = "'.$status.'" ORDER BY initiative_id ASC';

        $result = $this->db->query($sql);

        // if($result->num_rows>0){
            return $result->result_array();
        // }else{
            // return false;
        // }
    }

    function getDeliverableStatusByInitiative($id){
        $this->db->where('initiative_id', (int)$id);
        $this->db->order_by('status', 'asc');
        $query = $this->db->get('workblock');
        $result = $query->result();
        $status = "";
        foreach($result as $res){
            $status = $res->status;

            if($res->status == "Delay"){
                $status = "Delay";
                break;
            }

            if(($res->status == "In Progress") || ($res->status == "Not Started Yet")){
                $status = "In Progress";
                break;
            }
        }

        if (empty($status))
            $status = "Not Started Yet";

        return $status;
    }

    function getStatusByCode($id){
        $this->db->where('code', $id);
        $this->db->order_by('status', 'asc');
        $query = $this->db->get('workblock');
        $result = $query->result();
        $status = "";
        foreach($result as $res){
            $status = $res->status;

            if($res->status == "Delay"){
                $status = "Delay";
                break;
            }

            if(($res->status == "In Progress") || ($res->status == "Not Started Yet")){
                $status = "In Progress";
                break;
            }
        }

        if (empty($status))
            $status = "Not Started Yet";

        return $status;
    }

    function getSummaryDeliverable()
    {
        $sql = 'SELECT * FROM initiative';

        $result = $this->db->query($sql)->result_array();

        $summary = array();

        $completed = 0;
        $delay = 0;
        $inprog = 0;
        $notstarted = 0;
        $status = '';
        for ($i = 0; $i < count($result); $i++) {
            $status = $this->getDeliverableStatusByInitiative($result[$i]['id']);
            if (strtolower($status) == 'completed'){
                $completed++;
            }

            if (strtolower($status) == 'delay'){
                $delay++;
            }

            if (strtolower($status) == 'in progress'){
                $inprog++;
            }

            if (strtolower($status) == 'not started yet'){
                $notstarted++;
            }
        }

        $summary[0]['title'] = '';
        $summary[0]['status'] = 'Completed';
        $summary[0]['percent'] = $completed;

        $summary[1]['title'] = '';
        $summary[1]['status'] = 'Delay';
        $summary[1]['percent'] = $delay;

        $summary[2]['title'] = '';
        $summary[2]['status'] = 'In Progress';
        $summary[2]['percent'] = $inprog;

        $summary[3]['title'] = '';
        $summary[3]['status'] = 'Not Started Yet';
        $summary[3]['percent'] = $notstarted;

        return $summary;

    }

    function getSummaryWorkstream()
    {
        $sql = 'SELECT * FROM program';

        $result = $this->db->query($sql)->result_array();

        $summary_workblock = array();
        $summary = array();

        $completed = 0;
        $delay = 0;
        $inprog = 0;
        $notstarted = 0;
        $status = '';
        foreach ($result as $key => $value) {
            $data_initiative = $this->minitiative->get_initiative_by_program_id($value['id']);

            if (!empty($data_initiative)){
                foreach ($data_initiative as $key1 => $value1) {
                    $status = $this->getDeliverableStatusByInitiative($value1->id);
                    array_push($summary_workblock, $status);
                }
                foreach($summary_workblock as $res){
                    $status_res = $res;

                    if($res == "Delay"){
                        $status_res = "Delay";
                        break;
                    }

                    if(($res == "In Progress") || ($res == "Not Started Yet")){
                        $status_res = "In Progress";
                        break;
                    }
                }

                if (empty($status_res))
                    $status_res = "Not Started Yet";

                if (strtolower($status_res) == 'completed'){
                    $completed++;
                }

                if (strtolower($status_res) == 'delay'){
                    $delay++;
                }

                if (strtolower($status_res) == 'in progress'){
                    $inprog++;
                }

                if (strtolower($status_res) == 'not started yet'){
                    $notstarted++;
                }
            }else{
                $notstarted++;
            }
        }

        $summary[0]['title'] = '';
        $summary[0]['status'] = 'Completed';
        $summary[0]['percent'] = $completed;

        $summary[1]['title'] = '';
        $summary[1]['status'] = 'Delay';
        $summary[1]['percent'] = $delay;

        $summary[2]['title'] = '';
        $summary[2]['status'] = 'In Progress';
        $summary[2]['percent'] = $inprog;

        $summary[3]['title'] = '';
        $summary[3]['status'] = 'Not Started Yet';
        $summary[3]['percent'] = $notstarted;

        return $summary;
    }

    function getSummaryInit()
    {
        $sql = 'SELECT * FROM program GROUP BY segment';

        $result = $this->db->query($sql)->result_array();

        $summary = array();

        $completed = 0;
        $delay = 0;
        $inprog = 0;
        $notstarted = 0;
        $status = '';
        foreach ($result as $key => $value) {
            $status = $this->getStatusByCode($value['id']);
            if (strtolower($status) == 'completed'){
                $completed++;
            }

            if (strtolower($status) == 'delay'){
                $delay++;
            }

            if (strtolower($status) == 'in progress'){
                $inprog++;
            }

            if (strtolower($status) == 'not started yet'){
                $notstarted++;
            }
        }

        $summary['inprog'] = $inprog;
        $summary['notyet'] = $notstarted;
        $summary['complete'] = $completed;
        $summary['delay'] = $delay;

        return $summary;

    }

}
