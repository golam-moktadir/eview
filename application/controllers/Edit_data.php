<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Edit_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Individual_model');
    }

    public function change_status_product() {
        $id = $this->input->post('id');
        $status_value = $this->input->post('status_value');
        $db_name = $this->input->post('db_name');
        $this->Individual_model->change_status($id, $status_value, $db_name);
        $result1 = $this->Common_model->get_allinfo_byid('cus_req_product', 'cus_req_id', $id);
        foreach ($result1 as $result_info) {
            $product_id = $result_info->product_id;
            $qty1 = $result_info->qty;
            $discount1 = $result_info->discount;
            $balance1 = $result_info->balance;
            $result2 = $this->Common_model->get_allinfo_byid('product', 'record_id', $product_id);
            foreach ($result2 as $info) {
                $qty2 = $info->qty;
                $discount2 = $info->discount;
                $balance2 = $info->balance;
            }
            $total_qty = $qty1 + $qty2;
            $total_discount = $discount1 + $discount2;
            $total_balance = $balance1 + $balance2;

            $update_data = array(
                'qty' => $total_qty,
                'discount' => $total_discount,
                'balance' => $total_balance
            );
            $this->Common_model->update_data_onerow('product', $update_data, 'record_id', $product_id);
        }

        echo json_encode("Approved Successfuly");
    }

    public function change_status_gen_reg() {
        $id = $this->input->post('id');
        $status_value = $this->input->post('status_value');
        $db_name = $this->input->post('db_name');
        $this->Individual_model->change_status($id, $status_value, $db_name);
        $result = $this->Common_model->get_allinfo_byid('gen_reg', 'record_id', $id);
        foreach ($result as $result_info) {
            $full_name = $result_info->name;
            $password = $result_info->password;
            $mobile = $result_info->mobile;
            $email = $result_info->email;
            $address = $result_info->address;
            $status = 1;
        }

        $insert_data = array(
            'type' => "general_member",
            'full_name' => $full_name,
            'user_name' => $email,
            'password' => $password,
            'email' => $email,
            'address' => $address,
            'mobile' => $mobile,
            'status' => 1
//            'ses_view_menu_id' => $view_menu_id,
//            'ses_insert_menu_id' => $insert_menu_id,
//            'ses_edit_menu_id' => $edit_menu_id,
//            'ses_delete_menu_id' => $delete_menu_id
        );
        $this->Common_model->trans_start();
        $this->Common_model->insert_data('role_setting', $insert_data);
        $this->Common_model->trans_complete();
        echo json_encode("Approved Successfuly");
    }

    public function change_status_mer_reg() {
        $id = $this->input->post('id');
        $status_value = $this->input->post('status_value');
        $db_name = $this->input->post('db_name');
        $this->Individual_model->change_status($id, $status_value, $db_name);
        $result = $this->Common_model->get_allinfo_byid('mer_reg', 'record_id', $id);
        foreach ($result as $result_info) {
            $cat = $result_info->category;
            $sub_cat = $result_info->sub_category;
            $full_name = $result_info->name;
            $res_person = $result_info->res_person;
            $password = $result_info->password;
            $mobile = $result_info->mobile;
            $email = $result_info->email;
            $address = $result_info->address;
            $status = 1;
        }

        $insert_data = array(
            'type' => "merchant_member",
            'cat' => $cat,
            'sub_cat' => $sub_cat,
            'res_person' => $res_person,
            'full_name' => $full_name,
            'user_name' => $email,
            'password' => $password,
            'email' => $email,
            'address' => $address,
            'mobile' => $mobile,
            'status' => 1,
            'approved_id' => $id
//            'ses_view_menu_id' => $view_menu_id,
//            'ses_insert_menu_id' => $insert_menu_id,
//            'ses_edit_menu_id' => $edit_menu_id,
//            'ses_delete_menu_id' => $delete_menu_id
        );
        $this->Common_model->trans_start();
        $this->Common_model->insert_data('role_setting', $insert_data);
        $this->Common_model->trans_complete();
        echo json_encode("Approved Successfuly");
    }

    public function change_status() {
        $id = $this->input->post('id');
        $status_value = $this->input->post('status_value');
        $db_name = $this->input->post('db_name');
        $this->Individual_model->change_status($id, $status_value, $db_name);
        echo json_encode("Status Changed");
    }

    public function doc_con() {
        $max_id = $this->input->post('record_id');
        $logo = $max_id . ".jpg";

        $config['file_name'] = $logo;
        $config['upload_path'] = './assets/img/doc_con_logo/';
        $config['allowed_types'] = '*';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->do_upload('picture');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/img/doc_con_logo/' . $logo;
//                $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 200;
        $config['height'] = 200;

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $name = $this->input->post('name');
        $name_bangla = $this->input->post('name_bangla');
        $mobile = $this->input->post('mobile');
        $designation = $this->input->post('designation');
        $designation_bangla = $this->input->post('designation_bangla');
        $specialist = $this->input->post('specialist');
        $specialist_bangla = $this->input->post('specialist_bangla');
        $bmdc = $this->input->post('bmdc');
        $bmdc_bangla = $this->input->post('bmdc_bangla');
        $gender = $this->input->post('gender');
        $blood_group = $this->input->post('blood_group');
        $address = $this->input->post('address');
        $education = $this->input->post('education');
        $education_bangla = $this->input->post('education_bangla');
        $current_emp = $this->input->post('current_emp');
        $current_emp_bangla = $this->input->post('current_emp_bangla');
        $training_sub = $this->input->post('training_sub');
        $training_sub_bangla = $this->input->post('training_sub_bangla');
        $training_place = $this->input->post('training_place');
        $training_place_bangla = $this->input->post('training_place_bangla');

        $update_data = array(
            'record_id' => $max_id,
            'name' => $name,
            'name_bangla' => $name_bangla,
            'picture' => $logo,
            'mobile' => $mobile,
            'designation' => $designation,
            'designation_bangla' => $designation_bangla,
            'specialist' => $specialist,
            'specialist_bangla' => $specialist_bangla,
            'bmdc' => $bmdc,
            'gender' => $gender,
            'blood_group' => $blood_group,
            'address' => $address,
            'bmdc_bangla' => $bmdc_bangla,
            'education' => $education,
            'education_bangla' => $education_bangla,
            'current_emp' => $current_emp,
            'current_emp_bangla' => $current_emp_bangla,
            'training_sub' => $training_sub,
            'training_sub_bangla' => $training_sub_bangla,
            'training_place' => $training_place,
            'training_place_bangla' => $training_place_bangla
        );

        $this->Common_model->trans_start();
        $this->Common_model->update_data_onerow('doc_con', $update_data, 'record_id', $max_id);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Edited Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function product() {
        $max_id = $this->input->post('record_id');
        $logo_1 = $max_id . "_1.jpg";
        $logo_2 = $max_id . "_2.jpg";
        $logo_3 = $max_id . "_3.jpg";
        $logo_4 = $max_id . "_4.jpg";
        $logo_5 = $max_id . "_5.jpg";
        $logo_6 = $max_id . "_6.jpg";

        $this->load->library('upload');
//        $this->load->library('image_lib');
        for ($i = 1; $i <= 6; $i++) {
            $config['file_name'] = ${"logo_" . $i};
            $config['upload_path'] = './assets/img/product/';
            $config['allowed_types'] = '*';
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['overwrite'] = TRUE;

            $this->upload->initialize($config);
            $this->upload->do_upload('picture_' . $i);

//            $config['image_library'] = 'gd2';
//            $config['source_image'] = './assets/img/product/' . ${"logo_".$i};
////            $config['create_thumb'] = TRUE;
//            $config['maintain_ratio'] = TRUE;
//            $config['width'] = 500;
//            $config['height'] = 500;
//
//            $this->image_lib->initialize($config);
//            $this->image_lib->resize();
        }

        $name = $this->input->post('name');
        $code = $this->input->post('code');
        $brand = $this->input->post('brand');
        $description = $this->input->post('description');
        $specification = $this->input->post('specification');
        $price = $this->input->post('price');
        $category = $this->input->post('category');
        $sub_category = $this->input->post('sub_category');

        $update_data = array(
            'record_id' => $max_id,
            'name' => $name,
            'code' => $code,
            'brand' => $brand,
            'description' => $description,
            'specification' => $specification,
            'price' => $price,
            'category' => $category,
            'sub_category' => $sub_category
        );

        $this->Common_model->trans_start();
        $this->Common_model->trans_start();
        $this->Common_model->update_data_onerow('product', $update_data, 'record_id', $max_id);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Inserted Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function photo_gallery() {
        $max_id = $this->input->post('record_id');
        $logo = $max_id . ".jpg";

        $config['file_name'] = $logo;
        $config['upload_path'] = './assets/img/photo_gallery/';
        $config['allowed_types'] = '*';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->do_upload('picture');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/img/photo_gallery/' . $logo;
//                $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 600;
        $config['height'] = 250;

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $title = $this->input->post('title');
        $details = $this->input->post('details');

        $update_data = array(
            'record_id' => $max_id,
            'title' => $title,
            'details' => $details,
            'picture' => $logo
        );

        $this->Common_model->trans_start();
        $this->Common_model->update_data_onerow('photo_gallery', $update_data, 'record_id', $max_id);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Edited Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function news_events() {
        $max_id = $this->input->post('record_id');
        $logo = $max_id . ".jpg";

        $config['file_name'] = $logo;
        $config['upload_path'] = './assets/img/news_events/';
        $config['allowed_types'] = '*';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->do_upload('picture');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/img/news_events/' . $logo;
//                $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 600;
        $config['height'] = 250;

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $title = $this->input->post('title');
        $details = $this->input->post('details');

        $update_data = array(
            'record_id' => $max_id,
            'title' => $title,
            'details' => $details,
            'picture' => $logo
        );

        $this->Common_model->trans_start();
        $this->Common_model->update_data_onerow('news_events', $update_data, 'record_id', $max_id);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Edited Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function slider() {
        $max_id = $this->input->post('record_id');
        $logo = $max_id . ".jpg";

        $config['file_name'] = $logo;
        $config['upload_path'] = './assets/img/slider/';
        $config['allowed_types'] = '*';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->do_upload('picture');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/img/slider/' . $logo;
//                $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 1200;
        $config['height'] = 500;

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $title = $this->input->post('title');

        $update_data = array(
            'record_id' => $max_id,
            'title' => $title,
            'picture' => $logo,
        );

        $this->Common_model->trans_start();
        $this->Common_model->update_data_onerow('slider', $update_data, 'record_id', $max_id);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Edited Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function about() {
        $max_id = $this->input->post('record_id');

        $about = $this->input->post('about');

        $update_data = array(
            'about' => $about
        );

        $this->Common_model->trans_start();
        $this->Common_model->update_data_onerow('about', $update_data, 'record_id', $max_id);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Edited Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function contact() {
        $max_id = $this->input->post('record_id');

        $details = $this->input->post('details');

        $update_data = array(
            'details' => $details
        );

        $this->Common_model->trans_start();
        $this->Common_model->update_data_onerow('contact', $update_data, 'record_id', $max_id);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Edited Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function category() {
        $max_id = $this->input->post('record_id');
        $category = $this->input->post('category');

        $update_data = array(
            'category' => $category
        );

        $this->Common_model->trans_start();
        $this->Common_model->update_data_onerow('category', $update_data, 'record_id', $max_id);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Edited Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function sub_category() {
        $max_id = $this->input->post('record_id');
        $category_id = $this->input->post('category');
        $sub_category = $this->input->post('sub_category');

        $update_data = array(
            'category_id' => $category_id,
            'sub_category' => $sub_category
        );

        $this->Common_model->trans_start();
        $this->Common_model->update_data_onerow('sub_category', $update_data, 'record_id', $max_id);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Edited Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

}
