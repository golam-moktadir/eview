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
<?php if (in_array("10", $view_id) || in_array("all", $view_id)) { ?>
<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div style="color: black;">
                    <form id="income_form">
                    <div class="box-body">
                        <p style="font-size: 20px; margin: 0px; padding: 0px; 
                           color: green; font-weight: bolder; text-align: center;">
                            Income Entry
                        </p>
                        <div class="row">
                            <div class="form-group col-sm-2 col-xs-12" style="display: none;">
                                <label for="ac_type">A/C Type</label>
                                <select name="ac_type" id="ac_type" class="form-control selectpicker"
                                        data-live-search="true">
                                    <option value="">-- Select --</option>
                                    <option value="Morning">Morning</option>
                                    <option value="Evening">Evening</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="date">Date</label>
                                <input type="text" class="form-control new_datepicker"
                                       placeholder="Insert Date" name="date" id="date" value="<?php echo date('Y-m-d');?>"
                                       autocomplete="off">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="particular">Particular</label>
                                <select name="particular" id="particular" class="form-control selectpicker"
                                        data-live-search="true">
                                    <option value="">-- Select --</option>
                                    <?php foreach ($all_income as $info) { ?>
                                        <option value="<?php echo $info->record_id; ?>">
                                            <?php echo $info->head; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                             <div class="form-group col-sm-2 col-xs-12">
                                <label for="amount">Amount</label>
                                <input type="text" name="amount" id="amount" class="form-control">
                            </div>
                             <div class="form-group col-sm-2 col-xs-12">
                                <label for="remarks">Remarks</label>
                                <input type="text" name="remarks" id="remarks" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="paid_by">Issued By</label>
                                <input type="text" readonly="" value="<?php echo $this->session->ses_full_name; ?>" name="paid_by" id="paid_by" class="form-control">
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
                           color: purple; font-weight: bolder; text-align: center;">
                            All Income List
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
        $("#income_form").on("submit", function (e) {
            e.preventDefault();
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Insert_data/income";
                $.ajax({
                    url: url,
                    type: "post",
                    dataType:"json",
                    data: $(this).serialize(),
//                    beforeSend: function(){
//                                     
//                    },
                    success: function (data) {
                        $('#income_head_id').val("");
                        $("#income_head_id").selectpicker('refresh');
                        $("#income_form")[0].reset();
                        alert(data);
                        view();
                    }
                });
            }
        });
        
        function delete_data(id){
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Delete_data/income";
                $.ajax({
                    url: url,
                    type: "post",
                    dataType:"json",
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

        function view(){
            $.ajax({
                url: "<?php echo base_url() ?>View_data/income",
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
                "order":false
            });
        }
</script>
<?php } ?>