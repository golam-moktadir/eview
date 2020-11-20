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
<?php if (in_array("14", $view_id) || in_array("all", $view_id)) { ?>
<style>
    @media print {
        @page 
        {
            size: A4 landscape;   /* auto is the current printer page size */
            margin: -5mm 0mm 0mm 10mm;
        }
        html
        {
            background-color: #FFFFFF; 
            margin: 0px;  /* this affects the margin on the html before sending to printer */
        }
        .no_print {
            display: none;
        }
        ::-webkit-scrollbar{
            display: none;
        }
        .dataTables_filter {
            display: none;
        }
        .dataTables_paginate {
            display: none;
        }
        .dataTables_info {
            display: none;
        }
        .dataTables_length {
            display: none;
        }
        .dataTables_orderable{
            display: none;
        }
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            display: none;
        }
    }
    /*     table.table-bordered{
            border: grey 1px solid;
            font-weight: bold;
            color: black;
            font-size: 13px;
        }
        table.table-bordered > thead > tr > th{
            border: grey 1px solid;
            font-weight: bold;
            color: black;
            font-size: 13px;
        }
        table.table-bordered > tbody > tr > td{
            border: grey 1px solid;
            font-weight: bold;
            color: black;
            font-size: 13px;
        }*/
</style>
<button  id="print" onclick="window.print()" class="btn btn-warning waves-effect waves-light no_print">
    <i class="fa fa-print"></i>
</button>
<table id="datatable" class="datatable table table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align: center;">SL</th>
            <th style="text-align: center;">Patient_Name(ID)</th>
            <th style="text-align: center;">Total Stay Duration</th>
            <th style="text-align: center;">Total Receivable</th>
            <th style="text-align: center;">Total Payable Charge</th>
            <th style="text-align: center;">Recipient Name</th>
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
                <td style="text-align: center;"><?php echo $single_value->patient_name."(".$single_value->patient_id.")"; ?></td>
                <td style="text-align: center;"><?php echo $single_value->duration; ?></td>
                <td style="text-align: center;"><?php echo $single_value->receivable; ?></td>
                <td style="text-align: center;"><?php echo $single_value->payable; ?></td>
                <td style="text-align: center;"><?php echo $single_value->recipient; ?></td>
               <td style="text-align: center;"  class="no_print">
                    <?php if (in_array("14", $edit_id) || in_array("all", $edit_id)) { ?>
                    <button class="btn btn-info" onclick="edit_data('<?php echo $single_value->record_id; ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <?php } ?>
                    <?php if (in_array("14", $delete_id) || in_array("all", $delete_id)) { ?>
                    <button class="btn btn-danger" onclick="delete_data('<?php echo $single_value->record_id; ?>')">
                        <i class="fa fa-trash-o"></i>
                    </button> 
                    <?php } ?>
                    <?php if (!in_array("14", $edit_id) && !in_array("14", $delete_id) &&
                            !in_array("all", $edit_id) && !in_array("all", $delete_id)) { ?>
                    <b>N/A</b>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="row">
    <div class="col-xs-6" style="text-align: left;"></div>
    <div class="col-xs-6"  style="text-align: right;">
       <br>
        <b>Authorization Signature ___________________________</b>
    </div>
</div>
<?php } ?>