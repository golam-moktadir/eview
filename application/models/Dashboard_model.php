<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    public function total_staff()
    {
        return $this->db->count_all_results("staff_info");
    }
    
    public function total_doc()
    {
//        $this->db->where('status', 1);
        return $this->db->count_all_results("doc_con");
    }
    public function total_patient()
    {
//        $this->db->where('status', 1);
        return $this->db->count_all_results("patient");
    }
    public function total_inv()
    {
        $this->db->select('balance');
        $this->db->group_by('unique_id');
        return $this->db->get('inv_receipt')->result(); 
    }
    public function total_op_morning()
    {
        $this->db->select('balance');
        $this->db->group_by('unique_id');
        return $this->db->get('op_receipt')->result(); 
    }
     public function total_op_evening()
    {
        $this->db->select('balance');
        $this->db->group_by('unique_id');
        return $this->db->get('op_receipt_ev')->result(); 
    }
   
    public function total_inactive_client()
    {
        $this->db->where('status', 0);
        return $this->db->count_all_results("client_info");
    }
    public function total_inactive_reseller()
    {
        $this->db->where('status', 0);
        return $this->db->count_all_results("reseller_info");
    }
}

?>