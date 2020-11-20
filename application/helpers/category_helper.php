<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!function_exists('base_info_lists')) {

    function base_info_lists($base_id) {
        $CI = & get_instance();
        $CI->load->model('admin_model');
        $membres = $CI->admin_model->get_all_base_info($base_id); 
        return $membres;
    }

}


