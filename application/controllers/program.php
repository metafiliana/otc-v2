<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Program extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('minitiative');
        $this->load->model('mprogram');
        $this->load->model('mworkblock');
        $this->load->model('mremark');
        $this->load->model('mmilestone');
        $this->load->model('muser');
        $this->load->model('mfiles_upload');
        $this->load->model('mkuantitatif');
        $this->load->library('excel');

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
        redirect('program/list_programs');
    }

    /*Program*/
    public function list_programs(){
      $data['title'] = "List All Initiative";

  		$user = $this->session->userdata('user');
  		$prog['user'] = $user;
      $data['user'] = $user;

      //View list of initiative
      if($user['role']=='1'){
        $init_code= explode(";",$user['initiative']);
        $prog['programs'] = $this->mprogram->get_m_initiative($init_code);
      }
      else{
        $prog['programs'] = $this->mprogram->get_m_initiative('');
      }
      $prog['list_program'] = $this->load->view('program/component/_list_of_initiative_v2',$prog,TRUE);


      //notification
      if($user['role']!='2'){
          $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
          $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
      }
      else{
          $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
          $data['notif']= $this->mremark->get_notification_by_admin('');
      }

  		$data['footer'] = $this->load->view('shared/footer','',TRUE);
  		$data['header'] = $this->load->view('shared/header-v2',$data,TRUE);
  		$data['content'] = $this->load->view('program/list_program',$prog,TRUE);

  		$this->load->view('front',$data);
    }

    public function summary(){
        $data['title'] = "List All Program";

        $prog['page']="all";

        $user = $this->session->userdata('user');
        $prog['user'] = $user;
        $pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);

        $init_id = null; //init

        $views['init'] = $this->minitiative->get_initiative_by_id($init_id);
        // $views['init_status'] = $this->minitiative->get_initiative_status_only($views['init']);
        $views['wb_status'] = $this->minitiative->get_init_workblocks_status($init_id);
        $views['summary_not_started'] = $this->mworkblock->get_summary_all('Not Started Yet');
        $views['summary_delay'] = $this->mworkblock->get_summary_all('Delay');
        $views['summary_progress'] = $this->mworkblock->get_summary_all('In Progress');
        $views['summary_completed'] = $this->mworkblock->get_summary_all('Completed');
        // $views['info'] = $this->load->view('initiative/detail/_general_info_old',array('initiative'=>$views['init'],'stat'=>$views['init_status'],'wb' => $views['wb_status'], 'summary_not_started' => $views['summary_not_started'], 'summary_delay' => $views['summary_delay'], 'summary_progress' => $views['summary_progress'], 'summary_completed' => $views['summary_completed']),TRUE);
        $views['info'] = $this->load->view('initiative/detail/_general_info_old',array('initiative'=>$views['init'],'wb' => $views['wb_status'], 'summary_not_started' => $views['summary_not_started'], 'summary_delay' => $views['summary_delay'], 'summary_progress' => $views['summary_progress'], 'summary_completed' => $views['summary_completed']),TRUE);

        //$prog['programs'] = $this->mprogram->get_segment_programs('','','','');

        //$prog['list_program'] = $this->load->view('program/component/_list_of_program',$prog,TRUE);

        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['header'] = $this->load->view('shared/header-new','',TRUE);
        $data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
        $data['content'] = $this->load->view('program/summary',$views,TRUE);

        $this->load->view('front',$data);
    }

    public function my_inisiatif(){
    	$data['title'] = "My List Initiative";
    	$prog['arr_categ'] = $this->mfiles_upload->get_distinct_col("category","asc","program");

  		$prog['page']="my";

  		$user = $this->session->userdata('user');
  		$prog['user'] = $user;
  		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
  		$init_id= explode(";",$this->muser->get_user_by_id($user['id'])->initiative);

  		$prog['programs'] = $this->mprogram->get_segment_programs('',$init_id,'','');
  		$prog['indicator'] = $this->load->view('program/component/_indicator',$prog,TRUE);
  		$prog['list_program'] = $this->load->view('program/component/_list_of_program',$prog,TRUE);

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
  		$data['content'] = $this->load->view('program/list_program',$prog,TRUE);

  		$this->load->view('front',$data);
    }

    public function input_program(){
        $data['title'] = "Input Program";

        $id = $this->input->get('id');

        $user = $this->session->userdata('user');
        $pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);


        if($id){
            $data['all'] = $this->mprogram->get_program_by_id($id);
            $data['code']= $this->mprogram->get_program_by_init_code($data['all']->init_code);

        }
        else{
            $data['code'] = $this->mfiles_upload->get_distinct_col("code","asc","program");
        }

        $data['init_code'] = $this->mfiles_upload->get_distinct_col("init_code","asc","program");

        /*$data['arr_segment'] = $this->mfiles_upload->get_distinct_col("segment","asc","program");


        $data['category'] = $this->mfiles_upload->get_distinct_col("category","asc","program");
        $data['dir'] = $this->mfiles_upload->get_distinct_col("dir_spon","asc","program");
        $data['pmo'] = $this->mfiles_upload->get_distinct_col("pmo_head","asc","program");*/

        //$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);
        //$data['footer'] = $this->load->view('shared/footer','',TRUE);
        //$data['sidebar'] = $this->load->view('shared/sidebar','',TRUE);
        //$data['content'] = $this->load->view('initiative/input_program',$data,TRUE);

        //$this->load->view('front',$data);
        $data['all_list']=$this->load->view('initiative/form_all',$data,TRUE);

        $json['html'] = $this->load->view('initiative/input_program',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }

    //otc v2
    public function input_action(){
        $data['init_id'] = $this->input->get('init_id');
        $data['action_id'] = $this->input->get('action_id');

        if($data['action_id']){
          $data['title'] = "Edit Action";
          $data['action'] = $this->mprogram->get_action_by_init_code('',$data['action_id'])[0];
        }
        else{
          $data['title'] = "Add Action";
        }

        $json['html'] = $this->load->view('program/component/_form_action',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }

    public function filter_data(){
        $user = $this->session->userdata('user');
        $code = $this->input->get('code_filter');

        if($code=="category"){
            $data['arr'] = $this->mfiles_upload->get_distinct_col("category","asc","program");
        }

        if($code=="dir_spon"){
            $data['arr'] = $this->mfiles_upload->get_distinct_col("dir_spon","asc","program");
        }

        if($code=="pmo_head"){
            $data['arr'] = $this->mfiles_upload->get_distinct_col("pmo_head","asc","program");
        }

		if($code=="co_pmo"){
			$data['arr'] = $this->muser->get_user_co_pmo();
			$json['html'] = $this->load->view('program/component/_list_of_co_pmo',$data,TRUE);

		}

		if($code!="co_pmo"){
			$json['html'] = $this->load->view('program/component/_list_of_filter',$data,TRUE);
		}
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }

    public function change_code(){
        $data['code'] = $this->input->get('init_code');
        $data['all']= $this->mprogram->get_program_by_init_code($data['code'])[0];
        $json['html'] = $this->load->view('initiative/form_all',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }

    public function change_data(){
		$code = $this->input->get('code_filter');
		$filter = $this->input->get('filter');

        if($code=="category"){
            $data['programs'] = $this->mprogram->get_segment_programs($filter,'','','');
        }

        if($code=="dir_spon"){
            $data['programs'] = $this->mprogram->get_segment_programs('','',$filter,'');
        }

		if($code=="pmo_head"){
			$data['programs'] = $this->mprogram->get_segment_programs('','','',$filter);
		}

		if($code=="co_pmo"){
			$data['programs'] = $this->mprogram->get_segment_programs('',$filter,'','');
		}

		$data['user'] = $this->session->userdata('user');

		$json['html'] = $this->load->view('program/component/_list_of_program',$data,TRUE);
		$json['wb'] = $this->load->view('program/component/_indicator',$data,TRUE);
		$json['completed'] = $this->load->view('program/component/_completed',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }

    public function submit_program(){
        $id = $this->uri->segment(3);

        $program['title'] = $this->input->post('title');
        $program['code'] = $this->input->post('code');
        $program['segment'] = $this->input->post('segment');
        $program['category'] = $this->input->post('category');
        $program['init_code'] = $this->input->post('init_code');
        $program['dir_spon'] = $this->input->post('dir_spon');
        $program['pmo_head'] = $this->input->post('pmo_head');

        if($id){
            $this->mprogram->update_program($program,$id);
        }
        else{$this->minitiative->insert_program($program);}

        redirect('program/list_programs');
    }

    //otc v2
    public function submit_action(){
        $id = $this->uri->segment(3);

        $program['title'] = $this->input->post('title');
        $program['status'] = $this->input->post('status');
        $program['initiative_id'] = $this->input->post('initiative_id');
        if($this->input->post('start')){$start = DateTime::createFromFormat('m/d/Y', $this->input->post('start'));
      		$program['start_date'] = $start->format('Y-m-d');
      	}

      	if($this->input->post('end')){$end = DateTime::createFromFormat('m/d/Y', $this->input->post('end'));
      		$program['end_date'] = $end->format('Y-m-d');
      	}

        if($id){
          $this->mprogram->update_action($program,$id);
        }
        else{
          $this->mprogram->insert_action($program);
        }

        redirect('program/list_programs');
    }

    public function delete_program(){
        $id = $this->input->post('id');
        if($this->minitiative->delete_program($id)){
            $json['status'] = 1;
        }
        else{
            $json['status'] = 0;
        }
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }

    //otc v2
    public function delete_action(){
        $id = $this->input->post('id');
        if($this->mprogram->delete_action($id)){
            $json['status'] = 1;
        }
        else{
            $json['status'] = 0;
        }
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }

    public function detail_program(){
        $init_code = $this->input->get('init_code');

        $data['programs'] = $this->mprogram->get_segment_programs_by_init_code($init_code);

        $json['html'] = $this->load->view('program/component/_table',$data,TRUE);
        $json['status'] = 1;

        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }

    //otc v2
    public function detail_minitative(){
        $data['id'] = $this->input->get('id');

        $data['programs'] = $this->mprogram->get_action_by_init_code($data['id'],'');

        $json['html'] = $this->load->view('program/component/_detail_table_initative',$data,TRUE);
        $json['status'] = 1;

        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
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
