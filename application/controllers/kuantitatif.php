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
    public function index()
    {
        $data['title'] = "All Kuantitatif";

        $prog['page']="all";

        $user = $this->session->userdata('user');
        $prog['user'] = $user;
        $pending_aprv = $this->mmilestone->get_pending_aprv($user['id'],$user['role']);

        $prog['programs'] = $this->mkuantitatif->get_kuantitatif()->result_array();
        $prog['all_count_wb'] = $this->mworkblock->get_count_workblock();
        $init = $this->mprogram->get_init_code();

        $prog['list_program'] = $this->load->view('kuantitatif/component/_list_of_kuantitatif',$prog,TRUE);

        $data['user']=$user;
        if($user['role']!='admin'){
            $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
            $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],5);
        }
        else{
            $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
            $data['notif']= $this->mremark->get_notification_by_admin(5);
        }

        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['header'] = $this->load->view('shared/header-new',$data,TRUE);
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

        $prog['programs'] = $this->mkuantitatif->get_kuantitatif_by_user($user['username'])->result_array();

        $prog['all_count_wb'] = $this->mworkblock->get_count_workblock();
        $init = $this->mprogram->get_init_code();
        
        $prog['list_program'] = $this->load->view('kuantitatif/component/_list_of_kuantitatif',$prog,TRUE);

        $data['user']=$user;
        if($user['role']!='admin'){
            $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
            $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],5);
        }
        else{
            $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
            $data['notif']= $this->mremark->get_notification_by_admin(5);
        }

        $data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['header'] = $this->load->view('shared/header-new',$data,TRUE);
        $data['content'] = $this->load->view('kuantitatif/list_kuantitatif',$prog,TRUE);

        $this->load->view('front',$data);
    }

}
