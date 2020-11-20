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
<?php if (in_array("12", $view_id) || in_array("all", $view_id)) { ?>
<table id="datatable" class="datatable table table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align: center;">SL</th>
            <th style="text-align: center;">Inv_No</th>
            <th style="text-align: center;">Patient(ID)</th>
            <th style="text-align: center;">Age</th>
            <th style="text-align: center;">Doctor</th>
            <th style="text-align: center;">Issue_Date</th>
            <th style="text-align: center;">Delivery</th>
            <th style="text-align: center;">Amount</th>
            <th style="text-align: center;">Discount</th>
            <th style="text-align: center;">Balance</th>
            <th style="text-align: center;">Remarks</th>
<!--            <th style="text-align: center;">Investigation Name</th>
            <th style="text-align: center;">Cabin Charge</th>
            <th style="text-align: center;">Bed & OPD Charge</th>
            <th style="text-align: center;">Non Paying Bed Charge</th>-->
            <th style="text-align: center;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 0;
        foreach ($all_value as $single_value) {
            $count++;
            ?>
            <tr>
                    <td style="text-align: center;"><?php echo $count; ?></td>
                <td style="text-align: center; white-space: nowrap;">
                    <button class="btn btn-info no_print" onclick="show_rec_inv('<?php echo $single_value->unique_id; ?>')">
                        <i class="fa fa-list"></i>
                    </button>
                    <?php echo date('Y', strtotime($single_value->date))."-".$single_value->unique_id; ?>
                </td>
                    <td style="text-align: center;"><?php echo $single_value->patient_name." (".$single_value->patient_id.")"; ?></td>
                    <td style="text-align: center;"><?php echo $single_value->age; ?></td>
                    <td style="text-align: center;"><?php echo $single_value->doc_name; ?></td>
                    <td style="text-align: center;"><?php echo $single_value->date; ?></td>
                    <td style="text-align: center;"><?php echo $single_value->delivery_date; ?></td>
                    <td style="text-align: center;"><?php echo $single_value->total; ?></td>
                    <td style="text-align: center;"><?php echo $single_value->discount; ?></td>
                    <td style="text-align: center;"><?php echo $single_value->balance; ?></td>
                    <td style="text-align: center;"><?php echo $single_value->remarks; ?></td>
                    <td style="text-align: center;"  class="no_print">
                    <?php if (in_array("12", $edit_id) || in_array("all", $edit_id)) { ?>
                    <button class="btn btn-info" onclick="edit_data('<?php echo $single_value->record_id; ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <?php } ?>
                    <?php if (in_array("12", $delete_id) || in_array("all", $delete_id)) { ?>
                    <button class="btn btn-danger" onclick="delete_data('<?php echo $single_value->record_id; ?>')">
                        <i class="fa fa-trash-o"></i>
                    </button> 
                    <?php } ?>
                    <?php if (!in_array("12", $edit_id) && !in_array("12", $delete_id) && !in_array("all", $edit_id) && !in_array("all", $delete_id)) { ?>
                    <b>N/A</b>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>