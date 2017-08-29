<?php 
/**
 * Action Transactions
 *
 * @author Afil
 */

class Taction extends CI_Model {

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

    // new master initiatives table
    function getAllInitiative($distinct = false)
    {
        if ($distinct)
            $this->db->distinct();
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
        $this->db->select('id, status');
        $this->db->where('initiative_id', $init_code);
        $query = $this->db->get('m_action')->result_array();

        foreach ($query as $key => $value) {
        	array_push($return, $value);
        }

        return $return;
    }

}

?>