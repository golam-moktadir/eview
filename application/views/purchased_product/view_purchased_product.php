<table id="datatable" class="datatable table table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align: center;">SL</th>
            <th style="text-align: center;">Name</th>
            <th style="text-align: center;">Mobile</th>
            <th style="text-align: center;">Address</th>
            <th style="text-align: center;">TrxID</th>
            <th style="text-align: center;">Purchase Details</th>
            <th style="text-align: center;">Shipping</th>
            <th style="text-align: center;">Total</th>
            <th style="text-align: center;">Discount</th>
            <th style="text-align: center;">Net Total</th>
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
                <td style="text-align: center;"><?php echo $single_value->mobile; ?></td>
                <td style="text-align: center;"><?php echo $single_value->address; ?></td>
                <td style="text-align: center;"><?php echo $single_value->trx_id; ?></td>
                <td style="text-align: center;"><?php echo nl2br($single_value->purchase_details); ?></td>
                <td style="text-align: center;"><?php echo $single_value->shipping; ?></td>
                <td style="text-align: center;"><?php echo $single_value->total; ?></td>
                <td style="text-align: center;"><?php echo $single_value->discount; ?></td>
                <td style="text-align: center;"><?php echo $single_value->net_total; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>