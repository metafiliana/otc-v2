<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mmilestone');
        $this->load->model('mremark');
        $this->load->model('muser');
        $this->load->model('mfiles_upload');
        $session = $this->session->userdata('user');
        if(!$session){
            redirect('user/login');
        }
    }
    /**
     * Method for page (public)
     */
    public function index()
    {
        $users = $this->session->userdata('user');
        $user = $users['username'];
        $initid = $users['initiative'];
        $foto = $this->muser->get_data_user($user)->foto;
        $lastlogin = $this->muser->get_data_user($user)->last_login;
        $privateemail = $this->muser->get_data_user($user)->private_email;
        $workemail = $this->muser->get_data_user($user)->work_email;
        $data = array(
            'username' => $user,
            'foto' => $foto,
            'initid' => $initid,
            'last_login' => $lastlogin,
            'private_email' => $privateemail,
            'work_email' => $workemail
        );

		    $data['title'] = "Home";

        $user = $users;
        $data['user']=$user;
        if($user['role']!='2'){
            $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
            $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
        }
        else{
            $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
            $data['notif']= $this->mremark->get_notification_by_admin('');
        }

        //$data['notif_hari'] = $this->muser->insert_notification_by_date_7();
        //$data['notif_hari'] = $this->muser->insert_notification_by_date_2();
        //$this->blast_email();

        $data['header'] = $this->load->view('shared/header-v2',$data,TRUE);
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('home/undermt',$data,TRUE);

		$this->load->view('front',$data);

    }

    public function blast_email(){
        if(date('01-m-Y')==date('d-m-Y')){
            $data['check_date']=date('Y-m-01');
            if(!$this->muser->check_date($data['check_date'])){
                $user=$this->muser->get_user_by_role('Co-PMO');
                foreach ($user as $users) {
                $email = explode(';',$users->private_email);
                $this->send_email($users->name,$email,$users->initiative);
                }
                $this->mfiles_upload->insert_db($data,'email_date');
            }
        }
    }

    public function send_email($name,$email,$init){
        // Set SMTP Configuration
        $emailConfig = [
            'protocol' => 'smtp',
            'smtp_host' => 'smtp-mail.outlook.com',
            'smtp_port' => 587,
            'smtp_user' => 'otc.mandiri@outlook.com',//OTCmandiri1
            'smtp_pass' => 'QWEasd123',
            'smtp_crypto' => 'tls'
            //'mailtype' => 'html',
            //'charset' => 'iso-8859-1'
        ];
        // Set your email information
        $from = [
            'email' => 'otc.mandiri@outlook.com',
            'name' => 'OTC Mandiri'
        ];

        $to = $email;
        //array('tezza.riyanto@bankmandiri.co.id');
        $subject = 'Permohonan update progress pada sistem OTC';
        $message = 'Kepada '.$name.' untuk update progress pada initiative '.$init.' di http://10.200.7.53/otc Terima kasih.'; // use this line to send text email.
        // load view file called "welcome_message" in to a $message variable as a html string.
        //$message =  $this->load->view('welcome_message',[],true);
        // Load CodeIgniter Email library
        $this->load->library('email', $emailConfig);
        // Sometimes you have to set the new line character for better result
        $this->email->set_newline("\r\n");
        // Set email preferences
        $this->email->from($from['email'], $from['name']);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        // Ready to send email and check whether the email was successfully sent
        if (!$this->email->send()) {
            // Raise error message
            show_error($this->email->print_debugger());
        } else {
            // Show success notification or other things here
            //echo 'Success to send email';
        }
    }
}
