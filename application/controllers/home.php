<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
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

		$data['title'] = "Home";
		$user = $this->session->userdata('user');
        $data['user']=$user;
        //$data['sidebar'] = $this->load->view('shared/sidebar_2',$data,TRUE);

		$data['header'] = $this->load->view('shared/header-new','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('home/home',$data,TRUE);

		$this->load->view('front',$data);
        
    }
}
