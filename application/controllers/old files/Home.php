<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Home extends CI_Controller {
    public function index() {
        $this->load->model('Common_model');
        //Getting Counter Info        
        $this->load->model('Counter_model');
        $counter_value=$this->Counter_model->get_counter_value();
        foreach($counter_value as $value){
           $total=$value->count;
           if($total == 0){
                $this->Counter_model->update_counter_value(1);
                $sescounter = array('hit_counter' => $total);
                $this->session->set_userdata($sescounter);
           }
           else{
                $one_count=$total+1;
                $sescounter = array('hit_counter' => $total);
                $this->session->set_userdata($sescounter);
                $this->Counter_model->update_counter_value($one_count);
           } 
        } 
        $data['all_news']=$this->Common_model->get_all_info('47_new_msg');
        $data['all_photo'] = $this->Common_model->get_all_info('33_photo_gallery');
        $data['all_value']=$this->Common_model->get_all_info('32_single_page_content');
        $this->load->view('website/header');
        $this->load->view('website/home', $data);
        $this->load->view('website/footer');
    }
}
