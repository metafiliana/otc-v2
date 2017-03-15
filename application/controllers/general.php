<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class General extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('mworkblock');
        $this->load->model('mmilestone');
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
		
    }
    
    public function overview(){
    	$data['title'] = 'Overview Tower Center';
    	
    	$user = $this->session->userdata('user');
    	$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		// $data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		// $data['sidebar'] = $this->load->view('shared/sidebar','',TRUE);
        $data['header'] = $this->load->view('shared/header-new','',TRUE);
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('general/overview',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function mom(){
    	$data['title'] = 'MoM Tower Center';
    	
    	$user = $this->session->userdata('user');
    	
        // $pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		// $data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
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
        $data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('general/mom',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function outlook(){
    	$data['title'] = 'Outlook 7 Sectors';
    	
    	$user = $this->session->userdata('user');
    	$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['sidebar'] = $this->load->view('shared/sidebar','',TRUE);
		$data['content'] = $this->load->view('general/outlook',array(),TRUE);

		$this->load->view('front',$data);
    }
    
}
