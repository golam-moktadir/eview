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
<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div style="color: black;" class="no_print">
                    <form id="opd_em_form">
                        <div class="box-body">
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: green; font-weight: bolder; text-align: center;" id="insert_title">
                                Insert OPD/Emergency Receipt
                            </p>
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: blue; font-weight: bolder; text-align: center; display: none;" id="edit_title">
                                Edit OPD/Emergency Receipt
                            </p>
                            <input type="hidden" name="record_id" placeholder="Name" class="form-control"  id="record_id" >
                            <div class="row">
                                <div class="form-group col-sm-3 col-xs-8">
                                    <label for="opd_em">OPD/Emergency</label>
                                    <select name="opd_em" id="opd_em" class="form-control selectpicker"
                                            data-live-search="true">
                                        <option value="">-- Select --</option>
                                        <option value="OPD">OPD</option>
                                        <option value="Emergency">Emergency</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="date">Date</label>
                                    <input type="text" class="form-control new_datepicker"
                                           placeholder="Insert Date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>"
                                           autocomplete="off">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="total_patient_qty">Total Patient Qty</label>
                                    <input type="text" name="total_patient_qty" id="total_patient_qty" class="form-control">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="total_collection">Total Collection</label>
                                    <input type="text" name="total_collection" id="total_collection" class="form-control">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="total_discount">Total Discount</label>
                                    <input type="text" name="total_discount" id="total_discount" class="form-control">
                                </div>
                                <div class="form-group col-sm-3 col-xs-8">
                                    <label for="remarks">Remarks</label>
                                    <select name="remarks[]" id="remarks" class="form-control selectpicker"
                                            multiple>
                                        <option value="Freedom Fighter" selected="">Freedom Fighter</option>
                                        <option value="Old Patient" selected="">Old Patient</option>
                                        <option value="Disabled" selected="">Disabled</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="total_balance">Total Balance</label>
                                    <input type="text" name="total_balance" id="total_balance" class="form-control">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="sub_date">Submission Date</label>
                                    <input type="text" class="form-control new_datepicker"
                                           placeholder="Insert Date" name="sub_date" id="sub_date" value="<?php echo date('Y-m-d'); ?>"
                                           autocomplete="off">
                                </div>
                                 <div class="form-group col-sm-3 col-xs-12">
                                    <label for="received_by">Received By</label>
                                    <input type="text" name="received_by" id="received_by" class="form-control">
                                </div>
                                <div class="form-group col-sm-1 col-xs-12" style="margin-top: 25px;" id="insert_btn">
                                    <button type="submit" class="pull-left btn btn-success">Insert <i
                                            class="fa fa-arrow-circle-right"></i></button>
                                </div>
                                <div class="form-group col-sm-1 col-xs-12" style="margin-top: 25px; display:none;"  id="edit_btn" >
                                    <button type="button" class="pull-left btn btn-info" id="click_edit">Edit <i
                                            class="fa fa-arrow-circle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div>
                    <div class="box-header">
                        <!--                        <div style="text-align: right; padding-right: 27px;" class="no_print">
                                                    <button  id="print" onclick="window.print()" class="btn btn-warning waves-effect waves-light">
                                                        <i class="fa fa-print"></i>
                                                    </button>
                                                </div>-->
                        <p style="font-size: 20px; margin: 0px; padding: 0px; 
                           color: purple; font-weight: bolder; text-align: center;">
                            All OPD/Emergency Receipt
                        </p>
                    </div>

                    <div class="box-body table-responsive"  id="view_table" style="width: 98%; overflow-x: scroll; color: black;">
                    </div>
                </div>
            </section>
        </div>
    </section>
</aside>

<script>
    view();
    $("#opd_em_form").on("submit", function (e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Insert_data/opd_em";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: $(this).serialize(),
                success: function (data) {
                    $("#opd_em_form")[0].reset();
                    alert(data);
                    view();
                }
            });
        }
    });

    function edit_data(id) {
        var url = "<?php echo base_url() ?>Get_data/opd_em";
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {'id': id},
            success: function (data) {
                $("#opd_em_form")[0].reset();
                $('#record_id').val(data[0].record_id);
                $('#opd_em').val(data[0].opd_em);
                $("#opd_em").selectpicker('refresh');
                $('#date').val(data[0].date);
                $('#total_patient_qty').val(data[0].total_patient_qty);
                $('#total_collection').val(data[0].total_collection);
                $('#total_discount').val(data[0].total_discount);
                $("#remarks option:selected").removeAttr("selected");
//                var remarks = data[0].remarks.split(",");
//                jQuery.each(remarks, function (i, val) {
//                    $("#remarks option[value=" + val + "]").prop('selected', true);
//                });              
                $("#remarks").selectpicker('refresh');
                $('#total_balance').val(data[0].total_balance);
                $('#sub_date').val(data[0].sub_date);
                $('#received_by').val(data[0].received_by);
                $('#insert_title').hide();
                $('#edit_title').show();
                $('#insert_btn').hide();
                $('#edit_btn').show();
            }
        });
    }

    $("#click_edit").on("click", function () {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Edit_data/opd_em";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: new FormData($('#opd_em_form')[0]),
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#opd_em_form")[0].reset();
                    $("#opd_em").selectpicker('refresh');
                    $("#remarks").selectpicker('refresh');
                    $('#insert_title').show();
                    $('#edit_title').hide();
                    $('#insert_btn').show();
                    $('#edit_btn').hide();
                    alert(data);
                    view();
                }
            });
        }
    });

    function delete_data(id) {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Delete_data/opd_em";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {'id': id},
                //                    beforeSend: function(){
                //                                     
                //                    },
                success: function (data) {
                    alert(data);
                    view();
                }
            });
        }
    }

    function view() {
        $.ajax({
            url: "<?php echo base_url() ?>View_data/opd_em",
            dataType: "json",
            success: function (data) {
                $("#view_table").html(data);
                datatable();
            }
        });
    }

    function datatable() {
        $('#datatable').dataTable({
            //"info":false,
            "autoWidth": false,
            "order": false
        });
    }
</script>

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
</style>
<?php } ?>