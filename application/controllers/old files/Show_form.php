<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Show_form extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
    }

    // create xlsx
    public function createXLSX($excel_result) {
        // create file name
        $fileName = '';
        // load excel library
        $this->load->library('excel');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'PO No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Machine Category');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Section');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Machine Model');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Chassis No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Brand');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Parts Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Parts No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Chinese Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Unit');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'U.Price');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Payment Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Qty');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Total Price');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Supplier');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Shipping Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Serial');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Others Cost');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Total Cost');
        // set Row
        $rowCount = 2;
        foreach ($excel_result as $val) {
            $fileName = $val['po_no'].".xlsx";
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $val['po_no']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $val['machine_category']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $val['section']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $val['machine_model']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $val['chassis']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $val['brand']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $val['parts_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $val['parts_no'] . ", Alt: " . $val['alternative_parts_no']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $val['chinese_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $val['unit']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $val['unit_price']);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $val['payment_type']);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $val['quantity']);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $val['total_price']);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $val['supplier']);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $val['shipping_type']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $val['serial']);
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, "Shipping: " . $val['shiping_cost'] . ", Custom: " . $val['custom_cost'] .
                    ", Transport: " . $val['transport_cost'] . ", Mixed: " . $val['misc_cost']);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, "Total Price: " . $val['total_with_extra'] . ", Discount: " . $val['discount'] . "%, " .
                    "Net Payable: " . $val['net_payable']);
            $rowCount++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);
        // download file
        header("Content-Type: application/vnd.ms-excel");
        redirect(site_url() . $fileName);
        
