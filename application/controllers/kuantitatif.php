<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Kuantitatif extends CI_Controller {

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
    public function test()
    {
        $data['id'] = $this->input->get('id');
        $time=strtotime(date("Y-m-d"));
        $data['month_view']=date("F",$time);

        $data['leading'] = $this->mkuantitatif->get_leading($data['id'],$data['month_view']);
        $data['lagging'] = $this->mkuantitatif->lagging($data['id']);
        $json['html'] = $this->load->view('kuantitatif/component/_list_detail_kuantitatif',$data,TRUE);
        $json['status'] = 1;

        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($json));
    }
    public function index()
    {
        $data['title'] = "All Kuantitatif";

        $prog['page']="all";

        $user = $this->session->userdata('user');
        $prog['user'] = $user;
        $pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);

        $prog['programs'] = $this->mkuantitatif->get_kuantitatif_with_update('');
        $prog['total'] = $this->mkuantitatif->get_total_kuantatif('');
        $prog['init_code']=$this->mkuantitatif->get_init_code_on_kuantitatif();
        $prog['target_year']=$this->mkuantitatif->get_target_year_kuantitatif()->target_year;

        $prog['list_program'] = $this->load->view('kuantitatif/component/_list_of_kuantitatif',$prog,TRUE);

        $data['user']=$user;
        if($user['role']!='admin'){
            $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
            $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
        }
        else{
            $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
            $data['notif']= $this->mremark->get_notification_by_admin('');
        }
        //$this->mkuantitatif->get_kuantitatif_update_with_detail('1');

        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['header'] = $this->load->view('shared/header-new',$data,TRUE);
        $data['content'] = $this->load->view('kuantitatif/list_kuantitatif',$prog,TRUE);

        $this->load->view('front',$data);
    }

    public function list_kuantitatif()
    {
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
        $prog['list_program'] = $this->load->view('kuantitatif/component/_list_of_kuantitatif_v2',$prog,TRUE);


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
        $data['content'] = $this->load->view('kuantitatif/list_kuantitatif',$prog,TRUE);

        $this->load->view('front',$data);
    }

    public function my_kuantitatif()
    {
        $data['title'] = "My List Kuantitatif";

        $prog['page']="my";

        $user = $this->session->userdata('user');
        $prog['user'] = $user;
        $pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
        $init_id= explode(";",$this->muser->get_user_by_id($user['id'])->initiative);

        $prog['programs'] = $this->mkuantitatif->get_kuantitatif_with_update($init_id);
        $prog['total'] = $this->mkuantitatif->get_total_kuantatif($init_id);
        $prog['init_code']=$this->mkuantitatif->get_init_code_on_kuantitatif();
        $prog['target_year']=$this->mkuantitatif->get_target_year_kuantitatif()->target_year;

        $prog['all_count_wb'] = $this->mworkblock->get_count_workblock();
        $init = $this->mprogram->get_init_code();

        $prog['list_program'] = $this->load->view('kuantitatif/component/_list_of_kuantitatif',$prog,TRUE);

        $data['user']=$user;
        if($user['role']!='admin'){
            $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
            $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
        }
        else{
            $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
            $data['notif']= $this->mremark->get_notification_by_admin('');
        }

        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['header'] = $this->load->view('shared/header-new',$data,TRUE);
        $data['content'] = $this->load->view('kuantitatif/list_kuantitatif',$prog,TRUE);

        $this->load->view('front',$data);
    }

    public function input_kuantitatif(){
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $id_update = $this->input->get('id_update');

        $data['kuan_update']="";
        if($id){
            $data['kuantitatif'] = $this->mkuantitatif->get_kuantitatif_by_id($id);
            $data['update']= $this->mkuantitatif->get_kuantitatif_update($id);
        }
        else if($id_update){
            $data['kuan_update']= $this->mkuantitatif->get_update_by_id($id_update);
            $id=$data['kuan_update']->id_kuan;
            $data['update']= "";
            $data['kuantitatif'] = $this->mkuantitatif->get_kuantitatif_by_id($id);
        }

        $data['title'] = "Update Kuantitatif ".$type;

        if($type=="Realisasi"){
            $json['html'] = $this->load->view('kuantitatif/input_kuantitatif_'.$type,$data,TRUE);
        }
        else{
            $json['html'] = $this->load->view('kuantitatif/input_kuantitatif_'.$type,$data,TRUE);
        }

        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }

    public function submit_kuantitatif_update(){
        $id = $this->uri->segment(3);

        $program['id_kuan'] = $this->input->post('id');
        $program['year'] = $this->input->post('year');
        $program['month'] = $this->input->post('month');
        $program['amount'] = $this->input->post('amount');

        if($id){
            $this->mkuantitatif->update_kuantitatif_update($program,$id);
        }
        else{$this->mkuantitatif->insert_kuantitatif_update($program);}
        $user = $this->session->userdata('user');
        if($user['role']=='admin'){
            redirect('kuantitatif');
        }
        else{
            redirect('kuantitatif/my_kuantitatif');
        }

    }

    public function submit_target(){
        $program['id'] = $this->input->post('id');
        $program['metric'] = $this->input->post('metric');
        $program['target'] = $this->input->post('target');

        if($program['id']){
            $this->mkuantitatif->update_kuantitatif($program,$program['id']);
        }

        redirect('kuantitatif');
    }

    public function detail_update(){
        $id = $this->input->get('id');
        $year = $this->input->get('year');

        $data['title'] = "Detail Update Kuantitatif";

        if($id){
            $data['detail']= $this->mkuantitatif->get_kuantitatif_by_id($id);
            $data['update']= $this->mkuantitatif->get_all_kuantitatif_update($id,$year);
        }

        $json['html'] = $this->load->view('kuantitatif/component/_detail_update_kuantitatif',$data,TRUE);

        $json['status'] = 1;
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }

    public function delete_kuantitatif_update(){
        $id = $this->input->get('id');
        if($id){
            $this->mkuantitatif->delete_kuantitatif_update($id);
            $json['status'] = true;
        }
        else
        {
             $json['status'] = false;
        }
        $this->output->set_content_type('application/json')
                         ->set_output(json_encode($json));
    }

}
