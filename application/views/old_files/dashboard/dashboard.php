<?php
$view_menu = $this->session->ses_view_menu_id;
$insert_menu = $this->session->ses_insert_menu_id;
$edit_menu = $this->session->ses_edit_menu_id;
$delete_menu = $this->session->ses_delete_menu_id;
$view_id = explode(",", $view_menu);
$insert_id = explode(",", $insert_menu);
$edit_id = explode(",", $edit_menu);
$delete_id = explode(",", $delete_menu);
?>
<?php if (in_array("1", $view_id) || in_array("all", $view_id)) { ?>

    <div class="col-xs-4" style="margin-top: 20px;">
        <div class="small-box bg-green" style="border-radius: 10px;">
            <div class="inner" style="text-align: center; height: 130px;">
                <a style="color: wheat;" href="<?php echo base_url(); ?>Dashboard/doc_con">
                    <p style="color: white; font-size: 20px;">Total Doctor</p>
                    <p style="color: wheat; font-size: 20px;"><?php echo $total_doc; ?></p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xs-4" style="margin-top: 20px;">
        <div class="small-box bg-green" style="border-radius: 10px;">
            <div class="inner" style="text-align: center; height: 130px;">
                <a style="color: wheat;" href="<?php echo base_url(); ?>Dashboard/patient">
                    <p style="color: white; font-size: 20px;">Total Patient</p>
                    <p style="color: wheat; font-size: 20px;"><?php echo $total_patient; ?></p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xs-4" style="margin-top: 20px;">
        <div class="small-box bg-green" style="border-radius: 10px;">
            <div class="inner" style="text-align: center; height: 130px;">
                <a style="color: wheat;" href="<?php echo base_url(); ?>Dashboard/inv_account">
                    <p style="color: white; font-size: 20px;">Total Investigation</p>
                    <p style="color: wheat; font-size: 20px;">
                        <?php
                        $total = 0;
                        foreach ($total_inv as $val) {
                            $total += $val->balance;
                        }echo $total;
                        ?>
                    </p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xs-4" style="margin-top: 20px;">
        <div class="small-box bg-green" style="border-radius: 10px;">
            <div class="inner" style="text-align: center; height: 130px;">
                <a style="color: wheat;" href="<?php echo base_url(); ?>Dashboard/opd_em">
                    <p style="color: white; font-size: 20px;">Total OPD/Emergency Balance</p>
                    <p style="color: wheat; font-size: 20px;"><?php echo $opd_em_total; ?></p> 
                </a>
            </div>
        </div>
    </div>
    <div class="col-xs-4" style="margin-top: 20px;">
        <div class="small-box bg-green" style="border-radius: 10px;">
            <div class="inner" style="text-align: center; height: 130px;">
                <a style="color: wheat;" href="<?php echo base_url(); ?>Dashboard/cabin">
                    <p style="color: white; font-size: 20px;">Total Cabin Balance</p>
                    <p style="color: wheat; font-size: 20px;"><?php echo $cabin_total; ?></p> 
                </a>
            </div>
        </div>
    </div>
    <div class="col-xs-4" style="margin-top: 20px;">
        <div class="small-box bg-green" style="border-radius: 10px;">
            <div class="inner" style="text-align: center; height: 130px;">
                <a style="color: wheat;" href="<?php echo base_url(); ?>Dashboard/ambulance">
                    <p style="color: white; font-size: 20px;">Total Ambulance Balance</p>
                    <p style="color: wheat; font-size: 20px;"><?php echo $ambulance_total; ?></p> 
                </a>
            </div>
        </div>
    </div>

    <!--<div class="col-xs-4" style="margin-top: 20px;">
        <div class="small-box bg-green" style="border-radius: 10px;">
            <div class="inner" style="text-align: center; height: 130px;">
                    <p style="color: white; font-size: 20px;">Total Discount</p>
                    <p style="color: wheat; font-size: 20px;"><?php echo $total_discount; ?></p> 
            </div>
        </div>
    </div>

    <div class="col-xs-4" style="margin-top: 20px;">
        <div class="small-box bg-green" style="border-radius: 10px;">
            <div class="inner" style="text-align: center; height: 130px;">
                    <p style="color: white; font-size: 20px;">Total Due</p>
                    <p style="color: wheat; font-size: 20px;"><?php echo $total_bill - ($total_collection + $total_discount); ?></p> 
            </div>
        </div>
    </div>
    <div class="col-xs-4" style="margin-top: 20px;">
        <div class="small-box bg-green" style="border-radius: 10px;">
            <div class="inner" style="text-align: center; height: 130px;">
                    <p style="color: white; font-size: 20px;">Total Inactive Client</p>
                    <p style="color: wheat; font-size: 20px;"><?php echo $total_inactive_client; ?></p> 
            </div>
        </div>
    </div>
    <div class="col-xs-4" style="margin-top: 20px;">
        <div class="small-box bg-green" style="border-radius: 10px;">
            <div class="inner" style="text-align: center; height: 130px;">
                    <p style="color: wheat; font-size: 20px;"><?php echo $total_inactive_reseller; ?></p> 
                    <p style="color: white; font-size: 20px;">Total Inactive Reseller</p>
            </div>
        </div>
    </div>-->

    <div class="footer" style="font-size: 16px; font-weight: bolder; margin-top: 40%;">
        <p style="text-align: center; color: green;">Copyright &copy; 2020. Designed & Developed by
            <a href="http://www.greensoftechbd.com/" target="_blank" style="color: brown;">GREEN SOFTWARE &
                TECHNOLOGY</a>. All rights reserved</p>
    </div>
<?php } ?>

