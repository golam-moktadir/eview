<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
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
                <?php if (in_array("13", $view_id) || in_array("all", $view_id)) { ?>
                    <style>
                        @media print {
                            @page 
                            {
                                size: A4 landscape;   /* auto is the current printer page size */
                                margin: -5mm 0mm 0mm 10mm;
                            }
                            textarea {
                                height: auto;
                                overflow: visible!important;
                                page-break-inside: avoid !important;
                            } 
                            html
                            {
                                background-color: #FFFFFF; 
                                margin: 0px;  /* this affects the margin on the html before sending to printer */
                            }
                            .no_print {
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
                                <th style="text-align: center;">Type</th>
                                <th style="text-align: center;">Date</th>
                                <th style="text-align: center;">Total Patient Qty</th>
                                <th style="text-align: center;">Total Collection</th>
                                <th style="text-align: center;">Total Discount</th>
                                <th style="text-align: center;">Remarks</th>
                                <th style="text-align: center;">Total Balance</th>
                                <th style="text-align: center;">Submission Date</th>
                                <th style="text-align: center;">Received By</th>
                                <!--<th style="text-align: center;"  class="no_print">Action</th>-->
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
                                    <td style="text-align: center;"><?php echo $single_value->opd_em; ?></td>
                                    <td style="text-align: center;"><?php echo $single_value->date; ?></td>
                                    <td style="text-align: center;"><?php echo $single_value->total_patient_qty; ?></td>
                                    <td style="text-align: center;"><?php echo $single_value->total_collection; ?></td>
                                    <td style="text-align: center;"><?php echo $single_value->total_discount; ?></td>
                                    <td style="text-align: center;"><?php echo $single_value->remarks; ?></td>
                                    <td style="text-align: center;"><?php echo $single_value->total_balance; ?></td>
                                    <td style="text-align: center;"><?php echo $single_value->sub_date; ?></td>
                                    <td style="text-align: center;"><?php echo $single_value->received_by; ?></td>
                    <!--                <td style="text-align: center;"  class="no_print">
                                    <?php if (in_array("13", $edit_id) || in_array("all", $edit_id)) { ?>
                                                            <button class="btn btn-info" onclick="edit_data('<?php echo $single_value->record_id; ?>')">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                    <?php } ?>
                                    <?php if (in_array("13", $delete_id) || in_array("all", $delete_id)) { ?>
                                                            <button class="btn btn-danger" onclick="delete_data('<?php echo $single_value->record_id; ?>')">
                                                                <i class="fa fa-trash-o"></i>
                                                            </button> 
                                    <?php } ?>
                                    <?php if (!in_array("13", $edit_id) && !in_array("13", $delete_id) && !in_array("all", $edit_id) && !in_array("all", $delete_id)) { ?>
                                                            <b>N/A</b>
                                    <?php } ?>
                                    </td>-->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <!--<div class="row">
                        <div class="col-xs-6" style="text-align: left;">
                            <br>
                            <b>In-charge Signature ___________________________</b>
                        </div>
                        <div class="col-xs-6"  style="text-align: right;">
                            <br>
                            <b>Cashier Signature ___________________________</b>
                        </div> 
                    </div>-->
                <?php } ?>
            </section>
        </div>
    </section>
</aside>