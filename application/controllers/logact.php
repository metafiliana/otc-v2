<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Logact extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mworkblock');
        $this->load->model('mmilestone');
        $this->load->model('mlogact');
        $this->load->model('mremark');
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

      $data['title'] = 'Log Activity';

      $user = $users;
      $data['logs'] = $this->mlogact->get_notification_for_logact('');

      $data['user']=$user;
      if($user['role']!='2'){
          $data['notif_count']= count($this->mremark->get_notification_by_user_id($user['id'],''));
          $data['notif']= $this->mremark->get_notification_by_user_id($user['id'],'');
      }
      else{
          $data['notif_count']= count($this->mremark->get_notification_by_admin(''));
          $data['notif']= $this->mremark->get_notification_by_admin('');
      }

      $data['header'] = $this->load->view('shared/header-v2',$data,TRUE);
      $data['footer'] = $this->load->view('shared/footer','',TRUE);
      $data['content'] = $this->load->view('logact/list_logact',$data,TRUE);
      $this->load->view('front',$data);
    }

}
