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
            <th style="text-align: center;">SL</th>
            <th style="text-align: center;">Voucher</th>
            <th style="text-align: center;">Date</th>
            <th style="text-align: center;">Supplier_Name</th>
            <th style="text-align: center;">Particular</th>
            <th style="text-align: center;">Bill_No</th>
            <th style="text-align: center;">Amount</th>
            <th style="text-align: center;">VAT</th>
            <th style="text-align: center;">TAX</th>
            <th style="text-align: center;">Security_Money</th>
            <th style="text-align: center;">Balance</th>
            <th style="text-align: center;">Received_Date</th>
            <th style="text-align: center;">Matured_Date</th>
            <th style="text-align: center;">Budget_Sector/Code</th>
            <th style="text-align: center;">Financial_Year</th>
            <th style="text-align: center;">Remarks</th>
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
                    <button class="btn btn-info no_print" onclick="show_debit_inv('<?php echo $single_value->record_id; ?>')">
                        <i class="fa fa-list"></i>
                    </button>
                    <?php echo date('Y', strtotime($single_value->date))."-".$single_value->record_id; ?>
                </td>
                <td style="text-align: center;"><?php echo $single_value->date; ?></td>
                <td style="text-align: center;"><?php echo $single_value->supplier_id; ?></td>
                <td style="text-align: center;"><?php echo $single_value->particular; ?></td>
                <td style="text-align: center;"><?php echo $single_value->bill; ?></td>
                <td style="text-align: center;"><?php echo $single_value->amount; ?></td>
                <td style="text-align: center;"><?php echo $single_value->vat; ?>%</td>
                <td style="text-align: center;"><?php echo $single_value->tax; ?>%</td>
                <td style="text-align: center;"><?php echo $single_value->security_money; ?>%</td>
                <?php $npr = $single_value->amount - ((($single_value->amount * $single_value->vat) / 100) + (($single_value->amount * $single_value->tax) / 100) +
                                (($single_value->amount * $single_value->security_money) / 100)); ?>
                <td style="text-align: center;"><?php echo $npr; ?></td>
                <td style="text-align: center;"><?php echo $single_value->received_date; ?></td>
                <td style="text-align: center;"><?php echo $single_value->matured_date; ?></td>
                <td style="text-align: center;"><?php echo $single_value->budget_sector_code; ?></td>
                <td style="text-align: center;"><?php echo $single_value->financial_year; ?></td>
                <td style="text-align: center;"><?php echo $single_value->remarks; ?></td>
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