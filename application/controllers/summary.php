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
        $views['persen_initiative'] = 100/($this->mworkblock->get_count_workblock());
        // var_dump($views['persen_initiative']);die;
        $views['summary_not_started'] = $this->mworkblock->get_summary_all('Not Started Yet');
        $views['summary_delay'] = $this->mworkblock->get_summary_all('Delay');
        $views['summary_progress'] = $this->mworkblock->get_summary_all('In Progress');
        $views['summary_completed'] = $this->mworkblock->get_summary_all('Completed');

        $views['chart_data_action'] = $this->mworkblock->getDataChartAction();
        $views['persen_action'] = 100/($this->mworkblock->getCountDataChartAction());
        $views['summary_action_not_started'] = $this->mworkblock->get_summary_action_all('Not Started Yet');
        $views['summary_action_delay'] = $this->mworkblock->get_summary_action_all('Delay');
        $views['summary_action_progress'] = $this->mworkblock->get_summary_action_all('In Progress');
        $views['summary_action_completed'] = $this->mworkblock->get_summary_action_all('Completed');
        
        $views['chart_data_deliverable'] = $this->mworkblock->getDataChartDeliverable();
        $views['persen_deliverable'] = 100/($this->mworkblock->getCountDataChartDeliverable());
        $views['summary_deliverable_not_started'] = $this->mworkblock->get_summary_deliverable_all('Not Started Yet');
        $views['summary_deliverable_delay'] = $this->mworkblock->get_summary_deliverable_all('Delay');
        $views['summary_deliverable_progress'] = $this->mworkblock->get_summary_deliverable_all('In Progress');
        $views['summary_deliverable_completed'] = $this->mworkblock->get_summary_deliverable_all('Completed');
        // var_dump($views['persen_workstream']);die;

        $views['chart_data_workstream'] = $this->mworkblock->getDataChartWorkstream();
        // var_dump($views['chart_data_deliverable']);die;
        $views['persen_workstream'] = 100/($this->mworkblock->getCountDataChartWorkstream());
        $views['summary_workstream_not_started'] = $this->mworkblock->get_summary_workstream_all('Not Started Yet');
        $views['summary_workstream_delay'] = $this->mworkblock->get_summary_workstream_all('Delay');
        $views['summary_workstream_progress'] = $this->mworkblock->get_summary_workstream_all('In Progress');
        $views['summary_workstream_completed'] = $this->mworkblock->get_summary_workstream_all('Completed');
        // var_dump($views['chart_data_action']);exit();
        //$views['info'] = $this->load->view('initiative/detail/_general_info_old',array('initiative'=>$views['init'],'wb' => $views['wb_status'], 'summary_not_started' => $views['summary_not_started'], 'summary_delay' => $views['summary_delay'], 'summary_progress' => $views['summary_progress'], 'summary_completed' => $views['summary_completed']),TRUE);
        
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
        // $views['initiative_list'] = $this->muser->get_all_co_pmo();

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
            $data['programs'] = $this->mprogram->getInitCode($nama, $role);
        }

        if($role == "co_pmo"){
            $data['programs'] = $this->mprogram->getInitCode($nama, $role);
        }
        
        // $data['user'] = $this->session->userdata('user');

        $json['html'] = $this->load->view('summary/_program',$data,TRUE);
        $json['status'] = 1;
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function listDetailInitiative()
    {
        $id = $this->input->get('id');
        $data['init_code'] = $this->input->get('initcode');

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
        $data = $this->mworkblock->getWorkblocksByInitiativeId($id);
        // }

        // if($code=="co_pmo"){
        //     $data['programs'] = $this->mprogram->get_segment_programs('',$filter,'','');
        // }
        
        // $data['user'] = $this->session->userdata('user');

        // $json['html'] = $this->load->view('summary/_workblocks',$data,TRUE);
        // $json['status'] = 1;
        // $this->output->set_content_type('application/json')->set_output(json_encode($json));

        $string = "<ul class='list-group'>";
        $color_style = 'active';
        foreach ($data as $key => $value) {
            if ($value->status == 'Delay'){
                $color_style = 'danger';
            }
            if ($value->status == 'Completed'){
                $color_style = 'success';
            }
            if ($value->status == 'Not Started Yet'){
                $color_style = 'warning';
            }
            if ($value->status == 'In Progress'){
                $color_style = 'info';
            }
            $string .= "<li id='row-".$value->id."' class='list-group-item list-group-item-".$color_style."'>".$value->title." ( ".$value->status." )</li>";
        }
        $string .= "</ul>";

        $json['workblocks_list'] = $string;
        $json['status'] = 1;
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function isiworkblock()
    {
        $this->mworkblock->insertStatus();
    }

    public function getDetailProgram()
    {
        $init_code = $this->input->get('id');
        $data = $this->mprogram->getProgramByRole($init_code);

        $string = "<ul>";
        foreach ($data as $key => $value) {
            $string .= "<li><a class = 'filter-value-detail-initiative' data-id = '".$value['id']."' data-initcode = '".$value['init_code']."'>".$value['title']."</a></li>";
        }
        $string .= "</ul>";

        $json['detail_programs'] = $string;
        $json['status'] = 1;
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function front()
    {
        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['header'] = $this->load->view('shared/header-new','',TRUE);
        //$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
        $data['content'] = $this->load->view('summary/front',TRUE);
    }

}