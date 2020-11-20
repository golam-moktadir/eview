<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Get_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Join_model');
    }
    
    public function get_sub_category_info() {
        $category = $this->input->post('category');

        $sub_categories = $this->Common_model->get_allinfo_byid("sub_category", 'category_id', $category);
        $this->load->view('website/get_sub_category_info',['sub_categories'=>$sub_categories]);
    }
    public function get_sub_category() {
        $category = $this->input->post('category');

        $result = $this->Common_model->get_allinfo_byid("sub_category", 'category_id', $category);
        $option = "<option value=''>-- Select --</option>";
        foreach ($result as $info) {
            $option .= "<option value='$info->record_id'>$info->sub_category</option>";
        }
        echo $option;
    }
    public function check_member() {
        $mem_email = $this->input->post('mem_email');
        $mem_password = $this->input->post('mem_password');
        $checking_array = array("user_name" => $mem_email, "password" => $mem_password);
        $result = $this->Common_model->check_value_get_data('role_setting', $checking_array);
        if ($result) {
            $status = 1;
        } else {
            $status = 0;
        }
        echo json_encode($status);
    }

    public function product() {
        $id = $this->input->post('id');
        $data = $this->Common_model->get_allinfo_byid('product', 'record_id', $id);
        echo json_encode($data);
    }

    public function review() {
        $id = $this->input->post('id');
        $data = $this->Common_model->get_allinfo_byid('review', 'record_id', $id);
        echo json_encode($data);
    }

    public function video_gallery() {
        $id = $this->input->post('id');
        $data = $this->Common_model->get_allinfo_byid('video_gallery', 'record_id', $id);
        echo json_encode($data);
    }

    public function photo_gallery() {
        $id = $this->input->post('id');
        $data = $this->Common_model->get_allinfo_byid('photo_gallery', 'record_id', $id);
        echo json_encode($data);
    }

    public function slider() {
        $id = $this->input->post('id');
        $data = $this->Common_model->get_allinfo_byid('slider', 'record_id', $id);
        echo json_encode($data);
    }

    public function about() {
        $id = $this->input->post('id');
        $data = $this->Common_model->get_allinfo_byid('about', 'record_id', $id);
        echo json_encode($data);
    }

    public function contact() {
        $id = $this->input->post('id');
        $data = $this->Common_model->get_allinfo_byid('contact', 'record_id', $id);
        echo json_encode($data);
    }

    public function category() {
        $id = $this->input->post('id');
        $data = $this->Common_model->get_allinfo_byid('category', 'record_id', $id);
        echo json_encode($data);
    }

    public function sub_category() {
        $id = $this->input->post('id');
        $data = $this->Common_model->get_allinfo_byid('sub_category', 'record_id', $id);
        echo json_encode($data);
    }

}
