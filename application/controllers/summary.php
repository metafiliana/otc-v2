<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Summary extends CI_Controller {
    
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
        //$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
        $data['content'] = $this->load->view('summary/all',$views,TRUE);

        $this->load->view('front',$data);
    }

    public function program_list()
    {
        $data['title'] = "Summary List";
        
        $prog['page']="all";

        $user = $this->session->userdata('user');
        $prog['user'] = $user;
        $pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);

        $init_id = null; //init
        
        $views['pmo_head_list'] = $this->mprogram->get_all_pmo_head();
        $views['dir_spon_list'] = $this->mprogram->get_all_dir_spon();
        $views['co_pmo_list'] = $this->muser->get_all_co_pmo();
        // var_dump($views['pmo_head_list']);die;

        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['header'] = $this->load->view('shared/header-new','',TRUE);
        //$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
        $data['content'] = $this->load->view('summary/list',$views,TRUE);

        $this->load->view('front',$data);
    }

    public function listDetailProgram()
    {
        $nama = $this->input->get('nama');
        $role = $this->input->get('role');

        // if($role == "category"){
        //     $data['programs'] = $this->mprogram->get_segment_programs($filter,'','','');
        // }

        if($role == "dir_spon" || $role == "pmo_head"){
            $data['programs'] = $this->mprogram->getProgramByRole($nama, $role);
        }

        // if($code=="co_pmo"){
        //     $data['programs'] = $this->mprogram->get_segment_programs('',$filter,'','');
        // }
        
        // $data['user'] = $this->session->userdata('user');

        $json['html'] = $this->load->view('summary/_program',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function listDetailInitiative()
    {
        $id = $this->input->get('id');

        // if($role == "category"){
        //     $data['programs'] = $this->mprogram->get_segment_programs($filter,'','','');
        // }

        // if($role == "dir_spon" || $role == "pmo_head"){
        $data['initiatives'] = $this->minitiative->getInitiativeByProgramId($id);
        // }

        // if($code=="co_pmo"){
        //     $data['programs'] = $this->mprogram->get_segment_programs('',$filter,'','');
        // }
        
        // $data['user'] = $this->session->userdata('user');

        $json['html'] = $this->load->view('summary/_initiative',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function listDetailWorkblock()
    {
        $id = $this->input->get('id');

        // if($role == "category"){
        //     $data['programs'] = $this->mprogram->get_segment_programs($filter,'','','');
        // }

        // if($role == "dir_spon" || $role == "pmo_head"){
        $data['workblocks'] = $this->mworkblock->getWorkblocksByInitiativeId($id);
        // }

        // if($code=="co_pmo"){
        //     $data['programs'] = $this->mprogram->get_segment_programs('',$filter,'','');
        // }
        
        // $data['user'] = $this->session->userdata('user');

        $json['html'] = $this->load->view('summary/_workblocks',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function isiworkblock()
    {
        $this->mworkblock->insertStatus();
    }

}