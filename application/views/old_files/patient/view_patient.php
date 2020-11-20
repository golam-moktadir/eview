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
<?php if (in_array("7", $view_id) || in_array("all", $view_id)) { ?>
<table id="datatable" class="datatable table table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align: center;">SL</th>
            <th style="text-align: center;">Date</th>
            <th style="text-align: center;">Patient(ID)</th>
            <th style="text-align: center;">Father/Husband</th>
            <th style="text-align: center;">Age</th>
            <th style="text-align: center;">Sex</th>
            <th style="text-align: center;">Address</th>
            <th style="text-align: center;">NID/Birth_Certificate</th>
            <th style="text-align: center;">Contact</th>
            <th style="text-align: center;"  class="no_print">Action</th>
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
                <td style="text-align: center;"><?php echo $single_value->admission_date; ?></td>
                <td style="text-align: center;"><?php echo $single_value->patient_name."(".$single_value->record_id.")"; ?></td>
                <td style="text-align: center;"><?php echo $single_value->father_husband_name; ?></td>
                <td style="text-align: center;"><?php echo $single_value->age; ?></td>
                <td style="text-align: center;"><?php echo $single_value->sex; ?></td>
                <td style="text-align: center;"><?php echo $single_value->house_no; ?></td>
                <td style="text-align: center;"><?php echo $single_value->mailing_address; ?></td>
                <td style="text-align: center;"><?php echo $single_value->contact; ?></td>
               <td style="text-align: center;"  class="no_print">
                    <?php if (in_array("7", $edit_id) || in_array("all", $edit_id)) { ?>
                    <button class="btn btn-info" onclick="edit_data('<?php echo $single_value->record_id; ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <?php } ?>
                    <?php if (in_array("7", $delete_id) || in_array("all", $delete_id)) { ?>
                    <button class="btn btn-danger" onclick="delete_data('<?php echo $single_value->record_id; ?>')">
                        <i class="fa fa-trash-o"></i>
                    </button> 
                    <?php } ?>
                    <?php if (!in_array("7", $edit_id) && !in_array("7", $delete_id) && !in_array("all", $edit_id) && !in_array("all", $delete_id)) { ?>
                    <b>N/A</b>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>