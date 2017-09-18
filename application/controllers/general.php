<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class General extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mworkblock');
        $this->load->model('mmilestone');
        $this->load->model('mremark');
        $this->load->model('mfiles_upload');
        $this->load->model('mkuantitatif');
        $this->load->model('mprogram');
        $this->load->model('minitiative');
        $this->load->model('mworkblock');
        $this->load->model('muser');

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

    public function get_file(){
        $init_code = $this->input->get('init_code');

        $data['files'] = $this->mfiles_upload->get_all_files_upload_modul_how($init_code,'');

        $json['html'] = $this->load->view('general/_files',$data,TRUE);
        $json['status'] = 1;

        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }

    public function delete_file(){
        $id = $this->input->get('id');
        if($id){
            $this->mfiles_upload->delete_with_files($id);
            $json['status'] = true;
        }
        else
        {
             $json['status'] = false;
        }
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
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

    public function form_input_file()
    {
        $data['title'] = "Form Input File";

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

        //$data['initiative']=$this->mfiles_upload->get_files_upload_by_ownership_id('program','','1');
        //$data['deliverable']=$this->mfiles_upload->get_files_upload_by_ownership_id('initiative','','1');
        $data['action']=$this->mfiles_upload->get_files_upload_by_ownership_id('action','','1');
        $data['user']=$this->mfiles_upload->get_files_upload_by_ownership_id('user','','1');
        $data['kuantitatif']=$this->mfiles_upload->get_files_upload_by_ownership_id('kuantitatif','','1');
        //$data['kuantitatif_update']=$this->mfiles_upload->get_files_upload_by_ownership_id('kuantitatif_update','','1');

        $data['header'] = $this->load->view('shared/header-new',$data,TRUE);
        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('general/form_input_file',$data,TRUE);

        $this->load->view('front',$data);

    }

    public function submit_input_file()
    {
        $file['for'] = $this->input->post('file_for');
        $year = $this->input->post('year');

        $date_now = new DateTime();

        $filename = $file['for']."_".$year."_".$date_now->getTimestamp();
        $upload_path = "assets/uploads/".$file['for']."/";

        // Check upload path directory and create if not apc_exists(keys)
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        /* Get previous files same date
        $filepattern = $file['for'] . "_" . $year . "_*";
        $oldfiles = glob("$upload_path/$filepattern");*/

        $json = array();

        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => "*",
            'overwrite' => TRUE,
            'max_size' => "2048000000",
            'file_name' => $filename
        );
        $this->load->library('upload', $config);

        if($this->mfiles_upload->get_files_upload_by_ownership_id($file['for'],$year,"1"))
        {
            $this->mfiles_upload->delete_with_files_ownership("1",$file['for'],$year);
        }
        if($this->upload->do_upload())
        {
            /* Safely delete previous files same date
            foreach ($oldfiles as $oldfile) {
                @unlink($oldfile);
            }*/
            $arr_month=['January','February','March','April','May','June','July','August','September','October','November','December'];
            $file_uploaded = $this->upload->data();
            $file_address = $upload_path.$filename.$file_uploaded['file_ext'];

            $program['title']=$file['for'].$year;
            $this->mfiles_upload->insert_files_upload_with_full_url_with_param($upload_path, $file['for'], $year, $file_uploaded,"1", $program);

            $exel = $this->mfiles_upload->read_excel($file_address);
            $arrres = array(); $s=0;
            if($file['for']!='user'){
                $this->mfiles_upload->delete_db_truncate($file['for']);
            }
                if($file['for']=='action'){
                    for ($row = 2; $row <= $exel['row']; ++$row) {
                    $data = "";
                    for ($col = 0; $col < $exel['col']; ++$col) {
                    $arrres[$row][$col] = $exel['wrksheet']->getCellByColumnAndRow($col, $row)->getValue();
                    }
                        $data['title'] = $arrres[$row][0];
                        $data['initiative_id'] = $arrres[$row][4];
                        $data['start_date'] = date("Y-m-d",$this->mfiles_upload->excelDateToDate($arrres[$row][2]));
                        $data['end_date'] = date("Y-m-d",$this->mfiles_upload->excelDateToDate($arrres[$row][3]));
                        $data['status'] = $arrres[$row][1];

                        $this->mworkblock->insert_workblock($data);
                    }
                }

                if($file['for']=='kuantitatif'){
                    $this->mfiles_upload->delete_db_truncate($file['for']);
                    $this->mfiles_upload->delete_db_truncate('kuantitatif_update');
                    for ($row = 2; $row <= $exel['row']; ++$row) {
                    $data = "";
                    for ($col = 0; $col < $exel['col']; ++$col) {
                    $arrres[$row][$col] = $exel['wrksheet']->getCellByColumnAndRow($col, $row)->getValue();
                    }
                        $data['init_code'] = $arrres[$row][0];
                        $data['type'] = $arrres[$row][1];
                        $data['init_id'] = $arrres[$row][2];
                        $data['metric'] = $arrres[$row][3];
                        $data['measurment'] = $arrres[$row][4];
                        $data['target'] = $arrres[$row][6];
                        $data['target_year'] = $year;
                        $i=1;
                        foreach ($arr_month as $val) {
                          $data[$val]= ($arrres[$row][$i+6]);
                          $i++;
                        }
                        $data['baseline'] = $arrres[$row][5];
                        $data['baseline_year'] = $year-1;
                        $this->mkuantitatif->insert_kuantitatif($data);

                        $update['year'] = $year;
                        $j=1;
                        foreach ($arr_month as $val) {
                          $update[$val]= $arrres[$row][$j+18];
                          $j++;
                        }
                        $this->mkuantitatif->insert_kuantitatif_update($update);
                    }
                }

                // if($file['for']=='kuantitatif_update'){
                //     $this->mfiles_upload->delete_db_truncate($file['for']);
                //     for ($row = 2; $row <= $exel['row']; ++$row) {
                //     $data = "";
                //     for ($col = 0; $col < $exel['col']; ++$col) {
                //     $arrres[$row][$col] = $exel['wrksheet']->getCellByColumnAndRow($col, $row)->getValue();
                //     }
                //         $data['year'] = $year;
                //         $j=1;
                //         foreach ($arr_month as $val) {
                //           $data[$val]= $arrres[$row][$j-1];
                //           $j++;
                //         }
                //         $this->mkuantitatif->insert_kuantitatif_update($data);
                //     }
                // }

                if($file['for']=='user'){
                    $array = array('id >' => '4');
                    $this->mfiles_upload->delete_db_where($array,$file['for']);
                    for ($row = 2; $row <= $exel['row']; ++$row) {
                    $data = "";
                    for ($col = 0; $col < $exel['col']; ++$col) {
                    $arrres[$row][$col] = $exel['wrksheet']->getCellByColumnAndRow($col, $row)->getValue();
                    }
                        $data['username'] = $arrres[$row][0];
                        $data['password'] = md5($arrres[$row][1]);
                        $data['name'] = $arrres[$row][2];
                        $data['role'] = $this->muser->get_id_m_role($arrres[$row][3])->id;
                        $data['work_email']= $arrres[$row][4];
                        $data['private_email']= $arrres[$row][5];
                        $data['initiative']= $arrres[$row][6];

                        $this->muser->insert_user($data);
                    }
                }
                $json['msg'] = "<div> Sukses </div> <a href='".base_url()."general/form_input_file/'>Back</a>";
        }
        else
        {
            $error = array('error' => $this->upload->display_errors());

            $json['msg'] = "<div class='alert alert-danger' role='alert'> ".$error['error']."</div>";
            $json['config'] = $config;
        }

        $this->output->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function input_data_segment(){
        //$segment = $this->uri->segment(3);
        $exel = $this->mfiles_upload->read_excel("initiative.xlsx");
        $arrres = array(); $s=0;
        //if($this->mnasabah->empty_table('nasabah')){
        for ($row = 2; $row <= $exel['row']; ++$row) {
            $data = "";
            for ($col = 0; $col < $exel['col']; ++$col) {
                $arrres[$row][$col] = $exel['wrksheet']->getCellByColumnAndRow($col, $row)->getValue();
            }

            //Program

            /*$data['category'] = $arrres[$row][0];
            $data['segment'] = $arrres[$row][1];
            $data['title'] = $arrres[$row][2];
            $data['code'] = $arrres[$row][3];
            $data['init_code'] = $arrres[$row][4];
            $data['dir_spon'] = $arrres[$row][5];
            $data['pmo_head'] = $arrres[$row][6];
            //$data['sort'] = $arrres[$row][7];

            $this->mprogram->insert_program($data);*/


            //Initiative
            /*$data['title'] = $arrres[$row][0];
            $data['program_id'] = $arrres[$row][1];
            $data['start'] = date("Y-m-d",$this->excelDateToDate($arrres[$row][2]));
            $data['end'] = date("Y-m-d",$this->excelDateToDate($arrres[$row][3]));
            $this->minitiative->insert_initiative($data);*/

            //Workblock
            /*$data['title'] = $arrres[$row][0];
            $data['initiative_id'] = $arrres[$row][3];
            $data['start'] = date("Y-m-d",$this->excelDateToDate($arrres[$row][1]));
            $data['end'] = date("Y-m-d",$this->excelDateToDate($arrres[$row][2]));
            $data['code'] = $arrres[$row][4];
            $data['status'] = $arrres[$row][5];
            $this->mworkblock->insert_workblock($data);*/
        }
    }

    public function input_data_kuantitatif(){
        $exel = $this->mfiles_upload->read_excel("Kuantitatif.xlsx");
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

}
