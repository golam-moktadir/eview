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
            <section class="col-xs-12 connectedSortable" id="view_inv">
                <div style="color: black;">
                    <form id="debit_voucher_form">
                        <div class="box-body">
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: black; font-weight: bolder; text-align: center;">
                                Insert Debit Voucher
                            </p>
                            <div class="row">
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="date">Billing Date</label>
                                    <input type="text" class="form-control new_datepicker"
                                           placeholder="Insert Date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>"
                                           autocomplete="off">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="supplier_id">Supplier Name</label>
                                    <input type="text" name="supplier_id" id="supplier_id" class="form-control">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="particular">Particular</label>
                                    <input type="text" name="particular" id="particular" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="bill">Bill No</label>
                                    <input type="text" name="bill" id="bill" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="amount">Amount</label>
                                    <input type="text" name="amount" id="amount" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="vat">VAT(%)</label>
                                    <input type="text" name="vat" id="vat" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="tax">TAX(%)</label>
                                    <input type="text" name="tax" id="tax" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="security_money">Security Money(%)</label>
                                    <input type="text" name="security_money" id="security_money" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="received_date">Received Date</label>
                                    <input type="text" class="form-control new_datepicker"
                                           placeholder="Insert Date" name="received_date" id="received_date" value="<?php echo date('Y-m-d'); ?>"
                                           autocomplete="off">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="matured_date">Matured Date</label>
                                    <input type="text" class="form-control new_datepicker"
                                           placeholder="Insert Date" name="matured_date" id="matured_date" value="<?php echo date('Y-m-d'); ?>"
                                           autocomplete="off">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="budget_sector_code">Budget Sector/Code</label>
                                    <input type="text" name="budget_sector_code" id="budget_sector_code" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="financial_year">Financial Year</label>
                                    <input type="text" name="financial_year" id="financial_year" class="form-control">
                                </div>
                                <div class="form-group col-sm-4 col-xs-12">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" name="remarks" id="remarks" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12" style="margin-top: 25px;">
                                    <button type="submit" class="pull-left btn btn-success">Insert <i
                                            class="fa fa-arrow-circle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
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
    $("#debit_voucher_form").on("submit", function (e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Insert_data/debit_voucher";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: $(this).serialize(),
//                    beforeSend: function(){
//                                     
//                    },
                success: function (data) {
                    $("#view_inv").html(data);
                }
            });
        }
    });

    function delete_data(id) {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Delete_data/debit_voucher";
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
            url: "<?php echo base_url() ?>View_data/debit_voucher",
            dataType: "json",
            success: function (data) {
                $("#view_table").html(data);
                datatable();
            }
        });
    }

    function show_debit_inv(id) {
        var url = "<?php echo base_url() ?>Insert_data/show_debit_inv/" + id;
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
//                    data: {'id': id},
            success: function (data) {
                $("#view_inv").html(data);
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