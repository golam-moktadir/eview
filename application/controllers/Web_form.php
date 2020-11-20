<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Web_form extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Join_model');
    }

    public function view_mer_product() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $data["all_product"] = $this->Common_model->get_allinfo_byid('product', 'member_id', $id);
        $result = $this->Common_model->get_all_info('category');
        $count = 0;
        foreach ($result as $info) {
            $count++;
            $category_id = $info->record_id;
            $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
        }
        $data["head"] = $name;
        $data["cat"] = $result;
        $data["count"] = $count;
        $result = $this->load->view('website/product_info', $data, true);
        echo json_encode($result);
    }
    
    public function view_brand_product() {
        $brand_name = $this->input->post('brand_name');
        $data["all_product"] = $this->Common_model->get_allinfo_byid('product', 'brand', $brand_name);
        $result = $this->Common_model->get_all_info('category');
        $count = 0;
        foreach ($result as $info) {
            $count++;
            $category_id = $info->record_id;
            $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
        }
        $data["head"] = $brand_name;
        $data["cat"] = $result;
        $data["count"] = $count;
        $result = $this->load->view('website/product_info', $data, true);
        echo json_encode($result);
    }

    public function merchant() {
        $data['all_merchant'] = $this->Common_model->get_allinfo_byid('role_setting', 'type', 'merchant_member');
        $result = $this->Common_model->get_all_info('category');
        $data['sub_category'] = $this->Common_model->get_all_info('sub_category');
        $count = 0;
        foreach ($result as $info) {
            $count++;
            $category_id = $info->record_id;
            $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
        }
        $data["cat"] = $result;
        $data["count"] = $count;
        $result = $this->load->view('website/merchant', $data, true);
        echo json_encode($result);
    }
    public function brand() {
        $data['all_brand'] = $this->Common_model->only_group_by('product', 'brand');
        $result = $this->Common_model->get_all_info('category');
        $data['sub_category'] = $this->Common_model->get_all_info('sub_category');
        $count = 0;
        foreach ($result as $info) {
            $count++;
            $category_id = $info->record_id;
            $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
        }
        $data["cat"] = $result;
        $data["count"] = $count;
        $result = $this->load->view('website/brand', $data, true);
        echo json_encode($result);
    }

    public function mer_reg() {
        $result = $this->Common_model->get_all_info('category');
        $data['sub_category'] = $this->Common_model->get_all_info('sub_category');
        $count = 0;
        foreach ($result as $info) {
            $count++;
            $category_id = $info->record_id;
            $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
        }
        $data["cat"] = $result;
        $data["count"] = $count;
        $result = $this->load->view('website/mer_reg', $data, true);
        echo json_encode($result);
    }

    public function gen_reg() {
        $result = $this->Common_model->get_all_info('category');
        $count = 0;
        foreach ($result as $info) {
            $count++;
            $category_id = $info->record_id;
            $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
        }
        $data["cat"] = $result;
        $data["count"] = $count;
        $result = $this->load->view('website/gen_reg', $data, true);
        echo json_encode($result);
    }

    public function cart_payment() {
        $data['all_content'] = $this->input->post('all_content');
        $result = $this->Common_model->get_all_info('category');
        $count = 0;
        foreach ($result as $info) {
            $count++;
            $category_id = $info->record_id;
            $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
        }
        $data["cat"] = $result;
        $data["count"] = $count;
        $result = $this->load->view('website/cart_payment', $data, true);
        echo json_encode($result);
    }

    public function view_product_details() {
        $id = $this->input->post('id');
        $data["product_info"] = $this->Common_model->get_allinfo_byid('product', 'record_id', $id);
        $view_count = $this->Common_model->get_single_row($id,'product');
        $value = $view_count->view_count + 1;
        $this->Common_model->update_data_onerow_where_array('product',['view_count'=>$value],['record_id'=>$id]);
        $result = $this->Common_model->get_all_info('category');
        $count = 0;
        foreach ($result as $info) {
            $count++;
            $category_id = $info->record_id;
            $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
        }
        $data["cat"] = $result;
        $data["count"] = $count;
        $result = $this->load->view('website/view_product_details', $data, true);
        echo json_encode($result);
    }

    public function product_by_subcat() {
        $subcat_id = $this->input->post('id');
        $sub = $this->input->post('sub');
        $data['all_product'] = $this->Join_model->product_by_subcat($subcat_id);
        $result = $this->Common_model->get_all_info('category');
        $count = 0;
        foreach ($result as $info) {
            $count++;
            $category_id = $info->record_id;
            $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
        }
        $data["head"] = $sub;
        $data["cat"] = $result;
        $data["count"] = $count;
        $result = $this->load->view('website/product_info', $data, true);
        echo json_encode($result);
    }

    public function popular_latest_product() {
        $data['all_product'] = $this->Common_model->get_all_info_limit_offset_order_by("product",9,0, "record_id", "DESC");
        $data['popular_products'] = $this->Common_model->get_result_condition("product",['view_count >' => 0]);
        $result = $this->Common_model->get_all_info('category');
        $count = 0;
        foreach ($result as $info) {
            $count++;
            $category_id = $info->record_id;
            $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
        }
        $data["cat"] = $result;
        $data["count"] = $count;
        $data["head"] = "Latest";
        $result = $this->load->view('website/popular_latest_product', $data, true);
        echo json_encode($result);
    }

    public function about() {
        $result = $this->Common_model->get_all_info('category');
        $count = 0;
        foreach ($result as $info) {
            $count++;
            $category_id = $info->record_id;
            $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
        }
        $data["cat"] = $result;
        $data["count"] = $count;
        $data['about'] = $this->Common_model->get_all_info('about');
        $result = $this->load->view('website/about', $data, true);
        echo json_encode($result);
    }

    public function contact() {
        $result = $this->Common_model->get_all_info('category');
        $count = 0;
        foreach ($result as $info) {
            $count++;
            $category_id = $info->record_id;
            $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
        }
        $data["cat"] = $result;
        $data["count"] = $count;
        $data['contact'] = $this->Common_model->get_all_info('contact');
        $result = $this->load->view('website/contact', $data, true);
        echo json_encode($result);
    }

    public function index() {
        $slider_data['all_slider'] = $this->Common_model->get_all_info('slider');
        $this->load->view('website/header');
        $this->load->view('website/slider', $slider_data);
        $this->load->view('website/index');
        $this->load->view('website/footer');
    }
    // public function mer_reg() {
    //     $result = $this->Common_model->get_all_info('category');
    //     $data['sub_category'] = $this->Common_model->get_all_info('sub_category');
    //     $count = 0;
    //     foreach ($result as $info) {
    //         $count++;
    //         $category_id = $info->record_id;
    //         $data["sub_cat" . $count] = $this->Common_model->get_sub_category($category_id);
    //     }
    //     $data["cat"] = $result;
    //     $data["count"] = $count;
    //     $this->load->view('website/header');
    //     $this->load->view('website/mer_reg', $data);
    //     $this->load->view('website/footer');
    // }

}
