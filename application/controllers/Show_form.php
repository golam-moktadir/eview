<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Show_form extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
    }

    public function profile() {
        $this->load->view('layout/header');
        $this->load->view('profile/view_profile');
        $this->load->view('layout/footer');
    }

    public function purchased_product() {
        $this->load->view('layout/header');
        $this->load->view('purchased_product/purchased_product');
        $this->load->view('layout/footer');
    }

    public function mer_reg() {
        $this->load->view('layout/header');
        $this->load->view('mer_reg/mer_reg');
        $this->load->view('layout/footer');
    }

    public function gen_reg() {
        $this->load->view('layout/header');
        $this->load->view('gen_reg/gen_reg');
        $this->load->view('layout/footer');
    }

    public function cus_req() {
        $this->load->view('layout/header');
        $this->load->view('cus_req/cus_req');
        $this->load->view('layout/footer');
    }

    public function review() {
        $this->load->view('layout/header');
        $this->load->view('review/review');
        $this->load->view('layout/footer');
    }

    public function slider() {
        $this->load->view('layout/header');
        $this->load->view('slider/slider');
        $this->load->view('layout/footer');
    }

    public function about() {
        $this->load->view('layout/header');
        $this->load->view('about/about');
        $this->load->view('layout/footer');
    }

    public function contact() {
        $this->load->view('layout/header');
        $this->load->view('contact/contact');
        $this->load->view('layout/footer');
    }

    public function category() {
        $this->load->view('layout/header');
        $this->load->view('category/category');
        $this->load->view('layout/footer');
    }

    public function sub_category() {
        $data['category'] = $this->Common_model->get_all_info('category');
        $this->load->view('layout/header');
        $this->load->view('sub_category/sub_category', $data);
        $this->load->view('layout/footer');
    }
    public function brand() {
        $this->load->view('layout/header');
        $this->load->view('brands/brand');
        $this->load->view('layout/footer');
    }
    public function photo_gallery() {
        $this->load->view('layout/header');
        $this->load->view('photo_gallery/photo_gallery');
        $this->load->view('layout/footer');
    }
    public function product_info() {
        $ses_cat = $this->session->ses_cat;
        $ses_sub_cat = $this->session->ses_sub_cat;
        $ses_type = $this->session->ses_type;

        if ($ses_type == "merchant_member") {
            $data['category'] = $this->Common_model->get_allinfo_byid('category', 'record_id', $ses_cat);
			$data["type"]=$ses_type;
        } else {
            $data['category'] = $this->Common_model->get_all_info('category');
            $data['sub_category'] = array();
            $data["type"]="";
        }
        $data['brands'] = $this->Common_model->get_all_info('brands');

        $this->load->view('layout/header');
        $this->load->view('product_info/product_info', $data);
        $this->load->view('layout/footer');
    }

}
