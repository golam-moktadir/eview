<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Show_edit_form extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
    }

    public function add_product($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['section'] = $this->Common_model->get_all_info('create_section');
            $data['manufacture_company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['product_name'] = $this->Common_model->get_all_info('create_product_name');
            $data['all_po'] = $this->Common_model->get_distinct_value('po_no', 'purchase_product');

            $data['one_value'] = $this->Common_model->get_allinfo_byid('add_product', 'record_id', $id);


            $this->load->view('admin/header');
            $this->load->view('admin/add_product_edit', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function service_bill($id=null)
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data=array();
            $data['all_service_bill']=$this->Common_model->get_all_service_bill();
            // debug_p($data);
            $data['service_bill']=$this->Common_model->get_single("service_bill",array("record_id"=>$id),"",1);
            $data['details']=$this->Common_model->get_single("service_bill_details",array("service_bill_id"=>$id));
            $data['edit']=true;
            $this->load->view('admin/header');
            $this->load->view('admin/service_bill', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function purchase_product($id=null,$po_no=null,$total=null,$discount=null,$net_pay=null) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['one_value'] = $this->Common_model->get_allinfo_byid('purchase_product', 'record_id', $id);
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['section'] = $this->Common_model->get_all_info('create_section');
            $data['manufacture_company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['product_name'] = $this->Common_model->get_all_info('create_product_name');
            if($po_no!='')
            {
                $data['po_no']=$po_no;
                $data['total']=$total;
                $data['discount']=$discount;
                $data['net_pay']=$net_pay;
            }

            $this->load->view('admin/header');
            $this->load->view('admin/edit_purchase_product', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function purchase_order($id=null,$po_no=null,$total=null,$discount=null,$net_pay=null) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['one_value'] = $this->Common_model->get_allinfo_byid('purchase_order', 'record_id', $id);
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['section'] = $this->Common_model->get_all_info('create_section');
            $data['manufacture_company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['product_name'] = $this->Common_model->get_all_info('create_product_name');
            if($po_no!='')
            {
                $data['po_no']=$po_no;
                $data['total']=$total;
                $data['discount']=$discount;
                $data['net_pay']=$net_pay;
            }
            $this->load->view('admin/header');
            $this->load->view('admin/edit_purchase_order', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function print_sales_invoice($id, $btn_type) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $result = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $id);
            $all_sales = array();
            $row_count = 0;
            $sales_type = "";
            foreach ($result as $info) {
                $row_count++;
                $all_sales[$row_count] = array(
                    "0" => $info->product_name,
                    "1" => $info->parts_no,
                    "2" => $info->unit,
                    "4" => $info->product_qty,
                    "5" => $info->price_per_unit,
                    "6" => $info->first_total,
                    "7" => $info->ind_discount,
                    "8" => $info->total,
                    "10" => $info->remarks,
                    "11" => $info->alt_parts_no
                );
                $data['date'] = $info->date;
                $data['invoice_no'] = $info->invoice_no;
                $data['customer_name'] = $info->client_name;
                $data['customer_id'] = "Client ID: " . $info->client_id . "";
                $data['invoice_total'] = $info->sub_total;
                $data['discount'] = $info->discount;
                $data['sub_total'] = $info->sub_total - $info->discount;
                $data['previous_due'] = $info->previous_due;
                $data['complete_total'] = $info->complete_total;
                $data['paid'] = $info->paid;
                $data['due'] = $info->due;
                $data['sold_by'] = $info->sold_by;
                $data['sales_type'] = $info->sales_type;
                $sales_type = $info->sales_type;
                $data['payment_type'] = $info->payment_type;
            }
            $data['all_sales'] = $all_sales;
            $result = $this->Common_model->get_allinfo_byid('print_field', 'invoice_id', $id);
            $data["reference"] = "";
            $data["address"] = "";
            $data["project_name"] = "";
            $data["indent_no"] = "";
            $data["mpr_no"] = "";
            $data["currency"] = "";
            $data["print_field"] = "";
            $data["extra_charge_type"] ="";
            $data["extra_charge"] = "";
            foreach ($result as $info) {
                $data["reference"] = $info->reference;
                $data["address"] = $info->address;
                $data["project_name"] = $info->project_name;
                $data["indent_no"] = $info->indent_no;
                $data["mpr_no"] = $info->mpr_no;
                $data["currency"] = $info->currency;
                $data["extra_charge_type"] = $info->extra_charge_type;
                $data["extra_charge"] = $info->extra_charge;
                $data["print_field"] = $info->confirmed;
            }

            if ($btn_type == "challan_btn") {
                $data["print_type"] = "Challan";
            } else if ($btn_type == "invoice_btn" && ($sales_type == "Bill" || $sales_type == "Service Bill" ||
                    $sales_type == "Wrong Parts Exchange Bill" || $sales_type == "LC")) {
                $data["print_type"] = "Invoice";
            } else {
                $data["print_type"] = "";
            }
            $this->load->view('admin/header');
            $this->load->view('admin/show_sales_invoice', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

//    public function print_sales_challan($id) {
//        $user_type = $this->session->ses_user_type;
//        if ($user_type == "admin" || $user_type == "staff") {
//            $result = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $id);
//            $all_sales = array();
//            $row_count = 0;
//            foreach ($result as $info) {
//                $all_sales[$row_count] = array(
//                    "1" => $info->section,
//                    "2" => $info->product_name,
//                    "3" => $info->parts_no,
//                    "4" => $info->unit,
//                    "6" => $info->product_qty,
//                    "7" => $info->price_per_unit,
//                    "8" => $info->first_total,
//                    "9" => $info->ind_discount,
//                    "10" => $info->total,
//                    "12" => $info->remarks,
//                );
//                $data['date'] = $info->date;
//                $data['invoice_no'] = $info->invoice_no;
//                $data['customer_name'] = $info->client_name;
//                $data['customer_id'] = "Client ID: " . $info->client_id . "";
//                $data['invoice_total'] = $info->sub_total;
//                $data['discount'] = $info->discount;
//                $data['sub_total'] = $info->sub_total - $info->discount;
//                $data['previous_due'] = $info->previous_due;
//                $data['complete_total'] = $info->complete_total;
//                $data['paid'] = $info->paid;
//                $data['due'] = $info->due;
//                $data['sold_by'] = $info->sold_by;
//                $data['sales_type'] = $info->sales_type;
//            }
//            $data['all_sales'] = $all_sales;
//
//            $result = $this->Common_model->get_allinfo_byid('print_field', 'invoice_id', $id);
//            foreach ($result as $info) {
//                $data["reference"] = $info->reference;
//                $data["address"] = $info->address;
//                $data["project_name"] = $info->project_name;
//                $data["indent_no"] = $info->indent_no;
//                $data["mpr_no"] = $info->mpr_no;
//                $data["print_field"] = $info->confirmed;
//            }
//            $this->load->view('admin/header');
//            $this->load->view('admin/show_sales_challan', $data);
//            $this->load->view('admin/footer');
//        } else {
//            $data['wrong_msg'] = "";
//            $this->load->view('website/login_check', $data);
//        }
//    }

    public function create_manufacture_company($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['one_value'] = $this->Common_model->get_allinfo_byid('create_manufacture_company', 'record_id', $id);
            $this->load->view('admin/header');
            $this->load->view('admin/edit_create_manufacture_company', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_section($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['one_value'] = $this->Common_model->get_allinfo_byid('create_section', 'record_id', $id);
            $this->load->view('admin/header');
            $this->load->view('admin/edit_create_section', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_product_name($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['all_section'] = $this->Common_model->get_all_info('create_section');
            $data['one_value'] = $this->Common_model->get_allinfo_byid('create_product_name', 'record_id', $id);
            $this->load->view('admin/header');
            $this->load->view('admin/edit_create_product_name', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_product_type($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['one_value'] = $this->Common_model->get_allinfo_byid('create_product_type', 'record_id', $id);
            $this->load->view('admin/header');
            $this->load->view('admin/edit_create_product_type', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_dealing($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_client'] = $this->Common_model->get_all_info('add_client');
            $data['one_value'] = $this->Common_model->get_allinfo_byid('sales_dealing', 'record_id', $id);
            $this->load->view('admin/header');
            $this->load->view('admin/edit_sales_dealing', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_schedule($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_client'] = $this->Common_model->get_all_info('add_client');
            $data['one_value'] = $this->Common_model->get_allinfo_byid('sales_schedule', 'record_id', $id);
            $this->load->view('admin/header');
            $this->load->view('admin/edit_sales_schedule', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function add_client($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $data['one_value'] = $this->Common_model->get_allinfo_byid('add_client', 'record_id', $id);
            $this->load->view('admin/header');
            $this->load->view('admin/edit_add_client', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function insert_product_info($id, $msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $data['product_name'] = $this->Common_model->get_all_info('create_product_name');
            $data['sub_category'] = $this->Common_model->get_all_info('create_sub_category');
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['brand'] = $this->Common_model->get_all_info('create_brand_name');
            $data['manufacture_company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['one_value'] = $this->Common_model->get_allinfo_byid('insert_product_info', 'record_id', $id);
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/edit_product_info', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function sell_product($invoice)
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_client'] = $this->Common_model->get_all_info('add_client');
            $result = $this->Common_model->get_distinct_value_order_by('invoice_no', 'sell_product');
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $data['pro_result' . $count] = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $info->invoice_no);
            }
            $data['count_it'] = $count;
            $data['section'] = $this->Common_model->get_all_info('create_section');
            $data['manufacture_company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['product_name'] = $this->Common_model->get_all_info('create_product_name');
            $data['parts_name'] = $this->Common_model->get_distinct_value("product_name",'create_product_name');

            $data['invoice'] = $this->Common_model->get_single('sell_product',array("invoice_no"=>$invoice));
            // echo "<pre>";
            // print_r($data['invoice']);
            // die();
            $data['inovice_no'] = $invoice;
            $this->load->view('admin/header');
            $this->load->view('admin/edit_sell_product', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function employee_schedule($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['one_value'] = $this->Common_model->get_allinfo_byid('employee_schedule', 'record_id', $id);
            $this->load->view('admin/header');
            $this->load->view('admin/edit_employee_schedule', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function employee_list($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['one_value'] = $this->Common_model->get_allinfo_byid('employee', 'record_id', $id);
            $data['all_designation'] = $this->Common_model->get_all_info('create_designation');
            $data['all_department'] = $this->Common_model->get_all_info('create_department');
            $this->load->view('admin/header');
            $this->load->view('admin/edit_employee', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_user($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['one_value'] = $this->Common_model->get_allinfo_byid('user', 'record_id', $id);
            $data['all_employee'] = $this->Common_model->get_all_info('employee');
            $this->load->view('admin/header');
            $this->load->view('admin/edit_user', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_sms($id, $msg) {
        if ($this->session->userdata('ses_user_type') == "admin") {
            $data['all_value'] = $this->Common_model->get_all_info('create_sms');
            $data['one_value'] = $this->Common_model->get_allinfo_byid('create_sms', 'record_id', $id);
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/edit_create_sms', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function insert_notice($id, $msg) {
        if ($this->session->userdata('ses_user_type') == "admin") {
            $data['one_value'] = $this->Common_model->get_allinfo_byid('insert_notice', 'record_id', $id);
            $data['all_value'] = $this->Common_model->get_all_info('insert_notice');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/edit_insert_notice', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_sub_category($id, $msg) {
        if ($this->session->userdata('ses_user_type') == "admin") {
            $data['one_value'] = $this->Common_model->get_allinfo_byid('create_sub_category', 'record_id', $id);
            $data['all_category'] = $this->Common_model->get_all_info('create_product_type');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/edit_sub_category', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_brand_name($id, $msg) {
        if ($this->session->userdata('ses_user_type') == "admin") {
            $data['one_value'] = $this->Common_model->get_allinfo_byid('create_brand_name', 'record_id', $id);
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/edit_brand_name', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

}
