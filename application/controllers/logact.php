<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Logact extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('mworkblock');
        $this->load->model('mmilestone');
        $this->load->model('mlogact');
        $this->load->model('mremark');
        
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
		$data['title'] = 'Log Activity';
    	
    	$user = $this->session->userdata('user');
    	$logs = $this->mlogact->get_logact();
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		$listlog = $this->load->view('logact/_list_logact',array('logs' => $logs),TRUE);
		
        $data['user']=$user;
        if($user['role']!='admin'){
            $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
            $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
        }
        else{
            $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
            $data['notif']= $this->mremark->get_notification_by_admin('');
        }
		// $data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		// $data['sidebar'] = $this->load->view('shared/sidebar_2','',TRUE);
        $data['header'] = $this->load->view('shared/header-new',$data,TRUE);
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('logact/index',array('listlog' => $listlog),TRUE);
		$this->load->view('front',$data);	
    }
    
}
