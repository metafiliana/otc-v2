<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admins
 *
 * @author Maulnick
 */
class Mfiles_upload extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('excel');
    }
    
    //INSERT or CREATE FUNCTION
    function insert($program){
        $insert_id = $this->db->insert('files_upload', $program);
        return $insert_id;
    }
     
    function  insert_user_customer($program){
        $insert_id = $this->db->insert('user_customer', $program);
        return $insert_id;
    }
   
    function insert_files_upload($program){
        if($this->db->insert('files_upload', $program)){
           return $this->db->insert_id();
        }
        else{
            return false;
        }
    }

    function insert_db($data,$db){
        if($this->db->insert($db, $data)){
           return $this->db->insert_id();
        }
        else{
            return false;
        }
    }

    function insert_db_batch($data,$db){ 
        $this->db->trans_start();
        $this->db->insert_batch($db, $data);
        //$this->db->insert_id();
        $this->db->trans_complete();
    }
    
	function insert_files_upload_with_full_url($full_url,$modul, $submodul, $atch, $ownership_id){
		$file_atch['full_url'] = $full_url.$atch['file_name'];
		$user = $this->session->userdata('userdb');
    	$file_atch['file_name'] = $atch['file_name'];
		$file_atch['ext'] = $atch['file_ext'];
		$file_atch['title'] =  $atch['raw_name'];
		$file_atch['modul'] = $modul;
		$file_atch['sub_modul'] = $submodul;
		$file_atch['user_id'] = $user['id'];
		$file_atch['created'] = date("Y-m-d h:i:s");
		if($ownership_id){
        $file_atch['ownership_id'] = $ownership_id;
        }
		return $this->insert_files_upload($file_atch);
	}
    
    function insert_files_upload_with_full_url_return_id($full_url,$modul, $submodul, $atch, $ownership_id){
		if($this->insert_files_upload_with_full_url($full_url,$modul, $submodul, $atch, $ownership_id)){
             return $this->db->insert_id();
        }
        else{
            return false;
        }
	}
    
    function insert_files_upload_with_full_url_with_param($full_url,$modul, $submodul, $atch, $ownership_id,$program){
		$file_atch['full_url'] = $full_url.$atch['file_name'];
		$user = $this->session->userdata('userdb');
    	$file_atch['file_name'] = $atch['file_name'];
		$file_atch['ext'] = $atch['file_ext'];
        if($program['title']){
            $file_atch['title'] = $program['title'];
        }
        else{
            $file_atch['title'] =  $atch['raw_name'];
        }
		$file_atch['modul'] = $modul;
		$file_atch['sub_modul'] = $submodul;
		$file_atch['user_id'] = $user['id'];
		//$file_atch['created'] = $program['created'];
        $file_atch['created'] = date("Y-m-d H:i:s");
		//$file_atch['ownership_id'] = $ownership_id;
        /*if($program['user_allowed']){
             $file_atch['user_allowed'] = $program['user_allowed'];
        }
        //$file_atch['description'] = $program['description'];

        if($program['segment_allowed'])
        {
         $file_atch['segment_allowed'] = $program['segment_allowed'];   
        }*/
		return $this->insert_files_upload($file_atch);
	}
	
    function insert_files_upload_with_param_input($modul, $submodul, $atch, $ownership_id){
    	$user = $this->session->userdata('userdb');
    	$file_atch['file_name'] = $atch['file_name'];
		$file_atch['ext'] = $atch['file_ext'];
		$file_atch['title'] =  $atch['raw_name'];
		$file_atch['modul'] = $modul;
		$file_atch['sub_modul'] = $submodul;
		$file_atch['user_id'] = $user['id'];
		$file_atch['created'] = date("Y-m-d h:i:s");
		$file_atch['ownership_id'] = $ownership_id;
		return $this->insert_files_upload($file_atch);
    }

    function insert_by_param($title, $file_name, $ext, $description, $user_id, $modul, 
        $sub_modul, $user_allowed, $customer, $type, $ownership_id, $cust_type){
        
        $file_atch['title'] = $title;
        $file_atch['file_name'] = $file_name;
        $file_atch['ext'] = $file_ext;
        $file_atch['description'] = $description;
        $file_atch['user_id'] = $user_id;
        $file_atch['modul'] = $modul;
        $file_atch['sub_modul'] = $submodul;
        $file_atch['user_allowed'] = $uet_type;
        $file_atch['created'] = date("Y-m-d h:i:s");
        $file_atch['ownership_id'] = $ownership_id;
        return $this->db->insert('files_upload', $file_atch);
    }

    
    //GET FUNCTION
  	
  	function get_latest_date_employee($db,$employee){
       $this->db->select('MAX(a.date) as latest_date',false);
		$this->db->from($db);
		$this->db->join('user_customer as b','a.customer = b.customer_name');
		$this->db->where('b.nip',$employee); 
        $realizations = $this->db->get();
		//echo $this->db->last_query();die();
        return $realizations -> result()[0]->latest_date;  
		
    }
  
  	function get_latest_date_clncl($db){
		$string_query_cl = 
            "select MAX(date) as latest_date
			FROM (`summarycredit`)";
		$string_query_ncl = 
            "select MAX(date) as latest_date
			FROM (`summarynclouts`)";
		
		$string_query = "select MAX(a.latest_date) as latest_date
			from( ".$string_query_cl." UNION ".$string_query_ncl.")a";	
		
		$realizations = $this->db->query($string_query);
		
		
		// realizations $this->db->last_query();die();
	 	return $realizations->row('latest_date');
		
    
    }
	
  	function get_db_employee($employee,$order,$how,$db,$arr_where,$select,$limit){
        if($select){$this->db->select($select,false);}
		$this->db->from($db);
		$this->db->join('user_customer b','a.customer = b.customer_name');
		$this->db->where('nip',$employee);
		//if($arr_where){$this->db->where('a.date',$arr_where);}
        if($limit){$this->db->limit($limit);}
        if(is_array($order)){
            $i=0;
            foreach($order as $row){
                $this->db->order_by($row,$how[$i]); $i++;
            }
        }
        else{$this->db->order_by($order,$how);}
        
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_detil_files_by_id($id){
		$this->db->where('id',$id);
        $query = $this->db->get('files_upload');
		return $query->result()[0];
	}
	
	function get_all_files_upload_modul_sort_like($modul,$param,$how,$col,$value,$query){
		if($value!='all' && $col){
			$this->db->like($col, $value, 'after');
		}
		if($query!=''){
			$this->db->where('(customer LIKE "%'.$query.'%")');
		}
		return $this->get_all_files_upload_modul_sort($modul,$param,$how);
	}
    
	function get_all_files_upload_modul_limit($modul,$param,$how,$limit){
    	$this->db->limit($limit);
    	return $this->get_all_files_upload_modul_sort($modul,$param,$how);
    }
    
    function get_all_files_upload_modul_sort($modul,$param,$how){
    	if($modul == "customer_files"){
    		$this->db->distinct();
    		//$this->db->select('customer.customer_name, customer.buc');
    		//$this->db->join('customer', 'files_upload.customer = customer.customer_name', 'left');
    	}
    	$this->db->order_by($param,$how);
    	return $this->get_all_files_upload_modul($modul);
    }
    
    function get_all_files_upload_modul($modul){
    	$this->db->select('files_upload.*');
		$this->db->where('modul',$modul);
    	$this->db->order_by('id','desc');
    	$result = $this->db->get('files_upload');
    	return $result->result();
    }
    
    function get_all_files_upload_modul_join_id($modul){
    	//$this->db->select('files_upload.*');
        $this->db->select('files_upload.id as files_id ,user.id as idu, full_name , title, file_name, ext, modul, sub_modul, created, updated, customer, description, full_url');
		$this->db->where('modul',$modul);
    	$this->db->order_by('files_id','desc');
        $this->db->join('user','files_upload.user_id = user.id');
    	$result = $this->db->get('files_upload');
    	return $result->result();
    }

    function get_all_files_upload_modul_how($modul, $sort){
        $this->db->select('files_upload.*');
        $this->db->where('modul',$modul);
        $this->db->order_by($sort,'desc');
        $result = $this->db->get('files_upload');
        return $result->result();
    }
    
    function get_all_files_upload_modul_submodul($modul,$submodul,$limit){
    	if($limit){
    		$this->db->limit($limit);
    	}
    	$this->db->select('*');
		$this->db->where('modul',$modul);
		$this->db->where('sub_modul',$submodul);
    	$this->db->order_by('created','desc');
        $this->db->order_by('id','desc');
    	$result = $this->db->get('files_upload');
    	return $result->result();
    }
    
    function get_files_upload_by_id($id){
    	$this->db->select('files_upload.*');
    	$this->db->where('files_upload.id',$id);
    	$res = $this->db->get('files_upload'); 
    	$result = $res->row(0);
    	return $result;
    }
	
	function get_cr_files_upload_by_id($id){
    	$this->db->select('call_reports.*');
    	$this->db->where('call_reports.id',$id);
    	$res = $this->db->get('call_reports'); 
    	$result = $res->row(0);
    	return $result;
    }
    
    function get_files_upload_by_ownership_id($modul, $submodul, $id){
    	$this->db->select('files_upload.*');
    	$this->db->where('modul',$modul);
    	if($submodul){
    		$this->db->where('sub_modul',$submodul);
    	}
		$this->db->where('ownership_id',$id);
    	$this->db->order_by('id','desc');
    	$result = $this->db->get('files_upload');
    	return $result->result();
    }
    
    function get_files_upload_by_ownership_id_order($modul, $submodul, $id, $order_by, $how){
    	$this->db->select('files_upload.*');
    	if($modul){
             $this->db->where('modul',$modul);
        }
    	if($submodul){
    		$this->db->where('sub_modul',$submodul);
    	}
		$this->db->where('ownership_id',$id);
    	$this->db->order_by($order_by,$how);
    	$result = $this->db->get('files_upload');
    	return $result->result();
    }

    function get_by_param($modul, $sub_modul, $ownership_id, $type="all"){
        $this->db->select('files_upload.*');
        $this->db->where('modul',$modul);
        $this->db->where('sub_modul',$sub_modul);
        $this->db->where('ownership_id',$ownership_id);
        //$this->db->where('cust_type',$cust_type);
        if($type!="all"){
            $this->db->where('type',$type);
        }
        $result = $this->db->get('files_upload');
        return $result->result();
    }

    function get_custfile_by_custgroup($arr_cust){
        $this->db->where('modul','customer_files');
        $this->db->where_in('customer',$arr_cust);
        $this->db->order_by('created','desc');
        $result = $this->db->get('files_upload');
        return $result->result();
    }

    function get_custfile($type, $custname){
        $arr_cust = array();
        $arr_cust[0] = $custname;
        if($type == "group"){
            $cust = $this->mcustomer->get_group_member($custname); $i=1;
            foreach ($cust as $row) {
                $arr_cust[$i] = $row->customer_name;
                $i++;
            }
        }
        return $this->get_custfile_by_custgroup($arr_cust);
    }


    //UPDATE FUNCTION
    function update_files_upload($program,$id){
        $program['updated'] = date("Y-m-d H:i:s");
        $this->db->where('id',$id);
        return $this->db->update('files_upload', $program);
    }

    function update_with_modul_ownership_id($modul,$id,$program){
        $this->db->where('ownership_id',$id);
        $this->db->where('modul',$modul);
        return $this->db->update('files_upload', $program);
    }
    
    function update_files_upload_with_id($program,$modul,$submodul,$id){
        $this->db->where('modul',$modul);
        $this->db->where('sub_modul',$submodul);
        $this->db->where('id',$id);
        return $this->db->update('files_upload', $program);
    }

    function update_db($program,$id,$db){
        $this->db->where('id',$id);
        return $this->db->update($db, $program);
    }

    function update_db_where($program,$arr_where,$db){
        $this->db->where($arr_where);
        return $this->db->update($db, $program);
    }
    
    //DELETE FUNCTION
    function delete_files_upload($id){
    	$this->db->where('id',$id);
    	$this->db->delete('files_upload');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    
    function delete_files_upload_by_file_name($file,$modul,$submodul){
    	$this->db->where('file_name',$file);
    	$this->db->where('modul',$modul);
    	$this->db->where('sub_modul',$submodul);
    	$this->db->delete('files_upload');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    
    //DELETE FUNCTION with files
    function delete_with_files($id){
    	$file=$this->get_detil_files_by_id($id);
        if($file->full_url){
            unlink($file->full_url);
        }else{
            if($file->modul == "ftp"){
                unlink("assets/uploads/ftp/files/".$file->file_name);
            }
        }
        if($file->icon){
            unlink($file->icon);
        }
        return $this->delete_files_upload($id);
    }

    function delete_with_files_ownership($ownership_id,$modul,$sub_modul){
        $files=$this->get_files_upload_by_ownership_id($modul, $sub_modul, $ownership_id);
        foreach($files as $file){
            if($file->full_url){
                $arr = explode("/", $file->full_url);
                unlink($file->full_url);

                //Delete Thumbnail
                $folder=""; $sum_arr = count($arr)-1;
                for($i=0; $i<$sum_arr;$i++){
                    $folder = $folder.$arr[$i]."/";
                }
                $thumb = $folder."thumb/".$arr[$i]."_thumbnail.jpg";
                //$thumb=$arr[0]."/".$arr[1]."/".$arr[2]."/".$arr[3]."/".$arr[4]."/thumb/".$arr[5]."_thumbnail.jpg";
                if(file_exists($thumb)){
                  unlink($thumb);
                  //rmdir($folder."thumb/");
                }
                //rmdir($folder);
                
            }else{
                if($file->modul == "ftp"){
                    unlink("assets/uploads/ftp/files/".$file->file_name);

                }
            }
            $this->delete_files_upload($file->id);
        }
        return true;
    }

    function delete_id_db($db,$id){
        $this->db->where('id',$id);
        $this->db->delete($db);
        if($this->db->affected_rows()>0){
            return true;
        }
        else{
            return false;
        }
    }
    
    function delete_by_date_user_customer($date){
    	$this->db->where('date',$date);
    	$this->db->delete('user_customer');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return true;
    	}
    }
    
    
    // OTHER FUNCTION
    function get_db($order,$how,$db,$arr_where,$select,$limit){
        if($arr_where){$this->db->where($arr_where);}
        if($limit){$this->db->limit($limit);}
        if($select){$this->db->select($select);}

        if(is_array($order)){
            $i=0;
            foreach($order as $row){
                $this->db->order_by($row,$how[$i]); $i++;
            }
        }
        else{$this->db->order_by($order,$how);}
        
        $query = $this->db->get($db);
        return $query->result();
    }
    function get_db_group_by($order,$how,$db,$arr_where,$select,$limit,$group_by){
        if($group_by){$this->db->group_by($group_by);}
        return $this->get_db($order,$how,$db,$arr_where,$select,$limit);
    }
    function get_db_join($order,$how,$db,$arr_where,$select,$limit,$group_by,$join){
        if($join){
            foreach($join as $row){
                if(isset($row['how'])) $this->db->join($row['table'], $row['in'], $row['how']);
                else $this->db->join($row['table'], $row['in']);
                
            }
        }
        return $this->get_db_group_by($order,$how,$db,$arr_where,$select,$limit,$group_by);
    }
    function get_distinct_col($col,$order,$db){
        $this->db->select("$col as val");
        $this->db->distinct();
        $this->db->order_by($col,$order);
        $this->db->where("$col !=",'');
        $query = $this->db->get($db);
        return $query->result();
    }

    function get_distinct_col_segment($col,$order,$db){
        $this->db->select("$col as val,segment");
        $this->db->distinct();
        $this->db->order_by($col,$order);
        $this->db->where("$col !=",'');
        $query = $this->db->get($db);
        return $query->result();
    }

    function get_distinct_col_where($col,$order,$db,$arr_where){
        if($arr_where){$this->db->where($arr_where);}
        return $this->get_distinct_col($col,$order,$db);
    }

    function get_distinct_col_where_limit($col,$order,$db,$arr_where,$limit){
        if($arr_where){$this->db->where($arr_where);}
        $this->db->limit($limit);
        return $this->get_distinct_col($col,$order,$db);
    }

    function get_distinct_col_where_in($col,$order,$db,$arr_where,$where_col,$in){
        $this->db->where_in($where_col,$in);
        return $this->get_distinct_col($col,$order,$db,$arr_where);
    }

    function get_latest_date($db){
        $this->db->select('MAX(date) as latest_date');
        $realizations = $this->db->get($db);

        return $realizations -> result()[0]->latest_date;
    }

    function get_latest_date_year_month($db,$year,$month){
        if($year){$this->db->where("YEAR(date) = $year");}
        if($month){$this->db->where("Month(date) = $month");}
        $this->db->select('MAX(date) as latest_date');
        $realizations = $this->db->get($db);

        return $realizations -> result()[0]->latest_date;
    }

    function get_form_element($array){
        $result = array();
        foreach ($array as $row) {
            $result[$row] = $this->input->post($row);
        }
        return $result;
    }

    function search_db_content($db, $arr_col, $search, $arr_where, $limit,$order_by,$how){
        if($arr_where){
            $this->db->where($arr_where);
        }
        if($arr_col){
            if($db == "files_upload"){
                $search_stc = explode(" ", $search);
                $search = "$search_stc[0]";
                for($j=1;$j<count($search_stc);$j++){
                    $search .= "_".$search_stc[$j];
                }
            }

            $search_value = "'%".$search."%'";
            
            $arr_after = array('custname','custgroup');
            if(in_array($db, $arr_after)){
                $search_value = "'".$search."%'";
            }

            $like_stc = "($arr_col[0] LIKE ".$search_value;
            for($i=1;$i<count($arr_col);$i++){
                $like_stc= $like_stc." OR $arr_col[$i] LIKE ".$search_value;
            }
            $like_stc = $like_stc.")";
        }
        if($limit){$this->db->limit($limit);}

        $this->db->where($like_stc);
        $this->db->order_by($order_by, $how);
        $this->db->from($db);
        
        $query = $this->db->get();
        return $query->result();
    }

    function delete_db_where($arr_where,$db){
        if($arr_where){
            $this->db->delete($db,$arr_where);
        }else{
            $this->db->empty_table($db); 
        }
        if($this->db->affected_rows()>0){
            return true;
        }
        else{
            return true;
        }
    }

    function upload_files($form,$path,$modul,$submodul,$ownership_id,$to_files_upload,$make_thumbnail){
        $upload_path = "assets/uploads/".$path;
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => "*",
            'overwrite' => FALSE,
            'max_size' => "2048000000",
        );
        $this->load->library('upload', $config);

        if($this->upload->do_multi_upload($form))
        {
            $attachments = $this->upload->get_multi_upload_data($form);
            foreach($attachments as $atch){
                $this->insert_files_upload_with_full_url($upload_path,$modul,$submodul, $atch, $ownership_id);
                if($make_thumbnail){
                    $file_location = $upload_path.$atch['file_name'];
                    $this->make_photo_thumb($atch['file_name'],$file_location,$path,400,'_thumbnail.jpg');
                }
            }
        }
        else{
            $error = array('error' => $this->upload->display_errors());
        }
    }
    
    function upload_file($form,$path,$modul,$submodul,$ownership_id,$to_files_upload){
        $upload_path = "assets/uploads/".$path;
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => "*",
            'overwrite' => FALSE,
            'max_size' => "2048000000",
        );
        $this->load->library('upload', $config);
        if($this->upload->do_upload($form))
        {
            $atch = $this->upload->data();
            if($to_files_upload){
                $this->insert_files_upload_with_full_url($upload_path,$modul,$submodul, $atch, $ownership_id);
            }
            $atch['full_url'] = $upload_path.$atch['file_name'];
           return $atch;
            
        }
        else{
            $error = array('error' => $this->upload->display_errors());
        }
    }
    
    function upload_file_with_icon($form,$icon,$path,$modul,$submodul,$id){
        $upload_path = "assets/uploads/".$path;
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
        
        if($id){
            $url=$this->get_files_upload_by_id($id);
            if($this->input->post('description'))
            {
                $program['description']=$this->input->post('description');
            }
            if($this->input->post('type'))
            {
                $program['modul']=$this->input->post('type');
            }
            $program['title']=$this->input->post('title');
            $program['updated'] = date("Y-m-d");
            if($this->upload->do_upload($form))
            {
                $atch = $this->upload->data();
                unlink($url->full_url);
                $program['full_url'] = $upload_path.$atch['file_name'];
                $program['file_name'] = $atch['file_name'];
                $program['ext'] = $atch['file_ext'];
            }
            $this->update_files_upload($program,$id);
            $this->upload->reset_multi_upload_data();
            if($this->upload->do_upload($icon)){
                unlink($url->icon);
                $atchs = $this->upload->data();
                $programs['icon'] = $upload_path.$atchs['file_name'];
                $this->update_files_upload($programs,$id);
            }
        } 
        else{
            $program['title']=$this->input->post('title');
            if($this->input->post('description'))
            {
                $program['description']=$this->input->post('description');
            }
            if($this->input->post('type'))
            {
                $modul="";
                $modul=$this->input->post('type');
            }
           if($this->upload->do_upload($form))
            {
                $atch = $this->upload->data();
                
                $file=$this->insert_files_upload_with_full_url_return_id($upload_path,$modul,$submodul, $atch, '0');
                $this->upload->reset_multi_upload_data();
                
            }
            if($this->upload->do_upload($icon)){
                    $atchs = $this->upload->data();
                    $program['icon'] = $upload_path.$atchs['file_name'];
                    
            }
            $this->update_files_upload_with_id($program,$modul,$submodul,$file);
        }
              
	}

    function make_photo_thumb($image_name, $image_location, $target_folder, $w_thumb, $ext_thumb_name){
        $target_folder = "assets/uploads/".$target_folder;
        $thumbnail = $target_folder.'thumb/'.$image_name.$ext_thumb_name;  // Set the thumbnail name
        make_dir($target_folder.'thumb/');
        // Get new sizes
        $upload_image = $image_location;
        list($width, $height) = getimagesize($upload_image);
        $newwidth = $w_thumb;
        $newheight = $w_thumb*$height/$width;
        
        // Load the images
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        
        $stype = explode(".", $image_name);
        $stype = $stype[count($stype)-1];
        switch($stype) {
            case 'gif':
                $source = imagecreatefromgif($upload_image);
                break;
            case 'jpg':
                $source = imagecreatefromjpeg($upload_image);
                break;
            case 'jpeg':
                $source = imagecreatefromjpeg($upload_image);
                break;
            case 'JPG':
                $source = imagecreatefromjpeg($upload_image);
                break;    
            case 'png':
                $source = imagecreatefrompng($upload_image);
                break;
        }
        // Resize the $thumb image.
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        
        // Save the new file to the location specified by $thumbnail
        imagejpeg($thumb, $thumbnail, 80);
    }
    
     /*Function PHP EXCEL for parsing*/ 
    function read_excel($file){
    	$arrres = array();
    	
        if(end(explode(".", $file)) == "xlsx") $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        else $objReader = PHPExcel_IOFactory::createReader('Excel5');

		$objReader->setReadDataOnly(TRUE);

        
		$objPHPExcel = $objReader->load($file);
		
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
	
	function get_pic_employee(){
		$this->db->select("*")->from("user")->where("is_employee",1)->order_by("full_name asc");
		$q = $this->db->get();
		return $q->result_array();
	}
	
	function insert_activity_step($data){
		
	}
}
