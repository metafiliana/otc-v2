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
        
        $views['wb_status'] = $this->minitiative->get_init_workblocks_status($init_id);
        $views['persen_initiative'] = 100/($this->mworkblock->get_count_workblock());
        $views['summary_not_started'] = $this->mworkblock->get_summary_all('Not Started Yet');
        $views['summary_delay'] = $this->mworkblock->get_summary_all('Delay');
        $views['summary_progress'] = $this->mworkblock->get_summary_all('In Progress');
        $views['summary_completed'] = $this->mworkblock->get_summary_all('Completed');
        $views['total_summary_initiative'] = count($this->mprogram->get_all_program());

        $views['chart_data_action'] = $this->mworkblock->getDataChartAction();
        $views['persen_action'] = 100/($this->mworkblock->getCountDataChartAction());
        $views['summary_action_not_started'] = $this->mworkblock->get_summary_action_all('Not Started Yet');
        $views['summary_action_delay'] = $this->mworkblock->get_summary_action_all('Delay');
        $views['summary_action_progress'] = $this->mworkblock->get_summary_action_all('In Progress');
        $views['summary_action_completed'] = $this->mworkblock->get_summary_action_all('Completed');
        $views['total_summary_action'] = $this->mworkblock->get_count_workblock();
        
        $views['chart_data_deliverable'] = $this->mworkblock->getDataChartDeliverable();
        $views['persen_deliverable'] = 100/($this->mworkblock->getCountDataChartDeliverable());
        $views['summary_deliverable_not_started'] = $this->mworkblock->get_summary_deliverable_all('Not Started Yet');
        $views['summary_deliverable_delay'] = $this->mworkblock->get_summary_deliverable_all('Delay');
        $views['summary_deliverable_progress'] = $this->mworkblock->get_summary_deliverable_all('In Progress');
        $views['summary_deliverable_completed'] = $this->mworkblock->get_summary_deliverable_all('Completed');
        $views['total_summary_deliverable'] = count($views['summary_deliverable_not_started']) + count($views['summary_deliverable_delay']) + count($views['summary_deliverable_progress']) + count($views['summary_deliverable_completed']);

        $views['chart_data_workstream'] = $this->mworkblock->getDataChartWorkstream();
        $views['persen_workstream'] = 100/($this->mworkblock->getCountDataChartWorkstream());
        $views['summary_workstream_not_started'] = $this->mworkblock->get_summary_workstream_all('Not Started Yet');
        $views['summary_workstream_delay'] = $this->mworkblock->get_summary_workstream_all('Delay');
        $views['summary_workstream_progress'] = $this->mworkblock->get_summary_workstream_all('In Progress');
        $views['summary_workstream_completed'] = $this->mworkblock->get_summary_workstream_all('Completed');
        $views['total_summary_workstream'] = count($views['summary_workstream_not_started']) + count($views['summary_workstream_delay']) + count($views['summary_workstream_progress']) + count($views['summary_workstream_completed']);

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

        $prog['total'] = $this->mkuantitatif->get_total_kuantatif();
        $prog['asd'] = $this->mkuantitatif->get_init_code_on_kuantitatif(array('17b', '18'));
        
        $views['pmo_head_list'] = $this->mprogram->get_all_pmo_head();
        $views['dir_spon_list'] = $this->mprogram->get_all_dir_spon();
        $views['co_pmo_list'] = $this->muser->get_all_co_pmo();
        $views['initiative_list'] = $this->minitiative->getAllInitiative();

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
        //$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
        $data['content'] = $this->load->view('summary/list',$views,TRUE);

        $this->load->view('front',$data);
    }

    public function listDetailProgram()
    {
        $nama = $this->input->get('nama');
        $role = $this->input->get('role');
        
        $data['programs'] = $this->mprogram->getInitCode($nama, $role);

        $json['html'] = $this->load->view('summary/_program',$data,TRUE);
        $json['status'] = 1;

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function listDetailInitiative()
    {
        $id = $this->input->get('id');
        $data['init_code'] = $this->input->get('initcode');

        $data['initiatives'] = $this->minitiative->getInitiativeByProgramId($id);

        $json['html'] = $this->load->view('summary/_initiative',$data,TRUE);
        $json['status'] = 1;

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function listDetailWorkblock()
    {
        $id = $this->input->get('id');
        
        $data = $this->mworkblock->getWorkblocksByInitiativeId($id);

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

    public function listDetailKuantitatif()
    {
        $init = $this->input->get('init');
        $init_code = explode(";",$init);
        // $data['init_code'] = $this->input->get('initcode');

        // $data['kuantitatif'] = $this->mkuantitatif->get_kuantitatif_by_user($init_code)->result();
        $data['kuantitatif'] = $this->mkuantitatif->get_kuantitatif_with_update($init_code);
        $data['init_code'] = $init_code;

        $json['html'] = $this->load->view('summary/_kuantitatif',$data,TRUE);
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
            $total_complete = 0;
            $total_init = 0;
            $data_persen = $this->minitiative->getInitiativeByProgramId($value['id']);

            foreach ($data_persen as $key1 => $value1) {
                $total_complete = $total_complete + $value1->total_c;
                $total_init = $total_init + $value1->total_w;
            }
            $percent = 0;
            if ($total_init != 0){
                $percent_raw = ($total_complete / $total_init) * 100;
                $percent = number_format($percent_raw, 2, '.', '');
            }

            $string .= "<li><a class = 'filter-value-detail-initiative' data-id = '".$value['id']."' data-initcode = '".$value['init_code']."'>".$value['title']." (".$percent."%)</a></li>";
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