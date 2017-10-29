<?php 
/**
 * Action Transactions
 *
 * @author Afil
 */

class Mt_action extends CI_Model {

	public $status = array(
			0 => 'Not Started',
			1 => 'Completed',
			2 => 'On track, no issues',
			3 => 'On track, with issues',
		);

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function truncateTable()
    {
        if ($this->db->truncate('t_action')){
            return true;
        }

        return false;
    }

    // new master initiatives table
    function getAllInitiative($distinct = false)
    {
        if ($distinct)
            $this->db->distinct();
        $this->db->order_by('id', 'ASC');
        $result = $this->db->get('m_initiative');

        return $result->result();
    }

    // keperluan generate t_action
    public function getUserInit()
    {
        $this->db->select('id, initiative');
        $this->db->where_not_in('role', '2');
        $this->db->where_not_in('initiative', null);
        $query = $this->db->get('user')->result();

        $return = array();

        foreach ($query as $key => $value) {
            $return[$key]['id_user'] = $value->id;

            $init = explode(';', $value->initiative);
            $return[$key]['initiative'] = $init;
        }

        return $return;
    }

    function getInitiativeByInitCode($init_code)
    {
        $this->db->select('id');
        $this->db->where('init_code', $init_code);
        $query = $this->db->get('m_initiative')->result_array();

        return !empty($query) ? $query[0]['id'] : null;
    }

    function getActionByInitId($init_code)
    {
    	$return = array();
        $this->db->select('id, status, start_date, end_date');
        $this->db->where('initiative_id', $init_code);
        $query = $this->db->get('m_action')->result_array();

        foreach ($query as $key => $value) {
        	array_push($return, $value);
        }

        return $return;
    }

    function getStatusSummaryMilestone($initiative_id, $status = false, $month = false, $user = false)
    {
    	$where = 'initiative_id = '.$initiative_id;
        if ($status !== false){
            $where .= ' AND status = '.$status;
        }
        if ($month){
            $date = date('Y') . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-28';
    		$where .= ' AND `end` <= "'.$date.'"';
        }
        if ($user){
            $where .= ' AND user_id = '.$user;
        }
    	$sql = 'select count(id) as jumlah from t_action WHERE '.$where;
        $query = $this->db->query($sql)->row();

        return ($query->jumlah > 0) ? $query->jumlah : 0;
    }

    function getStatusFutureMilestone($initiative_id, $status = false, $month = false, $user = false)
    {
        $where = '`updated_date` < `start` AND `initiative_id` = '.$initiative_id;
        if ($status !== false){
            $where .= ' AND `status` = '.$status;
        }
        if ($month){
            $date = date('Y') . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-28';
            $where .= ' AND `end` <= "'.$date.'"';
        }
        if ($user){
            $where .= ' AND user_id = '.$user;
        }
        $sql = 'select count(id) as jumlah from t_action WHERE '.$where;
        $query = $this->db->query($sql)->row();

        return ($query->jumlah > 0) ? $query->jumlah : 0;
    }

    function getStatusFlaggedMilestone($initiative_id, $status = false, $month = false, $user = false)
    {
        // before start
        $where1 = '`updated_date` < `start` AND `updated_date` < `start` AND `initiative_id` = '.$initiative_id.' AND `status` = '.$status;

        // between start and end
        $where2 = '`updated_date` between `start` AND `end` AND `updated_date` < `start` AND `initiative_id` = '.$initiative_id.' AND `status` = '.$status;

        // after end date
        $where3 = '`updated_date` > `end` AND `updated_date` < `start` AND `initiative_id` = '.$initiative_id.' AND `status` = '.$status;

        // query month
        $where_month = '';
        $where_user = '';
        if ($month){
            $date = date('Y') . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-28';
            $where_month = ' AND `end` <= "'.$date.'"';
        }

        if ($user){
            $where_user = ' AND user_id = '.$user;
        }

        // main query
        $sql = 'select count(id) as jumlah from t_action WHERE ';

        // before start
        $query1 = $this->db->query($sql.$where1.$where_month.$where_user)->row();

        // between start and end
        $query2 = $this->db->query($sql.$where2.$where_month.$where_user)->row();

        // after end date
        $query3 = $this->db->query($sql.$where3.$where_month.$where_user)->row();

        $hasil1 = ($query1->jumlah > 0) ? $query1->jumlah : 0;
        $hasil2 = ($query2->jumlah > 0) ? $query2->jumlah : 0;
        $hasil3 = ($query3->jumlah > 0) ? $query3->jumlah : 0;

        $total = $hasil1 + $hasil2 + $hasil3;

        return ($total > 0) ? $total : 0;
    }

