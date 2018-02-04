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
class Mkuantitatif extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('minitiative');
    }

    //INSERT or CREATE FUNCTION

    function insert_kuantitatif($program){
        if($this->db->insert('kuantitatif', $program)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function insert_kuantitatif_legend($program){
        if($this->db->insert('kuantitatif_legend', $program)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function insert_kuantitatif_update($program){
        if($this->db->insert('kuantitatif_update', $program)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function insert_db($program,$db){
        if($this->db->insert($db, $program)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function insert_baseline($program){
        if($this->db->insert('baseline', $program)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    //GET FUNCTION

    //otc v2
    function get_kuanitatif_and_update(){
        $arr_month=['January','February','March','April','May','June','July','August','September','October','November','December'];
        foreach ($arr_month as $arr) {
          $this->db->select('kuantitatif.'.$arr.'');
          $this->db->select('kuantitatif_update.'.$arr.' as u_'.$arr.'');
        }
        $this->db->select('kuantitatif.init_code,kuantitatif.type,kuantitatif.metric,kuantitatif.measurment,kuantitatif.measurment,kuantitatif.target,kuantitatif.target_year,kuantitatif.baseline,kuantitatif.baseline_year');
        $this->db->join('kuantitatif_update','kuantitatif.id = kuantitatif_update.id');
        $this->db->order_by('kuantitatif.id', 'asc');
        $query = $this->db->get('kuantitatif');
        return $query->result();
    }

    function get_leading_lagging($id,$month,$type){
        $query = $this->db->where('init_id',$id)->where('type',$type)->order_by('id', 'asc')->get('kuantitatif');
        $arr = array(); $i=0;
        $progs = $query->result();
        $legend = $this->get_id_different_sum_kuantitatif();
        foreach($progs as $prog){
        	  $arr[$i]['prog'] = $prog;
            $arr[$i]['update'] = $this->get_update_by_id($prog->id,$month);
            $arr[$i]['target'] = $this->get_month_target_by_id($prog->id,$month);
            if(in_array($prog->id,$legend,TRUE)){
              if ($arr[$i]['update']->$month==0 || $arr[$i]['target']->$month==0 || $prog->target==0) {
                $arr[$i]['month_kiner'] = 0;
                $arr[$i]['year_kiner'] = 0;
              }
              else{
                $arr[$i]['month_kiner'] = (1-(($arr[$i]['update']->$month-$arr[$i]['target']->$month)/$arr[$i]['target']->$month));
                $arr[$i]['year_kiner'] = (1-(($arr[$i]['update']->$month-$prog->target)/$prog->target));
              }
            }
            else if ($arr[$i]['update']->$month==0 || $arr[$i]['target']->$month==0 || $prog->target==0) {
              $arr[$i]['month_kiner'] = 0;
              $arr[$i]['year_kiner'] = 0;
            }
            else{
              $arr[$i]['month_kiner'] = ($arr[$i]['update']->$month/$arr[$i]['target']->$month);
              $arr[$i]['year_kiner'] = ($arr[$i]['update']->$month/$prog->target);
            }
        	  $i++;
        }
        return $arr;
        //return $query;
    }

    function get_total_per_type($id,$month,$type){
        $query = $this->db->where('init_id',$id)->where('type',$type)->order_by('id', 'asc')->get('kuantitatif');
        $arr = array(); $i=0;
        $progs = $query->result();
        $tot['month']=""; $tot['year']="";
        $legend = $this->get_id_different_sum_kuantitatif();
        foreach($progs as $prog){
        	  $arr[$i]['prog'] = $prog;
            $arr[$i]['update'] = $this->get_update_by_id($prog->id,$month);
            $arr[$i]['target'] = $this->get_month_target_by_id($prog->id,$month);
            if(in_array($prog->id,$legend,TRUE)){
              if ($arr[$i]['update']->$month==0 || $arr[$i]['target']->$month==0 || $prog->target==0) {
                $tot['month'] += 0;
                $tot['year'] += 0;
              }
              else{
                $tot['month'] += (1-(($arr[$i]['update']->$month-$arr[$i]['target']->$month)/$arr[$i]['target']->$month));
                $tot['year'] += (1-(($arr[$i]['update']->$month-$prog->target)/$prog->target));
              }
            }
            else if ($arr[$i]['update']->$month==0 || $arr[$i]['target']->$month==0 || $prog->target==0) {
              $tot['month'] += 0;
              $tot['year'] += 0;
            }
            else{
              $tot['month'] += ($arr[$i]['update']->$month/$arr[$i]['target']->$month);
              $tot['year'] += ($arr[$i]['update']->$month/$prog->target);
            }
            $i++;
        }
        return $tot;
        //return $query;
    }

    function get_leading_leading_count($id,$type){
        $this->db->select('init_id');
        $this->db->where('init_id',$id);
        $this->db->where('type',$type);
        $query = $this->db->get('kuantitatif');
        return count($query->result());
    }

    function get_all_kuantitatif_by_id($id){
        $this->db->where('id',$id);
        $result = $this->db->get('kuantitatif');
        $all['kuantitatif']=$result->row(0);
        $all['update'] = $this->get_update_by_id($id,'');
        return $all;
    }

    function get_id_different_sum_kuantitatif(){
      $this->db->select('kuan_id');
      $query = $this->db->get('kuantitatif_legend');
      $result = $query->result();
      $all=array();
      foreach ($result as $key) {
        array_push($all,$key->kuan_id);
      }
      return $all;
    }

    function lagging($id){
        $query = $this->db->where('init_id',$id)->where('type','Lagging')->get('kuantitatif');
        return $query;
    }

    function get_kuantitatif(){
        $query = $this->db->get('kuantitatif');
        return $query;
    }

    function getAllKuantitatifUpdate(){
        $query = $this->db->get('kuantitatif_update');
        return $query;
    }

    function get_kuantitatif_by_user($init_id){
        $this->db->select('*');
        if($init_id){
            foreach ($init_id as $row) {
                $this->db->or_where('init_code', $row);
            }
        }
        $query = $this->db->get('kuantitatif');
        return $query;
    }

    function get_kuantitatif_by_id($id){
        $this->db->where('id',$id);
        $result = $this->db->get('kuantitatif');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function get_kuantitatif_by_init_code($init_code){
        $this->db->select('id, metric, type');
        $this->db->where('init_code',$init_code);
        $result = $this->db->get('kuantitatif');
        return $result->result();
    }

    function get_update_by_id($id,$month){
        if($month){
          $this->db->select($month);
        }
        $this->db->where('id',$id);
        $result = $this->db->get('kuantitatif_update');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function get_month_target_by_id($id,$month){
        $this->db->select($month);
        $this->db->where('id',$id);
        $result = $this->db->get('kuantitatif');
        if($result->num_rows==1){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function get_baseline_by_kuan_id($id){
        $this->db->select('amount_baseline','year');
        $this->db->where('kuantitatif_id',$id);
        $result = $this->db->get('baseline');
        return $result->result();
    }

    function get_kuantitatif_update($id){
        $this->db->where('id_kuan',$id);
        $this->db->order_by('id_kuan', 'desc');
        $result = $this->db->get('kuantitatif_update');
        if($result){
            return $result->row(0);
        }else{
            return false;
        }
    }

    function check_data_kuantitatif_update($year){
        $this->db->select('year');
        $this->db->where('year',$year);
        $result = $this->db->get('kuantitatif_update');
        if(count($result->result())>0){
            return true;
        }else{
            return false;
        }
    }

    function get_all_kuantitatif_update($id,$year){
        $this->db->where('id_kuan',$id);
        $this->db->where('year',$year);
        $this->db->order_by('id', 'asc');
        $result = $this->db->get('kuantitatif_update');
        if($result){
            return $result->result();
        }
    }

    function get_kuantitatif_with_update($init_id){
        $this->db->select('*');
        if($init_id){
            foreach ($init_id as $row) {
                $this->db->or_where('init_code', $row);
            }
        }
    	$query = $this->db->get('kuantitatif');
    	$arr = array(); $i=0;
        $progs = $query->result();
        foreach($progs as $prog){
        	$arr[$i]['prog'] = $prog;
            $arr[$i]['update'] = $this->get_kuantitatif_update($prog->id);
            $arr[$i]['percentage'] = $this->get_total_kuantitatif_by_id($prog->id,$prog->metric);
        	$i++;
        }
        return $arr;
    }

    function get_total_kuantatif($init_id = null){
        $this->db->select('*');
        if($init_id){
            foreach ($init_id as $row) {
                $this->db->or_where('init_code', $row);
            }
        }
        //$this->db->where('init_code','1b');
        $query = $this->db->get('kuantitatif');
        $arr = array(); $init="";
        $progs = $query->result();
        foreach($progs as $prog){
           if(!isset($arr[$prog->init_code])){
            $arr[$prog->init_code]=0;
           }
           $arr[$prog->init_code] += $this->get_total_kuantitatif_by_id($prog->id,$prog->metric);
        }
        return $arr;
    }

    function get_total_kuantitatif_by_id($id,$npl){
        $total=0;$realisasi=0;
        $this->db->select('*');
        $this->db->where('id',$id);
        $query = $this->db->get('kuantitatif');
        $res = $query->row();
        if($this->get_kuantitatif_update($id))
        {
            $realisasi=$this->get_kuantitatif_update($id)->amount;
            $total=(($realisasi/$res->target)*100);
        }
        if(strpos($npl,"NPL")!==false){
           if($this->get_kuantitatif_update($id))
            {
                $realisasi=$this->get_kuantitatif_update($id)->amount;
                $total=(($res->target/$realisasi)*100);
            }
            else{
                $realisasi=$res->realisasi;
                $total=(($res->target/$realisasi)*100);
            }

        }
        else if($res->target==0)
        {
            $total=0;
        }
        else{
            $realisasi=$res->realisasi;
            $total=(($realisasi/$res->target)*100);
        }

        return $total;
    }

    function get_init_code_on_kuantitatif(){
        $this->db->distinct();
        $this->db->select('init_code');
        $query = $this->db->get('kuantitatif');
        $arr = array(); $i=0;
        $progs = $query->result();
        foreach($progs as $prog){
            $arr[$i]['code'] = $prog;
            $arr[$i]['count_code'] = $this->get_count_init_code($prog->init_code);
            $i++;
        }
        return $arr;
    }

    function get_count_init_code($ic){
        $this->db->select('init_code');
        $this->db->where('init_code',$ic);
        $query = $this->db->get('kuantitatif');
        return count($query->result());
    }

    function get_last_data_kuantitatif(){
        return $this->db->select('*')->order_by('id',"desc")->limit(1)->get('kuantitatif');
    }

    function get_year_kuantitatif_update(){
        $this->db->distinct();
        $this->db->select('year');
        $query = $this->db->get('kuantitatif_update');
        return $query->result()[0]->year;
    }

    function get_all_programs_with_segment($segment){
    	$this->db->order_by('code', 'asc');
    	if($segment != 'all'){
    		$this->db->where('segment', $segment);
    	}
    	$query = $this->db->get('program');
    	return $query->result();
    }

    //UPDATE FUNCTION

    function update_kuantitatif($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('kuantitatif', $program);
    }

    function update_kuantitatif_update($program,$id){
        $this->db->where('id',$id);
        return $this->db->update('kuantitatif_update', $program);
    }

    function update_db($program,$id,$db){
        $this->db->where('id',$id);
        return $this->db->update($db , $program);
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

    function delete_kuantitatif_update($id){
        $this->db->where('id',$id);
        $this->db->delete('kuantitatif_update');
        if($this->db->affected_rows()>0){
            return true;
        }
        else{
            return false;
        }
    }

    function delete_db_id($db,$id){
        $this->db->where('id',$id);
        $this->db->delete($db);
        if($this->db->affected_rows()>0){
            return true;
        }
        else{
            return false;
        }
    }

    function get_action_by_init_code_kpi($id,$id_action){
        if($id){
          $this->db->where('init_id', $id);
        }
        if($id_action){
          $this->db->where('id', $id_action);
        }
        $this->db->select('*');
        $this->db->order_by('id','asc');
        $query = $this->db->get('kuantitatif');
        $kuan = $query->result();
        return $kuan;
    }

    public function detail_mkuantitatif($id){
        $this->db->where('id',$id);
        $query = $this->db->get('kuantitatif');

        $result = $query->result();
        return $result;
    }



    // OTHER FUNCTION
    // -- afil --
    function getKuantitatifByInitCode($init_code)
    {
        $this->db->select('title, init_code');
        $this->db->where('init_code',$init_code);
        $this->db->group_by('init_code');
        $this->db->order_by('title', 'asc');
        $query = $this->db->get('kuantitatif');

        $result = $query->result();
        return $result;
    }

    function getKuantitatifDetailByInitCode($init_code)
    {
        $this->db->select('*');
        $this->db->where('init_code', $init_code);
        $this->db->order_by('init_code', 'asc');
        $query = $this->db->get('kuantitatif');

        $result = $query->result();
        return $result;
    }

    function getSummaryLeadingLaggingAll($init_code = false, $type = false, $get = false, $month = false)
    {
        $where = ' WHERE t.type IN ("Leading", "Lagging")';

        if ($type)
            $where = ' WHERE t.type = "'.$type.'"';

        if ($init_code)
            $where .= ' AND t.init_code = "'.$init_code.'"';

        $sql = 'select t.id, t.init_code, t.type, t.init_id, t.target_year, t.target, t.'.$month.' as target_month , ku.* from kuantitatif t right join kuantitatif_update ku on ku.id = t.id and ku.`year` = t.target_year'.$where;

        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    function getSummaryKuantitatif($array_in = false)
    {
        $where = '';
        if ($array_in)
            $where = ' WHERE init_id IN ('.$array_in.')';
        $sql = '
            SELECT id,
            CASE WHEN (target = 0) THEN
            "-"
            ELSE
            type
            END as type,
            init_id
            from kuantitatif '.$where.' ORDER BY init_id';

        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    function getSummaryKuantitatifInit($array_in = false)
    {
        $where = '';
        if ($array_in)
            $where = ' WHERE init_id IN ('.$array_in.')';
        $sql = '
            SELECT init_id
            from kuantitatif '.$where.' ORDER BY init_id';

        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    function getLastMonthUpdated()
    {
        $bulan = getMonth(true);
        $return = date('Y-m-d');

        foreach ($bulan as $key => $value) {
            $this->db->where($key.' > 0');
            $query = $this->db->get('kuantitatif_update')->result_array();

            // if (count($query) > 50){
            if (count($query) > 0){
                $return = date('Y-m-t', strtotime($key));
            }
        }

        return $return;
    }
}
