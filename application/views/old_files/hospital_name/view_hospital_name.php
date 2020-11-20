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
<?php if (in_array("2", $view_id) || in_array("all", $view_id)) { ?>
<table id="datatable" class="datatable table table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Logo</th>
            <th style="text-align: center;">Hospital Name</th>
            <th style="text-align: center;">Address</th>
            <th style="text-align: center;">Email</th>
            <th style="text-align: center;">Contact</th>
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
                <td style="text-align: center;">
                    <?php 
                    if (file_exists('./assets/img/hospital_logo/' . $single_value->logo)) { ?>
                        <img src="<?php echo base_url(); ?>assets/img/hospital_logo/<?php echo $single_value->logo; ?>"
                             width="50" height="50">
                    <?php } ?>
                </td>
                <td style="text-align: center;"><?php echo $single_value->hospital_name; ?></td>
                <td style="text-align: center;"><?php echo $single_value->address; ?></td>
                <td style="text-align: center;"><?php echo $single_value->email; ?></td>
                <td style="text-align: center;"><?php echo $single_value->contact; ?></td>
                <td style="text-align: center;"  class="no_print">
                    <?php if (in_array("2", $edit_id) || in_array("all", $edit_id)) { ?>
                    <button class="btn btn-info" onclick="edit_data('<?php echo $single_value->record_id; ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <?php } ?>
                    <?php if (in_array("2", $delete_id) || in_array("all", $delete_id)) { ?>
                    <button class="btn btn-danger" onclick="delete_data('<?php echo $single_value->record_id; ?>')">
                        <i class="fa fa-trash-o"></i>
                    </button> 
                    <?php } ?>
                    <?php if (!in_array("2", $edit_id) && !in_array("2", $delete_id) &&
                            !in_array("all", $edit_id) && !in_array("all", $delete_id)) { ?>
                    <b>N/A</b>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>