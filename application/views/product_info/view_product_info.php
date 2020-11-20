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
            <th style="text-align: center;" class="no_print">Action</th>
            <th style="text-align: center;">Category</th>
            <th style="text-align: center;">Sub Category</th>
            <th style="text-align: center;">Product Name</th>
            <th style="text-align: center;">Product Code</th>
            <th style="text-align: center;">Brand</th>
            <th style="text-align: center;">B.Picture</th>
            <th style="text-align: center;">Price</th>
            <th style="text-align: center;">Qty</th>
            <th style="text-align: center;">Discount</th>
            <th style="text-align: center;">Balance</th>
            <th style="text-align: center;">Description</th>
            <th style="text-align: center;">Specification</th>
            <th style="text-align: center;">Picture-1</th>
            <th style="text-align: center;">Picture-2</th>
            <th style="text-align: center;">Picture-3</th>
            <th style="text-align: center;">Picture-4</th>
            <th style="text-align: center;">Picture-5</th>
            <th style="text-align: center;">Picture-6</th>



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
                <td style="text-align: center; white-space: nowrap;"  class="no_print">
                        <button class="btn btn-info" onclick="edit_data('<?php echo $single_value->record_id; ?>')">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger" onclick="delete_data('<?php echo $single_value->record_id; ?>')">
                            <i class="fa fa-trash-o"></i>
                        </button> 
                </td>
                <td style="text-align: center;"><?php echo $single_value->cat; ?></td>
                <td style="text-align: center;"><?php echo $single_value->sub_cat; ?></td>
                <td style="text-align: center;"><?php echo $single_value->name; ?></td>
                <td style="text-align: center;"><?php echo $single_value->code; ?></td>
                <td style="text-align: center;"><?php echo $single_value->brand; ?></td>
                <td style="text-align: center;">
                    <a href="<?php echo base_url(); ?>assets/img/brands/<?php echo $single_value->image ?>" target="_blank">
                        <img src="<?php echo base_url(); ?>assets/img/brands/<?php echo $single_value->image; ?>"
                             width="60" height="50">
                    </a>
                </td>
                <td style="text-align: center;"><?php echo $single_value->price; ?></td>
                <td style="text-align: center;"><?php echo $single_value->qty; ?></td>
                <td style="text-align: center;"><?php echo $single_value->discount; ?></td>
                <td style="text-align: center;"><?php echo $single_value->balance; ?></td>
                <td style="text-align: center;"><?php echo $single_value->description; ?></td>
                <td style="text-align: center;"><?php echo $single_value->specification; ?></td>
                <td style="text-align: center;">
                    <a href="<?php echo base_url(); ?>assets/img/product/<?php echo $single_value->record_id . "_1.jpg"; ?>" target="_blank">
                        <img src="<?php echo base_url(); ?>assets/img/product/<?php echo $single_value->record_id . "_1.jpg"; ?>"
                             width="60" height="50">
                    </a>
                </td>
                <td style="text-align: center;">
                    <a href="<?php echo base_url(); ?>assets/img/product/<?php echo $single_value->record_id . "_2.jpg"; ?>" target="_blank">
                        <img src="<?php echo base_url(); ?>assets/img/product/<?php echo $single_value->record_id . "_2.jpg"; ?>"
                             width="60" height="50">
                    </a>
                </td>
                <td style="text-align: center;">
                    <a href="<?php echo base_url(); ?>assets/img/product/<?php echo $single_value->record_id . "_3.jpg"; ?>" target="_blank">
                        <img src="<?php echo base_url(); ?>assets/img/product/<?php echo $single_value->record_id . "_3.jpg"; ?>"
                             width="60" height="50">
                    </a>
                </td>
                <td style="text-align: center;">
                    <a href="<?php echo base_url(); ?>assets/img/product/<?php echo $single_value->record_id . "_4.jpg"; ?>" target="_blank">
                        <img src="<?php echo base_url(); ?>assets/img/product/<?php echo $single_value->record_id . "_4.jpg"; ?>"
                             width="60" height="50">
                    </a>
                </td>
                <td style="text-align: center;">
                    <a href="<?php echo base_url(); ?>assets/img/product/<?php echo $single_value->record_id . "_5.jpg"; ?>" target="_blank">
                        <img src="<?php echo base_url(); ?>assets/img/product/<?php echo $single_value->record_id . "_5.jpg"; ?>"
                             width="60" height="50">
                    </a>
                </td>
                <td style="text-align: center;">
                    <a href="<?php echo base_url(); ?>assets/img/product/<?php echo $single_value->record_id . "_6.jpg"; ?>" target="_blank">
                        <img src="<?php echo base_url(); ?>assets/img/product/<?php echo $single_value->record_id . "_6.jpg"; ?>"
                             width="60" height="50">
                    </a>
                </td>

            </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>