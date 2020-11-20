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
<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable"  id="view_rec">
                <div style="color: black;">
                    <div class="box-body">
                        <p style="font-size: 20px; margin: 0px; padding: 0px; 
                           color: green; font-weight: bolder; text-align: center;">
                            Investigation Receipt
                        </p>
                        <div class="row">
                            <form id="receipt_form">
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
                                    <a href="<?php echo base_url(); ?>Show_form/patient/inv" title="Add Patient"
                                       class="form-control btn btn-info waves-effect waves-light"><i class="fa fa-plus"></i>
                                    </a>
                                </div>


                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="age">Age</label>
                                    <input type="text" name="age" id="age" class="form-control">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
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
                               
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="date">Issue Date</label>
                                    <input type="text" class="form-control new_datepicker"
                                           placeholder="Insert Date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>"
                                           autocomplete="off">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="delivery_date">Delivery Date</label>
                                    <input type="text" class="form-control new_datepicker"
                                           placeholder="Delivery Date" name="delivery_date" id="delivery_date" value="<?php echo date('Y-m-d'); ?>"
                                           autocomplete="off">
                                </div>

                                <div class="form-group col-sm-3 col-xs-12">
                                    <font color="red"><label for="inv_id">Investigation Name</label></font>
                                    <select name="inv_id" id="inv_id" class="form-control selectpicker"
                                            data-live-search="true">
                                        <option value="">-- Select --</option>
                                        <?php foreach ($all_inv as $info) { ?>
                                            <option value="<?php echo $info->record_id; ?>">
                                                <?php echo $info->investigation_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="rate">Rate</label>
                                    <input type="text" name="rate"  id="rate" class="form-control" required="">
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
                                <th style="text-align: center;">Investigation Name</th>
                                <th style="text-align: center;">Rate</th>
                            </tr>
                        </thead>
                        <tbody id="show_all_inv">

                        </tbody>
                    </table>
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
                        <div class="form-group col-sm-3 col-xs-12">
                            <label for="remarks">Remarks</label>
                            <input type="text" name="remarks"  id="remarks" class="form-control">
                        </div>
                        <div class="form-group col-sm-2 col-xs-12">
                            <button type="button" class=" btn btn-info" style="margin-top: 26px;"
                                    id="confirm_btn">Confirm <i class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="box-header">
                        <p style="font-size: 20px; margin: 0px; padding: 0px; 
                           color: purple; font-weight: bolder; text-align: center;">
                            All Investigation List
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

    $('#inv_id').on('change paste keyup', function () {
        var inv_id = $('#inv_id').val();
        var post_data = {
            'inv_id': inv_id,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        };

        $.ajax({
            url: "<?php echo base_url(); ?>Get_data/get_pay_rate",
            type: "post",
            dataType: "json",
            data: post_data,
            success: function (data) {
                $('#rate').val(data[0]);
            }
        });
    });

    var all_inv = new Array();
    var inv_count = 0;
    $("#add_btn").click(function () {
        var inv_id = $('#inv_id').val();
        var inv_name = $("#inv_id option:selected").text().trim();
        var rate = $('#rate').val();
        all_inv[inv_count] = new Array(inv_name, rate, inv_id);
        var full_table = "";
        var total = 0;
        for (var i = 0; i < all_inv.length; i++) {
            total += parseInt(all_inv[i][1]);
            full_table += "<tr><td style='text-align: center;'><button class='btn btn-danger fa fa-trash-o' onclick='delete_added_data(" + i + ")'></button></td>";
            for (var j = 0; j <= 1; j++) {
                full_table += "<td style='text-align: center;'>" + all_inv[i][j] + "</td>";
            }
            full_table += "</tr>";
        }

        $('#show_all_inv').html(full_table);
        $('#total').val(total);
        $('#discount').val(0);
        $('#balance').val(total);
        inv_count++;
    });

    function delete_added_data(arr_no) {
        all_inv.splice(arr_no, 1);
         var full_table = "";
        var total = 0;
        for (var i = 0; i < all_inv.length; i++) {
            total += parseInt(all_inv[i][1]);
            full_table += "<tr><td style='text-align: center;'><button class='btn btn-danger fa fa-trash-o' onclick='delete_added_data(" + i + ")'></button></td>";
            for (var j = 0; j <= 1; j++) {
                full_table += "<td style='text-align: center;'>" + all_inv[i][j] + "</td>";
            }
            full_table += "</tr>";
        }
         $('#total').val(total);
        $('#discount').val(0);
        $('#balance').val(total);
        $('#show_all_inv').html(full_table);
        inv_count--;
    }
    $('#discount').on('change paste keyup', function () {
            var discount = parseInt($('#discount').val()) || 0;
            var total = parseInt($('#total').val());
            var balance=total-discount;
            $('#balance').val(balance);
    });
    $("#confirm_btn").click(function () {
        var inv_id = $('#inv_id').val();
        var patient_id = $('#patient_id').val();
        var age = $('#age').val();
        var ref_doc_id = $('#ref_doc_id').val();
        var date = $('#date').val();
        var delivery_date = $('#delivery_date').val();
        var total = $('#total').val();
        var discount = $('#discount').val();
        var balance = $('#balance').val();
        var remarks = $('#remarks').val();
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Insert_data/inv_receipt";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {'inv_id': inv_id, 'patient_id': patient_id, 'age': age, 'ref_doc_id': ref_doc_id,'date': date, 'delivery_date': delivery_date,
                    'total': total,'discount': discount,'balance': balance, 'remarks': remarks,
                    'all_inv': all_inv},
                success: function (data) {
                    $("#receipt_form")[0].reset();
                    all_inv = new Array();
                    var full_table = "";
                    for (var i = 0; i < all_inv.length; i++) {
                        full_table += "<tr><td style='text-align: center;'><button class='btn btn-danger fa fa-trash-o' onclick='delete_added_data(" + i + ")'></button></td>";
                        for (var j = 0; j <= 1; j++) {
                            full_table += "<td style='text-align: center;'>" + all_inv[i][j] + "</td>";
                        }
                        full_table += "</tr>";
                    }

                    $('#show_all_inv').html(full_table);
                    $("#view_rec").html(data);
                }
            });
        }
    });
    
    function edit_data(id) {
        var url = "<?php echo base_url() ?>Get_data/edit_inv_account/" + id;
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            success: function (data) {
                $("#view_rec").html(data);
                $("#patient_id").selectpicker('refresh');
                $("#ref_doc_id").selectpicker('refresh');
            }
        });
    }

    function delete_data(id) {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Delete_data/inv_account";
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
            url: "<?php echo base_url() ?>View_data/inv_account",
            dataType: "json",
            success: function (data) {
                $("#view_table").html(data);
                datatable();
            }
        });
    }
    function show_rec_inv(id) {
        var url = "<?php echo base_url() ?>Insert_data/show_rec_inv/" + id;
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
<?php } ?>