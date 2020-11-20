<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Dhaka');

class Insert_data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Individual_model');
        $this->load->model('Join_model');
    }

    public function mer_reg() {
        $result = $this->Common_model->get_last_data("mer_reg");
        if (!$result) {
            $max_id = 1;
            $logo = "1.jpg";
        } else {
            foreach ($result as $row) {
                $max_id = ($row->record_id) + 1;
                $logo = $max_id . ".jpg";
            }
        }

        $config['file_name'] = $logo;
        $config['upload_path'] = './assets/img/mer_reg/';
        $config['allowed_types'] = '*';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->do_upload('picture');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/img/mer_reg/' . $logo;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 300;
        $config['height'] = 300;

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();

        $category = $this->input->post('category');
        $sub_category = $this->input->post('sub_category');
        $res_person = $this->input->post('res_person');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $name = $this->input->post('name');
        $mobile = $this->input->post('mobile');
        $password = $this->input->post('password');
        $country = $this->input->post('country');

        $insert_data = array(
            'record_id' => $max_id,
            'category' => $category,
            'country' => $country,
            'sub_category' => $sub_category,
            'res_person' => $res_person,
            'name' => $name,
            'mobile' => $mobile,
            'address' => $address,
            'email' => $email,
            'password' => $password,
            'status' => 0
        );
        $this->Common_model->trans_start();
        $this->Common_model->insert_data('mer_reg', $insert_data);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Registration Completed Successfully. We will send feedback soon");
        } else {
            echo json_encode("Error Occured");
        }
    }
    public function gen_reg() {
        $result = $this->Common_model->get_last_data("gen_reg");
        if (!$result) {
            $max_id = 1;
            $logo = "1.jpg";
        } else {
            foreach ($result as $row) {
                $max_id = ($row->record_id) + 1;
                $logo = $max_id . ".jpg";
            }
        }

        $config['file_name'] = $logo;
        $config['upload_path'] = './assets/img/gen_reg/';
        $config['allowed_types'] = '*';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->do_upload('picture');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/img/gen_reg/' . $logo;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 300;
        $config['height'] = 300;

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $name = $this->input->post('name');
        $mobile = $this->input->post('mobile');
        $password = $this->input->post('password');
        $country = $this->input->post('country');

        $insert_data = array(
            'record_id' => $max_id,
            'country' => $country,
            'name' => $name,
            'mobile' => $mobile,
            'address' => $address,
            'email' => $email,
            'password' => $password,
            'status' => 0
        );
        $this->Common_model->trans_start();
        $this->Common_model->insert_data('gen_reg', $insert_data);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Registration Completed Successfully. We will send feedback soon");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function cus_req() {
        $all_content = $this->input->post('all_content');
        $trx_id = $this->input->post('trx_id');
        $address = $this->input->post('address');
        $name = $this->input->post('name');
        $mobile = $this->input->post('mobile');

        $mem_email = $this->input->post('mem_email');
        $mem_password = $this->input->post('mem_password');
        $checking_array = array("user_name" => $mem_email, "password" => $mem_password);
        $result = $this->Common_model->check_value_get_data('role_setting', $checking_array);
        if ($result) {
            $member_id = $result[0]->record_id;
        } else {
            $member_id = 0;
        }

        $result = $this->Common_model->get_last_data("cus_req");
        if (!$result) {
            $max_id = 1;
        } else {
            foreach ($result as $row) {
                $max_id = ($row->record_id) + 1;
            }
        }
        $purchase_details = "";
        if ($member_id == 0) {
            $discount = 0;
        } else {
            $discount = 5;
        }
        $total_price = 0;
        $count = 0;
        foreach ($all_content as $single_content) {
            $count++;
            $total_price += $single_content[4];
            $purchase_details .= $count . ". " . $single_content[0] . ", C" . $single_content[1] . ", " . $single_content[2] . " BDT, " . $single_content[3] . "Pc, " . $single_content[4] . " BDT\n";
            $insert_data = array(
                'cus_req_id' => $max_id,
                'product_id' => $single_content[5],
                'qty' => $single_content[3],
                'discount' => ($single_content[4] * $discount) / 100,
                'balance' => $single_content[4] - (($single_content[4] * $discount) / 100)
            );

            $this->Common_model->insert_data('cus_req_product', $insert_data);
        }
        $shipping = 100;
        $total = $total_price + $shipping;
        $discount_amount = ($total * $discount) / 100;
        $net_total = $total - $discount_amount;


        $insert_data2 = array(
            'record_id' => $max_id,
            'member_id' => $member_id,
            'name' => $name,
            'mobile' => $mobile,
            'address' => $address,
            'trx_id' => $trx_id,
            'purchase_details' => $purchase_details,
            'total_price' => $total_price,
            'shipping' => 100,
            'total' => $total,
            'discount' => $discount_amount,
            'net_total' => $net_total,
            'status' => 0
        );
        $this->Common_model->trans_start();
        $this->Common_model->insert_data('cus_req', $insert_data2);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Payment Completed Successfully. We will send your product soon");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function photo_gallery() {
        $result = $this->Common_model->get_last_data("photo_gallery");
        if (!$result) {
            $max_id = 1;
            $logo = "1.jpg";
        } else {
            foreach ($result as $row) {
                $max_id = ($row->record_id) + 1;
                $logo = $max_id . ".jpg";
            }
        }

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

        $insert_data = array(
            'record_id' => $max_id,
            'title' => $title,
            'details' => $details,
            'picture' => $logo
        );

        $this->Common_model->trans_start();
        $this->Common_model->insert_data('photo_gallery', $insert_data);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Inserted Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function news_events() {
        $result = $this->Common_model->get_last_data("news_events");
        if (!$result) {
            $max_id = 1;
            $logo = "1.jpg";
        } else {
            foreach ($result as $row) {
                $max_id = ($row->record_id) + 1;
                $logo = $max_id . ".jpg";
            }
        }

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

        $insert_data = array(
            'record_id' => $max_id,
            'title' => $title,
            'details' => $details,
            'picture' => $logo
        );

        $this->Common_model->trans_start();
        $this->Common_model->insert_data('news_events', $insert_data);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Inserted Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function product() {
        $result = $this->Common_model->get_last_data("product");
        if (!$result) {
            $max_id = 1;
            $logo_1 = "1_1.jpg";
            $logo_2 = "1_2.jpg";
            $logo_3 = "1_3.jpg";
            $logo_4 = "1_4.jpg";
            $logo_5 = "1_5.jpg";
            $logo_6 = "1_6.jpg";
            $logo_7 = "1_7.jpg";
        } else {
            foreach ($result as $row) {
                $max_id = ($row->record_id) + 1;
                $logo_1 = $max_id . "_1.jpg";
                $logo_2 = $max_id . "_2.jpg";
                $logo_3 = $max_id . "_3.jpg";
                $logo_4 = $max_id . "_4.jpg";
                $logo_5 = $max_id . "_5.jpg";
                $logo_6 = $max_id . "_6.jpg";
                $logo_7 = $max_id . "_7.jpg";
            }
        }

        $this->load->library('upload');
//        $this->load->library('image_lib');
        for ($i = 1; $i <= 7; $i++) {
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
        $member_id = $this->session->ses_record_id;
        $name = $this->input->post('name');
        $code = $this->input->post('code');
        $brand = $this->input->post('brand');
        $description = $this->input->post('description');
        $specification = $this->input->post('specification');
        $price = $this->input->post('price');
        $category = $this->input->post('category');
        $sub_category = $this->input->post('sub_category');

        $insert_data = array(
            'record_id' => $max_id,
            'name' => $name,
            'code' => $code,
            'brand' => $brand,
            'description' => $description,
            'specification' => $specification,
            'price' => $price,
            'category' => $category,
            'sub_category' => $sub_category,
            'member_id' => $member_id
        );

        $this->Common_model->trans_start();
        $this->Common_model->insert_data('product', $insert_data);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Inserted Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function slider() {
        $result = $this->Common_model->get_last_data("slider");
        if (!$result) {
            $max_id = 1;
            $logo = "1.jpg";
        } else {
            foreach ($result as $row) {
                $max_id = ($row->record_id) + 1;
                $logo = $max_id . ".jpg";
            }
        }

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

        $insert_data = array(
            'record_id' => $max_id,
            'title' => $title,
            'picture' => $logo,
        );

        $this->Common_model->trans_start();
        $this->Common_model->insert_data('slider', $insert_data);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Inserted Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function about() {
        $about = $this->input->post('about');

        $insert_data = array(
            'about' => $about
        );

        $this->Common_model->trans_start();
        $this->Common_model->insert_data('about', $insert_data);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Inserted Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function contact() {
        $details = $this->input->post('details');

        $insert_data = array(
            'details' => $details
        );

        $this->Common_model->trans_start();
        $this->Common_model->insert_data('contact', $insert_data);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Inserted Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function category() {
        $category = $this->input->post('category');

        $insert_data = array(
            'category' => $category
        );

        $this->Common_model->trans_start();
        $this->Common_model->insert_data('category', $insert_data);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Inserted Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function sub_category() {
        $all_content = $this->input->post('all_content');
        $count = 0;
        $insert_data = array();
        foreach ($all_content as $single_content) {
            $count++;
            $category_id = $single_content[0];
            $sub_category = $single_content[2];
            $insert_data[$count] = array(
                'category_id' => $category_id,
                'sub_category' => $sub_category
            );
        }
        $this->Common_model->trans_start();
        $this->Common_model->insert_multiple_data('sub_category', $insert_data);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Inserted Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }

    public function review() {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $message = $this->input->post('message');

        $insert_data = array(
            'name' => $name,
            'email' => $email,
            'review' => $message
        );

        $this->Common_model->trans_start();
        $this->Common_model->insert_data('review', $insert_data);
        $this->Common_model->trans_complete();
        if ($this->Common_model->trans_status() == true) {
            echo json_encode("Inserted Successfully");
        } else {
            echo json_encode("Error Occured");
        }
    }
    public function mer_reg() {
        
        $config['upload_path'] = './assets/img/mer_reg/';
        $config['allowed_types'] = 'gif|jpg|png';
        
        $this->load->library('upload', $config);
        $this->upload->do_upload('picture');
        $image = $this->upload->data();

        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/img/mer_reg/'.$image['file_name'];
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 300;
        $config['height'] = 300;

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();

        $insert_data = array(
            'name' => $this->input->post('name'),
            'mobile' => $this->input->post('mobile'),
            'address' => $this->input->post('address'),
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'status' => 0,
            'category' => $this->input->post('category'),
            'res_person' => $this->input->post('res_person'),
            'country' => $this->input->post('country'),
            'image' => $image['file_name']
        );
        $insert_id = $this->Common_model->insert_mer('mer_reg', $insert_data);
        $sub_category = $this->input->post('sub_category');

        foreach($sub_category as $subcategory){
            $this->db->insert('sub_category_details',[
                                               'company_id' => $insert_id,
                                               'category_id' => $this->input->post('category'),
                                               'sub_category_id' => $subcategory
                                          ]);
        }
        $this->session->set_userdata("message","Registration Completed Successfully. We will send feedback soon");
        redirect(base_url().'Web_form/mer_reg');        
    }

}
