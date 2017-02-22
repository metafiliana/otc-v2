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

    function insert_db($program,$db){
        if($this->db->insert($db, $program)){
           return $this->db->insert_id();
        }
        else{
            return false;
        }
    }

    function update_db($program,$id,$db){
        $this->db->where('id',$id);
        return $this->db->update($db, $program);
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
                $this->db->join($row['table'], $row['in']);
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
}
