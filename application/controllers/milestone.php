<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Milestone extends CI_Controller {
    
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
    
    public function submit_milestone(){
      	$id = $this->uri->segment(3);
      	$program['title'] = $this->input->post('title');
        $program['workblock_id'] = $this->input->post('workblock');
        $program['status'] = $this->input->post('status');
        $program['reason'] = $this->input->post('reason');
        
        if($this->input->post('start')){$start = DateTime::createFromFormat('m/d/Y', $this->input->post('start'));
    		$program['start'] = $start->format('Y-m-d');
    	}
    	
    	if($this->input->post('end')){$end = DateTime::createFromFormat('m/d/Y', $this->input->post('end'));
    		$program['end'] = $end->format('Y-m-d');
    	}
    	
    	if($this->input->post('revised')){
    		$revised = DateTime::createFromFormat('m/d/Y', $this->input->post('revised'));
    		$program['revised'] = $revised->format('Y-m-d');
        }
        
        if(!$id){
        	if($this->mmilestone->insert_milestone($program)){
        		redirect("workblock/detail_workblock/".$program['workblock_id']);
        	}else{redirect("workblock/detail_workblock/".$program['workblock_id']);}
        }
        else{
        	if($this->mmilestone->update_milestone($program,$id)){
        		redirect("workblock/detail_workblock/".$program['workblock_id']);
        	}else{redirect("workblock/detail_workblock/".$program['workblock_id']);}
		}
    }
    
    
    
    public function submit_revised(){
    	$id = $this->uri->segment(3);
    	$wb = $this->uri->segment(4);
    	$revid = $this->input->post('rev_id');
    	$program['milestone_id'] = $id;
    	$program['reason'] = $this->input->post('reason');
    	$program['action'] = $this->input->post('action');
    	if($this->input->post('revised')){
    		$revised = DateTime::createFromFormat('m/d/Y', $this->input->post('revised'));
    		$program['revised_date'] = $revised->format('Y-m-d');
        }
        if(!$revid){
			if($this->mmilestone->insert_revised($program,$wb)){
				redirect("workblock/detail_workblock/".$wb);
			}else{redirect("workblock/detail_workblock/".$wb);}
		}
		else{
			$program['date_update']=date('Y-m-d h:i:s');
			$program['desc_GH']="";
			$program['aprv_GH']=null;
			if($this->mmilestone->update_revised($program,$revid)){
				redirect("workblock/detail_workblock/".$wb);
			}else{redirect("workblock/detail_workblock/".$wb);}
		}
    }
    
    public function aprove_revised(){
    	$aut = $this->uri->segment(3);
    	$id = $this->uri->segment(4);
    	$ms = $this->uri->segment(5);
    	$wb = $this->uri->segment(6);
    	if (isset($_POST['yes'])) {
			$revised['desc_'.$aut]="Approved";
		} else if (isset($_POST['no'])) {
			$revised['desc_'.$aut]="Rejected";
		}
		$revised[$aut.'_cmnt']=$this->input->post('cmnt_'.$aut);
		$revised['aprv_'.$aut]=date('Y-m-d');
		if($this->mmilestone->update_revised_and_end_date($revised,$id, $revised['desc_'.$aut])){
			redirect("workblock/detail_workblock/".$wb);
		}else{redirect("workblock/detail_workblock/".$wb);}
    } 
    
    public function change_status(){
    	$stat = $this->uri->segment(3);
    	$id = $this->uri->segment(4);
    	$wb = $this->uri->segment(5);
    	if($stat == "start"){$ms['status'] = "In Progress";}
    	elseif($stat == "end"){$ms['status'] = "Completed";}
    	
    	if($stat){
    		if($this->mmilestone->update_milestone($ms, $id)){
				redirect("workblock/detail_workblock/".$wb);
			}else{redirect("workblock/detail_workblock/".$wb);}
    	}
    }
    
    public function submit_timeline(){
    	$id = $this->uri->segment(3);
    	$user = $this->session->userdata('user');
    	$program['milestone_id'] = $id;
    	$program['content'] = $this->input->post('content');
    	$program['user_id'] = $user['id'];
    	$program['date_created'] = date('Y-m-d h:i:s');
        if($this->mmilestone->insert_timeline($program)){
			$json['status'] = 1;
			$tl = $this->mmilestone->get_timeline_by_ms_id($id);
    		$content = $this->load->view('milestone/content_timeline',array('tl'=>$tl),TRUE);
            $json['html'] = $content;
		}else{$json['status'] = 0;}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function submit_update_issue(){
    	$id = $this->uri->segment(3);
    	$user = $this->session->userdata('user');
    	$program['milestone_id'] = $id;
    	$program['issue'] = $this->input->post('content');
    	$program['user_id'] = $user['id'];
    	$program['date_created'] = date('Y-m-d h:i:s');
        if($this->mmilestone->insert_update_issue($program)){
			$json['status'] = 1;
			$ui = $this->mmilestone->get_update_issue_by_ms_id($id);
    		$content = $this->load->view('milestone/content_update_issue',array('ui'=>$ui),TRUE);
            $json['html'] = $content;
		}else{$json['status'] = 0;}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    
    public function delete_milestone(){
        if($this->mmilestone->delete_milestone()){
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
    	$ms = $this->mmilestone->get_milestone_by_id($id); 
    	$tl = $this->mmilestone->get_timeline_by_ms_id($id);
    	$content = $this->load->view('milestone/content_timeline',array('tl'=>$tl),TRUE);
		if($ms){
			$json['status'] = 1;
            $json['html'] = $this->load->view('milestone/timeline',array('ms'=>$ms, 'cnt'=>$content),TRUE);
            $json['title'] = $ms->title;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
	
	public function get_notes_delay(){
		$id = $this->input->get('id');
    	$ms = $this->mmilestone->get_milestone_by_id($id); 
    	$aprv = $this->mmilestone->get_milestone_approved($id);
		if($ms){
			$json['status'] = 1;
            $json['message'] = $this->load->view('milestone/notes_delay',array('aprv'=>$aprv),TRUE);
            $json['title'] = $ms->title;
		}else{
			$json['status'] = 0;
		}
		$this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
	}
}
