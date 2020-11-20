<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable"  id="view_rec">
                <div style="color: black;">
                    <div class="box-body">
                        <p style="font-size: 20px; margin: 0px; padding: 0px; 
                           color: green; font-weight: bolder; text-align: center;">
                            Receipt for Operation's Charge Morning
                        </p>
                        <div class="row">
                            <form id="receipt_form">
                                <div class="form-group col-sm-2 col-xs-8">
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
                                    <a href="<?php echo base_url(); ?>Show_form/patient/opm" title="Add Patient"
                                       class="form-control btn btn-info waves-effect waves-light"><i class="fa fa-plus"></i>
                                    </a>
                                </div>

                                <div class="form-group col-sm-1 col-xs-12">
                                    <label for="age">Age</label>
                                    <input type="text" name="age" id="age" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="ref_doc_id">Ref. Doctor</label>
                                    <select name="ref_doc_id" id="ref_doc_id" class="form-control selectpicker"
                                            data-live-search="true">
                                        <option value="">-- Select --</option>
                                        <?php foreach ($all_doc as $info) { ?>
                                            <option value="<?php echo $info->record_id; ?>">
                                                <?php echo $info->name . " (" . $info->record_id . ")"; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="ref_unit_id">Select Unit</label>
                                    <select name="ref_unit_id" id="ref_unit_id" class="form-control selectpicker"
                                            data-live-search="true">
                                        <option value="">-- Select --</option>
                                        <?php foreach ($all_unit as $info) { ?>
                                            <option value="<?php echo $info->record_id; ?>">
                                                <?php echo $info->unit_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="date">Date</label>
                                    <input type="text" class="form-control new_datepicker"
                                           placeholder="Insert Date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>"
                                           autocomplete="off">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="opd_cabin_ward">OPD/Cabin/Ward</label>
                                    <select name="opd_cabin_ward" id="opd_cabin_ward" class="form-control selectpicker"
                                            data-live-search="true">
                                        <option value="">-- Select --</option>
                                        <option value="OPD">OPD</option>
                                        <option value="Cabin">Cabin</option>
                                        <option value="Ward">Ward</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="bed_no">Bed No</label>
                                    <input type="text" name="bed_no" id="bed_no" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="reg_no">Reg. No</label>
                                    <input type="text" name="reg_no" id="reg_no" class="form-control">
                                </div>

                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="grade_id">Grade Name</label>
                                    <select name="grade_id" id="grade_id" class="form-control selectpicker"
                                            data-live-search="true">
                                        <option value="">-- Select --</option>
                                        <?php foreach ($all_grade as $info) { ?>
                                            <option value="<?php echo $info->record_id; ?>">
                                                <?php echo $info->grade_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="operation_charge">Operation Charge</label>
                                    <input type="text" name="operation_charge"  id="operation_charge" class="form-control" required="">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="ot_charge">OT Charge</label>
                                    <input type="text" name="ot_charge"  id="ot_charge" class="form-control" required="">
                                </div>
                            </form>
                            <div class="form-group col-sm-2 col-xs-12">
                                <button style="margin-top: 27px" type="button" class="pull-left btn btn-success"
                                        id="add_btn">Add <i
                                        class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-body table-responsive" style="width: 98%; color: black; overflow-x: scroll;">
                    <table id="purchaseList" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Action</th>
                                <th style="text-align: center;">Grade Name</th>
                                <th style="text-align: center;">Operation Charge</th>
                                <th style="text-align: center;">OT Charge</th>
                            </tr>
                        </thead>
                        <tbody id="show_added_rec">

                        </tbody>
                        <div class="row">
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="total">Total</label>
                                <input type="text" readonly="" name="total"  id="total" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="discount">Discount</label>
                                <input type="text" name="discount"  id="discount" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="balance">Balance</label>
                                <input type="text" readonly name="balance"  id="balance" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <button type="button" class=" btn btn-info" style="margin-top: 26px;"
                                        id="confirm_btn">Confirm <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </div>
                    </table>
                </div>

                <div>
                    <div class="box-header">
                        <p style="font-size: 20px; margin: 0px; padding: 0px; 
                           color: black; font-weight: bolder; text-align: center;">
                            All Info
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
    $('#patient_id').on('change paste keyup', function () {
        var patient_id = $('#patient_id').val();
        var post_data = {
            'patient_id': patient_id,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        };

        $.ajax({
            url: "<?php echo base_url(); ?>Get_data/get_patient_age",
            type: "post",
            dataType: "json",
            data: post_data,
            success: function (data) {
                $('#age').val(data[0]);
            }
        });
    });

    $('#grade_id').on('change paste keyup', function () {
        var grade_id = $('#grade_id').val();
        var post_data = {
            'grade_id': grade_id,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        };

        $.ajax({
            url: "<?php echo base_url(); ?>Get_data/get_grade_rate",
            type: "post",
            dataType: "json",
            data: post_data,
            success: function (data) {
                $('#operation_charge').val(data[0]);
                $('#ot_charge').val(data[1]);
            }
        });
    });

    var all_op = new Array();
    var op_count = 0;
    $("#add_btn").click(function () {
        var grade_id = $('#grade_id').val();
        var grade_name = $("#grade_id option:selected").text().trim();
        var operation_charge = $('#operation_charge').val();
        var ot_charge = $('#ot_charge').val();
        all_op[op_count] = new Array(grade_name, operation_charge, ot_charge, grade_id);
        var full_table = "";
        var total = 0;
        for (var i = 0; i < all_op.length; i++) {
            total += parseInt(all_op[i][1]) + parseInt(all_op[i][2]);
            full_table += "<tr><td style='text-align: center;'><button class='btn btn-danger fa fa-trash-o' onclick='delete_added_data(" + i + ")'></button></td>";
            for (var j = 0; j <= 2; j++) {
                full_table += "<td style='text-align: center;'>" + all_op[i][j] + "</td>";
            }
            full_table += "</tr>";
        }

        $('#show_added_rec').html(full_table);
        $('#total').val(total);
        $('#discount').val(0);
        $('#balance').val(total);
        op_count++;
    });

    function delete_added_data(arr_no) {
        all_op.splice(arr_no, 1);
        var full_table = "";
        var total = 0;
        for (var i = 0; i < all_op.length; i++) {
            total += parseInt(all_op[i][1]) + parseInt(all_op[i][2]);
            full_table += "<tr><td style='text-align: center;'><button class='btn btn-danger fa fa-trash-o' onclick='delete_added_data(" + i + ")'></button></td>";
            for (var j = 0; j <= 2; j++) {
                full_table += "<td style='text-align: center;'>" + all_op[i][j] + "</td>";
            }
            full_table += "</tr>";
        }

        $('#show_added_rec').html(full_table);
        $('#total').val(total);
        $('#discount').val(0);
        $('#balance').val(total);
        op_count--;
    }
    $('#discount').on('change paste keyup', function () {
        var discount = parseInt($('#discount').val()) || 0;
        var total = parseInt($('#total').val());
        var balance = total - discount;
        $('#balance').val(balance);
    });
    $("#confirm_btn").click(function () {
        var patient_id = $('#patient_id').val();
        var age = $('#age').val();
        var ref_doc_id = $('#ref_doc_id').val();
        var ref_unit_id = $('#ref_unit_id').val();
        var date = $('#date').val();
        var opd_cabin_ward = $('#opd_cabin_ward').val();
        var bed_no = $('#bed_no').val();
        var reg_no = $('#reg_no').val();
        var total = $('#total').val();
        var discount = $('#discount').val();
        var balance = $('#balance').val();
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Insert_data/op_receipt";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {'patient_id': patient_id, 'age': age, 'ref_doc_id': ref_doc_id, 'ref_unit_id': ref_unit_id, 'date': date,
                    'opd_cabin_ward': opd_cabin_ward, 'bed_no': bed_no, 'reg_no': reg_no, 'total': total, 'discount': discount, 'balance': balance,
                    'all_op': all_op},
                success: function (data) {
                    $("#receipt_form")[0].reset();
                    all_op = new Array();
                    var full_table = "";
                    for (var i = 0; i < all_op.length; i++) {
                        full_table += "<tr><td style='text-align: center;'><button class='btn btn-danger fa fa-trash-o' onclick='delete_added_data(" + i + ")'></button></td>";
                        for (var j = 0; j <= 3; j++) {
                            full_table += "<td style='text-align: center;'>" + all_op[i][j] + "</td>";
                        }
                        full_table += "</tr>";
                    }

                    $('#show_added_rec').html(full_table);
                    $("#view_rec").html(data);
                }
            });
        }
    });

    function delete_data(id) {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Delete_data/op_account";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {'id': id},
                success: function (data) {
                    alert(data);
                    view();
                }
            });
        }
    }

    function view() {
        $.ajax({
            url: "<?php echo base_url() ?>View_data/op_account",
            dataType: "json",
            success: function (data) {
                $("#view_table").html(data);
                datatable();
            }
        });
    }
    function show_rec_op(id) {
        var url = "<?php echo base_url() ?>Insert_data/show_rec_op/" + id;
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
//                    data: {'id': id},
            success: function (data) {
                $("#view_rec").html(data);
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