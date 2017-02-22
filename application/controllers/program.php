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
    	$segment = $this->uri->segment(3);
    	if(!$segment){$segment = "Accelerate the growth segment";}
    	$data['title'] = "List ".$segment." Program";
    	$prog['arr_categ'] = $this->mfiles_upload->get_distinct_col("category","asc","program");
		
		$user = $this->session->userdata('user');
		$prog['user'] = $user;
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);

		$segment = str_replace("%20"," ",$segment); 
		
		$prog['programs'] = $this->mprogram->get_segment_programs($segment);
		$prog['segment'] = $segment;
		//$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
		$data['content'] = $this->load->view('program/list_program',$prog,TRUE);

		$this->load->view('front',$data);
    }

    public function input_program(){
    	$data['title'] = "Input Program";
		
		$user = $this->session->userdata('user');
		$pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);

		$data['arr_segment'] = $this->mfiles_upload->get_distinct_col("segment","asc","program");
		$data['code'] = $this->mfiles_upload->get_distinct_col("code","asc","program");
		$data['init_code'] = $this->mfiles_upload->get_distinct_col("init_code","asc","program");
		$data['category'] = $this->mfiles_upload->get_distinct_col("category","asc","program");

		$data['header'] = $this->load->view('shared/header',array('user' => $user,'pending'=>$pending_aprv),TRUE);	
		$data['footer'] = $this->load->view('shared/footer','',TRUE);
		$data['sidebar'] = $this->load->view('shared/sidebar','',TRUE);
		//$data['content'] = $this->load->view('initiative/input_program',$data,TRUE);

		//$this->load->view('front',$data);

		$json['html'] = $this->load->view('initiative/input_program',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }
    
    public function submit_program(){
      	$program['title'] = $this->input->post('title');
        $program['code'] = $this->input->post('code');
        $program['segment'] = $this->input->post('segment');
        $program['init_code'] = $this->input->post('init_code');
        $program['category'] = $this->input->post('category');
        
        if($this->minitiative->insert_program($program)){
        	redirect('program/list_program');
        }else{redirect('program/input_program');}
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
	
	public function input_data_segment(){
		//$segment = $this->uri->segment(3);
    	//$exel = $this->read_excel("Data Segment ".$segment.".xlsx",1);
    	$exel = $this->read_excel("Program.xlsx");
    	$arrres = array(); $s=0;
    	//if($this->mnasabah->empty_table('nasabah')){
		for ($row = 2; $row <= $exel['row']; ++$row) {
			$data = "";
			for ($col = 0; $col < $exel['col']; ++$col) {
				$arrres[$row][$col] = $exel['wrksheet']->getCellByColumnAndRow($col, $row)->getValue();
			}
			
			$data['category'] = $arrres[$row][0];
			$data['segment'] = $arrres[$row][1];
			$data['title'] = $arrres[$row][2];
			$data['code'] = $arrres[$row][3];
			$data['init_code'] = $arrres[$row][4];
			$this->mprogram->insert_program($data);

			/*if($arrres[$row][2]=="P"){
				$prog_id_yes = $data['code'];
				$data['segment'] = $segment;
				$prog = $this->mprogram->get_program_by_code($data['code']);
				if($prog){
					$this->mprogram->update_program($data,$prog->id);
				}
				else{
					$this->mprogram->insert_program($data);
				}
			}
			elseif($arrres[$row][2]=="I"){
				$init_id_yes = $data['code'];
				$data['start'] = date("Y-m-d",excelDateToDate($arrres[$row][4]));
				$data['end'] = date("Y-m-d",excelDateToDate($arrres[$row][5]));
				$data['kickoff'] = $arrres[$row][7];
				$data['completion'] = $arrres[$row][8];
				$data['status'] = $arrres[$row][9];
				$data['pic'] = $arrres[$row][3];
				$int = $this->minitiative->get_initiative_by_code($data['code']);
				if($int){
					$this->minitiative->update_initiative($data,$int->id);
				}
				else{
					$prog_int = $this->mprogram->get_program_by_code($prog_id_yes);
					$data['program_id'] = $prog_int->id;
					$this->minitiative->insert_initiative($data);
				}
				
			}
			elseif($arrres[$row][2]=="W"){
				$data['start'] = date("Y-m-d",excelDateToDate($arrres[$row][4]));
				$data['end'] = date("Y-m-d",excelDateToDate($arrres[$row][5]));
				$data['pic'] = $arrres[$row][3];
				$wb = $this->mworkblock->get_workblock_by_code($data['code']);
				if($wb){
					$this->mworkblock->update_workblock($data,$wb->id);
				}
				else{
					$int_wb = $this->minitiative->get_initiative_by_code($init_id_yes);
					$data['initiative_id'] = $int_wb->id;
					$this->mworkblock->insert_workblock($data);
				}
				
			}*/
			
			/*$nasabah['company'] = $arrres[$row][1];
			$nasabah['group'] = $arrres[$row][2];
			$nasabah['sector'] = $arrres[$row][3];
			$nasabah['gas'] = $arrres[$row][4];
			$nasabah['oldbuc'] = $arrres[$row][5];
			$nasabah['newbuc'] = $arrres[$row][6];
			$nasabah['rm'] = $arrres[$row][7];
			$nasabah['loan'] = $arrres[$row][8];
			$nasabah['dana'] = $arrres[$row][9];
			$nasabah['ncl'] = $arrres[$row][10];*/
			
			//$this->mnasabah->insert_nasabah($nasabah);
		}
		//}
    }

    public function input_data_new_corplan(){
		$segment = $this->uri->segment(3);
    	$exel = $this->read_excel("new data.xlsx",1);
    	$arrres = array(); $s=0;
    	//if($this->mnasabah->empty_table('nasabah')){
    	$pv_categ = ""; $pv_initiative = ""; $pv_sub_init = ""; $pv_deliv = "";
		for ($row = 3; $row <= $exel['row']; ++$row) {
			$data = "";
			for ($col = 0; $col < $exel['col']; ++$col) {
				$arrres[$row][$col] = $exel['wrksheet']->getCellByColumnAndRow($col, $row)->getValue();
			}

			$end = date("Y-m-d",excelDateToDate($arrres[$row][8]));;
			$start = date("Y-m-d",excelDateToDate($arrres[$row][7]));;
			$action = $arrres[$row][6];
			$deliv = $arrres[$row][5];
			$sub_init = $arrres[$row][4];
			$code = $arrres[$row][3];
			$initiative = $arrres[$row][2];
			$init_code = $arrres[$row][1];
			$categ = $arrres[$row][0];

			if($sub_init && $sub_init != $pv_sub_init){
				$program['title'] = $sub_init;
				$program['code'] = $code;
				$program['segment'] = $initiative;
				$program['init_code'] = $init_code;
				$program['category'] = $categ;

				$pv_sub_init_id = $this->mfiles_upload->insert_db($program,"program");
				$pv_sub_init = $sub_init;
			}

			if($deliv && $deliv != $pv_deliv){
				$init_arr['title'] = $deliv;
				$init_arr['program_id'] = $pv_sub_init_id;

				$pv_deliv_id = $this->mfiles_upload->insert_db($init_arr,"initiative");
				$pv_deliv = $deliv;
			}

			$workblock['title'] = $action;
			$workblock['initiative_id'] = $pv_deliv_id;
			$workblock['start'] = $start;
			$workblock['end'] = $end;

			$wb_id = $this->mfiles_upload->insert_db($workblock,"workblock");
			/*
			$data['title'] = $arrres[$row][1];
			$data['code'] = $arrres[$row][0];
			$data['description'] = $arrres[$row][6];
			//$data['tier'] = $arrres[$row][1];
			if($arrres[$row][2]=="P"){
				$prog_id_yes = $data['code'];
				$data['segment'] = $segment;
				$prog = $this->mprogram->get_program_by_code($data['code']);
				if($prog){
					$this->mprogram->update_program($data,$prog->id);
				}
				else{
					$this->mprogram->insert_program($data);
				}
			}
			elseif($arrres[$row][2]=="I"){
				$init_id_yes = $data['code'];
				$data['start'] = date("Y-m-d",excelDateToDate($arrres[$row][4]));
				$data['end'] = date("Y-m-d",excelDateToDate($arrres[$row][5]));
				$data['kickoff'] = $arrres[$row][7];
				$data['completion'] = $arrres[$row][8];
				$data['status'] = $arrres[$row][9];
				$data['pic'] = $arrres[$row][3];
				$int = $this->minitiative->get_initiative_by_code($data['code']);
				if($int){
					$this->minitiative->update_initiative($data,$int->id);
				}
				else{
					$prog_int = $this->mprogram->get_program_by_code($prog_id_yes);
					$data['program_id'] = $prog_int->id;
					$this->minitiative->insert_initiative($data);
				}
				
			}
			elseif($arrres[$row][2]=="W"){
				$data['start'] = date("Y-m-d",excelDateToDate($arrres[$row][4]));
				$data['end'] = date("Y-m-d",excelDateToDate($arrres[$row][5]));
				$data['pic'] = $arrres[$row][3];
				$wb = $this->mworkblock->get_workblock_by_code($data['code']);
				if($wb){
					$this->mworkblock->update_workblock($data,$wb->id);
				}
				else{
					$int_wb = $this->minitiative->get_initiative_by_code($init_id_yes);
					$data['initiative_id'] = $int_wb->id;
					$this->mworkblock->insert_workblock($data);
				}
				
			}
			
			/*$nasabah['company'] = $arrres[$row][1];
			$nasabah['group'] = $arrres[$row][2];
			$nasabah['sector'] = $arrres[$row][3];
			$nasabah['gas'] = $arrres[$row][4];
			$nasabah['oldbuc'] = $arrres[$row][5];
			$nasabah['newbuc'] = $arrres[$row][6];
			$nasabah['rm'] = $arrres[$row][7];
			$nasabah['loan'] = $arrres[$row][8];
			$nasabah['dana'] = $arrres[$row][9];
			$nasabah['ncl'] = $arrres[$row][10];*/
			
			//$this->mnasabah->insert_nasabah($nasabah);
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

    /*private function read_excel($file,$sheet){
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
    }*/
    
}
