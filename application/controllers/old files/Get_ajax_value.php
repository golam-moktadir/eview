<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Get_ajax_value extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
    }
    public function download_excel() {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $client_id = $this->input->post('client_id');
            $product_category = $this->input->post('product_category');
            $parts_no = $this->input->post('parts_no');
            $product_name = $this->input->post('product_name');
            $invoice = $this->input->post('invoice');
            $user = $this->input->post('user');

            $checking_array = array();

            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }
            if (!empty($product_name)) {
                $checking_array['product_name'] = $product_name;
            }
            if (!empty($parts_no)) {
                $checking_array['parts_no'] = $parts_no;
            }
            if (!empty($invoice)) {
                $checking_array['invoice_no'] = $invoice;
            }
            if (!empty($user)) {
                $checking_array['sold_by'] = $user;
            }
            if (!empty($client_id)) {
                $checking_array['client_id'] = $client_id;
            }
            if (!empty($product_category)) {
                $checking_array['product_type'] = $product_category;
            }
        // create file name
        // load excel library
        $this->load->library('excel');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Reference No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Client');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Category');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Section');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Parts Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Parts No');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Unit');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Sales Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'U.Price');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Qty');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Discount');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'S.Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'P.Due');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Total Discount');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'G.Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Paid');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Due');
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Payment');
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Remarks');
        // set Row
        $result = $this->Common_model->get_distinct_value_where('invoice_no', "sell_product", $checking_array);
        $rowCount = 1;
        foreach ($result as $info) {
            $checking_array['invoice_no'] = $info->invoice_no;
            $pro_result = $this->Common_model->get_all_info_by_array("sell_product", $checking_array);
            foreach ($pro_result as $single_value) {
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date('d/m/y', strtotime($single_value->date)));
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $single_value->invoice_no);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $single_value->client_name . ' [ID: ' . $single_value->client_id . ']');
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $single_value->product_type);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $single_value->section);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $single_value->product_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $single_value->parts_no);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $single_value->unit);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $single_value->sales_type);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $single_value->price_per_unit);
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $single_value->product_qty);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $single_value->first_total);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $single_value->ind_discount."%");
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $single_value->total);
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $single_value->sub_total);
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $single_value->previous_due);
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $single_value->discount."%");
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $single_value->complete_total);
                $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $single_value->paid);
                $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $single_value->due);
                $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, "Name: ".$single_value->bank_name."A/C NO: ".
                $single_value->account_no."C. NO: ". $single_value->cheque_no);
                // $objPHPExcel->getActiveSheet()->SetCellValue('V' . $single_value->sold_by);
                $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $single_value->remarks);
            }
        }

        $fileName = "Sales_Statement_".date('d_M_Y').".xlsx";
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);
        // header("Content-Type: application/vnd.ms-excel");
        // redirect(site_url() . $fileName);
        echo $fileName;
    }

    public function download_excel_purchase() {
        $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $po_no = $this->input->post('po_no');
            $manufacturer = $this->input->post('manufacturer');
            $machine_category = $this->input->post('machine_category');
            $parts_no = $this->input->post('parts_no');
            $parts_name = $this->input->post('parts_name');
            $shipping_type = $this->input->post('shipping_type');
            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }
            if (!empty($po_no)) {
                $checking_array['po_no'] = $po_no;
            }
            if (!empty($manufacturer)) {
                $checking_array['supplier'] = $manufacturer;
            }
            if (!empty($machine_category)) {
                $checking_array['machine_category'] = $machine_category;
            }
            if (!empty($parts_no)) {
                $checking_array['parts_no'] = $parts_no;
            }
            if (!empty($parts_name)) {
                $checking_array['parts_name'] = $parts_name;
            }
            if (!empty($shipping_type)) {
                $checking_array['shipping_type'] = $shipping_type;
            }
    // create file name
    // load excel library
    $this->load->library('excel');

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    // set Header
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'PO No.');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Date');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Machine Category');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Section');
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Machine Model');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Chassis No.');
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Parts Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Parts No.');
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Chinese Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Brand');
    $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Unit');
    $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'U.Price');
    $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Discount');
    $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'After Discount U.P');
    $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Payment Type');
    $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Shipping Type');
    $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Qty');
    $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Total Price');
    $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'R.Level');
    $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Description');
    $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Shelf Details');
    $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Selling U.Price');
    $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Supplier');
    $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Shipping Type');
    $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Others Cost');
    $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Total Cost');
    // set Row
    $result = $this->Common_model->get_distinct_value_where('po_no', "purchase_product", $checking_array);
    $rowCount = 1;
    foreach ($result as $info) {
        $checking_array['po_no'] = $info->po_no;
        $pro_result = $this->Common_model->get_all_info_by_array("purchase_product", $checking_array);
        foreach ($pro_result as $single_value) {
            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $single_value->po_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $single_value->date);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $single_value->machine_category);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $single_value->section);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $single_value->machine_model);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $single_value->chassis);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $single_value->parts_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $single_value->alternative_parts_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $single_value->chinese_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $single_value->brand);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $single_value->unit);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $single_value->unit_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $single_value->discount."%");
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $single_value->after_discount_unit_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $single_value->payment_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $single_value->shipping_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $single_value->quantity);
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, round($single_value->total_price,2,PHP_ROUND_HALF_UP));
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $single_value->reminder_level);
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $single_value->description);
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $single_value->shelf_details);
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $single_value->selling_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $single_value->supplier);
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $single_value->shipping_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, "Shipping: ".$single_value->shiping_cost.
            "Custom: ".$single_value->custom_cost."Transport: ".$single_value->transport_cost.
            "Mixed: ".$single_value->misc_cost);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, "Total Price: ".$single_value->total_with_extra.
            "Discount: ".$single_value->total_discount."Net Payable: ".$single_value->net_payable);
        }
    }

    $fileName = "Purchase_Statement_".date('d_M_Y').".xlsx";
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter->save($fileName);
    // header("Content-Type: application/vnd.ms-excel");
    // redirect(site_url() . $fileName);
    echo $fileName;
}

    public function add_print_info() {
        $id = $this->input->post("id");
        $data = array(
            "subject" => $this->input->post("subject"),
            "purchase_date" => $this->input->post("new_date"),
            "address" => $this->input->post("to"),
        );
        $this->db->update('print_info', $data, array("id" => $id));
        echo "success";
    }
   
    public function get_all_by_po_total() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $po_no = $this->input->post('po_no');
            $data['all_value'] = $this->Common_model->get_allinfo_byid('add_product', 'po_no', $po_no);
            $total = 0;
            foreach ($data['all_value'] as $single) {
                $total += $single->total_price;
            }
            echo $total;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_all_by_po() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $po_no = $this->input->post('po_no');
            $data['all_value'] = $this->Common_model->get_allinfo_byid('add_product', 'po_no', $po_no);
            $this->load->view('admin/get_all_by_po', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_avail_qty() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $parts_name = $this->input->post('parts_name');
            $result_qty = $this->Common_model->get_allinfo_byid2('purchase_product', array("parts_name"=>$parts_name));
            $new_add_qty = 0;
            foreach ($result_qty as $info_qty) {
                $new_add_qty += $info_qty->quantity;
            }

            $result_qty = $this->Common_model->get_allinfo_byid2('sell_product', array("product_name"=>$parts_name,"delivered_status"=>1));
            $sales_qty = 0;
            foreach ($result_qty as $info_qty) {
                $sales_qty += $info_qty->product_qty;
            }
//            $data["new_add_qty" . $product_count] = $new_add_qty;
//            $data["sales_qty" . $product_count] = $sales_qty;
            $present_qty = $new_add_qty - $sales_qty;
            $pending_qty = $this->Common_model->get_pending_qty('sell_product',array("product_name"=>$parts_name,"delivered_status"=>0));
            $send_data['pending_qty']=$pending_qty;
            $send_data['present_qty']=$present_qty;
            echo json_encode($send_data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function get_avail_part_no_qty() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $parts_no = $this->input->post('parts_no');
            $parts_name = $this->input->post('parts_name');
            $result_qty = $this->Common_model->get_allinfo_byid2('purchase_product',array("parts_no"=>$parts_no,"parts_name"=>$parts_name));
            $new_add_qty = 0;
            foreach ($result_qty as $info_qty) {
                $new_add_qty += $info_qty->quantity;
            }

            $result_qty = $this->Common_model->get_allinfo_byid2('sell_product',array("parts_no"=>$parts_no,"product_name"=>$parts_name,"delivered_status"=>1));
            $sales_qty = 0;
            foreach ($result_qty as $info_qty) {
                $sales_qty += $info_qty->product_qty;
            }
            $present_qty = $new_add_qty - $sales_qty;
            $pending_qty = $this->Common_model->get_pending_qty('sell_product',array("parts_no"=>$parts_no,"product_name"=>$parts_name,"delivered_status"=>0));
            $send_data['pending_qty']=$pending_qty;
            $send_data['present_qty']=$present_qty;
            echo json_encode($send_data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function search_sales_product() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $search_invoice = $this->input->post('search_invoice');
            $count = 1;
            $data['pro_result' . $count] = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $search_invoice);

            $data['count_it'] = $count;

            $this->load->view('admin/search_sales_product', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function search_purchase_product() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $search_po_no = $this->input->post('search_po_no');
            $brand = $this->input->post('brand');

            $result = $this->Common_model->get_distinct_value_where_brand_po("po_no,brand", "purchase_product", $brand, $search_po_no);
            
            // debug_p($result);
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $data['purchase_result' . $count] = $this->Common_model->get_allinfo_byid2('purchase_product', array("po_no"=>$info->po_no,"brand"=>$info->brand));
            }
            
            $data['count_it'] = $count;
            $this->load->view('admin/search_purchase_product', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_average_selling_unit() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $parts_name = $this->input->post('parts_name');

            $result = $this->Common_model->get_allinfo_byid('purchase_product', 'parts_name', $parts_name);

            $total_qty = 0;
            $total_price = 0;
            foreach ($result as $info) {
                $total_qty += $info->quantity;
                $total_price += $info->selling_price;
            }

            if ($total_qty == 0) {
                $average_unit_price = "";
            } else {
                $average_unit_price = $total_price / $total_qty;
            }
            echo round($average_unit_price,2,PHP_ROUND_HALF_DOWN);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function get_average_unit_price_for_sale() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $parts_name = $this->input->post('parts_name');
            $parts_no = $this->input->post('parts_no');
            if($parts_name!='')
            {
                $checking_array['parts_name']=$parts_name;
            }
            if($parts_no!='')
            {
                $checking_array['parts_no']=$parts_no;
            }
            $result=round($this->Common_model->get_average_unit_price_for_sale($checking_array),2,PHP_ROUND_HALF_UP);
            echo json_encode($result);
           
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_unit() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $parts_name = $this->input->post('parts_name');
            $result = $this->Common_model->get_allinfo_byid("purchase_product", 'parts_name', $parts_name);
            $unit = "";
            foreach ($result as $info) {
                $unit = $info->unit;
            }
            echo $unit;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_parts_no_by_name() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $parts_name = $this->input->post('parts_name');
            $result = $this->Common_model->group_by_data_where("purchase_product", array("parts_name" => $parts_name), "parts_no");

            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                if (!empty($info->parts_no)) {
                    $option .= "<option value='$info->parts_no'>$info->parts_no</option>";
                }
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_alt_parts_no_by_name() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $parts_name = $this->input->post('parts_name');
            $result = $this->Common_model->group_by_data_where("purchase_product", array("parts_name" => $parts_name), "alternative_parts_no");

            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                if (!empty($info->alternative_parts_no)) {
                    $option .= "<option value='$info->alternative_parts_no'>$info->alternative_parts_no</option>";
                }
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_parts_name() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $section = $this->input->post('section');
            $result = $this->Common_model->get_allinfo_byid("create_product_name", 'section', $section);
            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                $option .= "<option value='$info->product_name'>$info->product_name</option>";
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_parts_name2() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $product_type = $this->input->post('product_type');
            $result = $this->Common_model->get_allinfo_byid("create_product_name", 'machine_category', $product_type);
            // debug_p($result);
            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                $option .= "<option value='$info->product_name'>$info->product_name</option>";
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function get_brand_name() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $product_type = $this->input->post('product_type');
            $result = $this->Common_model->get_allinfo_byid("create_product_type", 'product_type', $product_type);
            // debug_p($result);
            $option="";
            foreach ($result as $info) {
                $option=$info->brand;
            }
            echo json_encode($option);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_section() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $machine_category = $this->input->post('product_type');
            $result = $this->Common_model->get_allinfo_byid("create_section", 'machine_category', $machine_category);
            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                $option .= "<option value='$info->section'>$info->section</option>";
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_model() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $machine_category = $this->input->post('product_type');

            $result = $this->Common_model->group_by_data_where("purchase_product", array("machine_category" => $machine_category), "machine_model");

            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                if (!empty($info->machine_model)) {
                    $option .= "<option value='$info->machine_model'>$info->machine_model</option>";
                }
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_chassis() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $machine_category = $this->input->post('product_type');
            $result = $this->Common_model->group_by_data_where("purchase_product", array("machine_category" => $machine_category), "chassis");

            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                if (!empty($info->chassis)) {
                    $option .= "<option value='$info->chassis'>$info->chassis</option>";
                }
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_parts_no() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $parts_name = $this->input->post('product_name');
            $result = $this->Common_model->group_by_data_where("purchase_product", array("parts_name" => $parts_name), "parts_no");

            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                if (!empty($info->parts_no)) {
                    $option .= "<option value='$info->parts_no'>$info->parts_no</option>";
                }
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_alt_parts_no() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $machine_category = $this->input->post('product_type');
            $result = $this->Common_model->group_by_data_where("purchase_product", array("machine_category" => $machine_category), "alternative_parts_no");

            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                if (!empty($info->alternative_parts_no)) {
                    $option .= "<option value='$info->alternative_parts_no'>$info->alternative_parts_no</option>";
                }
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_chinese_name() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $machine_category = $this->input->post('product_type');
            $result = $this->Common_model->group_by_data_where("purchase_product", array("machine_category" => $machine_category), "chinese_name");

            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                if (!empty($info->chinese_name)) {
                    $option .= "<option value='$info->chinese_name'>$info->chinese_name</option>";
                }
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_average_unit_price() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $parts_name = $this->input->post('parts_name');

            $result = $this->Common_model->get_allinfo_byid('purchase_product', 'parts_name', $parts_name);

            $total_qty = 0;
            $total_price = 0;
            foreach ($result as $info) {
                $total_qty += $info->quantity;
                $total_price += $info->total_price;
            }

            if ($total_qty == 0) {
                $average_unit_price = "";
            } else {
                $average_unit_price = $total_price / $total_qty;
            }
            echo $average_unit_price;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function generate_barcode() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $product_id = $this->input->post('product_id');
            $quantity = $this->input->post('quantity');

            $result = $this->Common_model->get_allinfo_byid('insert_product_info', 'record_id', $product_id);
            foreach ($result as $res) {
                $image = $res->image;
                $name = $res->product_name;
                $r_price = $res->retail_price;
            }

            $data['product_id'] = $image;
            $data['quantity'] = $quantity;
            $data['name'] = $name;
            $data['r_price'] = $r_price;

            $this->load->view('admin/show_barcodes', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_product() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $product_type = $this->input->post('product_type');

            $result = $this->Common_model->get_allinfo_byid('insert_product_info', 'product_type', $product_type);

            $data = array($result);
            echo json_encode($data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_product_profit_loss_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $product_id = $this->input->post('product_id');
            $checking_array = array();
//            if (!empty($date_from) && !empty($date_to))  {
//                $checking_array['date >='] = $date_from;
//                $checking_array['date <='] = $date_to;
//            }
            if (!empty($product_id)) {
                $checking_array['record_id'] = $product_id;
            }
            $data['all_product_info'] = $this->Common_model->check_value_get_data('insert_product_info', $checking_array);
            if (!empty($data['all_product_info'])) {
                $count = 0;
                foreach ($data['all_product_info'] as $p) {
                    $purchase_price = $p->purchase_price;
                    $array_check = array();
                    $array_check['product_id'] = $p->record_id;
                    if (!empty($date_from) && !empty($date_to)) {
                        $array_check['date >='] = $date_from;
                        $array_check['date <='] = $date_to;
                    }
                    $sold_qty = 0;
                    $total_sale = 0;
                    $sales = $this->Common_model->get_all_info_by_array('sell_product', $array_check);
                    foreach ($sales as $s) {
                        $sold_qty += $s->product_qty;
                        $total_sale += ($s->sub_total - $s->ind_discount);
                    }
                    if ($sold_qty != 0) {
                        $count++;
                        $data['name' . $count] = $p->product_name . ' [ID: ' . 'RTB' . sprintf('%04d', $p->record_id) . ']';
                        $data['purchase_price' . $count] = $p->purchase_price;
                        $data['sold_qty' . $count] = $sold_qty;
                        $data['selling_price' . $count] = round($total_sale / $sold_qty, 2);
                        $data['profit_loss_unit' . $count] = $data['selling_price' . $count] - $purchase_price;
                        $data['profit_loss_total' . $count] = $data['profit_loss_unit' . $count] * $sold_qty;
                        $data['total_sale' . $count] = $total_sale;
                    }
                }
                $data['c'] = $count;
                $data['start_date'] = $date_from;
                $data['end_date'] = $date_to;
                $this->load->view('admin/show_product_profit_loss_info', $data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_expense_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $expense_head = $this->input->post('expense_head');

            $checking_array = array();
            $data['date_range'] = "";
            $data["expense_head"] = "All Expense Info.";
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
                $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
            }
            if (!empty($expense_head)) {
                $checking_array['head'] = $expense_head;
                $data["expense_head"] = $expense_head;
            }
            $data["all_value"] = $this->Common_model->get_all_info_by_array("expense", $checking_array);

            $this->load->view('admin/get_expense_report', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_income_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $income_head = $this->input->post('income_head');

            $checking_array = array();
            $data['date_range'] = "";
            $data["income_head"] = "All Income Info.";
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
                $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
            }
            if (!empty($income_head)) {
                $checking_array['head'] = $income_head;
                $data["income_head"] = $income_head;
            }
            $data["all_value"] = $this->Common_model->get_all_info_by_array("income", $checking_array);

            $this->load->view('admin/get_income_report', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_purchase_due_statement() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $vendor = $this->input->post('vendor');

            $checking_array = array();
            $data['date_range'] = "";
            $data['vendor_name'] = "";
            if (!empty($vendor)) {
                $checking_array['manufacturer'] = $vendor;
                $data['vendor_name'] = $vendor;
            }
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
                $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
            }
            $data["all_value"] = $this->Common_model->get_all_info_by_array("purchase_due", $checking_array);

            $this->load->view('admin/show_purchase_due_statement', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_sales_due_statement() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $client_id = $this->input->post('client_id');

            $checking_array = array();
            $data['date_range'] = "";
            if (!empty($client_id)) {
                $checking_array['client_id'] = $client_id;
            }
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
                $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
            }
            $data["all_value"] = $this->Common_model->get_sales_info_by_array_group_by_sum($checking_array);
            // $result = $this->Common_model->get_allinfo_byid('sales_due', 'client_id', $client_id);
            $total = 0;
            $paid = 0;
            $discount = 0;
            foreach ($data["all_value"] as $info) {
                $total += $info->total_without_discount;
                $paid += $info->total_paid;
                $discount += $info->total_discount;
            }
            $total_due = ($total - $discount) - $paid;
            $data['total'] = $total;
            $data['discount'] = $discount;
            $data['total_after_discount'] = $total - $discount;
            $data['total_paid'] = $paid;
            $data['total_due'] = $total_due;
            // echo "<pre>";
            // print_r($data['all_value']);
            // die();
            $this->load->view('admin/show_sales_due_statement', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_challan_statement() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $challan = $this->input->post('challan');

            $checking_array = array();
            if (!empty($challan)) {
                $checking_array['invoice_no'] = $challan;
            }
            $result = $this->Common_model->get_distinct_value_where('invoice_no', "sell_product", $checking_array);
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $checking_array['invoice_no'] = $info->invoice_no;
                $data['pro_result' . $count] = $this->Common_model->get_all_info_by_array("sell_product", $checking_array);
            }
            $data['count_it'] = $count;
            $this->load->view('admin/challan_statement_show_all', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_product_model() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $product_name = $this->input->post('product_name');
            $result = $this->Common_model->get_allinfo_byid('insert_product_info', 'product_name', $product_name);

            $data = array();
            foreach ($result as $info) {
                array_push($data, $info->product_model);
            }
            echo json_encode($data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_customer_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $client_id = $this->input->post('customer_id');
            $result = $this->Common_model->get_allinfo_byid('sales_due', 'client_id', $client_id);
            $total = 0;
            $paid = 0;
            foreach ($result as $info) {
                $total += $info->total;
                $paid += $info->paid;
            }
            $old_due = $total - $paid;
            $data['old_due'] = $old_due;
            $data['all_value'] = $this->Common_model->get_allinfo_byid('add_client', 'record_id', $client_id);
            $this->load->view('admin/get_customer_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_client_due() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $client = $this->input->post('client');
            if (empty($client)) {
                $old_due = 0;
                $point = 0;
            } else {
                $client = explode('#', $this->input->post('client'));
                $client_name = $client[0];
                $client_id = $client[1];

                $result = $this->Common_model->get_allinfo_byid('sales_due', 'client_id', $client_id);
                $total = 0;
                $paid = 0;
                foreach ($result as $info) {
                    $total += $info->total;
                    $paid += $info->paid;
                }
                $old_due = $total - $paid;

                $result = $this->Common_model->get_allinfo_byid('add_client', 'record_id', $client_id);
                foreach ($result as $info) {
                    $point = $info->point;
                }
            }
            $data = array($old_due, $point);
            echo json_encode($data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_sales_chalan() {
        $temp_chalan = array();
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $client = $this->input->post('client_id');
            if (empty($client)) {

                $temp_chalan['msg'] = "Please Select Client";
            } else {

                $client = explode('#', $this->input->post('client_id'));
                $client_id = $client[1];
                $all_value = $this->Common_model->get_distinct_value_order_by_where('invoice_no', 'sales_due', array('client_id' => $client_id), "invoice_no", "ASC");
                foreach ($all_value as $value) {
                    $temp_chalan[] = $value->invoice_no;
                }
            }
            echo json_encode($temp_chalan);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_sales_due() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $search_client = $this->input->post('search_client');
            if (empty($search_client)) {
                echo "<p style='color: red;font-size: 20px;'>Please select a client.</p>";
            } else {
                $search_client = explode('#', $this->input->post('search_client'));
                $client_name = $search_client[0];
                $client_id = $search_client[1];
                $chalan = $this->input->post('chalan');
                $data['all_value'] = $this->Common_model->get_all_byid_orderby('sales_due', 'client_id', $client_id, "record_id", "DESC");
                $total = 0;
                $paid = 0;
                $discount = 0;
                foreach ($data['all_value'] as $info) {
                    if ($chalan == $info->invoice_no) {
                        $total += $info->total;
                        $paid += $info->paid;
                        $discount += $info->discount;
                    }
                }
                $old_due = ($total - $discount - $paid);
                $data['old_due'] = $old_due;
                $data['client_name'] = $client_name;
                $data['client_id'] = $client_id;
                // debug_p($data);
                $this->load->view('admin/show_sales_due', $data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_sales_due_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $invoice = $this->input->post('invoice');

            $result = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $invoice);
            if (empty($result)) {
                $data = array("Not Available", "Not Available", "Not Available", "Not Available");
            } else {
                foreach ($result as $info) {
                    $client_id = $info->client_id;
                    $customer = $info->client_name . " [Id: " . $info->client_id . "]";
                    $total = $info->total;
                }

                $result = $this->Common_model->get_allinfo_byid('add_client', 'record_id', $client_id);
                foreach ($result as $info) {
                    $mobile = $info->mobile;
                }

                $total_paid = 0;
                $result = $this->Common_model->get_allinfo_byid('sales_due', 'invoice_no', $invoice);
                foreach ($result as $info) {
                    $total_paid += $info->paid;
                }
                $due = $total - $total_paid;

                $data = array($customer, $total, $due, $mobile);
            }
            echo json_encode($data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_purchase_due() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $search_vendor = $this->input->post('search_vendor');

            if (empty($search_vendor)) {
                echo "<p style='color: red;font-size: 20px;'>Please select a vendor.</p>";
            } else {
                $data['all_value'] = $this->Common_model->get_allinfo_byid('purchase_due', 'manufacturer', $search_vendor);
                $total = 0;
                $paid = 0;
                foreach ($data['all_value'] as $info) {
                    $total += $info->total;
                    $paid += $info->paid;
                }
                $old_due = $total - $paid;
                $data['old_due'] = $old_due;
                $data['vendor_name'] = $search_vendor;
                $this->load->view('admin/show_purchase_due', $data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_due_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $voucher = $this->input->post('voucher');

            $result = $this->Common_model->get_allinfo_byid('purchase_product', 'invoice_no', $voucher);
            $total = 0;
            if (empty($result)) {
                $data = array("Not Available", "Not Available", "Not Available");
            } else {
                foreach ($result as $info) {
                    $manufacture_company = $info->manufacture_company;
                    $total += $info->sub_total;
                }

                $total_paid = 0;
                $result = $this->Common_model->get_allinfo_byid('purchase_due', 'voucher_no', $voucher);
                foreach ($result as $info) {
                    $total_paid += $info->paid;
                }
                $due = $total - $total_paid;
                $data = array($manufacture_company, $total, $due);
            }
            echo json_encode($data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_product_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $search_product_type = $this->input->post('search_product_type');
            $search_product_name = $this->input->post('search_product_name');
            $search_product_model = $this->input->post('search_product_model');
            $sub_category = $this->input->post('sub_category');
            $brand_name = $this->input->post('brand_name');


            $array_check = array();
            if (!empty($search_product_type)) {
                $array_check["product_type"] = $search_product_type;
            }
            if (!empty($search_product_name)) {
                $array_check["product_name"] = $search_product_name;
            }
            if (!empty($search_product_model)) {
                $array_check["product_model"] = $search_product_model;
            }
            if (!empty($sub_category)) {
                $array_check["sub_category"] = $sub_category;
            }
            if (!empty($brand_name)) {
                $array_check["brand_name"] = $brand_name;
            }

            $data['all_value'] = $this->Common_model->get_all_info_by_array("insert_product_info", $array_check);
            $this->load->view('admin/show_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_salary_sheet() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $data['date_range'] = "";
            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $data['date_range'] = "$date_from to $date_to";
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }

            $data['all_value'] = $this->Common_model->get_all_info_by_array("create_salary_sheet", $checking_array);
            $total = 0;
            foreach ($data['all_value'] as $info) {
                $total += $info->salary_scale;
            }
//            $data['month'] = $month;
            $data['total'] = $total;
            $this->load->view('admin/show_salary_sheet', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_des_acc_salary() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $employee_id = $this->input->post('employee_id');

            $result = $this->Common_model->get_allinfo_byid('employee', 'record_id', $employee_id);
            if (empty($result)) {
                $data = array("Not Available", "Not Available", "Not Available");
            } else {
                foreach ($result as $info) {
                    $designation = $info->designation;
                    $account = $info->account;
                    $salary = $info->total_salary;
                }
                $data = array($designation, $account, $salary);
            }
            echo json_encode($data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_bank_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $bank_name = $this->input->post('bank_name');
            if (empty($from_date) && empty($to_date)) {
                $data['deposit_result'] = $this->Common_model->get_allinfo_byid('bank_deposit', 'bank_name', $bank_name);
                $data['withdraw_result'] = $this->Common_model->get_allinfo_byid('bank_withdraw', 'bank_name', $bank_name);
            } elseif (empty($bank_name)) {
                $data['deposit_result'] = $this->Common_model->data_between_date('bank_deposit', 'date', $to_date, $from_date);
                $data['withdraw_result'] = $this->Common_model->data_between_date('bank_withdraw', 'date', $to_date, $from_date);
            } else {
                $data['deposit_result'] = $this->Common_model->data_between_date_where('bank_deposit', 'date', $to_date, $from_date, 'bank_name', $bank_name);
                $data['withdraw_result'] = $this->Common_model->data_between_date_where('bank_withdraw', 'date', $to_date, $from_date, 'bank_name', $bank_name);
            }
            $this->load->view('admin/bank_show_report', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_report_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $data['date_range'] = "";
            if (!empty($date_from) && !empty($date_to)) {
                $data['date_range'] = date('d/m/y', strtotime($date_from)) . " to " . date('d/m/y', strtotime($date_to));
            }
            $data['all_sales'] = $this->Common_model->data_date_to_date('sell_product', 'date', $date_from, $date_to);
            $data['sales_due'] = $this->Common_model->data_date_to_date('sales_due', 'date', $date_from, $date_to);
            $data['all_income'] = $this->Common_model->data_date_to_date('income', 'date', $date_from, $date_to);

            $data['all_purchase_product'] = $this->Common_model->data_date_to_date('purchase_product', 'date', $date_from, $date_to);
            $data['purchase_due'] = $this->Common_model->data_date_to_date('purchase_due', 'date', $date_from, $date_to);
            $data['all_expense'] = $this->Common_model->data_date_to_date('expense', 'date', $date_from, $date_to);
            $data['all_salary'] = $this->Common_model->data_date_to_date('create_salary_sheet', 'date', $date_from, $date_to);

            $count = 0;
            foreach ($data['all_sales'] as $info1) {
                $count++;
                $data['date' . $count] = $info1->date;
                $data['invoice' . $count] = $info1->invoice_no;
                $data['selling_amount' . $count] = $info1->sub_total;
                $data['particular' . $count] = "X";
                $data['amount' . $count] = "0";
                $data['client' . $count] = "X";
                $data['sales_collection' . $count] = "0";
            }
            foreach ($data['sales_due'] as $info1) {
                if ($info1->paid != 0) {
                    $count++;
                    $data['date' . $count] = $info1->date;
                    $data['invoice' . $count] = "0";
                    $data['selling_amount' . $count] = "0";
                    $data['particular' . $count] = "X";
                    $data['amount' . $count] = "0";
                    $data['client' . $count] = $info1->client_name;
                    $data['sales_collection' . $count] = $info1->paid;
                }
            }
            foreach ($data['all_income'] as $info1) {
                $count++;
                $data['date' . $count] = $info1->date;
                $data['invoice' . $count] = "0";
                $data['selling_amount' . $count] = "0";
                $data['particular' . $count] = $info1->head;
                $data['amount' . $count] = $info1->amount;
                $data['client' . $count] = "X";
                $data['sales_collection' . $count] = "0";
            }

            $count_ex = 0;
            foreach ($data['all_purchase_product'] as $info1) {
                $count_ex++;
                $data['expense_date' . $count_ex] = $info1->date;
                $data['voucher' . $count_ex] = $info1->invoice_no;
                $data['purchase_amount' . $count_ex] = $info1->sub_total;
                $data['expense_particular' . $count_ex] = "X";
                $data['expense_amount' . $count_ex] = "0";
                $data['vendor' . $count_ex] = "X";
                $data['purchase_payment' . $count_ex] = "0";
            }
            foreach ($data['purchase_due'] as $info1) {
                if ($info1->paid != 0) {
                    $count_ex++;
                    $data['expense_date' . $count_ex] = $info1->date;
                    $data['voucher' . $count_ex] = "0";
                    $data['purchase_amount' . $count_ex] = "0";
                    $data['expense_particular' . $count_ex] = "X";
                    $data['expense_amount' . $count_ex] = "0";
                    $data['vendor' . $count_ex] = $info1->manufacturer;
                    $data['purchase_payment' . $count_ex] = $info1->paid;
                }
            }
            foreach ($data['all_expense'] as $info1) {
                $count_ex++;
                $data['expense_date' . $count_ex] = $info1->date;
                $data['voucher' . $count_ex] = "0";
                $data['purchase_amount' . $count_ex] = "0";
                $data['expense_particular' . $count_ex] = $info1->head;
                $data['expense_amount' . $count_ex] = $info1->amount;
                $data['vendor' . $count_ex] = "X";
                $data['purchase_payment' . $count_ex] = "0";
            }
            foreach ($data['all_salary'] as $info1) {
                $count_ex++;
                $data['expense_date' . $count_ex] = $info1->date;
                $data['voucher' . $count_ex] = "0";
                $data['purchase_amount' . $count_ex] = "0";
                $data['expense_particular' . $count_ex] = "Salary (" . $info1->employee_name . ")";
                $data['expense_amount' . $count_ex] = $info1->salary_scale;
                $data['vendor' . $count_ex] = "X";
                $data['purchase_payment' . $count_ex] = "0";
            }
            if ($count >= $count_ex) {
                $empty_range = $count - $count_ex;
                $start = $count_ex + 1;
                $finish = $count_ex + $empty_range;
                for ($i = $start; $i <= $finish; $i++) {
                    $data['expense_date' . $i] = "";
                    $data['voucher' . $i] = "";
                    $data['purchase_amount' . $i] = "";
                    $data['expense_particular' . $i] = "";
                    $data['expense_amount' . $i] = "";
                    $data['vendor' . $i] = "";
                    $data['purchase_payment' . $i] = "";
                }
                $data['count_it'] = $count;
            } else {
                $empty_range = $count_ex - $count;
                $start = $count + 1;
                $finish = $count + $empty_range;
                for ($i = $start; $i <= $finish; $i++) {
                    $data['date' . $i] = "";
                    $data['invoice' . $i] = "";
                    $data['selling_amount' . $i] = "";
                    $data['particular' . $i] = "";
                    $data['amount' . $i] = "";
                    $data['client' . $i] = "";
                    $data['sales_collection' . $i] = "";
                }
                $data['count_it'] = $count_ex;
            }

            $this->load->view('admin/show_report_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_ledger_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $data['all_sales'] = $this->Common_model->data_date_to_date('sales_due', 'date', $date_from, $date_to);
            $data['bank_deposit'] = $this->Common_model->data_date_to_date('bank_deposit', 'date', $date_from, $date_to);
            $data['all_income'] = $this->Common_model->data_date_to_date('income', 'date', $date_from, $date_to);

            $data['all_purchase_product'] = $this->Common_model->data_date_to_date('purchase_due', 'date', $date_from, $date_to);
            $data['bank_withdraw'] = $this->Common_model->data_date_to_date('bank_withdraw', 'date', $date_from, $date_to);
            $data['all_expense'] = $this->Common_model->data_date_to_date('expense', 'date', $date_from, $date_to);
            $data['all_salary'] = $this->Common_model->data_date_to_date('create_salary_sheet', 'date', $date_from, $date_to);

            $count = 0;
            foreach ($data['all_sales'] as $info1) {
                if ($info1->paid != 0) {
                    $count++;
                    $data['date' . $count] = $info1->date;
                    $data['particular' . $count] = "Sales Collection";
                    $data['client_info' . $count] = "$info1->client_name [ID: $info1->client_id]";
                    $data['amount' . $count] = $info1->paid;
                }
            }
            foreach ($data['all_income'] as $info1) {
                $count++;
                $data['date' . $count] = $info1->date;
                $data['particular' . $count] = $info1->head;
                $data['client_info' . $count] = "X";
                $data['amount' . $count] = $info1->amount;
            }
            foreach ($data['bank_deposit'] as $info1) {
                $count++;
                $data['date' . $count] = $info1->date;
                $data['particular' . $count] = 'Deposit By: ' . $info1->responsible_person . '<br>(' . $info1->bank_name . '<br>A/C: ' . $info1->account_no . ')';
                $data['client_info' . $count] = "X";
                $data['amount' . $count] = $info1->amount;
            }

            $count_ex = 0;
            foreach ($data['all_purchase_product'] as $info1) {
                if ($info1->paid != 0) {
                    $count_ex++;
                    $data['expense_date' . $count_ex] = $info1->date;
                    $data['expense_particular' . $count_ex] = "Purchase Payment";
                    $data['expense_vendor' . $count_ex] = $info1->manufacturer;
                    $data['expense_amount' . $count_ex] = $info1->paid;
                }
            }
            foreach ($data['all_expense'] as $info1) {
                $count_ex++;
                $data['expense_date' . $count_ex] = $info1->date;
                $data['expense_particular' . $count_ex] = $info1->head;
                $data['expense_vendor' . $count_ex] = "X";
                $data['expense_amount' . $count_ex] = $info1->amount;
            }
            foreach ($data['all_salary'] as $info1) {
                $count_ex++;
                $data['expense_date' . $count_ex] = $info1->date;
                $data['expense_particular' . $count_ex] = "Salary (" . $info1->employee_name . ")";
                $data['expense_vendor' . $count_ex] = "X";
                $data['expense_amount' . $count_ex] = $info1->salary_scale;
            }
            foreach ($data['bank_withdraw'] as $info1) {
                $count_ex++;
                $data['expense_date' . $count_ex] = $info1->date;
                $data['expense_particular' . $count_ex] = 'Withdraw By: ' . $info1->responsible_person . '<br>(' . $info1->bank_name . '<br>A/C: ' . $info1->account_no . ')';
                $data['expense_vendor' . $count_ex] = "X";
                $data['expense_amount' . $count_ex] = $info1->amount;
            }

            if ($count >= $count_ex) {
                $empty_range = $count - $count_ex;
                $start = $count_ex + 1;
                $finish = $count_ex + $empty_range;
                for ($i = $start; $i <= $finish; $i++) {
                    $data['expense_date' . $i] = "";
                    $data['expense_particular' . $i] = "";
                    $data['expense_vendor' . $i] = "";
                    $data['expense_amount' . $i] = "";
                }
                $data['count_it'] = $count;
            } else {
                $empty_range = $count_ex - $count;
                $start = $count + 1;
                $finish = $count + $empty_range;
                for ($i = $start; $i <= $finish; $i++) {
                    $data['date' . $i] = "";
                    $data['particular' . $i] = "";
                    $data['client_info' . $i] = "";
                    $data['amount' . $i] = "";
                }
                $data['count_it'] = $count_ex;
            }

            $this->load->view('admin/show_ledger_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_sales_statement() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $client_id = $this->input->post('client_id');
            $product_category = $this->input->post('product_category');
            $parts_no = $this->input->post('parts_no');
            $product_name = $this->input->post('product_name');
            $invoice = $this->input->post('invoice');
            $user = $this->input->post('user');

            $checking_array = array();

            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }
            if (!empty($product_name)) {
                $checking_array['product_name'] = $product_name;
            }
            if (!empty($parts_no)) {
                $checking_array['parts_no'] = $parts_no;
            }
            if (!empty($invoice)) {
                $checking_array['invoice_no'] = $invoice;
            }
            if (!empty($user)) {
                $checking_array['sold_by'] = $user;
            }
            if (!empty($client_id)) {
                $checking_array['client_id'] = $client_id;
            }
            if (!empty($product_category)) {
                $checking_array['product_type'] = $product_category;
            }

            $result = $this->Common_model->get_distinct_value_where('invoice_no', "sell_product", $checking_array);
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $checking_array['invoice_no'] = $info->invoice_no;
                $data['pro_result' . $count] = $this->Common_model->get_all_info_by_array("sell_product", $checking_array);
            }
            $data['count_it'] = $count;
            $this->load->view('admin/sales_statement_show_all', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_sales_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $brand_name = $this->input->post('brand_name');

            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['P.date>='] = $date_from;
                $checking_array['P.date<='] = $date_to;
                $checking_array['S.date>='] = $date_from;
                $checking_array['S.date<='] = $date_to;
            }
            if (!empty($brand_name)) {
                $checking_array['P.brand'] = $brand_name;
            }

            $data["result"] = $this->Common_model->sales_report($checking_array);
            //print_r($data);
            $this->load->view('admin/sales_report_show_all', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_officer_list() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $department = $this->input->post('department');
            $data['all_employee'] = $this->Common_model->get_allinfo_byid('employee', 'department', $department);
            $this->load->view('admin/show_officer_list', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function return_product() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $invoice = $this->input->post('invoice_no');
            $date = date('Y-m-d');

            //Getting data by specific record id
            $result = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $invoice);
            foreach ($result as $info) {
//                $product_id = $info->product_id;
                $product_type = $info->product_type;
//                $sub_category = $info->sub_category;
//                $brand_name = $info->brand_name;
                $product_name = $info->product_name;
//                $product_model = $info->product_model;
                $sell_qty = $info->product_qty;
                //keeping return record as return list
                $returned_qty = $sell_qty;
                $insert_data = array(
                    'date' => $date,
                    'invoice_no' => $invoice,
//                    'product_id' => $product_id,
                    'product_type' => $product_type,
//                    'sub_category' => $sub_category,
//                    'brand_name' => $brand_name,
                    'product_name' => $product_name,
//                    'product_model' => $product_model,
//                    'manufacture_company' => $manufacture_company,
                    'returned_qty' => $returned_qty
                );
                $this->Common_model->insert_data('returned_product_info', $insert_data);
            }
            //deleting voucher info from sell_product & sales_due
            $this->Common_model->delete_info('invoice_no', $invoice, 'sell_product');
            $this->Common_model->delete_info('invoice_no', $invoice, 'common_bill');
            $this->Common_model->delete_info('invoice_id', $invoice, 'print_field');
            $this->Common_model->delete_info('invoice_no', $invoice, 'sales_due');
            $auditors_data=array(
                "name"=>"Invoice No: ".$invoice,
                "user_name"=>$this->session->ses_username,
                "type"=>"Cancel Invoice",
                "created_at"=>date("Y-m-d H:i:s")
            );
            $this->Common_model->insert_data("auditors",$auditors_data);

            $data['return_product'] = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $invoice);
            $this->load->view('admin/sold_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function challan_return_product() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $invoice = $this->input->post('invoice_no');
            $date = date('Y-m-d');

            //Getting data by specific record id
            $result = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $invoice);
            foreach ($result as $info) {
                $product_type = $info->product_type;
                $product_name = $info->product_name;
                $sell_qty = $info->product_qty;
                //keeping return record as return list
                $returned_qty = $sell_qty;
                $insert_data = array(
                    'date' => $date,
                    'invoice_no' => $invoice,
                    'product_type' => $product_type,
                    'product_name' => $product_name,
                    'returned_qty' => $returned_qty
                );
                $this->Common_model->insert_data('returned_product_info', $insert_data);
            }
            //deleting voucher info from sell_product & sales_due
            $this->Common_model->delete_info('invoice_no', $invoice, 'sell_product');
            $this->Common_model->delete_info('invoice_no', $invoice, 'common_bill');
            $this->Common_model->delete_info('invoice_id', $invoice, 'print_field');
            $auditors_data=array(
                "name"=>"Invoice No: ".$invoice,
                "user_name"=>$this->session->ses_username,
                "type"=>"Cancel Invoice",
                "created_at"=>date("Y-m-d H:i:s")
            );
            $this->Common_model->insert_data("auditors",$auditors_data);

            $data['return_product'] = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $invoice);
            $this->load->view('admin/challan_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function update_product_full_row() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $record_id = $this->input->post('record_id');
            $product_qty = $this->input->post('product_qty');
//            $sub_total = $this->input->post('total_price');
            $date = date('Y-m-d');

            //Getting data by specific record id
            $result = $this->Common_model->get_allinfo_byid('sell_product', 'record_id', $record_id);
            foreach ($result as $info) {
                $invoice = $info->invoice_no;
//                $product_id = $info->product_id;
                $product_type = $info->product_type;
//                $sub_category = $info->sub_category;
//                $brand_name = $info->brand_name;
                $product_name = $info->product_name;
//                $product_model = $info->product_model;
//                $manufacture_company = $info->manufacture_company;
                $price_per_unit = $info->price_per_unit;
//                $first_total = $info->first_total;
                $ind_discount = $info->ind_discount;
                $sell_qty = $info->product_qty;
                $sell_price = $info->total;
                $total_price = $info->sub_total;
                $complete_total = $info->complete_total;
                $net_payable = $info->net_payable;
                $due = $info->due;
            }
            //Updating total quantity in insert_product_info
            //keeping return record as return list
            $returned_qty = $sell_qty - $product_qty;
            $insert_data = array(
                'date' => $date,
                'invoice_no' => $invoice,
                'product_type' => $product_type,
                'product_name' => $product_name,
                'returned_qty' => $returned_qty,
                'orginal_quantity' => $sell_qty
            );
            $this->Common_model->insert_data('returned_product_info', $insert_data);
            $reduction = $sell_price - (($product_qty * $price_per_unit) - (($product_qty * $price_per_unit * $ind_discount) / 100));
            $update_data = array(
                'product_qty' => $product_qty,
                'first_total' => $product_qty * $price_per_unit,
                'total' => ($product_qty * $price_per_unit) - (($product_qty * $price_per_unit * $ind_discount) / 100)
            );
            $this->Common_model->update_data_onerow('sell_product', $update_data, 'record_id', $record_id);

            $update_data = array(
                'sub_total' => $total_price - $reduction,
                'complete_total' => $complete_total - $reduction,
                'net_payable' => $net_payable - $reduction,
                'due' => $due - $reduction,
                "delivered_status"=>0,
            );
            $this->Common_model->update_data_onerow('sell_product', $update_data, 'invoice_no', $invoice);

            $result = $this->Common_model->get_allinfo_byid('sales_due', 'invoice_no', $invoice);
            foreach ($result as $info) {
                $old_due = $info->due;
                $old_total = $info->total;
            }
            $update_data = array(
                'total' => $old_total - $reduction,
                'due' => $old_due - $reduction
            );
            $this->Common_model->update_data_onerow('sales_due', $update_data, 'invoice_no', $invoice);

            $data['return_product'] = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $invoice);
            $auditors_data=array(
                "name"=>"Invoice: ".$invoice."<br/>Product Name: ".$product_name."<br/>Return Qty: ".$returned_qty,
                "user_name"=>$this->session->ses_username,
                "type"=>"Return Product",
                "created_at"=>date("Y-m-d H:i:s")
            );
            $this->Common_model->insert_data("auditors",$auditors_data);
            $this->load->view('admin/sold_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function challan_update_product_full_row() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $record_id = $this->input->post('record_id');
            $product_qty = $this->input->post('product_qty');
//            $sub_total = $this->input->post('total_price');
            $date = date('Y-m-d');

            //Getting data by specific record id
            $result = $this->Common_model->get_allinfo_byid('sell_product', 'record_id', $record_id);
            foreach ($result as $info) {
                $invoice = $info->invoice_no;
                $product_type = $info->product_type;
                $product_name = $info->product_name;
                $price_per_unit = $info->price_per_unit;
                $ind_discount = $info->ind_discount;
                $sell_qty = $info->product_qty;
                $sell_price = $info->total;
                $total_price = $info->sub_total;
                $complete_total = $info->complete_total;
                $due = $info->due;
            }
            //Updating total quantity in insert_product_info
            //keeping return record as return list
            $returned_qty = $sell_qty - $product_qty;
            $insert_data = array(
                'date' => $date,
                'invoice_no' => $invoice,
                'product_type' => $product_type,
                'product_name' => $product_name,
                'returned_qty' => $returned_qty,
                'orginal_quantity' => $sell_qty
            );
            $this->Common_model->insert_data('returned_product_info', $insert_data);
            $reduction = $sell_price - (($product_qty * $price_per_unit) - (($product_qty * $price_per_unit * $ind_discount) / 100));
            $update_data = array(
                'product_qty' => $product_qty,
                'first_total' => $product_qty * $price_per_unit,
                'total' => ($product_qty * $price_per_unit) - (($product_qty * $price_per_unit * $ind_discount) / 100)
            );
            $this->Common_model->update_data_onerow('sell_product', $update_data, 'record_id', $record_id);

            $update_data = array(
                'sub_total' => $total_price - $reduction,
                'complete_total' => $complete_total - $reduction,
                'due' => $due - $reduction,
                "delivered_status"=>0,
            );
            $this->Common_model->update_data_onerow('sell_product', $update_data, 'invoice_no', $invoice);


            $data['return_product'] = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $invoice);
            $auditors_data=array(
                "name"=>"Invoice: ".$invoice."<br/>Product Name: ".$product_name."<br/>Return Qty: ".$returned_qty,
                "user_name"=>$this->session->ses_username,
                "type"=>"Return Product",
                "created_at"=>date("Y-m-d H:i:s")
            );
            $this->Common_model->insert_data("auditors",$auditors_data);
            $this->load->view('admin/challan_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function return_product_full_row() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $record_id = $this->input->post('record_id');
            $date = date("Y-m-d");

            //Getting data by specific record id
            $result = $this->Common_model->get_allinfo_byid('sell_product', 'record_id', $record_id);
            foreach ($result as $info) {
                $invoice = $info->invoice_no;
//                $product_id = $info->product_id;
                $product_type = $info->product_type;
//                $sub_category = $info->sub_category;
//                $brand_name = $info->brand_name;
                $product_name = $info->product_name;
//                $product_model = $info->product_model;
//                $manufacture_company = $info->manufacture_company;
                $sell_qty = $info->product_qty;
                $sell_price = $info->total;
                $total_price = $info->sub_total;
                $complete_total = $info->complete_total;
                $net_payable = $info->net_payable;
                $due = $info->due;
            }

            //keeping return record as return list
            $returned_qty = $sell_qty;
            $insert_data = array(
                'date' => $date,
                'invoice_no' => $invoice,
                'product_type' => $product_type,
                'product_name' => $product_name,
                'returned_qty' => $returned_qty
            );
            $this->Common_model->insert_data('returned_product_info', $insert_data);

            $this->Common_model->delete_info('record_id', $record_id, 'sell_product');
            $remain_invoice=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice),"",1);
            if(!$remain_invoice)
            {
                // debug_p($remain_invoice);
                @$this->Common_model->delete_info('invoice_no', $invoice, 'common_bill');
                @$this->Common_model->delete_info('invoice_id', $invoice, 'print_field');
            }


            //Updating new total to sell_product
            $update_data = array(
                'sub_total' => $total_price - $sell_price,
                'complete_total' => $complete_total - $sell_price,
                'net_payable' => $net_payable - $sell_price,
                'due' => $due - $sell_price,
                'delivered_status' =>0
            );
            $this->Common_model->update_data_onerow('sell_product', $update_data, 'invoice_no', $invoice);

            //Updating new total to sales_due
            $result = $this->Common_model->get_allinfo_byid('sales_due', 'invoice_no', $invoice);
            foreach ($result as $info) {
                $old_due = $info->due;
                $old_total = $info->total;
            }
            $update_data = array(
                'total' => $old_total - $sell_price,
                'due' => $old_due - $sell_price
            );
            $this->Common_model->update_data_onerow('sales_due', $update_data, 'invoice_no', $invoice);
            $auditors_data=array(
                "name"=>"Invoice: ".$invoice."<br/>Product Name: ".$product_name."<br/>Return Qty: ".$returned_qty,
                "user_name"=>$this->session->ses_username,
                "type"=>"Return Product",
                "created_at"=>date("Y-m-d H:i:s")
            );
            $this->Common_model->insert_data("auditors",$auditors_data);
            $data['return_product'] = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $invoice);
            $this->load->view('admin/sold_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function challan_return_product_full_row() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $record_id = $this->input->post('record_id');
            $date = date("Y-m-d");

            //Getting data by specific record id
            $result = $this->Common_model->get_allinfo_byid('sell_product', 'record_id', $record_id);
            foreach ($result as $info) {
                $invoice = $info->invoice_no;
                $product_type = $info->product_type;
                $product_name = $info->product_name;
                $sell_qty = $info->product_qty;
                $sell_price = $info->total;
                $total_price = $info->sub_total;
                $complete_total = $info->complete_total;
                $due = $info->due;
            }

//            //Updating total quantity in insert_product_info
            //keeping return record as return list
            $returned_qty = $sell_qty;
            $insert_data = array(
                'date' => $date,
                'invoice_no' => $invoice,
                'product_type' => $product_type,
                'product_name' => $product_name,
                'returned_qty' => $returned_qty
            );
            $this->Common_model->insert_data('returned_product_info', $insert_data);

            $this->Common_model->delete_info('record_id', $record_id, 'sell_product');
            $remain_invoice=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice),"",1);
            if(!$remain_invoice)
            {
                // debug_p($remain_invoice);
                @$this->Common_model->delete_info('invoice_no', $invoice, 'common_bill');
                @$this->Common_model->delete_info('invoice_id', $invoice, 'print_field');
            }


            //Updating new total to sell_product
            $update_data = array(
                'sub_total' => $total_price - $sell_price,
                'complete_total' => $complete_total - $sell_price,
                'due' => $due - $sell_price,
                'delivered_status' =>0
            );
            $this->Common_model->update_data_onerow('sell_product', $update_data, 'invoice_no', $invoice);

            $auditors_data=array(
                "name"=>"Invoice: ".$invoice."<br/>Product Name: ".$product_name."<br/>Return Qty: ".$returned_qty,
                "user_name"=>$this->session->ses_username,
                "type"=>"Return Product",
                "created_at"=>date("Y-m-d H:i:s")
            );
            $this->Common_model->insert_data("auditors",$auditors_data);
            $data['return_product'] = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $invoice);
            $this->load->view('admin/challan_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sold_product_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $invoice = $this->input->post('invoice_no');
            $data['return_product'] = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $invoice);
            // debug_p($data['return_product']);
            $this->load->view('admin/sold_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function challan_product_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $invoice = $this->input->post('invoice_no');
            $data['return_product'] = $this->Common_model->get_allinfo_byid('sell_product', 'invoice_no', $invoice);
            // debug_p($data['return_product']);
            $this->load->view('admin/challan_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_success_msg2() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $all_sales = $this->input->post('all_sales');
            $reference = $this->input->post('reference');
            $ref_type="";
            if (strpos($reference, '_ST_') !== false || strpos($reference, 'ATL_') !== false) {
                $ref_type="";
            }elseif(strpos($reference, '_XCMG_') !== false){
                $ref_type="xcmg";
            }
            $invoice_no_re_sell = $this->input->post('invoice_no');
            $invoice_info=array();
            if($invoice_no_re_sell!='')
            {
                $invoice_info=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice_no_re_sell),"",1);
            }
            if (!empty($all_sales)) {
                if($invoice_no_re_sell=="")
                {
                    $max_id=$this->Common_model->get_max_id_ref_type("sell_product","reference_id",$ref_type);
                    $invoice_no = $reference . "_" . str_pad($max_id, 4, 0, STR_PAD_LEFT);
                    $reference_id = $max_id;
                    // $result = $this->Common_model->find_last_id('record_id', 'sell_product');
                    // if (!$result) {
                    //     $invoice_no = $reference . "_" . str_pad(1, 4, 0, STR_PAD_LEFT);
                    //     $reference_id = 1;
                    // } else {
                    //     foreach ($result as $row) {
                    //         $invoice_no = $reference . "_" . (str_pad(($row->reference_id + 1), 4, 0, STR_PAD_LEFT));
                    //         $reference_id = $row->reference_id + 1;
                    //     }
                    // }
                    $reference .= $invoice_no;
                    $client_name = $this->input->post('client_name');
                    $client_name_id = $this->input->post('client_name_id');
                    if ($client_name_id == "New") {
                        $insert_data = array(
                            'date' => date("Y-m-d"),
                            'name' => $client_name
                        );
                        $insert_id = $this->Common_model->insert_data_get_id('add_client', $insert_data);
                        $client_id = $insert_id;
                    } else {
                        $client_name_id = explode('#', $client_name_id);
                        $client_name = $client_name_id[0];
                        $client_id = $client_name_id[1];
                    }
                    $paid = $this->input->post('pay');
                    $due = $this->input->post('due');
                    $discount = $this->input->post('discount');
                    $complete_total = $this->input->post('complete_total');
                    $net_payable =$complete_total-$discount;
                    $invoice_total = $this->input->post('invoice_total');
                    $previous_due = $this->input->post('previous_due');
                    $payment_type = $this->input->post('payment_type');
                    $bank_name = $this->input->post('bank_name');
                    $account_no = $this->input->post('account_no');
                    $cheque_no = $this->input->post('cheque_no');
                    $user = $this->session->ses_full_name;
                }else{
                    $reference_id=$invoice_info['reference_id'];
                    $invoice_no=$invoice_no_re_sell;
                    $client_name=$invoice_info['client_name'];
                    $client_id=$invoice_info['client_id'];
                    $paid=$this->input->post('pay')+$invoice_info['paid'];
                    $due=$this->input->post('due')+$invoice_info['due'];
                    $discount=$this->input->post('discount')+$invoice_info['discount'];
                    $complete_total=$this->input->post('complete_total')+$invoice_info['complete_total'];
                    $net_payable =$complete_total-$discount;
                    $invoice_total=$this->input->post('invoice_total')+$invoice_info['sub_total'];
                    $previous_due=$this->input->post('previous_due')+$invoice_info['previous_due'];
                    $payment_type=$invoice_info['payment_type'];
                    $bank_name=$invoice_info['bank_name'];
                    $account_no=$invoice_info['account_no'];
                    $cheque_no=$invoice_info['cheque_no'];
                    $user=$invoice_info['sold_by'];
                    
                }
//195978 1810745781


//                $sub_total = 0;
//                foreach ($all_sales as $single_sale) {
//                    $sub_total += $single_sale[10];
//                }
                $brand="";
                $insert_data=array();
                foreach ($all_sales as $single_sale) {
                    $parts_name = $single_sale[0];
                    $parts_no = $single_sale[1];
                    $unit = $single_sale[2];
                    $sales_type = $single_sale[3];
                    $product_qty = $single_sale[4];
                    $selling_price = $single_sale[5];
                    $first_total = $single_sale[6];
                    $ind_discount = $single_sale[7];
                    $total = $single_sale[8];
                    $date = $single_sale[9];
                    $remarks = $single_sale[10];
                    $alt_parts_no = $single_sale[11];
                    if(isset($single_sale[12]))
                    {
                    	$brand = $single_sale[12];
                    }

                    $insert_data = array(
                        'date' => $date,
                        'invoice_no' => $invoice_no,
                        'ref_type' => $ref_type,
                        'reference_id' => $reference_id,
                        'product_name' => $parts_name,
                        'parts_no' => $parts_no,
                        'unit' => $unit,
                        'sales_type' => $sales_type,
                        'price_per_unit' => $selling_price,
                        'product_qty' => $product_qty,
                        'first_total' => $first_total,
                        'ind_discount' => $ind_discount,
                        'total' => $total,
                        'client_name' => $client_name,
                        'client_id' => $client_id,
                        'sub_total' => $invoice_total,
                        'discount' => $discount,
                        'previous_due' => $previous_due,
                        'complete_total' => $complete_total,
                        'net_payable' => $net_payable,
                        'paid' => $paid,
                        'due' => $due,
                        'payment_type' => $payment_type,
                        'bank_name' => $bank_name,
                        'account_no' => $account_no,
                        'cheque_no' => $cheque_no,
                        'sold_by' => $user,
                        'remarks' => $remarks,
                        'alt_parts_no' => $alt_parts_no,
                        'brand' => $brand
                    );
                    $this->Common_model->insert_data('sell_product', $insert_data);
                }
                 if($invoice_no_re_sell=='')
                 {
                     $insert_data = array(
                         'invoice_id' => $invoice_no,
                         'confirmed' => "no"
                     );
                     $this->Common_model->insert_data('print_field', $insert_data);
                 }
                

//                $update_data = array('delete_status' => 0);
//                $this->Common_model->update_data_all_column('sales_due', $update_data);

                if ($sales_type == "Bill" || $sales_type == "Service Bill" ||
                        $sales_type == "Wrong Parts Exchange Bill" || $sales_type == "LC") {
                    if (!empty($paid)) {
                        $payment_number = "First";
                    } else {
                        $payment_number = "N/A";
                    }
                    $sales_due_array=array(
                        'payment_number' => $payment_number,
                        'total' => $invoice_total,
                        'delete_status' => 0
                    );
                    $insert_data = array(
                        'date' => $date,
                        'invoice_no' => $invoice_no,
                        'client_name' => $client_name,
                        'client_id' => $client_id,
                        'discount' => $discount,
                        'payment_type' => $payment_type,
                        'bank_name' => $bank_name,
                        'account_no' => $account_no,
                        'cheque_no' => $cheque_no,
                        'paid' => $paid,
                        'due' => $due,
                    );
                    $sell_array=array(
                        "complete_total"=> $complete_total,
                        "net_payable"=> $net_payable,
                        'sub_total' => $invoice_total
                    );
                    $new_sales_due_array=array_merge($sales_due_array,$insert_data);
                    $new_sales_array=array_merge($sell_array,$insert_data);

                    if($invoice_no_re_sell!='')
                    {
                        $this->Common_model->update('sales_due', $new_sales_due_array,array("invoice_no"=>$invoice_no_re_sell));
                        $this->Common_model->update("sell_product",$new_sales_array,array("invoice_no"=>$invoice_no_re_sell));
                    }else{
                        $this->Common_model->insert_data('sales_due', $new_sales_due_array);

                        $this->Common_model->insert_data('all_invoice', array("invoice_no"=>$invoice_no));
                    }
                }

                if ($sales_type == "Bill" || $sales_type == "Service Bill" ||
                        $sales_type == "Wrong Parts Exchange Bill" || $sales_type == "LC") {
                    $print_type = "Invoice";
                } else {
                    $print_type = "Challan";
                }
                if($invoice_no_re_sell!='')
                {
                    $auditors_data=array(
                        "name"=>"Invoice No: ".$invoice_no."<br/>Qty:".count($all_sales),
                        "user_name"=>$this->session->ses_username,
                        "type"=>"Extra Qty Add",
                        "created_at"=>date("Y-m-d H:i:s")
                    );
                    $this->Common_model->insert_data("auditors",$auditors_data);
                }
                $this->print_show_invoice($invoice_no,$print_type);
            } else {
                echo "<p style='color: red; font-size: 20px; text-align: center;'>Please provide your product details</p>";
            } 
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function print_show_invoice($id,$print_type)
    {
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
        $data["print_field"] = "";
        foreach ($result as $info) {
            $data["reference"] = $info->reference;
            $data["address"] = $info->address;
            $data["project_name"] = $info->project_name;
            $data["indent_no"] = $info->indent_no;
            $data["mpr_no"] = $info->mpr_no;
            $data["currency"] = $info->currency;
            $data["extra_charge"] = $info->extra_charge;
            $data["extra_charge_type"] = $info->extra_charge_type;
            $data["print_field"] = $info->confirmed;
        }

        if ($print_type == "Challan") {
            $data["print_type"] = "Challan";
        } else if ($print_type == "Invoice" && ($sales_type == "Bill" || $sales_type == "Service Bill" ||
                $sales_type == "Wrong Parts Exchange Bill" || $sales_type == "LC")) {
            $data["print_type"] = "Invoice";
        } else {
            $data["print_type"] = "";
        }
        $this->load->view('admin/show_sales_invoice', $data);
    }
    public function serial_check() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $product_id = $this->input->post('product_id');
            $result = $this->Common_model->get_allinfo_byid('sell_product', 'product_id', $product_id);
            $all_serial = "";
            foreach ($result as $info) {
                $all_serial .= $info->serial . "###";
            }

            $temp_serial = $this->input->post('serial');
            $serial = preg_replace('/\s+/', '###', $temp_serial);
            $serial = explode('###', $serial);
            $sold_serial = array();
            foreach ($serial as $s) {
                if (preg_match('~\b' . $s . '\b~', $all_serial)) {
                    if ($s != 'N/A') {
                        array_push($sold_serial, $s);
                    }
                }
            }
            $data = array($sold_serial);
            echo json_encode($data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function selling_product_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $product_id = $this->input->post('record_id');
            $sales_type = $this->input->post('sales_type');
            $result = $this->Common_model->get_allinfo_byid('insert_product_info', 'record_id', $product_id);
            foreach ($result as $info) {
                $product_type = $info->product_type;
                $sub_category = $info->sub_category;
                $brand_name = $info->brand_name;
                $product_name = $info->product_name;
                $product_model = $info->product_model;
                $manufacture_company = $info->manufacture_company;
                if ($sales_type == 0) {
                    $selling_price = $info->retail_price;
                } else {
                    $selling_price = $info->wholesale_price;
                }
                $available_qty = $info->total_qty;
                $product_quantity = 1;
                $total_price = $product_quantity * $selling_price;
            }
            $result2 = $this->Common_model->get_allinfo_byid('purchase_product', 'product_id', $product_id);
            $all_serial = "";
            foreach ($result2 as $info) {
                $all_serial .= $info->serial . "###";
            }

            $result3 = $this->Common_model->get_allinfo_byid('sell_product', 'product_id', $product_id);
            foreach ($result3 as $info) {
                $sales_serial = explode('#', $info->serial);
                foreach ($sales_serial as $s) {
                    $sales_serial = $s . "###";
                    $all_serial = str_replace($sales_serial, '', $all_serial);
                }
            }

            $data = array($product_id, $product_type, $product_name, $product_model,
                $manufacture_company, $selling_price, $product_quantity,
                $total_price, $available_qty, $sub_category, $brand_name, $all_serial);
            echo json_encode($data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function client_details() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $client = explode('#', $this->input->post('client'));
            $client_id = $client[1];

            $result = $this->Common_model->get_allinfo_byid('add_client', 'record_id', $client_id);

            foreach ($result as $info) {
                $mobile = $info->mobile;
                $email = $info->email;
            }
            $data = array($mobile, $email);
            echo json_encode($data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function return_to_manufacture() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $invoice = $this->input->post('invoice_no');
            $date = date('Y-m-d');

            //Getting data by specific record id
            $result = $this->Common_model->get_allinfo_byid('purchase_product', 'po_no', $invoice);
            foreach ($result as $info) {
//                $product_id = $info->product_id;
                $product_type = $info->machine_category;
                $product_name = $info->parts_name;
                $manufacture_company = $info->supplier;
                $purchase_qty = $info->quantity;

                //Updating total quantity in insert_product_info
////                $checking_array = array(
////                    'record_id' => $product_id
////                );
////                $single_result = $this->Common_model->get_all_info_by_array('insert_product_info', $checking_array);
//                foreach ($single_result as $single_info) {
//                    $old_qty = $single_info->total_qty;
//                    $new_qty = $old_qty - $purchase_qty;
//                }
//                $update_data = array(
//                    'total_qty' => $new_qty
//                );
//                $this->Common_model->update_data_onerow_where_array('insert_product_info', $update_data, $checking_array);
                //keeping return record as return list
                $returned_qty = $purchase_qty;
                $insert_data = array(
                    'date' => $date,
                    'invoice_no' => $invoice,
                    'manufacture_company' => $manufacture_company,
//                    'product_id' => $product_id,
                    'product_name' => $product_name,
                    'product_type' => $product_type,
//                    'sub_category' => $sub_category,
//                    'brand_name' => $brand_name,
//                    'product_model' => $product_model,
                    'returned_qty' => $returned_qty
                );
                $this->Common_model->insert_data('returned_to_manufacturer', $insert_data);
            }

            //deleting voucher info from purchase_product & purchase_due
            $this->Common_model->delete_info('po_no', $invoice, 'purchase_product');
            $this->Common_model->delete_info('voucher_no', $invoice, 'purchase_due');

            $data['return_product'] = $this->Common_model->get_allinfo_byid('purchase_product', 'po_no', $invoice);
            $this->load->view('admin/purchased_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function return_to_manufacture_update_full_row() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $record_id = $this->input->post('record_id');
            $product_qty = $this->input->post('product_qty');
//            $sub_total = $this->input->post('total_price');
            $date = date('Y-m-d');

            //Getting data by specific record id
            $result = $this->Common_model->get_allinfo_byid('purchase_product', 'record_id', $record_id);
            foreach ($result as $info) {
                $invoice = $info->po_no;
//                $product_id = $info->product_id;
                $product_type = $info->machine_category;
//                $sub_category = $info->sub_category;
//                $brand_name = $info->brand_name;
                $product_name = $info->parts_name;
//                $product_model = $info->product_model;
                $after_discount_unit_price = $info->after_discount_unit_price;
                $manufacture_company = $info->supplier;
                $purchase_qty = $info->quantity;
                $purchase_price = $info->total_price;
                $total_without_extra = $info->total_without_extra;
                $total_with_extra = $info->total_with_extra;
                $net_payable = $info->net_payable;
                $due = $info->due;
            }

//            //Updating total quantity in insert_product_info
//            $checking_array = array(
//                'record_id' => $product_id
//            );
//            $result = $this->Common_model->get_all_info_by_array('insert_product_info', $checking_array);
//            foreach ($result as $info) {
//                $old_qty = $info->total_qty;
//                $new_qty = $old_qty - ($purchase_qty - $product_qty);
//            }
//            $update_data = array(
//                'total_qty' => $new_qty
//            );
//            $this->Common_model->update_data_onerow_where_array('insert_product_info', $update_data, $checking_array);
            //keeping return record as return list
            $returned_qty = $purchase_qty - $product_qty;
            $insert_data = array(
                'date' => $date,
                'invoice_no' => $invoice,
                'manufacture_company' => $manufacture_company,
//                'product_id' => $product_id,
                'product_name' => $product_name,
                'product_type' => $product_type,
//                'sub_category' => $sub_category,
//                'brand_name' => $brand_name,
//                'product_model' => $product_model,
                'returned_qty' => $returned_qty
            );
            $this->Common_model->insert_data('returned_to_manufacturer', $insert_data);

            $reduction = $purchase_price - ($product_qty * $after_discount_unit_price);
            $update_data = array(
                'quantity' => $product_qty,
                'total_without_extra' => $total_without_extra - $reduction,
                'total_price' => $purchase_price - $reduction,
                'total_with_extra' => $total_with_extra - $reduction,
                'net_payable' => $net_payable - $reduction,
                'due' => $due - $reduction
            );
            $this->Common_model->update_data_onerow('purchase_product', $update_data, 'po_no', $invoice);

            //Updating new total to sales_due
            $result = $this->Common_model->get_allinfo_byid('purchase_due', 'voucher_no', $invoice);
            foreach ($result as $info) {
                $old_due = $info->due;
                $old_total = $info->total;
            }
            $update_data = array(
                'total' => $old_total - $reduction,
                'due' => $old_due - $reduction
            );
            $this->Common_model->update_data_onerow('purchase_due', $update_data, 'voucher_no', $invoice);

//            //Updating new total to purchase_product
//            $new_total = $total_price - $purchase_price;
//            $update_data = array(
//                'total' => $new_total
//            );
//            $this->Common_model->update_data_onerow('purchase_product', $update_data, 'invoice_no', $invoice);
//
//            //Updating new total to purchase_due
//            $result = $this->Common_model->get_allinfo_byid('purchase_due', 'voucher_no', $invoice);
//            foreach ($result as $info) {
//                $old_due = $info->due;
//            }
//            $update_data = array(
//                'total' => $new_total,
//                'due' => $old_due - $purchase_price
//            );
//            $this->Common_model->update_data_onerow('purchase_due', $update_data, 'voucher_no', $invoice);

            $data['return_product'] = $this->Common_model->get_allinfo_byid('purchase_product', 'po_no', $invoice);
            $this->load->view('admin/purchased_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function return_to_manufacture_full_row() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $record_id = $this->input->post('record_id');
            $date = date('Y-m-d');

            //Getting data by specific record id
            $result = $this->Common_model->get_allinfo_byid('purchase_product', 'record_id', $record_id);
            foreach ($result as $info) {
                $invoice = $info->po_no;
//                $product_id = $info->product_id;
                $product_type = $info->machine_category;
//                $sub_category = $info->sub_category;
//                $brand_name = $info->brand_name;
                $product_name = $info->parts_name;
//                $product_model = $info->product_model;
                $manufacture_company = $info->supplier;
                $purchase_qty = $info->quantity;
                $purchase_price = $info->total_price;
                $total_without_extra = $info->total_without_extra;
                $total_with_extra = $info->total_with_extra;
                $net_payable = $info->net_payable;
                $due = $info->due;
            }

//            //Updating total quantity in insert_product_info
//            $checking_array = array(
//                'record_id' => $product_id
//            );
//            $result = $this->Common_model->get_all_info_by_array('insert_product_info', $checking_array);
//            foreach ($result as $info) {
//                $old_qty = $info->total_qty;
//                $new_qty = $old_qty - $purchase_qty;
//            }
//            $update_data = array(
//                'total_qty' => $new_qty
//            );
//            $this->Common_model->update_data_onerow_where_array('insert_product_info', $update_data, $checking_array);
            //keeping return record as return list
            $returned_qty = $purchase_qty;
            $insert_data = array(
                'date' => $date,
                'invoice_no' => $invoice,
                'manufacture_company' => $manufacture_company,
//                'product_id' => $product_id,
                'product_name' => $product_name,
                'product_type' => $product_type,
//                'sub_category' => $sub_category,
//                'brand_name' => $brand_name,
//                'product_model' => $product_model,
                'returned_qty' => $returned_qty
            );
            $this->Common_model->insert_data('returned_to_manufacturer', $insert_data);
            $this->Common_model->delete_info('record_id', $record_id, 'purchase_product');

            //Updating new total to sell_product
            $update_data = array(
                'total_without_extra' => $total_without_extra - $purchase_price,
                'total_with_extra' => $total_with_extra - $purchase_price,
                'net_payable' => $net_payable - $purchase_price,
                'due' => $due - $purchase_price
            );
            $this->Common_model->update_data_onerow('purchase_product', $update_data, 'po_no', $invoice);

            //Updating new total to sales_due
            $result = $this->Common_model->get_allinfo_byid('purchase_due', 'voucher_no', $invoice);
            foreach ($result as $info) {
                $old_due = $info->due;
                $old_total = $info->total;
            }
            $update_data = array(
                'total' => $old_total - $purchase_price,
                'due' => $old_due - $purchase_price
            );
            $this->Common_model->update_data_onerow('purchase_due', $update_data, 'voucher_no', $invoice);

//            //Updating new total to purchase_product
//            $new_total = $total_price - $purchase_price;
//            $update_data = array(
//                'total' => $new_total
//            );
//            $this->Common_model->update_data_onerow('purchase_product', $update_data, 'invoice_no', $invoice);
//
//            //Updating new total to purchase_due
//            $result = $this->Common_model->get_allinfo_byid('purchase_due', 'voucher_no', $invoice);
//            foreach ($result as $info) {
//                $old_due = $info->due;
//            }
//            $update_data = array(
//                'total' => $new_total,
//                'due' => $old_due - $purchase_price
//            );
//            $this->Common_model->update_data_onerow('purchase_due', $update_data, 'voucher_no', $invoice);

            $data['return_product'] = $this->Common_model->get_allinfo_byid('purchase_product', 'po_no', $invoice);
            $this->load->view('admin/purchased_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function purchased_product_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $invoice = $this->input->post('invoice_no');
            $data['return_product'] = $this->Common_model->get_allinfo_byid('purchase_product', 'po_no', $invoice);
            $this->load->view('admin/purchased_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_purchase_for_manufacture_return() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');

            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }

            $result = $this->Common_model->get_distinct_value_where('invoice_no', 'purchase_product', $checking_array);
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $checking_array['invoice_no'] = $info->invoice_no;
                $data['product_result' . $count] = $this->Common_model->get_all_info_by_array('purchase_product', $checking_array);
            }
            $data['count_it'] = $count;
            $data['category'] = "";
            $this->load->view('admin/get_purchase_for_manufacture_return', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function inout_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $trans_type = $this->input->post('trans_type');

            $checking_array = array();
            if ($trans_type == "in") {
                //Purchase
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                $result = $this->Common_model->get_distinct_value_where('po_no', 'purchase_product', $checking_array);
                $count = 0;
                foreach ($result as $info) {
                    $count++;
                    $checking_array['po_no'] = $info->po_no;
                    $data['product_result' . $count] = $this->Common_model->get_all_info_by_array('purchase_product', $checking_array);
                }
                $data['count_it'] = $count;
                $this->load->view('admin/product_in_report', $data);
            } elseif ($trans_type == "out") {
                //Sales
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                $result = $this->Common_model->get_distinct_value_where('invoice_no', "sell_product", $checking_array);
                $count = 0;
                foreach ($result as $info) {
                    $count++;
                    $checking_array['invoice_no'] = $info->invoice_no;
                    $data['product_result' . $count] = $this->Common_model->get_all_info_by_array("sell_product", $checking_array);
                }
                $data['count_it'] = $count;
                $this->load->view('admin/product_out_report', $data);
            } else {
                //Purchase
                $checking_array_p = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                    $checking_array_p['date>='] = $date_from;
                    $checking_array_p['date<='] = $date_to;
                }
                $result = $this->Common_model->get_distinct_value_where('po_no', 'purchase_product', $checking_array);
                $count = 0;
                foreach ($result as $info) {
                    $count++;
                    $checking_array['po_no'] = $info->po_no;
                    $data['product_result' . $count] = $this->Common_model->get_all_info_by_array('purchase_product', $checking_array);
                }
                $data['count_it'] = $count;

                //Sell
                $result2 = $this->Common_model->get_distinct_value_where('invoice_no', 'sell_product', $checking_array_p);
                $count2 = 0;
                foreach ($result2 as $info2) {
                    $count2++;
                    $checking_array_p['invoice_no'] = $info2->invoice_no;
                    $data['product_result2' . $count2] = $this->Common_model->get_all_info_by_array('sell_product', $checking_array_p);
                }
                $data['count_it2'] = $count2;
                $this->load->view('admin/product_inout_report', $data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_purchase_statement() {
        set_time_limit(300);
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $po_no = $this->input->post('po_no');
            $manufacturer = $this->input->post('manufacturer');
            $machine_category = $this->input->post('machine_category');
            $parts_no = $this->input->post('parts_no');
            $parts_name = $this->input->post('parts_name');
            $shipping_type = $this->input->post('shipping_type');
            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }
            if (!empty($po_no)) {
                $checking_array['po_no'] = $po_no;
            }
            if (!empty($manufacturer)) {
                $checking_array['supplier'] = $manufacturer;
            }
            if (!empty($machine_category)) {
                $checking_array['machine_category'] = $machine_category;
            }
            if (!empty($parts_no)) {
                $checking_array['parts_no'] = $parts_no;
            }
            if (!empty($parts_name)) {
                $checking_array['parts_name'] = $parts_name;
            }
            if (!empty($shipping_type)) {
                $checking_array['shipping_type'] = $shipping_type;
            }
            $result = $this->Common_model->get_distinct_value_where('po_no', "purchase_product", $checking_array);
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $checking_array['po_no'] = $info->po_no;
                $data['purchase_result' . $count] = $this->Common_model->get_all_info_by_array("purchase_product", $checking_array);
            }
            $data['count_it'] = $count;
            if (!empty($po_no))
                $data['po_no'] = true;
            $this->load->view('admin/purchase_statement_product', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_sold_product_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $serial = $this->input->post('serial_no');
            $data['serial'] = $serial;

            if (!empty($serial)) {
                $result = $this->Common_model->get_all_info("sell_product");
                foreach ($result as $res) {
                    $s = explode('#', $res->serial);
                    if (in_array($serial, $s)) {
                        $d = $res->record_id;
                        break;
                    }
                }
                $data['all_value'] = $this->Common_model->get_allinfo_byid("sell_product", 'record_id', $d);
            } else {
                $data['all_value'] = $this->Common_model->get_all_info("sell_product");
            }


            $this->load->view('admin/show_sold_product_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_sold_product_warranty() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $serial = $this->input->post('serial_no');
            $data['serial'] = $serial;
            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }

            if (!empty($serial)) {
                $result = $this->Common_model->get_all_info("warranty");
                foreach ($result as $res) {
                    $s = explode('#', $res->serial);
                    if (in_array($serial, $s)) {
                        $checking_array['record_id'] = $res->record_id;
                        break;
                    } else {
                        $checking_array['record_id'] = '';
                    }
                }
            }
//            print_r($checking_array);
            $data['all_value'] = $this->Common_model->get_all_info_by_array("warranty", $checking_array);
            $this->load->view('admin/show_sales_warranty', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_sold_product_warranty2() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $serial = $this->input->post('serial_no');
            $record_id = $this->input->post('record_id');
            $comment = $this->input->post('comment');
            $result = $this->Common_model->get_allinfo_byid("warranty", 'record_id', $record_id);
            foreach ($result as $res) {
                $c = $res->comment;
            }
            $c .= '###' . $comment;
            $update_data = array(
                'service_date' => date('Y-m-d'),
                'comment' => $c,
            );
            $this->Common_model->update_data_onerow('warranty', $update_data, 'record_id', $record_id);

            $data['serial'] = $serial;
            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }

            if (!empty($serial)) {
                $result = $this->Common_model->get_all_info("warranty");
                foreach ($result as $res) {
                    $s = explode('#', $res->serial);
                    if (in_array($serial, $s)) {
                        $checking_array['record_id'] = $res->record_id;
                        break;
                    } else {
                        $checking_array['record_id'] = '';
                    }
                }
            }
//            print_r($checking_array);
            $data['all_value'] = $this->Common_model->get_all_info_by_array("warranty", $checking_array);
            $this->load->view('admin/show_sales_warranty', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function confirm_machine_purchase() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date = date('Y-m-d');

            //$total_without_extra = $this->input->post('total_without_extra');
            $net_payable = $this->input->post('net_payable');
            $total_with_extra = $this->input->post('total_with_extra');
            $po_no = $this->input->post('po_no');
            $supplier = $this->input->post('supplier');
            $shipping_type = $this->input->post('shipping_type');
            $serial = $this->input->post('serial');
            $shiping_cost = (float) $this->input->post('shiping_cost');
            $custom_cost = (float) $this->input->post('custom_cost');
            $transport_cost = (float) $this->input->post('transport_cost');
            $misc_cost = (float) $this->input->post('misc_cost');
            $discount = (int) $this->input->post('discount');
            $discount_percentage = $discount / 100;
            // $all_extra = $shiping_cost + $custom_cost + $transport_cost + $misc_cost;
            //$all_extra = $all_extra - ($all_extra * $discount_percentage);
            $total_discount = $this->input->post('total_with_extra') * $discount_percentage;
            $total_without_extra = 0;
            $paid = $this->input->post('paid');
            $due = $this->input->post('due');
            $all_purchase = $this->Common_model->get_allinfo_byid('add_product', 'po_no', $po_no);
            foreach ($all_purchase as $single_purchase) {
                $machine_category = $single_purchase->machine_category;
                $section = $single_purchase->section;
                $machine_model = $single_purchase->machine_model;
                $chassis = $single_purchase->chassis;
                $brand = $single_purchase->brand;
                $parts_name = $single_purchase->parts_name;
                $parts_no = $single_purchase->parts_no;
                $alternative_parts_no = $single_purchase->alternative_parts_no;
                $chinese_name = $single_purchase->chinese_name;
                $unit = $single_purchase->unit;
                $unit_price = $single_purchase->unit_price;
                $payment_type = $single_purchase->payment_type;
                $quantity = $single_purchase->quantity;
                //$total_price = $single_purchase[13];
                $reminder_level = $single_purchase->reminder_level;
                $description = $single_purchase->description;
                $shelf_details = $single_purchase->shelf_details;
                $selling_price = $single_purchase->selling_price;

                $after_discount_unit_price = $unit_price - ($unit_price * $discount_percentage);
                $total_price = $quantity * $after_discount_unit_price;
                $total_without_extra += $total_price;

                $insert_data = array(
                    'date' => $date,
                    'machine_category' => $machine_category,
                    'section' => $section,
                    'machine_model' => $machine_model,
                    'chassis' => $chassis,
                    'brand' => $brand,
                    'parts_name' => $parts_name,
                    'parts_no' => $parts_no,
                    'alternative_parts_no' => $alternative_parts_no,
                    'chinese_name' => $chinese_name,
                    'unit' => $unit,
                    'unit_price' => $unit_price,
                    'discount' => $discount,
                    'after_discount_unit_price' => $after_discount_unit_price,
                    'payment_type' => $payment_type,
                    'quantity' => $quantity,
                    'total_price' => $total_price,
                    'reminder_level' => $reminder_level,
                    'description' => $description,
                    'shelf_details' => $shelf_details,
                    'selling_price' => $selling_price,
                    'supplier' => $supplier,
                    'po_no' => $po_no,
                    'shipping_type' => $shipping_type,
                    'serial' => $serial,
                    'shiping_cost' => $shiping_cost,
                    'custom_cost' => $custom_cost,
                    'transport_cost' => $transport_cost,
                    'misc_cost' => $misc_cost,
                    'paid' => $paid,
                    'due' => $due
                );
                $this->Common_model->insert_data('purchase_product', $insert_data);
            }

            $update_data = array(
                'total_discount' => $total_discount,
                'total_without_extra' => $total_without_extra,
                'total_with_extra' => $total_with_extra,
                'net_payable' => $net_payable
            );
            $this->Common_model->update_data_onerow('purchase_product', $update_data, 'po_no', $po_no);

            $insert_data = array(
                'date' => $date,
                'voucher_no' => $po_no,
                'manufacturer' => $supplier,
                'total' => $total_without_extra,
                'paid' => $paid,
                'due' => $due,
                'delete_status' => 0
            );
            $this->Common_model->insert_data('purchase_due', $insert_data);
            $this->Common_model->delete_info('po_no', $po_no, 'add_product');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function confirm_machine_add() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $all_purchase = $this->input->post('all_purchase');
            $date = date('Y-m-d');
            foreach ($all_purchase as $single_purchase) {
                $po_no = str_replace(" ", "_", trim($single_purchase[0], " "));
                $machine_category = $single_purchase[1];
                $section = $single_purchase[2];
                $machine_model = $single_purchase[3];
                $chassis = $single_purchase[4];
                $brand = $single_purchase[5];
                $parts_name = $single_purchase[6];
                $parts_no = $single_purchase[7];
                $alternative_parts_no = $single_purchase[8];
                $chinese_name = $single_purchase[9];
                $unit = $single_purchase[10];
                $unit_price = $single_purchase[11];
                $payment_type = $single_purchase[12];
                $quantity = $single_purchase[13];
                $total_price = $single_purchase[14];
                $reminder_level = $single_purchase[15];
                $description = $single_purchase[16];
                $shelf_details = $single_purchase[17];
                $selling_price = $single_purchase[18];

                $insert_data = array(
                    'date' => $date,
                    'po_no' => $po_no,
                    'machine_category' => $machine_category,
                    'section' => $section,
                    'machine_model' => $machine_model,
                    'chassis' => $chassis,
                    'brand' => $brand,
                    'parts_name' => $parts_name,
                    'parts_no' => $parts_no,
                    'alternative_parts_no' => $alternative_parts_no,
                    'chinese_name' => $chinese_name,
                    'unit' => $unit,
                    'unit_price' => $unit_price,
                    'payment_type' => $payment_type,
                    'quantity' => $quantity,
                    'total_price' => $total_price,
                    'reminder_level' => $reminder_level,
                    'description' => $description,
                    'shelf_details' => $shelf_details,
                    'selling_price' => $selling_price
                );
                $this->Common_model->insert_data('add_product', $insert_data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function confirm_purchase_order() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $all_purchase = $this->input->post('all_purchase');
            $date = date('Y-m-d');

            $total_without_extra = $this->input->post('total_without_extra');
            $po_no = $this->input->post('po_no');
            $supplier = $this->input->post('supplier');
            $shipping_type = $this->input->post('shipping_type');
            $serial = $this->input->post('serial');
            $shiping_cost = $this->input->post('shiping_cost');
            $custom_cost = $this->input->post('custom_cost');
            $transport_cost = $this->input->post('transport_cost');
            $misc_cost = $this->input->post('misc_cost');
            $total_with_extra = $this->input->post('total_with_extra');
            $discount = $this->input->post('discount');
            $net_payable = $this->input->post('net_payable');
            $paid = $this->input->post('paid');
            $due = $this->input->post('due');
            foreach ($all_purchase as $single_purchase) {
                $machine_category = $single_purchase[0];
                $section = $single_purchase[1];
                $machine_model = $single_purchase[2];
                $chassis = $single_purchase[3];
                $brand = $single_purchase[4];
                $parts_name = $single_purchase[5];
                $parts_no = $single_purchase[6];
                $alternative_parts_no = $single_purchase[7];
                $chinese_name = $single_purchase[8];
                $unit = $single_purchase[9];
                $unit_price = $single_purchase[10];
                $payment_type = $single_purchase[11];
                $quantity = $single_purchase[12];
                $total_price = $single_purchase[13];
                $reminder_level = $single_purchase[14];
                $description = $single_purchase[15];
                $shelf_details = $single_purchase[16];
                $selling_price = $single_purchase[17];
                $product_model_status = $single_purchase[18];
                $chassis_status = $single_purchase[19];
                $product_name_status = $single_purchase[20];
                $parts_no_status = $single_purchase[21];
                $alternative_parts_no_status = $single_purchase[22];
                $chinese_name_status = $single_purchase[23];

                if ($product_name_status == 1) {
                    $insert_data = array(
                        'product_name' => $parts_name
                    );
                    $this->Common_model->insert_data('create_product_name', $insert_data);
                }

                $insert_data = array(
                    'date' => $date,
                    'machine_category' => $machine_category,
                    'section' => $section,
                    'machine_model' => $machine_model,
                    'chassis' => $chassis,
                    'brand' => $brand,
                    'parts_name' => $parts_name,
                    'parts_no' => $parts_no,
                    'alternative_parts_no' => $alternative_parts_no,
                    'chinese_name' => $chinese_name,
                    'unit' => $unit,
                    'unit_price' => $unit_price,
                    'payment_type' => $payment_type,
                    'quantity' => $quantity,
                    'total_price' => $total_price,
                    'reminder_level' => $reminder_level,
                    'description' => $description,
                    'shelf_details' => $shelf_details,
                    'selling_price' => $selling_price,
                    'supplier' => $supplier,
                    'po_no' => $po_no,
                    'total_without_extra' => $total_without_extra,
                    'shipping_type' => $shipping_type,
                    'serial' => $serial,
                    'shiping_cost' => $shiping_cost,
                    'custom_cost' => $custom_cost,
                    'transport_cost' => $transport_cost,
                    'misc_cost' => $misc_cost,
                    'total_with_extra' => $total_with_extra,
                    'discount' => $discount,
                    'net_payable' => $net_payable,
                    'paid' => $paid,
                    'due' => $due
                );
                $this->Common_model->insert_data('purchase_order', $insert_data);
            }

//            $insert_data = array(
//                'date' => $date,
//                'voucher_no' => $voucher,
//                'manufacturer' => $vendor,
//                'total' => $complete_total,
//                'paid' => $paid,
//                'due' => $due,
//                'delete_status' => 1
//            );
//            $this->Common_model->insert_data('purchase_due', $insert_data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function product_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $product_id = $this->input->post('product_id');
            $result = $this->Common_model->get_allinfo_byid('insert_product_info', 'record_id', $product_id);
            foreach ($result as $info) {
                $product_type = $info->product_type;
                $product_id = $info->record_id;
                $product_name = $info->product_name;
                $product_model = $info->product_model;
                $manufacture_company = $info->manufacture_company;
                $sub_category = $info->sub_category;
                $brand_name = $info->brand_name;
            }

            $result = $this->Common_model->get_allinfo_byid('purchase_product', 'product_id', $product_id);
            $total_price = 0;
            $total_qty = 0;
            foreach ($result as $info) {
                $total_price += $info->sub_total;
                $total_qty += $info->product_qty;
            }
            $data = array($product_type, $product_name, $product_model,
                $manufacture_company, $sub_category, $brand_name, $total_price, $total_qty, $product_id);
            echo json_encode($data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function department_designation() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $employee = explode('#', $this->input->post('employee'));
            $employee_id = $employee[1];

            $result = $this->Common_model->get_allinfo_byid('employee', 'record_id', $employee_id);

            foreach ($result as $info) {
                $department = $info->department;
                $designation = $info->designation;
            }
            $data = array($department, $designation);
            echo json_encode($data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_project_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $id = $this->input->post('project_id');

            $result = $this->Common_model->get_allinfo_byid('payment_processing', 'record_id', $id);

            foreach ($result as $info) {
                $area = $info->land_area;
                $land_amount = $info->land_amount;
                $land_price = $info->total_amount;
                $interest_rate = $info->interest_rate;
                $num_months = $info->num_months;
                $installment_amount = $info->installment_amount;
            }
            $data = array($area, $land_amount, $land_price, $interest_rate, $num_months, $installment_amount);
            echo json_encode($data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_payment_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $id = $this->input->post('payment_id');

            $result = $this->Common_model->get_allinfo_byid('down_payment', 'record_id', $id);

            $data['all_down'] = $result;
            $this->load->view('admin/show_payment_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function pay_installment() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date = $this->input->post('date');
            $payment_id = $this->input->post('payment_id');
            $rest_month = $this->input->post('rest_month');
            $paid_amount = $this->input->post('paid_amount');
            $num_months = $this->input->post('num_months');
            $pay_method = $this->input->post('pay_method');
            $bank_name = $this->input->post('bank_name');
            $branch_name = $this->input->post('branch_name');
            $ac_no = $this->input->post('ac_no');
            $cheque_no = $this->input->post('cheque_no');

            $insert_data = array(
                'date' => $date,
                'payment_id' => $payment_id,
                'num_months' => $num_months,
                'paid_amount' => $paid_amount,
                'pay_method' => $pay_method,
                'bank_name' => $bank_name,
                'branch_name' => $branch_name,
                'ac_no' => $ac_no,
                'cheque_no' => $cheque_no,
            );
            $this->Common_model->insert_data('installment_payment', $insert_data);


            $result = $this->Common_model->get_allinfo_byid('down_payment', 'record_id', $payment_id);
            foreach ($result as $res) {
                $rest_month_old = $res->rest_months;
                $rest_amount_old = $res->rest_amount;
            }
            $rest_month_new = $rest_month_old - $num_months;
            $rest_amount_new = $rest_amount_old - $paid_amount;

            $update_data = array(
                'rest_months' => $rest_month_new,
                'rest_amount' => $rest_amount_new,
            );
            $this->Common_model->update_data_onerow('down_payment', $update_data, 'record_id', $payment_id);

            $result = $this->Common_model->get_allinfo_byid('down_payment', 'record_id', $payment_id);
            $data['all_down'] = $result;
            $this->load->view('admin/show_payment_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_employee_for_attendance() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $department = $this->input->post('department');
            $data['department'] = $department;
            $session = date("Y");
            $data['session'] = $session;
            $data['date'] = $this->input->post('date');
            $data['intime'] = $this->input->post('intime');
            $this->load->model('Common_model');
            $table_name = "employee";

            $result = $this->Common_model->get_all_info($table_name);
            $data['all_value'] = $result;
//            print_r($result);
            $this->load->view('admin/employee_info_for_attendance', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_employee_attendance_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $report = $this->input->post('report');
            $data['e_type'] = $report;
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
//            echo $report.$date_from.$date_to;
            $table_name = "employee_attendance";
            $checking_array = array(
                'department' => $report
            );
            $data['date_range'] = date('d F, Y', strtotime($date_from)) . " - " . date('d F, Y', strtotime($date_to));

            $result = $this->Common_model->data_date_to_date($table_name, 'date', $date_from, $date_to);

            $data['all_value'] = $result;
            $this->load->view('admin/attendance_report_info', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function send_sms_employee() {
        $sms_body = $this->input->post('sms_body');

        $result = $this->Common_model->get_all_info('employee');

        if (!empty($result)) {
            foreach ($result as $res) {
                $return_code = $this->send_sms("+88" . $res->mobile, $sms_body);
            }
            echo "<p style='color: green; font-size: 20px; padding: 10px;'>Message Sent Successfully</p>";
        } else {
            echo "<p style='color: red; font-size: 20px; padding: 10px;'>No user found</p>";
        }
    }

    public function send_sms($mobile, $sms_body) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://107.20.199.106/restapi/sms/1/text/single",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{ "
            . "\"from\":\"+8804445650406\", "
            . "\"to\":\"" . $mobile . "\", "
            . "\"text\":\"" . $sms_body . "\" }",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: Basic bGVvcGFyZDU4OmFiYzI3MTEzMTg5MA==",
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            //echo "cURL Error #:" . $err;
            return -1;
        } else {
            //echo $response;
            $result = json_decode($response, true);
            return $result['messages'][0]['status']['groupId'];
        }
    }

    public function get_sms_by_title() {
        $title = $this->input->post('title');
        $this->load->model('Common_model');
        $message = $this->Common_model->one_column_one_info('body', 'title', $title, 'create_sms');
        foreach ($message as $m) {
            $msg = $m->body;
        }
        echo $msg;
    }

    //    average price search

    public function search_average_price() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $search_p_no = $this->input->post('search_p_no');
            $search_p_name = $this->input->post('search_p_name');

            $data['result'] = $this->Common_model->get_distinct_average_price("purchase_product", $search_p_no, $search_p_name);

            $this->load->view('admin/search_average_price', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
//quantity by brand search
    public function search_brand_quantity() {
        set_time_limit(300);
        $search_brand_name = $this->input->get('search_brand_name');
        $search_type = $this->input->get('search_type');
        $result = $this->Common_model->get_product_quantity_by_brand($search_brand_name,$search_type);
        // debug_p($result);
        $total_add_quantity=0;
        $total_sell_quantity=0;
        $total_present_quantity=0;
        if(!empty($result))
        {
            foreach($result as $value){
                $total_add_quantity+=$value['add_total_quantity'];
                $total_sell_quantity+=$value['total_sell_quantity'];
                $total_present_quantity+=$value['present_qty'];
            }
        }
        $data['all_value']=$result;
        $data['total_add_quantity']=$total_add_quantity;
        $data['total_sell_quantity']=$total_sell_quantity;
        $data['total_present_quantity']=$total_present_quantity;
        if($search_type==1){
            $data['count_by']="Parts Name";
        }else{
            $data['count_by']="Part No";
        }
        $this->load->view('admin/search_brand_name', $data);
        
    }

//    profit/loss
    public function get_product_profit_loss() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $product_name = $this->input->post('product_name');
            $part = $this->input->post('part');
            $brand = $this->input->post('brand');
            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }
            if (!empty($product_name)) {
                $checking_array['product_name'] = $product_name;
            }
            if (!empty($part)) {
                $checking_array['parts_no'] = $part;
            }
            if (!empty($brand)) {
                $checking_array['brand'] = $brand;
            }

            $result = $this->Common_model->multil_column_group_by_where("sell_product", $checking_array,
                    array("brand", "product_name", "parts_no"));
//            echo "<pre>";
//            print_r($result);
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $get_brand = $info->brand;
                $get_product_name = $info->product_name;
                $get_parts_no = $info->parts_no;
                if($get_brand!='')
                {
                    $purchase_arr['brand']=$get_brand;
                }
                 if($get_product_name!='')
                {
                    $purchase_arr['parts_name']=$get_product_name;
                }
                 if($get_parts_no!='')
                {
                    $purchase_arr['parts_no']=$get_parts_no;
                }
                
                // $purchase_value_array = array("brand" => $get_brand, "parts_name" => $get_product_name, "parts_no" => $get_parts_no);
                $result_purchase = $this->Common_model->get_all_info_by_array('purchase_product', $purchase_arr);
                $purchase_qty = 0;
                $purchase_price = 0;
                foreach ($result_purchase as $info_all) {
                    $purchase_price += $info_all->total_price;
                    $purchase_qty += $info_all->quantity;
                }
                if ($purchase_qty == 0) {
                    $purchase_unit_price = 0;
                } else {
                    $purchase_unit_price = round($purchase_price / $purchase_qty, 2);
                }
    // debug_p($result_purchase);
                $sell_value_array = array("brand" => $get_brand, "product_name" => $get_product_name, "parts_no" => $get_parts_no);
                $result_sell = $this->Common_model->get_all_info_by_array('sell_product', $sell_value_array);
                $sell_qty = 0;
                $sell_price = 0;
                foreach ($result_sell as $info_all) {
                    if($info_all->sub_total==0)
                    {
                        $sell_price +=$info_all->total;
                    }else{
                        $sell_price += ($info_all->total - (($info_all->total * $info_all->discount) / $info_all->sub_total));
                    }
                    $sell_qty += $info_all->product_qty;
                }
                if ($sell_qty == 0) {
                    $sell_unit_price = 0;
                } else {
                    $sell_unit_price = round($sell_price / $sell_qty, 2);
                }

                $data['ref_no'. $count] = $info_all->invoice_no;
                $data["brand" . $count] = $get_brand;
                $data["product_name" . $count] = $get_product_name;
                $data["parts_no" . $count] = $get_parts_no;
                $data["purchase_total" . $count] = $purchase_price;
                $data["purchase_qty" . $count] = $purchase_qty;
                $data["purchase_average_price" . $count] = $purchase_unit_price;
                $data["sell_total" . $count] = $sell_price;
                $data["sell_qty" . $count] = $sell_qty;
                $data["sell_average_price" . $count] = $sell_unit_price;
                $data["profit_loss" . $count] = $sell_qty * ($sell_unit_price - $purchase_unit_price);
            }
            $data["count_it"] = $count;
        }
        $this->load->view('admin/show_product_profit_loss_info', $data);
    }

}
