<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Summary extends CI_Controller {

    public $data_bulan = array(
                'January' => 1,
                'February' => 2,
                'March' => 3,
                'April' => 4,
                'May' => 5,
                'June' => 6,
                'July' => 7,
                'August' => 8,
                'September' => 9,
                'October' => 10,
                'November' => 11,
                'December' => 12,
            );

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
        $this->load->model('msummary');
        $this->load->model('magenda');
        $this->load->model('mt_action');
        $this->load->model('minfo');
        $this->load->library('excel');
        $this->load->helper('form');
        $this->load->helper('site_helper');

        $session = $this->session->userdata('user');

        if(!$session){
            redirect('user/login');
        }
    }

    /**
     * Method for page (public)
     */

    public function initSummary()
    {
        $this->msummary->insertDeliverable(); //uncomment to insert automatically summary base on data
        $this->msummary->insertWorkstream(); //uncomment to insert automatically summary base on data
        $this->msummary->insertInitiative(); //uncomment to insert automatically summary base on data

        redirect('summary/index');
    }

    public function index()
    {
        redirect('summary/home');
        // $this->initSummary(); //insert automatically summary base on data
        // $data['title'] = "List All Program";
        //
        // $prog['page']="all";
        //
        // $user = $this->session->userdata('user');
        // $prog['user'] = $user;
        // $pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);
        //
        // $init_id = null; //init
        //
        // $views['init'] = $this->minitiative->get_initiative_by_id($init_id);
        //
        // $views['summary_not_started'] = $this->mworkblock->get_summary_all('Not Started Yet');
        // $views['summary_delay'] = $this->mworkblock->get_summary_all('Delay');
        // $views['summary_progress'] = $this->mworkblock->get_summary_all('In Progress');
        // $views['summary_completed'] = $this->mworkblock->get_summary_all('Completed');
        // // $views['total_summary_initiative'] = count($this->mprogram->get_all_program(true, true));
        // // $views['wb_status'] = $this->mworkblock->getSummaryInit();
        // $views['total_summary_initiative'] = count($this->msummary->getAllInitiative());
        // $views['wb_status'] = $this->msummary->getSummaryInitiative();
        // $views['persen_initiative'] = 100/($views['total_summary_initiative']);
        //
        // $views['summary_action_not_started'] = $this->mworkblock->get_summary_action_all('Not Started Yet');
        // $views['summary_action_delay'] = $this->mworkblock->get_summary_action_all('Delay');
        // $views['summary_action_progress'] = $this->mworkblock->get_summary_action_all('In Progress');
        // $views['summary_action_completed'] = $this->mworkblock->get_summary_action_all('Completed');
        // $views['total_summary_action'] = $this->mworkblock->get_count_workblock();
        // $views['chart_data_action'] = $this->mworkblock->getDataChartAction();
        // $views['persen_action'] = 100/($this->mworkblock->getCountDataChartAction());
        //
        // $views['summary_deliverable_not_started'] = $this->mworkblock->get_summary_deliverable_all('Not Started Yet');
        // $views['summary_deliverable_delay'] = $this->mworkblock->get_summary_deliverable_all('Delay');
        // $views['summary_deliverable_progress'] = $this->mworkblock->get_summary_deliverable_all('In Progress');
        // $views['summary_deliverable_completed'] = $this->mworkblock->get_summary_deliverable_all('Completed');
        // // $views['total_summary_deliverable'] = count($this->minitiative->get_initiatives(true));
        // // $views['chart_data_deliverable'] = $this->mworkblock->getSummaryDeliverable();
        // $views['total_summary_deliverable'] = count($this->msummary->getAllDeliverable());
        // $views['chart_data_deliverable'] = $this->msummary->getSummaryDeliverable();
        // $views['persen_deliverable'] = 100/$views['total_summary_deliverable'];
        //
        // $views['summary_workstream_not_started'] = $this->mworkblock->get_summary_workstream_all('Not Started Yet');
        // $views['summary_workstream_delay'] = $this->mworkblock->get_summary_workstream_all('Delay');
        // $views['summary_workstream_progress'] = $this->mworkblock->get_summary_workstream_all('In Progress');
        // $views['summary_workstream_completed'] = $this->mworkblock->get_summary_workstream_all('Completed');
        // // $views['total_summary_workstream'] = count($this->mprogram->get_all_program(true));
        // // $views['chart_data_workstream'] = $this->mworkblock->getSummaryWorkstream();
        // $views['total_summary_workstream'] = count($this->msummary->getAllWorkstream());
        // $views['chart_data_workstream'] = $this->msummary->getSummaryWorkstream();
        // $views['persen_workstream'] = 100/($views['total_summary_workstream']);
        //
        // $data['user']=$user;
        // if($user['role']!='admin'){
        //     $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
        //     $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
        // }
        // else{
        //     $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
        //     $data['notif']= $this->mremark->get_notification_by_admin('');
        // }
        //
        // $data['footer'] = $this->load->view('shared/footer','',TRUE);
        // $data['header'] = $this->load->view('shared/header-new',$data,TRUE);
        // //$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
        // $data['content'] = $this->load->view('summary/all',$views,TRUE);
        //
        // $this->load->view('front',$data);
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

    public function listMilestone()
    {
      $users = $this->session->userdata('user');
      $user = $users['username'];
      $initid = $users['initiative'];
      $foto = $this->muser->get_data_user($user)->foto;
      $lastlogin = $this->muser->get_data_user($user)->last_login;
      $privateemail = $this->muser->get_data_user($user)->private_email;
      $workemail = $this->muser->get_data_user($user)->work_email;
      $data = array(
          'username' => $user,
          'foto' => $foto,
          'initid' => $initid,
          'last_login' => $lastlogin,
          'private_email' => $privateemail,
          'work_email' => $workemail
      );

      $data['title'] = "List Summary Milestone";

      $user = $users;
      $data['user']=$user;
      if($user['role']!='2'){
          $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
          $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
      }
      else{
          $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
          $data['notif']= $this->mremark->get_notification_by_admin('');
      }
        // views start
        $views = array();
        $info_last_summary = $this->minfo->getInfoLastUpdatedSummary();
        // $get_month = (!empty($info_last_summary->date)) ? $info_last_summary->date : date('Y-m-d');
        $get_month = $this->mkuantitatif->getLastMonthUpdated();
        // views end

        $is_admin = false;
        if ($user['role'] == 2){
            $is_admin = true;
        }
        $data['is_admin'] = $is_admin;

        //process start
        $data['init_table'] = $this->mt_action->getAllInitiative();
        $data['controller'] = $this;
        $data['bulan_search'] = date('F', strtotime($get_month));
        $data['user'] = null;
        $data['summary_info'] = $this->minfo->getInfoLastUpdatedSummary();
        //process end

        if ($_POST){
            if ($_POST['bulan']){
                $data['bulan_search'] = $_POST['bulan'];
            }

            if ($_POST['user']){
                $data_user = $this->muser->get_user_by_role($_POST['user']);
                $array_table = array();
                foreach ($data_user as $key => $value) {
                    $name = $value->name;
                    $id = $value->id;

                    if (strpos($value->initiative, ';')){
                        $array_initiative = explode(';', $value->initiative);
                        foreach ($array_initiative as $key1 => $value1) {
                            $object_table_raw = new StdClass();
                            $object_table_raw->name = $name;
                            $object_table_raw->id = $id;
                            $initiative = $this->minitiative->getInitiativeByCode($value1);
                            $object_table_raw->initiative = $initiative->id;
                            $object_table_raw->init_code = $value1;
                            array_push($array_table, $object_table_raw);
                        }
                    }else{
                        $object_table_raw = new StdClass();
                        $object_table_raw->name = $name;
                        $object_table_raw->id = $id;
                        if (!empty($value->initiative)){
                            $initiative = $this->minitiative->getInitiativeByCode($value->initiative);
                            if (!empty($initiative)){
                                $object_table_raw->initiative = $initiative->id;
                                $object_table_raw->init_code = $value->initiative;
                                array_push($array_table, $object_table_raw);
                            }
                        }
                    }
                }
                $data['init_table'] = $array_table;
                $data['user'] = $_POST['user'];
            }
        }

        $data['table_title'] = empty($_POST['user']) ? 0 : $_POST['user'];

        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['header'] = $this->load->view('shared/header-v2',$data,TRUE);
        //$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
        $data['content'] = $this->load->view('summary/milestone',$views,TRUE);

        $this->load->view('front',$data);
    }

    public function getStatus(
            $initiative_id,
            $status = false,
            $future = false,
            $flagged = false,
            $bulan = false,
            $user = false,
            // $overdue = false,
            $all = false,
            $admin = false
        )
    {
        $return = 0;
        // $future = false;

        if ($future){
            $return = $this->mt_action->getStatusFutureMilestone($initiative_id, $status, $bulan, $user, $all, $admin);
        }elseif ($flagged){
            // $return = $this->mt_action->getStatusFlaggedMilestone($initiative_id, $status, $bulan, $user);
            $return = $this->mt_action->getStatusIssueMilestone($initiative_id, $bulan, $user, $flagged, $all, $admin);
        // }elseif ($overdue){
        //     $return = $this->mt_action->getStatusOverdueMilestone($initiative_id, $bulan, $user);
        }else{
            $return = $this->mt_action->getStatusSummaryMilestone($initiative_id, $status, $bulan, $user, $all, $admin);
        }

        return $return;
    }

    public function listKuantitatif()
    {
      $users = $this->session->userdata('user');
      $user = $users['username'];
      $initid = $users['initiative'];
      $foto = $this->muser->get_data_user($user)->foto;
      $lastlogin = $this->muser->get_data_user($user)->last_login;
      $privateemail = $this->muser->get_data_user($user)->private_email;
      $workemail = $this->muser->get_data_user($user)->work_email;
      $data = array(
          'username' => $user,
          'foto' => $foto,
          'initid' => $initid,
          'last_login' => $lastlogin,
          'private_email' => $privateemail,
          'work_email' => $workemail
      );

      $data['title'] = "List Summary Kuantitatif";

      $user = $users;
      $data['user']=$user;
      if($user['role']!='2'){
          $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
          $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
      }
      else{
          $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
          $data['notif']= $this->mremark->get_notification_by_admin('');
      }
        // views start
        $views = array();
        $info_last_summary = $this->minfo->getInfoLastUpdatedSummary();
        // $get_month = (!empty($info_last_summary->date)) ? $info_last_summary->date : date('Y-m-d');
        $get_month = $this->mkuantitatif->getLastMonthUpdated();
        // views end

        $is_admin = false;
        if ($user['role'] == 2){
            $is_admin = true;
        }
        $data['is_admin'] = $is_admin;

        //process start
        $data['init_table'] = $this->getDataTableKuantitatif();
        $data['controller'] = $this;
        $data['bulan_search'] = date('F', strtotime($get_month));
        $data['user'] = null;
        $data['summary_info'] = $this->minfo->getInfoLastUpdatedSummary();
        //process end
        if ($_POST){
            if ($_POST['bulan']){
                $data['bulan_search'] = $_POST['bulan'];
            }

            if ($_POST['user']){
                $data['init_table'] = $this->getDataTableKuantitatifUser($_POST['user']);
                $data['user'] = $_POST['user'];
            }
        }

        $data['table_title'] = empty($_POST['user']) ? 0 : $_POST['user'];

        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['header'] = $this->load->view('shared/header-v2',$data,TRUE);
        //$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
        $data['content'] = $this->load->view('summary/kuantitatif',$views,TRUE);

        $this->load->view('front',$data);
    }

    public function countKuantitatif($initiative_id, $get = false, $user = false)
    {
        // keterangan get :
        // 1 = get milestone detail mtd
        // 2 = get milestone detail ytd

        $return = 0;

        if ($get === 1){ // mtd
            $jumlah = $this->mt_action->getMilestoneDetail($initiative_id, true, false, $user);
        }elseif ($get === 2){ // ytd
            $jumlah = $this->mt_action->getMilestoneDetail($initiative_id, false, true, $user);
        }

        $return = ($jumlah) ? $jumlah : 0;

        return $return;
    }

    public function getLeadingLagging($init_code, $type = false, $get = false, $month = null)
    {
        // keterangan get :
        // 1 = monthly
        // 2 = yearly

        // keterangan type :
        // 1 = Leading - String
        // 2 = Lagging - String

        // init bulan
        if (!$month){
            $data_kuantitatif = $this->mkuantitatif->getAllKuantitatifUpdate()->result_array();
            $bulan_now = date('F');
            $tahun_now = date('Y'); //belum pake condition tahun

            foreach ($data_kuantitatif as $key => $value) {
                if ($value[$bulan_now] > 0){
                    $month = $bulan_now;
                    break;
                }else{
                    if ($value['December'] > 0){
                        $month = 'December';
                        break;
                    }elseif ($value['November'] > 0){
                        $month = 'November';
                        break;
                    }elseif ($value['October'] > 0){
                        $month = 'October';
                        break;
                    }elseif ($value['September'] > 0){
                        $month = 'September';
                        break;
                    }elseif ($value['August'] > 0){
                        $month = 'August';
                        break;
                    }elseif ($value['July'] > 0){
                        $month = 'July';
                        break;
                    }elseif ($value['June'] > 0){
                        $month = 'June';
                        break;
                    }elseif ($value['May'] > 0){
                        $month = 'May';
                        break;
                    }elseif ($value['April'] > 0){
                        $month = 'April';
                        break;
                    }elseif ($value['March'] > 0){
                        $month = 'March';
                        break;
                    }elseif ($value['February'] > 0){
                        $month = 'February';
                        break;
                    }elseif ($value['January'] > 0){
                        $month = 'January';
                        break;
                    }
                }
            }
        }

        $datas = $this->mkuantitatif->getSummaryLeadingLaggingAll($init_code, $type, $get, $month);
        $count_data = $datas ? count($datas) : 1;
        $pembobotan = (1 / $count_data);
        $total = 0;
        $return = 0;
        $cap_leading = 1;
        $cap_lagging = 1.3;
        $legend = $this->mkuantitatif->get_id_different_sum_kuantitatif();

        if ($datas){
            if ($get === 2){ //yearly

                foreach ($datas as $key => $value) {
                    $target = ($value['target']) ? $value['target'] : 1;
                    $done = ($value[$month]) ? $value[$month] : 0;
                    if ($done > 0){
                        if (in_array($value['id'], $legend, true)){
                            $hasil = 1 - ($done/$target);
                        }else{
                            $hasil = $done / $target;
                        }

                        $total = $total + ($hasil * $pembobotan);
                    }
                }
            }

            if ($get === 1){ //monthly
                foreach ($datas as $key => $value) {
                    $target = ($value['target_month']) ? $value['target_month'] : 1;
                    $done = ($value[$month]) ? $value[$month] : 0;

                    if ($done > 0){
                        if (in_array($value['id'], $legend, true)){
                            $hasil = 1 - ($done/$target);
                        }else{
                            $hasil = $done / $target;
                        }
                        $total = $total + ($hasil * $pembobotan);
                    }
                }
            }

            if ($type == 'Leading'){
                $total = (($total) > $cap_leading) ? $cap_leading : $total;
            }else{
                $total = (($total) > $cap_lagging) ? $cap_lagging : $total;
            }
            $return = $total * 100;
        }

        $return = number_format($return, 2);

        return $return;
    }

    function getDataTableKuantitatif($user = false, $user_id = false)
    {
        if (!$user){
            $get_kuantitatif = $this->mkuantitatif->getSummaryKuantitatif();
        }else{
            if (!$user_id){
                $data_user = $this->muser->getInitiativeOnlyByRole($user);
            }else{
                $data_user = $this->muser->getInitiativeOnlyByUserId($user);
            }

            $data_initiative_user = array();
            foreach ($data_user as $key => $value) {
                $initiative_explode = explode(';', $value['initiative']);

                if (is_array($initiative_explode)){
                    foreach ($initiative_explode as $key1 => $value1) {
                        $data_initiative_user_code = $this->minitiative->getInitiativeByCode($value1);
                        if (!empty($data_initiative_user_code)){
                            array_push($data_initiative_user, $data_initiative_user_code->id);
                        }
                    }
                }
            }

            $data_initiative_user = implode(',', $data_initiative_user);
            $get_kuantitatif = $this->mkuantitatif->getSummaryKuantitatif($data_initiative_user);
        }

        // insert array dummy for batas compare
        array_push($get_kuantitatif, ['id' => 'xxx', 'type' => 'xxx', 'init_id' => 'xxx']);
        $data['type_1'] = array();
        $data['type_2'] = array();
        $data['type_3'] = array();

        $init_id = $get_kuantitatif[0]['init_id'];
        $leading = false;
        $lagging = false;
        foreach ($get_kuantitatif as $key => $value) {
            if ($value['init_id'] != $init_id){
                if ($lagging === true){
                    array_push($data['type_1'], $init_id);
                }elseif (($leading === true) && ($lagging === false)){
                    array_push($data['type_2'], $init_id);
                }else{
                    array_push($data['type_3'], $init_id);
                }

                $init_id = $value['init_id'];
                $leading = false;
                $lagging = false;
            }
            // else{
                if ($value['type'] == 'Leading'){
                    $leading = true;
                    continue;
                }elseif ($value['type'] == 'Lagging'){
                    $lagging = true;
                    continue;
                }
            // }
        }

        $get_table_inititative = $this->mt_action->getDataInKuantitatif($data);

        return $get_table_inititative;
    }

    function getDataTableKuantitatifUser($role = false)
    {
        $data_user = $this->muser->get_user_by_role($role);
        $array_user = array();
        foreach ($data_user as $key => $value) {
            $name = $value->name;
            $id = $value->id;

            if (strpos($value->initiative, ';')){
                $array_initiative = explode(';', $value->initiative);
                foreach ($array_initiative as $key1 => $value1) {
                    $object_table_raw = new StdClass();
                    $object_table_raw->name = $name;
                    $object_table_raw->id = $id;
                    $initiative = $this->minitiative->getInitiativeByCode($value1);
                    $object_table_raw->init_id = $initiative->id;
                    $object_table_raw->init_code = $value1;
                    array_push($array_user, $object_table_raw);
                }
            }else{
                $object_table_raw = new StdClass();
                $object_table_raw->name = $name;
                $object_table_raw->id = $id;
                if (!empty($value->initiative)){
                    $initiative = $this->minitiative->getInitiativeByCode($value->initiative);
                    if (!empty($initiative)){
                        $object_table_raw->init_id = $initiative->id;
                        $object_table_raw->init_code = $value->initiative;
                        array_push($array_user, $object_table_raw);
                    }
                }
            }
        }

        $get_kuantitatif = $this->mkuantitatif->getSummaryKuantitatif();

        $get_kuantitatif_new = array();
        foreach ($array_user as $key => $value) {
            foreach ($get_kuantitatif as $key1 => $value1) {
                if ($value->init_id == $value1['init_id']){
                    array_push($get_kuantitatif_new, $get_kuantitatif[$key1]);
                }
            }
        }

        // insert array dummy for batas compare
        array_push($get_kuantitatif, ['id' => 'xxx', 'type' => 'xxx', 'init_id' => 'xxx']);

        $data['type_1'] = array();
        $data['type_2'] = array();
        $data['type_3'] = array();

        $init_id = $get_kuantitatif[0]['init_id'];
        $leading = false;
        $lagging = false;
        foreach ($get_kuantitatif as $key => $value) {
            if ($value['init_id'] != $init_id){
                if ($lagging === true){
                    foreach ($array_user as $key1 => $value1) {
                        if ($value['init_id'] == $value1->init_id){
                            array_push($data['type_1'], $init_id);
                        }
                    }
                }elseif (($leading === true) && ($lagging === false)){
                    foreach ($array_user as $key1 => $value1) {
                        if ($value['init_id'] == $value1->init_id){
                            array_push($data['type_2'], $init_id);
                        }
                    }
                }else{
                    foreach ($array_user as $key1 => $value1) {
                        if ($value['init_id'] == $value1->init_id){
                            array_push($data['type_3'], $init_id);
                        }
                    }
                }

                $init_id = $value['init_id'];
                $leading = false;
                $lagging = false;
            }else{
                if ($value['type'] == 'Leading'){
                    $leading = true;
                    continue;
                }elseif ($value['type'] == 'Lagging'){
                    $lagging = true;
                    continue;
                }
            }
        }
        $get_table_inititative = $this->mt_action->getDataInKuantitatif($data);

        foreach ($get_table_inititative['type_1'] as $key => $value) {
            $status = 0;
            foreach ($array_user as $key1 => $value1) {
                if ($value->id == $value1->init_id){
                    $get_table_inititative['type_1'][$key]->title = $value1->name;

                    $status = 1;
                }
            }

            if ($status == 0){
                unset($get_table_inititative['type_1'][$key]);
            }
        }

        foreach ($get_table_inititative['type_2'] as $key => $value) {
            $status = 0;
            foreach ($array_user as $key1 => $value1) {
                if ($value->id == $value1->init_id){
                    $get_table_inititative['type_2'][$key]->title = $value1->name;

                    $status = 1;
                }
            }

            if ($status == 0){
                unset($get_table_inititative['type_2'][$key]);
            }
        }

        foreach ($get_table_inititative['type_3'] as $key => $value) {
            $status = 0;
            foreach ($array_user as $key1 => $value1) {
                if ($value->id == $value1->init_id){
                    $get_table_inititative['type_3'][$key]->title = $value1->name;

                    $status = 1;
                }
            }

            if ($status == 0){
                unset($get_table_inititative['type_3'][$key]);
            }
        }

        return $get_table_inititative;
    }

    public function getYtdMilestone($kuantitatif_id = false, $user = false)
    {
        $ytd = 0;
        if ($kuantitatif_id){
            $completed = $this->getStatus($kuantitatif_id, 1, false, false, false, $user);
            $total = $this->getStatus($kuantitatif_id, false, false, false, false, $user);
            $ytd = ($total > 0) ? (($completed / $total) * 100) : 0;
        }

        return $ytd;
    }

    public function home()
    {
        $this->mkuantitatif->getLastMonthUpdated();
      $users = $this->session->userdata('user');
      $user = $users['username'];
      $initid = $users['initiative'];
      $foto = $this->muser->get_data_user($user)->foto;
      $lastlogin = $this->muser->get_data_user($user)->last_login;
      $privateemail = $this->muser->get_data_user($user)->private_email;
      $workemail = $this->muser->get_data_user($user)->work_email;
      $data = array(
          'username' => $user,
          'foto' => $foto,
          'initid' => $initid,
          'last_login' => $lastlogin,
          'private_email' => $privateemail,
          'work_email' => $workemail
      );

      $data['title'] = "Summary Home";

      $user = $users;
      $data['user']=$user;
      if($user['role']!='2'){
          $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
          $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
      }
      else{
          $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
          $data['notif']= $this->mremark->get_notification_by_admin('');
      }

        $info_last_summary = $this->minfo->getInfoLastUpdatedSummary();
        // $get_month = (!empty($info_last_summary->date)) ? $info_last_summary->date : date('Y-m-d');
        $get_month = $this->mkuantitatif->getLastMonthUpdated();

        // views start
        $views = array();
        $views['user'] = $user;
        $data['last_agenda'] = $this->magenda->get_last_agenda(5);
        $data['bulan_search'] = date('F', strtotime($get_month));
        $data['bulan_search_status'] = !empty($data['bulan_search_status']) ? $data['bulan_search_status'] : date('m', strtotime($get_month));
        $bulan_search = $bulan_search_status = false;
        // views end

        //search starts
        if (isset($_POST['bulan'])){
            $data['bulan_search'] = $_POST['bulan'];
            $bulan_search = convertMonth($_POST['bulan']);

            foreach ($this->data_bulan as $key => $value) {
                if ($_POST['bulan'] == $key){
                    $bulan_search_status = $value;
                    $data['bulan_search_status'] = $bulan_search_status;

                    break;
                }
            }
        }
        //search ends

        if (!$bulan_search){
            $bulan_search = date('F', strtotime($get_month));
        }

        //process start
        $data['top_bod'] = $this->getTopBod($bulan_search);
        $data['list_initiatives'] = $this->minitiative->getNewInitiativesAll();

        $is_admin = false;
        if ($user['role'] == 2){
            $is_admin = true;
            $data['initiatives_detail'] = $this->getInitiativesDetail(false, $bulan_search, $is_admin);
        }else{
            $data['initiatives_detail'] = $this->getInitiativesDetail($user['id'], $bulan_search, $is_admin);

            $data_user = $this->muser->getInitiativeArrayById($user['id']);
            $initiative_explode = explode(';', $data_user->initiative);
            $data_initiative_user = array();
            if (is_array($initiative_explode)){
                foreach ($initiative_explode as $key1 => $value1) {
                    $data_initiative_user_raw = array();
                    $data_initiative_user_code = $this->minitiative->getInitiativeByCode($value1);
                    if (!empty($data_initiative_user_code)){
                        $data_initiative_user_raw['init_code'] = $data_initiative_user_code->init_code;
                        $data_initiative_user_raw['title'] = $data_initiative_user_code->title;

                        $data_initiative_user[$data_initiative_user_code->init_code] = $data_initiative_user_raw;
                    }
                }
            }

            $list_initiatives_user = array();
            $list_initiatives_user_array = array();
            foreach ($data['initiatives_detail'] as $key => $value) {
                $array_init_id = array();
                $array_init_id['init_code'] = $value['init_code'];
                $array_init_id['title'] = $value['title'];

                array_push($list_initiatives_user, $array_init_id);
                array_push($list_initiatives_user_array, $value['init_code']);
            }

            $list_initiatives_user_all = array_merge($initiative_explode, $list_initiatives_user_array);
            $list_initiatives_user_all = array_unique($list_initiatives_user_all);

            foreach ($list_initiatives_user_all as $key => $value) {
                if (!in_array($value, $list_initiatives_user_array)){
                    array_push($list_initiatives_user, $data_initiative_user[$value]);
                }
            }
            $data['list_initiatives'] = $list_initiatives_user;
        }

        $data['controller'] = $this;
        $data['is_admin'] = $is_admin;
        $data['summary_info'] = $this->minfo->getInfoLastUpdatedSummary();
        //process end

        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['header'] = $this->load->view('shared/header-v2',$data,TRUE);
        //$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
        $data['content'] = $this->load->view('summary/home',$views,TRUE);

        $this->load->view('front',$data);
    }

    public function getTopBod($month = false)
    {
        $data_summary_kuantitatif = $this->getDataTableKuantitatif();

        $total_monthly = 0;
        $total_yearly = 0;
        $i = 0;
        $j = 1;
        foreach ($data_summary_kuantitatif['type_1'] as $key => $value) {
            $final_monthly_score = $this->getKuantitatifSummary($value->init_code, 'Lagging', 1, $month);
            $final_yearly_score = $this->getKuantitatifSummary($value->init_code, 'Lagging', 2, $month);
            $total_monthly += (float)$final_monthly_score;
            $total_yearly += (float)$final_yearly_score;

            $i++;
        }

        foreach ($data_summary_kuantitatif['type_2'] as $key => $value) {
            $final_monthly_score = $this->getKuantitatifSummary($value->init_code, 'Leading', 1, $month);
            $final_yearly_score = $this->getKuantitatifSummary($value->init_code, 'Leading', 2, $month);
            $total_monthly += $final_monthly_score;
            $total_yearly += $final_yearly_score;

            $i++;
        }

        // foreach ($data_summary_kuantitatif['type_3'] as $key => $value) {
        //     $final_monthly_score = $this->countKuantitatif($value->id, 1);
        //     $final_yearly_score = $this->countKuantitatif($value->id, 1);
        //     $total_monthly = $total_monthly + (int)$final_monthly_score;
        //     $total_yearly = $total_yearly + (int)$final_yearly_score;

        //     $j++;
        // }

        // $total_monthly = round($total_monthly / $i);
        // $total_yearly = round($total_yearly / $i);
        $total_monthly = number_format($total_monthly / $i, 2);
        $total_yearly = number_format($total_yearly / $i, 2);

        $return['mtd'] = $total_monthly;
        $return['ytd'] = $total_yearly;

        return $return;
    }

    public function getInitiativesDetail($user = false, $month = false, $admin = false)
    {
        $info_summary = $this->minfo->getInfoLastUpdatedSummary();

        $month_status = false;
        if ($month){
            foreach ($this->data_bulan as $key => $value) {
                if ($month == $key){
                    $month_status = $value;

                    break;
                }
            }
        }

        $data_summary_kuantitatif = $this->getDataTableKuantitatif($user, true);

        $initiative_explode = '';
        if ($admin){
            $data_user_admin = $this->minitiative->getAllInitCode();
            $data_user = array();
            if (is_array($data_user_admin)){
                foreach ($data_user_admin as $key => $value) {
                    array_push($data_user, $value['init_code']);
                }

                $initiative_explode = $data_user;
            }
        }else{
            $data_user = $this->muser->getInitiativeArrayById($user);
            if ($data_user)
                $initiative_explode = explode(';', $data_user->initiative);
        }
        
        $data_initiative_user = array();
        $data_initiative_user_array = array();
        if (is_array($initiative_explode)){
            foreach ($initiative_explode as $key1 => $value1) {
                $data_initiative_user_raw = array();
                $data_initiative_user_code = $this->minitiative->getInitiativeByCode($value1);
                if (!empty($data_initiative_user_code)){
                    $data_initiative_user_raw['init_code'] = $data_initiative_user_code->init_code;
                    $data_initiative_user_raw['title'] = $data_initiative_user_code->title;

                    $data_initiative_user[$data_initiative_user_code->init_code] = $data_initiative_user_raw;
                    array_push($data_initiative_user_array, $data_initiative_user_code->id);
                }
            }
        }
        $initiative_implode = implode(',', $data_initiative_user_array);
        $data_user_exist_raw = $this->mkuantitatif->getSummaryKuantitatifInit($initiative_implode);
        $data_user_exist = array();
        foreach ($data_user_exist_raw as $key => $value) {
            array_push($data_user_exist, $value['init_id']);
        }

        $initiative_sisa = array();
        foreach ($data_initiative_user_array as $key => $value) {
            if (!in_array($value, $data_user_exist)){
                array_push($initiative_sisa, $value);
            }
        }

        // array data initiatives detail
        $data_initiative_detail = array();

        $total_monthly = 0;
        $total_yearly = 0;
        $i = 1;

        if (!empty($data_summary_kuantitatif['type_1'])){
            foreach ($data_summary_kuantitatif['type_1'] as $key => $value) {
                $data_initiative_detail_raw = array();
                if (!empty($value->init_code)){
                    // kuantitatif details
                    $final_monthly_score = $this->getKuantitatifSummary($value->init_code, 'Lagging', 1, $month);
                    $final_yearly_score = $this->getKuantitatifSummary($value->init_code, 'Lagging', 2, $month);

                    // milestone details
                    // $issues = $this->getStatus($value->id, 3, false, false, $month_status, $user, false, $admin);
                    $flagged = $this->getStatus($value->id, 0, false, 3, $month_status, $user, false, $admin);
                    $completed = $this->getStatus($value->id, 1, false, false, $month_status, $user, false, $admin);
                    $on_track = $this->getStatus($value->id, 2, false, false, $month_status, $user, false, $admin);
                    $future_start = $this->getStatus($value->id, 0, true, false, $month_status, $user, false, $admin);
                    $overdue = $this->getStatus($value->id, 3, false, 2, $month_status, $user, false, $admin);
                    $delay = $this->getStatus($value->id, 3, false, 1, $month_status, $user, false, $admin);
                    // $flagged = abs($issues - ($overdue + $delay));
                    // $flagged = $issues;
                    // $milestone_mtd = ($completed + $overdue > 0) ? (($completed / ($completed + $overdue)) * 100) : 0;
                    $milestone_mtd = $this->getMtdMilestone($overdue, $completed, $value->id, $month_status);
                    $milestone_ytd = $this->getYtdMilestone($value->id);

                    // raw data bind
                        // kuantitatif
                    $data_initiative_detail_raw['id'] = $i;
                    $data_initiative_detail_raw['init_code'] = $value->init_code;
                    $data_initiative_detail_raw['init_id'] = $value->id;
                    $data_initiative_detail_raw['title'] = $value->title;
                    $data_initiative_detail_raw['kuantitatif_mtd'] = $final_monthly_score;
                    $data_initiative_detail_raw['kuantitatif_ytd'] = $final_yearly_score;
                        // milestone
                    $data_initiative_detail_raw['completed'] = $completed;
                    $data_initiative_detail_raw['on_track'] = $on_track;
                    $data_initiative_detail_raw['future_start'] = $future_start;
                    $data_initiative_detail_raw['flagged'] = $flagged;
                    $data_initiative_detail_raw['overdue'] = $overdue;
                    $data_initiative_detail_raw['delay'] = $delay;
                    $data_initiative_detail_raw['milestone_mtd'] = number_format($milestone_mtd);
                    $data_initiative_detail_raw['milestone_ytd'] = number_format($milestone_ytd);

                    array_push($data_initiative_detail, $data_initiative_detail_raw); // insert details to main array
                    $i++;
                }
            }
        }

        if (!empty($data_summary_kuantitatif['type_2'])){
            foreach ($data_summary_kuantitatif['type_2'] as $key => $value) {
                $data_initiative_detail_raw = array();
                if (!empty($value->init_code)){
                    $final_monthly_score = $this->getKuantitatifSummary($value->init_code, 'Leading', 1, $month);
                    $final_yearly_score = $this->getKuantitatifSummary($value->init_code, 'Leading', 2, $month);

                    // milestone details
                    // $issues = $this->getStatus($value->id, 3, false, false, $month_status, $user, false, $admin);
                    $completed = $this->getStatus($value->id, 1, false, false, $month_status, $user, false, $admin);
                    $on_track = $this->getStatus($value->id, 2, false, false, $month_status, $user, false, $admin);
                    $future_start = $this->getStatus($value->id, 0, true, false, $month_status, $user, false, $admin);
                    $overdue = $this->getStatus($value->id, 3, false, 2, $month_status, $user, false, $admin);
                    $delay = $this->getStatus($value->id, 3, false, 1, $month_status, $user, false, $admin);
                    $flagged = $this->getStatus($value->id, 0, false, 3, $month_status, $user, false, $admin);
                    // $milestone_mtd = ($completed + $overdue > 0) ? (($completed / ($completed + $overdue)) * 100) : 0;
                    $milestone_mtd = $this->getMtdMilestone($overdue, $completed, $value->id, $month_status);
                    $milestone_ytd = $this->getYtdMilestone($value->id);

                    // raw data bind
                        // kuantitatif
                    $data_initiative_detail_raw['id'] = $i;
                    $data_initiative_detail_raw['init_code'] = $value->init_code;
                    $data_initiative_detail_raw['init_id'] = $value->id;
                    $data_initiative_detail_raw['title'] = $value->title;
                    $data_initiative_detail_raw['kuantitatif_mtd'] = $final_monthly_score;
                    $data_initiative_detail_raw['kuantitatif_ytd'] = $final_yearly_score;
                        // milestone
                    $data_initiative_detail_raw['completed'] = $completed;
                    $data_initiative_detail_raw['on_track'] = $on_track;
                    $data_initiative_detail_raw['future_start'] = $future_start;
                    $data_initiative_detail_raw['flagged'] = $flagged;
                    $data_initiative_detail_raw['overdue'] = $overdue;
                    $data_initiative_detail_raw['delay'] = $delay;
                    $data_initiative_detail_raw['milestone_mtd'] = number_format($milestone_mtd);
                    $data_initiative_detail_raw['milestone_ytd'] = number_format($milestone_ytd);

                    array_push($data_initiative_detail, $data_initiative_detail_raw); // insert details to main array
                    $i++;
                }
            }
        }

        if (!empty($data_summary_kuantitatif['type_3'])){
            foreach ($data_summary_kuantitatif['type_3'] as $key => $value) {
                $data_initiative_detail_raw = array();
                if (!empty($value->init_code)){
                    $final_monthly_score = $this->countKuantitatif($value->id, 1);
                    $final_yearly_score = $this->countKuantitatif($value->id, 2);

                    // milestone details
                    // $issues = $this->getStatus($value->id, 3, false, false, $month_status, $user, false, $admin);
                    $completed = $this->getStatus($value->id, 1, false, false, $month_status, $user, false, $admin);
                    $on_track = $this->getStatus($value->id, 2, false, false, $month_status, $user, false, $admin);
                    $future_start = $this->getStatus($value->id, 0, true, false, $month_status, $user, false, $admin);
                    $overdue = $this->getStatus($value->id, 3, false, 2, $month_status, $user, false, $admin);
                    $delay = $this->getStatus($value->id, 3, false, 1, $month_status, $user, false, $admin);
                    $flagged = $this->getStatus($value->id, 0, false, 3, $month_status, $user, false, $admin);
                    // $milestone_mtd = ($completed + $overdue > 0) ? (($completed / ($completed + $overdue)) * 100) : 0;
                    $milestone_mtd = $this->getMtdMilestone($overdue, $completed, $value->id, $month_status);
                    $milestone_ytd = $this->getYtdMilestone($value->id);

                    //cek bulan generate summary
                    $compare_month_filter = (int)$month_status;
                    $compare_month_update = (int)date('m', strtotime($info_summary->date));
                    if ($compare_month_filter > $compare_month_update){
                        $final_monthly_score = 0;
                        $final_yearly_score = 0;
                        $milestone_mtd = 0;
                        $milestone_ytd = 0;
                    }

                    // raw data bind
                        // kuantitatif
                    $data_initiative_detail_raw['id'] = $i;
                    $data_initiative_detail_raw['init_code'] = $value->init_code;
                    $data_initiative_detail_raw['init_id'] = $value->id;
                    $data_initiative_detail_raw['title'] = $value->title;
                    $data_initiative_detail_raw['kuantitatif_mtd'] = number_format($final_monthly_score, 2);
                    $data_initiative_detail_raw['kuantitatif_ytd'] = number_format($final_yearly_score, 2);
                        // milestone
                    $data_initiative_detail_raw['completed'] = $completed;
                    $data_initiative_detail_raw['on_track'] = $on_track;
                    $data_initiative_detail_raw['future_start'] = $future_start;
                    $data_initiative_detail_raw['flagged'] = $flagged;
                    $data_initiative_detail_raw['overdue'] = $overdue;
                    $data_initiative_detail_raw['delay'] = $delay;
                    $data_initiative_detail_raw['milestone_mtd'] = number_format($milestone_mtd);
                    $data_initiative_detail_raw['milestone_ytd'] = number_format($milestone_ytd);

                    array_push($data_initiative_detail, $data_initiative_detail_raw); // insert details to main array
                    $i++;
                }
            }
        }

        if (!empty($initiative_sisa)){
            foreach ($initiative_sisa as $key => $value) {
                $data_initiative_detail_raw = array();
                // if (!empty($value->init_code)){
                    $detail_initiatives = $this->minitiative->get_initiative_by_id_new($value);
                    // $final_monthly_score = $this->countKuantitatif($value, 1);
                    // $final_yearly_score = $this->countKuantitatif($value, 2);

                    // milestone details
                    // $issues = $this->getStatus($value, 3, false, false, $month_status, $user, false, $admin);
                    $completed = $this->getStatus($value, 1, false, false, $month_status, $user, false, $admin);
                    $on_track = $this->getStatus($value, 2, false, false, $month_status, $user, false, $admin);
                    $future_start = $this->getStatus($value, 0, true, false, $month_status, $user, false, $admin);
                    $overdue = $this->getStatus($value, 3, false, 2, $month_status, $user, false, $admin);
                    $delay = $this->getStatus($value, 3, false, 1, $month_status, $user, false, $admin);
                    $flagged = $this->getStatus($value, 0, false, 3, $month_status, $user, false, $admin);
                    // $milestone_mtd = ($completed + $overdue > 0) ? (($completed / ($completed + $overdue)) * 100) : 0;
                    $milestone_mtd = $this->getMtdMilestone($overdue, $completed, $value, $month_status);
                    $milestone_ytd = $this->getYtdMilestone($value);

                    //cek bulan generate summary
                    $compare_month_filter = (int)$month_status;
                    $compare_month_update = (int)date('m', strtotime($info_summary->date));
                    if ($compare_month_filter > $compare_month_update){
                        $milestone_mtd = 0;
                        $milestone_ytd = 0;
                    }

                    // raw data bind
                        // kuantitatif
                    $data_initiative_detail_raw['id'] = $i;
                    $data_initiative_detail_raw['init_code'] = $detail_initiatives->init_code;
                    $data_initiative_detail_raw['init_id'] = $value;
                    $data_initiative_detail_raw['title'] = $detail_initiatives->title;
                    $data_initiative_detail_raw['kuantitatif_mtd'] = number_format(0, 2);
                    $data_initiative_detail_raw['kuantitatif_ytd'] = number_format(0, 2);
                        // milestone
                    $data_initiative_detail_raw['completed'] = $completed;
                    $data_initiative_detail_raw['on_track'] = $on_track;
                    $data_initiative_detail_raw['future_start'] = $future_start;
                    $data_initiative_detail_raw['flagged'] = $flagged;
                    $data_initiative_detail_raw['overdue'] = $overdue;
                    $data_initiative_detail_raw['delay'] = $delay;
                    $data_initiative_detail_raw['milestone_mtd'] = number_format($milestone_mtd);
                    $data_initiative_detail_raw['milestone_ytd'] = number_format($milestone_ytd);

                    array_push($data_initiative_detail, $data_initiative_detail_raw); // insert details to main array
                    $i++;
                // }
            }
        }

        // var_dump($data_initiative_detail);die;

        return $data_initiative_detail;
    }

    public function getDetailInitiative()
    {
        $initiative_id = $_GET['initiative_id'];
        $status = $_GET['status'];
        $flagged = $_GET['flagged'];
        $month = !empty($_GET['month']) ? $_GET['month'] : null;
        $future = !empty($_GET['future']) ? $_GET['future'] : false;
        // $flagged = ($_GET['flagged'] != false) ? $_GET['flagged'] : false;

        if ($flagged === 'false'){
            $flagged = false;
        }

        if ($future === 'false'){
            $future = false;
        }

        $user = $this->session->userdata('user');
        $is_admin = false;

        if ($user['role'] == 2){
            $user_id = false;
            $is_admin = true;
        }else{
            $user_id = $user['id'];
        }
        // getStatus
        // $initiative_id,
        // $status = false,
        // $future = false,
        // $flagged = false,
        // $bulan = false,
        // $user = false,
        // $all = false

        // $completed =    $this->getStatus($value->id, 1, false, false, false, $user_id, true);
        // $issues =       $this->getStatus($value->id, 3, false, false, false, $user_id, true);
        // $overdue =      $this->getStatus($value->id, 3, false, 2, false, $user_id, true);
        // $not_started =  $this->getStatus($value->id, 3, false, 1, false, $user_id, true);
        // $future_start = $this->getStatus($value->id, 0, true, false, $month_status, $user, false, $admin);
        // $on_track =     $this->getStatus($value->id, 2, false, false, false, $user_id, true);

        $data = $this->getStatus($initiative_id, $status, $future, $flagged, $month, $user_id, true, $is_admin);

        foreach ($data as $key => $value) {
            $data[$key]['start'] = date('d/M/Y', strtotime($value['start']));
            $data[$key]['end'] = date('d/M/Y', strtotime($value['end']));
        }

        $dataResponse = array("status" => "success", "data" => $data);
        header('Content-Type: application/json');
        echo json_encode($dataResponse);
    }

    public function generateSummary()
    {
      $users = $this->session->userdata('user');
      $user = $users['username'];
      $initid = $users['initiative'];
      $foto = $this->muser->get_data_user($user)->foto;
      $lastlogin = $this->muser->get_data_user($user)->last_login;
      $privateemail = $this->muser->get_data_user($user)->private_email;
      $workemail = $this->muser->get_data_user($user)->work_email;
      $data = array(
          'username' => $user,
          'foto' => $foto,
          'initid' => $initid,
          'last_login' => $lastlogin,
          'private_email' => $privateemail,
          'work_email' => $workemail
      );

      $data['title'] = "Generate Summary";

      $user = $users;
      $data['user']=$user;
      if($user['role']!='2'){
          $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
          $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
      }
      else{
          $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
          $data['notif']= $this->mremark->get_notification_by_admin('');
      }
        // views start
        $views = array();
        $is_admin = false;
        if ($user['role'] == 2){
            $is_admin = true;
        }
        $data['is_admin'] = $is_admin;
        // views end

        //process start
        $data['controller'] = $this;
        $data['summary_info'] = $this->minfo->getInfoLastUpdatedSummary();
        //process end

        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['header'] = $this->load->view('shared/header-v2',$data,TRUE);
        //$data['sidebar'] = $this->load->view('shared/sidebar_2',$prog,TRUE);
        $data['content'] = $this->load->view('summary/generate_summary',$views,TRUE);

        $this->load->view('front',$data);
    }

    public function getMtdMilestone($overdue, $complete, $initiative_id, $month = false)
    {
        $complete = ($complete > 0) ? $complete : 0;
        $total_action = $this->mt_action->getAllAction($initiative_id, $month);

        $pembagi = $complete + $overdue;
        $pembagi = ($pembagi > 0) ? $pembagi : 1;

        $mtd = $complete / ($pembagi) * 100;

        return ($mtd <= 100) ? $mtd : 100;
    }

    public function getKuantitatifSummary($init_code, $type, $period, $month = false)
    {
        $month = ($month) ? $month : date('F');
        $get = $this->mprogram->get_m_initiative_tot($init_code, $month);

        $total = 0;
        $count = 1;
        if ($type == 'Lagging'){
            foreach ($get as $key => $value) {
                $count = $value['count_lagging'];

                if ($period == 1){ //monthly
                    $total = $value['tot_lagging']['month'];
                }else{
                    $total = $value['tot_lagging']['year'];
                }
            }
        }else{
            foreach ($get as $key => $value) {
                $count = $value['count_leading'];

                if ($period == 1){ //monthly
                    $total = $value['tot_leading']['month'];
                }else{
                    $total = $value['tot_leading']['year'];
                }
            }
        }

        $count = ($count > 0) ? $count : 1;

        $percentage = ($total * 100) / $count;
        $percentage = maxscore($percentage, $type);

        $return = number_format($percentage, 2);
        // $return = round($percentage);

        return $return;
    }

    public function getTotalMilestone($month = false, $type = false)
    {
        // $type = 1 = monthly
        // $type = 2 = yearly

        $month = ($month) ? $month : date('F');
        $type = ($type) ? $type : 1;
        $data = $this->mt_action->getTotalSummaryMilestone($month, $type);
        $count = round($data['total'] * 100);

        return $count;
    }

}
