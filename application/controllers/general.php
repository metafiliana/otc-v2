<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class General extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('mworkblock');
        $this->load->model('mmilestone');
        
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
    	$data['title'] = 'Overview Corplan';
    	
    	$user = $this->session->userdata('user');
    	$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['sidebar'] = $this->load->view('shared/sidebar','',TRUE);
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('general/overview',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function mom(){
    	$data['title'] = 'MoM Corplan';
    	
    	$user = $this->session->userdata('user');
    	$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['sidebar'] = $this->load->view('shared/sidebar','',TRUE);
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
