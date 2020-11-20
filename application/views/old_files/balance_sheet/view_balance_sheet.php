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
<?php if (in_array("16", $view_id) || in_array("all", $view_id)) { ?>
    <button  id="print" onclick="scrollDown();" class="btn btn-danger waves-effect waves-light no_print">
        <i class="fa fa-arrow-down"></i>
    </button>
    <button  id="print" onclick="window.print()" class="btn btn-warning waves-effect waves-light no_print">
        <i class="fa fa-print"></i>
    </button>

    <div class="row">
        <div class="form-group col-sm-1 col-xs-12"style="text-align: center; padding-bottom:0px;margin-bottom:0px;"></div>
        <div class="form-group col-sm-10 col-xs-12" style="text-align: center; padding-bottom:0px;margin-bottom:0px;">
            <?php foreach ($all_hos as $single_value) { ?>
                <p style="font-size: 28px; color: black;"><img src="<?php echo base_url(); ?>assets/img/hospital_logo/<?php echo $single_value->logo; ?>" height="40" width="8%">
                    <?php echo $single_value->hospital_name; ?></p>

            <?php } ?>
        </div>
        <div class="form-group col-sm-1 col-xs-12" style="text-align: center; padding-bottom:0px;margin-bottom:0px;"></div>

    </div>
    <!--<div class="row">
        <div class="form-group col-sm-4 col-xs-12" style="text-align: center;padding-top:0px;margin-top:0px;"></div>
        <div class="form-group col-sm-4 col-xs-12"style="text-align: center;padding-top:0px;margin-top:0px;">
    <?php foreach ($all_hos as $single_value) { ?>
                                                <p style="text-align: center;"><?php echo $single_value->address; ?>, 
        <?php echo $single_value->email; ?></p>
                                                <p style="font-size: 18px;"><?php echo $single_value->contact; ?></p>
    <?php } ?>
        </div>
        <div class="form-group col-sm-4 col-xs-12">

        </div>
    </div>-->
    <p style="font-size: 20px; text-align: center;"><u>Balance Sheet (<?php echo $date_range; ?>)</u></p>

    <table id="datatable" class="datatable table table-bordered table-hover">
        <thead>
            <tr>
                <th style="text-align: center;">SL</th>
                <th style="text-align: center;">Date</th>
                <th  style="text-align: center;">Investigation</th>
                <th  style="text-align: center;">OPD/Emergency</th>
                <th  style="text-align: center;">Cabin</th>
                <th  style="text-align: center;">Ambulance</th>
                <th style="text-align: center;">Income</th>
                <th style="text-align: center;">Expense</th>
                <th style="text-align: center;">Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $t1 = 0;
            $t2 = 0;
            $t3 = 0;
            $t4 = 0;
            $t5 = 0;
            $t6 = 0;
            $t7 = 0;
            $t8 = 0;
            for ($i = 1; $i <= $count_it; $i++) {
                $t1 += ${"inv_total" . $i};
                $t2 += ${"opd_em_total" . $i};
                $t3 += ${"cabin_total" . $i};
                $t4 += ${"ambulance_total" . $i};
                $t5 += ${"income_total" . $i};
                $t6 += ${"expense_total" . $i};
                $t7 += (${"inv_total" . $i} + ${"opd_em_total" . $i} + ${"cabin_total" . $i} +
                        ${"ambulance_total" . $i} + ${"income_total" . $i}) - (${"expense_total" . $i});
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $i; ?></td>
                    <td style="text-align: center;"><?php echo ${"date" . $i}; ?></td>
                    <td style="text-align: center;"><?php echo ${"inv_total" . $i}; ?></td>
                    <td style="text-align: center;"><?php echo ${"opd_em_total" . $i}; ?></td>
                    <td style="text-align: center;"><?php echo ${"cabin_total" . $i}; ?></td>
                    <td style="text-align: center;"><?php echo ${"ambulance_total" . $i}; ?></td>
                    <td style="text-align: center;"><?php echo ${"income_total" . $i}; ?></td>
                    <td style="text-align: center;"><?php echo ${"expense_total" . $i}; ?></td>
                    <td style="text-align: center;">
                        <?php
                        echo (${"inv_total" . $i} + ${"opd_em_total" . $i} + ${"cabin_total" . $i} +
                        ${"ambulance_total" . $i} + ${"income_total" . $i}) - (${"expense_total" . $i});
                        ?>
                    </td>
                </tr>
            <?php } ?>
            <tr style="font-weight: bold;">
                <td style="text-align: center;"></td>
                <td style="text-align: center;">Total</td>
                <td style="text-align: center;"><?php echo $t1; ?></td>
                <td style="text-align: center;"><?php echo $t2; ?></td>
                <td style="text-align: center;"><?php echo $t3; ?></td>
                <td style="text-align: center;"><?php echo $t4; ?></td>
                <td style="text-align: center;"><?php echo $t5; ?></td>
                <td style="text-align: center;"><?php echo $t6; ?></td>
                <td style="text-align: center;"><?php echo $t7; ?></td>
            </tr>
        </tbody>
    </table>
    <button  id="print" onclick="scrollUp();" class="btn btn-danger waves-effect waves-light no_print">
        <i class="fa fa-arrow-up"></i>
    </button>


    <script type="text/javascript">
        function scrollDown() {
            window.scrollTo(0, document.body.scrollHeight);
        }

        function scrollUp() {
            window.scrollTo(0, 100);
        }
    </script>
<?php } ?>