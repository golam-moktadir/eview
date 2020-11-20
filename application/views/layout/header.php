<?php
$type = $this->session->ses_type;
$view_menu = $this->session->ses_view_menu_id;
$insert_menu = $this->session->ses_insert_menu_id;
$edit_menu = $this->session->ses_edit_menu_id;
$delete_menu = $this->session->ses_delete_menu_id;
$view_id = explode(",", $view_menu);
$insert_id = explode(",", $insert_menu);
$edit_id = explode(",", $edit_menu);
$delete_id = explode(",", $delete_menu);
?>
<!DOCTYPE html>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title>Eview Online Shopping</title>
        <link rel="Tab Icon" type="image/png" href="<?php echo base_url(); ?>assets/img/fab.jpg"/>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link href="<?php echo base_url(); ?>adminlte/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>adminlte/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>assets/css/w3.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>adminlte/css/AdminLTE.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/fixedHeader.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-select.min.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
        <!--Live Search-->
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    </head>

    <body>
        <div class="container-fluid" style="position: fixed; z-index: 50; width: 100%;">
            <div class="row">
                <div class="navbar navbar-inverse" style="background-color: #066;
                     color: white; border: 0px; margin-left: 20px; margin-right: 20px;">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="container-fluid">
                        <div class="collapse navbar-collapse row" style="padding: 8px; font-size: 16px; font-weight: bold;">
                            <?php if ($type == "admin") { ?>
                                <div class="col-sm-1 col-xs-12" style="color: #066; text-align: center; padding-top: 3px;">
                                    <?php if (in_array("1", $view_id) || in_array("all", $view_id)) { ?>
                                        <a class="sub_hide" style="color: wheat;" href="<?php echo base_url(); ?>Log_in_out">Dashboard</a>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-2 col-xs-12" style="color: #066; text-align: center; padding-top: 3px;">
                                    <a style="color: wheat; cursor: pointer;" class="dropdown-toggle sub_hide"
                                       data-toggle="dropdown">Input Data
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php if (in_array("11", $view_id) || in_array("all", $view_id)) { ?>
                                            <li class="dropdown-submenu" style="margin: 10px; font-size: 15px; text-align: left;">
                                                <a href="<?php echo base_url(); ?>Show_form/category">
                                                    <i class="fa fa-th text-green"></i>
                                                    <span>Create Category</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (in_array("11", $view_id) || in_array("all", $view_id)) { ?>
                                            <li class="dropdown-submenu" style="margin: 10px; font-size: 15px; text-align: left;">
                                                <a href="<?php echo base_url(); ?>Show_form/sub_category">
                                                    <i class="fa fa-th text-green"></i>
                                                    <span>Create Sub Category</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (in_array("11", $view_id) || in_array("all", $view_id)) { ?>
                                            <li class="dropdown-submenu" style="margin: 10px; font-size: 15px; text-align: left;">
                                                <a href="<?php echo base_url(); ?>Show_form/brand">
                                                    <i class="fa fa-th text-green"></i>
                                                    <span>Create Brand</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (in_array("11", $view_id) || in_array("all", $view_id)) { ?>
                                            <li class="dropdown-submenu" style="margin: 10px; font-size: 15px; text-align: left;">
                                                <a href="<?php echo base_url(); ?>Show_form/product_info">
                                                    <i class="fa fa-th text-green"></i>
                                                    <span>Product Info</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (in_array("6", $view_id) || in_array("all", $view_id)) { ?>
                                            <li class="dropdown-submenu" style="margin: 10px; font-size: 15px; text-align: left;">
                                                <a href="<?php echo base_url(); ?>Show_form/slider">
                                                    <i class="fa fa-th text-green"></i>
                                                    <span>Slider Upload</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (in_array("7", $view_id) || in_array("all", $view_id)) { ?>
                                            <li class="dropdown-submenu" style="margin: 10px; font-size: 15px; text-align: left;">
                                                <a href="<?php echo base_url(); ?>Show_form/about">
                                                    <i class="fa fa-th text-green"></i>
                                                    <span>About Us</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (in_array("9", $view_id) || in_array("all", $view_id)) { ?>
                                            <li class="dropdown-submenu" style="margin: 10px; font-size: 15px; text-align: left;">
                                                <a href="<?php echo base_url(); ?>Show_form/contact">
                                                    <i class="fa fa-th text-green"></i>
                                                    <span>Contact Us</span>
                                                </a>
                                            </li>
                                        <?php } ?>

                                    </ul>
                                </div>
                                <?php if (in_array("18", $view_id) || in_array("all", $view_id)) { ?>
                                    <div class="col-sm-2 col-xs-12" style="color: #066; text-align: center; padding-top: 3px;">
                                        <a style="color: wheat;" href="<?php echo base_url(); ?>Show_form/cus_req">Product Request</a>
                                    </div>
                                <?php } ?>

                                <?php if (in_array("18", $view_id) || in_array("all", $view_id)) { ?>
                                    <div class="col-sm-2 col-xs-12" style="color: #066; text-align: center;  font-size: 24px;">
                                        <a style="color: white;" href="<?php echo base_url(); ?>Web_form">Eview Shopping</a>
                                    </div>
                                <?php } ?>
                                <?php if (in_array("18", $view_id) || in_array("all", $view_id)) { ?>
                                    <!--                                <div class="col-sm-2 col-xs-12" style="color: #066; text-align: center; padding-top: 3px;">
                                                                        <a style="color: wheat;" href="<?php echo base_url(); ?>Show_form/review">Client Reviews</a>
                                                                    </div>-->
                                <?php } ?>
                                <div class="col-sm-2 col-xs-12" style="color: #066; text-align: center; padding-top: 3px;">
                                    <a style="color: wheat; cursor: pointer;" class="dropdown-toggle sub_hide"
                                       data-toggle="dropdown">Member
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">

                                        <?php if (in_array("7", $view_id) || in_array("all", $view_id)) { ?>
                                            <li class="dropdown-submenu" style="margin: 10px; font-size: 15px; text-align: left;">
                                                <a href="<?php echo base_url(); ?>Show_form/gen_reg">
                                                    <i class="fa fa-th text-green"></i>
                                                    <span>General Member</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (in_array("9", $view_id) || in_array("all", $view_id)) { ?>
                                            <li class="dropdown-submenu" style="margin: 10px; font-size: 15px; text-align: left;">
                                                <a href="<?php echo base_url(); ?>Show_form/mer_reg">
                                                    <i class="fa fa-th text-green"></i>
                                                    <span>Merchant Member</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="col-sm-2 col-xs-12" style="color: #066; text-align: center; padding-top: 3px;">
                                    <a style="color: wheat;" href="<?php echo base_url(); ?>Log_in_out/logout">Logout</a>
                                </div>
                                <div class="col-sm-1 col-xs-12" style="text-align: center; font-size: 14px;">
                                    <?php echo date('l'); ?><br><?php echo date('d-m-y'); ?>
                                </div>
                            <?php } elseif ($type == "general_member") { ?>
                                <div class="col-sm-2 col-xs-12" style="color: #066; text-align: center; padding-top: 3px;">
                                    <a style="color: wheat;" href="<?php echo base_url(); ?>Show_form/profile">My Profile</a>
                                </div>
                                <div class="col-sm-2 col-xs-12" style="color: #066; text-align: center; padding-top: 3px;">
                                    <a style="color: wheat;" href="<?php echo base_url(); ?>Show_form/purchased_product">Purchased Product</a>
                                </div>
                                <div class="col-sm-4 col-xs-12" style="color: #066; text-align: center;  font-size: 24px;">
                                    <a style="color: white;" href="<?php echo base_url(); ?>Web_form">Eview Online Shopping</a>
                                </div>
                                <div class="col-sm-2 col-xs-12" style="color: #066; text-align: center; padding-top: 3px;">
                                    <a style="color: wheat;" href="<?php echo base_url(); ?>Log_in_out/logout">Logout</a>
                                </div>
                                <div class="col-sm-2 col-xs-12" style="text-align: center; font-size: 14px;">
                                    <?php echo date('l'); ?><br><?php echo date('d-m-y'); ?>
                                </div>
                            <?php } elseif ($type == "merchant_member") { ?>
                                <div class="col-sm-4 col-xs-12"style="color: #066; text-align: center; padding-top: 3px;">
                                    <a style="color: wheat;" href="<?php echo base_url(); ?>Show_form/product_info">Product Info</a>
                                </div>
                                <div class="col-sm-4 col-xs-12" style="color: #066; text-align: center;  font-size: 24px;">
                                    <a style="color: white;" href="<?php echo base_url(); ?>Web_form">Eview Online Shopping</a>
                                </div>
                                <div class="col-sm-2 col-xs-12" style="color: #066; text-align: center; padding-top: 3px;">
                                    <a style="color: wheat;" href="<?php echo base_url(); ?>Log_in_out/logout">Logout</a>
                                </div>
                                <div class="col-sm-2 col-xs-12" style="text-align: center; font-size: 14px;">
                                    <?php echo date('l'); ?><br><?php echo date('d-m-y'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="padding-top: 55px;"></div>
        <script>
            $('.sub_hide').on("click", function () {
                $('.subtog').hide();
            });

            $('.dropdown-submenu a.test').on("click", function (e) {
                $('.subtog').hide();
                $(this).next('ul').show();
                e.stopPropagation();
                e.preventDefault();
            });
        </script>