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
<?php if (in_array("8", $view_id) || in_array("all", $view_id)) { ?>

<table id="datatable" class="datatable table table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align: center;">SL</th>
            <th style="text-align: center;">Name(ID)</th>
            <th style="text-align: center;">Mobile</th>
            <th style="text-align: center;">Designation</th>
            <th style="text-align: center;">Specialist</th>
            <th style="text-align: center;">BMDC_Reg:</th>
            <th style="text-align: center;">Gender</th>
            <th style="text-align: center;">Blood_Group</th>
            <th style="text-align: center;">Address</th>
            <th style="text-align: center;">Edu/Degree</th>
            <th style="text-align: center;">Current_Empl</th>
            <th style="text-align: center;">Training_Sub</th>
            <th style="text-align: center;">Training_Place</th>
            <th style="text-align: center;" class="no_print">Action</th>
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
                <td style="text-align: center;"><?php echo $single_value->name." (".$single_value->record_id.")"; ?></td>
                <td style="text-align: center;"><?php echo $single_value->mobile; ?></td>
                <td style="text-align: center;"><?php echo $single_value->designation; ?></td>
                <td style="text-align: center;"><?php echo $single_value->specialist; ?></td>
                <td style="text-align: center;"><?php echo $single_value->bmdc; ?></td>
                <td style="text-align: center;"><?php echo $single_value->gender; ?></td>
                <td style="text-align: center;"><?php echo $single_value->blood_group; ?></td>
                <td style="text-align: center;"><?php echo $single_value->address; ?></td>
                <td style="text-align: center;"><?php echo $single_value->education; ?></td>
                <td style="text-align: center;"><?php echo $single_value->current_emp; ?></td>
                <td style="text-align: center;"><?php echo $single_value->training_sub; ?></td>
                <td style="text-align: center;"><?php echo $single_value->training_place; ?></td>
                <td style="text-align: center;"  class="no_print">
                    <?php if (in_array("8", $edit_id) || in_array("all", $edit_id)) { ?>
                    <button class="btn btn-info" onclick="edit_data('<?php echo $single_value->record_id; ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <?php } ?>
                    <?php if (in_array("8", $delete_id) || in_array("all", $delete_id)) { ?>
                    <button class="btn btn-danger" onclick="delete_data('<?php echo $single_value->record_id; ?>')">
                        <i class="fa fa-trash-o"></i>
                    </button> 
                    <?php } ?>
                    <?php if (!in_array("8", $edit_id) && !in_array("8", $delete_id) &&
                            !in_array("all", $edit_id) && !in_array("all", $delete_id)) { ?>
                    <b>N/A</b>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>