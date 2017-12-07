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

    function user_role($no_role){
    	if($no_role == 1){return "Co-PMO";}
    	elseif($no_role == 2){return "Admin";}
    	elseif($no_role == 3){return "PMO Head";}
    	elseif($no_role == 4){return "Direktur Sponsor";}
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
        $notif['admin_stat'] = 'unread';


        if($ctrl->mremark->insert_notification($notif)){
            return 1;}

    }


    function plus_icon(){
    $src = get_icon_url('plus.png');
    echo "<img style=\"height:20px;\" src='".$src."'>";
    }

    function icon_small($img){
    $src = get_icon_url($img);
    echo "<img style=\"height:20px;\" src='".$src."'>";
    }

    function icon_url($img){
    echo base_url()."assets/img/icon/".$img;
    }

    function get_icon_url($img){
        return base_url()."assets/img/icon/".$img;
    }

    function get_ext_icon($ext){
    $arr_img = array('.jpg','.png','.jpeg');

    if($ext == ".doc" || $ext == ".docx"){$img = "word - color";}
    elseif($ext == ".xls" || $ext == ".xlsx"){$img = "xlx - color";}
    elseif($ext == ".ppt" || $ext == ".pptx"){$img = "ppt - color";}
    elseif($ext == ".pdf"){$img = "pdf - color";}
    elseif(in_array($ext, $arr_img)){$img = "gallery - color";}
    else{$img = "copy - color";}

    return get_icon_url($img.'.png');
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

    function getMonth($is_string = false)
    {
        if (!$is_string){
            $data = array(
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
            );
        }else{
            $data = array(
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember',
            );
        }

        return $data;
    }

    function indikatorWarna($score = 0)
    {
        $score = (int)$score;

        if ($score >= 100){
            $warna = 'green';
        }

        else if ($score <= 95){
            $warna = 'red';
        }
        else {
          $warna = 'yellow';
        }

        $html = "<i class='bullet-".$warna."'>&#8226</i>";

        return $html;
    }

    function warna($score = 0)
    {
        $score = (int)$score;
        if ($score >= 100){
            $warna = 'green';
        }

        else if ($score <= 95){
            $warna = 'red';
        }
        else {
          $warna = 'yellow';
        }
        return $warna;
    }
    function warnaborder($score = 0)
    {
        $score = (int)$score;
        if ($score >= 100){
            $warna = '#084a09';
        }

        else if ($score <= 95){
            $warna = '#6f0606';
        }
        else {
          $warna = '#9ca108';
        }
        return $warna;
    }

    function maxscore($score = 0, $type)
    {
        $score = (float)$score;
        if($type=='Leading'){
          if ($score > 100){
              $score = 100;
          }
          else {
            $score = $score;
          }
        }
        else{
          if ($score > 130){
              $score = 130;
          }
          else {
            $score = $score;
          }
        }

        return $score;
    }

    function getListUser($initiative = false)
    {
        $list = array(
            0 => '- All -',
            1 => 'CO-PMO',
            3 => 'PMO',
            4 => 'Direktur Sponsor',
        );

        if ($initiative){
            // array_push($list, 'Initiative');
        }

        return $list;
    }

    function getUserRole($role = 0)
    {
        $return = 'Initiative';

        $list = array(
            1 => 'CO-PMO',
            3 => 'PMO',
            4 => 'Direktur Sponsor',
        );

        foreach ($list as $key => $value) {
            if ($key == $role){
                $return = $value;
                break;
            }
        }

        return $return;
    }

    function convertMonth($month, $is_string = false)
    {
        $data = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        );

        if (!$is_string){
            foreach ($data as $key => $value) {
                if ($key == $month){
                    $month = $value;

                    break;
                }
            }
        }else{
            foreach ($data as $key => $value) {
                if ($value == $month){
                    $month = $key;

                    break;
                }
            }
        }

        return $month;
    }

?>
