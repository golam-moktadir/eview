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
<?php if (in_array("8", $view_id) || in_array("all", $view_id)) { ?>
<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div style="color: black;" class="no_print">
                    <form id="doc_con_form">
                        <div class="box-body">
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: green; font-weight: bolder; text-align: center;" id="insert_title">
                                Add Doctor Info
                            </p>
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: blue; font-weight: bolder; text-align: center; display: none;" id="edit_title">
                                Edit Doctor Info
                            </p>
                            <input type="hidden" name="record_id" placeholder="Name" class="form-control"  id="record_id" >
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <strong><label for="name">Name</label></strong>
                                        <input type="text" required="" name="name" placeholder="Name" class="form-control"  id="name" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name_bangla">নাম</label>
                                        <input type="text" name="name_bangla" placeholder="ডাক্তার নাম" class="form-control"  id="name_bangla" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <strong><label for="picture">Picture</label></strong>
                                        <input type="file" name="picture" class="form-control"  id="picture" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <strong><label for="mobile">Mobile</label></strong>
                                        <input type="text" name="mobile" placeholder="Mobile No." class="form-control"  id="mobile" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="designation">Designation</label>
                                        <input type="text"  name="designation"  placeholder="Designation" class="form-control"  id="designation" >
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="designation_bangla">উপাধি</label>
                                        <input type="text" name="designation_bangla" placeholder="উপাধি" class="form-control"  id="designation_bangla" >
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <strong><label for="specialist">Specialist</label></strong>
                                        <input type="text"  name="specialist"  placeholder="Specialist" class="form-control"  id="specialist" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="specialist_bangla">স্পেশালিস্ট</label>
                                        <input type="text" name="specialist_bangla"  placeholder="স্পেশালিস্ট" class="form-control"  id="specialist_bangla" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <strong><label for="bmdc">BMDC Reg:</label></strong>
                                        <input type="text" name="bmdc"  placeholder="BMDC Reg" class="form-control"  id="bmdc" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="bmdc_bangla">বিএমডিসি রেজি:</label>
                                        <input type="text" name="bmdc_bangla"  placeholder="BMDC Bangla" class="form-control"  id="bmdc_bangla" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <strong><label for="gender">Gender</label></strong>
                                        <select name="gender" id="gender"  class="form-control selectpicker">
                                            <option value="">Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <strong><label for="blood_group">Blood Group</label></strong>
                                        <select name="blood_group" id="blood_group"  class="form-control selectpicker">
                                            <option value="">Select</option>
                                            <option value="A+">A+</option>
                                            <option value="O+">O+</option>
                                            <option value="B+">B+</option>
                                            <option value="AB+">AB+</option>
                                            <option value="A-">A-</option>
                                            <option value="O-">O-</option>
                                            <option value="B-">B-</option>
                                            <option value="AB-">AB-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <strong><label for="address">Address</label></strong>
                                        <input type="text" name="address"  placeholder="Address" class="form-control"  id="address" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <strong><label for="education">Education/Degree</label></strong>
                                        <input type="text" name="education"  placeholder="Education/Degree" class="form-control"  id="education" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="education_bangla">শিক্ষা/ডিগ্রী</label>
                                        <input type="text" name="education_bangla"  placeholder="শিক্ষা/ডিগ্রী" class="form-control"  id="education_bangla" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <strong><label for="current_emp">Current Employment</label></strong>
                                        <input type="text"  name="current_emp" placeholder="Current Employement" class="form-control"  id="current_emp" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="current_emp_bangla">বর্তমান চাকরি</label>
                                        <input type="text" name="current_emp_bangla" placeholder="বর্তমান চাকরি" class="form-control"  id="current_emp_bangla" >
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <strong><label for="training_sub">Training of Subject</label></strong>
                                        <input type="text" name="training_sub" placeholder="Training of Subject" class="form-control"  id="training_sub" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="training_sub_bangla">প্রশিক্ষণের বিষয়</label>
                                        <input type="text" name="training_sub_bangla" placeholder="প্রশিক্ষণের বিষয়" class="form-control"  id="training_sub_bangla" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <strong><label for="training_place">Training Place</label></strong>
                                        <input type="text" name="training_place" placeholder="Training Place" class="form-control"  id="training_place" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <p for="training_place_bangla">প্রশিক্ষণের স্থান </label>
                                            <input type="text" name="training_place_bangla" placeholder="প্রশিক্ষণের স্থান" class="form-control"  id="training_place_bangla" >
                                    </div>
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
                        <p style="font-size: 20px; margin: 0px; padding: 0px; 
                           color: purple; font-weight: bolder; text-align: center;">
                            All Doctor List
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
    $("#doc_con_form").on("submit", function (e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Insert_data/doc_con";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#doc_con_form")[0].reset();
                    alert(data);
                    view();
                }
            });
        }
    });

    function edit_data(id) {
        var url = "<?php echo base_url() ?>Get_data/doc_con";
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {'id': id},
            success: function (data) {
                $("#doc_con_form")[0].reset();
                $('#record_id').val(data[0].record_id);
                $('#name').val(data[0].name);
                $('#name_bangla').val(data[0].name_bangla);
                $('#mobile').val(data[0].mobile);
                $('#designation').val(data[0].designation);
                $('#designation_bangla').val(data[0].designation_bangla);
                $('#specialist').val(data[0].specialist);
                $('#specialist_bangla').val(data[0].specialist_bangla);
                $('#bmdc').val(data[0].bmdc);
                $('#bmdc_bangla').val(data[0].bmdc_bangla);
                $('#gender').val(data[0].gender);
                $("#gender").selectpicker('refresh');
                $('#blood_group').val(data[0].blood_group);
                $("#blood_group").selectpicker('refresh');
                $('#address').val(data[0].address);
                $('#education').val(data[0].education);
                $('#education_bangla').val(data[0].education_bangla);
                $('#current_emp').val(data[0].current_emp);
                $('#current_emp_bangla').val(data[0].current_emp_bangla);
                $('#training_sub').val(data[0].training_sub);
                $('#training_sub_bangla').val(data[0].training_sub_bangla);
                $('#training_place').val(data[0].training_place);
                $('#training_place_bangla').val(data[0].training_place_bangla);
                $('#insert_title').hide();
                $('#edit_title').show();
                $('#insert_btn').hide();
                $('#edit_btn').show();
            }
        });
    }

    $("#click_edit").on("click", function () {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Edit_data/doc_con";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: new FormData($('#doc_con_form')[0]),
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#doc_con_form")[0].reset();
                    $("#gender").selectpicker('refresh');
                    $("#blood_group").selectpicker('refresh');
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
            var url = "<?php echo base_url() ?>Delete_data/doc_con";
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
            url: "<?php echo base_url() ?>View_data/doc_con",
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
