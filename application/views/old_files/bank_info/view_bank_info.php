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
<table id="datatable" class="datatable table table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Bank Name</th>
            <th style="text-align: center;">Address</th>
            <th style="text-align: center;">A/C No.</th>
            <th style="text-align: center;">A/C Type</th>
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
                    <td style="text-align: center;"><?php echo $single_value->bank_name; ?></td>
                    <td style="text-align: center;"><?php echo $single_value->address; ?></td>
                    <td style="text-align: center;"><?php echo $single_value->acc_no; ?></td>
                    <td style="text-align: center;"><?php echo $single_value->acc_type; ?></td>
                    <td style="text-align: center;">
                        <button class="btn btn-danger" onclick="delete_data(<?php echo $single_value->record_id; ?>)">
                            <i class="fa fa-trash-o"></i>
                        </button> 
                    </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>