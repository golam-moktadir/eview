<table id="datatable" class="datatable table table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align: center;">SL</th>
            <th style="text-align: center;">Receipt_No</th>
            <th style="text-align: center;">Patient(ID)</th>
            <th style="text-align: center;">Age</th>
            <th style="text-align: center;">Doctor</th>
            <th style="text-align: center;">Unit</th>
            <th style="text-align: center;">Date</th>
            <th style="text-align: center;">Type</th>
            <th style="text-align: center;">Bed_No</th>
            <th style="text-align: center;">Reg._No</th>
            <th style="text-align: center;">Amount</th>
            <th style="text-align: center;">Discount</th>
            <th style="text-align: center;">Balance</th>
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
                    <button class="btn btn-info no_print" onclick="show_rec_op_ev('<?php echo $single_value->unique_id; ?>')">
                        <i class="fa fa-list"></i>
                    </button>
                    <?php echo date('Y', strtotime($single_value->date))."-".$single_value->unique_id; ?>
                </td>
                <td style="text-align: center;"><?php echo $single_value->patient_name . " (" . $single_value->record_id . ")"; ?></td>
                <td style="text-align: center;"><?php echo $single_value->age; ?></td>
                <td style="text-align: center;"><?php echo $single_value->doc_name; ?></td>
                <td style="text-align: center;"><?php echo $single_value->unit_name; ?></td>
                <td style="text-align: center;"><?php echo $single_value->date; ?></td>
                <td style="text-align: center;"><?php echo $single_value->opd_cabin_ward; ?></td>
                <td style="text-align: center;"><?php echo $single_value->bed_no; ?></td>
                <td style="text-align: center;"><?php echo $single_value->reg_no; ?></td>
                <td style="text-align: center;"><?php echo $single_value->total; ?></td>
                <td style="text-align: center;"><?php echo $single_value->discount; ?></td>
                <td style="text-align: center;"><?php echo $single_value->balance; ?></td><!--                    <td style="text-align: center;"><?php echo $single_value->cabin_charge; ?></td>
                <td style="text-align: center;"><?php echo $single_value->bed_opd_charge; ?></td>
                <td style="text-align: center;"><?php echo $single_value->non_paying_bed_charge; ?></td>-->
                <td style="text-align: center;">
                    <button class="btn btn-danger" onclick="delete_data('<?php echo $single_value->unique_id; ?>')">
                        <i class="fa fa-trash-o"></i>
                    </button> 
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>