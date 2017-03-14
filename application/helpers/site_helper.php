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
    	if($status == "Not Started Yet"){return "#EAEAEA";}
    	elseif($status == "In Progress"){return "#2BD621";}
    	elseif($status == "Completed"){return "#A8D8F0";}
    	elseif($status == "At Risk"){return "#EBF34C";}
    	elseif($status == "Delay"){return "#E73F3F";}
    }
    
    function return_arr_status(){
    	$arr = array("Not Started Yet","In Progress","At Risk","Delay","Completed");
    	return $arr;
    }
    
    function return_all_segments(){
    	$arr = array("Wholesale","SME","Mikro","Individuals","IT","HC","Risk","Organization","Distribution","Performance Management","Marketing");
    	return $arr;
    }

    function return_all_category(){
    $arr = array("Accelerate the growth segment","Deepen client relationship","Integrate the group","Enablers","Stakeholder");
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

    function insert_notification($ctrl,$content,$id_to,$init_id){
        $notif['date_time'] = date('Y-m-d h:i:s');
        $notif['notification'] = $content;
        $notif['status'] = 'unread';
        $notif['user_id_to'] = $id_to;
        $notif['init_id'] = $init_id;

        
        if($ctrl->mremark->insert_notification($notif)){
            return 1;}
        
    }
    
    function excelDateToDate($readDate){
		$phpexcepDate = $readDate-25569; //to offset to Unix epoch
		return strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
	}

    function long_text_real($string,$char){
    echo substr($string,0,$char); 
    if((strlen($string))>$char){echo " . . .";}
    }

    function long_text_all($string,$char){
    echo substr($string,0,$char); 
    if((strlen($string))>$char){echo "";}
    }
    
    
