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
<?php if (in_array("9", $view_id) || in_array("all", $view_id)) { ?>
<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div style="color: black;">
                     <form id="staff_form">
                    <div class="box-body">
                        <p style="font-size: 20px; margin: 0px; padding: 0px; 
                           color: green; font-weight: bolder; text-align: center;">
                            Add Staff Info
                        </p>
                        <div class="row">
                             <div class="form-group col-sm-3 col-xs-12">
                                <label for="name">Staff Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                             <div class="form-group col-sm-2 col-xs-12">
                                <label for="designation">Designation</label>
                                <input type="text" name="designation" id="designation" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="joining_date">Joining Date</label>
                                <input type="text" class="form-control new_datepicker"
                                       placeholder="Insert Date" name="joining_date" id="joining_date" value="<?php echo date('Y-m-d');?>"
                                       autocomplete="off">
                            </div>
                             <div class="form-group col-sm-2 col-xs-12">
                                <label for="mobile">Mobile</label>
                                <input type="text" name="mobile" id="mobile" class="form-control">
                            </div>
                            <div class="form-group col-sm-3 col-xs-12">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control">
                            </div>
                            
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="salary">Salary</label>
                                <input type="text" name="salary" id="salary" class="form-control">
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
                            All Staff List
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
        $("#staff_form").on("submit", function (e) {
            e.preventDefault();
            if (confirm("Are you sure?")) {
                var all_data = $(this).serializeArray();
                var url = "<?php echo base_url() ?>Insert_data/staff_info";
                $.ajax({
                    url: url,
                    type: "post",
                    dataType:"json",
                    data: $(this).serialize(),
                    success: function (data) {
                        $("#staff_form")[0].reset();
                        alert(data);
                        view();
                    }
                });
            }
        });
        
        function delete_data(id){
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Delete_data/staff_info";
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
                url: "<?php echo base_url() ?>View_data/staff_info",
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