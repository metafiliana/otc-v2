<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class General extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('mworkblock');
        $this->load->model('mmilestone');
        $this->load->model('mremark');
        $this->load->model('mfiles_upload');
        $this->load->model('mkuantitatif');
        
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
		
        $data['header'] = $this->load->view('shared/header-new','',TRUE);
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('general/overview',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function files(){
    	$data['title'] = 'Files Control Tower';
    	
    	$user = $this->session->userdata('user');
    	
        $data['user']=$user;
        if($user['role']!='admin'){
            $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
            $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
        }
        else{
            $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
            $data['notif']= $this->mremark->get_notification_by_admin('');
        }
        $prog['init_code']=$this->mfiles_upload->get_distinct_col_segment('init_code','asc','program');
        
        $data['header'] = $this->load->view('shared/header-new',$data,TRUE);
        $data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('general/_all_files',$prog,TRUE);

		$this->load->view('front',$data);
    }

    public function input_file(){
        $data['title'] = "Upload Files";
        
        $data['init_code'] = $this->input->get('init_code');
        if($this->input->get('id')){
            $id = $this->input->get('id');
            $data['files'] = $this->mkuantitatif->get_kuantitatif_by_id($id);  
        }

        $json['html'] = $this->load->view('general/input',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }

    public function submit_file(){
        $id = $this->uri->segment(3);
        $user = $this->session->userdata('userdb');
        $program['title'] = $this->input->post('title');
        $data['init_code'] = $this->input->post('init_code');
         
        /*Upload */ 
        $upload_path = "assets/upload/files/".$data['init_code']."/";
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => "*",
            'overwrite' => TRUE,
            'max_size' => "2048000000",
        );
        $this->load->library('upload', $config);
        
        if($this->upload->do_multi_upload("attachment"))
        {
            $attachments = $this->upload->get_multi_upload_data();
            foreach($attachments as $atch){
                $this->mfiles_upload->insert_files_upload_with_full_url_with_param($upload_path, $data['init_code'], 'files', $atch, '', $program);
            }
        }
        else{
            $error = array('error' => $this->upload->display_errors());
        }
        redirect('general/files/');
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
