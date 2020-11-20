<?php
date_default_timezone_set("Asia/Dhaka"); 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!function_exists('check_exits_payment')) {

    function check_exits_payment($invoice_id) {
        $CI = & get_instance();
        $CI->db->select('invoice_no');
        $CI->db->from('sales_due');
        $CI->db->where("invoice_no",$invoice_id);
        $result=$CI->db->get()->num_rows();
        if($result>1){
            return false;
        }else{
            return true;
        }
    }

}
if (!function_exists('check_invoice_paid')) {

    function check_invoice_paid($invoice_id) {
        $CI = & get_instance();
        $CI->db->select('invoice_no,sum(paid) as total_paid');
        $CI->db->from('sales_due');
        $CI->db->group_by("invoice_no");
        $CI->db->where("invoice_no",$invoice_id);
        $CI->db->having('total_paid',0);
        $result=$CI->db->get()->num_rows();
        if($result==1){
            return true;
        }else{
            return false;
        }
    }

}
if (!function_exists('get_challan_invoice')) {

    function get_challan_invoice() {
        $CI = & get_instance();
        $CI->db->select('invoice_no');
        $CI->db->from('sell_product');
        $CI->db->group_by("invoice_no");
        $CI->db->where("sales_type!=","Bill");
        $CI->db->where_not_in("sales_type","Service Bill");
        $CI->db->where_not_in("sales_type","Wrong Parts Exchange Bill");
        return $CI->db->get()->result_array();
    }

}
if (!function_exists('check_exits_invoice')) {

    function check_exits_invoice($invoice_id) {
        $CI = & get_instance();
        $CI->db->select('invoice_no');
        $CI->db->from('sales_due');
        $CI->db->group_by("invoice_no");
        $CI->db->where("invoice_no",$invoice_id);
        $result=$CI->db->get()->num_rows();
        return $result;
    }

}
if (!function_exists('debug_p')) {

    function debug_p($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }
    function debug_v($data) {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die();
    }

}


