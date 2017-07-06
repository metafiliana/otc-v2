<?php

/**
 * @author Afil
 */
class Msummary extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

/*
 * Insert or generate summary data
 * Start
 */
    function insertDeliverable()
    {
    	//clean data
    	$this->db->empty_table('summary_deliverable');

        $sql = 'SELECT `initiative`.`id` as "initiative_id",`initiative`.`program_id` ,`initiative`.`title`,`initiative`.`start`,`initiative`.`end`,`workblock`.`status` FROM `initiative` JOIN `workblock` ON `initiative`.`id` = `workblock`.`initiative_id` group by initiative_id';


        $result = $this->db->query($sql)->result_array();
        $data = array();

        foreach ($result as $key => $value) {
            $status = $this->mworkblock->getDeliverableStatusByInitiative($value['initiative_id']);
            $value['status'] = $status;

            $this->db->insert('summary_deliverable', $value);
        }
    }

    function insertWorkstream()
    {
    	//clean data
    	$this->db->empty_table('summary_workstream');

        $sql = 'SELECT t.program_id, p.title, t.start, t.end, status FROM `summary_deliverable` t JOIN `program` p ON p.`id` = t.`program_id` group by program_id';


        $result = $this->db->query($sql)->result_array();
        $summary_workblock = array();

        foreach ($result as $key => $value) {
            $data_initiative = $this->minitiative->get_initiative_by_program_id($value['program_id']);

            if (!empty($data_initiative)){
                foreach ($data_initiative as $key1 => $value1) {
                    $status = $this->mworkblock->getDeliverableStatusByInitiative($value1->id);
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
                    $status = "Not Started Yet";

                $value['status'] = $status;
            }
            $this->db->insert('summary_workstream', $value);
        }
    }

    function insertInitiative()
    {
    	//clean data
    	$this->db->empty_table('summary_initiative');
    	
        $sql = 'SELECT t.program_id, p.segment, t.start, t.end, status, p.init_code FROM `summary_deliverable` t JOIN `program` p ON p.`id` = t.`program_id` group by p.segment';


        $result = $this->db->query($sql)->result_array();
        $data = array();

        foreach ($result as $key => $value) {
            $status = $this->mworkblock->getStatusByCode($value['init_code']);
            $value['status'] = $status;

            $this->db->insert('summary_initiative', $value);
        }
    }

/*
 * Insert or generate summary data
 * End
 */


/*
 * Get summary data
 * Start
 */
    public function getAllDeliverable()
    {
    	$sql = 'SELECT * FROM summary_deliverable';
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    public function getAllWorkstream()
    {
    	$sql = 'SELECT * FROM summary_workstream';
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    public function getAllInitiative()
    {
    	$sql = 'SELECT * FROM summary_initiative';
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

/*
 * Get summary data
 * End
 */


/*
 * Utility function
 * Start
 */
    function getSummaryDeliverable()
    {
        $sql = 'SELECT * FROM summary_deliverable';

        $result = $this->db->query($sql)->result_array();

        $summary = array();

        $completed = 0;
        $delay = 0;
        $inprog = 0;
        $notstarted = 0;
        $status = '';

        foreach ($result as $key => $value) {
        	if (strtolower($value['status']) == 'completed'){
                $completed++;
            }

            if (strtolower($value['status']) == 'delay'){
                $delay++;
            }

            if (strtolower($value['status']) == 'in progress'){
                $inprog++;
            }

            if (strtolower($value['status']) == 'not started yet'){
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
        $sql = 'SELECT * FROM summary_workstream';

        $result = $this->db->query($sql)->result_array();

        $summary = array();

        $completed = 0;
        $delay = 0;
        $inprog = 0;
        $notstarted = 0;
        $status = '';

        foreach ($result as $key => $value) {
        	if (strtolower($value['status']) == 'completed'){
                $completed++;
            }

            if (strtolower($value['status']) == 'delay'){
                $delay++;
            }

            if (strtolower($value['status']) == 'in progress'){
                $inprog++;
            }

            if (strtolower($value['status']) == 'not started yet'){
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

    function getSummaryInitiative()
    {
        $sql = 'SELECT * FROM summary_initiative';

        $result = $this->db->query($sql)->result_array();

        $summary = array();

        $completed = 0;
        $delay = 0;
        $inprog = 0;
        $notstarted = 0;
        $status = '';

        foreach ($result as $key => $value) {
        	if (strtolower($value['status']) == 'completed'){
                $completed++;
            }

            if (strtolower($value['status']) == 'delay'){
                $delay++;
            }

            if (strtolower($value['status']) == 'in progress'){
                $inprog++;
            }

            if (strtolower($value['status']) == 'not started yet'){
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