<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Initiative extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('minitiative');
        $this->load->model('mworkblock');
        $this->load->model('mremark');
        $this->load->model('mmilestone');
        $this->load->model('mprogram');
        $this->load->model('mfiles_upload');
        $this->load->model('muser');
        $this->load->helper('url');

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
		redirect('initiative/list_initiative');
    }
    
    /*Initiative*/
    /*public function list_initiative(){
    	$data['title'] = "List All Initiatives";
		$segment = $this->uri->segment(3);
		
		if($segment == "Performance%20Management"){$segment = "Performance Management";}
		
		//Header
		$user = $this->session->userdata('user');
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		$this->minitiative->check_initiative_status();
		
		$programs = $this->minitiative->get_all_programs_with_segment($segment);
		$user_info = $this->muser->get_user_by_id($user['id']);
		$roles = explode(',',$user['role']); $user_initiative="";
		if((in_array('PIC',$roles))&&!(in_array('PMO',$roles))){
			$user_initiative = explode(';',$user_info->initiative);	
		}
		
		$form_new = $this->load->view('initiative/input_initiative',array('programs' => $programs,'segment' => $segment),TRUE);
		
		$initiatives = $this->minitiative->get_all_initiatives($user_initiative, $segment);
		$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['sidebar'] = $this->load->view('shared/sidebar','',TRUE);
		$data['content'] = $this->load->view('initiative/list_initiative',array('ints' => $initiatives,'programs' => $programs, 'form_new' => $form_new),TRUE);

		$this->load->view('front',$data);
    }
    
    public function input_initiative(){
    	$data['title'] = "Input Initiative";
		
		$user = $this->session->userdata('user');
		
		$programs = $this->minitiative->get_all_programs();
		
		$data['header'] = $this->load->view('shared/header',array('user' => $user),TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('initiative/input_initiative',array('programs' => $programs),TRUE);

		$this->load->view('front',$data);
    }*/
    
    public function edit_initiative(){
    	$id = $this->input->get('id');
    	$segment = $this->input->get('segment');
    	$programs = $this->minitiative->get_all_programs_with_segment($segment);
    	$init = $this->minitiative->get_initiative_by_id($id);
    	$pic = $this->get_existing_pic_token($init->GH_PIC);
		if($init){
			$json['status'] = 1;
            $json['html'] = $this->load->view('initiative/_edit_initiative',array('programs' => $programs, 'init'=>$init, 'pic'=>$pic, 'segment' => $segment),TRUE);
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function detail_initiative(){
    	$id = $this->uri->segment(3);
    	$initiative['int'] = $this->minitiative->get_initiative_by_id($id);
    	$user = $this->session->userdata('user');
    	$roles = explode(',',$user['role']);
    	$inits = explode(';',$user['initiative']); 
    	if((in_array('PIC',$roles)&&(count($roles)==1))&& !(in_array($initiative['int']->code,$inits))){
    		redirect('initiative/list_initiative');
    	}
    	else{
			$initiative['stat'] = $this->minitiative->get_initiative_status($id)['status'];
			$workblocks = $this->mworkblock->get_all_initiative_workblock($id);
		
			$user = $this->session->userdata('user');
			$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
			$data['title'] = "Initiative";
			$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
			$data['footer'] = $this->load->view('shared/footer','',TRUE);
			$data['content'] = $this->load->view('initiative/detail',array('initiative' => $initiative,'workblocks' => $workblocks),TRUE);

			$this->load->view('front',$data);
		}
    }
    
    public function get_pic_token(){
        $arr = array();
        $arr = $this->muser->get_pic_token();
    
        # JSON-encode the response
        $json_response = json_encode($arr);
        
        # Return the response
        echo $json_response;
    }
    
    public function get_existing_pic_token($user_id){
        $arr = array();
        $arr = $this->muser->get_existing_pic_token($user_id);
        # Collect the results
        
        # JSON-encode the response
        $json_response = json_encode($arr);
        
        # Optionally: Wrap the response in a callback function for JSONP cross-domain support
        /*if($_GET["callback"]) {
         $json_response = $_GET["callback"] . "(" . $json_response . ")";
         }*/
        
        # Return the response
        return $json_response;
    }
    
    /*Program*/
    public function list_programs(){
    	$data['title'] = "List All Initiatives";
		
		$user = $this->session->userdata('user');
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		$programs = $this->minitiative->get_all_programs();
		
		//$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['sidebar'] = $this->load->view('shared/sidebar_2','',TRUE);
		$data['content'] = $this->load->view('initiative/list_program',array('programs' => $programs),TRUE);

		$this->load->view('front',$data);
    }
    
	public function delete_initiative(){
        if($this->minitiative->delete_initiative()){
    		$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function get_description(){
       	$id = $this->input->get('id');
    	$int = $this->minitiative->get_info_initiative_by_id($id); 
		if($int){
			$view = $this->load->view('initiative/_descrp_initiative',array('int' => $int),TRUE);
			
			$json['status'] = 1;
            $json['message'] = $view;
            $json['title'] = $int['init']->title;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function mind_map(){
		$allthing = $this->minitiative->get_all('Wholesale');
		$data['title'] = "List All Initiatives";
		
		$user = $this->session->userdata('user');
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('initiative/mind_map',array('all'=>$allthing),TRUE);

		$this->load->view('front',$data);
	} 
	
	/*Initiative New */
	
	public function list_program_initiative(){
    	$data['title'] = "List All Initiatives";
		
		$program_id = $this->uri->segment(3);
		
		//Header
		$user = $this->session->userdata('user');
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		//$this->minitiative->check_initiative_status();
		
		$program = $this->mprogram->get_program_by_id($program_id);
		$user_info = $this->muser->get_user_by_id($user['id']);
		$roles = explode(',',$user['role']); $user_initiative="";
		if((in_array('PIC',$roles))&&!(in_array('PMO',$roles))){
			$user_initiative = explode(';',$user_info->initiative);	
		}
		$user_init = $this->muser->get_user_by_init_code($program->init_code);
		$initiatives = $this->minitiative->get_program_initiatives($user_initiative, $program_id);

		// $data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['header'] = $this->load->view('shared/header-new','',TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		// $data['sidebar'] = $this->load->view('shared/sidebar_2','',TRUE);
		$data['content'] = $this->load->view('initiative/list_initiative',array('ints' => $initiatives,'program' => $program, 'user_init' => $user_init),TRUE);

		$this->load->view('front',$data);
    }
    
    public function update_notification(){
		$id = $this->input->get('id');
		if($id){
			$prog['status']='read';
			$this->mremark->update_notification($prog,$id);
		}
    	$json['status'] = 1;
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}

	public function mark_as_read(){
		$user_id = $this->input->get('user_id');
		if($user_id){
			$prog['status']='read';
			$this->mremark->update_notification_by_user_id($prog,$user_id);
		}
    	$json['status'] = 1;
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}


    public function input_initiative(){
		$id = $this->input->get('id');
		$program_id = $this->input->get('program');
		$initiative = "";
		if($id){
			$initiative = $this->minitiative->get_initiative_by_id($id);
		}
		$program = $this->mprogram->get_program_by_id($program_id);
    	$json['status'] = 1;
		$json['html'] = $this->load->view('initiative/_input_initiative',array('program' => $program, 'int' => $initiative),TRUE);
		
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}

	public function input_comment(){
		$init_id = $this->input->get('id');
		//$program_id = $this->input->get('program');
		$initiative = "";
		if($id){
			$remarks = $this->mremark->get_remarks_by_init_id($init_id);
		}
    	$json['status'] = 1;
		$json['html'] = $this->load->view('initiative/detail/_form_remarks',array('remark'=>'','init_id'=>$init_id),TRUE);
		
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function submit_initiative(){
      	$id = $this->input->post('id');
      	$program['title'] = $this->input->post('title');
        //$program['code'] = $this->input->post('code');
        //$program['parent_code'] = $this->input->post('parent');
        $program['program_id'] = $this->input->post('program_id');
        //$program['kickoff'] = $this->input->post('kickoff');
        //$program['completion'] = $this->input->post('completion');
        $program['description'] = $this->input->post('description');
        $program['status'] = $this->input->post('status');
        //$program['GH_PIC'] = $this->input->post('GH_PIC');
        //$program['pic'] = $this->input->post('pic');
        
        if($this->input->post('start')){$start = DateTime::createFromFormat('m/d/Y', $this->input->post('start'));
    		$program['start'] = $start->format('Y-m-d');
    	}
    	
    	if($this->input->post('end')){$end = DateTime::createFromFormat('m/d/Y', $this->input->post('end'));
    		$program['end'] = $end->format('Y-m-d');
    	}
        
        if($id){
        	if($this->minitiative->update_initiative($program,$id)){redirect('initiative/list_program_initiative/'.$program['program_id']);}
        	else{redirect('initiative/input_initiative/'.$segment);}
        }
        else{
        	if($this->minitiative->insert_initiative($program)){redirect('initiative/list_program_initiative/'.$program['program_id']);}
        	else{redirect('initiative/input_initiative/'.$segment);}
        }
    }
	
	public function detail(){
		$data['title'] = 'Detail Initiative';
    	
    	$user = $this->session->userdata('user');
    	
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		$init_id = $this->uri->segment(3);
		
		$views['init'] = $this->minitiative->get_initiative_by_id($init_id);
		$views['init_status'] = $this->minitiative->get_initiative_status_only($views['init']);
		$views['wb_status'] = $this->minitiative->get_init_workblocks_status($init_id);
		$views['info'] = $this->load->view('initiative/detail/_general_info',array(
		'initiative'=>$views['init'],'stat'=>$views['init_status'],'wb' => $views['wb_status']),TRUE);
		
		$remarks = $this->mremark->get_remarks_by_init_id($init_id);
		$views['remarks'] = $this->load->view('initiative/detail/_list_remarks',array('remarks'=>$remarks),TRUE);
		$views['form_rmrk'] = $this->load->view('initiative/detail/_form_remarks',array('remark'=>'','init_id'=>$init_id),TRUE);
		
		$workblocks = $this->mworkblock->get_all_initiative_workblock($init_id);
		$views['wb'] = $this->load->view('initiative/detail/_list_workblocks',array('workblocks'=>$workblocks,'init_id'=>$init_id),TRUE);
		
		$views['form_wb'] = $this->load->view('initiative/detail/_form_workblocks',array('wb'=>'','init_id'=>$init_id),TRUE);
		$form_prog = $this->load->view('initiative/detail/_form_progress',array(),TRUE);
		
		$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['sidebar'] = $this->load->view('shared/sidebar_2','',TRUE);
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('initiative/detail',$views,TRUE);
		$this->load->view('front',$data);
	}
	
	public function submit_remark(){
    	$init_id = $this->uri->segment(3);
    	$user = $this->session->userdata('user');
    	$program['initiative_id'] = $init_id;
    	$program['content'] = $this->input->post('remark');
    	$program['user_id'] = $user['id'];
    	$program['created'] = date('Y-m-d h:i:s');
        
        $id = $this->input->post('id');
        $user_id_to = $this->input->post('user_id');

        if($id){
        	if($this->mremark->update_remark($program,$id)){
        		$json['status'] = 1;
        	}
        	else{$json['status'] = 0;}
        }
        else{
        	if($this->mremark->insert_remark($program)){
        		$initiative=$this->minitiative->get_initiative_by_id($init_id);
        		$content = "".$user['name']." </b> Komentar pada Deliverable <b>".$initiative->init_title."</b> <br>Yaitu:".$program['content']."";
        		insert_notification($this,$content,$user_id_to,$init_id);
        		$json['status'] = 1;
        	}
        	else{$json['status'] = 0;}
		}
                
		$remarks = $this->mremark->get_remarks_by_init_id($init_id);
		$content = $this->load->view('initiative/detail/_list_remarks',array('remarks'=>$remarks),TRUE);
		$json['html'] = $content;
		$json['id'] = $init_id;
		
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function edit_remark(){
		$id = $this->input->get('id');
		$init = $this->input->get('init');
		$user_id = $this->input->get('user_id');

    	if($id){
			$remark = $this->mremark->get_remark_by_id($id); 
			if($remark){
				$json['status'] = 1;
				$json['html'] = $this->load->view('initiative/detail/_form_remarks',array('remark'=>$remark,'init_id'=>$init,'user_id'=>$user_id),TRUE);
			}else{
				$json['status'] = 0;
			}
		}
		else{
			$json['status'] = 1;
			$json['html'] = $this->load->view('initiative/detail/_form_remarks',array('remark'=>'','init_id'=>$init,'user_id'=>$user_id),TRUE);
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function delete_remark(){
        if($this->mremark->delete_remark()){
    		$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}

	public function detail_wb(){
		$init_id = $this->input->get('id');
		$init_code = $this->input->get('init_code');
		
		$user_init = $this->muser->get_user_by_init_code($init_code);
		$views['init'] = $this->minitiative->get_initiative_by_id($init_id);
		$views['init_status'] = $this->minitiative->get_initiative_status_only($views['init']);
		$views['wb_status'] = $this->minitiative->get_init_workblocks_status($init_id);
		$views['wb_total'] = count($this->minitiative->get_wb_total($init_id));
		$json['info'] = $this->load->view('initiative/detail/_general_info',array(
		'initiative'=>$views['init'],'stat'=>$views['init_status'],'wb' => $views['wb_status'], 'wb_total' => $views['wb_total']),TRUE);
		
		$remarks = $this->mremark->get_remarks_by_init_id($init_id);
		$json['remarks'] = $this->load->view('initiative/detail/_list_remarks',array('remarks'=>$remarks,'user_init'=>$user_init),TRUE);
		//$views['form_rmrk'] = $this->load->view('initiative/detail/_form_remarks',array('remark'=>'','init_id'=>$init_id),TRUE);
		
		
		$workblocks = $this->mworkblock->get_all_initiative_workblock($init_id);
		$json['html'] = $this->load->view('initiative/detail/_list_workblocks',array('workblocks'=>$workblocks,'init_id'=>$init_id,'user_init'=>$user_init),TRUE);
		$json['status'] = 1;
		/*$views['form_wb'] = $this->load->view('initiative/detail/_form_workblocks',array('wb'=>'','init_id'=>$init_id),TRUE);
		$form_prog = $this->load->view('initiative/detail/_form_progress',array(),TRUE);*/
	
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
    
    public function segment(){
    	$data['title'] = 'Recapt Segment';
    	
    	$user = $this->session->userdata('user');
    	
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		$data_content['segment_status'] = $this->minitiative->get_all_segments_status();
		
		$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['sidebar'] = $this->load->view('shared/sidebar_2','',TRUE);
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('initiative/segment',$data_content,TRUE);
		$this->load->view('front',$data);
    }
    
}
