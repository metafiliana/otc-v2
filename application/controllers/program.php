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
    	//$segment = $this->uri->segment(3);
    	//if(!$segment){$segment = "Accelerate the growth segment";}
    	
    	$data['title'] = "List All Program";
    	//$prog['arr_categ'] = $this->mfiles_upload->get_distinct_col("category","asc","program");
		
    	$prog['page']="all";

		$user = $this->session->userdata('user');
		$prog['user'] = $user;
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);

		$prog['programs'] = $this->mprogram->get_segment_programs('','','','');
		$init = $this->mprogram->get_init_code();
		//$prog['kuantitatif'] = $this->mprogram->get_kuantitatif_by_init_code($init->init_code);
//        $init_code
		//$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$prog['list_program'] = $this->load->view('program/component/_list_of_program',$prog,TRUE);

		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
		$data['content'] = $this->load->view('program/list_program',$prog,TRUE);

		$this->load->view('front',$data);
    }

    public function summary(){
    	$data['title'] = "List All Program";
		
    	$prog['page']="all";

		$user = $this->session->userdata('user');
		$prog['user'] = $user;
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);

		$init_id = 1;
		
		$views['init'] = $this->minitiative->get_initiative_by_id($init_id);
		$views['init_status'] = $this->minitiative->get_initiative_status_only($views['init']);
		$views['wb_status'] = $this->minitiative->get_init_workblocks_status($init_id);
		$views['info'] = $this->load->view('initiative/detail/_general_info_old',array(
		'initiative'=>$views['init'],'stat'=>$views['init_status'],'wb' => $views['wb_status']),TRUE);
		
		//$prog['programs'] = $this->mprogram->get_segment_programs('','','','');

		//$prog['list_program'] = $this->load->view('program/component/_list_of_program',$prog,TRUE);

		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
		$data['content'] = $this->load->view('program/summary',$views,TRUE);

		$this->load->view('front',$data);
    }

    public function my_inisiatif(){
    	$data['title'] = "My List Program";
    	$prog['arr_categ'] = $this->mfiles_upload->get_distinct_col("category","asc","program");
		
		$prog['page']="my";
		
		$user = $this->session->userdata('user');
		$prog['user'] = $user;
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
		$init_id= explode(";",$this->muser->get_user_by_id($user['id'])->initiative);
		
		$prog['programs'] = $this->mprogram->get_segment_programs('',$init_id,'','');
		$prog['list_program'] = $this->load->view('program/component/_list_of_program',$prog,TRUE);

		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
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

		$json['html'] = $this->load->view('program/component/_list_of_filter',$data,TRUE);
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
		$user = $this->session->userdata('user');
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
		
		$data['user'] = $this->session->userdata('user');

		$json['html'] = $this->load->view('program/component/_list_of_program',$data,TRUE);
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
	
	public function input_data_segment(){
		//$segment = $this->uri->segment(3);
    	$exel = $this->read_excel("workblok.xlsx");
    	$arrres = array(); $s=0;
    	//if($this->mnasabah->empty_table('nasabah')){
		for ($row = 2; $row <= $exel['row']; ++$row) {
			$data = "";
			for ($col = 0; $col < $exel['col']; ++$col) {
				$arrres[$row][$col] = $exel['wrksheet']->getCellByColumnAndRow($col, $row)->getValue();
			}
			
			/*Program
			
			$data['category'] = $arrres[$row][0];
			$data['segment'] = $arrres[$row][1];
			$data['title'] = $arrres[$row][2];
			$data['code'] = $arrres[$row][3];
			$data['init_code'] = $arrres[$row][4];
			$data['dir_spon'] = $arrres[$row][5];
			$data['pmo_head'] = $arrres[$row][6];
			$data['sort'] = $arrres[$row][7];
			
			$this->mprogram->insert_program($data); */
			

			/*Initiative
			$data['title'] = $arrres[$row][0];
			$data['program_id'] = $arrres[$row][1];
			$data['start'] = date("Y-m-d",$this->excelDateToDate($arrres[$row][2]));
			$data['end'] = date("Y-m-d",$this->excelDateToDate($arrres[$row][3]));
			$this->minitiative->insert_initiative($data);*/
			
			//Workblock
			$data['title'] = $arrres[$row][0];
			$data['initiative_id'] = $arrres[$row][3];
			$data['start'] = date("Y-m-d",$this->excelDateToDate($arrres[$row][1]));
			$data['end'] = date("Y-m-d",$this->excelDateToDate($arrres[$row][2]));
			$data['code'] = $arrres[$row][4];
			$this->mworkblock->insert_workblock($data);
		}
    }

    public function input_data_kuantitatif(){
    	$exel = $this->read_excel("Kuantitatif.xlsx");
    	$arrres = array(); $s=0;
		for ($row = 2; $row <= $exel['row']; ++$row) {
			$data = "";
			for ($col = 0; $col < $exel['col']; ++$col) {
				$arrres[$row][$col] = $exel['wrksheet']->getCellByColumnAndRow($col, $row)->getValue();
			}
			$target="2017";
			//Kuantitatif
			$data['init_code'] = $arrres[$row][0];
			$data['title'] = $arrres[$row][1];
			$data['metric'] = $arrres[$row][2];
			$data['realisasi'] = $arrres[$row][3];
			$data['target'] = $arrres[$row][4];
			$data['real_year'] = $target-1;
			$data['target_year'] = $target;
			//date("Y-m-d",$this->excelDateToDate($arrres[$row][1]));
			//$data['end'] = date("Y-m-d",$this->excelDateToDate($arrres[$row][2]));
			$this->mkuantitatif->insert_kuantitatif($data);	
		}
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
