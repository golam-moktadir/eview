<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Get_ajax_value extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $view_menu = $this->session->ses_view_menu_id;
        $insert_menu = $this->session->ses_insert_menu_id;
        $edit_menu = $this->session->ses_edit_menu_id;
        $delete_menu = $this->session->ses_delete_menu_id;
        $view_id = explode(",", $view_menu);
        $insert_id = explode(",", $insert_menu);
        $edit_id = explode(",", $edit_menu);
        $delete_id = explode(",", $delete_menu);
        $data["view_id"]=$view_id;
        $data["insert_id"]=$insert_id;
        $data["edit_id"]=$edit_id;
        $data["delete_id"]=$delete_id;
    }

    public function get_dep_bank_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('search_date_from');
            $date_to = $this->input->post('search_date_to');
            $root = $this->input->post('search_route');
            $bus_type = $this->input->post('search_bus_type');
            $expense_head = $this->input->post('search_expense_head');
//            $counter = $this->input->post('search_counter');
//            $trip_time = $this->input->post('search_trip_time');
//            $supervisor = $this->input->post('search_supervisor');
            //Staff Route Division
            if ($user_type == "staff") {
                $staff_id = $this->session->ses_record_id;
                $result = $this->Common_model->get_allinfo_byid('user', 'record_id', $staff_id);
                foreach ($result as $info) {
                    $data['staff_route'] = explode('###', $info->route);
                }
            }
            $data["user_type"] = $user_type;
//Staff Route Division Finish
            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }
            if (!empty($bus_type)) {
                $checking_array['bus_type'] = $bus_type;
            }
            if (!empty($root)) {
                $checking_array['root'] = $root;
            }
            if (!empty($expense_head)) {
                $checking_array['head'] = $expense_head;
            }
