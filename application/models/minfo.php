<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of informations table
 *
 * @author Afil
 */
class Minfo extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function updateLastUpdatedSummary()
    {
    	$result = $this->db->where('id', 1)->get('t_info')->row(0);

    	$modified = (int)$result->modified;
    	$modified++;

    	$this->db->where('id', 1);
		$this->db->update('t_info', array('date' => date('Y-m-d H:i:s'), 'modified' => $modified));

		return true;
    }

    function getInfoLastUpdatedSummary()
    {
    	$result = $this->db->where('id', 1)->get('t_info')->row(0);

    	return $result;
    }
}