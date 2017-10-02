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

    function get_user_co_pmo(){
        $this->db->select('name,initiative');
        $this->db->where('role','Co-PMO');
        $result = $this->db->get('user');
        return $result->result();
    }

    function get_user_by_role($role){
        $this->db->select('*');
        $this->db->where('role',$role);
        $result = $this->db->get('user');
        return $result->result();
    }

    function get_id_m_role($role){
        $this->db->select('id');
        $this->db->where('title',$role);
        $result = $this->db->get('m_role');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function check_date($date){
        $this->db->where('check_date',$date);
        $result = $this->db->get('email_date');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
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

    // function delete_notif_data_after_1year(){
    //     $this->db->select('*');
    //     $this->db->from('notification');
    //     $this->db->where('date_time = date_sub(CURDATE(), INTERVAL 2 DAY)');
    //     $this->db->delete('notification');
    // }

    function insert_notification_by_date_7(){
        $this->db->db_debug = FALSE;
        $this->db->select('initiative.end as date_time');
        $this->db->select("CONCAT((user.name),('<p><br> tersisa 7 hari untuk initiative <br>'),(program.code),(' pada deliverable <br>'),(initiative.title),('</p>')) as notification");
        $this->db->select('user.id as user_id_to');
        $this->db->select('program.id as init_id');
        $this->db->select('initiative.id as initiativeid');
        $this->db->join('program','program.id = initiative.program_id');
        $this->db->join('user','program.init_code = user.initiative');
        $this->db->where('initiative.end = date_sub(CURDATE(), INTERVAL -7 DAY)');
        $sql = $this->db->get('initiative');
        foreach($sql->result() as $row){
            $data = array(
                'date_time' => $row->date_time,
                'notification' => $row->notification,
                'user_id_to' => $row->user_id_to,
                'init_id' => $row->init_id,
                'initiativeid' => $row->initiativeid
                    );
                $insertest = $this->db->insert('notification',$data);
            }
            $this->db->_error_message();
    }

    function insert_notification_by_date_2(){
        $this->db->db_debug = FALSE;
        $this->db->select('initiative.end as date_time');
        $this->db->select("CONCAT((user.name),('<p><br> tersisa 2 hari untuk initiative <br>'),(program.code),(' pada deliverable <br>'),(initiative.title),('</p>')) as notification");
        $this->db->select('user.id as user_id_to');
        $this->db->select('program.id as init_id');
        $this->db->select('initiative.id as initiativeid');
        $this->db->join('program','program.id = initiative.program_id');
        $this->db->join('user','program.init_code = user.initiative');
        $this->db->where('initiative.end = date_sub(CURDATE(), INTERVAL -2 DAY)');
        $sql = $this->db->get('initiative');
            foreach($sql->result() as $row){
                $data = array(
                    'date_time' => $row->date_time,
                    'notification' => $row->notification,
                    'user_id_to' => $row->user_id_to,
                    'init_id' => $row->init_id,
                    'initiativeid' => $row->initiativeid
                        );
                    $insertest = $this->db->insert('notification',$data);
            }
            $this->db->_error_message();
    }

    function get_workemail_reco($b){
        $this->db->select('work_email');
        $this->db->where('token',$b);
        $result = $this->db->get('user');
        return $result->row()->work_email;
    }

    function check_token($b){
        $this->db->select('token');
        $this->db->where('token',$b);
        $result = $this->db->get('user');
        return $result->row()->token;
    }

    function get_username_reco($b){
        $this->db->select('username');
        $this->db->where('token',$b);
        $result = $this->db->get('user');
        return $result->row()->username;
    }

    function get_user_by_init_code($id){
        if($this->get_user_like_1($id)!=false){
            return $this->get_user_like_1($id);
        }
        if($this->get_user_like_2($id)!=false){
            return $this->get_user_like_2($id);
        }
        else{
            return $this->get_user_like_3($id);
        }
    }

    function get_user_like_1($id){
        $like = "initiative LIKE '$id'";
        $this->db->where("($like)");
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function get_user_like_2($id){
        $like = "initiative LIKE '$id%'";
        $this->db->where("($like)");
        $result = $this->db->get('user');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    function get_user_like_3($id){
        $like = "initiative LIKE '%$id'";
        $this->db->where("($like)");
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

    public function add_photo_profile($filename,$user){
        $data = array(
            'foto' => $filename
        );
        $this->db->where('username',$user);
        return $this->db->update('user', $data);
    }


    public function get_data_user($user){
        $this->db->select('*');
        $this->db->where('username',$user);
        $result = $this->db->get('user');
        return $result->row();
    }

    public function delete_photo($user){
        $data = array(
            'foto' => null
        );
        $this->db->select('foto');
        $this->db->where('username',$user);
        return $this->db->update('user',$data);
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

    //afil
    function get_all_co_pmo(){
        $this->db->distinct();
        $this->db->where('role', 'Co-PMO');
        $this->db->select('name as nama, initiative');
        // $this->db->join('program','kuantitatif.init_code = program.init_code');
        $query = $this->db->get('user')->result();

        $data = array();
        $i = 0;
        foreach ($query as $key => $value) {
            $status = 0;
            $data[$i]['nama'] = $value->nama;
            // array_push($database, $value->nama);
            if (strpos($value->initiative, ';') !== false) {
                $array = explode(';', $value->initiative);
                // array_push($data[$i]['initiative'], $array);
                $data[$i]['initiative'] = $array;
                $status = 1;
            }

            if ($status == 0){
                $data[$i]['initiative'] = $value->initiative;
            }

            $data[$i]['total_initiative'] = 0;
            $data[$i]['total_completed'] = 0;
            $i++;
        }

        // $sql = 'SELECT t.code as code, COUNT(STATUS) AS t_complete, (SELECT COUNT(STATUS) AS total FROM workblock a WHERE a.code = t.code GROUP BY CODE) AS total FROM workblock t WHERE LOWER(STATUS) = "completed" GROUP BY CODE';
        // $result = $this->db->query($sql)->result_array();


        foreach ($data as $key => $value) {
            $total_initiative = 0;
            $total_completed_raw = 0;
            $total_completed = 0;
            $is_array = 0;
            if (is_array($value['initiative']) === true){
                $r_init = array();
                foreach ($value['initiative'] as $ky => $v) {
                    $sql = 'SELECT t.code, t.init_code, (SELECT COUNT(a.STATUS) FROM workblock a WHERE a.STATUS = "Completed" AND a.code = t.`init_code`) AS status_c, (SELECT COUNT(b.STATUS) FROM workblock b WHERE b.STATUS = "In Progress" AND b.code = t.`init_code`) AS status_i, (SELECT COUNT(c.STATUS) FROM workblock c WHERE c.STATUS = "Delay" AND c.code = t.`init_code`) AS status_d, (SELECT COUNT(d.STATUS) FROM workblock d WHERE d.STATUS = "Not Started Yet" AND d.code = t.`init_code`) AS status_n, (SELECT COUNT(STATUS) FROM workblock z WHERE z.code = t.`init_code`) total_init FROM (SELECT f.*, e.`name` AS nama FROM program f RIGHT JOIN user e ON f.`init_code` = "'.$v.'") t WHERE t.nama = "'.$value["nama"].'" GROUP BY t.init_code';
                    $r_hasil = $this->db->query($sql)->result_array();

                    array_push($r_init, $r_hasil[0]);
                }

                $total_initiative = count($value['initiative']);

                $initiative = '';
                foreach ($value['initiative'] as $key2 => $value2) {
                    $initiative .= $value2.';';
                }

                foreach ($r_init as $key1 => $value1) {
                    // $jumlah_completed = round(((float)($value1['status_c']/$value1['total_init']) * 100), 2);
                    // $total_completed = $total_completed + $jumlah_completed;
                    $get_persen = $this->mprogram->getPercentProgram($value1['init_code'], false);
                    $total_completed_raw = $total_completed_raw + $get_persen;
                }

                $data[$key]['initiative_string'] = $initiative;
                $data[$key]['total_initiative'] = $total_initiative;
                if ($total_completed_raw != 0 && $total_initiative != 0){
                    // $data[$key]['total_completed'] = round(((float)($total_completed/$total_initiative)), 2);
                    $total_completed = $total_completed_raw / count($r_init);
                    $data[$key]['total_completed'] = number_format($total_completed, 2, '.', '');
                }
            }else{
                $sql1 = 'SELECT t.code, t.init_code, (SELECT COUNT(a.STATUS) FROM workblock a WHERE a.STATUS = "Completed" AND a.code = t.`init_code`) AS status_c, (SELECT COUNT(b.STATUS) FROM workblock b WHERE b.STATUS = "In Progress" AND b.code = t.`init_code`) AS status_i, (SELECT COUNT(c.STATUS) FROM workblock c WHERE c.STATUS = "Delay" AND c.code = t.`init_code`) AS status_d, (SELECT COUNT(d.STATUS) FROM workblock d WHERE d.STATUS = "Not Started Yet" AND d.code = t.`init_code`) AS status_n, (SELECT COUNT(STATUS) FROM workblock z WHERE z.code = t.`init_code`) total_init FROM (SELECT f.*, e.`name` AS nama FROM program f RIGHT JOIN user e ON e.`initiative` = f.`init_code`) t WHERE t.nama = "'.$value["nama"].'" GROUP BY t.init_code';
                $result1 = $this->db->query($sql1)->result_array();

                $total_initiative = 1;
                $data[$key]['initiative_string'] = $value['initiative'];
                $data[$key]['total_initiative'] = $total_initiative;
                foreach ($result1 as $key1 => $value1) {
                    if ($value['initiative'] == $value1['init_code']){
                        $data[$key]['total_completed'] = (int)$value1['status_c'];
                        if ($total_initiative != 0 && $value1['total_init'] != 0)
                            // $data[$key]['total_completed'] = round(((float)($value1['status_c']/$value1['total_init']) * 100), 2);
                            $data[$key]['total_completed'] = $this->mprogram->getPercentProgram($value1['init_code']);
                    }
                }
            }
                //keperluan penghitungan kuantitatif
            $arr_initcode= explode(";",$data[$key]['initiative_string']);
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

        foreach ($data as $key => $row) {
            $arsort[$key]  = $row['total_completed'];
        }

        array_multisort($arsort, SORT_DESC, $data);

        return $data;
    }

    public function getInitiative($name = null)
    {
        $this->db->distinct();
        $this->db->where('role', 'Co-PMO');
        if ($name !== null)
            $this->db->where('name', $name);
        $this->db->select('name as nama, initiative');
        // $this->db->join('program','kuantitatif.init_code = program.init_code');
        $query = $this->db->get('user')->result();

        $data = array();
        $i = 0;
        foreach ($query as $key => $value) {
            $status = 0;
            $data['nama'] = $value->nama;
            // array_push($database, $value->nama);
            if (strpos($value->initiative, ';') !== false) {
                $array = explode(';', $value->initiative);
                // array_push($data[$i]['initiative'], $array);
                $data['initiative'] = $array;
                $status = 1;
            }

            if ($status == 0){
                $data['initiative'] = $value->initiative;
            }

            $i++;
        }

        return $data;
    }
}
