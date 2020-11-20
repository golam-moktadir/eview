<table id="datatable" class="datatable table table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align: center;">SL</th>
            <th style="text-align: center;">Name</th>
            <th style="text-align: center;">Email</th>
            <th style="text-align: center;">Review</th>
            <th style="text-align: center;" class="no_print">Approval</th>
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
                <td style="text-align: center;"><?php echo $single_value->name; ?></td>
                <td style="text-align: center;"><?php echo $single_value->email; ?></td>
                <td style="text-align: justify;"><?php echo $single_value->review; ?></td>
                <td style="text-align: center;"  class="no_print">
                    <?php
                    if ($single_value->status == "1") {
                        echo "Approved";
                        ?>
                        <button class="btn btn-warning" onclick="change_status('<?php echo $single_value->record_id; ?>', 0)" title="Cancel Approval">
                            <i class="fa fa-eye-slash"></i>
                        </button>
                        <?php
                    } else {
                        echo "Not Approved";
                        ?>
                        <button class="btn btn-success" onclick="change_status('<?php echo $single_value->record_id; ?>', 1)"  title="Approve">
                            <i class="fa fa-eye"></i>
                        </button>
                    <?php } ?>
                </td>
                <td style="text-align: center;"  class="no_print">
                    <button class="btn btn-danger" onclick="delete_data('<?php echo $single_value->record_id; ?>')">
                        <i class="fa fa-trash-o"></i>
                    </button> 
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