//            if (!empty($counter)) {
//                $checking_array['counter'] = $counter;
//            }
//            if (!empty($trip_time)) {
//                $checking_array['trip_time'] = $trip_time;
//            }
//            if (!empty($supervisor)) {
//                $checking_array['supervisor'] = $supervisor;
//            }
            $data["all_value"] = $this->Common_model->get_all_info_by_array("dep_bank", $checking_array);

            $this->load->view('admin/get_dep_bank_report', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function dep_bank_entry() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $all_expense = $this->input->post('all_expense');
            $result = $this->Common_model->find_last_id('entry_no', 'dep_bank');
            if (!$result) {
                $entry_no = 1;
            } else {
                foreach ($result as $row) {
                    $entry_no = ($row->entry_no) + 1;
                }
            }
            foreach ($all_expense as $single_expense) {
//                $bus_type = $single_expense[2];
//                $vehicle_reg_no = $single_expense[3];
//
//                if (empty($vehicle_reg_no)) {
//                    $vehicle_type = "Bus NAC";
//                } else {
//                    $result = $this->Common_model->get_allinfo_byid('vehicle_details', 'registration_no', $vehicle_reg_no);
//                    foreach ($result as $res) {
//                        $vehicle_type = $res->vehicle_type;
//                    }
//                }
//                $supervisor = $single_expense[6];
//                $trip_time = $single_expense[7];
//                $s_type = $single_expense[12];              
//                if ($s_type == 1) {
//                    $result = $this->Common_model->find_last_id('record_id', 'insert_staff');
//                    if (!$result) {
//                        $max_id = 1;
//                    } else {
//                        foreach ($result as $row) {
//                            $max_id = ($row->record_id) + 1;
//                        }
//                    }
//                    $img_name = $max_id . ".jpg";
//                    $insert_data = array(
//                        'record_id' => $max_id,
//                        'staff_name' => $supervisor,
//                        'designation' => 'Supervisor',
//                        'image' => $img_name,
//                    );
//                    $this->Common_model->insert_data('insert_staff', $insert_data);
//                }

                $root = $single_expense[1];
                $date = $single_expense[2];
                $search_date = date('d/m/Y', strtotime($date));
                $bus_type = $single_expense[3];
                $vehicle_type = $single_expense[4];
                $expense_head = $single_expense[5];
                $counter = $single_expense[6];
                $quantity = $single_expense[7];
                $amount = $single_expense[8];
                $comment = $single_expense[9];
                $insert_data = array(
                    'entry_no' => $entry_no,
                    'root' => $root,
                    'date' => $date,
                    'search_date' => $search_date,
                    'bus_type' => $bus_type,
                    'vehicle_type' => $vehicle_type,
                    'head' => $expense_head,
                    'counter' => $counter,
                    'quantity' => $quantity,
                    'amount' => $amount,
                    'comment' => $comment
//                    'bus_type' => $bus_type,
//                    'vehicle_reg_no' => $vehicle_reg_no,
//                    'trip_time' => $trip_time,
//                    'supervisor' => $supervisor
                );
                $this->Common_model->insert_data('dep_bank', $insert_data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_bus_maintenance_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('search_date_from');
            $date_to = $this->input->post('search_date_to');
            $root = $this->input->post('search_route');
            $bus_type = $this->input->post('search_bus_type');
            $parts_name = $this->input->post('search_parts_name');

            //Staff Route Division
            if ($user_type == "staff") {
                $staff_id = $this->session->ses_record_id;
                $result = $this->Common_model->get_allinfo_byid('user', 'record_id', $staff_id);
                foreach ($result as $info) {
                    $data['staff_route'] = explode('###', $info->route);
                }
            }
            $data["user_type"] = $user_type;
//Staff Route Division Finish
            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }
            if (!empty($bus_type)) {
                $checking_array['bus_type'] = $bus_type;
            }
            if (!empty($root)) {
                $checking_array['root'] = $root;
            }
            if (!empty($parts_name)) {
                $checking_array['parts_name'] = $parts_name;
            }
            $data["all_value"] = $this->Common_model->get_all_info_by_array("insert_bus_maintenance", $checking_array);

            $this->load->view('admin/get_bus_maintenance_report', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_gen_maintenance_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('search_date_from');
            $date_to = $this->input->post('search_date_to');
            $root = $this->input->post('search_route');
            $bus_type = $this->input->post('search_bus_type');
            $expense_head = $this->input->post('search_expense_head');
//            $counter = $this->input->post('search_counter');
//            $trip_time = $this->input->post('search_trip_time');
//            $supervisor = $this->input->post('search_supervisor');
            //Staff Route Division
            if ($user_type == "staff") {
                $staff_id = $this->session->ses_record_id;
                $result = $this->Common_model->get_allinfo_byid('user', 'record_id', $staff_id);
                foreach ($result as $info) {
                    $data['staff_route'] = explode('###', $info->route);
                }
            }
            $data["user_type"] = $user_type;
//Staff Route Division Finish
            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }
            if (!empty($bus_type)) {
                $checking_array['bus_type'] = $bus_type;
            }
            if (!empty($root)) {
                $checking_array['root'] = $root;
            }
            if (!empty($expense_head)) {
                $checking_array['head'] = $expense_head;
            }
//            if (!empty($counter)) {
//                $checking_array['counter'] = $counter;
//            }
//            if (!empty($trip_time)) {
//                $checking_array['trip_time'] = $trip_time;
//            }
//            if (!empty($supervisor)) {
//                $checking_array['supervisor'] = $supervisor;
//            }
            $data["all_value"] = $this->Common_model->get_all_info_by_array("general_maintenance", $checking_array);

            $this->load->view('admin/get_gen_maintenance_report', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_vou_exp_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('search_date_from');
            $date_to = $this->input->post('search_date_to');
            $root = $this->input->post('search_route');
            $bus_type = $this->input->post('search_bus_type');
            $expense_head = $this->input->post('search_expense_head');
//            $counter = $this->input->post('search_counter');
//            $trip_time = $this->input->post('search_trip_time');
//            $supervisor = $this->input->post('search_supervisor');
            //Staff Route Division
            if ($user_type == "staff") {
                $staff_id = $this->session->ses_record_id;
                $result = $this->Common_model->get_allinfo_byid('user', 'record_id', $staff_id);
                foreach ($result as $info) {
                    $data['staff_route'] = explode('###', $info->route);
                }
            }
            $data["user_type"] = $user_type;
//Staff Route Division Finish
            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }
            if (!empty($bus_type)) {
                $checking_array['bus_type'] = $bus_type;
            }
            if (!empty($root)) {
                $checking_array['root'] = $root;
            }
            if (!empty($expense_head)) {
                $checking_array['head'] = $expense_head;
            }
//            if (!empty($counter)) {
//                $checking_array['counter'] = $counter;
//            }
//            if (!empty($trip_time)) {
//                $checking_array['trip_time'] = $trip_time;
//            }
//            if (!empty($supervisor)) {
//                $checking_array['supervisor'] = $supervisor;
//            }
            $data["all_value"] = $this->Common_model->get_all_info_by_array("expense", $checking_array);

            $this->load->view('admin/get_vou_exp_report', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_gen_exp_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('search_date_from');
            $date_to = $this->input->post('search_date_to');
            $root = $this->input->post('search_route');
            $expense_head = $this->input->post('search_expense_head');

            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }
            if (!empty($root)) {
                $checking_array['route'] = $root;
            }
            if (!empty($expense_head)) {
                $checking_array['expense_head'] = $expense_head;
            }

            $data["all_value"] = $this->Common_model->get_all_info_by_array("insert_credit_general", $checking_array);

            $this->load->view('admin/get_gen_exp_report', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_income_expense_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('search_date_from');
            $date_to = $this->input->post('search_date_to');
            $bus_type = $this->input->post('search_bus_type');
            $root = $this->input->post('search_route');
            $counter = $this->input->post('search_counter');
            $trip_time = $this->input->post('search_trip_time');
            $supervisor = $this->input->post('search_supervisor');
            $line_expense = $this->input->post('search_line_expense');

            //Staff Route Division
            if ($user_type == "staff") {
                $staff_id = $this->session->ses_record_id;
                $result = $this->Common_model->get_allinfo_byid('user', 'record_id', $staff_id);
                foreach ($result as $info) {
                    $data['staff_route'] = explode('###', $info->route);
                }
            }
            $data["user_type"] = $user_type;
//Staff Route Division Finish
            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
            }
            if (!empty($bus_type)) {
                $checking_array['bus_type'] = $bus_type;
            }
            if (!empty($root)) {
                $checking_array['root'] = $root;
            }
            if (!empty($counter)) {
                $checking_array['counter'] = $counter;
            }
            if (!empty($trip_time)) {
                $checking_array['trip_time'] = $trip_time;
            }
            if (!empty($supervisor)) {
                $checking_array['supervisor'] = $supervisor;
            }
            if (!empty($line_expense)) {
                $checking_array['line_expense_head'] = $line_expense;
            }
            $data["all_value"] = $this->Common_model->get_all_info_by_array("income", $checking_array);

            $this->load->view('admin/get_income_expense_report', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_search_spare_parts() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('search_date_from');
            $date_to = $this->input->post('search_date_to');
            $search_category = $this->input->post('search_category');
            $data['date_range'] = "";
            $data['category'] = "";

//            //Staff Route Division
//            if ($user_type == "staff") {
//                $staff_id = $this->session->ses_record_id;
//                $result = $this->Common_model->get_allinfo_byid('user', 'record_id', $staff_id);
//                foreach ($result as $info) {
//                    $data['staff_route'] = explode('###', $info->route);
//                }
//            }
//            $data["user_type"] = $user_type;
//Staff Route Division Finish
            $checking_array = array();
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['purchase_date>='] = $date_from;
                $checking_array['purchase_date<='] = $date_to;
                $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
            }
            if (!empty($search_category)) {
                $checking_array['parts_category'] = $search_category;
                $data['category'] = $search_category;
            }
            $data["all_value"] = $this->Common_model->get_all_info_by_array("insert_spare_parts_info", $checking_array);

            $this->load->view('admin/get_search_spare_parts', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function general_maintenance_entry() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $all_expense = $this->input->post('all_expense');
            $result = $this->Common_model->find_last_id('entry_no', 'general_maintenance');
            if (!$result) {
                $entry_no = 1;
            } else {
                foreach ($result as $row) {
                    $entry_no = ($row->entry_no) + 1;
                }
            }
            foreach ($all_expense as $single_expense) {
                $root = $single_expense[1];
                $date = $single_expense[2];
                $search_date = date('d/m/Y', strtotime($date));
                $bus_type = $single_expense[3];
                $expense_head = $single_expense[4];
                $counter = $single_expense[5];
                $quantity = $single_expense[6];
                $amount = $single_expense[7];
                $comment = $single_expense[8];
                $insert_data = array(
                    'entry_no' => $entry_no,
                    'root' => $root,
                    'date' => $date,
                    'search_date' => $search_date,
                    'bus_type' => $bus_type,
                    'head' => $expense_head,
                    'counter' => $counter,
                    'voucher_num' => $quantity,
                    'amount' => $amount,
                    'comment' => $comment
                );
                $this->Common_model->insert_data('general_maintenance', $insert_data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_line_expense_amount() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $root = $this->input->post('root');
            $line_expense = $this->input->post('line_expense');
            $checking_array = array();
            $checking_array["route"] = $root;
            $checking_array["particular"] = $line_expense;
            $result = $this->Common_model->get_all_info_by_array("create_line_expenses", $checking_array);
            $final_amount = 0;
            foreach ($result as $info) {
                $final_amount = $info->amount;
            }
            echo $final_amount;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_sub_root() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $root = $this->input->post('root');
            $result = $this->Common_model->get_allinfo_byid("create_sub_root", 'root', $root);
            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                $option .= "<option value='$info->sub_root'>$info->sub_root</option>";
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_counter() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $root = $this->input->post('root');
            $result = $this->Common_model->get_allinfo_byid("create_counter", 'root', $root);
            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                $option .= "<option value='$info->counter_name'>$info->counter_name</option>";
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_line_expense_head() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $root = $this->input->post('root');
            $result = $this->Common_model->get_allinfo_byid("create_line_expenses", 'route', $root);
            $option = "<option value=''>-- Select --</option>";
            foreach ($result as $info) {
                $option .= "<option value='$info->particular'>$info->particular</option>";
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_route_trip_wise_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $bus_type = $this->input->post('bus_type');

            $checking_array = array();
            $data['date_range'] = "";
            $data['bus_type'] = "Golden Line Paribahan & Azmeri Enterprise";
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
                $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
            }
            if (!empty($bus_type)) {
                $checking_array['bus_type'] = $bus_type;
                $data['bus_type'] = $bus_type;
            }

            $all_route = $this->Common_model->get_all_info('create_root');
            $row_count = 0;
            foreach ($all_route as $single_route) {
                $row_count++;
                $data["route_name" . $row_count] = $single_route->root;
                $data["bus_type" . $row_count] = $single_route->bus_type;
                $data["distance_km" . $row_count] = $single_route->distance_km;
                $data["fuel_need" . $row_count] = $single_route->fuel_need;
                $data["fuel_cost_per_trip" . $row_count] = $single_route->fuel_cost_per_trip;

                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['root'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $total_actual_trip = count($this->Common_model->multil_column_group_by_where("income", $checking_array,
                                array("date", "trip_time", "bus_type", "root")));
                $data["total_trip" . $row_count] = $total_actual_trip;
                $all_ticket_result = $this->Common_model->get_all_info_by_array("income", $checking_array);
                $pass_qty = 0;
                foreach ($all_ticket_result as $single_ticket_result) {
                    $pass_qty += $single_ticket_result->quantity;
                }
                $data["total_pass_qty" . $row_count] = $pass_qty;
                if ($total_actual_trip == 0) {
                    $data["avg_pass_per_trip" . $row_count] = 0;
                } else {
                    $data["avg_pass_per_trip" . $row_count] = $pass_qty / $total_actual_trip;
                }
                $data["fare" . $row_count] = $single_route->fare;
                $total_sales = $single_route->fare * $pass_qty;
                $data["total_sales" . $row_count] = $total_sales;

                //Daily Bus Expense Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['root'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $daily_bus_exp_result = $this->Common_model->multil_column_group_by_where("income", $checking_array,
                        array("date", "trip_time", "bus_type", "root"));

                $daily_bus_exp_amount = 0;
                foreach ($daily_bus_exp_result as $single) {
                    $daily_bus_exp_amount += $single->amount;
                }
                $data["daily_bus_exp_amount" . $row_count] = $daily_bus_exp_amount;

                //Daily Voucher Expense Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['root'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $checking_array['head<>'] = "Depreciation";
                $checking_array['head<>'] = "Bank Loan Interest";
                $daily_vou_exp_result = $this->Common_model->get_all_info_by_array("expense", $checking_array);

                $daily_vou_exp_amount = 0;
                foreach ($daily_vou_exp_result as $single) {
                    $daily_vou_exp_amount += $single->amount;
                }
                $data["daily_vou_exp_amount" . $row_count] = $daily_vou_exp_amount;

                //Daily Bus Maintenance Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['purchase_date>='] = $date_from;
                    $checking_array['purchase_date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['route'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $daily_bus_maint_result = $this->Common_model->get_all_info_by_array("insert_bus_maintenance", $checking_array);

                $daily_bus_maint_amount = 0;
                foreach ($daily_bus_maint_result as $single) {
                    $daily_bus_maint_amount += $single->amount;
                }
                $data["daily_bus_maint_amount" . $row_count] = $daily_bus_maint_amount;

                //Daily General Maintenance Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['root'] = $single_route->root;

                $daily_gen_maint_amount = 0;

                if ($single_route->bus_type == "Bus NAC") {
                    $daily_gen_maint_result = $this->Common_model->get_all_info_by_array("general_maintenance", $checking_array);
                    foreach ($daily_gen_maint_result as $single) {
                        $daily_gen_maint_amount += $single->amount;
                    }
                }
                $data["daily_gen_maint_amount" . $row_count] = $daily_gen_maint_amount;

                //Credit Parts Expense Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['purchase_date>='] = $date_from;
                    $checking_array['purchase_date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['user_unit'] = $bus_type;
                }
                $checking_array['route'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $credit_parts_result = $this->Common_model->get_all_info_by_array("insert_spare_parts_info", $checking_array);

                $credit_parts_amount = 0;
                foreach ($credit_parts_result as $single) {
                    $credit_parts_amount += $single->amount;
                }
                $data["credit_parts_amount" . $row_count] = $credit_parts_amount;

                //Credit General Expense Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                $checking_array['route'] = $single_route->root;
                $checking_array['bus_type'] = $single_route->bus_type;


                $credit_general_amount = 0;

//                if ($single_route->bus_type == "Bus NAC") {
                $credit_general_result = $this->Common_model->get_all_info_by_array("insert_credit_general", $checking_array);
                foreach ($credit_general_result as $single) {
                    $credit_general_amount += $single->amount;
                }
//                }

                $data["credit_general_amount" . $row_count] = $credit_general_amount;
                //Cash Parts Expense Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['user_unit'] = $bus_type;
                }
                $checking_array['route'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $checking_array['cash_type'] = "payment_parts";
                $cash_parts_result = $this->Common_model->get_all_info_by_array("petty_cash", $checking_array);

                $cash_parts_amount = 0;
                foreach ($cash_parts_result as $single) {
                    $cash_parts_amount += $single->amount;
                }
                $data["cash_parts_amount" . $row_count] = $cash_parts_amount;
                //Cash General Expense Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                $checking_array['route'] = $single_route->root;
                $checking_array['cash_type'] = "payment_general";

                $cash_general_amount = 0;

                if ($single_route->bus_type == "Bus NAC") {
                    $cash_general_result = $this->Common_model->get_all_info_by_array("petty_cash", $checking_array);
                    foreach ($cash_general_result as $single) {
                        $cash_general_amount += $single->amount;
                    }
                }
                $data["cash_general_amount" . $row_count] = $cash_general_amount;

                //Total Expense
                $total_expense = $daily_bus_exp_amount + $daily_vou_exp_amount + $daily_bus_maint_amount + $daily_gen_maint_amount +
                        $credit_parts_amount + $credit_general_amount + $cash_parts_amount + $cash_general_amount;
                $data["total_expenses" . $row_count] = $total_expense;

                //Depreciation Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['root'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $checking_array['head'] = "Depreciation";
                $depreciation_result = $this->Common_model->get_all_info_by_array("dep_bank", $checking_array);

                $depreciation_amount = 0;
                foreach ($depreciation_result as $single) {
                    $depreciation_amount += $single->amount;
                }
                $data["depreciation_amount" . $row_count] = $depreciation_amount;

                //Bank Loan Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['root'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $checking_array['head'] = "Bank Loan Interest";
                $bank_loan_result = $this->Common_model->get_all_info_by_array("dep_bank", $checking_array);

                $bank_loan_amount = 0;
                foreach ($bank_loan_result as $single) {
                    $bank_loan_amount += $single->amount;
                }
                $data["bank_loan_amount" . $row_count] = $bank_loan_amount;
                $total_expense_with_dep_bank = $total_expense + $depreciation_amount + $bank_loan_amount;
                $data["total_expense_with_dep_bank" . $row_count] = $total_expense_with_dep_bank;
                $accounting_profit = $total_sales - $total_expense_with_dep_bank;
                $data["accounting_profit" . $row_count] = $accounting_profit;
                $data["cash_profit_with_dep" . $row_count] = $accounting_profit + $depreciation_amount;

                if ($total_actual_trip == 0) {
                    $data["accounting_profit_per_trip" . $row_count] = 0;
                    $data["cash_profit_per_trip" . $row_count] = 0;
                } else {
                    $data["accounting_profit_per_trip" . $row_count] = round(($accounting_profit / $total_actual_trip), 2);
                    $data["cash_profit_per_trip" . $row_count] = round((($accounting_profit + $depreciation_amount) / $total_actual_trip), 2);
                }
            }
            $data["count_it"] = $row_count;
            $this->load->view('admin/show_route_trip_wise_report', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }
    public function show_profit_loss_account() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $bus_type = $this->input->post('bus_type');

            $checking_array = array();
            $data['date_range'] = "";
            $data['bus_type'] = "Golden Line Paribahan & Azmeri Enterprise";
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
                $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
            }
            if (!empty($bus_type)) {
                $checking_array['bus_type'] = $bus_type;
                $data['bus_type'] = $bus_type;
            }

            $all_route = $this->Common_model->get_all_info('create_root');
            $row_count = 0;
            foreach ($all_route as $single_route) {
                $row_count++;
                $data["route_name" . $row_count] = $single_route->root;
                $data["bus_type" . $row_count] = $single_route->bus_type;
                $data["distance_km" . $row_count] = $single_route->distance_km;
                $data["fuel_need" . $row_count] = $single_route->fuel_need;
                $data["fuel_cost_per_trip" . $row_count] = $single_route->fuel_cost_per_trip;

                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['root'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $total_actual_trip = count($this->Common_model->multil_column_group_by_where("income", $checking_array,
                                array("date", "trip_time", "bus_type", "root")));
                $data["total_trip" . $row_count] = $total_actual_trip;
                $all_ticket_result = $this->Common_model->get_all_info_by_array("income", $checking_array);
                $pass_qty = 0;
                foreach ($all_ticket_result as $single_ticket_result) {
                    $pass_qty += $single_ticket_result->quantity;
                }
                $data["total_pass_qty" . $row_count] = $pass_qty;
                if ($total_actual_trip == 0) {
                    $data["avg_pass_per_trip" . $row_count] = 0;
                } else {
                    $data["avg_pass_per_trip" . $row_count] = $pass_qty / $total_actual_trip;
                }
                $data["fare" . $row_count] = $single_route->fare;
                $total_sales = $single_route->fare * $pass_qty;
                $data["total_sales" . $row_count] = $total_sales;

                //Daily Bus Expense Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['root'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $daily_bus_exp_result = $this->Common_model->multil_column_group_by_where("income", $checking_array,
                        array("date", "trip_time", "bus_type", "root"));

                $daily_bus_exp_amount = 0;
                foreach ($daily_bus_exp_result as $single) {
                    $daily_bus_exp_amount += $single->amount;
                }
                $data["daily_bus_exp_amount" . $row_count] = $daily_bus_exp_amount;

                //Daily Voucher Expense Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['root'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $checking_array['head<>'] = "Depreciation";
                $checking_array['head<>'] = "Bank Loan Interest";
                $daily_vou_exp_result = $this->Common_model->get_all_info_by_array("expense", $checking_array);

                $daily_vou_exp_amount = 0;
                foreach ($daily_vou_exp_result as $single) {
                    $daily_vou_exp_amount += $single->amount;
                }
                $data["daily_vou_exp_amount" . $row_count] = $daily_vou_exp_amount;

                //Daily Bus Maintenance Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['purchase_date>='] = $date_from;
                    $checking_array['purchase_date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['route'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $daily_bus_maint_result = $this->Common_model->get_all_info_by_array("insert_bus_maintenance", $checking_array);

                $daily_bus_maint_amount = 0;
                foreach ($daily_bus_maint_result as $single) {
                    $daily_bus_maint_amount += $single->amount;
                }
                $data["daily_bus_maint_amount" . $row_count] = $daily_bus_maint_amount;

                //Daily General Maintenance Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['root'] = $single_route->root;

                $daily_gen_maint_amount = 0;

                if ($single_route->bus_type == "Bus NAC") {
                    $daily_gen_maint_result = $this->Common_model->get_all_info_by_array("general_maintenance", $checking_array);
                    foreach ($daily_gen_maint_result as $single) {
                        $daily_gen_maint_amount += $single->amount;
                    }
                }
                $data["daily_gen_maint_amount" . $row_count] = $daily_gen_maint_amount;

                //Credit Parts Expense Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['purchase_date>='] = $date_from;
                    $checking_array['purchase_date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['user_unit'] = $bus_type;
                }
                $checking_array['route'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $credit_parts_result = $this->Common_model->get_all_info_by_array("insert_spare_parts_info", $checking_array);

                $credit_parts_amount = 0;
                foreach ($credit_parts_result as $single) {
                    $credit_parts_amount += $single->amount;
                }
                $data["credit_parts_amount" . $row_count] = $credit_parts_amount;

                //Credit General Expense Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                $checking_array['route'] = $single_route->root;
                $checking_array['bus_type'] = $single_route->bus_type;


                $credit_general_amount = 0;

//                if ($single_route->bus_type == "Bus NAC") {
                $credit_general_result = $this->Common_model->get_all_info_by_array("insert_credit_general", $checking_array);
                foreach ($credit_general_result as $single) {
                    $credit_general_amount += $single->amount;
                }
//                }

                $data["credit_general_amount" . $row_count] = $credit_general_amount;
                //Cash Parts Expense Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['user_unit'] = $bus_type;
                }
                $checking_array['route'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $checking_array['cash_type'] = "payment_parts";
                $cash_parts_result = $this->Common_model->get_all_info_by_array("petty_cash", $checking_array);

                $cash_parts_amount = 0;
                foreach ($cash_parts_result as $single) {
                    $cash_parts_amount += $single->amount;
                }
                $data["cash_parts_amount" . $row_count] = $cash_parts_amount;
                //Cash General Expense Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                $checking_array['route'] = $single_route->root;
                $checking_array['cash_type'] = "payment_general";

                $cash_general_amount = 0;

                if ($single_route->bus_type == "Bus NAC") {
                    $cash_general_result = $this->Common_model->get_all_info_by_array("petty_cash", $checking_array);
                    foreach ($cash_general_result as $single) {
                        $cash_general_amount += $single->amount;
                    }
                }
                $data["cash_general_amount" . $row_count] = $cash_general_amount;

                //Total Expense
                $total_expense = $daily_bus_exp_amount + $daily_vou_exp_amount + $daily_bus_maint_amount + $daily_gen_maint_amount +
                        $credit_parts_amount + $credit_general_amount + $cash_parts_amount + $cash_general_amount;
                $data["total_expenses" . $row_count] = $total_expense;

                //Depreciation Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['root'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $checking_array['head'] = "Depreciation";
                $depreciation_result = $this->Common_model->get_all_info_by_array("dep_bank", $checking_array);

                $depreciation_amount = 0;
                foreach ($depreciation_result as $single) {
                    $depreciation_amount += $single->amount;
                }
                $data["depreciation_amount" . $row_count] = $depreciation_amount;

                //Bank Loan Result
                $checking_array = array();
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                }
                if (!empty($bus_type)) {
                    $checking_array['bus_type'] = $bus_type;
                }
                $checking_array['root'] = $single_route->root;
                $checking_array['vehicle_type'] = $single_route->bus_type;
                $checking_array['head'] = "Bank Loan Interest";
                $bank_loan_result = $this->Common_model->get_all_info_by_array("dep_bank", $checking_array);

                $bank_loan_amount = 0;
                foreach ($bank_loan_result as $single) {
                    $bank_loan_amount += $single->amount;
                }
                $data["bank_loan_amount" . $row_count] = $bank_loan_amount;
                $total_expense_with_dep_bank = $total_expense + $depreciation_amount + $bank_loan_amount;
                $data["total_expense_with_dep_bank" . $row_count] = $total_expense_with_dep_bank;
                $accounting_profit = $total_sales - $total_expense_with_dep_bank;
                $data["accounting_profit" . $row_count] = $accounting_profit;
                $data["cash_profit_with_dep" . $row_count] = $accounting_profit + $depreciation_amount;

                if ($total_actual_trip == 0) {
                    $data["accounting_profit_per_trip" . $row_count] = 0;
                    $data["cash_profit_per_trip" . $row_count] = 0;
                } else {
                    $data["accounting_profit_per_trip" . $row_count] = round(($accounting_profit / $total_actual_trip), 2);
                    $data["cash_profit_per_trip" . $row_count] = round((($accounting_profit + $depreciation_amount) / $total_actual_trip), 2);
                }
            }
            $data["count_it"] = $row_count;
            $this->load->view('admin/show_profit_loss_accounts', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_route_line_wise_amount() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $root = $this->input->post('root');
            $result = $this->Common_model->get_allinfo_byid('create_line_expenses', 'route', $root);
            $total = 0;
            if (empty($result)) {
                $total = 0;
            } else {
                foreach ($result as $info) {
                    $total += $info->amount;
                }
            }
            echo $total;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_routewise_amount() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $root = $this->input->post('root');
            $sub_root = $this->input->post('sub_root');
            $vehicle_reg_no = $this->input->post('bus');
            $counter = $this->input->post('counter');
            $result = $this->Common_model->get_allinfo_byid('vehicle_details', 'registration_no', $vehicle_reg_no);
            foreach ($result as $r) {
                $bus_type = $r->vehicle_type;
            }
            if (empty($sub_root)) {
                $checking_array = array(
                    'bus_type' => $bus_type,
                    'root' => $root
                );
                $result = $this->Common_model->get_all_info_by_array('create_root', $checking_array);
            } else {
                $checking_array = array(
                    'bus_type' => $bus_type,
                    'root' => $root,
                    'sub_root' => $sub_root
                );
                $result = $this->Common_model->get_all_info_by_array('create_sub_root', $checking_array);
            }

            if (empty($result)) {
                $fare = 0;
            } else {
                foreach ($result as $info) {
                    $now_date = date("Y-m-d");
                    $now_time = date("H:i:s");
                    $fare = $info->fare;
                    $change_date_from = $info->change_date_from;
                    $change_time_from = date('H:i', strtotime($info->change_time_from));
                    $final_from = new DateTime($change_date_from . ' ' . $change_time_from);
                    $change_date_to = $info->change_date_to;
                    $change_time_to = date('H:i', strtotime($info->change_time_to));
                    $final_to = new DateTime($change_date_to . ' ' . $change_time_to);
                    $main_date_time = new DateTime($now_date . ' ' . $now_time);
                    $change_fare = $info->change_fare;
                }
                if ($final_from <= $main_date_time && $main_date_time <= $final_to) {
                    $fare = $change_fare;
                }
            }

            $checking_array = array(
                'counter_name' => $counter,
                'root' => $root
            );
            $result = $this->Common_model->get_all_info_by_array('create_counter', $checking_array);
            foreach ($result as $r) {
                $commission_type = $r->commission_type;
                $commission_percentage = $r->commission_percentage;
                $commission_amount = $r->commission_amount;
            }
            if (empty($result) || $commission_type == "no") {
                echo $fare;
            } elseif ($commission_type == "percentage") {
                echo number_format($fare - ($fare * ($commission_percentage / 100)), 2);
            } elseif ($commission_type == "amount") {
                echo $fare - $commission_amount;
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_route_wise_line_expenses() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $data['all_root'] = $this->Common_model->get_distinct_value("root", "create_root");
            $search_by_route = $this->input->post('search_by_route');
            $count = 0;
            if (empty($search_by_route)) {
                foreach ($data['all_root'] as $info) {
                    $count++;
                    $data['single_route' . $count] = $info->root;
                    $data['single_route_info' . $count] = $this->Common_model->get_allinfo_byid('create_line_expenses', 'route', $info->root);
                }
            } else {
                $count++;
                $data['single_route' . $count] = $search_by_route;
                $data['single_route_info' . $count] = $this->Common_model->get_allinfo_byid('create_line_expenses', 'route', $search_by_route);
            }
            $data['count_it'] = $count;
            $this->load->view('admin/get_route_wise_line_expenses', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_petty_cash_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $cash_type = $this->input->post('cash_type');
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $counter = $this->input->post('counter');
            if ($cash_type == "new_all") {
                $checking_array = array();
                $data['date_range'] = "";
                $data['counter_name'] = "";
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                    $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
                }
                if (!empty($counter)) {
                    $checking_array['counter'] = $counter;
                    $data['counter_name'] = $counter;
                }
                $checking_array['cash_type'] = "payment_general";
                $all_result = $this->Common_model->get_all_info_by_array("petty_cash", $checking_array);
                $total_general = 0;
                foreach ($all_result as $single_result) {
                    $total_general += $single_result->amount;
                }
                $data["total_general"] = $total_general;

                $checking_array_2 = array();

                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array_2['date>='] = $date_from;
                    $checking_array_2['date<='] = $date_to;
                    $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
                }
                if (!empty($counter)) {
                    $checking_array_2['counter'] = $counter;
                    $data['counter_name'] = $counter;
                }
                $checking_array['cash_type'] = "payment_parts";
                $all_result = $this->Common_model->get_all_info_by_array("petty_cash", $checking_array);
                $total_spare = 0;
                foreach ($all_result as $single_result) {
                    $total_spare += $single_result->amount;
                }
                $data["total_spare"] = $total_spare;
                $data["total"] = $total_general + $total_spare;
                $this->load->view('admin/show_all_cash', $data);
            } elseif ($cash_type == "all") {
                $checking_array = array();
                $data['date_range'] = "";
                $data['show_counter'] = "";
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                    $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
                }
                if (!empty($counter)) {
                    $checking_array['counter'] = $counter;
                    $data['show_counter'] = "($counter)";
                }
                $checking_array['cash_type'] = "receive";
                $result = $this->Common_model->get_all_info_by_array("petty_cash", $checking_array);
                $count_in = 0;
                foreach ($result as $info) {
                    $count_in++;
                    $data['income_id' . $count_in] = $info->record_id;
                    $data['income_date' . $count_in] = $info->date;
                    $data['income_counter' . $count_in] = $info->counter;
                    $data['income_amount' . $count_in] = $info->amount;
                    $data['income_head' . $count_in] = $info->receive_head;
                }
//                unset($checking_array['cash_type']);
                $checking_array['cash_type'] = "payment_general";
                $result = $this->Common_model->get_all_info_by_array("petty_cash", $checking_array);
                $count_ex = 0;
                foreach ($result as $info) {
                    $count_ex++;
                    $data['expense_id' . $count_ex] = $info->record_id;
                    $data['expense_date' . $count_ex] = $info->date;
                    $data['expense_counter' . $count_ex] = $info->counter;
                    $data['expense_route' . $count_ex] = $info->route;
                    $data['expense_head' . $count_ex] = $info->payment_head;
                    $data['expense_transport' . $count_ex] = $info->transport_no;
                    $data['expense_parts_name' . $count_ex] = $info->parts_name;
                    $data['expense_parts_category' . $count_ex] = $info->parts_category;
                    $data['expense_installation_date' . $count_ex] = $info->installation_date;
                    $data['expense_expired_date' . $count_ex] = $info->expired_date;
                    $data['expense_amount' . $count_ex] = $info->amount;
                    $data['expense_repair_status' . $count_ex] = $info->repair_status;
                }

                if ($count_in >= $count_ex) {
                    $diff = $count_in - $count_ex;
                    for ($i = 1; $i <= $diff; $i++) {
                        $count_ex++;
                        $data['expense_id' . $count_ex] = "";
                        $data['expense_date' . $count_ex] = "";
                        $data['expense_counter' . $count_ex] = "";
                        $data['expense_route' . $count_ex] = "";
                        $data['expense_head' . $count_ex] = "";
                        $data['expense_transport' . $count_ex] = "";
                        $data['expense_parts_name' . $count_ex] = "";
                        $data['expense_parts_category' . $count_ex] = "";
                        $data['expense_installation_date' . $count_ex] = "";
                        $data['expense_expired_date' . $count_ex] = "";
                        $data['expense_amount' . $count_ex] = 0;
                        $data['expense_repair_status' . $count_ex] = "";
                    }
                    $data["count_it"] = $count_ex;
                } else if ($count_ex > $count_in) {
                    $diff = $count_ex - $count_in;
                    for ($i = 1; $i <= $diff; $i++) {
                        $count_in++;
                        $data['income_id' . $count_in] = "";
                        $data['income_date' . $count_in] = "";
                        $data['income_counter' . $count_in] = "";
                        $data['income_amount' . $count_in] = 0;
                        $data['income_head' . $count_in] = "";
                    }
                    $data["count_it"] = $count_in;
                }
                $data["cash_type"] = $cash_type;
                $this->load->view('admin/get_petty_cash_report', $data);
            } else if ($cash_type == "balance_spare_parts") {
                $checking_array = array();
                $data['date_range'] = "";
                $data['counter_name'] = "";
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                    $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
                }
                if (!empty($counter)) {
                    $checking_array['counter'] = $counter;
                    $data['counter_name'] = $counter;
                }
                $checking_array['cash_type'] = "payment_parts";
                $all_vehicle_list = $this->Common_model->get_distinct_value_where("transport_no", "petty_cash", $checking_array);
                $all_parts_list = $this->Common_model->get_distinct_value_where("parts_name", "petty_cash", $checking_array);
                $row = 0;
                foreach ($all_vehicle_list as $single_vehicle) {
                    $row++;
                    $data["car_no" . $row] = $single_vehicle->transport_no;
                    $column = 0;
                    foreach ($all_parts_list as $single_parts) {
                        $column++;
                        $checking_array['transport_no'] = $single_vehicle->transport_no;
                        $checking_array['parts_name'] = $single_parts->parts_name;
                        $value_result = $this->Common_model->get_all_info_by_array("petty_cash", $checking_array);
                        $amount_value = 0;
                        foreach ($value_result as $single_value) {
                            $amount_value += $single_value->amount;
                        }
                        $data["value" . $row . "c" . $column] = $amount_value;
                    }
                }
                $data["all_vehicle_list"] = $all_vehicle_list;
                $data["all_parts_list"] = $all_parts_list;
                $this->load->view('admin/show_parts_info_petty_cash', $data);
            } else if ($cash_type == "receive") {
                $income_head = $this->input->post('income_head');
                $checking_array = array();
                $data['date_range'] = "";
                $data['show_counter'] = "";
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                    $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
                }
                if (!empty($counter)) {
                    $checking_array['counter'] = $counter;
                    $data['show_counter'] = "($counter)";
                }
                if (!empty($income_head)) {
                    $checking_array['receive_head'] = $income_head;
                }
                $checking_array['cash_type'] = $cash_type;

                $result = $this->Common_model->get_all_info_by_array("petty_cash", $checking_array);
                $count_in = 0;
                foreach ($result as $info) {
                    $count_in++;
                    $data['income_id' . $count_in] = $info->record_id;
                    $data['income_date' . $count_in] = $info->date;
                    $data['income_counter' . $count_in] = $info->counter;
                    $data['income_amount' . $count_in] = $info->amount;
                    $data['income_head' . $count_in] = $info->receive_head;
                }
                $data["count_it"] = $count_in;
                $data["cash_type"] = $cash_type;
                $this->load->view('admin/get_petty_cash_report', $data);
            } else if ($cash_type == "payment_general") {
                $expense_head = $this->input->post('expense_head');
                $root1 = $this->input->post('root1');

                $checking_array = array();
                $data['date_range'] = "";
                $data['show_counter'] = "";
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                    $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
                }
                if (!empty($counter)) {
                    $checking_array['counter'] = $counter;
                    $data['show_counter'] = "($counter)";
                }
                if (!empty($expense_head)) {
                    $checking_array['payment_head'] = $expense_head;
                }
                if (!empty($root1)) {
                    $checking_array['route'] = $root1;
                }
                $checking_array['cash_type'] = $cash_type;

                $result = $this->Common_model->get_all_info_by_array("petty_cash", $checking_array);
                $count_ex = 0;
                foreach ($result as $info) {
                    $count_ex++;
                    $data['expense_id' . $count_ex] = $info->record_id;
                    $data['expense_date' . $count_ex] = $info->date;
                    $data['expense_counter' . $count_ex] = $info->counter;
                    $data['expense_route' . $count_ex] = $info->route;
                    $data['expense_head' . $count_ex] = $info->payment_head;
                    $data['expense_amount' . $count_ex] = $info->amount;
                }
                $data["count_it"] = $count_ex;
                $data["cash_type"] = $cash_type;
                $this->load->view('admin/get_petty_cash_report', $data);
            } else if ($cash_type == "payment_parts") {
                $root2 = $this->input->post('root2');
                $vehicle_reg_no = $this->input->post('vehicle_reg_no');
                $parts_name = $this->input->post('parts_name');
                $installation_date = $this->input->post('installation_date');
                $expired_date = $this->input->post('expired_date');

                $checking_array = array();
                $data['date_range'] = "";
                $data['show_counter'] = "";
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                    $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
                }
                if (!empty($counter)) {
                    $checking_array['counter'] = $counter;
                    $data['show_counter'] = "($counter)";
                }
                if (!empty($root2)) {
                    $checking_array['route'] = $root2;
                }
                if (!empty($vehicle_reg_no)) {
                    $checking_array['transport_no'] = $vehicle_reg_no;
                }
                if (!empty($parts_name)) {
                    $parts_name = explode("###", $this->input->post('parts_name'));
                    $checking_array['parts_name'] = $parts_name[0];
                    $checking_array['parts_category'] = $parts_name[1];
                }
                if (!empty($installation_date)) {
                    $checking_array['installation_date'] = $installation_date;
                }
                if (!empty($expired_date)) {
                    $checking_array['expired_date'] = $expired_date;
                }
                $checking_array['cash_type'] = $cash_type;

                $result = $this->Common_model->get_all_info_by_array("petty_cash", $checking_array);
                $count_ex = 0;
                foreach ($result as $info) {
                    $count_ex++;
                    $data['expense_id' . $count_ex] = $info->record_id;
                    $data['expense_date' . $count_ex] = $info->date;
                    $data['expense_counter' . $count_ex] = $info->counter;
                    $data['expense_route' . $count_ex] = $info->route;
                    $data['expense_transport' . $count_ex] = $info->transport_no;
                    $data['expense_parts_name' . $count_ex] = $info->parts_name;
                    $data['expense_parts_category' . $count_ex] = $info->parts_category;
                    $data['expense_installation_date' . $count_ex] = $info->installation_date;
                    $data['expense_expired_date' . $count_ex] = $info->expired_date;
                    $data['expense_amount' . $count_ex] = $info->amount;
                    $data['expense_repair_status' . $count_ex] = $info->repair_status;
                }
                $data["count_it"] = $count_ex;
                $data["cash_type"] = $cash_type;
                $this->load->view('admin/get_petty_cash_report', $data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_petty_cash_our_search() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $our_search = $this->input->post('our_search');
            $result = $this->Common_model->get_petty_cash_income($our_search);
            $count_in = 0;
            foreach ($result as $info) {
                if (!empty($info->receive_head)) {
                    $count_in++;
                    $data['income_id' . $count_in] = $info->record_id;
                    $data['income_date' . $count_in] = $info->date;
                    $data['income_counter' . $count_in] = $info->counter;
                    $data['income_amount' . $count_in] = $info->amount;
                    $data['income_head' . $count_in] = $info->receive_head;
                }
            }

            $result = $this->Common_model->get_petty_cash_expense($our_search);
            $count_ex = 0;
            foreach ($result as $info) {
                if (!empty($info->payment_head) || !empty($info->transport_no)) {
                    $count_ex++;
                    $data['expense_id' . $count_ex] = $info->record_id;
                    $data['expense_date' . $count_ex] = $info->date;
                    $data['expense_counter' . $count_ex] = $info->counter;
                    $data['expense_route' . $count_ex] = $info->route;
                    $data['expense_head' . $count_ex] = $info->payment_head;
                    $data['expense_transport' . $count_ex] = $info->transport_no;
                    $data['expense_parts_name' . $count_ex] = $info->parts_name;
                    $data['expense_parts_category' . $count_ex] = $info->parts_category;
                    $data['expense_installation_date' . $count_ex] = $info->installation_date;
                    $data['expense_expired_date' . $count_ex] = $info->expired_date;
                    $data['expense_amount' . $count_ex] = $info->amount;
                    $data['expense_repair_status' . $count_ex] = $info->repair_status;
                }
            }

            if ($count_in >= $count_ex) {
                $diff = $count_in - $count_ex;
                for ($i = 1; $i <= $diff; $i++) {
                    $count_ex++;
                    $data['expense_id' . $count_ex] = "";
                    $data['expense_date' . $count_ex] = "";
                    $data['expense_counter' . $count_ex] = "";
                    $data['expense_route' . $count_ex] = "";
                    $data['expense_head' . $count_ex] = "";
                    $data['expense_transport' . $count_ex] = "";
                    $data['expense_parts_name' . $count_ex] = "";
                    $data['expense_parts_category' . $count_ex] = "";
                    $data['expense_installation_date' . $count_ex] = "";
                    $data['expense_expired_date' . $count_ex] = "";
                    $data['expense_amount' . $count_ex] = "";
                    $data['expense_repair_status' . $count_ex] = "";
                }
                $data["count_it"] = $count_ex;
            } else if ($count_ex > $count_in) {
                $diff = $count_ex - $count_in;
                for ($i = 1; $i <= $diff; $i++) {
                    $count_in++;
                    $data['income_id' . $count_in] = "";
                    $data['income_date' . $count_in] = "";
                    $data['income_counter' . $count_in] = "";
                    $data['income_amount' . $count_in] = "";
                    $data['income_head' . $count_in] = "";
                }
                $data["count_it"] = $count_in;
            }
            $this->load->view('admin/get_petty_cash_our_search', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_head_office_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');

            $checking_array = array();
            $data['date_range'] = "";
            if (!empty($date_from) && !empty($date_to)) {
                $checking_array['date>='] = $date_from;
                $checking_array['date<='] = $date_to;
                $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
            }

            $data["all_value"] = $this->Common_model->get_all_info_by_array("head_office_petty_cash", $checking_array);

            $this->load->view('admin/show_head_office_report', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_expense_our_search() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $our_search = $this->input->post('our_search');
            $result = $this->Common_model->expense_our_search($our_search);
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $data['expense_result' . $count] = $this->Common_model->get_allinfo_byid('expense', 'entry_no', $info->entry_no);
            }

            $data['count_it'] = $count;
            $this->load->view('admin/get_expense_our_search', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_income_our_search() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $our_search = $this->input->post('our_search');
            $result = $this->Common_model->income_our_search($our_search);
            $count = 0;
            foreach ($result as $info) {
                $count++;
                $data['income_result' . $count] = $this->Common_model->get_allinfo_byid('income', 'entry_no', $info->entry_no);
            }

            $data['count_it'] = $count;
            $this->load->view('admin/get_income_our_search', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_trial_balance() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $bus_type = $this->input->post('bus_type');
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $root = $this->input->post('root');

            if (empty($bus_type) || empty($date_from) || empty($date_to) || empty($root)) {
                echo "<p style='color: red; font-size: 20px;'>Please Select Required Field.</p>";
            } else {
                //Income Details
                $all_income_head = array("Ticket Sales", "Road Ticket Sales");
                //Route Loop Starts
                $route_count = 0;
                foreach ($root as $one_root) {
                    $route_count++;
                    //NAC Bus Result
                    $nac_total_trip = 0;
                    $start_date = $date_from;
                    while (strtotime($start_date) <= strtotime($date_to)) {
                        $checking_array = array(
                            'bus_type' => $bus_type,
                            'date' => $start_date,
                            'root' => $one_root,
                            'vehicle_type' => "Bus NAC"
                        );
                        $nac_total_trip += count($this->Common_model->get_distinct_value_where("trip_time", "income", $checking_array));
                        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                    }
                    $data['nac_total_trip' . $route_count] = $nac_total_trip;
                    $count = 0;
                    foreach ($all_income_head as $all_income_info) {
                        $count++;
                        $checking_array = array(
                            'head' => $all_income_info,
                            'bus_type' => $bus_type,
                            'date>=' => $date_from,
                            'date<=' => $date_to,
                            'root' => $one_root,
                            'vehicle_type' => "Bus NAC"
                        );
                        $data['nac_income_head' . $route_count . "c" . $count] = $all_income_info;
                        $result = $this->Common_model->get_all_info_by_array("income", $checking_array);
                        $ind_amount = 0;
                        foreach ($result as $info) {
                            $ind_amount += $info->amount;
                        }
                        $data['nac_head_amount' . $route_count . "c" . $count] = $ind_amount;
                    }

                    //AC Bus Result
                    $ac_total_trip = 0;
                    $start_date = $date_from;
                    while (strtotime($start_date) <= strtotime($date_to)) {
                        $checking_array = array(
                            'bus_type' => $bus_type,
                            'date' => $start_date,
                            'root' => $one_root,
                            'vehicle_type' => "Bus AC"
                        );
                        $ac_total_trip += count($this->Common_model->get_distinct_value_where("trip_time", "income", $checking_array));
                        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                    }
                    $data['ac_total_trip' . $route_count] = $ac_total_trip;
                    $count = 0;
                    foreach ($all_income_head as $all_income_info) {
                        $count++;
                        $checking_array = array(
                            'head' => $all_income_info,
                            'bus_type' => $bus_type,
                            'date>=' => $date_from,
                            'date<=' => $date_to,
                            'root' => $one_root,
                            'vehicle_type' => "Bus AC"
                        );
                        $data['ac_income_head' . $route_count . "c" . $count] = $all_income_info;
                        $result = $this->Common_model->get_all_info_by_array("income", $checking_array);
                        $ind_amount = 0;
                        foreach ($result as $info) {
                            $ind_amount += $info->amount;
                        }
                        $data['ac_head_amount' . $route_count . "c" . $count] = $ind_amount;
                    }

                    //AC Bus Result
                    $rm2_total_trip = 0;
                    $start_date = $date_from;
                    while (strtotime($start_date) <= strtotime($date_to)) {
                        $checking_array = array(
                            'bus_type' => $bus_type,
                            'date' => $start_date,
                            'root' => $one_root,
                            'vehicle_type' => "Bus RM-2"
                        );
                        $rm2_total_trip += count($this->Common_model->get_distinct_value_where("trip_time", "income", $checking_array));
                        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                    }
                    $data['rm2_total_trip' . $route_count] = $rm2_total_trip;
                    $count = 0;
                    foreach ($all_income_head as $all_income_info) {
                        $count++;
                        $checking_array = array(
                            'head' => $all_income_info,
                            'bus_type' => $bus_type,
                            'date>=' => $date_from,
                            'date<=' => $date_to,
                            'root' => $one_root,
                            'vehicle_type' => "Bus RM-2"
                        );
                        $data['rm2_income_head' . $route_count . "c" . $count] = $all_income_info;
                        $result = $this->Common_model->get_all_info_by_array("income", $checking_array);
                        $ind_amount = 0;
                        foreach ($result as $info) {
                            $ind_amount += $info->amount;
                        }
                        $data['rm2_head_amount' . $route_count . "c" . $count] = $ind_amount;
                    }

                    $data['count_it'] = count($all_income_head);


                    //Others Received
                    $others_received_count = 0;
                    $others_received_result = $this->Common_model->get_all_info("income_head");
                    $data["all_received_head"] = $others_received_result;
                    foreach ($others_received_result as $ind_received) {
                        if ($ind_received->head != "Ticket Sales" && $ind_received->head != "Road Ticket Sales") {
                            $others_received_count++;
                            $checking_array = array(
                                'head' => $ind_received->head,
                                'bus_type' => $bus_type,
                                'date>=' => $date_from,
                                'date<=' => $date_to,
                                'root' => $one_root
                            );
                            $result = $this->Common_model->get_all_info_by_array("income", $checking_array);
                            $ind_amount = 0;
                            foreach ($result as $info) {
                                $ind_amount += $info->amount;
                            }
                            $data['others_received' . $route_count . "o" . $others_received_count] = $ind_amount;
                        }
                    }

                    //Expenditure Details
                    //Line Expenses NAC Bus
                    $multiple_column_array = array('bus_type', 'date', 'root', 'trip_time');

                    $checking_array = array(
                        'bus_type' => $bus_type,
                        'date>=' => $date_from,
                        'date<=' => $date_to,
                        'root' => $one_root,
                        'vehicle_type' => "Bus NAC"
                    );
                    $result = $this->Common_model->multil_column_group_by_where("income", $checking_array, $multiple_column_array);
                    $ind_amount = 0;
                    foreach ($result as $info) {
                        $ind_amount += $info->line_expense_amount;
                    }
                    $data['nac_line_exp_vou' . $route_count] = count($result);
                    $data['nac_line_exp_amount' . $route_count] = $ind_amount;

                    //Line Expenses AC Bus
                    $checking_array = array(
                        'bus_type' => $bus_type,
                        'date>=' => $date_from,
                        'date<=' => $date_to,
                        'root' => $one_root,
                        'vehicle_type' => "Bus AC"
                    );
                    $result = $this->Common_model->multil_column_group_by_where("income", $checking_array, $multiple_column_array);
                    $ind_amount = 0;
                    foreach ($result as $info) {
                        $ind_amount += $info->line_expense_amount;
                    }
                    $data['ac_line_exp_vou' . $route_count] = count($result);
                    $data['ac_line_exp_amount' . $route_count] = $ind_amount;

                    //Line Expenses RM-2 Bus
                    $checking_array = array(
                        'bus_type' => $bus_type,
                        'date>=' => $date_from,
                        'date<=' => $date_to,
                        'root' => $one_root,
                        'vehicle_type' => "Bus RM-2"
                    );
                    $result = $this->Common_model->multil_column_group_by_where("income", $checking_array, $multiple_column_array);
                    $ind_amount = 0;
                    foreach ($result as $info) {
                        $ind_amount += $info->line_expense_amount;
                    }
                    $data['rm2_line_exp_vou' . $route_count] = count($result);
                    $data['rm2_line_exp_amount' . $route_count] = $ind_amount;
                }

                //All General Expenses
                $all_expense_head = $this->Common_model->get_all_info('expense_head');
                $count = 0;
                foreach ($all_expense_head as $all_expense_info) {
                    $ind_amount = 0;
                    $ind_vou = 0;
                    foreach ($root as $one_root) {
                        $checking_array = array(
                            'head' => $all_expense_info->head,
                            'bus_type' => $bus_type,
                            'date>=' => $date_from,
                            'date<=' => $date_to,
                            'root' => $one_root
                        );
                        $result = $this->Common_model->get_all_info_by_array("expense", $checking_array);
                        foreach ($result as $info) {
                            $ind_amount += $info->amount;
                            $ind_vou += $info->quantity;
                        }
                    }
                    if ($ind_amount != 0) {
                        $count++;
                        $data["expense_head" . $count] = $all_expense_info->head;
                        $data['expense_vou' . $count] = $ind_vou;
                        $data['expense_amount' . $count] = $ind_amount;
                    }
                }
                $data["count_expense"] = $count;

                //General Maintenance Expense
                $all_expense_head = $this->Common_model->get_all_info('expense_head');
                $count = 0;
                foreach ($all_expense_head as $all_expense_info) {
                    $ind_amount = 0;
                    $ind_vou = 0;
                    foreach ($root as $one_root) {
                        $checking_array = array(
                            'head' => $all_expense_info->head,
                            'bus_type' => $bus_type,
                            'date>=' => $date_from,
                            'date<=' => $date_to,
                            'root' => $one_root
                        );
                        $result = $this->Common_model->get_all_info_by_array("general_maintenance", $checking_array);
                        foreach ($result as $info) {
                            $ind_amount += $info->amount;
                            $ind_vou += $info->voucher_num;
                        }
                    }
                    if ($ind_amount != 0) {
                        $count++;
                        $data["maintenance_expense_head" . $count] = $all_expense_info->head;
                        $data['maintenance_expense_vou' . $count] = $ind_vou;
                        $data['maintenance_expense_amount' . $count] = $ind_amount;
                    }
                }
                $data["general_maintenance_count"] = $count;

                //Parts Expense Details
                $all_bus_result = $this->Common_model->get_allinfo_byid('vehicle_details', 'owner_unit', $bus_type);
                $count = 0;
                foreach ($all_bus_result as $all_bus_info) {
                    $ind_amount = 0;
                    $ind_vou = 0;
                    foreach ($root as $one_root) {
                        $checking_array = array(
                            'vehicle_no' => $all_bus_info->registration_no,
                            'owner_unit' => $bus_type,
                            'purchase_date>=' => $date_from,
                            'purchase_date<=' => $date_to,
                            'route' => $one_root
                        );
                        $result = $this->Common_model->get_all_info_by_array("insert_bus_maintenance", $checking_array);
                        foreach ($result as $info) {
                            $ind_amount += $info->amount;
                            $ind_vou += $info->qty;
                        }
                    }
                    if ($ind_amount != 0) {
                        $count++;
                        $data["parts_expense_vehicle_no" . $count] = $all_bus_info->registration_no;
                        $data["parts_expense_vehicle_type" . $count] = $all_bus_info->vehicle_type;
                        $data['parts_expense_vou' . $count] = $ind_vou;
                        $data['parts_expense_amount' . $count] = $ind_amount;
                    }
                }
                $data["parts_count_expense"] = $count;

                $data['public_bus_type'] = $bus_type;
                $data['date_from'] = $date_from;
                $data['date_to'] = $date_to;
                $data['route'] = $root;
                $data["total_route"] = $route_count;
                $this->load->view('admin/trial_balance_report', $data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_daily_position() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $bus_type = $this->input->post('bus_type');
            $date = $this->input->post('date');
            $root = $this->input->post('root');

            if (empty($bus_type) || empty($date) || empty($root)) {
                echo "<p style='color: red; font-size: 20px;'>Please Select Required Field.</p>";
            } else {
                //Income Details
                $all_income_head = array("Ticket Sales", "Road Ticket Sales");
                //NAC Bus Result
                $route_count = 0;
                foreach ($root as $one_root) {
                    $route_count++;
                    $checking_array = array(
                        'bus_type' => $bus_type,
                        'date' => $date,
                        'root' => $one_root,
                        'vehicle_type' => "Bus NAC"
                    );
                    $data['nac_total_trip' . $route_count] = count($this->Common_model->get_distinct_value_where("trip_time", "income", $checking_array));
                    $count = 0;
                    foreach ($all_income_head as $all_income_info) {
                        $count++;
                        $checking_array = array(
                            'head' => $all_income_info,
                            'bus_type' => $bus_type,
                            'date' => $date,
                            'root' => $one_root,
                            'vehicle_type' => "Bus NAC"
                        );
                        $data['nac_income_head' . $route_count . "c" . $count] = $all_income_info;
                        $result = $this->Common_model->get_all_info_by_array("income", $checking_array);
                        $ind_amount = 0;
                        foreach ($result as $info) {
                            $ind_amount += $info->amount;
                        }
                        $data['nac_head_amount' . $route_count . "c" . $count] = $ind_amount;
                    }

                    //AC Bus Result
                    $checking_array = array(
                        'bus_type' => $bus_type,
                        'date' => $date,
                        'root' => $one_root,
                        'vehicle_type' => "Bus AC"
                    );

                    $data['ac_total_trip' . $route_count] = count($this->Common_model->get_distinct_value_where("trip_time", "income", $checking_array));
                    $count = 0;
                    foreach ($all_income_head as $all_income_info) {
                        $count++;
                        $checking_array = array(
                            'head' => $all_income_info,
                            'bus_type' => $bus_type,
                            'date' => $date,
                            'root' => $one_root,
                            'vehicle_type' => "Bus AC"
                        );
                        $data['ac_income_head' . $route_count . "c" . $count] = $all_income_info;
                        $result = $this->Common_model->get_all_info_by_array("income", $checking_array);
                        $ind_amount = 0;
                        foreach ($result as $info) {
                            $ind_amount += $info->amount;
                        }
                        $data['ac_head_amount' . $route_count . "c" . $count] = $ind_amount;
                    }
                    //RM-2 Bus Result
                    $checking_array = array(
                        'bus_type' => $bus_type,
                        'date' => $date,
                        'root' => $one_root,
                        'vehicle_type' => "Bus RM-2"
                    );

                    $data['rm2_total_trip' . $route_count] = count($this->Common_model->get_distinct_value_where("trip_time", "income", $checking_array));
                    $count = 0;
                    foreach ($all_income_head as $all_income_info) {
                        $count++;
                        $checking_array = array(
                            'head' => $all_income_info,
                            'bus_type' => $bus_type,
                            'date' => $date,
                            'root' => $one_root,
                            'vehicle_type' => "Bus RM-2"
                        );
                        $data['rm2_income_head' . $route_count . "c" . $count] = $all_income_info;
                        $result = $this->Common_model->get_all_info_by_array("income", $checking_array);
                        $ind_amount = 0;
                        foreach ($result as $info) {
                            $ind_amount += $info->amount;
                        }
                        $data['rm2_head_amount' . $route_count . "c" . $count] = $ind_amount;
                    }

                    $data['count_it'] = count($all_income_head);


                    //Others Received
                    $others_received_count = 0;
                    $others_received_result = $this->Common_model->get_all_info("income_head");
                    $data["all_received_head"] = $others_received_result;
                    foreach ($others_received_result as $ind_received) {
                        if ($ind_received->head != "Road Ticket Sales" && $ind_received->head != "Ticket Sales") {
                            $others_received_count++;
                            $checking_array = array(
                                'head' => $ind_received->head,
                                'bus_type' => $bus_type,
                                'date' => $date,
                                'root' => $one_root
                            );
                            $result = $this->Common_model->get_all_info_by_array("income", $checking_array);
                            $ind_amount = 0;
                            foreach ($result as $info) {
                                $ind_amount += $info->amount;
                            }
                            $data['others_received' . $route_count . "o" . $others_received_count] = $ind_amount;
                        }
                    }

                    //Expenditure Details
                    //Line Expenses NAC Bus
                    $multiple_column_array = array('bus_type', 'date', 'root', 'trip_time');

                    $checking_array = array(
                        'bus_type' => $bus_type,
                        'date' => $date,
                        'root' => $one_root,
                        'vehicle_type' => "Bus NAC"
                    );
                    $result = $this->Common_model->multil_column_group_by_where("income", $checking_array, $multiple_column_array);
                    $ind_amount = 0;
                    foreach ($result as $info) {
                        $ind_amount += $info->line_expense_amount;
                    }
                    $data['nac_line_exp_vou' . $route_count] = count($result);
                    $data['nac_line_exp_amount' . $route_count] = $ind_amount;

                    //Line Expenses AC Bus
                    $checking_array = array(
                        'bus_type' => $bus_type,
                        'date' => $date,
                        'root' => $one_root,
                        'vehicle_type' => "Bus AC"
                    );
                    $result = $this->Common_model->multil_column_group_by_where("income", $checking_array, $multiple_column_array);
                    $ind_amount = 0;
                    foreach ($result as $info) {
                        $ind_amount += $info->line_expense_amount;
                    }
                    $data['ac_line_exp_vou' . $route_count] = count($result);
                    $data['ac_line_exp_amount' . $route_count] = $ind_amount;

                    //Line Expenses RM-2 Bus
                    $checking_array = array(
                        'bus_type' => $bus_type,
                        'date' => $date,
                        'root' => $one_root,
                        'vehicle_type' => "Bus RM-2"
                    );
                    $result = $this->Common_model->multil_column_group_by_where("income", $checking_array, $multiple_column_array);
                    $ind_amount = 0;
                    foreach ($result as $info) {
                        $ind_amount += $info->line_expense_amount;
                    }
                    $data['rm2_line_exp_vou' . $route_count] = count($result);
                    $data['rm2_line_exp_amount' . $route_count] = $ind_amount;
                }

                //All General Expenses
                $all_expense_head = $this->Common_model->get_all_info('expense_head');
                $count = 0;
                foreach ($all_expense_head as $all_expense_info) {
                    $ind_amount = 0;
                    $ind_vou = 0;
                    foreach ($root as $one_root) {
                        $checking_array = array(
                            'head' => $all_expense_info->head,
                            'bus_type' => $bus_type,
                            'date' => $date,
                            'root' => $one_root
                        );
                        $result = $this->Common_model->get_all_info_by_array("expense", $checking_array);
                        foreach ($result as $info) {
                            $ind_amount += $info->amount;
                            $ind_vou += $info->quantity;
                        }
                    }
                    if ($ind_amount != 0) {
                        $count++;
                        $data["expense_head" . $count] = $all_expense_info->head;
                        $data['expense_vou' . $count] = $ind_vou;
                        $data['expense_amount' . $count] = $ind_amount;
                    }
                }
                $data["count_expense"] = $count;

                //General Maintenance Expense
                $all_expense_head = $this->Common_model->get_all_info('expense_head');
                $count = 0;
                foreach ($all_expense_head as $all_expense_info) {
                    $ind_amount = 0;
                    $ind_vou = 0;
                    foreach ($root as $one_root) {
                        $checking_array = array(
                            'head' => $all_expense_info->head,
                            'bus_type' => $bus_type,
                            'date' => $date,
                            'root' => $one_root
                        );
                        $result = $this->Common_model->get_all_info_by_array("general_maintenance", $checking_array);
                        foreach ($result as $info) {
                            $ind_amount += $info->amount;
                            $ind_vou += $info->voucher_num;
                        }
                    }
                    if ($ind_amount != 0) {
                        $count++;
                        $data["maintenance_expense_head" . $count] = $all_expense_info->head;
                        $data['maintenance_expense_vou' . $count] = $ind_vou;
                        $data['maintenance_expense_amount' . $count] = $ind_amount;
                    }
                }
                $data["general_maintenance_count"] = $count;
                //Parts Expense Details
                $all_bus_result = $this->Common_model->get_allinfo_byid('vehicle_details', 'owner_unit', $bus_type);
                $count = 0;
                foreach ($all_bus_result as $all_bus_info) {
                    $ind_amount = 0;
                    $ind_vou = 0;
                    foreach ($root as $one_root) {
                        $checking_array = array(
                            'vehicle_no' => $all_bus_info->registration_no,
                            'owner_unit' => $bus_type,
                            'purchase_date' => $date,
                            'route' => $one_root
                        );
                        $result = $this->Common_model->get_all_info_by_array("insert_bus_maintenance", $checking_array);
                        foreach ($result as $info) {
                            $ind_amount += $info->amount;
                            $ind_vou += $info->qty;
                        }
                    }
                    if ($ind_amount != 0) {
                        $count++;
                        $data["parts_expense_vehicle_no" . $count] = $all_bus_info->registration_no;
                        $data["parts_expense_vehicle_type" . $count] = $all_bus_info->vehicle_type;
                        $data['parts_expense_vou' . $count] = $ind_vou;
                        $data['parts_expense_amount' . $count] = $ind_amount;
                    }
                }
                $data["parts_count_expense"] = $count;

                $data['public_bus_type'] = $bus_type;
                $data['date'] = $date;
                $data['route'] = $root;
                $data["total_route"] = $route_count;
                $this->load->view('admin/daily_cash_report', $data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_value_live_input() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $start_value = $this->input->post('start_value');
            $table_name = $this->input->post('table_name');
            $column_name = $this->input->post('column_name');

            if (!empty($start_value)) {
                $result = $this->Common_model->get_value_like_start($table_name, $column_name, $start_value);
                $live_list = "";
                if (!empty($result)) {
                    foreach ($result as $info) {
                        $live_list .= $info->$column_name . "<br>";
                    }
                    echo $live_list;
                }
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_transport_by_owner() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $owner_unit = $this->input->post('owner_unit');

            if ($owner_unit == "Azmeri Enterprise") {
                $owner_unit = "Golden Line Paribahan";
            }

            $data["all_vehicle"] = $this->Common_model->get_allinfo_byid('vehicle_details', 'user_unit', $owner_unit);
            if (!empty($data["all_vehicle"])) {
                $this->load->view('admin/get_transport_by_owner', $data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_daily_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $bus_type = $this->input->post('bus_type');
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $root = $this->input->post('root');
            $vehicle_type = $this->input->post('vehicle_type');


            if (empty($bus_type) || empty($date_from) || empty($date_to) || empty($root) || empty($vehicle_type)) {
                echo "<p style='color: red; font-size: 20px;'>Please Select Required Field.</p>";
            } else {
                $this->load->view('admin/daily_report_logo_print', $data);
                //Assgning Bus type
                if ($bus_type == "All") {
                    $flag = 2;
                    $bus_type = "Golden Line Paribahan";
                } else {
                    $flag = 1;
                }

                $total_pass = 0;
                $total_income = 0;
                $total_line_expense = 0;

                //Looping through Bus type
                for ($i = 1; $i <= $flag; $i++) {
                    if ($i == 2) {
                        $bus_type = "Azmeri Enterprise";
                    }
                    //Looping through Vehicle type
                    $start_date = $date_from;
                    $headline_count = 0;
                    while (strtotime($start_date) <= strtotime($date_to)) {
                        //Individual Date
                        //Assgning Vehicle type
                        if ($vehicle_type == "All") {
                            $flag_two = 3;
                            $vehicle_new_type = "Bus NAC";
                        } else {
                            $flag_two = 1;
                            $vehicle_new_type = $vehicle_type;
                        }
                        $date_count = 0;
                        for ($j = 1; $j <= $flag_two; $j++) {
                            if ($j == 2) {
                                $vehicle_new_type = "Bus AC";
                            } elseif ($j == 3) {
                                $vehicle_new_type = "Bus RM-2";
                            }

                            $get_counter = array(
                                'bus_type' => $bus_type,
                                'date' => $start_date,
                                'root' => $root,
                                'vehicle_type' => $vehicle_new_type,
                                'head' => "Ticket Sales"
                            );

                            $get_counter_result = $this->Common_model->get_distinct_value_where("counter", "income", $get_counter);
                            $counter_num = 0;

                            $result = $this->Common_model->get_distinct_value_orderby_trip_time("trip_time", "income");
                            $trip_time_count = 0;
                            //Individual Trip Time
                            foreach ($result as $res) {
                                //Dhaka ticket qty & amount in that trip time
                                $checking_array_two = array(
                                    'trip_time' => $res->trip_time,
                                    'bus_type' => $bus_type,
                                    'date' => $start_date,
                                    'root' => $root,
                                    'vehicle_type' => $vehicle_new_type
                                );
                                //Road ticket qty & amount in that trip time
                                $checking_array_three = array(
                                    'trip_time' => $res->trip_time,
                                    'bus_type' => $bus_type,
                                    'date' => $start_date,
                                    'root' => $root,
                                    'vehicle_type' => $vehicle_new_type,
                                    'head' => "Road Ticket Sales"
                                );
                                //Free ticket qty in that trip time
                                $checking_array_four = array(
                                    'trip_time' => $res->trip_time,
                                    'bus_type' => $bus_type,
                                    'date' => $start_date,
                                    'root' => $root,
                                    'vehicle_type' => $vehicle_new_type,
                                    'head' => "Free Ticket"
                                );

                                $result_two = $this->Common_model->get_all_info_by_array_where_in("income", $checking_array_two);
                                $result_three = $this->Common_model->get_all_info_by_array("income", $checking_array_three);
                                $result_four = $this->Common_model->get_all_info_by_array("income", $checking_array_four);
                                if (!empty($result_two) || !empty($result_three) || !empty($result_four)) {
                                    $trip_time_count++;
                                    $data['trip_time' . $trip_time_count] = $res->trip_time;
                                    $counter_num = 0;
                                    foreach ($get_counter_result as $get_counter_info) {
                                        $counter_num++;
                                        $data["counter_name" . $counter_num] = $get_counter_info->counter;
                                        $get_timewise_counter = array(
                                            'bus_type' => $bus_type,
                                            'date' => $start_date,
                                            'root' => $root,
                                            'vehicle_type' => $vehicle_new_type,
                                            'counter' => $get_counter_info->counter,
                                            'trip_time' => $res->trip_time,
                                            'head' => "Ticket Sales"
                                        );
                                        $time_counter = $this->Common_model->get_all_info_by_array_where_in("income", $get_timewise_counter);
                                        if (empty($time_counter)) {
                                            $data["single_counter_pass" . $trip_time_count . $counter_num] = 0;
                                            $data["single_counter_amount" . $trip_time_count . $counter_num] = 0;
                                        } else {
                                            foreach ($time_counter as $single_time_counter) {
                                                $data["single_counter_pass" . $trip_time_count . $counter_num] = $single_time_counter->quantity;
                                                $data["single_counter_amount" . $trip_time_count . $counter_num] = $single_time_counter->amount;
                                            }
                                        }
                                    }
                                    $bus_no = $supervisor = $coach_no = "";
                                    $line_expenses_amount = 0;
                                    $dhaka_qty = $dhaka_amount = $road_qty = $road_amount = $free_qty = $free_amount = 0;
                                    //Getting Value from Dhaka Result
                                    $counter_name = "";
                                    if (!empty($result_two)) {
                                        foreach ($result_two as $info_two) {
                                            $bus_no = $info_two->vehicle_reg_no;
                                            $supervisor = $info_two->supervisor;
                                            $coach_no = $info_two->coach_no;
                                            $line_expenses_amount = $info_two->line_expense_amount;
                                            $dhaka_qty += $info_two->quantity;
                                            $dhaka_amount += $info_two->amount;
                                        }
                                    }
                                    //Getting Value from Road Result
                                    if (!empty($result_three)) {
                                        foreach ($result_three as $info_three) {
                                            $bus_no = $info_three->vehicle_reg_no;
                                            $supervisor = $info_three->supervisor;
                                            $coach_no = $info_three->coach_no;
                                            $line_expenses_amount = $info_three->line_expense_amount;
                                            $road_qty += $info_three->quantity;
                                            $road_amount += $info_three->amount;
                                        }
                                    }
                                    //Getting Value from Free Result
                                    if (!empty($result_four)) {
                                        foreach ($result_four as $info_four) {
                                            $bus_no = $info_four->vehicle_reg_no;
                                            $supervisor = $info_four->supervisor;
                                            $coach_no = $info_four->coach_no;
                                            $line_expenses_amount = $info_four->line_expense_amount;
                                            $free_qty += $info_four->quantity;
                                            $free_amount += $info_four->amount;
                                        }
                                    }
                                    //Assiging all values
                                    $total_pass += $dhaka_qty + $road_qty + $free_qty;
                                    $total_income += $dhaka_amount + $road_amount + $free_amount;
                                    $total_line_expense += $line_expenses_amount;
//                              
                                    $data['bus_no' . $trip_time_count] = $bus_no;
                                    $data['sup_name' . $trip_time_count] = $supervisor;
                                    $data['coach_no' . $trip_time_count] = $coach_no;
                                    $data['line_expenses' . $trip_time_count] = $line_expenses_amount;
                                    $data['dhaka_pass' . $trip_time_count] = $dhaka_qty;
                                    $data['dhaka_taka' . $trip_time_count] = $dhaka_amount;
                                    $data['road_pass' . $trip_time_count] = $road_qty;
                                    $data['road_taka' . $trip_time_count] = $road_amount;
                                    $data['free_pass' . $trip_time_count] = $free_qty;
                                    $data['free_taka' . $trip_time_count] = $free_amount;
                                }
                            }
                            $data['total_trip_time'] = $trip_time_count;
                            $data["counter_num"] = $counter_num;
                            $data['root_name'] = "$vehicle_new_type $root";

                            //Only first time show date
                            if ($trip_time_count != 0) {
                                $date_count++;
                            }
                            if ($date_count == 1) {
                                $data['date_headline'] = "Date: " . date('d-M-y', strtotime($start_date));
                                $date_count++;
                            } else {
                                $data['date_headline'] = "";
                            }

                            //Only first time show date
                            if ($trip_time_count != 0) {
                                $headline_count++;
                            }
                            if ($headline_count == 1) {
                                $data['headline'] = "$bus_type Daily Income & Expenditure Summery";
                                $headline_count++;
                            } else {
                                $data['headline'] = "";
                            }
                            $this->load->view('admin/get_daily_report', $data);
                        }
                        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                    }
                }
                $data["total_pass"] = $total_pass;
                $data["total_income"] = $total_income;
                $data["total_line_expense"] = $total_line_expense;
                $this->load->view('admin/daily_report_footer', $data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_bill_register_payment() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $supplier = $this->input->post('supplier');
            $data['supplier'] = $supplier;

            $result = $this->Common_model->get_allinfo_byid('create_supplier', 'record_id', $supplier);
            if (!empty($result)) {
                foreach ($result as $res) {
                    $supplier_name = $res->supplier_name;
                }
            } else {
                $supplier_name = '';
            }
            $data['supplier_name'] = $supplier_name;

            $array_check = array(
                'supplier_id' => $supplier,
                'payment_status !=' => 1,
            );

            $data['all_value'] = $this->Common_model->get_all_info_by_array("bill_register_info", $array_check);
            $data['all_bank'] = $this->Common_model->get_all_info('create_bank');

            $this->load->view('admin/show_bill_register_payment', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_bill_payment() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $supplier = $this->input->post('supplier');
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $data['supplier'] = $supplier;

            $result = $this->Common_model->get_allinfo_byid('create_supplier', 'record_id', $supplier);
            if (!empty($result)) {
                foreach ($result as $res) {
                    $supplier_name = $res->supplier_name;
                }
            } else {
                $supplier_name = '';
            }
            $data['supplier_name'] = $supplier_name;


            $array_check = array();
            if (!empty($supplier)) {
                $array_check["supplier_id"] = $supplier;
            }

            if (!empty($date_from)) {
                $array_check["date >="] = $date_from;
            }

            if (!empty($date_to)) {
                $array_check["date <="] = $date_to;
            }

            $data['all_value'] = $this->Common_model->get_all_info_by_array("bill_payment_register", $array_check);

            $this->load->view('admin/show_bill_payment', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_bill_register() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $supplier = $this->input->post('supplier');
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $data['supplier'] = $supplier;

            $result = $this->Common_model->get_allinfo_byid('create_supplier', 'record_id', $supplier);
            if (!empty($result)) {
                foreach ($result as $res) {
                    $supplier_name = $res->supplier_name;
                }
            } else {
                $supplier_name = '';
            }
            $data['supplier_name'] = $supplier_name;

            $array_check = array();
            $data['date_range'] = "";
            $data["income_head"] = "All Income Info.";
            if (!empty($date_from) && !empty($date_to)) {
                $array_check['date>='] = $date_from;
                $array_check['date<='] = $date_to;
                $data['date_range'] = date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to));
            }
            if (!empty($supplier)) {
                $array_check["supplier_id"] = $supplier;
            }


            $data['all_value'] = $this->Common_model->get_all_info_by_array("bill_register_info", $array_check);

            $this->load->view('admin/show_bill_register', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_transport_type_ownerwise() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $owner_unit = $this->input->post('owner_unit');
            $result = $this->Common_model->get_allinfo_byid("create_owner_user_unit", 'company_name', $owner_unit);
            foreach ($result as $info) {
                $temp_vehicle_type = explode("###", $info->transport_type);
            }
            $option = "<option value=''>-- Select --</option>";
            foreach ($temp_vehicle_type as $info) {
                if (!empty($info)) {
                    $option .= "<option value='$info'>$info</option>";
                }
            }
            echo $option;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_change_vehicle_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $vehicle_reg_no = $this->input->post('vehicle_reg_no');
            $result = $this->Common_model->get_allinfo_byid("vehicle_details", 'registration_no', $vehicle_reg_no);
            foreach ($result as $info) {
                $data["owner_unit"] = $info->owner_unit;
                $data["user_unit"] = $info->user_unit;
                $data["user_name"] = $info->user_name;
                $data["driver_name"] = $info->driver_name;
                $data["parking_location"] = $info->parking_location;
                $data["user_id"] = $info->user;
                $data["driver_id"] = $info->driver;
            }
            $data['all_unit'] = $this->Common_model->get_all_info_orderby('create_owner_user_unit', 'company_name', 'ASC');
            $checking_array = array(
                'designation' => 'Driver'
            );

            $data['all_driver'] = $this->Common_model->get_data_wherearray_orderby('insert_staff', $checking_array, "staff_name");
            $checking_array = array(
                'designation !=' => 'Driver'
            );
            $data['all_user'] = $this->Common_model->get_data_wherearray_orderby('insert_staff', $checking_array, "staff_name");

            $this->load->view('admin/get_change_vehicle', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_parts_unit() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $parts_name = $this->input->post('parts_name');
            $result = $this->Common_model->get_allinfo_byid("create_parts_name", 'parts_name', $parts_name);
            foreach ($result as $info) {
                $unit = $info->unit;
            }
            echo $unit;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_parts_number() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $parts_name = $this->input->post('parts_name');
            $result = $this->Common_model->get_allinfo_byid("create_parts_name", 'parts_name', $parts_name);
            foreach ($result as $info) {
                $parts_number = explode("###", $info->parts_number);
            }
            $options = "<option value=''>-- Select --</option>";
            foreach ($parts_number as $info) {
                $options .= "<option value='$info'>$info</option>";
            }
            echo $options;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function get_parts_name() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $parts_category = $this->input->post('parts_category');
            $result = $this->Common_model->get_allinfo_byid("create_parts_name", 'parts_category', $parts_category);
            $options = array();
            $options[''] = "-- Select --";
            foreach ($result as $info) {
                $options[$info->parts_name] = $info->parts_name;
            }
            $js = array(
                'id' => 'parts_name'
            );
            $dropdown = form_dropdown('parts_name', $options, '', $js);
            echo $dropdown;
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_expirewise_vehicle() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $paper_name = $this->input->post('paper_name');
            $days_no = $this->input->post('days_no');
            $today_date = date('Y-m-d');

            $array_check = array();
            if (!empty($paper_name)) {
                $array_check['papers_name'] = $paper_name;
            }

            if (empty($days_no)) {
                $data['msg'] = '';
                $data['all_value'] = array();
                $this->load->view('admin/show_expirewise_vehicle', $data);
            } elseif ($days_no == "expired") {
                $array_check['expire_date<'] = $today_date;
                $data['all_value'] = $this->Common_model->get_all_info_by_array("insert_papers_info", $array_check);
                $count = 0;
                foreach ($data['all_value'] as $info) {
                    $vehicle_no = $info->vehicle_reg_no;
                    $result = $this->Common_model->get_allinfo_byid("vehicle_details", 'registration_no', $vehicle_no);
                    if (!empty($result)) {
                        $count++;
                        foreach ($result as $res) {
                            $data['vehicle_no' . $count] = $res->registration_no;
                            $data['vehicle_type' . $count] = $res->vehicle_type . " [" . $res->company_name . "] [" . $res->vehicle_name . "]";
                            $data['owner' . $count] = $res->owner_unit;
                            $data['userco' . $count] = $res->user_unit;
                            $data['user' . $count] = $res->user_name;
                            $data['driver' . $count] = $res->driver_name;
                        }

                        $data['expire' . $count] = $info->expire_date;
                        $earlier = new DateTime($today_date);
                        $later = new DateTime($info->expire_date);

                        $diff = $later->diff($earlier)->format("%a");
                        $data['val' . $count] = ($diff - 1) . " Days";
                    }
                }
                $data['c'] = $count;
                $data['msg'] = 'Expired ' . $paper_name . " Papers";
                $this->load->view('admin/show_expirewise_vehicle', $data);
            } else {
                $array_check['expire_date>='] = date('Y-m-d');
                $array_check['expire_date<='] = date('Y-m-d', strtotime('+' . ($days_no - 1) . ' Days'));
                $data['all_value'] = $this->Common_model->get_all_info_by_array("insert_papers_info", $array_check);
                $count = 0;
                foreach ($data['all_value'] as $info) {
                    $vehicle_no = $info->vehicle_reg_no;
                    $current_date = date('Y-m-d');
                    $result = $this->Common_model->get_allinfo_byid("vehicle_details", 'registration_no', $vehicle_no);
                    if (!empty($result)) {
                        $count++;
                        foreach ($result as $res) {
                            $data['vehicle_no' . $count] = $res->registration_no;
                            $data['vehicle_type' . $count] = $res->vehicle_type . " [" . $res->company_name . "] [" . $res->vehicle_name . "]";
                            $data['owner' . $count] = $res->owner_unit;
                            $data['userco' . $count] = $res->user_unit;
                            $data['user' . $count] = $res->user_name;
                            $data['driver' . $count] = $res->driver_name;
                        }

                        $data['expire' . $count] = $info->expire_date;
                        $ses = strtotime($info->expire_date);
                        $suru = strtotime($current_date);
                        $datediff = $ses - $suru;
                        $data['val' . $count] = (floor($datediff / (60 * 60 * 24)) + 1) . " Days After";
                    }
                }
                $data['c'] = $count;
                $data['msg'] = $paper_name . ' Papers Validity (' . $days_no . " Days)";
                $this->load->view('admin/show_expirewise_vehicle', $data);
            }
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
            $root = $this->input->post('root');
            $vehicle_reg_no = $this->input->post('vehicle_reg_no');
            $trip_time = $this->input->post('trip_time');
            if (!empty($date_from) && !empty($date_to)) {
                $start_date = $date_from;
                $count1 = 0;
                while (strtotime($date_from) <= strtotime($date_to)) {
                    $result = $this->Common_model->get_allinfo_byid('vehicle_details', 'vehicle_type', 'Bus');
                    foreach ($result as $res) {
                        $count1++;
                        $data['vehicle' . $count1] = $res->registration_no;
                        $checking_array = array(
                            'vehicle_reg_no' => $res->registration_no,
                            'date' => $date_from
                        );
                        $result1 = $this->Common_model->get_all_info_by_array('income', $checking_array);
                        $income_sum = 0;
                        $root_time_concat_i = "";
                        $agerbar_entry_i = "";
                        foreach ($result1 as $info) {
                            if ($info->entry_no != $agerbar_entry_i) {
                                $root_time_concat_i .= $info->root . " [" . date('h:i A', strtotime($info->trip_time))
                                        . "]<br>";
                            }

                            if (empty($info->amount)) {
                                $income_sum += 0;
                            } else {
                                $income_sum += $info->amount;
                            }
                            $agerbar_entry_i = $info->entry_no;
                        }

                        $result2 = $this->Common_model->get_all_info_by_array('expense', $checking_array);
                        $expense_sum = 0;
                        $root_time_concat_e = "";
                        $agerbar_entry_e = "";
                        foreach ($result2 as $info) {
                            if ($info->entry_no != $agerbar_entry_e) {
                                $root_time_concat_e .= $info->root . " [" . date('h:i A', strtotime($info->trip_time))
                                        . "]<br>";
                            }
                            if (empty($info->amount)) {
                                $expense_sum += 0;
                            } else {
                                $expense_sum += $info->amount;
                            }
                            $agerbar_entry_e = $info->entry_no;
                        }

                        $data['date' . $count1] = $date_from;
                        $data['income' . $count1] = $income_sum;
                        $data['expense' . $count1] = $expense_sum;
                        $data['root_time_i' . $count1] = $root_time_concat_i;
                        $data['root_time_e' . $count1] = $root_time_concat_e;
                    }


                    $date_from = date("Y-m-d", strtotime("+1 day", strtotime($date_from)));
                }

                $data['date_range'] = date('d F Y', strtotime($start_date)) . " - " . date('d F Y', strtotime($date_to));
                $data['count_it'] = $count1;
            } else {
                $data['date_range'] = "";
                $data['count_it'] = "";
            }

            $this->load->view('admin/show_report_info', $data);
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
            $root = $this->input->post('root');
            $income_head = $this->input->post('income_head');
            $counter = $this->input->post('counter');
            $bus_type = $this->input->post('bus_type');

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
            if (!empty($root)) {
                $checking_array['root'] = $root;
            }
            if (!empty($counter)) {
                $checking_array['counter'] = $counter;
            }
            if (!empty($bus_type)) {
                $checking_array['bus_type'] = $bus_type;
            }
            $data["all_value"] = $this->Common_model->get_all_info_by_array("income", $checking_array);

            $this->load->view('admin/get_income_report', $data);
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
            $root = $this->input->post('root');
            $expense_head = $this->input->post('expense_head');
            $counter = $this->input->post('counter');

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
            if (!empty($root)) {
                $checking_array['root'] = $root;
            }
            if (!empty($counter)) {
                $checking_array['counter'] = $counter;
            }
            $data["all_value"] = $this->Common_model->get_all_info_by_array("expense", $checking_array);

            $this->load->view('admin/get_expense_report', $data);
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
            $root = $this->input->post('root');
            $vehicle_reg_no = $this->input->post('vehicle_reg_no');
            $trip_time = $this->input->post('trip_time');

            $data['date_range'] = "";
            $data["vehicle_reg_no"] = "";
            $check = array();
            $check_papers = array();
            $check_vehicle = array();
            $check_logsheet = array();
            $check_lubricant = array();
            $check_parts = array();
            if (!empty($date_from) && !empty($date_to)) {
                $data['date_range'] = date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to));

                $check['date>='] = $date_from;
                $check['date<='] = $date_to;

                $check_papers['issue_date>='] = $date_from;
                $check_papers['issue_date<='] = $date_to;

                $check_vehicle['purchase_date>='] = $date_from;
                $check_vehicle['purchase_date<='] = $date_to;

                $check_logsheet['date>='] = $date_from;
                $check_logsheet['date<='] = $date_to;

                $check_lubricant['date>='] = $date_from;
                $check_lubricant['date<='] = $date_to;

                $check_parts['purchase_date>='] = $date_from;
                $check_parts['purchase_date<='] = $date_to;
            }
            if (!empty($vehicle_reg_no)) {
                $data["vehicle_reg_no"] = "Vehicle Reg. No: " . $vehicle_reg_no;
                $check['vehicle_reg_no'] = $vehicle_reg_no;
                $check_papers['vehicle_reg_no'] = $vehicle_reg_no;
                $check_vehicle['registration_no'] = $vehicle_reg_no;
                $check_logsheet['vehicle_reg_no'] = $vehicle_reg_no;
                $check_lubricant['vehicle_reg_no'] = $vehicle_reg_no;
                $check_parts['vehicle_no'] = $vehicle_reg_no;
            }

            //All Income
            $data['all_income'] = $this->Common_model->get_all_info_by_array("income", $check);

            //All Expense
            $data['all_expense'] = $this->Common_model->get_all_info_by_array("expense", $check);
            $data['all_papers'] = $this->Common_model->get_all_info_by_array("insert_papers_info", $check_papers);
            $data['all_log_sheet'] = $this->Common_model->get_all_info_by_array("insert_log_data", $check_logsheet);
            $data['all_lubricant'] = $this->Common_model->get_all_info_by_array("used_lub_info", $check_lubricant);
            $data['all_parts'] = $this->Common_model->get_all_info_by_array("insert_spare_parts_info", $check_parts);

            if (!empty($root)) {
                $check['root'] = $root;
                $data['all_income'] = $this->Common_model->get_all_info_by_array("income", $check);
                $data['all_expense'] = $this->Common_model->get_all_info_by_array("expense", $check);
                $data['all_papers'] = array();
                $data['all_log_sheet'] = array();
                $data['all_lubricant'] = array();
                $data['all_parts'] = array();
            }

            if (!empty($trip_time)) {
                $check['trip_time'] = $trip_time;
                $data['all_income'] = $this->Common_model->get_all_info_by_array("income", $check);
                $data['all_expense'] = $this->Common_model->get_all_info_by_array("expense", $check);
                $data['all_papers'] = array();
                $data['all_log_sheet'] = array();
                $data['all_lubricant'] = array();
                $data['all_parts'] = array();
            }
            $count = 0;
            foreach ($data['all_income'] as $info1) {
                $count++;
                $data['date' . $count] = $info1->date;
                $data['root' . $count] = $info1->root;
                $data['time' . $count] = $info1->trip_time;
                $data['vehicle_reg_no' . $count] = $info1->vehicle_reg_no;
                $data['particular' . $count] = $info1->head;
                $data['quantity' . $count] = $info1->quantity;
                $data['amount' . $count] = $info1->amount;
            }
            $count_ex = 0;
            foreach ($data['all_expense'] as $info1) {
                $count_ex++;
                $data['expense_date' . $count_ex] = $info1->date;
                $data['expense_root' . $count_ex] = $info1->root;
                $data['expense_time' . $count_ex] = $info1->trip_time;
                $data['expense_vehicle_reg_no' . $count_ex] = $info1->vehicle_reg_no;
                $data['expense_particular' . $count_ex] = $info1->head;
                $data['expense_quantity' . $count_ex] = $info1->quantity;
                $data['expense_amount' . $count_ex] = $info1->amount;
            }
            foreach ($data['all_papers'] as $info1) {
                $count_ex++;
                $data['expense_date' . $count_ex] = $info1->issue_date;
                $data['expense_root' . $count_ex] = "X";
                $data['expense_time' . $count_ex] = 'X';
                $data['expense_vehicle_reg_no' . $count_ex] = $info1->vehicle_reg_no;
                $data['expense_particular' . $count_ex] = $info1->papers_name;
                $data['expense_quantity' . $count_ex] = "1";
                $data['expense_amount' . $count_ex] = $info1->amount;
            }
            foreach ($data['all_log_sheet'] as $info1) {
                $count_ex++;
                $data['expense_date' . $count_ex] = $info1->date;
                $data['expense_root' . $count_ex] = "X";
                $data['expense_time' . $count_ex] = 'X';
                $data['expense_vehicle_reg_no' . $count_ex] = $info1->vehicle_reg_no;
                $data['expense_particular' . $count_ex] = "Log Sheet";
                $data['expense_quantity' . $count_ex] = $info1->quantity;
                $data['expense_amount' . $count_ex] = $info1->amount;
            }
            foreach ($data['all_lubricant'] as $info1) {
                $count_ex++;
                $data['expense_date' . $count_ex] = $info1->date;
                $data['expense_root' . $count_ex] = "X";
                $data['expense_time' . $count_ex] = 'X';
                $data['expense_vehicle_reg_no' . $count_ex] = $info1->vehicle_reg_no;
                $data['expense_particular' . $count_ex] = "Lubricant";
                $data['expense_quantity' . $count_ex] = $info1->quantity;
                $data['expense_amount' . $count_ex] = $info1->amount;
            }
            foreach ($data['all_parts'] as $info1) {
                $count_ex++;
                $data['expense_date' . $count_ex] = $info1->purchase_date;
                $data['expense_root' . $count_ex] = "X";
                $data['expense_time' . $count_ex] = 'X';
                $data['expense_vehicle_reg_no' . $count_ex] = $info1->vehicle_no;
                $data['expense_particular' . $count_ex] = $info1->parts_name;
                $data['expense_quantity' . $count_ex] = $info1->qty;
                $data['expense_amount' . $count_ex] = $info1->amount;
            }

            if ($count >= $count_ex) {
                $empty_range = $count - $count_ex;
                $start = $count_ex + 1;
                $finish = $count_ex + $empty_range;
                for ($i = $start; $i <= $finish; $i++) {
                    $data['expense_date' . $i] = "";
                    $data['expense_root' . $i] = "";
                    $data['expense_time' . $i] = '';
                    $data['expense_vehicle_reg_no' . $i] = "";
                    $data['expense_particular' . $i] = "";
                    $data['expense_quantity' . $i] = "";
                    $data['expense_amount' . $i] = "";
                }
                $data['count_it'] = $count;
            } else {
                $empty_range = $count_ex - $count;
                $start = $count + 1;
                $finish = $count + $empty_range;
                for ($i = $start; $i <= $finish; $i++) {
                    $data['date' . $i] = "";
                    $data['root' . $i] = "";
                    $data['time' . $i] = '';
                    $data['vehicle_reg_no' . $i] = "";
                    $data['particular' . $i] = "";
                    $data['quantity' . $i] = "";
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

    public function show_papers_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $vehicle_reg_no = $this->input->post('vehicle_reg_no');
            $array_check = array();
            if (!empty($vehicle_reg_no)) {
                $array_check["vehicle_reg_no"] = $vehicle_reg_no;
                $array["registration_no"] = $vehicle_reg_no;
                $result = $this->Common_model->get_all_info_by_array("vehicle_details", $array);
                foreach ($result as $info) {
                    $data['transport'] = $info->vehicle_type . " [" . $info->company_name . "] [" . $info->vehicle_name . "]";
                    $data['reg'] = $info->registration_no;
                    $data['owner_unit'] = $info->owner_unit;
                    $data['user_unit'] = $info->user_unit;
                    $data['user'] = $info->user_name . " [ID: " . $info->user . "]";
                    $data['driver'] = $info->driver_name . " [ID: " . $info->driver . "]";
                }
                $data['all_value'] = $this->Common_model->get_all_info_by_array("insert_papers_info", $array_check);
                $this->load->view('admin/show_papers_info_transportwise', $data);
            } else {
                echo "<p style='color: red; font-size: 20px;'>Please Select A Vehicle Reg. No.</p>";
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_log_data() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $vehicle_reg_no = $this->input->post('vehicle_reg_no');
            $user_unit = $this->input->post('user_unit');
            $user = $this->input->post('user');
            $driver = $this->input->post('driver');

            $array_check = array();
            if (!empty($vehicle_reg_no)) {
                $array_check["vehicle_reg_no"] = $vehicle_reg_no;
            }
            if (!empty($user_unit)) {
                $array_check["user_unit"] = $user_unit;
            }
            if (!empty($user)) {
                $array_check["user"] = $user;
            }
            if (!empty($driver)) {
                $array_check["driver"] = $driver;
            }
            if (!empty($date_from) && !empty($date_to)) {
                $array_check["date >="] = $date_from;
                $array_check["date <="] = $date_to;
            }
            $data['all_value'] = $this->Common_model->get_all_info_by_array("insert_log_data", $array_check);
            $this->load->view('admin/show_log_data', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function insert_spare_parts_details() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $result = $this->Common_model->find_last_id('entry_no', 'insert_spare_parts_info');
            if (!$result) {
                $entry_id = 1;
            } else {
                foreach ($result as $row) {
                    $entry_id = ($row->entry_no) + 1;
                }
            }

            $all_parts = $this->input->post('all_parts');

            foreach ($all_parts as $single_parts) {
                $vehicle_no = $single_parts[1];
                $result = $this->Common_model->get_allinfo_byid('vehicle_details', 'registration_no', $vehicle_no);
                if (!empty($result)) {
                    foreach ($result as $res) {
                        $owner_unit = $res->owner_unit;
                        $user_unit = $res->user_unit;
                        $vehicle_type = $res->vehicle_type;
                    }
                } else {
                    $owner_unit = "";
                    $user_unit = "";
                    $vehicle_type = "";
                }

                $purchase_date = $single_parts[2];
                $bill_no = $single_parts[3];
                $parts_category = $single_parts[5];
                $parts_name = $single_parts[6];
                $parts_number = $single_parts[7];
                $unit = $single_parts[8];
                $mileage = $single_parts[9];
                $site_name = $single_parts[10];
                $quantity = $single_parts[11];
                $rate = $single_parts[12];
                $amount = $single_parts[13];
                $install_date = $single_parts[14];
                $validity_date = $single_parts[15];
                $remarks = $single_parts[16];
                $counter_type = $single_parts[17];
                $supplier_type = $single_parts[18];
                $root = $single_parts[21];

                if ($counter_type == 1) {
                    $counter = $single_parts[0];

                    $result = $this->Common_model->find_last_id('record_id', 'create_counter');
                    if (!$result) {
                        $counter_id = 1;
                    } else {
                        foreach ($result as $row) {
                            $counter_id = ($row->record_id) + 1;
                        }
                    }
                    $insert_data = array(
                        'record_id' => $counter_id,
                        'counter_name' => $counter,
                    );
                    $this->Common_model->insert_data('create_counter', $insert_data);
                } else {
                    $counter_id = $single_parts[19];
                    $result = $this->Common_model->get_allinfo_byid('create_counter', 'record_id', $counter_id);
                    if (!empty($result)) {
                        foreach ($result as $res) {
                            $counter = $res->counter_name;
                        }
                    } else {
                        $counter = '';
                    }
                }

                if ($supplier_type == 1) {
                    $supplier = $single_parts[4];
                    $result = $this->Common_model->find_last_id('record_id', 'create_supplier');
                    if (!$result) {
                        $supplier_id = 1;
                    } else {
                        foreach ($result as $row) {
                            $supplier_id = ($row->record_id) + 1;
                        }
                    }
                    $insert_data = array(
                        'record_id' => $supplier_id,
                        'supplier_name' => $supplier,
                    );
                    $this->Common_model->insert_data('create_supplier', $insert_data);
                } else {
                    $supplier_id = $single_parts[20];
                    $result = $this->Common_model->get_allinfo_byid('create_supplier', 'record_id', $supplier_id);
                    if (!empty($result)) {
                        foreach ($result as $res) {
                            $supplier = $res->supplier_name;
                        }
                    } else {
                        $supplier = '';
                    }
                }

                $result = $this->Common_model->find_last_id('record_id', 'insert_spare_parts_info');
                if (!$result) {
                    $main_id = 1;
                } else {
                    foreach ($result as $row) {
                        $main_id = ($row->record_id) + 1;
                    }
                }
                $insert_data = array(
                    'record_id' => $main_id,
                    'counter' => $counter,
                    'counter_id' => $counter_id,
                    'bill_no' => $bill_no,
                    'entry_no' => $entry_id,
                    'purchase_date' => $purchase_date,
                    'install_date' => $install_date,
                    'parts_category' => $parts_category,
                    'parts_name' => $parts_name,
                    'parts_no' => $parts_number,
                    'unit' => $unit,
                    'supplier' => $supplier,
                    'supplier_id' => $supplier_id,
                    'mileage' => $mileage,
                    'vehicle_no' => $vehicle_no,
                    'site_name' => $site_name,
                    'rate' => $rate,
                    'qty' => $quantity,
                    'amount' => $amount,
                    'validity_date' => $validity_date,
                    'remarks' => $remarks,
                    'owner_unit' => $owner_unit,
                    'user_unit' => $user_unit,
                    'route' => $root,
                    'vehicle_type' => $vehicle_type
                );
                $this->Common_model->insert_data('insert_spare_parts_info', $insert_data);

                $insert_data = array(
                    'record_id' => $main_id,
                    'date' => $purchase_date,
                    'counter_name' => $counter,
                    'supplier_name' => $supplier,
                    'counter_id' => $counter_id,
                    'supplier_id' => $supplier_id,
                    'bill_no' => $bill_no,
                    'value' => $amount,
                    'due' => $amount,
                    'remarks' => "Unpaid",
                );
                $this->Common_model->insert_data('bill_register_info', $insert_data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function insert_bus_maintenance_details() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {

            $result = $this->Common_model->find_last_id('entry_no', 'insert_bus_maintenance');
            if (!$result) {
                $entry_id = 1;
            } else {
                foreach ($result as $row) {
                    $entry_id = ($row->entry_no) + 1;
                }
            }

            $all_parts = $this->input->post('all_parts');

            foreach ($all_parts as $single_parts) {
                $parts_category = $single_parts[0];
                $parts_name = $single_parts[1];
                $bus_type = $single_parts[2];
                $unit = $single_parts[3];
                $parts_number = $single_parts[4];
                $purchase_date = $single_parts[5];
                $vehicle_no = $single_parts[6];
                $result = $this->Common_model->get_allinfo_byid('vehicle_details', 'registration_no', $vehicle_no);
                if (!empty($result)) {
                    foreach ($result as $res) {
                        $owner_unit = $res->owner_unit;
                        $user_unit = $res->user_unit;
                        $vehicle_type = $res->vehicle_type;
                    }
                } else {
                    $owner_unit = "";
                    $user_unit = "";
                    $vehicle_type = "";
                }
                $root = $single_parts[7];
                $counter = $single_parts[8];
                $quantity = $single_parts[9];
                $rate = $single_parts[10];
                $amount = $single_parts[11];

                $result = $this->Common_model->find_last_id('record_id', 'insert_bus_maintenance');
                if (!$result) {
                    $main_id = 1;
                } else {
                    foreach ($result as $row) {
                        $main_id = ($row->record_id) + 1;
                    }
                }
                $insert_data = array(
                    'record_id' => $main_id,
                    'entry_no' => $entry_id,
                    'parts_category' => $parts_category,
                    'parts_name' => $parts_name,
                    'bus_type' => $bus_type,
                    'unit' => $unit,
                    'parts_no' => $parts_number,
                    'purchase_date' => $purchase_date,
                    'vehicle_no' => $vehicle_no,
                    'route' => $root,
                    'counter' => $counter,
                    'rate' => $rate,
                    'qty' => $quantity,
                    'amount' => $amount,
                    'owner_unit' => $owner_unit,
                    'user_unit' => $user_unit,
                    'vehicle_type' => $vehicle_type
                );
                $this->Common_model->insert_data('insert_bus_maintenance', $insert_data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_parts_info() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $expense_type = $this->input->post('expense_type');
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $counter = $this->input->post('counter');

            if ($expense_type == "All") {
                $checking_array = array();
                $data['date_range'] = "";
                $data['counter_name'] = "";
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                    $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
                }
                if (!empty($counter)) {
                    $checking_array['counter'] = $counter;
                    $data['counter_name'] = $counter;
                }
                $all_result = $this->Common_model->get_all_info_by_array("insert_credit_general", $checking_array);
                $total_general = 0;
                foreach ($all_result as $single_result) {
                    $total_general += $single_result->amount;
                }
                $data["total_general"] = $total_general;

                $checking_array_2 = array();

                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array_2['purchase_date>='] = $date_from;
                    $checking_array_2['purchase_date<='] = $date_to;
                    $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
                }
                if (!empty($counter)) {
                    $checking_array_2['counter'] = $counter;
                    $data['counter_name'] = $counter;
                }
                $all_vehicle_list = $this->Common_model->get_distinct_value_where("vehicle_no", "insert_spare_parts_info", $checking_array_2);
                $all_parts_list = $this->Common_model->get_distinct_value_where("parts_category", "insert_spare_parts_info", $checking_array_2);

                $total_spare = 0;

                foreach ($all_vehicle_list as $single_vehicle) {
                    foreach ($all_parts_list as $single_parts) {
                        $checking_array_2['vehicle_no'] = $single_vehicle->vehicle_no;
                        $checking_array_2['parts_category'] = $single_parts->parts_category;
                        $value_result = $this->Common_model->get_all_info_by_array("insert_spare_parts_info", $checking_array_2);
                        $amount_value = 0;
                        foreach ($value_result as $single_value) {
                            $amount_value += $single_value->amount;
                        }
                        $total_spare += $amount_value;
                    }
                }
                $data["total_spare"] = $total_spare;
                $data["total"] = $total_general + $total_spare;
                $this->load->view('admin/show_all', $data);
            } elseif ($expense_type == "general_expenses") {
                $checking_array = array();
                $data['date_range'] = "";
                $data['counter_name'] = "";
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['date>='] = $date_from;
                    $checking_array['date<='] = $date_to;
                    $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
                }
                if (!empty($counter)) {
                    $checking_array['counter'] = $counter;
                    $data['counter_name'] = $counter;
                }
                $data["all_result"] = $this->Common_model->get_all_info_by_array("insert_credit_general", $checking_array);
                $this->load->view('admin/show_credit_general', $data);
            } elseif ($expense_type == "parts_expenses") {
                $checking_array = array();
                $data['date_range'] = "";
                $data['counter_name'] = "";
                if (!empty($date_from) && !empty($date_to)) {
                    $checking_array['purchase_date>='] = $date_from;
                    $checking_array['purchase_date<='] = $date_to;
                    $data['date_range'] = "(" . date('d F', strtotime($date_from)) . " - " . date('d F', strtotime($date_to)) . ")";
                }
                if (!empty($counter)) {
                    $checking_array['counter'] = $counter;
                    $data['counter_name'] = $counter;
                }

                $all_vehicle_list = $this->Common_model->get_distinct_value_where("vehicle_no", "insert_spare_parts_info", $checking_array);
                $all_parts_list = $this->Common_model->get_distinct_value_where("parts_category", "insert_spare_parts_info", $checking_array);
                $row = 0;
                foreach ($all_vehicle_list as $single_vehicle) {
                    $row++;
                    $data["car_no" . $row] = $single_vehicle->vehicle_no;
                    $column = 0;
                    foreach ($all_parts_list as $single_parts) {
                        $column++;
                        $checking_array['vehicle_no'] = $single_vehicle->vehicle_no;
                        $checking_array['parts_category'] = $single_parts->parts_category;
                        $value_result = $this->Common_model->get_all_info_by_array("insert_spare_parts_info", $checking_array);
                        $amount_value = 0;
                        foreach ($value_result as $single_value) {
                            $amount_value += $single_value->amount;
                        }
                        $data["value" . $row . "c" . $column] = $amount_value;
                    }
                }
                $data["all_vehicle_list"] = $all_vehicle_list;
                $data["all_parts_list"] = $all_parts_list;
                $this->load->view('admin/show_parts_info', $data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function income_entry() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $all_income = $this->input->post('all_income');
            $result = $this->Common_model->find_last_id('entry_no', 'income');
            if (!$result) {
                $entry_no = 1;
            } else {
                foreach ($result as $row) {
                    $entry_no = ($row->entry_no) + 1;
                }
            }
            foreach ($all_income as $single_income) {
                $root = $single_income[1];
                $date = $single_income[2];
                $search_date = date('d/m/Y', strtotime($date));
                $bus_type = $single_income[3];
                $trip_time = $single_income[4];
                $coach_no = $single_income[5];
                $vehicle_reg_no = $single_income[6];

                if (empty($vehicle_reg_no)) {
                    $vehicle_type = "";
                } else {
                    $result = $this->Common_model->get_allinfo_byid('vehicle_details', 'registration_no', $vehicle_reg_no);
                    foreach ($result as $res) {
                        $vehicle_type = $res->vehicle_type;
                    }
                }
                $supervisor = $single_income[7];
                $income_head = $single_income[8];
                $counter = $single_income[9];
                $quantity = $single_income[10];
                $amount = $single_income[11];
                $line_expense_head = $single_income[12];
                $line_expense_amount = $single_income[13];
                $comment = $single_income[14];
                $s_type = $single_income[15];
                $c_type = $single_income[16];

                if ($s_type == 1) {
                    $result = $this->Common_model->find_last_id('record_id', 'insert_staff');
                    if (!$result) {
                        $max_id = 1;
                    } else {
                        foreach ($result as $row) {
                            $max_id = ($row->record_id) + 1;
                        }
                    }
                    $img_name = $max_id . ".jpg";
                    $insert_data = array(
                        'record_id' => $max_id,
                        'staff_name' => $supervisor,
                        'designation' => 'Supervisor',
                        'image' => $img_name,
                    );
                    $this->Common_model->insert_data('insert_staff', $insert_data);
                }

                if ($c_type == 1) {
                    $insert_data = array(
                        'coach_no' => $coach_no
                    );
                    $this->Common_model->insert_data('create_coach', $insert_data);
                }

                $insert_data = array(
                    'entry_no' => $entry_no,
                    'root' => $root,
                    'date' => $date,
                    'search_date' => $search_date,
                    'bus_type' => $bus_type,
                    'trip_time' => $trip_time,
                    'coach_no' => $coach_no,
                    'vehicle_reg_no' => $vehicle_reg_no,
                    'vehicle_type' => $vehicle_type,
                    'supervisor' => $supervisor,
                    'head' => $income_head,
                    'counter' => $counter,
                    'quantity' => $quantity,
                    'amount' => $amount,
                    'line_expense_head' => $line_expense_head,
                    'line_expense_amount' => $line_expense_amount,
                    'comment' => $comment
                );
                $this->Common_model->insert_data('income', $insert_data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function expense_entry() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $all_expense = $this->input->post('all_expense');
            $result = $this->Common_model->find_last_id('entry_no', 'expense');
            if (!$result) {
                $entry_no = 1;
            } else {
                foreach ($result as $row) {
                    $entry_no = ($row->entry_no) + 1;
                }
            }
            foreach ($all_expense as $single_expense) {
//                $bus_type = $single_expense[2];
//                $vehicle_reg_no = $single_expense[3];
//
//                if (empty($vehicle_reg_no)) {
//                    $vehicle_type = "Bus NAC";
//                } else {
//                    $result = $this->Common_model->get_allinfo_byid('vehicle_details', 'registration_no', $vehicle_reg_no);
//                    foreach ($result as $res) {
//                        $vehicle_type = $res->vehicle_type;
//                    }
//                }
//                $supervisor = $single_expense[6];
//                $trip_time = $single_expense[7];
//                $s_type = $single_expense[12];              
//                if ($s_type == 1) {
//                    $result = $this->Common_model->find_last_id('record_id', 'insert_staff');
//                    if (!$result) {
//                        $max_id = 1;
//                    } else {
//                        foreach ($result as $row) {
//                            $max_id = ($row->record_id) + 1;
//                        }
//                    }
//                    $img_name = $max_id . ".jpg";
//                    $insert_data = array(
//                        'record_id' => $max_id,
//                        'staff_name' => $supervisor,
//                        'designation' => 'Supervisor',
//                        'image' => $img_name,
//                    );
//                    $this->Common_model->insert_data('insert_staff', $insert_data);
//                }

                $root = $single_expense[1];
                $date = $single_expense[2];
                $search_date = date('d/m/Y', strtotime($date));
                $bus_type = $single_expense[3];
                $vehicle_type = $single_expense[4];
                $expense_head = $single_expense[5];
                $counter = $single_expense[6];
                $quantity = $single_expense[7];
                $amount = $single_expense[8];
                $comment = $single_expense[9];
                $insert_data = array(
                    'entry_no' => $entry_no,
                    'root' => $root,
                    'date' => $date,
                    'search_date' => $search_date,
                    'bus_type' => $bus_type,
                    'vehicle_type' => $vehicle_type,
                    'head' => $expense_head,
                    'counter' => $counter,
                    'quantity' => $quantity,
                    'amount' => $amount,
                    'comment' => $comment
//                    'bus_type' => $bus_type,
//                    'vehicle_reg_no' => $vehicle_reg_no,
//                    'trip_time' => $trip_time,
//                    'supervisor' => $supervisor
                );
                $this->Common_model->insert_data('expense', $insert_data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function line_expense_entry() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $all_line_expense = $this->input->post('all_line_expense');

            foreach ($all_line_expense as $single_expense) {
                $route = $single_expense[1];
                $particular = $single_expense[2];
                $amount = $single_expense[3];

                $insert_data = array(
                    'route' => $route,
                    'particular' => $particular,
                    'amount' => $amount
                );
                $this->Common_model->insert_data('create_line_expenses', $insert_data);
            }
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_ownerwise_vehicle() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $owner_unit = $this->input->post('owner_unit');

            $array_check = array();

            $data['date_range'] = '';
            $data['owner_unit'] = '';
            if (!empty($date_from) && !empty($date_to)) {
                $array_check["purchase_date >="] = $date_from;
                $array_check["purchase_date <="] = $date_to;
                $data['date_range'] = date('d F Y', strtotime($date_from)) . " - " . date('d F Y', strtotime($date_to));
            }

            if (!empty($owner_unit)) {
                $array_check["owner_unit"] = $owner_unit;
                $data['owner_unit'] = $owner_unit;
            }
            $data['all_value'] = $this->Common_model->get_all_info_by_array("vehicle_details", $array_check);
            $this->load->view('admin/show_ownerwise_vehicle', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_vehicle_value_report() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');

            $array_check = array();

            if (!empty($date_from) && !empty($date_to)) {
                $array_check["purchase_date >="] = $date_from;
                $array_check["purchase_date <="] = $date_to;
                $data['date_range'] = date('d F Y', strtotime($date_from)) . " - " . date('d F Y', strtotime($date_to));
            } else {
                $data['date_range'] = '';
            }
            $result = $this->Common_model->get_all_info_multiple_order('create_vehicle_type', "vehicle_type ASC, company_name ASC, vehicle_name ASC");
            $count = 0;
            foreach ($result as $res) {
                $count++;
                $data['vehicle_type' . $count] = $res->vehicle_type;
                $data['company_name' . $count] = $res->company_name;
                $data['vehicle_name' . $count] = $res->vehicle_name;
                $array_check["vehicle_type"] = $res->vehicle_type;
                $array_check["company_name"] = $res->company_name;
                $array_check["vehicle_name"] = $res->vehicle_name;
                $vehicle_result = $this->Common_model->get_all_info_by_array("vehicle_details", $array_check);

                $data['quantity' . $count] = count($vehicle_result);
                $total_value = 0;
                foreach ($vehicle_result as $info) {
                    if (!empty($info->purchase_amount)) {
                        $total_value += $info->purchase_amount;
                    }
                }
                $data['value' . $count] = $total_value;
            }
            $data['count_it'] = $count;
            $this->load->view('admin/show_vehicle_value_report', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

    public function show_usercowise_vehicle() {
        $user_type = $this->session->ses_user_type;
        if ($user_type == "admin" || $user_type == "staff") {
            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            $userco_unit = $this->input->post('userco_unit');

            $array_check = array();

            $data['date_range'] = '';
            $data['user_unit'] = $userco_unit;
            if (!empty($date_from) && !empty($date_to)) {
                $array_check["purchase_date >="] = $date_from;
                $array_check["purchase_date <="] = $date_to;
                $data['date_range'] = date('d F Y', strtotime($date_from)) . " - " . date('d F Y', strtotime($date_to));
            }

            if (!empty($userco_unit)) {
                $array_check["user_unit"] = $userco_unit;
                $data['user_unit'] = $userco_unit;
            }

            $data['all_value'] = $this->Common_model->get_all_info_by_array("vehicle_details", $array_check);
            $this->load->view('admin/show_usercowise_vehicle', $data);
        } else {
            $data['wrong_msg'] = "";
            $this->load->view('website/login_check', $data);
        }
    }

}
