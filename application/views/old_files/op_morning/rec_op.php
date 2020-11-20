<div style="text-align: right; padding-right: 0px;" class="no_print">
    <button  id="print" onclick="window.print()" class="btn btn-warning waves-effect waves-light">
        <i class="fa fa-print"></i>
    </button>
    <a href="<?php echo base_url(); ?>Show_form/op_morning" 
       class="btn btn-warning waves-effect waves-light"><i class="fa fa-window-close-o"></i>
    </a>
</div>
<div  style="color: black; font-weight: bolder; font-size: 14px;">
    <div class="box-body">
        <div class="row">
            <div class="form-group col-sm-1 col-xs-12"style="text-align: center; padding-bottom:0px;margin-bottom:0px;"></div>
            <div class="form-group col-sm-10 col-xs-12" style="text-align: center; padding-bottom:0px;margin-bottom:0px;">
                <?php foreach ($all_hos as $single_value) { ?>
                    <p style="font-size: 28px; color: black;"><img src="<?php echo base_url(); ?>assets/img/hospital_logo/<?php echo $single_value->logo; ?>" height="50" width="8%">
                        <?php echo $single_value->hospital_name; ?></p>
                <?php } ?>
            </div>
            <div class="form-group col-sm-1 col-xs-12" style="text-align: center; padding-bottom:0px;margin-bottom:0px;"></div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4 col-xs-12" style="text-align: center;padding-top:0px;margin-top:0px;"></div>
            <div class="form-group col-sm-4 col-xs-12"style="text-align: center;padding-top:0px;margin-top:0px;">
                <?php foreach ($all_hos as $single_value) { ?>
                    <p style="text-align: center;"><?php echo $single_value->address; ?>, 
                        <?php echo $single_value->email; ?></p>
                    <p style="font-size: 18px;"><?php echo $single_value->contact; ?></p>
                    <p style="background-color: darkblue; font-size: 20px; color: white;">Department of General Surgery</p>
                <?php } ?>
            </div>
            <div class="form-group col-sm-4 col-xs-12" style="text-align: center; border: 1px solid black; padding-top: 8px; width: 250px;">
                <?php
                foreach ($all_bank as $single_value) {
                    if ($single_value->acc_type == "Morning") {
                        ?>
                        <p style="text-align: left; font-size: 25px; font-weight: bold;"><?php echo $single_value->bank_name; ?></p>
                        <p style="text-align: left; font-size: 18px; font-weight: bold;"><?php echo $single_value->address; ?></p>
                        <p style="text-align: left; font-size: 25px; font-weight: bold;"><?php echo $single_value->acc_no; ?></p>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 col-xs-12" 
                 style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p >SL No: <?php echo date('Y', strtotime($all_rec[0]->date))."-".$all_rec[0]->unique_id; ?> </p>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-6 col-xs-12" style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Patient Name: <?php echo $all_rec[0]->patient_name; ?> </p>
            </div>
            <div class="form-group col-sm-6 col-xs-12"
                 style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Age: <?php echo $all_rec[0]->age; ?> </p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4 col-xs-12" style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Ref. Doctor: <?php echo $all_rec[0]->doc_name; ?> </p>
            </div>
            <div class="form-group col-sm-4 col-xs-12" style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Unit: <?php echo $all_rec[0]->unit_name; ?> </p>
            </div>
            <div class="form-group col-sm-4 col-xs-12" style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Date: <?php echo $all_rec[0]->date; ?> </p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4 col-xs-12" style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Type: <?php echo $all_rec[0]->opd_cabin_ward; ?> </p>
            </div>
            <div class="form-group col-sm-4 col-xs-12" style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Bed No: <?php echo $all_rec[0]->bed_no; ?> </p>
            </div>
            <div class="form-group col-sm-4 col-xs-12" style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Reg. No: <?php echo $all_rec[0]->reg_no; ?> </p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 col-xs-12" style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <table id="" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center;" rowspan="2">SL</th>
                            <th style="text-align: center;" rowspan="2">Grade Name</th>
                            <th style="text-align: center;" colspan="2">Amount (TK)</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">Operation Charge</th>
                            <th style="text-align: center;">OT Charge</th>
                            <!--<th style="text-align: center;">Total</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $total1 = 0;
                        $total2 = 0;
                        $total3 = 0;
                        foreach ($all_rec as $single_value) {
                            $total1 += $single_value->operation_charge;
                            $total2 += $single_value->ot_charge;
                            $total3 += $single_value->total;
                            $count++;
                            ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $count; ?></td>
                                <td style="text-align: center;"><?php echo $single_value->grade_name; ?></td>
                                <td style="text-align: center;"><?php echo $single_value->operation_charge; ?>/-</td>
                                <td style="text-align: center;"><?php echo $single_value->ot_charge; ?>/-</td>
                                <!--<td style="text-align: center;"><?php echo $single_value->total; ?>/-</td>-->
                            </tr>
                        <?php } ?>
<!--                        <tr>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;">Total</td>
                            <td style="text-align: center;"><?php echo $total1; ?>/-</td>
                            <td style="text-align: center;"><?php echo $total2; ?>/-</td>
                            <td style="text-align: center;"><?php echo $total3; ?>/-</td>

                        </tr>-->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 col-xs-12"style="text-align: left; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p style="text-align: right; font-size: 17px;">Sub Total: <?php echo $all_rec[0]->total; ?>/-</p>
                <p style="text-align: right; font-size: 17px;">Discount: <?php echo $all_rec[0]->discount; ?>/-</p>
                <p style="text-align: right; font-size: 17px;">Total: <?php echo $all_rec[0]->balance; ?>/-</p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 col-xs-12"style="text-align: left; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p style="text-align: right; font-size: 17px;">Total In Words: <?php echo $this->numbertowords->convert_number($all_rec[0]->balance); ?> Taka Only</p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4 col-xs-12" style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Form No.:............................BSMMU</p>
            </div>
            <div class="form-group col-sm-4 col-xs-12" style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>...................................</p>
                <p>Prepared By</p>
            </div>
            <div class="form-group col-sm-4 col-xs-12" style="text-align: left; font-size: 18px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>..................................</p>
                <p>Bank Officer</p>
            </div>
        </div>
    </div>
</div>


<style>
    @media print {
        @page 
        {
            size: A4 portrait;   /* auto is the current printer page size */
            margin: -5mm 5mm -5mm 10mm;
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
</style>
