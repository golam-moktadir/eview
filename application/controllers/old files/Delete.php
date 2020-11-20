<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Delete extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
    }
    public function bill_delete($invoice_no=null)
    {
        $result=$this->Common_model->get_single("common_bill",array("invoice_no"=>$invoice_no),'',1);
        $this->Common_model->delete_info('invoice_no', $invoice_no, 'common_bill');
        $exits=$this->Common_model->get_single("common_bill",array("bill_id"=>$result['bill_id']),'',1);
        if(empty($exits) || count($exits)<=0)
        {
            $this->Common_model->delete_info('invoice_id', $result['bill_id'], 'print_field');
        }
        $this->session->set_flashdata("msg",'<div class="text-danger text-center">Deleted Successfully</div>');
        redirect('Show_form/all_bill');
    }
    public function service_bill($id=null)
    {
        $this->Common_model->delete_info('record_id', $id, 'service_bill');
        $this->Common_model->delete_info('service_bill_id', $id, 'service_bill_details');
        $this->session->set_flashdata("msg",'<div class="text-danger text-center">Deleted Successfully</div>');
        redirect('Show_form/service_bill');
    }
    public function add_product($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'add_product');
            redirect('Show_form/add_product/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function purchase_product($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $delete=$this->Common_model->delete_info('po_no', $id, 'purchase_product');
            $this->Common_model->delete_info('voucher_no', $id, 'purchase_due');
            $this->session->set_flashdata("msg",'<div class="text-danger text-center">Deleted Successfully</div>');
            redirect('Show_form/purchase_product/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function purchase_order($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") { 

            $this->Common_model->delete_info('po_no', $id, 'purchase_order');
            redirect('Show_form/purchase_order/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    
    public function create_section($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'create_section');
            redirect('Show_form/create_section/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_salary_sheet($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'create_salary_sheet');
            redirect('Show_form/create_salary_sheet/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    
    public function create_sub_category($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'create_sub_category');
            redirect('Show_form/create_sub_category/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_brand_name($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'create_brand_name');
            redirect('Show_form/create_brand_name/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_due($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'sales_due');
            redirect('Show_form/sales_due/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function purchase_due($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'purchase_due');
            redirect('Show_form/purchase_due/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function bank_withdraw($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $this->Common_model->delete_info('record_id', $id, 'bank_withdraw');
            redirect('Show_form/bank_withdraw/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function bank_deposit($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $this->Common_model->delete_info('record_id', $id, 'bank_deposit');
            redirect('Show_form/bank_deposit/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_bank_name($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $this->Common_model->delete_info('record_id', $id, 'create_bank_name');
            redirect('Show_form/create_bank_name/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function expense($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'expense');
            redirect('Show_form/expense/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function expense_head($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'expense_head');
            redirect('Show_form/expense_head/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function income($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'income');
            redirect('Show_form/income/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function income_head($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'income_head');
            redirect('Show_form/income_head/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sell_product($invoice_no) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('invoice_no', $invoice_no, 'sell_product');
            $this->Common_model->delete_info('invoice_no', $invoice_no, 'sales_due');
            $this->Common_model->delete_info('invoice_id', $invoice_no, 'print_field');
            @$this->Common_model->delete_info('invoice_no', $invoice_no, 'all_invoice');
            @$this->Common_model->delete_info('invoice_no', $invoice_no, 'common_bill');
            $auditors_data=array(
                "name"=>"Invoice No: ".$invoice_no,
                "user_name"=>$this->session->ses_username,
                "type"=>"Delete",
                "created_at"=>date("Y-m-d H:i:s")
            );
            $this->Common_model->insert_data("auditors",$auditors_data);
            redirect('Show_form/sales/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_dealing($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'sales_dealing');
            redirect('Show_form/sales_dealing/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_schedule($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'sales_schedule');
            redirect('Show_form/sales_schedule/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function add_client($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'add_client');
            redirect('Show_form/add_client/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function insert_product_info($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'insert_product_info');
            redirect('Show_form/insert_product_info/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function employee_schedule($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'employee_schedule');
            redirect('Show_form/employee_schedule/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function employee_list($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'employee');
            redirect('Show_form/create_employee/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_product_type($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'create_product_type');
            redirect('Show_form/create_product_type/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_product_name($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'create_product_name');
            redirect('Show_form/create_product_name/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_manufacture_company($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'create_manufacture_company');
            redirect('Show_form/create_manufacture_company/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_storage_type($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'create_storage_type');
            redirect('Show_form/create_storage_type/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_department($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'create_department');
            redirect('Show_form/create_department/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_designation($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'create_designation');
            redirect('Show_form/create_designation/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function project_settings($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'project_program');
            redirect('Show_form/project_settings/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function reg_processing($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'reg_processing');
            redirect('Show_form/reg_processing/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function customer_care($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'customer_care');
            redirect('Show_form/customer_care/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function payment_processing($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'payment_processing');
            redirect('Show_form/payment_processing/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function down_payment($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->Common_model->delete_info('record_id', $id, 'down_payment');
            redirect('Show_form/down_payment/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function publication($id, $file) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data = $file;
            $dir = "./assets/files/publications/";
            $dirHandle = opendir($dir);
            while ($file = readdir($dirHandle)) {
                if ($file == $data) {
                    unlink($dir . "/" . $file); //give correct path,
                }
            }
            closedir($dirHandle);
            $this->Common_model->delete_info('record_id', $id, 'publication');
            redirect('Show_form/publication/delete', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    // public function create_user($id) {
    //     $user_type = $this->session->ses_user_type;
    //     if ($user_type == "admin" || $user_type == "staff") {
    //         $this->Common_model->delete_info('record_id', $id, 'user');
    //         redirect('Show_form/create_user/delete', 'refresh');
    //     } else {
    //         $data['wrong_msg'] = "";
    //         $this->load->view('website/login_check', $data);
    //     }
    // }

}
