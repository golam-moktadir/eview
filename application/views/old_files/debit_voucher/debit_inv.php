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

<div style="text-align: right; padding-right: 0px;" class="no_print">
    <button  id="print" onclick="window.print()" class="btn btn-warning waves-effect waves-light">
        <i class="fa fa-print"></i>
    </button>
    <a href="<?php echo base_url(); ?>Show_form/debit_voucher" 
       class="btn btn-warning waves-effect waves-light"><i class="fa fa-window-close-o"></i>
    </a>
</div>
<div  style="color: black; font-weight: bolder; font-size: 14px;">
    <div class="box-body">
        <div class="row">
            <div class="form-group col-sm-1 col-xs-12"style="text-align: center; padding-bottom:0px;margin-bottom:0px;"></div>
            <div class="form-group col-sm-10 col-xs-12" style="text-align: center; padding-bottom:0px;margin-bottom:0px;">
                <?php foreach ($all_hos as $single_value) { ?>
                    <b style="font-size: 28px; color: black;"><img src="<?php echo base_url(); ?>assets/img/hospital_logo/<?php echo $single_value->logo; ?>" height="40" width="8%">
                        <?php echo $single_value->hospital_name; ?></b>

                <?php } ?>
            </div>
            <div class="form-group col-sm-1 col-xs-12" style="text-align: center; padding-bottom:0px;margin-bottom:0px;"></div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4 col-xs-12" style="text-align: center;padding-top:0px;margin-top:0px;"></div>
            <div class="form-group col-sm-4 col-xs-12"style="text-align: center;padding-top:0px;margin-top:0px;">
                <?php foreach ($all_hos as $single_value) { ?>
                    <b style="text-align: center;"><?php echo $single_value->address; ?>, 
                        <?php echo $single_value->email; ?></b><br>
                        <b style="font-size: 16px;"><?php echo $single_value->contact; ?></b><br>
                    <b style="background-color: darkblue; font-size: 20px; color: white;"><u>Debit Voucher</u></b>
                <?php } ?>
            </div>
        </div>
        <div class="row" style="border: 1px solid black; margin: 0px 5px 0px 5px; padding: 0px; text-align: center;">
            <div class="form-group col-sm-6 col-xs-12" 
                 style="text-align: left; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Bill SL No: <?php echo $all_val[0]->bill; ?> </b>
            </div>
            <div class="form-group col-sm-6 col-xs-12" 
                 style="text-align: left; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Voucher No: <?php echo date('Y', strtotime($all_val[0]->date)) . "-" . $all_val[0]->record_id; ?> </b>
            </div>
        </div>

        <div class="row" style="border: 1px solid black; margin: 0px 5px 0px 5px; padding: 0px; text-align: center;">
            <div class="form-group col-sm-6 col-xs-12" style="text-align: left; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Billing Date: <?php echo $all_val[0]->date; ?> </b>
            </div>
            <div class="form-group col-sm-6 col-xs-12"
                 style="text-align: left; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Date: <?php echo date('Y/m/d'); ?> </b>
            </div>
        </div>
        <div class="row" style="border: 1px solid black; margin: 0px 5px 0px 5px; padding: 0px; text-align: center;">
            <div class="form-group col-sm-6 col-xs-12" style="text-align: left; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Billing Date: <?php echo $all_val[0]->date; ?> </b>
            </div>
            <div class="form-group col-sm-6 col-xs-12"
                 style="text-align: left; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Date: <?php echo date('Y/m/d'); ?> </b>
            </div>
        </div><br>
        <div class="row" style="border: 1px solid black; margin: 0px 5px 0px 5px; padding: 0px; text-align: center;">
            <div class="form-group col-sm-12 col-xs-12" style="text-align: left; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Budget Sector/Code: <?php echo $all_val[0]->budget_sector_code; ?> </b>
            </div>
        </div>
        <div class="row" style="border: 1px solid black; margin: 0px 5px 0px 5px; padding: 0px; text-align: center;">
            <div class="form-group col-sm-12 col-xs-12"
                 style="text-align: left; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Financial Year: <?php echo $all_val[0]->financial_year; ?> </b>
            </div>
        </div>
        <div class="row" style="border: 1px solid black; margin: 0px 5px 0px 5px; padding: 0px; text-align: center;">
            <div class="form-group col-sm-12 col-xs-12" style="text-align: left; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Total Expenditure:  </b>
            </div>
        </div>
        <div class="row" style="border: 1px solid black; margin: 0px 5px 0px 5px; padding: 0px; text-align: center;">
            <div class="form-group col-sm-12 col-xs-12" style="text-align: left; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Rest of the Bill Amount:  </b>
            </div>
        </div><br>
        <div class="row" style="background-color: lightgrey;border: 1px solid black; margin: 0px 5px 0px 5px; padding: 0px; text-align: center;">
            <div class="form-group col-sm-12 col-xs-12" style="text-align: left; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Bill Issued to:  <?php echo $all_val[0]->supplier_id; ?> </b>
            </div>
        </div><br>
        <div class="row" style="margin: 0px 5px 0px 5px; padding: 0px; text-align: center;">
            <div class="form-group col-sm-10 col-xs-12" style="background-color: lightgrey;border: 2px solid black; text-align: left; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Being Amount Paid:  <?php echo $all_val[0]->supplier_id; ?> for <?php echo $all_val[0]->particular; ?> </b>
            </div>
            <div class="form-group col-sm-2 col-xs-12" style="background-color: lightgrey;border: 2px solid black;
                 text-align: center; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Amount </b>
            </div>
        </div>
        <div class="row" style="margin: 0px 5px 0px 5px; padding: 0px; text-align: center;">
            <div class="form-group col-sm-12 col-xs-12" style="border: 2px solid black; text-align: right; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b><?php echo $all_val[0]->amount; ?> </b>
            </div>
        </div>
        <div class="row" style="border: 1px solid black; margin: 0px 5px 0px 5px;">
            <br>
            <div class="row">
                <div class="form-group col-sm-4 col-xs-12"></div>
                <div class="form-group col-sm-2 col-xs-12">
                    <b style="padding-bottom: 0px;">i. Bill</b>
                </div>
                <div class="form-group col-sm-1 col-xs-12">
                </div>
                <div class="form-group col-sm-3 col-xs-12">
                    <b style="padding-bottom: 0px;">= <?php echo $all_val[0]->amount; ?></b>
                </div>
                <div class="form-group col-sm-2 col-xs-12"></div>
            </div>

            <div class="row">
                <div class="form-group col-sm-4 col-xs-12"></div>
                <div class="form-group col-sm-2 col-xs-12">
                    <b style="padding-bottom: 0px;">ii. (-) VAT</b>
                </div>
                <div class="form-group col-sm-1 col-xs-12"><?php echo $all_val[0]->vat; ?>%</div>
                <div class="form-group col-sm-3 col-xs-12">
                    <b style="padding-bottom: 0px;">= <?php echo ($all_val[0]->amount * $all_val[0]->vat) / 100; ?> </b>
                </div>
                <div class="form-group col-sm-2 col-xs-12"></div>
            </div>

            <div class="row">


                <div class="form-group col-sm-4 col-xs-12"></div>
                <div class="form-group col-sm-2 col-xs-12">
                    <b style="padding-bottom: 0px;">iii. (-) TAX</b>
                </div>
                <div class="form-group col-sm-1 col-xs-12"><?php echo $all_val[0]->tax; ?>%</div>
                <div class="form-group col-sm-3 col-xs-12">
                    <b style="padding-bottom: 0px;">= <?php echo ($all_val[0]->amount * $all_val[0]->tax) / 100; ?> </b>
                </div>
                <div class="form-group col-sm-2 col-xs-12"></div>
            </div>

            <div class="row">

                <div class="form-group col-sm-4 col-xs-12"></div>
                <div class="form-group col-sm-2 col-xs-12">
                    <b style="padding-bottom: 0px;">iv. (-) Security Money</b>
                </div>
                <div class="form-group col-sm-1 col-xs-12"><?php echo $all_val[0]->security_money; ?>%</div>
                <div class="form-group col-sm-3 col-xs-12">
                    <b style="padding-bottom: 0px;">= <?php echo ($all_val[0]->amount * $all_val[0]->security_money) / 100; ?> </b>
                </div>
                <div class="form-group col-sm-2 col-xs-12"></div>

            </div>

            <div class="row">
                <div class="form-group col-sm-4 col-xs-12"></div>
                <div class="form-group col-sm-2 col-xs-12">
                    <b style="padding-bottom: 0px; font-weight: bold;">Net Payable to Receipient</b>
                </div>
                <div class="form-group col-sm-1 col-xs-12"></div>
                <div class="form-group col-sm-3 col-xs-12">
                    <b style="padding-bottom: 0px; font-weight: bold;">= 
                        <?php
                        $npr = $all_val[0]->amount - ((($all_val[0]->amount * $all_val[0]->vat) / 100) + (($all_val[0]->amount * $all_val[0]->tax) / 100) +
                                (($all_val[0]->amount * $all_val[0]->security_money) / 100));
                        echo $npr;
                        ?> 
                    </b>
                </div>
                <div class="form-group col-sm-2 col-xs-12"></div>
            </div>

            <div class="row">


                <div class="form-group col-sm-3 col-xs-12"></div>
                <div class="form-group col-sm-4 col-xs-12">Total Billing Amount Distribution:</div>
                <div class="form-group col-sm-1 col-xs-12"></div>
                <div class="form-group col-sm-4 col-xs-12">
                    <b>Paid by Cheque from STD-576</b>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-3 col-xs-12"></div>
                <div class="form-group col-sm-7 col-xs-12" style="text-align: right; border: 1px solid black; background-color: lightgray;">
                    Paid to Receipient <?php echo $all_val[0]->supplier_id ?>
                    <?php
                    $npr = $all_val[0]->amount - ((($all_val[0]->amount * $all_val[0]->vat) / 100) + (($all_val[0]->amount * $all_val[0]->tax) / 100) +
                            (($all_val[0]->amount * $all_val[0]->security_money) / 100));
                    ?> 
                    <b style="padding-left: 60%;"><?php echo $npr; ?></b>
                </div>
                <div class="form-group col-sm-2 col-xs-12"></div>
            </div>

            <div class="row">
                <div class="form-group col-sm-3 col-xs-12"></div>
                <div class="form-group col-sm-7 col-xs-12" style="text-align: right; border: 1px solid black; background-color: lightgray;">
                    To VAT Fund 
                    <b style="padding-left: 60%;"><?php echo ($all_val[0]->amount * $all_val[0]->vat) / 100; ?></b>
                </div>
                <div class="form-group col-sm-2 col-xs-12"></div>
            </div>

            <div class="row">
                <div class="form-group col-sm-3 col-xs-12"></div>
                <div class="form-group col-sm-7 col-xs-12" style="text-align: right; border: 1px solid black; background-color: lightgray;">
                    To TAX Fund 
                    <b style="padding-left: 60%;"><?php echo ($all_val[0]->amount * $all_val[0]->tax) / 100; ?></b>
                </div>
                <div class="form-group col-sm-2 col-xs-12"></div>
            </div>

            <div class="row">
                <div class="form-group col-sm-3 col-xs-12"></div>
                <div class="form-group col-sm-7 col-xs-12" style="text-align: right; border: 1px solid black; background-color: lightgray;">
                    Security Deposit
                    <b style="padding-left: 60%;"><?php echo ($all_val[0]->amount * $all_val[0]->security_money) / 100; ?></b>
                </div>
                <div class="form-group col-sm-2 col-xs-12"></div>
            </div>
        </div>
        <div class="row" style="margin: 0px 5px 0px 5px; padding: 0px; text-align: center;">
            <div class="form-group col-sm-10 col-xs-12" style="background-color: lightgrey;border: 2px solid black; 
                 text-align: center; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Total Amount</b>
            </div>
            <div class="form-group col-sm-2 col-xs-12" style="background-color: lightgrey;border: 2px solid black;
                 text-align: center; font-size: 16px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b><?php echo $all_val[0]->amount; ?></b>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 col-xs-12"style="text-align: left; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b style="text-align: right; font-size: 17px;">Amount In Word: <?php echo $this->numbertowords->convert_number($all_val[0]->amount); ?> Taka Only</b>
            </div>
        </div><br>
        <div class="row">
            <div class="form-group col-sm-12 col-xs-12"style="text-align: left; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Prepared by: <p> ________________________</p></b>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 col-xs-12"style="text-align: left; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Approved by:</b>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>_________________________</b>
            </div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>_________________________</b>
            </div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>_________________________</b>
            </div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>_________________________</b>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Member</b>
            </div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Member</b>
            </div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Member</b>
            </div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Convener</b>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Purchase Committee</b>
            </div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Purchase Committee</b>
            </div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Purchase Committee</b>
            </div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Purchase Committee</b>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Dept. of General Surgery</b>
            </div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Dept. of General Surgery</b>
            </div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Dept. of General Surgery</b>
            </div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Dept. of General Surgery</b>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 col-xs-12" style="text-align: left; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Cheque No :</b>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 col-xs-12" style="text-align: left; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>Issue Date:</b>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>_______________________<br>Receipient Signature</b>
            </div>
            <div class="form-group col-sm-2 col-xs-12"></div>
            <div class="form-group col-sm-2 col-xs-12" style="border: 1px solid black; padding: 15px;
                 text-align: center; font-size: 15px; font-weight: bold;">
                <b>Revenue<br>Stamp</b>
            </div>
            <div class="form-group col-sm-2 col-xs-12"></div>
            <div class="form-group col-sm-3 col-xs-12" style="text-align: center; font-size: 15px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <b>________________________<br>Chairman<br>Dept. of General Surgery</b>
            </div>
        </div>
    </div>
</div>
</div>


<style>
    @media print {
        @page 
        {
            size: A4 portrait;   /* auto is the current printer page size */
            margin: -5mm 5mm 0mm 10mm;
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
<?php } ?>
