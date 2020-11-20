<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Eview Limited | Online Shopping</title>
        <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
        <meta name="description" content="">
        <meta name="author" content="">

        <link id="callCss" rel="stylesheet" href="<?php echo base_url(); ?>assets/template_web/themes/bootshop/bootstrap.min.css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/template_web/themes/css/base.css" rel="stylesheet" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/template_web/themes/css/bootstrap-responsive.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>assets/template_web/themes/css/chosen.min.css" rel="stylesheet"/>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <!--<link href="<?php echo base_url(); ?>assets/template_web/themes/css/font-awesome.css" rel="stylesheet" type="text/css">-->
        <link href="<?php echo base_url(); ?>assets/template_web/themes/js/google-code-prettify/prettify.css" rel="stylesheet"/>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/template_web/themes/images/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/template_web/themes/images/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/template_web/themes/images/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/template_web/themes/images/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/template_web/themes/images/ico/apple-touch-icon-57-precomposed.png">
        <style type="text/css" id="enject"></style>
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    </head>
    <body>
        <div id="header">
            <div class="container" style="width: 100%;">
                <!-- Navbar ================================================== -->
                <div id="logoArea" class="navbar">
                    <div>
                        <ul id="topMenu" class="nav" style="background: white; width: 100%;  padding-top: 8px; 
                            padding-bottom: 8px; border-bottom: .2px solid #cfc2c2;">
                            <li class=""style="padding-left: 30px; padding-top: 5px;">
                                <img src="<?php echo base_url(); ?>assets/template_web/themes/images/logo.png" alt="Bootsshop" 
                                     style="width: 120px; height: 50px;"/>
                            </li>
                            <li class="topnav" style="color: black;">
                                    <input type="text" placeholder="Search for..." name="search">
                                    <button type="submit" id="search_now"><i class="fa fa-search"></i></button>
                            </li>
                            <li class="" style="color: black;">
                                <a onclick="home()" href="#" title="Home">
                                    <i class="fa fa-home" style="font-size: 25px; color: black; margin-right: 6px;"></i>
                                </a>
                            </li>
                             <li class="" style="color: black; margin-top: 22px; margin-right: 5px;">
                                <b style="font-size: 20px; color: black;">|</b>
                            </li>
                            <li class="">
                                <a onclick="cart_payment()" href="#" title="Cart">
                                    <i class=" fa fa-shopping-cart" style="font-size: 25px; color: black;"></i><b  id="cart_storage" style="color: black; margin-right: 6px;">(0)</b>
                                </a>
                            </li>
                            <li class="" style="color: black; margin-top: 22px; margin-right: 8px;">
                                <b style="font-size: 20px; color: black;">|</b>
                            </li>
                            <li class="">
                                <a  href="<?php echo base_url(); ?>Log_in_out" title="Login">
                                    <i class="fa fa-sign-in" style="font-size: 25px; color: black;"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
         <div id="header">
            <div class="container" style="width: 100%; padding-bottom: 20px;">
                <!-- Navbar ================================================== -->
                <div class="navbar">
                    <div>
                        <ul class="nav" style="background: white; width: 100%;  padding-top: 0px; 
                            padding-bottom: 0px; margin: 0px; border-bottom: .2px solid #cfc2c2;">
                            <li class="" style="padding: 0px; margin: 0px;">
                                <a onclick="brand()" href="#"  style="color: grey; margin-left: 100px; margin-right: 20px; font-size: 14px;">
                                    <i class="fa fa-caret-square-o-right" style="color: black;"></i> Brand Product</a>
                            </li>
                            <li class="" style="padding: 0px; margin: 0px;">
                                <a onclick="merchant()" href="#"  style="color: grey; margin-left: 50px; margin-right: 20px; font-size: 14px;">
                                    <i class="fa fa-caret-square-o-right" style="color: black;"></i> All Shop</a>
                            </li>
                            <li class="" style="padding: 0px; margin: 0px;">
                                <a onclick="gen_reg()" href="#"  style="color: grey; margin-left: 50px; margin-right: 20px; font-size: 14px;">
                                    <i class="fa fa-caret-square-o-right" style="color: black;"></i> General Member</a>
                            </li>
                          <!--   <li class="" style="padding: 0px; margin: 0px;">
                                <a href=""  style="color: grey; margin-left: 50px; margin-right: 20px; font-size: 14px;">
                                    <i class="fa fa-caret-square-o-right" style="color: black;"></i> Merchant Member</a>
                            </li> -->
                            <li class="" style="padding: 0px; margin: 0px;">
                                <a onclick="mer_reg()" href="#"  style="color: grey; margin-left: 50px; margin-right: 20px; font-size: 14px;">
                                    <i class="fa fa-caret-square-o-right" style="color: black;"></i> Merchant Member</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End====================================================================== -->

        <style>
            .topnav{
                padding-left: 20px;
                margin-top: 8px;
                width: 65%;
            }
            .topnav input[type=text] {
                width: 85%;
                border: 2px solid #ab0c0c;
                padding: 10px;
                margin-top: 6px;
                font-size: 15px;
                margin-right: 0px;
            }

            .topnav button {
                width: 8%;
                color: white;
                float: right;
                padding: 12px;
                margin-top: 6px;
                margin-right: 16px;
                margin-left: 0px;
                background: #ab0c0c;
                font-size: 17px;
                border: none;
                cursor: pointer;
            }
        </style>