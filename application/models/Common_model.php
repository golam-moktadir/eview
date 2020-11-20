<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {
    public function trans_start()
    {
       return $this->db->trans_start();
    }
    public function trans_complete()
    {
       return $this->db->trans_complete();
    }
    public function trans_status()
    {
        if ($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            return true;
        }else{
            $this->db->trans_rollback();
            return false;
        }
    }
    public function duplicate_check($table_name,$index_array,$id=null)
    {
        $this->db->from($table_name);
        $this->db->where($index_array);
        
        if($id!=''){
            $this->db->where_not_in('record_id', $id);
        }
        return $this->db->get()->num_rows();
    }
    function get_max_id($table_name,$coloum, $serial=1)
    {
         $this->db->select_max($coloum);
         $this->db->limit(1);
         $max_id = $this->db->get($table_name)->row()->$coloum;
         
         if(isset($max_id) && $max_id > 0)
         {
             $max_id = $max_id+1;
         }else{
             $max_id = $serial;
         }
         
         return $max_id;
    }
    public function update($table_name,$data,$index_array)
    {
        $this->db->update($table_name,$data,$index_array);
        return true;
    }

   
    function get_distinct_value_orderby($column_name, $table_name) {
        $this->db->select($column_name);
        $this->db->order_by('record_id', 'DESC');
        $this->db->distinct();
        $query = $this->db->get($table_name);
        return $query->result();
    }
    function get_sub_category($category_id) {
        $this->db->select("SC.*, CG.category");
        $this->db->from('sub_category as SC');
        $this->db->join('category as CG', "SC.category_id = CG.record_id", 'left');
        $this->db->where('SC.category_id', $category_id);
        return $this->db->get()->result();
    }

    function update_data_all_column($table_name, $data) {
        $this->db->update($table_name, $data);
    }

    function group_by_sum($table_name, $distinct_column, $sum_column1, $sum_column2) {
        $this->db->select('' . $distinct_column . ', SUM(' . $sum_column1 . ') AS sum_result1, SUM(' . $sum_column2 . ') AS sum_result2');
        $this->db->group_by($distinct_column);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function group_by_data_where($table_name, $where_array, $distinct_column) {
        $this->db->where($where_array);
        $this->db->group_by($distinct_column);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function only_group_by($table_name, $distinct_column) {
        $this->db->group_by($distinct_column);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function data_date_to_date_group_by($table_name, $distinct_column, $date_column, $date_from, $date_to) {
        $this->db->where($date_column . '>=', $date_from);
        $this->db->where($date_column . '<=', $date_to);
        $this->db->group_by($distinct_column);
        $this->db->order_by($date_column);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function get_distinct_value_where($column_name, $table_name, $column_with_value_array) {
        $this->db->select($column_name);
        $this->db->distinct();
        $this->db->where($column_with_value_array);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function get_distinct_value_where_brand_po($column_name, $table_name, $brand, $po) {
        $this->db->select($column_name);
        $this->db->distinct();
        if ($brand!='') {
            $this->db->where("brand", $brand);
        }
        if ($po!='') {
           $this->db->where("po_no", $po);
        }
        $this->db->order_by('record_id', 'desc');
        
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function get_distinct_value($column_name, $table_name) {
        $this->db->select($column_name);
        $this->db->distinct();
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function get_distinct_value_order_by($column_name, $table_name) {
        $this->db->order_by('record_id', 'DESC');
        $this->db->select($column_name);
        $this->db->distinct();
        $query = $this->db->get($table_name);
        return $query->result();
    }
    function get_distinct_value_order_by_where($column_name, $table_name,$column_with_value_array,$ordercoloum,$ordertype) {
        $this->db->order_by($ordercoloum, $ordertype);
        $this->db->select($column_name);
        $this->db->where($column_with_value_array);
        $this->db->distinct();
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function get_last_data_byid($table_name, $where_column, $where_column_value) {
        $this->db->where($where_column, $where_column_value);
        $this->db->order_by('record_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($table_name);
        return $query->result();
    }
    function get_last_data($table_name) {
        $this->db->select('record_id');
        $this->db->order_by('record_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function get_all_info_limit_offset($table_name, $limit, $offset) {
        $this->db->limit($limit, $offset);
        $query = $this->db->get($table_name);
        return $query->result();
    }
    
    function get_all_info_limit_offset_order_by($table_name, $limit, $offset, $column, $order) {
        $this->db->order_by($column, $order);
        $this->db->limit($limit, $offset);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function get_all_info_by_array($table_name, $column_with_value_array) {
        $s = $this->db->where($column_with_value_array);
        $this->db->where($column_with_value_array);
        $query = $this->db->get($table_name);
        return $query->result();
    }
    function get_result_condition($table_name,$array) {
        $this->db->where($array);
        $this->db->order_by('view_count','DESC');
        $this->db->limit(3);
        $query = $this->db->get($table_name);
        return $query->result();
    }
    function get_single_row($record_id,$table_name){
        $this->db->where('record_id',$record_id);
        $query = $this->db->get($table_name);
        return $query->row();
    }
    function data_date_to_date($table_name, $date_column, $date_from, $date_to) {
        $this->db->where($date_column . '>=', $date_from);
        $this->db->where($date_column . '<=', $date_to);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function update_data_onerow($table_name, $data, $where_column, $where_column_value) {
        $this->db->where($where_column, $where_column_value);
        $this->db->update($table_name, $data);
    }

    function insert_data($table_name, $data) {
        $query = $this->db->insert($table_name, $data);
        return $query;
    }
    function insert_mer($table_name, $data) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }
    function sub_category_details($data) {
        $this->db->insert('sub_category_details', $data);
    }
    function insert_multiple_data($table_name, $data) {
        $query = $this->db->insert_batch($table_name, $data);
        return $query;
    }
    function insert_data_get_id($table_name, $data) {
        $this->db->insert($table_name, $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    function one_column_one_info($column_name, $id_column, $one_id, $table_name) {
        $this->db->select($column_name);
        $this->db->where($id_column, $one_id);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function get_allinfo_byid($table_name, $where_column, $where_column_value) {
        $this->db->where($where_column, $where_column_value);
        $query = $this->db->get($table_name);
        return $query->result();
    }


    function get_allinfo_byid_limit_offset($limit, $offset, $table_name, $where_column, $where_column_value) {
        $this->db->limit($limit, $offset);
        $this->db->where($where_column, $where_column_value);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function get_all_review() {
        $this->db->where('status', 1);
        $query = $this->db->get("review");
        return $query->result();
    }
    
     function get_all_info($table_name) {
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function get_all_byid_orderby($table_name, $where_column, $where_column_value, $order_column, $order_details) {
        $this->db->order_by($order_column, $order_details);
        $this->db->where($where_column, $where_column_value);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function get_all_info_orderby($table_name, $order_column, $order_details) {
        $this->db->order_by($order_column, $order_details);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function check_value($table_name, $column_with_value_array) {
        $this->db->where($column_with_value_array);
        $query = $this->db->get($table_name);
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_value_get_data($table_name, $column_with_value_array) {
        $this->db->where($column_with_value_array);
        $query = $this->db->get($table_name);
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    function get_left_right_id($table_name, $parent_id, $parent_id_value) {
        $this->db->select('left_id, right_id');
        $this->db->where($parent_id, $parent_id_value);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function delete_info($table_id, $deleted_id, $table_name) {
        $this->db->where($table_id, $deleted_id);
        $query = $this->db->delete($table_name);
        return $query;
    }
    function data_between_date($table_name, $column_name, $start_date, $end_date) {
        $this->db->where($column_name . '<=', $start_date);
        $this->db->where($column_name . '>=', $end_date);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function data_between_date_where($table_name, $column_date, $start_date, $end_date, $where_column, $where_column_value) {
        $this->db->where($where_column, $where_column_value);
        $this->db->where($column_date . '<=', $start_date);
        $this->db->where($column_date . '>=', $end_date);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function row_number_until_date($table_name, $date_column, $date) {
        $this->db->where($date_column . '<=', $date);
        $query = $this->db->get($table_name);
        return $query->num_rows();
    }

    function data_until_date_where_id($table_name, $date_column, $date, $where_column, $where_value) {
        $this->db->where($date_column . '<=', $date);
        $this->db->where($where_column, $where_value);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function data_until_date($table_name, $date_column, $date) {
        $this->db->where($date_column . '<=', $date);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function row_number_single_date($table_name, $date_column, $date) {
        $this->db->where($date_column, $date);
        $query = $this->db->get($table_name);
        return $query->num_rows();
    }

    function find_last_id($column_name, $table_name) {
        $this->db->insert_id($column_name);
        $query = $this->db->get($table_name);
        if ($query->num_rows() < 1) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    function sum_one_columm_date_to_date_with_condition($table_name, $sum_col, $column_with_value_array, $date_column, $date_from, $date_to) {
        $this->db->select_sum($sum_col);
        $this->db->where($column_with_value_array);
        $this->db->where($date_column . '>=', $date_from);
        $this->db->where($date_column . '<=', $date_to);
        $query = $this->db->get($table_name);
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    function check_value_get_one_column($column_name, $column_with_value_array, $table_name) {
        $this->db->select($column_name);
        $this->db->where($column_with_value_array);
        $query = $this->db->get($table_name);
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    function data_date_to_date_with_check($table_name, $column_with_value_array, $date_column, $date_from, $date_to) {
        $this->db->where($column_with_value_array);
        $this->db->where($date_column . '>=', $date_from);
        $this->db->where($date_column . '<=', $date_to);
        $query = $this->db->get($table_name);
        return $query->result();
    }

     function multil_column_group_by_where($table_name, $where_array, $multiple_column_array) {
        $this->db->where($where_array);
        $this->db->group_by($multiple_column_array);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function one_column_group_by($column_name, $table_name) {
        $this->db->select($column_name);
        $this->db->group_by($column_name);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function get_allinfo_byid_groupby($where_column, $where_column_value, $table_name) {
        $this->db->where($where_column, $where_column_value);
        $this->db->group_by($where_column);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function simple_group_by($where_column, $table_name) {
        $this->db->group_by($where_column);
        $query = $this->db->get($table_name);
        return $query->result();
    }

    function update_data_onerow_where_array($table_name, $data, $column_with_value_array) {
        $this->db->where($column_with_value_array);
        $this->db->update($table_name, $data);
    }

    function find_last_id_where($column_name, $column_with_value_array, $table_name) {
        $this->db->where($column_with_value_array);
        $this->db->insert_id($column_name);
        $query = $this->db->get($table_name);
        if ($query->num_rows() < 1) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

}

?>