    function getStatusIssueMilestone($initiative_id, $month = false, $user = false, $type = null)
    {
        // $type : 
        // 1 = not started
        // 2 = overdue

        if ($type == 1){ // not started
            // between start and end date
            $where = '`updated_date` between `start` AND `end` AND `initiative_id` = '.$initiative_id.' AND `status` = 3';

            if ($month){
                $date = date('Y') . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-28';
                $where = '`updated_date` between `start` AND "'.$date.'" AND `initiative_id` = '.$initiative_id.' AND `status` = 3';
            }
        }elseif ($type == 2){ // overdue
            // after end date
            $where = '`end` <= NOW() AND `initiative_id` = '.$initiative_id.' AND `status` = 3';

            if ($month){
                $date = date('Y') . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-28';
                $where = '`end` <= "'.$date.'" AND `initiative_id` = '.$initiative_id.' AND `status` = 3';
            }
        }

        $where_user = '';
        // query user
        if ($user){
            $where_user = ' AND user_id = '.$user;
        }

        // main query
        $sql = 'select count(id) as jumlah from t_action WHERE ';

        // query execute
        $query = $this->db->query($sql.$where.$where_user)->row();

        return ($query->jumlah > 0) ? $query->jumlah : 0;
    }

    function getMilestoneDetail($initiative_id, $mtd = false, $ytd = false, $user = false)
    {
        $divider = 1;
        $hasil = 0;
        $total = 0;
        $completed = $this->getStatusSummaryMilestone($initiative_id, 1, false, $user);

        if ($completed > 0){
            // get data mtd find overdue
            if ($mtd){
                $sql = 'select count(id) as jumlah from t_action WHERE ';
                $where = '`updated_date` > `end` AND `updated_date` < `start` AND `initiative_id` = '.$initiative_id.' AND `status` IN (0, 2)';
                if ($user){
                    $where .= ' AND user_id IN '.$user;
                }
                $query = $this->db->query($sql.$where)->row();

                $overdue = ($query->jumlah > 0) ? $query->jumlah : 0;
                $divider = $completed + $overdue;
                $total = $completed / $divider;
            }

            // get data ytd find all
            if ($ytd){
                $all = $this->getStatusSummaryMilestone($initiative_id, false, false, $user);
                $total = $completed / $all;
            }

            // count percentage
            $hasil = $total * 100;
        }

        return number_format($hasil);
    }

    public function generateStatusTransaksi($status_source = false)
    {
        $return = 0;
        if ($status_source){
            if ($status_source == 'Completed'){
                $return = 1;
            }elseif ($status_source == 'On track, no issues'){
                $return = 2;
            }elseif ($status_source == 'On track, with issues'){
                $return = 3;
            }else{
                $return = 0;
            }
        }

        return $return;
    }

    public function getDataInKuantitatif($data = null)
    {
        $return_data['type_1'] = array();
        $return_data['type_2'] = array();
        $return_data['type_3'] = array();
        
        if ($data){
            $this->db->where_in('id', $data['type_1']);
            $this->db->where_not_in('initiative', null);
            $return_data['type_1'] = $this->db->get('m_initiative')->result();

            $this->db->where_in('id', $data['type_2']);
            $this->db->where_not_in('initiative', null);
            $return_data['type_2'] = $this->db->get('m_initiative')->result();

            $this->db->where_in('id', $data['type_3']);
            $this->db->where_not_in('initiative', null);
            $return_data['type_3'] = $this->db->get('m_initiative')->result();
        }


        return $return_data;
    }

}

?>