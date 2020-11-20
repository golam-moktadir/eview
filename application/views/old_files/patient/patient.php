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
<?php if (in_array("7", $view_id) || in_array("all", $view_id)) { ?>
<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div style="color: black;" class="no_print">
                    <form id="patient_form">
                        <div class="box-body">
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: green; font-weight: bolder; text-align: center;" id="insert_title">
                                Add Patient Info
                            </p>
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: blue; font-weight: bolder; text-align: center; display: none;" id="edit_title">
                                Edit Patient Info
                            </p>
                            <input type="hidden" name="record_id" placeholder="Name" class="form-control"  id="record_id" >
                            <div class="row">
                                <?php if ($url == "inv") { ?>
                                    <div class="form-group col-sm-1 col-xs-4" style="padding-top: 27px;" title="Back">
                                        <a href="<?php echo base_url(); ?>Show_form/inv_account" 
                                           class="form-control btn btn-info waves-effect waves-light"><i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                <?php } elseif ($url == "app") { ?>
                                    <div class="form-group col-sm-1 col-xs-4"  style="padding-top: 27px;" title="Back">
                                        <a href="<?php echo base_url(); ?>Show_form/appointment" 
                                           class="form-control btn btn-info waves-effect waves-light"><i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                <?php } elseif ($url == "amb") { ?>
                                    <div class="form-group col-sm-1 col-xs-4"  style="padding-top: 27px;" title="Back">
                                        <a href="<?php echo base_url(); ?>Show_form/ambulance" 
                                           class="form-control btn btn-info waves-effect waves-light"><i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                <?php } elseif ($url == "cab") { ?>
                                    <div class="form-group col-sm-1 col-xs-4"  style="padding-top: 27px;" title="Back">
                                        <a href="<?php echo base_url(); ?>Show_form/cabin" 
                                           class="form-control btn btn-info waves-effect waves-light"><i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="admission_date">Date</label>
                                    <input type="text" class="form-control new_datepicker"
                                           placeholder="Insert Date" name="admission_date" id="admission_date" value="<?php echo date('Y-m-d'); ?>"
                                           autocomplete="off">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="patient_name">Patient Name</label>
                                    <input type="text" name="patient_name" id="patient_name" class="form-control">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="father_husband_name">Father's/Husband's Name</label>
                                    <input type="text" name="father_husband_name" id="father_husband_name" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="age">Age</label>
                                    <input type="text" name="age" id="age" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="sex">Sex</label>
                                    <select name="sex" id="sex" class="form-control selectpicker"
                                            data-live-search="true">
                                        <option value="">-- Select --</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4 col-xs-12">
                                    <label for="house_no">Address</label>
                                    <input type="text" name="house_no" id="house_no" class="form-control">
                                </div>
                                <div class="form-group col-sm-4 col-xs-12">
                                    <label for="mailing_address">NID/Birth Certificate No.</label>
                                    <input type="text" name="mailing_address" id="mailing_address" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="contact">Contact No.</label>
                                    <input type="text" name="contact" id="contact" class="form-control">
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
                            All Patient List
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
    $("#patient_form").on("submit", function (e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Insert_data/patient";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: $(this).serialize(),
                success: function (data) {
                    $("#patient_form")[0].reset();
                    alert(data);
                    view();
                }
            });
        }
    });

    function edit_data(id) {
        var url = "<?php echo base_url() ?>Get_data/patient";
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {'id': id},
            success: function (data) {
                $("#patient_form")[0].reset();
                $('#record_id').val(data[0].record_id);
                $('#admission_date').val(data[0].admission_date);
                $('#patient_name').val(data[0].patient_name);
                $('#father_husband_name').val(data[0].father_husband_name);
                $('#age').val(data[0].age);
                $('#house_no').val(data[0].house_no);
                $('#sex').val(data[0].sex);
                $("#sex").selectpicker('refresh');
                $('#mailing_address').val(data[0].mailing_address);
                $('#contact').val(data[0].contact);
                $('#insert_title').hide();
                $('#edit_title').show();
                $('#insert_btn').hide();
                $('#edit_btn').show();
            }
        });
    }

    $("#click_edit").on("click", function () {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Edit_data/patient";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: new FormData($('#patient_form')[0]),
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#patient_form")[0].reset();
                    $("#sex").selectpicker('refresh');
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
            var url = "<?php echo base_url() ?>Delete_data/patient";
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
            url: "<?php echo base_url() ?>View_data/patient",
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