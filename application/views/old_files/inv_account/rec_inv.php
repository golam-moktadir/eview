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
<?php if (in_array("12", $view_id) || in_array("all", $view_id)) { ?>

<div style="text-align: right; padding-right: 0px;" class="no_print">
    <button  id="print" onclick="window.print()" class="btn btn-warning waves-effect waves-light">
        <i class="fa fa-print"></i>
    </button>
    <a href="<?php echo base_url(); ?>Show_form/inv_account" 
       class="btn btn-warning waves-effect waves-light"><i class="fa fa-window-close-o"></i>
    </a>
</div>
<div  style="color: black; font-weight: bolder; font-size: 14px;">
    <div class="box-body">
        <div class="row">
            <div class="form-group col-sm-1 col-xs-1"style="text-align: center; padding-bottom:0px;margin-bottom:0px;"></div>
            <div class="form-group col-sm-10 col-xs-10" style="text-align: center; padding-bottom:0px;margin-bottom:0px;">
                <?php foreach ($all_hos as $single_value) { ?>
                    <p style="font-size: 30px; color: black;"><img src="<?php echo base_url(); ?>assets/img/hospital_logo/<?php echo $single_value->logo; ?>" height="50" width="5%">
                        <?php echo $single_value->hospital_name; ?></p>
                <?php } ?>
            </div>
            <div class="form-group col-sm-1 col-xs-1" style="text-align: center; padding-bottom:0px;margin-bottom:0px;"></div>

        </div>
        <div class="row">
            <div class="form-group col-sm-4 col-xs-4" style="text-align: center;padding-top:0px;margin-top:0px;"></div>
            <div class="form-group col-sm-4 col-xs-4"style="text-align: center;padding-top:0px;margin-top:0px;">
                <?php foreach ($all_hos as $single_value) { ?>
                    <p style="text-align: center; font-size: 25px;"><?php echo $single_value->address; ?>, 
                        <?php echo $single_value->email; ?></p>
                    <p style="font-size: 25px;"><?php echo $single_value->contact; ?></p>
                <?php } ?>
            </div>
            
        </div>
        <div class="row">
            <div class="form-group col-sm-6 col-xs-6" 
                 style="text-align: left; font-size: 25px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p >Invoice No: <?php echo date('Y', strtotime($all_rec[0]->date))."-".$all_rec[0]->unique_id; ?> </p>
            </div>
            <div class="form-group col-sm-6 col-xs-6" style="text-align: left; font-size: 25px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Invoice Date: <?php echo $all_rec[0]->date; ?> </p>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-6 col-xs-6" style="text-align: left; font-size: 25px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Patient: <?php echo $all_rec[0]->patient_name; ?> </p>
            </div>
            <div class="form-group col-sm-6 col-xs-6"
                  style="text-align: left; font-size: 25px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Age: <?php echo $all_rec[0]->age; ?> </p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6 col-xs-6" style="text-align: left; font-size: 25px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Contact: <?php echo $all_rec[0]->contact; ?> </p>
            </div>
            <div class="form-group col-sm-6 col-xs-6"
                  style="text-align: left; font-size: 25px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Sex: <?php echo $all_rec[0]->sex; ?> </p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 col-xs-12" style="text-align: left; font-size: 25px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Consultant: <?php echo $all_rec[0]->doc_name." (".$all_rec[0]->designation.")"; ?> </p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12 col-xs-12"style="text-align: left; font-size: 25px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <table id="" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center;">SL</th>
                            <th style="text-align: center;">Service Description</th>
                            <th style="text-align: center;">Service Cost (Tk.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count=0;
                        foreach ($all_rec as $single_value) {
                            $count++;
                            ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $count; ?></td>
                                <td style="text-align: center;"><?php echo $single_value->investigation_name; ?></td>
                                <td style="text-align: center;"><?php echo $single_value->rate; ?>/-</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6 col-xs-6"style="text-align: left; font-size: 25px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p style="text-align: left; font-size: 25px;">Remarks: <?php echo $all_rec[0]->remarks; ?></p>
                <p style="text-align: left; font-size: 25px;">Delivery: <?php echo $all_rec[0]->delivery_date; ?></p>
                <p style="text-align: left; font-size: 25px;"><?php echo $this->numbertowords->convert_number($all_rec[0]->balance); ?> Taka Only</p>
                <p style="text-align: center; border: 1px solid black; width: 100px;">PAID</p>
            </div>
            <div class="form-group col-sm-6 col-xs-6"style="text-align: left; font-size: 25px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p style="text-align: right; font-size: 25px;">Net Amount: <?php echo $all_rec[0]->total; ?>/-</p>
                <p style="text-align: right; font-size: 25px;">Discount: <?php echo $all_rec[0]->discount; ?>/-</p>
                <p style="text-align: right; font-size: 25px;">Net Payable: <?php echo $all_rec[0]->balance; ?>/-</p>
            </div><br><br>
         <div class="row">
            <div class="form-group col-sm-12 col-xs-12" style="text-align: left; font-size: 25px; font-weight: bold; padding-bottom: 0px; margin-bottom: 0px;">
                <p>Cash Received By:</p><br>
                <p>_______________________</p>
            </div>
        </div>
    </div>
</div>


<style>
    @media print {
        @page 
        {
     /* 182mm 257mm  */
     size: A4 portrait ;   /* auto is the current printer page size */
		
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
