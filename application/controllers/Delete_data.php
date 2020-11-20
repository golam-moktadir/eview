<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Delete_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
    }

    public function mer_reg() {
        $id = $this->input->post('id');
        $this->Common_model->delete_info('record_id', $id, 'mer_reg');
        echo json_encode("Deleted Successfully");
    }

    public function gen_reg() {
        $id = $this->input->post('id');
        $this->Common_model->delete_info('record_id', $id, 'gen_reg');
        echo json_encode("Deleted Successfully");
    }

    public function cus_req() {
        $id = $this->input->post('id');
        $this->Common_model->delete_info('record_id', $id, 'cus_req');
        echo json_encode("Deleted Successfully");
    }

    public function review() {
        $id = $this->input->post('id');
        $this->Common_model->delete_info('record_id', $id, 'review');
        echo json_encode("Deleted Successfully");
    }

    public function news_events() {
        $id = $this->input->post('id');
        $this->Common_model->delete_info('record_id', $id, 'news_events');
        echo json_encode("Deleted Successfully");
    }

    public function photo_gallery() {
        $id = $this->input->post('id');
        $this->Common_model->delete_info('record_id', $id, 'photo_gallery');
        echo json_encode("Deleted Successfully");
    }

    public function sub_category() {
        $id = $this->input->post('id');
        $this->Common_model->delete_info('record_id', $id, 'sub_category');
        echo json_encode("Deleted Successfully");
    }

    public function category() {
        $id = $this->input->post('id');
        $this->Common_model->delete_info('record_id', $id, 'category');
        echo json_encode("Deleted Successfully");
    }

    public function slider() {
        $id = $this->input->post('id');
        $this->Common_model->delete_info('record_id', $id, 'slider');
        echo json_encode("Deleted Successfully");
    }

    public function product() {
        $id = $this->input->post('id');
        $this->Common_model->delete_info('record_id', $id, 'product');
        echo json_encode("Deleted Successfully");
    }

    public function about() {
        $id = $this->input->post('id');
        $this->Common_model->delete_info('record_id', $id, 'about');
        echo json_encode("Deleted Successfully");
    }

    public function contact() {
        $id = $this->input->post('id');
        $this->Common_model->delete_info('record_id', $id, 'contact');
        echo json_encode("Deleted Successfully");
    }

}
