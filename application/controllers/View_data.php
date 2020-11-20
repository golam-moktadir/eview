<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class View_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Join_model');
    }

    public function purchased_product() {
        $id = $this->session->ses_record_id;
        $data['all_value'] = $this->Common_model->get_all_byid_orderby('cus_req', 'member_id', $id, "record_id", "DESC");
        $result = $this->load->view('purchased_product/view_purchased_product', $data, true);
        echo json_encode($result);
    }

    public function mer_reg() {
        $data['all_value'] = $this->Join_model->get_mer_reg();
        $result = $this->load->view('mer_reg/view_mer_reg', $data, true);
        echo json_encode($result);
    }
    public function gen_reg() {
        $data['all_value'] = $this->Common_model->get_all_info_orderby('gen_reg', 'record_id', 'DESC');
        $result = $this->load->view('gen_reg/view_gen_reg', $data, true);
        echo json_encode($result);
    }

    public function cus_req() {
        $data['all_value'] = $this->Common_model->get_all_info_orderby('cus_req', 'record_id', 'DESC');
        $result = $this->load->view('cus_req/view_cus_req', $data, true);
        echo json_encode($result);
    }

    public function review() {
        $data['all_value'] = $this->Common_model->get_all_info_orderby('review', 'record_id', 'DESC');
        $result = $this->load->view('review/view_review', $data, true);
        echo json_encode($result);
    }

    public function product() {
        $member_id = $this->session->ses_record_id;
        $type = $this->session->ses_type;
        if($type == "merchant_member"){
            $data['all_value'] = $this->Join_model->get_all_product_mer($member_id);
        }else{
            $data['all_value'] = $this->Join_model->get_all_product();
        }
        
        $result = $this->load->view('product_info/view_product_info', $data,true);
        echo json_encode($result);
    }

    public function video_gallery() {
        $data['all_value'] = $this->Common_model->get_all_info_orderby('video_gallery', 'record_id', 'DESC');
        $result = $this->load->view('video_gallery/view_video_gallery', $data, true);
        echo json_encode($result);
    }

    public function photo_gallery() {
        $data['all_value'] = $this->Common_model->get_all_info_orderby('photo_gallery', 'record_id', 'DESC');
        $result = $this->load->view('photo_gallery/view_photo_gallery', $data, true);
        echo json_encode($result);
    }

    public function slider() {
        $data['all_value'] = $this->Common_model->get_all_info('slider');
        $result = $this->load->view('slider/view_slider', $data, true);
        echo json_encode($result);
    }

    public function about() {
        $data['all_value'] = $this->Common_model->get_all_info('about');
        $result = $this->load->view('about/view_about', $data, true);
        echo json_encode($result);
    }

    public function contact() {
        $data['all_value'] = $this->Common_model->get_all_info('contact');
        $result = $this->load->view('contact/view_contact', $data, true);
        echo json_encode($result);
    }

    public function category() {
        $data['all_value'] = $this->Common_model->get_all_info('category');
        $result = $this->load->view('category/view_category', $data, true);
        echo json_encode($result);
    }

    public function sub_category() {
        $data['all_value'] = $this->Join_model->get_all_sub_category();
        $result = $this->load->view('sub_category/view_sub_category', $data, true);
        echo json_encode($result);
    }
    public function brand() {
        $data['all_value'] = $this->Common_model->get_all_info('brands');
        $result = $this->load->view('brands/view_brand', $data, true);
        echo json_encode($result);
    }

}
