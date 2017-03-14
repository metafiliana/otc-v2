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
class mkuantitatif_update extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('minitiative');
    }




    //INSERT or CREATE FUNCTION


    function insert_program($program){
        return $this->db->insert('program', $program);
    }

    //GET FUNCTION

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
            $arr[$i]['metric'] = $this->mprogram->get_metric_by_init_code($prog->init_code);
            $arr[$i]['wb_status'] = $this->minitiative->get_init_workblocks_status_new($prog->id);

            $arr[$i]['status'] = $this->get_program_status($prog->id);
            $arr[$i]['wb_total']= $this->get_total_wb_by_program($prog->id);
            $arr[$i]['sub_init_total'] = count($this->minitiative->get_all_program_initiatives($prog->id));
            //count($this->get_total_wb_by_init_code($prog->init_code));
            //$arr[$i]['wb_all_status'] = $this->minitiative->get_init_workblocks_status_init_code($prog->init_code);

            //$arr[$i]['kuantitatif']=$this->get_kuantitatif_by_init_code($prog->init_code);
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
        $this->db->where('kuantitatif_update.init_code', $init_code);
        $this->db->select('kuantitatif_update.*');
        $this->db->join('program','kuantitatif_update.init_code = program.init_code');
        $query = $this->db->get('kuantitatif_update');
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
        $this->db->where('kuantitatif_update.init_code', $init_code);
        $this->db->select('kuantitatif_update.*');
        $this->db->join('program','kuantitatif_update.init_code = program.init_code');
        $query = $this->db->get('kuantitatif_update');
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
        $this->db->select('kuantitatif_update.init_code');
        $this->db->join('program','kuantitatif_update.init_code = program.init_code');
        $query = $this->db->get('kuantitatif_update');
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
}
