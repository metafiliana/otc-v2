<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Agenda extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('muser');
        $this->load->model('magenda');
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
		$data['title'] = "Agenda";
		
		$user = $this->session->userdata('user');
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		if($this->uri->segment(3) && $this->uri->segment(4)){$month = $this->uri->segment(3); $year = $this->uri->segment(4);}
		else{$month = date('m'); $year = date('Y');}
		$agendas = $this->magenda->get_all_agenda_month($month, $year);
		
		$datereq['month'] = $month; $datereq['year']=$year;
		
		$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['sidebar'] = $this->load->view('shared/sidebar','',TRUE);
		$data['content'] = $this->load->view('agenda/index_agenda',array('agendas' => $agendas,'datereq'=>$datereq),TRUE);

		$this->load->view('front',$data);
    }
    
    public function change_month(){
    	$month = $this->input->post('month');
    	$year = $this->input->post('year');
    	redirect('agenda/index/'.$month."/".$year);
    }
    
    public function get_detail(){
       	$id = $this->input->get('id');
    	$agenda = $this->magenda->get_agenda_by_id($id); 
		if($agenda){
			$json['status'] = 1;
            $json['message'] = $data['content'] = $this->load->view('agenda/detail_agenda',array('agenda' => $agenda),TRUE);
            $json['title'] = $agenda->title;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
    
    public function input_agenda(){
    	$data['title'] = "Input Agenda";
		
		$user = $this->session->userdata('user');
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		$choose_date = "";
		
		if($this->uri->segment(3)&&$this->uri->segment(4)&&$this->uri->segment(5)){
			$choose_date = $this->uri->segment(3)."/".$this->uri->segment(4)."/".$this->uri->segment(5);
		}
		
		$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['sidebar'] = $this->load->view('shared/sidebar','',TRUE);
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('agenda/input_agenda',array('agenda' => '','choose_date'=>$choose_date),TRUE);

		$this->load->view('front',$data);
    }
    
    public function submit_agenda(){
      	$id = $this->uri->segment(3);
      	$user = $this->session->userdata('user');
      	
      	$program['title'] = $this->input->post('title');
        $program['location'] = $this->input->post('location');
        $program['description'] = $this->input->post('description');
        $program['maker_id'] = $user['id'];
        
        if($this->input->post('start')){$start = DateTime::createFromFormat('m/d/Y', $this->input->post('start'));
    		$program['start'] = $start->format('Y-m-d')." ".$this->input->post('start_time').":00";
    	}
    	
    	if($this->input->post('end')){$end = DateTime::createFromFormat('m/d/Y', $this->input->post('end'));
    		$program['end'] = $end->format('Y-m-d')." ".$this->input->post('end_time').":00";
    	}
        
        if($id){
        	if($this->minitiative->update_initiative($program,$id)){redirect('initiative/list_initiative/'.$segment);}
        	else{redirect('initiative/input_initiative/'.$segment);}
        }
        else{
        	if($this->magenda->insert_agenda($program)){redirect('agenda');}
        	else{redirect('agenda/input_agenda/');}
        }
    }
    
    public function delete_agenda(){
    	$id = $this->uri->segment(3);
    	if($id){
        	if($this->magenda->delete_agenda($id)){redirect('agenda/'.$segment);}
        	//else{redirect('initiative/input_initiative/'.$segment);}
        }
    }
    
    /*Initiative*/
    public function list_initiative(){
    	$data['title'] = "List All Initiatives";
		$segment = $this->uri->segment(3);
		
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
		$data['content'] = $this->load->view('initiative/list_initiative',array('ints' => $initiatives,'programs' => $programs, 'form_new' => $form_new),TRUE);

		$this->load->view('front',$data);
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
    
    /*Program*/
    public function list_programs(){
    	$data['title'] = "List All Initiatives";
		
		$user = $this->session->userdata('user');
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		$programs = $this->minitiative->get_all_programs();
		
		$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('initiative/list_program',array('programs' => $programs),TRUE);

		$this->load->view('front',$data);
    }
    
    public function input_program(){
    	$data['title'] = "List All Initiatives";
		
		$user = $this->session->userdata('user');
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		
		$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['content'] = $this->load->view('initiative/input_program',array(),TRUE);

		$this->load->view('front',$data);
    }
    
    public function submit_program(){
      	$program['title'] = $this->input->post('title');
        $program['code'] = $this->input->post('code');
        $program['segment'] = $this->input->post('segment');
        
        if($this->minitiative->insert_program($program)){
        	redirect('initiative/list_programs');
        }else{redirect('initiative/input_program');}
    }
    
    public function delete_program(){
        if($this->minitiative->delete_program()){
    		$json['status'] = 1;
    	}
    	else{
    		$json['status'] = 0;
    	}
    	$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
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
    	$descrp = $this->minitiative->get_initiative_by_id($id); 
		if($descrp){
			$json['status'] = 1;
            $json['message'] = $descrp->description;
            $json['title'] = $descrp->title;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
    
}
