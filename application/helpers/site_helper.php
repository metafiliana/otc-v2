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
   	
    function segment_abv($initial){
    	if($initial == "Wholesale"){return "WS";}
		elseif($initial ==  "Individuals"){return 'Ind';}
		elseif($initial ==  "Organization"){return 'Org';}
		elseif($initial ==  "Performance Management"){return 'PM';}
		else{return $initial;}
    }
    
    function sign_status($status){
    	if($status == "Not Started Yet"){return "circle-notyet";}
    	elseif($status == "In Progress"){return "circle-inprog";}
    	elseif($status == "Completed"){return "circle-completed";}
    	elseif($status == "At Risk"){return "circle-atrisk";}
    	elseif($status == "Delay"){return "circle-delay";}
    }
    
    function color_status($status){
    	if($status == "Not Started Yet"){return "#bbb";}
    	elseif($status == "In Progress"){return "#27c24c";}
    	elseif($status == "Completed"){return "#337ab7";}
    	elseif($status == "At Risk"){return "#F6C600";}
    	elseif($status == "Delay"){return "#FF0000";}
    }
    
    function return_arr_status(){
    	$arr = array("Not Started Yet","In Progress","At Risk","Delay","Completed");
    	return $arr;
    }
    
    function return_all_segments(){
    	$arr = array("Wholesale","SME","Mikro","Individuals","IT","HC","Risk","Organization","Distribution","Performance Management","Marketing");
    	return $arr;
    }
    
    function insert_logact($contr,$segment,$content){
    	$user = $contr->session->userdata('user');
    	$log['user_id'] = $user['id'];
		$log['segment'] = $segment;
		$log['date'] = date('Y-m-d h:i:s');
		$log['content'] = $content;
		
		if($contr->mlogact->insert_logact($log)){
			return 1;}
    	
    }
    
    function excelDateToDate($readDate){
		$phpexcepDate = $readDate-25569; //to offset to Unix epoch
		return strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
	}
    
    
