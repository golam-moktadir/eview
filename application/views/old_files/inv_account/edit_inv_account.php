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
                           color: blue; font-weight: bolder; text-align: center;">
                            Edit Investigation Receipt
                        </p>

                        <?php echo form_open('Edit_data/inv_receipt'); ?>
                        <form id="receipt_form">
                            <div class="row">
                                <div class="form-group col-sm-3 col-xs-8">
                                    <label for="patient_id">Patient Name</label>
                                    <select name="patient_id" id="patient_id" class="form-control selectpicker"
                                            data-live-search="true">
                                        <option value="<?php echo $all_rec[0]->patient_id; ?>"><?php echo $all_rec[0]->patient_name . " (" . $all_rec[0]->patient_id . ")"; ?></option>
                                        <?php foreach ($all_patient as $info) { ?>
                                            <option value="<?php echo $info->record_id; ?>">
                                                <?php echo $info->patient_name . " (" . $info->record_id . ")"; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="age">Age</label>
                                    <input type="text" name="age" id="age" value="<?php echo $all_rec[0]->age; ?>" class="form-control">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="ref_doc_id">Ref. Doctor</label>
                                    <select name="ref_doc_id" id="ref_doc_id" class="form-control selectpicker"
                                            data-live-search="true">
                                        <option value="<?php echo $all_rec[0]->ref_doc_id; ?>"><?php echo $all_rec[0]->doc_name . " (" . $all_rec[0]->ref_doc_id . ")"; ?></option>
                                        <?php foreach ($all_doc as $info) { ?>
                                            <option value="<?php echo $info->record_id; ?>">
                                                <?php echo $info->name . " (" . $info->record_id . ")"; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="date">Insert Date</label>
                                    <input type="text" class="form-control new_datepicker"
                                           placeholder="Insert Date" name="date" id="date" value="<?php echo $all_rec[0]->date; ?>"
                                           autocomplete="off">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="delivery_date">Delivery Date</label>
                                    <input type="text" class="form-control new_datepicker"
                                           placeholder="Delivery Date" name="delivery_date" id="delivery_date" 
                                           value="<?php echo $all_rec[0]->delivery_date; ?>"
                                           autocomplete="off">
                                </div>
                            </div>
                            <input type="hidden" name="unique_id" id="unique_id" value="<?php echo $all_rec[0]->unique_id; ?>" class="form-control">
                            <?php
                            $count = 0;
                            foreach ($all_rec as $single_value) {
                                $count++;
                                ?>
                                <div class="row">
                                    <div class="form-group col-sm-4 col-xs-12" style="text-align: right; font-weight: bold;">Investigation <?php echo $count; ?></div>
                                    <div class="form-group col-sm-3 col-xs-12">
                                        <select name="inv_id_<?php echo $count; ?>" id="<?php echo $count; ?>" class="form-control"
                                                data-live-search="true">
                                            <option value="<?php echo $single_value->inv_id; ?>"><?php echo $single_value->investigation_name; ?></option>
                                            <?php foreach ($all_inv as $info) { ?>
                                                <option value="<?php echo $info->record_id; ?>">
                                                    <?php echo $info->investigation_name; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-1 col-xs-12">
                                        <input type="text" name="rate_<?php echo $count; ?>" value="<?php echo $single_value->rate; ?>" id="rate_<?php echo $count; ?>" class="form-control">
                                    </div>
                                    <input type="hidden" name="record_id_<?php echo $count; ?>" value="<?php echo $single_value->record_id; ?>" id="record_id_<?php echo $count; ?>" class="form-control">
                                </div>
                            <?php } ?>
                            <input type="hidden" id="total_inv" name="total_inv" value="<?php echo $count; ?>" class="form-control">
                            <div class="row">
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="total">Total</label>
                                    <input type="text" readonly="" name="total" value="<?php echo $single_value->total; ?>" id="total" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="discount">Discount</label>
                                    <input type="text" name="discount" value="<?php echo $single_value->discount; ?>"  id="discount" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="balance">Balance</label>
                                    <input type="text" readonly name="balance" value="<?php echo $single_value->balance; ?>"  id="balance" class="form-control">
                                </div>
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" name="remarks"  id="remarks" value="<?php echo $all_rec[0]->remarks; ?>" class="form-control">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <button type="submit" class=" btn btn-info" style="margin-top: 26px;"
                                            id="confirm_btn">Edit <i class="fa fa-arrow-circle-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
            </section>
        </div>
    </section>
</aside>

<script>
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


    $(document).on('change', 'select', function () {
        var inv_num = $(this).attr("id");
        var inv_id = $(this).val();
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
                $('#rate_' + inv_num).val(data[0]);
                var total_inv=parseInt($('#total_inv').val());
                var total=0;
                for (var i = 1; i <= total_inv; i++) {
                    total+=parseInt($('#rate_'+i).val());
                }
                $('#total').val(total);
                $('#discount').val(0);
                $('#balance').val(0)
            }
        });
    });

    $('#discount').on('change paste keyup', function (){
        var discount = parseInt($('#discount').val()) || 0;
        var total = parseInt($('#total').val());
        var balance = total - discount;
        $('#balance').val(balance);
    });
</script>

<script>
    $(function () {
        $(".new_datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            constrainInput: true,
            changeYear: true,
            changeMonth: true
        });
    });
</script>
<style>
    div.ui-datepicker{
        font-size:13px;
    }
    /*.ui-datepicker-calendar a.ui-state-default { background: cyan; }
    .ui-datepicker-calendar td.ui-datepicker-today a { background: red; }*/
    .ui-datepicker-calendar a.ui-state-hover { background: #066;color: white; } 
    .ui-datepicker-calendar a.ui-state-active { background: #066;color: white; } 
</style>
<?php } ?>