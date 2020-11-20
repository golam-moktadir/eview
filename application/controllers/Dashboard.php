<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Join_model');
    }

    public function cabin() {
        $data['all_value'] = $this->Join_model->get_all_info_cabin();
        $this->load->view('layout/header');
        $this->load->view('dashboard/view_cabin', $data);
        $this->load->view('layout/footer');
    }

    public function ambulance() {
        $data['all_value'] = $this->Join_model->get_all_info_ambulance();
        $this->load->view('layout/header');
        $this->load->view('dashboard/view_ambulance', $data);
        $this->load->view('layout/footer');
    }

    public function opd_em() {
        $data['all_value'] = $this->Common_model->get_all_info('opd_em');
        $this->load->view('layout/header');
        $this->load->view('dashboard/view_opd_em', $data);
        $this->load->view('layout/footer');
    }

    public function patient() {
        $data['all_value'] = $this->Common_model->get_all_info_orderby('patient', 'record_id', 'DESC');
        $this->load->view('layout/header');
        $this->load->view('dashboard/view_patient', $data);
        $this->load->view('layout/footer');
    }

    public function doc_con() {
        $data['all_value'] = $this->Common_model->get_all_info_orderby('doc_con', 'record_id', 'DESC');
        $this->load->view('layout/header');
        $this->load->view('dashboard/view_doc_con', $data);
        $this->load->view('layout/footer');
    }

    public function inv_account() {
        $data['all_value'] = $this->Join_model->get_rec_inv();
        $this->load->view('layout/header');
        $this->load->view('dashboard/view_inv_account', $data);
        $this->load->view('layout/footer');
    }

}
