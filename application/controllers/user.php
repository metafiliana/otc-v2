<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('muser');
        $this->load->model('mmilestone');
        $this->load->model('minitiative');
        $this->load->model('mremark');
        $this->load->library('excel');
    }
    
    public function index()
    {
    	$user = $this->session->userdata('user');
		
		if($user){
			$users = $this->muser->get_all_user();
			$data['title'] = "User List";
			$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		  
		    $data['user']=$user;
            if($user['role']!='admin'){
                $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
                $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
            }
            else{
                $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
                $data['notif']= $this->mremark->get_notification_by_admin('');
            }
			
            $data['header'] = $this->load->view('shared/header-new',$data,TRUE);
            $data['footer'] = $this->load->view('shared/footer','',TRUE);
			$data['content'] = $this->load->view('user/list_user',array('user'=>$users),TRUE);
	
			$this->load->view('front',$data);
        }else{
        	redirect('user/login');
        }
        
    }
    
    public function login($params=null)
    {
    	/*$session = $this->session->userdata('user');
        if($session){
            redirect('customer');
        }*/
    	$data['title'] = "User Login";
    	
        $data['header'] = '';
        $data['sidebar'] = '';
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('user/login',array('params' => $params),TRUE);
    
        $this->load->view('front',$data);
    }
    
    public function input_user()
    {
    	$user_id = $this->uri->segment(3); 
        $data_user="";
    	
    	if($user_id){$data_user = $this->muser->get_user_by_id($user_id);}
    	
    	$user = $this->session->userdata('user');
    	$data['title'] = "Input User";
        // $pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
        // $data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);
		$data['user']=$user;
        if($user['role']!='admin'){
            $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
            $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
        }
        else{
            $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
            $data['notif']= $this->mremark->get_notification_by_admin('');
        }
        
        $data['header'] = $this->load->view('shared/header-new',$data,TRUE);
        $data['sidebar'] = $this->load->view('shared/sidebar','',TRUE);
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('user/input',array('info' => $data_user),TRUE);
    
        $this->load->view('front',$data);
    }
    
	public function userEnter()
	{
		$params['username'] = $this->input->post('username');
        $params['password'] = md5($this->input->post('password'));
        
        if($this->check_login($params['username'],$params['password'])){
            $user = $this->muser->get_user_id_by_username($params['username']);
            $user_roles = explode(',',$user->role);
            $data = array(
					'username' => $params['username'],
					'id' => $user->id,
					'name' => $user->name,
					'is_logged_in' => true,
					'role' => $user->role,
					'jabatan' => $user->jabatan,
					'initiative' => $user->initiative
				);
			$this->session->set_userdata('user',$data);
            if(count($user_roles)>100){
            	$data['title'] = "Choose Role";
				$data['header'] = '';
				$data['footer'] = $this->load->view('shared/footer','',TRUE);
				$data['content'] = $this->load->view('user/choose_role',array('roles' => $user_roles),TRUE);
	
				$this->load->view('front',$data);
            }else{
				redirect('home');
            }
        }else{
            $params['type_login']="failed";
            $this->login($params);
        }
        //$data['notif_hari'] = $this->muser->insert_notification_by_date();
	}
	
	public function chooseRole()
    {
    	$user = $this->session->userdata('user');
    	if (isset($_POST['yes'])) {
			$revised['desc_'.$aut]="Approved";
		} else if (isset($_POST['no'])) {
			$revised['desc_'.$aut]="Rejected";
		}
    }
	
	private function check_login($username, $password){
         if(empty($username) || empty($password)){
             return false;
         }else{
             if($this->muser->verify($username, $password)){return true;}
             else{return false;}
         }
    }
    
    public function register(){
      	$id = $this->uri->segment(3);
      	$user['username'] = $this->input->post('username');
      	if(!$id){
        	$user['password'] = md5($this->input->post('password'));
        }
        $user['name'] = $this->input->post('name');
        $user['role'] = $this->input->post('role');
        //$user['jabatan'] = $this->input->post('jabatan');
        //$user['unitkerja'] = $this->input->post('unitkerja');
        $user['initiative'] = $this->input->post('initiative');
        
        if($id){
			if($this->muser->update_user($user,$id)){
				redirect('user');
			}
    	}else{
			if($this->muser->register($user)){
        		redirect('user');
			}
    	}
    }
    
    public function logout(){
        $this->session->unset_userdata('user');
        redirect('/user/login');
    }
    
    public function delete_user(){
        if($this->muser->delete_user()){
    		$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
    public function reset_user(){
        $id = $this->input->post('id');
        $user['password'] = md5('123123');
        if($this->muser->update_user($user,$id)){
            $json['status'] = 1;
        }
        else{
            $json['status'] = 0;
        }
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }

	public function form_password(){
    	$data['title'] = 'Change Password';
    	
    	$user = $this->session->userdata('user');
		
		$data_content['segment_status'] = $this->minitiative->get_all_segments_status();
		
        $data['user']=$user;
        if($user['role']!='admin'){
            $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
            $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],5);
        }
        else{
            $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
            $data['notif']= $this->mremark->get_notification_by_admin(5);
        }
        
        $data['header'] = $this->load->view('shared/header-new',$data,TRUE);    
		$data['sidebar'] = $this->load->view('shared/sidebar','',TRUE);
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('user/form_password',$data_content,TRUE);
		$this->load->view('front',$data);
    }
    
    public function check_user_password($password=null,$format=null){
         if($password==null){
             $password = $this->input->post('password');
         }
         if($this->muser->get_user_password($password)){
             $value = $this->muser->get_user_password($password);
         }else{
             $value = $this->muser->get_user_password($password);
         }
         if($format==null){
            $this->output->set_content_type('application/json')
                        ->set_output(json_encode(array("value" => $value)));
         }
         return $value;
     }
    
    public function change_password(){
    	$user['password'] = md5($this->input->post('password_new'));
        $user_ses = $this->session->userdata('user');
        if($this->muser->update_user($user,$user_ses['id'])){
            $json['status']=1;
            $json['success']=TRUE;
            //echo "Password berhasil dirubah" ;
            //redirect('home');
        }
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function not_login_yet(){
    	$params['type_login']="not_login";
        $this->login($params);
    }

    public function input_data_user(){
        $exel = $this->read_excel("userpmo.xlsx");
        $arrres = array(); $s=0;
        for ($row = 2; $row <= $exel['row']; ++$row) {
            $data = "";
            for ($col = 0; $col < $exel['col']; ++$col) {
                $arrres[$row][$col] = $exel['wrksheet']->getCellByColumnAndRow($col, $row)->getValue();
            }
            
            $data['username'] = $arrres[$row][0];
            $data['password'] = md5($arrres[$row][1]);
            $data['name'] = $arrres[$row][2];
            $data['role'] = $arrres[$row][3];
            $data['private_email']= $arrres[$row][4];
            $data['initiative']= $arrres[$row][5];
            $this->muser->insert_user($data);

        }
    }

    public function troublelogin(){
        $data['title'] = "Recover Password";
        
        $data['header'] = '';
        $data['sidebar'] = '';
        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('user/trouble_login','',TRUE);
    
        $this->load->view('front',$data);
    }

    /*Function PHP EXCEL for parsing*/ 
    function read_excel($file){
        $arrres = array();
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(TRUE);
        $objPHPExcel = $objReader->load("assets/upload/".$file);
        
        $arrres['wrksheet'] = $objPHPExcel->getActiveSheet();
        // Get the highest row and column numbers referenced in the worksheet
        $arrres['row'] = $arrres['wrksheet']->getHighestRow(); // e.g. 10
        $highestColumn = $arrres['wrksheet']->getHighestColumn(); // e.g 'F'
        $arrres['col'] = PHPExcel_Cell::columnIndexFromString($highestColumn);
        
        return $arrres;
    }
    
    function SaveViaTempFile($objWriter){
        $filePath = '/tmp/' . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
        $objWriter->save($filePath);
        readfile($filePath);
        unlink($filePath);
    }
     function excelDateToDate($readDate){
        $phpexcepDate = $readDate-25569; //to offset to Unix epoch
        return strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
    }
}
