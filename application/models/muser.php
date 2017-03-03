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
class Muser extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //INSERT or CREATE FUNCTION
    
    function verify_username($username){
        $this->db->where('username',$username);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return true;
        }else{
            return false;
        }
    }

    function verify($username, $password){
        $this->db->where('username',$username);
        $this->db->where('password',$password);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return true;
        }else{
            return false;
        }
    }
    
    function insert_profil($profil){
        return $this->db->insert('profil', $profil);
    }
    
    function insert_user($user){
        return $this->db->insert('user', $user);
    }
    
    function insert_payment($payment){
        return $this->db->insert('payment', $payment);
    }
    
    function insert_shipping($shipping){
        return $this->db->insert('shipping', $shipping);
    }
    
    function register($user){
    	return $this->db->insert('user', $user);
    }
    
    function insert_get_new_address($profil){
    	if($this->insert_profil($profil)){
    		return $this->get_address_by_id($this->get_last_profil_id());
    	}
    }
    
    function insert_photo_slider($photo_slider){
        return $this->db->insert('photo_slider', $photo_slider);
    }
    
    //GET FUNCTION
    
    function get_all_user(){
    	$this->db->order_by('name', 'asc');
    	$query = $this->db->get('user');
        return $query->result();
    }
    
    function get_user_by_id($id){
        $this->db->where('id',$id);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function get_user_by_init_code($id){
        $like = "initiative LIKE '$id' OR initiative LIKE '$id%' OR initiative LIKE '%$id'";
        $this->db->where("($like)");
        //$this->db->where('initiative',$id);
        //$this->db->where("(initiative = ".$id." OR (initiative LIKE '%$id%')");
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_all_customer_order($atr, $how){
    	$this->db->where('role',3);
    	$this->db->order_by($atr, $how);
    	$query = $this->db->get('user');
        return $query->result();
    }
    
    function get_all_customer_search($query){
    	$like = "name LIKE '$query%' OR username LIKE '$query%'";
    	$this->db->where("($like)");
    	$this->db->order_by('id', 'desc');
    	$this->db->where('role',3);
    	$query = $this->db->get('user');
        return $query->result();
    }
    
    function get_user_login(){
        $user = $this->session->userdata('user');
    	$this->db->where('id',$user['id']);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
        	$this->session->unset_userdata('user');
            return false;
        }
    }
    
    function get_user_id_by_username($username){
        $this->db->where('username',$username);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_user_password($password){
    	$user = $this->session->userdata('user');
    	$this->db->where('id',$user['id']);
        $result = $this->db->get('user');
        if($result->num_rows==1){
            $user = $result->row(0);
        }
    	//$user = $this->get_user_login();
    	$m = md5($password);
    	if($m == $user->password){return true;}
    	else{return false;}
    }
    
    function get_last_profil_id(){
        $result = $this->db->query('SELECT MAX(id) as id FROM profil');
        if($result->num_rows>0){
            return $result->row(0)->id;
        }else{
            return false;
        }
    }
    
    function get_last_user_id(){
        $result = $this->db->query('SELECT MAX(id) as id FROM user');
        if($result->num_rows>0){
            return $result->row(0)->id;
        }else{
            return false;
        }
    }
    
    function get_pic_token(){
        $q=$this->input->get('q');
        $like = "(name LIKE '%".$q."%')";
        //$this->db->like('name', $q);
        //$this->db->or_like('abbreviation',$q);
        $this->db->where($like);
        $result = $this->db->get('user');
        if($result->num_rows>0){
            return $result->result_array();
        }else{
            return false;
        }   
    }
    
    function get_existing_pic_token($user_id){
        $this->db->where('id',$user_id);
        $result = $this->db->get('user');
        if($result->num_rows>0){
            return $result->result_array();
        }else{
            return false;
        }
    }
    
    //UPDATE FUNCTION
    function update_user($user,$id){
        $this->db->where('id',$id);
        return $this->db->update('user', $user);
    }
    
    
    //DELETE FUNCTION
    function delete_address(){
    	$address_id = $this->input->post('address_id');
    	if($this->is_address_used($address_id)){
    		$this->db->where('id',$address_id);
    		$profil['user_id'] = '';
			return $this->db->update('profil', $profil);	
    	}else{
    		$this->db->where('id',$address_id);
    		return $this->db->delete('profil');
    	}
    }
    function delete_user(){
    	$id = $this->input->post('id');
    	$this->db->where('id',$id);
    	$this->db->delete('user');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    
    // OTHER FUNCTION
    function config_email(){
    	$config['protocol'] = 'smtp';
        $config['smtp_port'] = '25';
        $config['smtp_host'] = 'mail.dync-store.com';
        $config['smtp_user'] = 'dyn10000';
        $config['smtp_pass'] = 'dyn24157';
        $config['mailtype'] = 'html';
        $config['newline'] = "<br>";
        $config['wordwrap'] = TRUE;
        
        return $config;
    }
}
