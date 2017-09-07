<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('muser');
        $this->load->model('mmilestone');
        $this->load->model('minitiative');
        $this->load->model('mremark');
        $this->load->library('excel');
        $this->load->library('form_validation');
    }

    public function index()
    {
    	$user = $this->session->userdata('user');

		if($user){
			$users = $this->muser->get_all_user();
			$data['title'] = "User List";
			$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);

		    $data['user']=$user;
            if($user['role']!='2'){
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
      $user = $this->session->userdata('user');
      if($user && $user['role']=='2'){
    	$user_id = $this->uri->segment(3);
      $data_user="";

    	if($user_id){$data_user = $this->muser->get_user_by_id($user_id);}

    	//$user = $this->session->userdata('user');
    	$data['title'] = "Input User";
        // $pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
        // $data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);
      $data['user']=$user;
        if($user['role']!='2'){
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
      else{
        redirect('user/login');
      }
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
    	$user = $this->session->userdata('user');
      if($user){
        $data['title'] = 'Change Password';
  	    $data_content['segment_status'] = $this->minitiative->get_all_segments_status();

        $data['user']=$user;
        if($user['role']!='2'){
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
      else{
        redirect('user/login');
      }

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

    public function sendMail($u_recover, $key){
        $a = $this->input->post('username', TRUE);
        if($a)
        {
            $this->form_validation->set_rules('username', 'username', 'required');

            if($this->form_validation->run() == TRUE)
            {
                $get = $this->db->get_where('user', array('username' => $this->input->post('username', TRUE)));

                if($get->num_rows() > 0 )
                {
                    $emailConfig = [
                        'protocol' => 'smtp',
                        'smtp_host' => 'smtp.gmail.com',
                        'smtp_port' => 587,
                        'smtp_user' => 'sundfor0@gmail.com',
                        'smtp_pass' => 'legalizer14',
                        'smtp_crypto' => 'tls',
                        'mailtype' => 'html'
                        //'charset' => 'iso-8859-1'
                    ];
                    // Set your email information
                    $from = [
                        'email' => 'sundfor0@gmail.com',
                        'name' => 'OTC Mandiri'
                    ];

                    $reco['u_recover'] = $this->input->post('username');
                    $reco['key'] = md5(md5(time()));

                    $to = 'zand.only@gmail.com';
                    //$to = 'alfiansyah.ichsan@gmail.com';
                    //array('tezza.riyanto@bankmandiri.co.id');
                    $subject = 'Permohonan ubah password pada sistem OTC';

                    // $message = 'Mohon ubah password untuk user '.$u_recover.' Silahkan klik link di bawah ini untuk melakukan approval <a href="'.base_url().'user/recover_password/'.$key.'">disini</a>';
                    // use this line to send text email.
                    // load view file called "welcome_message" in to a $message variable as a html string.
                    //$message =  $this->load->view('welcome_message',[],true);
                    // Load CodeIgniter Email library

                    $body = $this->load->view('user/email.php',$reco,TRUE);
                    $this->load->library('email', $emailConfig);
                    // Sometimes you have to set the new line character for better result
                    $this->email->set_newline("\r\n");
                    // Set email preferences
                    $this->email->from($from['email'], $from['name']);
                    $this->email->to($to);
                    $this->email->subject($subject);
                    $this->email->message($body);
                    // Ready to send email and check whether the email was successfully sent
                    if (!$this->email->send()) {
                        $this->session->set_flashdata("error","Error in sending Email.");
                    } else {
                        $data['token'] = $reco['key'];
                        $cond['username'] = $this->input->post('username', TRUE);
                        $this->db->update('user', $data, $cond);
                        $this->session->set_flashdata("email_sent","Email sent successfully.");
                    }
                    redirect('user/troublelogin');
                }else{
                    $this->session->set_flashdata("error","Username tidak terdaftar.");
                    redirect('user/troublelogin');
                }
            }
        }
        $this->load->view('user/trouble_login');
    }

    public function success_reset(){
        $data['title'] = "Recover Password";

        $data['header'] = '';
        $data['sidebar'] = '';
        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('user/success_reset','',TRUE);

        $this->load->view('front',$data);
    }

    public function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function recover_password($usernamerec){
        $b = $this->uri->segment(3);
        $emailrec = $this->muser->get_workemail_reco($b);
        $tut['usernamerec'] = $this->muser->get_username_reco($b);
        if($b)
        {
            $result = $this->muser->check_token($b);
            if(empty($result))
            {
                redirect('user/login');

            } else{
                $tut['pass'] = $this->generateRandomString();
                $data['password'] = md5($tut['pass']);
                $data['token'] = '';

                $cond['token'] = $this->uri->segment(3);
                $this->db->update('user',$data, $cond);

                $emailConfig = [
                    'protocol' => 'smtp',
                    'smtp_host' => 'smtp.gmail.com',
                    'smtp_port' => 587,
                    'smtp_user' => 'sundfor0@gmail.com',
                    'smtp_pass' => 'legalizer14',
                    'smtp_crypto' => 'tls',
                    'mailtype' => 'html'
                    //'charset' => 'iso-8859-1'
                ];
                // Set your email information
                $from = [
                    'email' => 'sundfor0@gmail.com',
                    'name' => 'OTC Mandiri'
                ];

                $to = $emailrec;

                $subject = 'Recover Password';

                // $message = 'Password anda telah dirubah setelah disetujui oleh admin otc, dengan detail sebagai berikut: <br> Username : '.$usernamerec.' <br> Password : 123123 <br> Mohon untuk mengganti password setelah login ke sistem.';
                $body = $this->load->view('user/detail_email.php',$tut,TRUE);
                $this->load->library('email', $emailConfig);
                // Sometimes you have to set the new line character for better result
                $this->email->set_newline("\r\n");
                // Set email preferences
                $this->email->from($from['email'], $from['name']);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($body);
                // Ready to send email and check whether the email was successfully sent
                if (!$this->email->send()) {
                    $this->session->set_flashdata("email_sent","Error in sending Email.");
                } else {
                    $this->session->set_flashdata("email_sent","Email sent successfully.");
                }
                $this->load->view('user/success_reset');
            }
        }
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