//         $this->load->helper('download');
//
//        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//        $this->output->set_header('Content-Type: application/vnd.ms-excel');
//        $objWriter->save($fileName);
//        //redirect(HTTP_UPLOAD_PATH.$fileName); 
//        $filepath = file_get_contents($fileName);
//        force_download($fileName, $filepath);
    }

    public function download_excel($po_no) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->createXLSX($this->Common_model->get_allinfo_byid_ret_array('purchase_order', 'po_no', $po_no));
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function auditors()
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->view('admin/header');
            $data['auditors']=$this->Common_model->get_single("auditors",array("status"=>1));
            // echo "<pre>";
            // print_r($data);
            // die();
            $this->load->view('admin/auditors', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        } 
    }
    public function bill()
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->view('admin/header');
            $data['referance_no']=$this->Common_model->get_referance_no();
            $this->load->view('admin/bill', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        } 
    }
    public function all_bill()
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->view('admin/header');
            $data['bill']=$this->Common_model->get_common_bill();
            $this->load->view('admin/show_all_bill', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        } 
    }
    public function generate_bill($bill_id=null)
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            if($_POST)
            {
                $invoice_no=$this->input->post("invoice_no");
                $bill_id=$this->Common_model->get_custom_bill_no("common_bill","bill_id",1001,"C");
                
                foreach ($invoice_no as $key => $value) {
                    $exits=$this->Common_model->duplicate_check("common_bill",array("invoice_no"=>$value));
                    if($exits)
                    {
                        $send_data['result_data']="";
                        $send_data['msg']="error";
                        echo json_encode($send_data);
                        return;
                    }
                    $data[$key]['invoice_no']=$value;
                    $data[$key]['bill_id']=$bill_id;
                }
                $this->Common_model->insert_batch("common_bill",$data);
                $this->Common_model->insert_data("print_field",array("invoice_id"=>$bill_id,"confirmed"=>"no"));
                $data=array();
                $s_data=array();
                $temp_data=array();
                $total_discount=0.00;
                $invoice_total=0.00;
                $sub_total=0.00;
                $all_invoice_no='';
                $extra_charge=0.00;
                $extra_charge_type='';
                
                 $count_invoice=count($invoice_no);
                foreach ($invoice_no as $key => $value) {
                    $temp_data=$this->Common_model->get_single("sell_product",array("invoice_no"=>$value,"product_qty!="=>0));
                    $invoice_total+=$temp_data[0]["sub_total"];
                    $total_discount+=$temp_data[0]["discount"];
                    $extra_charge+=$temp_data[0]["extra_charge"];
                    $extra_charge_type=$temp_data[0]["extra_charge_type"];
                    // $sub_total+=$temp_data[0]["net_payable"];
                    $s_data[]["invoice_no"]=$temp_data;
                     $all_invoice_no.=strrev(substr(strrev($value), 0,9));
                    if($key!=($count_invoice-1))
                    {
                        $all_invoice_no.="/";
                    }

                }
                $final_data['referance_info']=$this->Common_model->get_single("print_field",array("invoice_id"=>$bill_id),"",1);
                $final_data['all_invoice_no']=$all_invoice_no;
                $final_data['product']=$s_data;
                $final_data['total_discount']=$total_discount;
                $final_data['invoice_total']=$invoice_total;
                $final_data['sub_total']=$invoice_total-$total_discount+$extra_charge;
                $final_data['extra_charge']=$extra_charge;
                $final_data['extra_charge_type']=$extra_charge_type;
                $final_data['invoice_id']=$bill_id;
                $result=$this->load->view("admin/bill_invoice",$final_data,true);
                $send_data['result_data']=$result;
                $send_data['msg']="success";
                echo json_encode($send_data);
                exit;
            }
            $data=array();
            $s_data=array();
            $temp_data=array();
            $total_discount=0.00;
            $invoice_total=0.00;
            $extra_charge=0.00;
            $sub_total=0.00;
            $extra_charge_type='';
            $invoice_no=$this->Common_model->get_single("common_bill",array("bill_id"=>$bill_id),"invoice_no");
            $all_invoice_no="";
            $count_invoice=count($invoice_no);
            foreach ($invoice_no as $key => $value) {
                $temp_data=$this->Common_model->get_single("sell_product",array("invoice_no"=>$value['invoice_no'],"product_qty!="=>0));
                $invoice_total+=$temp_data[0]["sub_total"];
                $total_discount+=$temp_data[0]["discount"];
                $extra_charge+=$temp_data[0]["extra_charge"];
                $extra_charge_type=$temp_data[0]["extra_charge_type"];
                // $sub_total+=$temp_data[0]["net_payable"];
                $s_data[]["invoice_no"]=$temp_data;
                $all_invoice_no.=strrev(substr(strrev($value['invoice_no']), 0,9));
                if($key!=($count_invoice-1))
                {
                    $all_invoice_no.="/";
                }

            }
            $final_data['referance_info']=$this->Common_model->get_single("print_field",array("invoice_id"=>$bill_id),"",1);
            
            $final_data['all_invoice_no']=$all_invoice_no;
            $final_data['product']=$s_data;
            $final_data['total_discount']=$total_discount;
            $final_data['invoice_total']=$invoice_total;
            $final_data['extra_charge']=$extra_charge;
            $final_data['extra_charge_type']=$extra_charge_type;
            $final_data['sub_total']=$invoice_total-$total_discount+$extra_charge;
            $final_data['invoice_id']=$bill_id;
            // debug_p($final_data['all_invoice_no']);
            // $this->load->library('Pdfgenerator');
            // $html=$this->load->view("admin/bill_invoice",$final_data,true);
            // $this->pdfgenerator->generate($html, "Bill Invoice",TRUE, 'A4',"portrait");
            $this->load->view('admin/header');
            $result=$this->load->view("admin/bill_invoice",$final_data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function generate_bill_pdf($bill_id=null)
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data=array();
            $s_data=array();
            $temp_data=array();
            $total_discount=0.00;
            $invoice_total=0.00;
            $extra_charge=0.00;
            $sub_total=0.00;
            $extra_charge_type='';
            $all_invoice_no='';
            $invoice_no=$this->Common_model->get_single("common_bill",array("bill_id"=>$bill_id),"invoice_no");
            $count_invoice=count($invoice_no);
            foreach ($invoice_no as $key => $value) {
                $temp_data=$this->Common_model->get_single("sell_product",array("invoice_no"=>$value['invoice_no'],"product_qty!="=>0));
                $invoice_total+=$temp_data[0]["sub_total"];
                $total_discount+=$temp_data[0]["discount"];
                // $sub_total+=$temp_data[0]["net_payable"];
                $extra_charge+=$temp_data[0]["extra_charge"];
                $extra_charge_type=$temp_data[0]["extra_charge_type"];
                $s_data[]["invoice_no"]=$temp_data;
                $all_invoice_no.=strrev(substr(strrev($value['invoice_no']), 0,9));
                if($key!=($count_invoice-1))
                {
                    $all_invoice_no.="/";
                }

            }
            $final_data['referance_info']=$this->Common_model->get_single("print_field",array("invoice_id"=>$bill_id),"",1);
            
            $final_data['all_invoice_no']=$all_invoice_no;
            $final_data['product']=$s_data;
            $final_data['total_discount']=$total_discount;
            $final_data['invoice_total']=$invoice_total;
            $final_data['extra_charge']=$extra_charge;
            $final_data['extra_charge_type']=$extra_charge_type;
            $final_data['sub_total']=$invoice_total-$total_discount+$extra_charge;
            $final_data['invoice_id']=$bill_id;
            $this->load->library('Pdfgenerator');
            $html=$this->load->view("admin/bill_pdf_invoice",$final_data,true);
            $this->pdfgenerator->generate($html, "Bill Invoice",TRUE, 'A4',"portrait");
            // $this->load->view('admin/header');
            // $result=$this->load->view("admin/bill_invoice",$final_data);
            // $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function generate_challan_pdf($invoice=null)
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $result=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice,"product_qty!="=>0),"product_name,parts_no,unit,product_qty,alt_parts_no");
            $total_qty=0;
            if(isset($result))
            {
                foreach($result as $value)
                {
                    $total_qty+=$value['product_qty'];
                }
            }
            $final_data['referance_info']=$this->Common_model->get_single("print_field",array("invoice_id"=>$invoice),"",1);
            $final_data['customer_name']=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice),"",1)['client_name'];
            // echo "<pre>";
            // print_r()
            // debug_p($final_data['customer_name']);
            $final_data['sales_type']=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice),"sales_type",1)["sales_type"];
            $final_data['product']=$result;
            $final_data['total_qty']=$total_qty;
            $final_data['invoice_id']=$invoice;
            $this->load->library('Pdfgenerator');
            $html=$this->load->view("admin/challan_pdf_view",$final_data,true);
            $this->pdfgenerator->generate($html, "Challan",TRUE, 'A4',"portrait");
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function generate_invoice_pdf($invoice=null)
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $result=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice,"product_qty!="=>0));
            $final_data['referance_info']=$this->Common_model->get_single("print_field",array("invoice_id"=>$invoice),"",1);
            $final_data['customer_name']=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice),"",1)['client_name'];
            // echo "<pre>";
            // print_r()
            // debug_p($result);
            $final_data['sales_type']=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice),"sales_type",1)["sales_type"];
            $final_data['product']=$result;
            $final_data['invoice_total']=$result[0]['sub_total'];
            $final_data['discount']=$result[0]['discount'];
            $final_data['extra_charge']=$result[0]['extra_charge'];
            $final_data['extra_charge_type']=$result[0]['extra_charge_type'];
            $final_data['sub_total']=$result[0]['sub_total']-$result[0]['discount']+$result[0]['extra_charge'];
            $final_data['invoice_id']=$invoice;
            $this->load->library('Pdfgenerator');
            $html=$this->load->view("admin/invoice_pdf_view",$final_data,true);
            $this->pdfgenerator->generate($html, "Inovice",TRUE, 'A4',"portrait");
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function service_bill()
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data=array();
            $data['all_service_bill']=$this->Common_model->get_all_service_bill();
            // debug_p($data);
            $data['add']=true;
            $this->load->view('admin/header');
            $this->load->view('admin/service_bill', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function service_invoice($id=null)
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data=array();
            $data['service_bill']=$this->Common_model->get_single("service_bill",array("record_id"=>$id),"",1);
            $data['details']=$this->Common_model->get_single("service_bill_details",array("service_bill_id"=>$id));
            // debug_p($data);
            $this->load->view('admin/header');
            $this->load->view('admin/service_bill_invoice', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function print_page_po($po_no) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_value'] = $this->Common_model->get_allinfo_byid('purchase_order', 'po_no', $po_no);

            $count = 0;
            $supplier = "";
            $total_with_extra = "";
            $discount = "";
            $net_payable = "";
            foreach ($data['all_value'] as $info) {
                $supplier = $info->supplier;
                $total_with_extra = $info->total_with_extra;
                $discount = $info->discount;
                $net_payable = $info->net_payable;
            }

            $data["supplier"] = $supplier;
            $data["total_with_extra"] = $total_with_extra;
            $data["discount"] = $discount;
            $data["net_payable"] = $net_payable;
            $data["po_no"] = $po_no;
            $data["print"] = $this->Common_model->get_print_info_single('print_info',array("id"=>1));
            $this->load->view('admin/header');
            $this->load->view('admin/print_page_po', $data);
            $this->load->view('admin/footer');

            //$this->createXLSX($this->Common_model->get_allinfo_byid_ret_array('purchase_order', 'po_no', $po_no));
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function print_barcode($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $data['one_value'] = $this->Common_model->get_allinfo_byid('insert_product_info', 'record_id', $id);
            $this->load->view('admin/header');
            $this->load->view('admin/print_barcode', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function profit_loss($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_product'] = $this->Common_model->only_group_by('sell_product','product_name');
            //var_dump($data['all_product']);
            $this->load->view('admin/header');
            $this->load->view('admin/profit_loss', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function search_income() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['income_head'] = $this->Common_model->get_all_info('income_head');
            $this->load->view('admin/header');
            $this->load->view('admin/search_income', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function search_expense() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['expense_head'] = $this->Common_model->get_all_info('expense_head');
            $this->load->view('admin/header');
            $this->load->view('admin/search_expense', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_due_statement() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_client'] = $this->Common_model->get_all_info('add_client');
            $data['sales_due_statement']=true;
            $this->load->view('admin/header');
            $this->load->view('admin/sales_due_statement', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function purchase_due_statement() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_vendor'] = $this->Common_model->get_all_info('create_manufacture_company');
            $this->load->view('admin/header');
            $this->load->view('admin/purchase_due_statement', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function delivered_product($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $data['invoice'] = $this->Common_model->only_group_by('sell_product', 'invoice_no');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/delivered_product', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function dashboard_purchase_due() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $count = 0;
            $purchase_due_result = $this->Common_model->group_by_sum('purchase_due', 'manufacturer', 'total', 'paid');
            foreach ($purchase_due_result as $purchase_due_info) {
                $count++;
                $single_voucher_total = $purchase_due_info->sum_result1;
                $single_voucher_total_paid = $purchase_due_info->sum_result2;
                $purchase_due = $single_voucher_total - $single_voucher_total_paid;
                $single_Vendor = $purchase_due_info->manufacturer;
                $result = $this->Common_model->get_allinfo_byid('create_manufacture_company', 'manufacture_company', $single_Vendor);

                $mobile_no = "";
                $address = "";
                foreach ($result as $info) {
                    $mobile_no = $info->mobile;
                    $address = $info->address;
                }
                $data['purchase_due' . $count] = $purchase_due;
                $data['vendor_name' . $count] = $single_Vendor;
                $data['mobile' . $count] = $mobile_no;
                $data['address' . $count] = $address;
            }
            $data['count_it'] = $count;
            $this->load->view('admin/header');
            $this->load->view('admin/dashboard_purchase_due', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function dashboard_sales_due() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $count = 0;
            $sales_due_result = $this->Common_model->group_by_sum('sales_due', 'client_id', 'total', 'paid');
            foreach ($sales_due_result as $sales_due_info) {
                $single_voucher_total = $sales_due_info->sum_result1;
                $single_voucher_total_paid = $sales_due_info->sum_result2;
                $sales_due = $single_voucher_total - $single_voucher_total_paid;
                $single_client = $sales_due_info->client_id;
                $result = $this->Common_model->get_allinfo_byid('add_client', 'record_id', $single_client);
                if (!empty($result)) {
                    $count++;
                    foreach ($result as $info) {
                        $client_name = $info->name;
                        $mobile_no = $info->mobile;
                        $address = $info->address;
                    }
                    $data['sales_due' . $count] = $sales_due;
                    $data['client_name' . $count] = $client_name;
                    $data['client_id' . $count] = $single_client;
                    $data['mobile' . $count] = $mobile_no;
                    $data['address' . $count] = $address;
                }
            }
            $data['count_it'] = $count;
            $this->load->view('admin/header');
            $this->load->view('admin/dashboard_sales_due', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function only_product_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->view('admin/header');
            $data['only_product_info']=true;
            $this->load->view('admin/only_product_info',$data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_due($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_invoice'] = $this->Common_model->get_distinct_value("invoice_no", "sales_due");
            $data['all_client'] = $this->Common_model->get_all_info('add_client');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/sales_due', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function purchase_due($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_voucher'] = $this->Common_model->get_distinct_value("voucher_no", "purchase_due");
            $data['all_vendor'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/purchase_due', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function search_product() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['product_name'] = $this->Common_model->get_all_info('create_product_name');
            $data['sub_category'] = $this->Common_model->get_all_info('create_sub_category');
            $data['brand'] = $this->Common_model->get_all_info('create_brand_name');

            $this->load->view('admin/header');
            $this->load->view('admin/search_product', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_section($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_value'] = $this->Common_model->get_all_info('create_section');
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/create_section', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function near_expired_product() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $array_check_expire = array(
                "expiry_date>=" => date('Y-m-d'),
                "expiry_date<" => date('Y-m-d', strtotime('+15 days'))
            );

            $data['expired_product'] = $this->Common_model->get_all_info_by_array('purchase_product', $array_check_expire);
            $title = "Near ";
            $data['title'] = $title;
            $this->load->view('admin/header');
            $this->load->view('admin/expired_product', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function expired_product() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $array_check_expire = array(
                "expiry_date<" => date('Y-m-d')
            );
            $data['expired_product'] = $this->Common_model->get_all_info_by_array('purchase_product', $array_check_expire);
            $title = " ";
            $data['title'] = $title;
            $this->load->view('admin/header');
            $this->load->view('admin/expired_product', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function monthly_sales_number() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $column_with_value_array = array(
                "date>=" => date('Y-m-d', strtotime('first day of this month')),
                "date<=" => date('Y-m-d', strtotime('last day of this month'))
            );
            $result = $this->Common_model->get_distinct_value_where('invoice_no', 'sell_product', $column_with_value_array);
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $data['pro_result' . $count] = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $info->invoice_no);
            }
            $data['count_it'] = $count;
            $data['title'] = "Sales of Month";
            $data['t'] = "Month";
            $this->load->view('admin/header');
            $this->load->view('admin/sales_number', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function today_sales_number() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $column_with_value_array = array(
                "date" => date('Y-m-d')
            );
            $result = $this->Common_model->get_distinct_value_where('invoice_no', 'sell_product', $column_with_value_array);
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $data['pro_result' . $count] = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $info->invoice_no);
            }
            $data['count_it'] = $count;
            $data['title'] = "Sales of Day";
            $data['t'] = "Day";
            $this->load->view('admin/header');
            $this->load->view('admin/sales_number', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function stock_shortage() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $result = $this->Common_model->get_distinct_value("parts_name", "purchase_product");
            $product_count = 0;
            $product_qty = 0;
            $stock_pro_qty = 0;
            $data = array();
            foreach ($result as $info) {

                $parts_name = $info->parts_name;

                $result_qty = $this->Common_model->get_allinfo_byid('purchase_product', 'parts_name', $parts_name);

                $stock_qty = 0;
                $stock_result = $this->Common_model->get_last_data_byid('purchase_product', 'parts_name', $parts_name);
                foreach ($stock_result as $stock_info_qty) {
                    $stock_qty += $stock_info_qty->reminder_level;
                } 

                $pro_qty = 0;
                foreach ($result_qty as $info_qty) {
                    $pro_qty += $info_qty->quantity;
                }

                $result_qty = $this->Common_model->get_allinfo_byid('sell_product', 'product_name', $parts_name);

                foreach ($result_qty as $info_qty) {
                    $pro_qty -= $info_qty->product_qty;
                }

                if ($pro_qty <= $stock_qty) {
                    $product_count++;
                    $data["parts_name" . $product_count] = $parts_name;
                    $data["machine_qty" . $product_count] = $pro_qty;
                    $product_qty += $pro_qty;
                }
            }
            $data['product_qty'] = $product_qty;
            $data['count'] = $product_count;
            $this->load->view('admin/header');
            $this->load->view('admin/stock_shortage', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function parts_no_stock_shortage() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $result = $this->Common_model->get_distinct_value("parts_no", "purchase_product");
            $product_count = 0;
            $product_qty = 0;
            $stock_pro_qty = 0;
            $data = array();
            foreach ($result as $info) {

                $parts_no = $info->parts_no;

                $result_qty = $this->Common_model->get_allinfo_byid('purchase_product', 'parts_no', $parts_no);

                $stock_qty = 0;
                $stock_result = $this->Common_model->get_last_data_byid('purchase_product', 'parts_no', $parts_no);
                foreach ($stock_result as $stock_info_qty) {
                    $stock_qty += $stock_info_qty->reminder_level;
                } 

                $pro_qty = 0;
                foreach ($result_qty as $info_qty) {
                    $pro_qty += $info_qty->quantity;
                }

                $result_qty = $this->Common_model->get_allinfo_byid('sell_product', 'parts_no', $parts_no);

                foreach ($result_qty as $info_qty) {
                    $pro_qty -= $info_qty->product_qty;
                }

                if ($pro_qty <= $stock_qty) {
                    $product_count++;
                    $data["parts_no" . $product_count] = $parts_no;
                    $data["machine_qty" . $product_count] = $pro_qty;
                    $product_qty += $pro_qty;
                }
            }
            $data['product_qty'] = $product_qty;
            $data['count'] = $product_count;
            $this->load->view('admin/header');
            $this->load->view('admin/parts_no_stock_shortage', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    

    public function create_bank_name($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $data['all_value'] = $this->Common_model->get_all_info('create_bank_name');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/create_bank_name', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function bank_deposit($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $data['all_bank'] = $this->Common_model->get_all_info('create_bank_name');
            $data['all_value'] = $this->Common_model->get_all_info('bank_deposit');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/bank_deposit', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function bank_withdraw($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $data['all_bank'] = $this->Common_model->get_all_info('create_bank_name');
            $data['all_value'] = $this->Common_model->get_all_info('bank_withdraw');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/bank_withdraw', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function bank_report($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $data['all_bank'] = $this->Common_model->get_bank_name();
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/bank_report', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_salary_sheet($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_employee'] = $this->Common_model->get_all_info('employee');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/create_salary_sheet', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function report($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/report', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function ledger($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/ledger', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function expense_head($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_value'] = $this->Common_model->get_all_info('expense_head');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/expense_head', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function expense($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['expense_head'] = $this->Common_model->get_all_info('expense_head');
            $data['all_value'] = $this->Common_model->get_all_info('expense');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/expense', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function income_head($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_value'] = $this->Common_model->get_all_info('income_head');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/income_head', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function income($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['income_head'] = $this->Common_model->get_all_info('income_head');
            $data['all_value'] = $this->Common_model->get_all_info('income');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/income', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function officer_list() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_value'] = $this->Common_model->get_all_info('create_department');
            $this->load->view('admin/header');
            $this->load->view('admin/officer_list', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function manufacturer_return_list() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_value'] = $this->Common_model->get_all_info('returned_to_manufacturer');
            $this->load->view('admin/header');
            $this->load->view('admin/manufacturer_return_list', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_return_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_value'] = $this->Common_model->get_all_info_orderby('returned_product_info',"record_id","desc");
            // debug_p($data['all_value']);
            $this->load->view('admin/header');
            $this->load->view('admin/sales_return_info', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_statement($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_client'] = $this->Common_model->get_all_info('add_client');
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['parts_no'] = $this->Common_model->get_distinct_value('parts_no', 'purchase_product');
            $data['all_product_name'] = $this->Common_model->get_all_info('create_product_name');
            $data['invoice'] = $this->Common_model->get_distinct_value('invoice_no', 'sell_product');
            $data['admin'] = $this->Common_model->get_all_info('admin');
            $data['user'] = $this->Common_model->get_all_info('user');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/sales_statement', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function sales_report($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/sales_report', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function return_product($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');

            $result= $this->Common_model->get_distinct_value('invoice_no', 'all_invoice');
            // debug_p($result);
            $sold_product=array();
            if(!empty($result))
            {
                $temp_sold_product=new stdClass();
                foreach($result as $key=>$value){
                    if(check_invoice_paid($value->invoice_no)){
                        $sold_product[]['invoice_no']=$value->invoice_no;
                    }
                }
                foreach($result as $key=>$value){
                    // debug_p(check_exits_invoice($value->invoice_no));
                    if(!check_exits_invoice($value->invoice_no)){
                        $sold_product[]['invoice_no']=$value->invoice_no;
                    }
                }
            }
            // debug_p($temp_sold_productld_product);
            $data['all_value'] = $this->Common_model->get_all_info('returned_product_info');
            $data['msg'] = $msg;
            $data['sold_product']=$sold_product;
            // debug_p($data);
            $this->load->view('admin/header');
            $this->load->view('admin/return_product', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function return_challan_product() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $all_invoice_no=get_challan_invoice();
            // debug_p($temp_sold_productld_product);
            // $data['all_value'] = $this->Common_model->get_all_info('returned_product_info');
            $data['all_invoice_no']=$all_invoice_no;
            // debug_p($data);
            $this->load->view('admin/header');
            $this->load->view('admin/return_challan_product', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

  public function sales_old($msg,$invoice_no=null) {
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
            // $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            // $data['section'] = $this->Common_model->get_all_info('create_section');
            $data['manufacture_company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['parts_name'] = $this->Common_model->get_distinct_value("product_name",'create_product_name');
            $data['invoice'] = $this->Common_model->get_distinct_value('invoice_no', 'sell_product');
            $data['msg'] = $msg;
            if($invoice_no!='')
            {
                $data['invoice_info']=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice_no),'sales_type',1);
                $data['invoice_no'] = $invoice_no;
            }
            $this->load->view('admin/header');
            $this->load->view('admin/sell_product', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
  public function sales($msg="main",$invoice_no=null) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
              if(is_numeric($msg))
            {
                $data['msg'] ="main";
                $segment=$this->uri->segment(3);
            }else{
                $data['msg'] = $msg;
                $segment=0;
            }
            $this->load->library('Pagi');
            $per_page=10;
            $total_rows= $this->Common_model->total_invoice();
            $page = $segment*$per_page;
            
            $data['all_client'] = $this->Common_model->get_all_info('add_client');
            $data['manufacture_company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['parts_name'] = $this->Common_model->get_distinct_value("product_name",'create_product_name');
            $data['invoice'] = $this->Common_model->get_distinct_value('invoice_no', 'sell_product');
            $data["all_sales"]=$this->Common_model->get_sales_product_info($per_page,$page);
            $data['links']=$this->pagi->createPagination("show_form/sales",$total_rows,$per_page);
            if($invoice_no!='')
            {
                $data['invoice_info']=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice_no),'sales_type',1);
                $data['invoice_no'] = $invoice_no;
            }
            $this->load->view('admin/header');
            $this->load->view('admin/sell_product', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_dealing($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_client'] = $this->Common_model->get_all_info('add_client');
            $data['all_value'] = $this->Common_model->get_all_info('sales_dealing');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/sales_dealing', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_schedule($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_client'] = $this->Common_model->get_all_info('add_client');
            $data['all_value'] = $this->Common_model->get_all_info('sales_schedule');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/sales_schedule', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function add_client($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $result = $this->Common_model->get_all_info_orderby('add_client', 'record_id', 'DESC');
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $client_id = $info->record_id;
                $due_result = $this->Common_model->get_allinfo_byid('sales_due', 'client_id', $client_id);
                $total = 0;
                $paid = 0;
                foreach ($due_result as $due_info) {
                    $total += $due_info->total;
                    $paid += $due_info->paid;
                }
                $old_due = $total - $paid;
                $data['old_due' . $count] = $old_due;
            }
            $data['all_value'] = $result;
            $this->load->view('admin/header');
            $this->load->view('admin/add_client', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function manufacturer_return($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['purchased_product'] = $this->Common_model->get_distinct_value('po_no', 'purchase_product');
            $data['all_value'] = $this->Common_model->get_all_info('returned_product_info');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/return_to_manufacture', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function product_inout($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/product_inout', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function purchase_statement($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_product'] = $this->Common_model->get_all_info('insert_product_info');
            $data['all_po'] = $this->Common_model->get_distinct_value('po_no', 'purchase_product');
            $data['all_machine_category'] = $this->Common_model->get_distinct_value('machine_category', 'purchase_product');
            $data['all_parts_no'] = $this->Common_model->get_distinct_value('parts_no', 'purchase_product');
            $data['company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/purchase_statement', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function add_product($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['section'] = $this->Common_model->get_all_info('create_section');
            $data['manufacture_company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['product_name'] = $this->Common_model->get_all_info('create_product_name');
            $data['all_po'] = $this->Common_model->get_distinct_value('po_no', 'purchase_product');

            $data['all_value'] = $this->Common_model->get_all_info_orderby('add_product','record_id',"desc");
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/add_product', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function purchase_product($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['section'] = $this->Common_model->get_all_info('create_section');
            $data['manufacture_company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['product_name'] = $this->Common_model->get_all_info('create_product_name');
            $data['all_po'] = $this->Common_model->get_distinct_value('po_no', 'purchase_product');
            $data['inserted_po'] = $this->Common_model->get_distinct_value('po_no', 'add_product');

            $result = $this->Common_model->get_distinct_value_orderby('po_no', 'purchase_product');
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $data['purchase_result' . $count] = $this->Common_model->get_allinfo_byid('purchase_product', 'po_no', $info->po_no);
            }
            $data['count_it'] = $count;
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/purchase_product', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function purchase_order($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['section'] = $this->Common_model->get_all_info('create_section');
            $data['manufacture_company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['product_name'] = $this->Common_model->get_all_info('create_product_name');

            $result = $this->Common_model->get_distinct_value_orderby('po_no', 'purchase_order');
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $data['purchase_result' . $count] = $this->Common_model->get_allinfo_byid('purchase_order', 'po_no', $info->po_no);
            }

            $data['count_it'] = $count;
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/purchase_order', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function employee_schedule($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_employee'] = $this->Common_model->get_all_info('employee');
            $data['all_value'] = $this->Common_model->get_all_info('employee_schedule');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/employee_schedule', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function dashboard($no) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            if ($no == 1) {
                $array_check_ap = array(
                    "date >= " => date('Y-m-d')
                );
                $data['appointment'] = $this->Common_model->get_all_info_by_array('appointment_info', $array_check_ap);
            } elseif ($no == 2) {
                $data['patient'] = $this->Common_model->get_all_info('patient');
            } elseif ($no == 3) {
                $data['employee'] = $this->Common_model->get_allinfo_byid('staff', 'staff_type', 'Doctor');
                $data["title"] = "Doctor Info.";
            } elseif ($no == 4) {
                $data['employee'] = $this->Common_model->get_allinfo_byid('staff', 'staff_type', 'Nurse');
                $data["title"] = "Nurse Info.";
            } elseif ($no == 5) {
                $data['employee'] = $this->Common_model->get_allinfo_byid('staff', 'staff_type', 'Staff');
                $data["title"] = "Staff Info.";
            } elseif ($no == 6) {
                $data['enquiry'] = $this->Common_model->get_all_info('enquiry');
            } elseif ($no == 7) {
                $data['notice'] = $this->Common_model->get_allinfo_byid('insert_notice', 'date', date('Y-m-d'));
                $data["title"] = "Today Notice";
            } elseif ($no == 8) {
                $array_check = array(
                    "status" => 0
                );
                $data['admitted_patient'] = $this->Common_model->get_all_info_by_array('patient_admission', $array_check);
                $data["title"] = "Admitted Patients";
            }
            $data['no'] = $no;
            $this->load->view('admin/header');
            $this->load->view('admin/dashboard_link', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_product_type($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info_orderby('create_product_type',"product_type","ASC");
            $this->load->view('admin/header');
            $this->load->view('admin/create_product_type', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_sub_category($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_category'] = $this->Common_model->get_all_info('create_product_type');
            $data['all_value'] = $this->Common_model->get_all_info('create_sub_category');
            $this->load->view('admin/header');
            $this->load->view('admin/create_product_sub_category', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_brand_name($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info('create_brand_name');
            $this->load->view('admin/header');
            $this->load->view('admin/create_brand_name', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_product_name($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            
            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['section'] = $this->Common_model->get_all_info('create_section');
            $this->load->view('admin/header');
            $this->load->view('admin/create_product_name', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    //ajax all product show
    public function show_product_name()
    {
        $data['all_value'] = $this->Common_model->get_all_info_orderby('create_product_name',"record_id","DESC");
        $result=$this->load->view('admin/show_product_name', $data,true);
        echo $result;
        exit;
    }
    public function create_manufacture_company($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $result = $this->Common_model->get_all_info('create_manufacture_company');
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $search_vendor = $info->manufacture_company;
                $due_result = $this->Common_model->get_allinfo_byid('purchase_due', 'manufacturer', $search_vendor);
                $total = 0;
                $paid = 0;
                foreach ($due_result as $due_info) {
                    if (!empty($due_info->total)) {
                        $total += $due_info->total;
                    }
                    if (!empty($due_info->paid)) {
                        $paid += $due_info->paid;
                    }
                }
                $old_due = $total - $paid;
                $data['old_due' . $count] = $old_due;
            }
            $data['all_value'] = $result;
            $this->load->view('admin/header');
            $this->load->view('admin/create_manufacture_company', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_storage_type($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info('create_storage_type');
            $this->load->view('admin/header');
            $this->load->view('admin/create_storage_type', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_department($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info('create_department');
            $this->load->view('admin/header');
            $this->load->view('admin/create_department', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_designation($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info('create_designation');
            $this->load->view('admin/header');
            $this->load->view('admin/create_designation', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_employee($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_employee'] = $this->Common_model->get_all_info('employee');
            $data['all_designation'] = $this->Common_model->get_all_info('create_designation');
            $data['all_department'] = $this->Common_model->get_all_info('create_department');
            $this->load->view('admin/header');
            $this->load->view('admin/create_employee', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function employee_list($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_employee'] = $this->Common_model->get_all_info('employee');
            $this->load->view('admin/header');
            $this->load->view('admin/employee_list', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function project_settings($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info('project_program');
            $this->load->view('admin/header');
            $this->load->view('admin/project_settings', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function reg_processing($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info('reg_processing');
            $data['all_client'] = $this->Common_model->get_all_info('add_client');
            $data['all_project'] = $this->Common_model->get_all_info('project_program');
            $this->load->view('admin/header');
            $this->load->view('admin/reg_processing', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function land_dealing($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info('land_dealing');
            $data['all_client'] = $this->Common_model->get_all_info('add_client');
            $data['all_project'] = $this->Common_model->get_all_info('project_program');
            $this->load->view('admin/header');
            $this->load->view('admin/land_dealing', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function customer_care($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info('customer_care');
            $this->load->view('admin/header');
            $this->load->view('admin/customer_care', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function publication($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info('publication');
            $this->load->view('admin/header');
            $this->load->view('admin/publication', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function payment_processing($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info('payment_processing');
            $data['all_project'] = $this->Common_model->get_all_info('project_program');
            $this->load->view('admin/header');
            $this->load->view('admin/payment_processing', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function down_payment($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info('down_payment');
            $data['all_project'] = $this->Common_model->get_all_info('payment_processing');
            $this->load->view('admin/header');
            $this->load->view('admin/down_payment', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function payment_status($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_value'] = $this->Common_model->get_all_info('down_payment');
            $data['all_project'] = $this->Common_model->get_all_info('payment_processing');
            $this->load->view('admin/header');
            $this->load->view('admin/down_payment', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function installment_payment($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_down'] = $this->Common_model->get_all_info('down_payment');
            $this->load->view('admin/header');
            $this->load->view('admin/installment_payment', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_user($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_user'] = $this->Common_model->get_all_info('user');
            $data['all_employee'] = $this->Common_model->get_all_info('employee');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/create_user', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function employee_attendance($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_department'] = $this->Common_model->get_all_info('create_department');
            $this->load->view('admin/header');
            $this->load->view('admin/employee_attendance', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function attendance_report($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['msg'] = $msg;
            $data['all_department'] = $this->Common_model->get_all_info('create_department');
            $this->load->view('admin/header');
            $this->load->view('admin/attendance_report', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function insert_notice($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_value'] = $this->Common_model->get_all_info('insert_notice');
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/insert_notice', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function send_sms_employee() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_value'] = $this->Common_model->get_all_info('create_sms');
            $this->load->view('admin/header');
            $this->load->view('admin/send_sms_employee', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_sms($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $table_name = "create_sms";
            $data['all_value'] = $this->Common_model->get_all_info($table_name);
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/create_sms', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function search_by_serial($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $serial = '';
            $result = $this->Common_model->get_all_info('sell_product');
            foreach ($result as $res) {
                $serial .= '#' . $res->serial;
            }
            $data['serial'] = explode('#', $serial);
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/search_serial', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function saleswarranty($msg) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $serial = '';
            $result = $this->Common_model->get_all_info('sell_product');
            foreach ($result as $res) {
                $serial .= '#' . $res->serial;
            }
            $data['serial'] = explode('#', $serial);
            $data['msg'] = $msg;
            $this->load->view('admin/header');
            $this->load->view('admin/sales_warranty', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    
    //average price

    public function search_avarage_price(){
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $data['parts_name'] = $this->Common_model->get_parts_name_group_by();
            $data['parts_no'] = $this->Common_model->get_parts_no_group_by();


            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['section'] = $this->Common_model->get_all_info('create_section');
            $data['manufacture_company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['product_name'] = $this->Common_model->get_all_info('create_product_name');
            $data['all_po'] = $this->Common_model->get_distinct_value('po_no', 'purchase_product');
            $data['inserted_po'] = $this->Common_model->get_distinct_value('po_no', 'add_product');

            $result = $this->Common_model->get_distinct_value_orderby('po_no', 'purchase_product');
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $data['purchase_result' . $count] = $this->Common_model->get_allinfo_byid('purchase_product', 'po_no', $info->po_no);
            }
            $data['count_it'] = $count;
            $data['msg'] = '';
            $this->load->view('admin/header');
            $this->load->view('admin/avarage_price', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

//search_profit_loss
    public function search_profit_loss(){
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['parts_name'] = $this->Common_model->get_parts_name_group_by();
            $data['parts_no'] = $this->Common_model->get_parts_no_group_by();


            $data['product_type'] = $this->Common_model->get_all_info('create_product_type');
            $data['section'] = $this->Common_model->get_all_info('create_section');
            $data['manufacture_company'] = $this->Common_model->get_all_info('create_manufacture_company');
            $data['product_name'] = $this->Common_model->get_all_info('create_product_name');
            $data['all_po'] = $this->Common_model->get_distinct_value('po_no', 'purchase_product');
            $data['inserted_po'] = $this->Common_model->get_distinct_value('po_no', 'add_product');

            $result = $this->Common_model->get_distinct_value_orderby('po_no', 'purchase_product');
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $data['purchase_result' . $count] = $this->Common_model->get_allinfo_byid('purchase_product', 'po_no', $info->po_no);
            }
            $data['count_it'] = $count;
            $data['msg'] = '';
            $this->load->view('admin/header');
            $this->load->view('admin/avarage_price', $data);
            $this->load->view('admin/footer');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }


}
