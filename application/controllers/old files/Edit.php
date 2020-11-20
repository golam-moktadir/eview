<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Edit extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
    }
    public function edit_user($id=null)
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            if($_POST)
            {
                $name = $this->input->post('name');
                $mobile = $this->input->post('mobile');
                $email = $this->input->post('email');
                $address = $this->input->post('address');
                $username = $this->input->post('username');
                $password = $this->input->post('password');
    
                $permission = "";
    
                $create_options = $this->input->post('create_options');
                $information_entry = $this->input->post('information_entry');
                $report = $this->input->post('report');
    
                if (empty($name) && empty($mobile) && empty($address) && empty($username) && empty($password) && empty($create_options) && empty($information_entry) &&
                        empty($report)) {
                    redirect('Show_form/create_user/empty2', 'refresh');
                } else {
                    $result = $this->Common_model->duplicate_check("user",array("username"=>$username),$id);
                    if (!$result) {
                        if (!empty($create_options)) {
                            foreach ($create_options as $permission_info) {
                                $permission .= $permission_info . "#";
                            }
                        }
    
                        if (!empty($information_entry)) {
                            foreach ($information_entry as $permission_info) {
                                $permission .= $permission_info . "#";
                            }
                        }
    
                        if (!empty($report)) {
                            foreach ($report as $permission_info) {
                                $permission .= $permission_info . "#";
                            }
                        }
    
    
                        $insert_data['name']=$name;
                        $insert_data['mobile']=$mobile;
                        $insert_data['email']=$email;
                        $insert_data['address']=$address;
                        $insert_data['username']=$username;
                        if($password!='')
                        {
                            $insert_data['password']=$password;
                        }
                        $insert_data['permission']=$permission;
                        $this->Common_model->update_data_onerow('user',$insert_data,"record_id",$id);
                        $this->session->set_flashdata("msg",'<div class="text-success text-center">Updated Successfully</div>');
                        redirect('Edit/edit_user/'.$id);
                    } else {
                        $this->session->set_flashdata("msg",'<div class="text-danger text-center">User Name Already Exits!</div>');
                        redirect('Edit/edit_user/'.$id);
                    }
                }
            }
            else{
                $data['all_user'] = $this->Common_model->get_all_info('user');
                $data['single']=$this->Common_model->get_single("user",array("record_id"=>$id),"",1);
                $data['all_employee'] = $this->Common_model->get_all_info('employee');
                $this->load->view('admin/header');
                $this->load->view('admin/edit_user', $data);
                $this->load->view('admin/footer');
            }
           
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function add_product($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $po_no = $this->input->post('po_no');
            $machine_category = $this->input->post('product_type');
            $section = $this->input->post('section');
            $machine_model = $this->input->post('product_model');
            $chassis = $this->input->post('chassis');
            $brand = $this->input->post('brand');
            $parts_name = $this->input->post('product_name');
            $parts_no = $this->input->post('parts_no');
            $alternative_parts_no = $this->input->post('alternative_parts_no');
            $chinese_name = $this->input->post('chinese_name');
            $unit = $this->input->post('unit');
            $unit_price = $this->input->post('unit_price');
            $payment_type = $this->input->post('payment_type');
            $quantity = $this->input->post('quantity');
            $total_price = $this->input->post('total_price');
            $reminder_level = $this->input->post('reminder_level');
            $description = $this->input->post('description');
            $shelf_details = $this->input->post('shelf_details');
            $selling_price = $this->input->post('selling_price');

            $update_data = array(
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
            $this->Common_model->update_data_onerow('add_product', $update_data, 'record_id', $id);
            redirect("Show_form/add_product/edit", 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function service_bill_print_info($id)
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['address'] = $this->input->post('address');
            $data['project_name'] = $this->input->post('project_name');
            $data['model'] = $this->input->post('model');
            $data['currency'] = $this->input->post('currency');
            $data['customer_name'] = $this->input->post('customer_name');
            $this->Common_model->update_data_onerow("service_bill",$data,"record_id",$id);
            $this->session->set_flashdata("msg",'<div class="text-success text-center">Successfully</div>');
            redirect("show_form/service_invoice/".$id);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function service_bill($id)
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            if($_POST)
            {
                $work_details=$this->input->post("work_details");
                $data['machine_qty']=$this->input->post("machine_qty");
                $data['man_power']=$this->input->post("man_power");
                $data['day']=$this->input->post("day");
                $data['unit_price']=$this->input->post("unit_price");
                $data['total_price']=$this->input->post("total_price");
                $data['discount']=$this->input->post("discount");
                $data['net_payable']=$this->input->post("net_payable");
                $data['invoice_no']=$this->input->post("invoice_no");
                $prefix="EMSL/XCMG/".date("Y")."/";
                // $data['invoice_no']=$this->Common_model->get_custom_service_invoice("service_bill","record_id",1,$prefix);
                // debug_p($data);
                $exits=$this->Common_model->duplicate_check("service_bill",array("invoice_no"=>$data['invoice_no']),$id);
                if(!$exits)
                {
                    $bill_id=$this->Common_model->update_data_onerow("service_bill",$data,"record_id",$id);
                    $details=array();
                    foreach($work_details as $key=>$value)
                    {
                        $details[$key]['service_bill_id']=$id;
                        $details[$key]['details']=$value;
                    }
                    $this->Common_model->delete_info("service_bill_id",$id,"service_bill_details");
                    $this->Common_model->insert_batch("service_bill_details",$details);
                    $this->session->set_flashdata("msg",'<div class="text-success text-center">Successfully</div>');
                    redirect("show_form/service_bill");
                }else{
                    $this->session->set_flashdata("msg",'<div class="text-danger text-center">Invoice Already Exits!</div>');
                    redirect("show_edit_form/service_bill/".$id);
                }
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function print_field_challan($invoice_id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $reference_challan = $this->input->post('reference_challan');
            $address_challan = $this->input->post('address_challan');
            $project_name_challan = $this->input->post('project_name_challan');
            $po_no_challan = $this->input->post('po_no_challan');
            $mpr_challan = $this->input->post('mpr_challan');

            $update_data = array(
                'reference' => $reference_challan,
                'address' => $address_challan,
                'project_name' => $project_name_challan,
                'indent_no' => $po_no_challan,
                'mpr_no' => $mpr_challan,
                'confirmed' => "yes"
            );
            $this->Common_model->update_data_onerow('print_field', $update_data, 'invoice_id', $invoice_id);
            redirect("Show_edit_form/print_sales_invoice/$invoice_id/challan_btn", 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function print_field_invoice($invoice_id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $reference_invoice = $this->input->post('reference_invoice');
            $address_invoice = $this->input->post('address_invoice');
            $project_name_invoice = $this->input->post('project_name_invoice');
            $po_no_invoice = $this->input->post('po_no_invoice');
            $mpr_invoice = $this->input->post('mpr_invoice');
            $currency = $this->input->post('currency');
            $customer_name = $this->input->post('customer_name');
            $sales_type = $this->input->post('sales_type');
            $extra_charge_type = $this->input->post('extra_charge_type');
            $extra_charge = $this->input->post('extra_charge');

            $update_data = array(
                'reference' => $reference_invoice,
                'address' => $address_invoice,
                'project_name' => $project_name_invoice,
                'indent_no' => $po_no_invoice,
                'mpr_no' => $mpr_invoice,
                'currency' => $currency,
                'customer_name' => $customer_name,
                'status' => $sales_type,
                'extra_charge_type' => $extra_charge_type,
                'extra_charge' => $extra_charge,
                'confirmed' => "yes"
            );
            $this->Common_model->update_data_onerow('print_field', $update_data, 'invoice_id', $invoice_id);
            $res=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice_id),"net_payable,extra_charge,paid,due",1);
            $new_payable=$res['net_payable']-$res['extra_charge']+$extra_charge;
            $arr=array(
                'net_payable' => $new_payable,
                'extra_charge_type' => $extra_charge_type,
                'due' => $new_payable-$res['paid'],
                'extra_charge' => $extra_charge,
            );
            $this->Common_model->update_data_onerow('sell_product', $arr, 'invoice_no', $invoice_id);
            $res=$this->Common_model->get_single("sales_due",array("invoice_no"=>$invoice_id),"total,paid,due,extra_charge",1);
            $new_total=$res['total']-$res['extra_charge']+$extra_charge;
            $arr2=array(
                'total' => $new_total,
                'due' => $new_total-$res['paid'],
                'extra_charge_type' => $extra_charge_type,
                'extra_charge' => $extra_charge,
            );
            $this->Common_model->update_data_onerow('sales_due', $arr2, 'invoice_no', $invoice_id);
            if($customer_name!='')
            {
                redirect("Show_form/generate_bill/$invoice_id");
            }else{
                redirect("Show_edit_form/print_sales_invoice/$invoice_id/invoice_btn", 'refresh');
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function purchase_order($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            if(isset($_POST['single_product'])=="Edit")
            {
                $machine_category = $this->input->post('machine_category');
                $section = $this->input->post('section');
                $machine_model = $this->input->post('machine_model');
                $chassis = $this->input->post('chassis');
                $parts_name = $this->input->post('parts_name');
                $parts_no = $this->input->post('parts_no');
                $alternative_parts_no = $this->input->post('alternative_parts_no');
                $chinese_name = $this->input->post('chinese_name');
                $unit = $this->input->post('unit');
                $payment_type = $this->input->post('payment_type');
                $reminder_level = $this->input->post('reminder_level');
                $description = $this->input->post('description');
                $shelf_details = $this->input->post('shelf_details');
                $selling_price = $this->input->post('selling_price');
                $brand = $this->input->post('brand');
                $unit_price = $this->input->post('unit_price');
                $quantity = $this->input->post('quantity');
                $po_hidden = $this->input->post('po_hidden');
                $single=$this->Common_model->get_allinfo_byid('purchase_order', 'record_id', $id);

                $this->db->select("sum(quantity) as total_quantity");
                $this->db->from('purchase_order');
                $this->db->where('po_no', $po_hidden);
                $result=$this->db->get()->result_array();
                $other_cost_minus=$single[0]->quantity*$single[0]->unit_price;
                $other_quantity=$result[0]['total_quantity']-$single[0]->quantity;
                $total_with_extra=$single[0]->total_with_extra-$other_cost_minus;
                $total_discount=$unit_price-(($unit_price*$single[0]->discount)/100);

                $total_quantity=$other_quantity+$quantity;
                $other_cost_plus=$quantity*$unit_price;
                
                $total=$quantity*$total_discount;
                // echo "<pre>";
                // print_r($other_cost_plus);
                // die();
                $total_with_extra=$total_with_extra+$other_cost_plus;
                $after_discount_unit_price=$unit_price-(($unit_price*$single[0]->discount)/100);
                $update_data = array(
                    'machine_category' => $machine_category,
                    'section' => $section,
                    'machine_model' => $machine_model,
                    'chassis' => $chassis,
                    'parts_name' => $parts_name,
                    'parts_no' => $parts_no,
                    'alternative_parts_no' => $alternative_parts_no,
                    'chinese_name' => $chinese_name,
                    'unit' => $unit,
                    'payment_type' => $payment_type,
                    'reminder_level' => $reminder_level,
                    'description' => $description,
                    'shelf_details' => $shelf_details,
                    'selling_price' => $selling_price,
                    'brand' => $brand,
                    'unit_price' => $unit_price,
                    'quantity' => $quantity,
                    'total_price' => $total
                );
                $this->db->update("purchase_order",array("total_with_extra"=>$total_with_extra),array("po_no"=>$po_hidden));
                $this->Common_model->update_data_onerow('purchase_order', $update_data, 'record_id', $id);
                $all_purchase = $this->Common_model->get_allinfo_byid('purchase_order', 'po_no', $po_hidden);
                $total_without_extra=0;
                $total_with_extra=0;
                $total_discount=0;
                foreach ($all_purchase as $single_purchase) {
                    $quantity = $single_purchase->quantity;
                    $total_with_extra = $single_purchase->total_with_extra;
                    $discount = $single_purchase->discount;
                    $unit_price = $single_purchase->unit_price;
                    $discount_percentage = $discount / 100;
                    $total_discount += $discount_percentage*$unit_price*$quantity;
                    $after_discount_unit_price = $unit_price - ($unit_price * $discount_percentage);
                    $total_price = $quantity * $after_discount_unit_price;
                    $total_without_extra += $total_price;
                }
                $update_all_data_po_hidden=array(
                    'total_without_extra'=>$total_without_extra,
                    'total_with_extra'=>$total_with_extra,
                    'net_payable'=>$total_with_extra-$total_discount,
                );
               
                $this->db->update("purchase_order",$update_all_data_po_hidden,array("po_no"=>$po_hidden));
                $this->Common_model->update_data_onerow('purchase_order', $update_data, 'record_id', $id);
                
            }
            else
            {
                $po_no=$this->input->post("po_no");
                if(isset($po_no))
                {
                    $po_editable = $this->input->post('po_editable');
                    $total_with_extra = $this->input->post('total_cost');
                    $net_payable = $this->input->post('net_payable');
                    $supplier = $this->input->post('supplier');
                    $shipping_type = $this->input->post('shipping_type');
                    $serial = $this->input->post('serial');
                    $shiping_cost = (float)$this->input->post('shiping_cost');
                    $custom_cost = (float)$this->input->post('custom_cost');
                    $transport_cost = (float)$this->input->post('transport_cost');
                    $misc_cost = (float)$this->input->post('misc_cost');
                    $discount = (int)$this->input->post('discount');
                    $discount_percentage = $discount / 100;
                    $total_without_extra = 0;
                    $paid = $this->input->post('paid');
                    $due = $this->input->post('due');
                    // $total_discount = $this->input->post('total_cost') * $discount_percentage;
                    $all_purchase = $this->Common_model->get_allinfo_byid('purchase_order', 'po_no', $po_no);
                    foreach ($all_purchase as $single_purchase) {
                        $quantity = $single_purchase->quantity;
                        $unit_price = $single_purchase->unit_price;
                        $after_discount_unit_price = $unit_price - ($unit_price * $discount_percentage);
                        $total_price = $quantity * $after_discount_unit_price;
                        $total_without_extra += $total_price;
                    }
                    $update_all_data=array(
                        'supplier'=>$supplier,
                        'total_without_extra'=>$total_without_extra,
                        'shipping_type'=>$shipping_type,
                        'shiping_cost'=>$shiping_cost,
                        'custom_cost'=>$custom_cost,
                        'transport_cost'=>$transport_cost,
                        'misc_cost'=>$misc_cost,
                        'total_with_extra'=>$total_with_extra,
                        'discount'=>$discount,
                        'net_payable'=>$net_payable,
                        'paid'=>$paid,
                        'due'=>$due,
                        'serial'=>$serial
                    );
                   
                    $this->db->update("purchase_order",$update_all_data,array("po_no"=>$po_no));
                    $this->db->update("purchase_order",array("po_no"=>$po_editable),array("po_no"=>$po_no));
                }
            }
            redirect('Show_form/purchase_order/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function sell_product($invoice_no)
    {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $record_id=$this->input->post("record_id");
            $payment_type = $this->input->post('payment_type');
            $bank_name = $this->input->post('bank_name');
            $account_no = $this->input->post('account_no');
            $cheque_no = $this->input->post('cheque_no');
            $date = $this->input->post("date");
            $paid = $this->input->post("pay");
            $discount = $this->input->post("discount");
            $due = $this->input->post("due");
            $complete_total = (float)$this->input->post("complete_total");
            $res=$this->Common_model->get_single("sell_product",array("invoice_no"=>$invoice_no),"complete_total,extra_charge,paid,due",1);
            $net_payable = $complete_total-$discount+$res['extra_charge'];
            foreach ($record_id as $value) {
                $parts_name = $this->input->post("parts_name")[$value];
                $parts_no = $this->input->post("parts_no")[$value];
                $unit = $this->input->post("unit")[$value];
                $product_qty =$this->input->post("product_qty")[$value];
                $selling_price = $this->input->post("selling_price")[$value];
                $first_total = $this->input->post("total_price")[$value];
                $ind_discount = $this->input->post("ind_discount")[$value];
                $total = $this->input->post("sub_total")[$value];
               
                $remarks = $this->input->post("remarks");
                $alt_parts_no =$this->input->post("alt_parts_no")[$value];
                $brand =$this->input->post("brand")[$value];

                $update_data = array(
                    'date' => $date,
                    'product_name' => $parts_name,
                    'parts_no' => $parts_no,
                    'unit' => $unit,
                    'price_per_unit' => $selling_price,
                    'product_qty' => $product_qty,
                    'first_total' => $first_total,
                    'ind_discount' => $ind_discount,
                    'total' => $total,
                    'sub_total' => $complete_total,
                    'discount' => $discount,
                    'complete_total' => $complete_total,
                    'net_payable' => $net_payable,
                    'paid' => $paid,
                    'due' => $due,
                    'payment_type' => $payment_type,
                    'bank_name' => $bank_name,
                    'account_no' => $account_no,
                    'cheque_no' => $cheque_no,
                    'remarks' => $remarks,
                    'alt_parts_no' => $alt_parts_no,
                    'brand' => $brand,
                );
                $this->db->update('sell_product', $update_data,array("record_id"=>$value));
            }
            if(!empty($paid)){
                $payment_number="First";
            }
            else{
                $payment_number="N/A";
            }
            $sales_due_update_data = array(
                'date' => $date,
                'total' => $complete_total,
                'after_discount' => $complete_total-$discount,
                'discount' => $discount,
                'payment_type' => $payment_type,
                'bank_name' => $bank_name,
                'account_no' => $account_no,
                'cheque_no' => $cheque_no,
                'paid' => $paid,
                'due' => $due,
                'payment_number' => $payment_number
            );
            $this->Common_model->update('sales_due', $sales_due_update_data,array("invoice_no"=>$invoice_no));
            $auditors_data=array(
                "name"=>"Invoice NO: ".$invoice_no,
                "user_name"=>$this->session->ses_username,
                "type"=>"Edit",
                "created_at"=>date("Y-m-d H:i:s")
            );
            $this->Common_model->insert_data("auditors",$auditors_data);
            redirect("Show_form/sales/main");
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function purchase_product($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            if(isset($_POST['single_product'])=="Edit")
            {
                $machine_category = $this->input->post('machine_category');
                $section = $this->input->post('section');
                $machine_model = $this->input->post('machine_model');
                $chassis = $this->input->post('chassis');
                $parts_name = $this->input->post('parts_name');
                $parts_no = $this->input->post('parts_no');
                $alternative_parts_no = $this->input->post('alternative_parts_no');
                $chinese_name = $this->input->post('chinese_name');
                $unit = $this->input->post('unit');
                $payment_type = $this->input->post('payment_type');
                $reminder_level = $this->input->post('reminder_level');
                $description = $this->input->post('description');
                $shelf_details = $this->input->post('shelf_details');
                $selling_price = $this->input->post('selling_price');
                $brand = $this->input->post('brand');
                $unit_price = $this->input->post('unit_price');
                $quantity = $this->input->post('quantity');
                $po_hidden = $this->input->post('po_hidden');
                
                $img_name = $id . ".jpg";

                $config['file_name'] = $img_name;
                $config['upload_path'] = './assets/img/purchase_product/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 0;
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['overwrite'] = TRUE;

                $this->load->library('upload', $config);
                $this->upload->do_upload('image');

                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/img/purchase_product/' . $img_name;
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 100;
                $config['height'] = 100;

                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $single=$this->Common_model->get_allinfo_byid('purchase_product', 'record_id', $id);

                $this->db->select("sum(quantity) as total_quantity");
                $this->db->from('purchase_product');
                $this->db->where('po_no', $po_hidden);
                $result=$this->db->get()->result_array();
                $other_cost_minus=$single[0]->quantity*$single[0]->unit_price;
                $other_quantity=$result[0]['total_quantity']-$single[0]->quantity;
                $total_with_extra=$single[0]->total_with_extra-$other_cost_minus;
                $total_discount=$unit_price-(($unit_price*$single[0]->discount)/100);

                $total_quantity=$other_quantity+$quantity;
                $other_cost_plus=$quantity*$unit_price;
                
                $total=$quantity*$total_discount;
                $total_with_extra=$total_with_extra+$other_cost_plus;
                $after_discount_unit_price=$unit_price-(($unit_price*$single[0]->discount)/100);
                $update_data = array(
                    'machine_category' => $machine_category,
                    'section' => $section,
                    'machine_model' => $machine_model,
                    'chassis' => $chassis,
                    'parts_name' => $parts_name,
                    'parts_no' => $parts_no,
                    'alternative_parts_no' => $alternative_parts_no,
                    'chinese_name' => $chinese_name,
                    'unit' => $unit,
                    'payment_type' => $payment_type,
                    'reminder_level' => $reminder_level,
                    'description' => $description,
                    'shelf_details' => $shelf_details,
                    'selling_price' => $selling_price,
                    'brand' => $brand,
                    'unit_price' => $unit_price,
                    'quantity' => $quantity,
                    'after_discount_unit_price' => $after_discount_unit_price,
                    'total_price' => $total,
                    'image_id' => $id . ".jpg"
                );
                $this->db->update("purchase_product",array("total_with_extra"=>$total_with_extra),array("po_no"=>$po_hidden));
                $this->Common_model->update_data_onerow('purchase_product', $update_data, 'record_id', $id);
                $all_purchase = $this->Common_model->get_allinfo_byid('purchase_product', 'po_no', $po_hidden);
                $total_without_extra=0;
                $total_with_extra=0;
                $total_discount=0;
                foreach ($all_purchase as $single_purchase) {
                    $quantity = $single_purchase->quantity;
                    $total_discount = $single_purchase->total_discount;
                    $total_with_extra = $single_purchase->total_with_extra;
                    $discount = $single_purchase->discount;
                    $unit_price = $single_purchase->unit_price;
                    $discount_percentage = $discount / 100;
                    $after_discount_unit_price = $unit_price - ($unit_price * $discount_percentage);
                    $total_price = $quantity * $after_discount_unit_price;
                    $total_without_extra += $total_price;
                }
                $update_all_data_po_hidden=array(
                    'total_without_extra'=>$total_without_extra,
                    'total_with_extra'=>$total_with_extra,
                    'total_discount'=>$total_discount,
                    'net_payable'=>$total_with_extra-$total_discount,
                );
            
                $this->db->update("purchase_product",$update_all_data_po_hidden,array("po_no"=>$po_hidden));
                $this->session->set_flashdata("msg",'<div class="text-success text-center">Updated Successfully</div>');
                redirect('Show_edit_form/purchase_product/'.$id, 'refresh');
            }else{
                
                $po_no=$this->input->post("po_no");
                if(isset($po_no)){
                    $po_editable = $this->input->post('po_editable');
                    $total_with_extra = $this->input->post('total_cost');
                    $net_payable = $this->input->post('net_payable');
                    $supplier = $this->input->post('supplier');
                    $shipping_type = $this->input->post('shipping_type');
                    $serial = $this->input->post('serial');
                    $shiping_cost = (float)$this->input->post('shiping_cost');
                    $custom_cost = (float)$this->input->post('custom_cost');
                    $transport_cost = (float)$this->input->post('transport_cost');
                    $misc_cost = (float)$this->input->post('misc_cost');
                    $discount = (int)$this->input->post('discount');
                    $discount_percentage = $discount / 100;
                    $total_without_extra = 0;
                    $paid = $this->input->post('paid');
                    $due = $this->input->post('due');
                    $total_discount = $this->input->post('total_cost') * $discount_percentage;
                    $all_purchase = $this->Common_model->get_allinfo_byid('purchase_product', 'po_no', $po_no);
                    foreach ($all_purchase as $single_purchase) {
                        $quantity = $single_purchase->quantity;
                        $unit_price = $single_purchase->unit_price;
                        $after_discount_unit_price = $unit_price - ($unit_price * $discount_percentage);
                        $total_price = $quantity * $after_discount_unit_price;
                        $total_without_extra += $total_price;
                    $this->db->update("purchase_product",array("after_discount_unit_price"=>$after_discount_unit_price,"total_price"=>$total_price),array("record_id"=>$single_purchase->record_id));
                    }
                    $update_all_data=array(
                        'supplier'=>$supplier,
                        'total_without_extra'=>$total_without_extra,
                        'shipping_type'=>$shipping_type,
                        'shiping_cost'=>$shiping_cost,
                        'custom_cost'=>$custom_cost,
                        'transport_cost'=>$transport_cost,
                        'misc_cost'=>$misc_cost,
                        'total_with_extra'=>$total_with_extra,
                        'discount'=>$discount,
                        'total_discount'=>$total_discount,
                        'net_payable'=>$net_payable,
                        'paid'=>$paid,
                        'due'=>$due,
                        'serial'=>$serial
                    );
                    
                    $this->db->update("purchase_product",$update_all_data,array("po_no"=>$po_no));
                    $this->db->update("purchase_product",array("po_no"=>$po_editable),array("po_no"=>$po_no));
                }
                $this->session->set_flashdata("msg",'<div class="text-success text-center">Updated Successfully</div>');
                redirect('Show_form/purchase_product/edit', 'refresh');
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function approve_po($po_no) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $result = $this->Common_model->get_allinfo_byid('purchase_order', 'po_no', $po_no);

            $total_without_extra = 0;
            foreach ($result as $info) {
                $discount_percentage = $info->discount / 100;
                $unit_price = $info->unit_price;
                $after_discount_unit_price = $unit_price - ($unit_price * $discount_percentage);
                $total_price = $info->quantity * $after_discount_unit_price;
                $total_without_extra += $total_price;
                $all_extra = $info->shiping_cost + $info->custom_cost +
                        $info->transport_cost + $info->misc_cost;
                $all_extra = $all_extra - ($all_extra * $discount_percentage);
                $total_discount = $info->total_with_extra * $discount_percentage;
                $insert_data = array(
                    'date' => $info->date,
                    'machine_category' => $info->machine_category,
                    'section' => $info->section,
                    'machine_model' => $info->machine_model,
                    'chassis' => $info->chassis,
                    'brand' => $info->brand,
                    'parts_name' => $info->parts_name,
                    'parts_no' => $info->parts_no,
                    'alternative_parts_no' => $info->alternative_parts_no,
                    'chinese_name' => $info->chinese_name,
                    'unit' => $info->unit,
                    'unit_price' => $info->unit_price,
                    'payment_type' => $info->payment_type,
                    'discount' => $info->discount,
                    'after_discount_unit_price' => $after_discount_unit_price,
                    'quantity' => $info->quantity,
                    'total_price' => $total_price,
                    'reminder_level' => $info->reminder_level,
                    'description' => $info->description,
                    'shelf_details' => $info->shelf_details,
                    'selling_price' => $info->selling_price,
                    'supplier' => $info->supplier,
                    'po_no' => $info->po_no,
                    'shipping_type' => $info->shipping_type,
                    'serial' => $info->serial,
                    'shiping_cost' => $info->shiping_cost,
                    'custom_cost' => $info->custom_cost,
                    'transport_cost' => $info->transport_cost,
                    'misc_cost' => $info->misc_cost,
                    'paid' => $info->paid,
                    'due' => $info->due
                );
                $this->Common_model->insert_data('purchase_product', $insert_data);
            }

            $update_data = array(
                'is_approved' => 1
            );
            $this->Common_model->update_data_onerow('purchase_order', $update_data, 'po_no', $po_no);
            $update_data = array(
                'total_discount' => $total_discount,
                'total_without_extra' => $total_without_extra,
                'total_with_extra' => $total_without_extra + $all_extra,
                'net_payable' => $total_without_extra + $all_extra
            );
            $this->Common_model->update_data_onerow('purchase_product', $update_data, 'po_no', $po_no);
            redirect('Show_form/purchase_order/approved', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function delivered_product($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $update_data = array('delivered_status' => 1);
            $this->Common_model->update_data_onerow('sell_product', $update_data, 'invoice_no', $id);
            $auditors_data=array(
                "name"=>"Invoice No: ".$id,
                "user_name"=>$this->session->ses_username,
                "type"=>"Product Deliverd",
                "created_at"=>date("Y-m-d H:i:s")
            );
            $this->Common_model->insert_data("auditors",$auditors_data);
            redirect('Show_form/delivered_product/delivered', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_manufacture_company($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $vendor_name = $this->input->post('vendor_name');
            $old_vendor_name = $this->input->post('old_vendor_name');
            $mobile = $this->input->post('mobile_no');
            $address = $this->input->post('address');
            $previous_due = $this->input->post('previous_due');

            $update_data = array(
                'manufacture_company' => $vendor_name,
                'mobile' => $mobile,
                'address' => $address,
                'previous_due' => $previous_due
            );
            $this->Common_model->update_data_onerow('create_manufacture_company', $update_data, 'record_id', $id);

            //Update purchase_due vendor name
            $update_data = array(
                'manufacturer' => $vendor_name
            );
            $this->Common_model->update_data_onerow('purchase_due', $update_data, 'manufacturer', $old_vendor_name);

            //Update purchase_due due
            $update_data = array(
                'total' => $previous_due,
                'due' => $previous_due
            );

            $checking_array = array(
                'manufacturer' => $vendor_name,
                'voucher_no' => "Previous Due"
            );
            $this->Common_model->update_data_onerow_where_array('purchase_due', $update_data, $checking_array);

            //Update purchase_product vendor name
            $update_data = array(
                'supplier' => $vendor_name
            );
            $this->Common_model->update_data_onerow('purchase_product', $update_data, 'supplier', $old_vendor_name);

            redirect('Show_form/create_manufacture_company/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_product_name($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $product_name = $this->input->post('product_name');
            $section = $this->input->post('section');
            $product_type = $this->input->post('product_type');
            $exits=$this->Common_model->duplicate_check("create_product_name",array("product_name"=>$product_name,"machine_category"=>$product_type),$this->input->post('id'));
            if(!$exits)
            {
                $update_data = array(
                    'product_name' => $product_name,
                    'section' => $section,
                    'machine_category' => $product_type
                );
                $this->Common_model->update_data_onerow('create_product_name', $update_data, 'record_id', $id);
                redirect('Show_form/create_product_name/edit', 'refresh');
            }else{
                $this->session->set_flashdata("msg",'<div class="alert alert-danger">Parts Name Already Exits!</div>');
                redirect('show_edit_form/create_product_name/'.$id);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_product_type($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $product_type = $this->input->post('product_type');
            $brand = $this->input->post('brand');
            $exits=$this->Common_model->duplicate_check("create_product_type",array("product_type"=>$product_type),$id);
            if($exits==true){
                $result = $this->Common_model->get_allinfo_byid('create_product_type', 'record_id', $id);
                foreach ($result as $info) {
                    $old_machine_category = $info->product_type;
                }
                $update_data = array(
                    'product_type' => $product_type,
                    'brand' => $brand
                );
                $this->Common_model->update_data_onerow('create_product_type', $update_data, 'record_id', $id);

                $update_data = array(
                    'machine_category' => $product_type
                );
                $this->Common_model->update_data_onerow('create_section', $update_data, 'machine_category', $old_machine_category);

                $update_data = array(
                    'machine_category' => $product_type
                );
                $this->Common_model->update_data_onerow('create_product_name', $update_data, 'machine_category', $old_machine_category);
                redirect('Show_form/create_product_type/edit', 'refresh');
            }else{
                $this->session->set_flashdata('msg', '<div class="alert alert-warning">Machine Category Already Exits.</div>');
                redirect('Show_form/create_product_type/main', 'refresh');
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_section($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $result = $this->Common_model->get_allinfo_byid('create_section', 'record_id', $id);
            foreach ($result as $info) {
                $old_section = $info->section;
            }
            $section = $this->input->post('section');
            $product_type = $this->input->post('product_type');
            $update_data = array(
                'machine_category' => $product_type,
                'section' => $section
            );
            $this->Common_model->update_data_onerow('create_section', $update_data, 'record_id', $id);

            $update_data = array(
                'section' => $section
            );
            $this->Common_model->update_data_onerow('create_product_name', $update_data, 'section', $old_section);

            redirect('Show_form/create_section/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_dealing($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $client = explode('#', $this->input->post('client'));
            $mobile = $this->input->post('mobile');
            $email = $this->input->post('email');
            $meeting_date = $this->input->post('meeting_date');
            $venue = $this->input->post('venue');
            $time = $this->input->post('time');
            $responsible_person = $this->input->post('responsible_person');
            $comments = $this->input->post('comments');

            $update_data = array(
                'date' => date('Y-m-d'),
                'name' => $client[0],
                'client_id' => $client[1],
                'mobile' => $mobile,
                'email' => $email,
                'meeting_date' => $meeting_date,
                'venue' => $venue,
                'time' => $time,
                'responsible_person' => $responsible_person,
                'comments' => $comments
            );
            $this->Common_model->update_data_onerow('sales_dealing', $update_data, 'record_id', $id);
            redirect('Show_form/sales_dealing/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function sales_schedule($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $client = explode('#', $this->input->post('client'));
            $mobile = $this->input->post('mobile');
            $email = $this->input->post('email');
            $meeting_date = $this->input->post('meeting_date');
            $venue = $this->input->post('venue');
            $time = $this->input->post('time');
            $responsible_person = $this->input->post('responsible_person');

            $update_data = array(
                'date' => date('Y-m-d'),
                'name' => $client[0],
                'client_id' => $client[1],
                'mobile' => $mobile,
                'email' => $email,
                'meeting_date' => $meeting_date,
                'venue' => $venue,
                'time' => $time,
                'responsible_person' => $responsible_person,
            );
            $this->Common_model->update_data_onerow('sales_schedule', $update_data, 'record_id', $id);
            redirect('Show_form/sales_schedule/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function add_client($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $client_name = $this->input->post('client_name');
            $old_client_name = $this->input->post('old_client_name');
            $mobile = $this->input->post('mobile');
            $address = $this->input->post('address');
            $previous_due = $this->input->post('previous_due');
//            $point = $this->input->post('point');

            $update_data = array(
                'date' => date('Y-m-d'),
                'name' => $client_name,
                'mobile' => $mobile,
                'address' => $address,
                'previous_due' => $previous_due,
//                'point' => $point,
            );
            $this->Common_model->update_data_onerow('add_client', $update_data, 'record_id', $id);

            //Update sales_due client name
            $update_data = array(
                'client_name' => $client_name
            );
            $this->Common_model->update_data_onerow('sales_due', $update_data, 'client_name', $old_client_name);

            //Update sales_due due
            $update_data = array(
                'total' => $previous_due,
                'due' => $previous_due
            );

            $checking_array = array(
                'client_name' => $client_name,
                'invoice_no' => "Previous Due"
            );
            $this->Common_model->update_data_onerow_where_array('sales_due', $update_data, $checking_array);

            //Update sell_product client name
            $update_data = array(
                'client_name' => $client_name
            );
            $this->Common_model->update_data_onerow('sell_product', $update_data, 'client_name', $old_client_name);

            redirect('Show_form/add_client/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function insert_product_info($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $img_name = $id . ".jpg";

            $config['file_name'] = $img_name;
            $config['upload_path'] = './assets/img/product/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 0;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['overwrite'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->do_upload('image');

            $product_type = $this->input->post('product_type');
            $sub_category = $this->input->post('sub_category');
            $product_name = $this->input->post('product_name');
            $brand_name = $this->input->post('brand_name');
            $product_model = $this->input->post('product_model');
            $manufacture_company = $this->input->post('manufacture_company');
            $product_indication = $this->input->post('product_indication');
            $unit = $this->input->post('unit');
            $reminder_level = $this->input->post('reminder_level');
            $shelf_details = $this->input->post('shelf_details');
            $purchase_price = $this->input->post('purchase_price');
            $selling_price = $this->input->post('selling_price');
            $wholesale_price = $this->input->post('wholesale_price');
            $retail_price = $this->input->post('retail_price');

            $update_data = array(
                'date' => date('Y-m-d'),
                'product_type' => $product_type,
                'sub_category' => $sub_category,
                'product_name' => $product_name,
                'brand_name' => $brand_name,
                'product_model' => $product_model,
                'manufacture_company' => $manufacture_company,
                'product_indication' => $product_indication,
                'unit_type' => $unit,
                'reminder_level' => $reminder_level,
                'shelf_details' => $shelf_details,
                'purchase_price' => $purchase_price,
                'selling_price' => $selling_price,
                'wholesale_price' => $wholesale_price,
                'retail_price' => $retail_price
            );

            $this->Common_model->update_data_onerow('insert_product_info', $update_data, 'record_id', $id);
            redirect('Show_form/insert_product_info/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function employee_schedule($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date = $this->input->post('date');
            $start_time = $this->input->post('start_time');
            $end_time = $this->input->post('end_time');
            $temp_available_days = $this->input->post('available_days');
            $available_days = "";
            foreach ($temp_available_days as $day) {
                $available_days = $available_days . $day . "#";
            }
            $update_data = array(
                'date' => $date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'available_days' => $available_days
            );
            $this->Common_model->update_data_onerow('employee_schedule', $update_data, 'record_id', $id);
            redirect('Show_form/employee_schedule/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function employee_active($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $update_data = array('block_status' => 0);
            $this->Common_model->update_data_onerow('employee', $update_data, 'record_id', $id);
            redirect('Show_form/create_employee/active', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function employee_inactive($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $update_data = array('block_status' => 1);
            $this->Common_model->update_data_onerow('employee', $update_data, 'record_id', $id);
            redirect('Show_form/create_employee/inactive', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function employee_list($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin") {
            $img_name = $id . ".jpg";

            $config['file_name'] = $img_name;
            $config['upload_path'] = './assets/img/employee/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 0;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['overwrite'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->do_upload('image');

            $name = $this->input->post('name');
            $designation = $this->input->post('designation');
            $joining_date = $this->input->post('joining_date');
            $department = $this->input->post('department');
            $mobile = $this->input->post('mobile');
            $address = $this->input->post('address');
            $bank_name = $this->input->post('bank_name');
            $account = $this->input->post('account');
            $total_salary = $this->input->post('total_salary');

            $update_data = array(
                'name' => $name,
                'designation' => $designation,
                'joining_date' => $joining_date,
                'department' => $department,
                'mobile' => $mobile,
                'address' => $address,
                'bank_name' => $bank_name,
                'account' => $account,
                'total_salary' => $total_salary,
            );
            $this->Common_model->update_data_onerow('employee', $update_data, 'record_id', $id);
            redirect('Show_form/create_employee/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function update_attendance() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $this->load->model('Common_model');
            $report = $this->input->post('report');
            $count = $this->input->post('count');

            $table_name = 'employee_attendance';


            for ($i = 1; $i <= $count; $i++) {
                $outtime = $this->input->post('outtime' . $i);
                $record_id = $this->input->post('record' . $i);
                $status = $this->input->post('status' . $i);

                if (!empty($outtime)) {
                    $update_data = array(
                        'outtime' => $outtime,
                        'status' => $status,
                    );
                    $this->Common_model->update_data_onerow($table_name, $update_data, 'record_id', $record_id);
                } else {
                    $outtime = $this->input->post('outtime' . $count);
                    $update_data = array(
                        'outtime' => $outtime,
                        'status' => $status,
                    );
                    $this->Common_model->update_data_onerow($table_name, $update_data, 'record_id', $record_id);
                }
            }
            redirect('Show_form/attendance_report/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_sms($id) {
        if ($this->session->userdata('ses_user_type') == "admin") {
            $this->load->model('Common_model');
            $this->form_validation->set_rules('date', 'Create Date', 'trim|required');
            $this->form_validation->set_rules('title', 'Message Title', 'trim|required');
            $this->form_validation->set_rules('body', 'Message Body', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                redirect('Show_edit_form/create_sms/' . $id . '/empty', 'refresh');
            } else {
                $date = $this->input->post('date');
                $title = $this->input->post('title');
                $body = $this->input->post('body');

                $update_data = array(
                    'create_date' => $date,
                    'title' => $title,
                    'body' => $body
                );
                $this->Common_model->update_data_onerow('create_sms', $update_data, 'record_id', $id);
                redirect('Show_form/create_sms/edit', 'refresh');
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function insert_notice($id) {
        if ($this->session->userdata('ses_user_type') == "admin") {
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
            $this->form_validation->set_rules('particular', 'Particular', 'trim|required');
            $this->form_validation->set_rules('details', 'Details', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                redirect('Show_edit_form/insert_notice/' . $id . '/empty', 'refresh');
            } else {
                $date = $this->input->post('date');
                $particular = $this->input->post('particular');
                $details = $this->input->post('details');

                $update_data = array(
                    'date' => $date,
                    'particular' => $particular,
                    'details' => $details
                );
                $this->Common_model->update_data_onerow('insert_notice', $update_data, 'record_id', $id);
                redirect('Show_form/insert_notice/edit', 'refresh');
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_user($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $name = $this->input->post('name');
            $mobile = $this->input->post('mobile');
            $email = $this->input->post('email');
            $address = $this->input->post('address');
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $inventory = $this->input->post('inventory');
            $sales = $this->input->post('sales');
            $accounting = $this->input->post('accounting');
            $hr = $this->input->post('hr');

            $permission = "";
            if (!empty($inventory)) {
                $permission .= $inventory . "###";
            }
            if (!empty($sales)) {
                $permission .= $sales . "###";
            }
            if (!empty($accounting)) {
                $permission .= $accounting . "###";
            }
            if (!empty($hr)) {
                $permission .= $hr;
            }

            $update_data = array(
                'name' => $name,
                'mobile' => $mobile,
                'address' => $address,
                'username' => $username,
                'password' => $password,
                'permission' => $permission
            );
            $this->Common_model->update_data_onerow('user', $update_data, 'record_id', $id);
            redirect('Show_form/create_user/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function update_status($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $result=$this->Common_model->get_single("user",array('record_id'=>$id));
            if(!empty($result)){
                $status=1;
                if($result[0]['status']=="1"){
                    $status=0;
                }
                $this->db->update("user",array("status"=>$status),array("record_id"=>$id));
                redirect('Show_form/create_user/edit', 'refresh');
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function create_sub_category($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $category = $this->input->post('category');
            $sub_category = $this->input->post('sub_category');
            $update_data = array(
                'category' => $category,
                'sub_category' => $sub_category
            );
            $this->Common_model->update_data_onerow('create_sub_category', $update_data, 'record_id', $id);
            redirect('Show_form/create_sub_category/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function create_brand_name($id) {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $brand_name = $this->input->post('brand_name');
            $update_data = array(
                'brand_name' => $brand_name
            );
            $this->Common_model->update_data_onerow('create_brand_name', $update_data, 'record_id', $id);
            redirect('Show_form/create_brand_name/edit', 'refresh');
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

}
