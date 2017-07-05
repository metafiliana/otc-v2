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
class Mprogram extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('minitiative');
        $this->load->model('mworkblock');
    }
    
    //INSERT or CREATE FUNCTION
    
    
    function insert_program($program){
        return $this->db->insert('program', $program);
    }
    
    //GET FUNCTION

    function get_all_program($distinct = false, $segment = false)
    {
        if ($distinct)
            $this->db->distinct();

        if ($segment)
            $this->db->select('segment');
        $result = $this->db->get('program');

        return $result->result();
    }
    
    function get_program_by_id($id){
        $this->db->where('id',$id);
        $result = $this->db->get('program');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }
    
    function get_program_by_code($code){
        $this->db->where('code',$code);
        $result = $this->db->get('program');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function get_program_by_init_code($code){
        $this->db->distinct();
        $this->db->select('segment, category, dir_spon, pmo_head,init_code');
        if($code)$this->db->where('init_code',$code);
        $query = $this->db->get('program');
        return $query->result();
    }
    
    function get_segment_programs($segment,$init_id,$dir_spon,$pmo_head){
    	if($segment){
        $this->db->where('category', $segment);
        }
        if($dir_spon){
        $this->db->where('dir_spon', $dir_spon);
        }
        if($pmo_head){
        $this->db->where('pmo_head', $pmo_head);
        }
        if($init_id){
            foreach ($init_id as $row) {
                $this->db->or_where('init_code', $row);
            }
        }
        $this->db->where_in('category',return_all_category());
        //$this->db->order_by('init_code', 'asc');
        //$this->db->order_by('code', 'asc');
        $this->db->select('program.*, initiative.id as init_id');
        $this->db->join('initiative','initiative.id = program.id');
    	$query = $this->db->get('program');
    	$arr = array(); $i=0;
        $progs = $query->result();
        foreach($progs as $prog){
        	$arr[$i]['prog'] = $prog;
        	$code = explode('.',$prog->code);
            $init_id=$prog->init_id;
        	//$arr[$i]['code'] = ($code[0]*100)+$code[1];
        	//$arr[$i]['date'] = $this->minitiative->get_initiative_minmax_date($prog->id);
        	$arr[$i]['lu'] = $this->minitiative->get_initiative_last_update($prog->id);
            $arr[$i]['init'] = $this->minitiative->get_initiative_by_id($init_id);
            $arr[$i]['init_status'] = $this->minitiative->get_status_only_by_prog_id($arr[$i]['init'],$prog->id);
            $arr[$i]['total'] = $this->mprogram->get_kuantitatif_by_init_code($prog->init_code);
            //$arr[$i]['metric'] = $this->mprogram->get_metric_by_init_code($prog->init_code);
            $arr[$i]['wb_status'] = $this->minitiative->get_init_workblocks_status_new($prog->id);

        	$arr[$i]['status'] = $this->get_program_status($prog->id);
            $arr[$i]['wb_total']= $this->get_total_wb_by_program($prog->id);
            $arr[$i]['sub_init_total'] = count($this->minitiative->get_all_program_initiatives($prog->id));
            $arr[$i]['tot_wb_init_code']= count($this->get_total_wb_by_init_code($prog->init_code));
            $arr[$i]['wb_completed'] = $this->minitiative->get_init_workblocks_status_init_code($prog->init_code)['complete'];
            //count($this->get_total_wb_by_init_code($prog->init_code));
            //$arr[$i]['wb_all_status'] = $this->minitiative->get_init_workblocks_status_init_code($prog->init_code);
            
            //$arr[$i]['kuantitatif']=$this->get_kuantitatif_by_init_code($prog->init_code);
        	$i++;
        }
        return $arr;
    }

    function get_segment_program_new(){
        $this->db->where_in('category',return_all_category());
        $this->db->select('program.*, initiative.id as init_id');
        $this->db->join('initiative','initiative.id = program.id');
        $query = $this->db->get('program');
        $arr = array(); $i=0;
        $progs = $query->result();
        foreach($progs as $prog){
            $arr[$i]['prog'] = $prog;
            $code = explode('.',$prog->code);
            $init_id=$prog->init_id;
            $arr[$i]['wb_status'] = $this->minitiative->get_init_workblocks_status_new($prog->id);
            $arr[$i]['wb_total']= $this->get_total_wb_by_program($prog->id);
            $arr[$i]['tot_wb_init_code']= count($this->get_total_wb_by_init_code($prog->init_code));
            $arr[$i]['wb_completed'] = $this->minitiative->get_init_workblocks_status_init_code($prog->init_code)['complete'];
            $i++;
        }
        return $arr;
    }

    function get_segment_programs_by_init_code($init_id){
        $this->db->where('init_code', $init_id);
        $this->db->select('program.*, initiative.id as init_id');
        $this->db->join('initiative','initiative.id = program.id');
        $query = $this->db->get('program');
        $arr = array(); $i=0;
        $progs = $query->result();
        foreach($progs as $prog){
            $arr[$i]['prog'] = $prog;
            $code = explode('.',$prog->code);
            $init_id=$prog->init_id;
            $arr[$i]['lu'] = $this->minitiative->get_initiative_last_update($prog->id);
            $arr[$i]['init'] = $this->minitiative->get_initiative_by_id($init_id);
            $arr[$i]['init_status'] = $this->minitiative->get_status_only_by_prog_id($arr[$i]['init'],$prog->id);
            //$arr[$i]['init_status'] = $this->minitiative->get_initiative_status($init_id,$arr[$i]['init']->end)['status'];
            $arr[$i]['total'] = $this->mprogram->get_kuantitatif_by_init_code($prog->init_code);
            $arr[$i]['wb_status'] = $this->minitiative->get_init_workblocks_status_new($prog->id);

            $arr[$i]['status'] = $this->get_program_status($prog->id);
            $arr[$i]['wb_total']= $this->get_total_wb_by_program($prog->id);
            $arr[$i]['sub_init_total'] = count($this->minitiative->get_all_program_initiatives($prog->id));
            $i++;
        }
        return $arr;
    }
    
    function get_all_programs_with_segment($segment){
    	$this->db->order_by('code', 'asc');
    	if($segment != 'all'){
    		$this->db->where('segment', $segment);
    	}
    	$query = $this->db->get('program');
    	return $query->result();
    }
    
    function get_program_status($program_id){
    	$allstat = return_arr_status();
    	$arr_status = array();
    	foreach($allstat as $each){$arr_status[$each]=0;}
    	$this->db->where('program_id', $program_id);
    	$this->db->select('initiative.*, program.segment');
    	$this->db->join('program','initiative.program_id = program.id');
    	$query = $this->db->get('initiative');
    	$inits = $query->result();
    	foreach($inits as $init){
    		$status = $this->minitiative->get_initiative_status_only($init);
    		if(!$status){
    			if($init->status){$status=$init->status;}
    			else{$status = "Not Started Yet";}
    		}
    		$arr_status[$status] = $arr_status[$status]+1;
    	}
    	return $arr_status;
    }
    
    function get_total_wb_by_program($program_id){
        $this->db->where('program_id', $program_id);
        $this->db->select('initiative.*, program.segment');
        $this->db->join('program','initiative.program_id = program.id');
        $query = $this->db->get('initiative');
        $inits = $query->result();
        $status=""; $total="";
        foreach($inits as $init){
            $status = $this->minitiative->get_total_wb_by_init($init);
            $total += $status;
        }
        return $total;
    }

    function get_total_wb_by_init_code($init_code){
        $this->db->where('code', $init_code);
        $this->db->select('*');
        //$this->db->join('workblock','workblock.code = program.init_code');
        $query = $this->db->get('workblock');
        $inits = $query->result();
        return $inits;
    }

    function get_kuantitatif_by_init_code($init_code){
        $this->db->distinct();
        $this->db->where('kuantitatif.init_code', $init_code);
        $this->db->select('kuantitatif.*');
        $this->db->join('program','kuantitatif.init_code = program.init_code');
        $query = $this->db->get('kuantitatif');
        $inits = $query->result();
        $total=0; $temp=0; $i=0; $hasil=0;
        foreach($inits as $init){

            if($init->realisasi==0 || $init->target==0)
            {
                $temp=0;
            }
            else{
                $temp = (($init->realisasi/$init->target)*100);
            }
            $hasil += $temp;
            $i++;
        }
        if($i!=0){
            $hasil = $hasil/$i;
        }
        return $hasil;
    }

    function get_metric_by_init_code($init_code){
        $this->db->distinct();
        $this->db->where('kuantitatif.init_code', $init_code);
        $this->db->select('kuantitatif.*');
        $this->db->join('program','kuantitatif.init_code = program.init_code');
        $query = $this->db->get('kuantitatif');
        $inits = $query->result();
        $hasil="";
        foreach($inits as $init){


            $hasil = $init->metric;
        }

        return $inits;
    }

    function get_init_code(){
        $this->db->distinct();
        //$this->db->where('kuantitatif.init_code', $init_code);
        $this->db->select('kuantitatif.init_code');
        $this->db->join('program','kuantitatif.init_code = program.init_code');
        $query = $this->db->get('kuantitatif');
        return $query;
    }
    //UPDATE FUNCTION
    
    function update_program($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('program', $program);
    }
    
    //DELETE FUNCTION
    function delete_program(){
    	$id = $this->input->post('id');
    	$this->db->where('id',$id);
    	$this->db->delete('program');
    	if($this->db->affected_rows()>0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    
    // OTHER FUNCTION

    // afil
    function get_all_pmo_head(){
        $sql = 'SELECT a.pmo_head as nama, a.init_code, (((select count(b.id) from workblock b where b.status = "Completed" AND b.code = a.init_code)) / ((select count(c.id) from workblock c where c.code = a.init_code))) as persenan from program a ORDER BY nama, init_code';

        $result = $this->db->query($sql);

        $item = $result->result_array();
        // var_dump($item);die;
        $data = array();
        $initiative = '';
        $nama = '';
        $completed = 0.0;
        $total_completed = 0.0;
        $length = count($result->result_array());

        $j = 0; // counter array $data
        $k = 0; // counter completed
        for ($i=0; $i < $length; $i++) { 
            if ($i == 0){
                $nama = $item[$i]['nama'];
                $ci = $item[$i]['init_code'];
                $initiative .= $ci.';';
                $k = 0; 
            }else{
                if ($item[$i]['nama'] != "$nama"){
                        if ($item[$i]['init_code'] != $ci){
                            $k++;
                            $initiative .= $ci.';';
                            $ci = $item[$i]['init_code'];
                        }
                    $data[$j]['nama'] = $nama;
                    $k = ($k != 0) ? $k : 1;
                    $data[$j]['total_initiative'] = $k;
                    $total_completed = $completed / $k;
                    // $data[$j]['total_completed'] = round($total_completed, 2);
                    $data[$j]['total_completed'] = 0;
                    $data[$j]['initiative'] = $initiative;
                    $j++;
                    $nama = $item[$i]['nama'];

                    $initiative = '';
                    $k = 0;
                }else{
                    $completed = $completed + $item[$i]['persenan'];
                    if ($item[$i]['init_code'] != $ci){
                        $k++;
                        $initiative .= $ci.';';
                        $ci = $item[$i]['init_code'];
                    }
                }
            }
        }

        $role = 'pmo_head';
        foreach ($data as $key => $value) {
            if ($value['nama'] != null){
                $sql1 = 'select t.id, t.'.$role.', t.title, t.code, t.init_code, t.segment, (SELECT COUNT(a.STATUS) FROM workblock a WHERE a.STATUS = "Completed" AND a.code = t.`init_code`) AS status_c, (SELECT COUNT(b.STATUS) FROM workblock b WHERE b.STATUS = "In Progress" AND b.code = t.`init_code`) AS status_i, (SELECT COUNT(c.STATUS) FROM workblock c WHERE c.STATUS = "Delay" AND c.code = t.`init_code`) AS status_d, (SELECT COUNT(d.STATUS) FROM workblock d WHERE d.STATUS = "Not Started Yet" AND d.code = t.`init_code`) AS status_n, (SELECT COUNT(STATUS) FROM workblock z WHERE z.code = t.`init_code`) total_init from program t where '.$role.' = "'.$value['nama'].'" group by t.init_code';
                $result1 = $this->db->query($sql1)->result_array();

                    // $total_completed = 0;
                $total_initiative = 0;
                $total_completed_raw = 0;
                $total_completed = 0;
                $percent_parsial = 0;
                if (!empty($result1)){       
                    foreach ($result1 as $key1 => $value1) {
                            // $total_completed = $total_completed + $value1['status_c'];
                        $total_initiative++;
                        // if ($value1['total_init'] != 0)
                        //     $percent_parsial = $percent_parsial + ($value1['status_c']/ $value1['total_init']) * 100;

                        $get_persen = $this->getPercentProgram($value1['init_code'], false);
                        $total_completed_raw = $total_completed_raw + $get_persen;
                    }
                    if ($total_initiative != 0){
                        // $percent_raw = (float)($percent_parsial/ $total_initiative);
                        // $percent = round((float)$percent_raw, 2);
                        $total_completed = $total_completed_raw / count($result1);
                        $data[$key]['total_completed'] = number_format($total_completed, 2, '.', '');
                    }else{
                        $data[$key]['total_completed'] = 0;
                    }
                }
                $arr_initcode= explode(";",$data[$key]['initiative']);
                    // $arr_initcode= array('9');
                    // var_dump($data[$key]['initiative']);die;
                $hitung_kuantitatif = 0;
                $hitung_kuantitatif = $this->mkuantitatif->get_total_kuantatif($arr_initcode);
                    // var_dump(($hitung_kuantitatif));die;
                $data[$key]['total_kuantitatif'] = $hitung_kuantitatif;
                
                $data[$key]['total_kuantitatif'] = 0;
                if (!empty($hitung_kuantitatif)){
                    $counter = 0;
                    $jumlah_kuantitatif = 0;
                    foreach ($hitung_kuantitatif as $key2 => $value2) {
                        $jumlah_kuantitatif = $this->mkuantitatif->get_count_init_code($key2);
                        // var_dump($jumlah_kuantitatif);die;
                        $hitung_total_kuantitatif[$counter] = $value2 / $jumlah_kuantitatif;

                        $counter = $counter +1;
                    }
                        // $data[$key]['total_kuantitatif'] = $hitung_total_kuantitatif;

                    $total_kuantitatif = array_sum($hitung_total_kuantitatif);
                    $jumlah_total_kuantitatif = $total_kuantitatif / count($hitung_total_kuantitatif);

                    $kuantitatif_percent = round((float)$jumlah_total_kuantitatif, 2);
                    $data[$key]['total_kuantitatif'] = $kuantitatif_percent;
                }
            }
        }
        
        // delete null data
        // array_splice($data, array_search('null', $data), 1);

        foreach ($data as $key => $row) {
            // replace 0 with the field's index/key for sorting compare
            $arsort[$key]  = $row['total_completed'];
        }

        array_multisort($arsort, SORT_DESC, $data);

        return $data;
    }

    function get_all_dir_spon(){
        $sql = 'SELECT a.dir_spon as nama, a.init_code, (((select count(b.id) from workblock b where b.status = "Completed" AND b.code = a.init_code)) / ((select count(c.id) from workblock c where c.code = a.init_code))) as persenan from program a ORDER BY nama, init_code';

        $result = $this->db->query($sql);

        $item = $result->result_array();
        // var_dump($item);die;
        $data = array();
        $nama = '';
        $initiative = '';
        $completed = 0.0;
        $total_completed = 0.0;
        $length = count($result->result_array());

        $j = 0; // counter array $data
        $k = 0; // counter completed
        for ($i=0; $i < $length; $i++) { 
            if ($i == 0){
                $nama = $item[$i]['nama'];
                $ci = $item[$i]['init_code'];
                $k = 0; 
            }else{
                if ($item[$i]['nama'] != "$nama"){
                        if ($item[$i]['init_code'] != $ci){
                            $k++;
                            $initiative .= $ci.';';
                            $ci = $item[$i]['init_code'];
                        }
                    $data[$j]['nama'] = $nama;
                    $k = ($k != 0) ? $k : 1;
                    $data[$j]['total_initiative'] = $k;
                    $total_completed = $completed / $k;
                    // $data[$j]['total_completed'] = round($total_completed, 2);
                    $data[$j]['total_completed'] = 0;
                    $data[$j]['initiative'] = $initiative;
                    $j++;
                    $nama = $item[$i]['nama'];

                    $initiative = '';
                    $k = 0;
                }else{
                    $completed = $completed + $item[$i]['persenan'];
                    if ($item[$i]['init_code'] != $ci){
                        $k++;
                        $initiative .= $ci.';';
                        $ci = $item[$i]['init_code'];
                    }
                }
            }
        }

        $role = 'dir_spon';
        foreach ($data as $key => $value) {
            if ($value['nama'] != null){
                $sql1 = 'select t.id, t.'.$role.', t.title, t.code, t.init_code, t.segment, (SELECT COUNT(a.STATUS) FROM workblock a WHERE a.STATUS = "Completed" AND a.code = t.`init_code`) AS status_c, (SELECT COUNT(b.STATUS) FROM workblock b WHERE b.STATUS = "In Progress" AND b.code = t.`init_code`) AS status_i, (SELECT COUNT(c.STATUS) FROM workblock c WHERE c.STATUS = "Delay" AND c.code = t.`init_code`) AS status_d, (SELECT COUNT(d.STATUS) FROM workblock d WHERE d.STATUS = "Not Started Yet" AND d.code = t.`init_code`) AS status_n, (SELECT COUNT(STATUS) FROM workblock z WHERE z.code = t.`init_code`) total_init from program t where '.$role.' = "'.$value['nama'].'" group by t.init_code';
                $result1 = $this->db->query($sql1)->result_array();

                // $total_completed = 0;
                $total_initiative = 0;
                $total_completed_raw = 0;
                $total_completed = 0;
                $percent_parsial = 0;
                if (!empty($result1)){       
                    foreach ($result1 as $key1 => $value1) {
                        // $total_completed = $total_completed + $value1['status_c'];
                        $total_initiative++;
                        // if ($value1['total_init'] != 0)
                        //     $percent_parsial = $percent_parsial + ($value1['status_c']/ $value1['total_init']) * 100;

                        $get_persen = $this->getPercentProgram($value1['init_code'], false);
                        $total_completed_raw = $total_completed_raw + $get_persen;
                    }
                    if ($total_initiative != 0){
                        // $percent_raw = (float)($percent_parsial/ $total_initiative);
                        // $percent = round((float)$percent_raw, 2);
                        // $value['total_completed'] = $percent;
                        // $data[$key]['total_completed'] = $percent;

                        $total_completed = $total_completed_raw / count($result1);
                        $data[$key]['total_completed'] = number_format($total_completed, 2, '.', '');
                    }else{
                        $data[$key]['total_completed'] = 0;
                    }
                }
                $arr_initcode= explode(";",$data[$key]['initiative']);
                    // $arr_initcode= array('9');
                    // var_dump($data[$key]['initiative']);die;
                $hitung_kuantitatif = 0;
                $hitung_kuantitatif = $this->mkuantitatif->get_total_kuantatif($arr_initcode);
                    // var_dump(($hitung_kuantitatif));die;
                $data[$key]['total_kuantitatif'] = $hitung_kuantitatif;
                
                $data[$key]['total_kuantitatif'] = 0;
                if (!empty($hitung_kuantitatif)){
                    $counter = 0;
                    $jumlah_kuantitatif = 0;
                    foreach ($hitung_kuantitatif as $key2 => $value2) {
                        $jumlah_kuantitatif = $this->mkuantitatif->get_count_init_code($key2);
                        // var_dump($jumlah_kuantitatif);die;
                        $hitung_total_kuantitatif[$counter] = $value2 / $jumlah_kuantitatif;

                        $counter = $counter +1;
                    }
                        // $data[$key]['total_kuantitatif'] = $hitung_total_kuantitatif;

                    $total_kuantitatif = array_sum($hitung_total_kuantitatif);
                    $jumlah_total_kuantitatif = $total_kuantitatif / count($hitung_total_kuantitatif);

                    $kuantitatif_percent = round((float)$jumlah_total_kuantitatif, 2);
                    $data[$key]['total_kuantitatif'] = $kuantitatif_percent;
                }
            }
        }
        
        // delete null data
        array_splice($data, array_search('null', $data), 1);

        foreach ($data as $key => $row) {
            // replace 0 with the field's index/key for sorting compare
            $arsort[$key]  = $row['total_completed'];
        }

        array_multisort($arsort, SORT_DESC, $data);

        return $data;
    }

    //role = pmo_head
    //role = dir_spon
    //role = Co-PMO
    function getProgramByRole($init_code)
    {
        // if ($role == 'pmo_head'){
        //     $nama = $this->mprogram->get_all_pmo_head();
        // }elseif($role == 'dir_spon'){
        //     $nama = $this->mprogram->get_all_dir_spon();
        // }elseif ($role == 'Co-PMO') {
        //     # code...
        // }

        $sql = 'select id, code, title, init_code from program where init_code = "'.$init_code.'"';
        $result = $this->db->query($sql);

        return $result->result_array();
    }

    function getInitCode($nama, $role)
    {
        // if ($role == 'pmo_head'){
        //     $nama = $this->mprogram->get_all_pmo_head();
        // }elseif($role == 'dir_spon'){
        //     $nama = $this->mprogram->get_all_dir_spon();
        // }elseif ($role == 'Co-PMO') {
        //     # code...
        // }

        // $sql = 'select id, '.$role.', title, code, init_code, segment from program where '.$role.' = "'.$nama.'" group by init_code';
        if ($role == 'pmo_head' || $role == 'dir_spon'){
            $sql = 'select t.id, t.'.$role.', t.title, t.code, t.init_code, t.segment, (SELECT COUNT(a.STATUS) FROM workblock a WHERE a.STATUS = "Completed" AND a.code = t.`init_code`) AS status_c, (SELECT COUNT(b.STATUS) FROM workblock b WHERE b.STATUS = "In Progress" AND b.code = t.`init_code`) AS status_i, (SELECT COUNT(c.STATUS) FROM workblock c WHERE c.STATUS = "Delay" AND c.code = t.`init_code`) AS status_d, (SELECT COUNT(d.STATUS) FROM workblock d WHERE d.STATUS = "Not Started Yet" AND d.code = t.`init_code`) AS status_n, (SELECT COUNT(STATUS) FROM workblock z WHERE z.code = t.`init_code`) total_init from program t where '.$role.' = "'.$nama.'" group by t.init_code';
            $result = $this->db->query($sql)->result_array();

            foreach ($result as $key => $value) {
                $result[$key]['percent'] = $this->getPercentProgram($value['init_code']);
            }
        }elseif ($role == 'co_pmo'){
            $data = $this->muser->getInitiative($nama);

            if (!is_array($data['initiative'])){
                $sql = 'SELECT t.id, t.`title`, t.`code`, t.init_code, t.`segment`, t.`nama`, (SELECT COUNT(a.STATUS) FROM workblock a WHERE a.STATUS = "Completed" AND a.code = t.`init_code`) AS status_c, (SELECT COUNT(b.STATUS) FROM workblock b WHERE b.STATUS = "In Progress" AND b.code = t.`init_code`) AS status_i, (SELECT COUNT(c.STATUS) FROM workblock c WHERE c.STATUS = "Delay" AND c.code = t.`init_code`) AS status_d, (SELECT COUNT(d.STATUS) FROM workblock d WHERE d.STATUS = "Not Started Yet" AND d.code = t.`init_code`) AS status_n, (SELECT COUNT(STATUS) FROM workblock z WHERE z.code = t.`init_code`) total_init FROM (SELECT f.*, e.`name` AS nama FROM program f RIGHT JOIN user e ON e.`initiative` = f.`init_code`) t WHERE t.nama = "'.$nama.'" GROUP BY t.init_code';
                $result = $this->db->query($sql)->result_array();
                $result[0]['percent'] = $this->getPercentProgram($result[0]['init_code']);
            }else{
                $result = array();
                foreach ($data['initiative'] as $key => $value) {
                    $sql = 'SELECT t.id, t.`title`, t.`code`, t.init_code, t.`segment`, t.`nama`, (SELECT COUNT(a.STATUS) FROM workblock a WHERE a.STATUS = "Completed" AND a.code = t.`init_code`) AS status_c, (SELECT COUNT(b.STATUS) FROM workblock b WHERE b.STATUS = "In Progress" AND b.code = t.`init_code`) AS status_i, (SELECT COUNT(c.STATUS) FROM workblock c WHERE c.STATUS = "Delay" AND c.code = t.`init_code`) AS status_d, (SELECT COUNT(d.STATUS) FROM workblock d WHERE d.STATUS = "Not Started Yet" AND d.code = t.`init_code`) AS status_n, (SELECT COUNT(STATUS) FROM workblock z WHERE z.code = t.`init_code`) total_init FROM (SELECT f.*, e.`name` AS nama FROM program f RIGHT JOIN user e ON f.`init_code` = "'.$value.'") t WHERE t.nama = "'.$nama.'" GROUP BY t.init_code';
                    $hasil = $this->db->query($sql)->result_array();

                    array_push($result, $hasil[0]);
                    $result[$key]['percent'] = $this->getPercentProgram($result[$key]['init_code']);
                }
            }

        }elseif ($role == 'initiatives'){
            $select = 'init_code';
            $sql = 'select t.id, t.'.$select.', t.title, t.code, t.init_code, t.segment, (SELECT COUNT(a.STATUS) FROM workblock a WHERE a.STATUS = "Completed" AND a.code = t.`init_code`) AS status_c, (SELECT COUNT(b.STATUS) FROM workblock b WHERE b.STATUS = "In Progress" AND b.code = t.`init_code`) AS status_i, (SELECT COUNT(c.STATUS) FROM workblock c WHERE c.STATUS = "Delay" AND c.code = t.`init_code`) AS status_d, (SELECT COUNT(d.STATUS) FROM workblock d WHERE d.STATUS = "Not Started Yet" AND d.code = t.`init_code`) AS status_n, (SELECT COUNT(STATUS) FROM workblock z WHERE z.code = t.`init_code`) total_init from program t where '.$select.' = "'.$nama.'" group by t.init_code';
            $result = $this->db->query($sql)->result_array();
            $result[0]['percent'] = $this->getPercentProgram($result[0]['init_code']);
        }

        return $result;
    }

    function getDataChartWorkstream()
    {
        $query = 'SELECT title FROM program GROUP BY title';
        $result = $this->db->query($query)->result_array();

        return $result;
    }

    function getPercentProgram($init_code, $format = true)
    {
        //get percent per program
        $percent_all_raw = 0;
        $data_program = $this->mprogram->getProgramByRole($init_code);
        foreach ($data_program as $key2 => $value2) {
            $total_complete = 0;
            $total_init = 0;
            $data_percent_program = $this->minitiative->getInitiativeByProgramId($value2['id']);

            foreach ($data_percent_program as $key1 => $value1) {
                $total_complete = $total_complete + $value1->total_c;
                $total_init = $total_init + $value1->total_w;
            }
            $percent = 0;
            if ($total_init != 0){
                $percent = ($total_complete / $total_init) * 100;
            }
            $percent_all_raw = $percent_all_raw + $percent;
        }
        $percent_all = $percent_all_raw / count($data_program);

        $result = $percent_all;

        if ($format == true)
            $result = number_format($percent_all, 2, '.', '');

        return $result;
    }
}
