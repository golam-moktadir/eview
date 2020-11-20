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
<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div style="color: black;" class="no_print">
                    <form id="appointment_form">
                        <div class="box-body">
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: green; font-weight: bolder; text-align: center;" id="insert_title">
                                Create Appointment
                            </p>
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: blue; font-weight: bolder; text-align: center; display: none;" id="edit_title">
                                Edit Appointment Info
                            </p>
                            <input type="hidden" name="record_id" placeholder="Name" class="form-control"  id="record_id" >
                            <div class="row">
                                <div class="form-group col-sm-3 col-xs-8">
                                    <label for="doc_id">Doctor Name</label>
                                    <select name="doc_id" id="doc_id" class="form-control selectpicker"
                                            data-live-search="true">
                                        <option value="">-- Select --</option>
                                        <?php foreach ($all_doc as $info) { ?>
                                            <option value="<?php echo $info->record_id; ?>">
                                                <?php echo $info->name . " (" . $info->record_id . ")"; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3 col-xs-8">
                                    <label for="patient_id">Patient Name</label>
                                    <select name="patient_id" id="patient_id" class="form-control selectpicker"
                                            data-live-search="true">
                                        <option value="">-- Select --</option>
                                        <?php foreach ($all_patient as $info) { ?>
                                            <option value="<?php echo $info->record_id; ?>">
                                                <?php echo $info->patient_name . " (" . $info->record_id . ")"; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-1 col-xs-4" style="padding-left: 0px; margin-left: 0px; padding-top: 26px; ">
                                    <a href="<?php echo base_url(); ?>Show_form/patient/app" title="Add Patient"
                                       class="form-control btn btn-info waves-effect waves-light"><i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="app_date">Appointment Date</label>
                                    <input type="text" class="form-control new_datepicker"
                                           placeholder="Insert Date" name="app_date" id="app_date" value="<?php echo date('Y-m-d'); ?>"
                                           autocomplete="off">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="app_time">Appointment Time</label>
                                    <input type="time" name="app_time" id="app_time" class="form-control">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="room">Room No</label>
                                    <input type="text" name="room" id="room" class="form-control">
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
                            All Appointment Info
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
    $("#appointment_form").on("submit", function (e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Insert_data/appointment";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: $(this).serialize(),
                success: function (data) {
                    $("#appointment_form")[0].reset();
                    $("#patient_id").selectpicker('refresh');
                    $("#doc_id").selectpicker('refresh');
                    alert(data);
                    view();
                }
            });
        }
    });

    function edit_data(id) {
        var url = "<?php echo base_url() ?>Get_data/appointment";
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {'id': id},
            success: function (data) {
                $("#appointment_form")[0].reset();
                $('#record_id').val(data[0].record_id);
                $('#patient_id').val(data[0].patient_id);
                $("#patient_id").selectpicker('refresh');
                $('#doc_id').val(data[0].doc_id);
                $("#doc_id").selectpicker('refresh');
                $('#app_date').val(data[0].app_date);
                $('#app_time').val(data[0].app_time);
                $('#room').val(data[0].room);
                $('#insert_title').hide();
                $('#edit_title').show();
                $('#insert_btn').hide();
                $('#edit_btn').show();
            }
        });
    }

    $("#click_edit").on("click", function () {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Edit_data/appointment";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: new FormData($('#appointment_form')[0]),
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#appointment_form")[0].reset();
                    $("#doc_id").selectpicker('refresh');
                    $("#patient_id").selectpicker('refresh');
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
            var url = "<?php echo base_url() ?>Delete_data/appointment";
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
            url: "<?php echo base_url() ?>View_data/appointment",
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