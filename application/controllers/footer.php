<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Footer extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('muser');
        $this->load->model('mitem');
        $this->load->model('mlookbook');
        $this->load->model('mcart');
        $this->load->model('mblog');
        $bahasa = $this->session->userdata('bahasa');
        if(!$bahasa){
            redirect('welcome');
        }
    }
    /**
     * Method for page (public)
     */
    public function index()
    {
        //$data['title'] = "beranda";
        redirect('home');
        
    }
    public function company()
    {
        $data['title'] = "Company";
        
        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        $cart_items = $this->mcart->get_user_item_unfinished_cart();
        $tablecart_td = $this->load->view('shared/header/_tablecart_td',array('cart_items' => $cart_items),TRUE); 
        $tablecart = $this->load->view('shared/header/_tablecart',array('tablecart_td' => $tablecart_td),TRUE);
        
        $bahasa = $this->session->userdata('bahasa');
        $misc = $this->muser->get_misc();
        $table = "company_$bahasa";
        $footer_content = $this->load->view('footer/_footer_content',array('content'=> $misc->$table, 'follow' => $this->load->view('shared/_followus',array('sosmed' => $this->muser->get_sosmed()),TRUE)),TRUE);
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header,'tablecart' => $tablecart, 'sum_ci' => count($cart_items), 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('footer/index',array('footer_content' => $footer_content),TRUE);
    
        $this->load->view('front',$data);
        
    }
    
    public function policy()
    {
        $data['title'] = "Policy";
        
        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        $cart_items = $this->mcart->get_user_item_unfinished_cart();
        $tablecart_td = $this->load->view('shared/header/_tablecart_td',array('cart_items' => $cart_items),TRUE); 
        $tablecart = $this->load->view('shared/header/_tablecart',array('tablecart_td' => $tablecart_td),TRUE);
        
        $bahasa = $this->session->userdata('bahasa');
        $misc = $this->muser->get_misc();
        $table = "policy_$bahasa";
        $footer_content = $this->load->view('footer/_footer_content',array('content'=> $misc->$table, 'follow' => $this->load->view('shared/_followus',array('sosmed' => $this->muser->get_sosmed()),TRUE)),TRUE);
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header,'tablecart' => $tablecart, 'sum_ci' => count($cart_items), 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('footer/index',array('footer_content' => $footer_content),TRUE);
    
        $this->load->view('front',$data);
        
    }
    
    public function contact()
    {
        $data['title'] = "Contact";
        
        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        $cart_items = $this->mcart->get_user_item_unfinished_cart();
        $tablecart_td = $this->load->view('shared/header/_tablecart_td',array('cart_items' => $cart_items),TRUE); 
        $tablecart = $this->load->view('shared/header/_tablecart',array('tablecart_td' => $tablecart_td),TRUE);
        
        $bahasa = $this->session->userdata('bahasa');
        $misc = $this->muser->get_misc();
        $table = "contact_$bahasa";
        $footer_content = $this->load->view('footer/_footer_content',array('content'=> $misc->$table, 'follow' => $this->load->view('shared/_followus',array('sosmed' => $this->muser->get_sosmed()),TRUE)),TRUE);
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header,'tablecart' => $tablecart, 'sum_ci' => count($cart_items), 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('footer/index',array('footer_content' => $footer_content),TRUE);
    
        $this->load->view('front',$data);
        
    }
    
    public function htb()
    {
        $data['title'] = "How to Buy";
        
        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        $cart_items = $this->mcart->get_user_item_unfinished_cart();
        $tablecart_td = $this->load->view('shared/header/_tablecart_td',array('cart_items' => $cart_items),TRUE); 
        $tablecart = $this->load->view('shared/header/_tablecart',array('tablecart_td' => $tablecart_td),TRUE);
        
        $bahasa = $this->session->userdata('bahasa');
        $misc = $this->muser->get_misc();
        $table = "htb_$bahasa";
        $footer_content = $this->load->view('footer/_footer_content',array('content'=> $misc->$table, 'follow' => $this->load->view('shared/_followus',array('sosmed' => $this->muser->get_sosmed()),TRUE)),TRUE);
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header,'tablecart' => $tablecart, 'sum_ci' => count($cart_items), 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('footer/index',array('footer_content' => $footer_content),TRUE);
    
        $this->load->view('front',$data);   
    }
    
    public function term()
    {
        $data['title'] = "Term and Agreement";
        
        $user_name = $this->muser->get_user_name_header();
        $stock = $this->mitem->check_all_items_stock();
        $lookbook_header = $this->mlookbook->get_lookbook_header();
        $cart_items = $this->mcart->get_user_item_unfinished_cart();
        $tablecart_td = $this->load->view('shared/header/_tablecart_td',array('cart_items' => $cart_items),TRUE); 
        $tablecart = $this->load->view('shared/header/_tablecart',array('tablecart_td' => $tablecart_td),TRUE);
        
        $bahasa = $this->session->userdata('bahasa');
        $misc = $this->muser->get_misc();
        $table = "terms_$bahasa";
        $footer_content = $this->load->view('footer/_footer_content',array('content'=> $misc->$table, 'follow' => $this->load->view('shared/_followus',array('sosmed' => $this->muser->get_sosmed()),TRUE)),TRUE);
        
        $data['header'] = $this->load->view('shared/header',array('user_name' => $user_name,'stock' => $stock, 'lookbook_header' => $lookbook_header,'tablecart' => $tablecart, 'sum_ci' => count($cart_items), 'blog_header' =>$this->mblog->get_all_blog_show()),TRUE);	
    	$data['footer'] = $this->load->view('shared/footer','',TRUE);
        $data['content'] = $this->load->view('footer/index',array('footer_content' => $footer_content),TRUE);
    
        $this->load->view('front',$data);   
    }
    
    public function change_lang(){
    	$bahasa = $this->uri->segment(3);
    	$this->session->set_userdata('bahasa',$bahasa);
    	$uri=base_url();
    	for($i=4;$i<=$this->uri->total_segments();$i++){
    		$uri=$uri.$this->uri->slash_segment($i);
    	}
    	redirect($uri);
    }
}
