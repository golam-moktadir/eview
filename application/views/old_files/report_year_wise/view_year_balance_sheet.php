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
<?php if (in_array("17", $view_id) || in_array("all", $view_id)) { ?>
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
<p style="font-size: 20px; text-align: center;"><u><?php echo $date_range; ?> Balance Sheet</u></p>

<table id="" class="datatable table table-bordered table-hover">
    <thead>
        <tr>
            <th style="vertical-align: middle; text-align: center;" rowspan="2">SL</th>
            <th style="vertical-align: middle; text-align: center;" rowspan="2">Month</th>
            <th style="vertical-align: middle; text-align: center;" rowspan="2">Opening Balance</th>
            <th style="vertical-align: middle; text-align: center;" rowspan="2">Investigation</th>
            <th style="vertical-align: middle; text-align: center;" rowspan="2">OPD/Emergency</th>
            <th style="vertical-align: middle; text-align: center;" rowspan="2">Cabin</th>
            <th style="vertical-align: middle; text-align: center;" rowspan="2">Ambulance</th>
            <th style="vertical-align: middle; text-align: center;" colspan="<?php echo count($income_list); ?>">Income</th>
            <th style="vertical-align: middle; text-align: center;" colspan="<?php echo count($expense_list); ?>">Expense</th>
            <th style="vertical-align: middle; text-align: center;" rowspan="2">Balance</th>
        </tr>
        <tr>
            <?php foreach ($income_list as $in) { ?>
                <th style="text-align: center;"><?php echo $in->head; ?></th>
            <?php } ?>
            <?php foreach ($expense_list as $ex) { ?>
                <th style="text-align: center;"><?php echo $ex->head; ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $t1 = 0;
        $t3 = 0;
        $t4 = 0;
        $t5 = 0;
        $t6 = 0;
        $t7 = 0;
        $t8 = 0;
        for ($i = 1; $i <= 12; $i++) {
            $t1 += ${"inv_total" . $i};
            $t3 += ${"income_total" . $i};
            $t4 += ${"expense_total" . $i};
            $t5 += (${"inv_total" . $i}+${"opd_em" . $i}+${"cabin" . $i}+${"ambulance" . $i}+ ${"income_total" . $i}) - (${"expense_total" . $i});
            $t6 += ${"opd_em" . $i};
            $t7 += ${"cabin" . $i};
            $t8 += ${"ambulance" . $i};
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $i; ?></td>
                <td style="text-align: center;"><?php echo ${"month" . $i}; ?></td>
                <td style="text-align: center;">
                    <?php echo $i == 1 ? $obd_total : 0; ?>
                </td>
                <td style="text-align: center;"><?php echo ${"inv_total" . $i}; ?></td>
                <td style="text-align: center;"><?php echo ${"opd_em" . $i}; ?></td>
                <td style="text-align: center;"><?php echo ${"cabin" . $i}; ?></td>
                <td style="text-align: center;"><?php echo ${"ambulance" . $i}; ?></td>
                <?php for ($j = 1; $j <= count($income_list); $j++) { ?>
                    <td style="text-align: center;">
                        <?php echo ${"in_" . $i."_".$j}==""?0:${"in_" . $i."_".$j}; ?>
                    </td>
                <?php } ?>
                <?php for ($j = 1; $j <= count($expense_list); $j++) { ?>
                    <td style="text-align: center;">
                        <?php echo ${"ex_" . $i."_".$j}==""?0:${"ex_" . $i."_".$j}; ?>
                    </td>
                <?php } ?>
                <td style="text-align: center;">
                    <?php echo (${"inv_total" . $i}+ ${"opd_em" . $i}+${"cabin" . $i}+${"ambulance" . $i}+${"income_total" . $i}) - (${"expense_total" . $i}); ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">Total</td>
            <td style="text-align: center;"><?php echo $t1; ?></td>
            <td style="text-align: center;"><?php echo $t6; ?></td>
            <td style="text-align: center;"><?php echo $t7; ?></td>
            <td style="text-align: center;"><?php echo $t8; ?></td>
            <td style="text-align: center;" colspan="<?php echo count($income_list); ?>"><?php echo $t3; ?></td>
            <td style="text-align: center;" colspan="<?php echo count($expense_list); ?>"><?php echo $t4; ?></td>
            <td style="text-align: center;"><?php echo $t5; ?></td>
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