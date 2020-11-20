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
<?php if (in_array("2", $view_id) || in_array("all", $view_id)) { ?>
<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div style="color: black;">
                    <form id="hospital_form">
                    <div class="box-body">
                        <p style="font-size: 20px; margin: 0px; padding: 0px; 
                           color: black; font-weight: bolder; text-align: center;">
                            Create Hospital Name
                        </p>
                        <div class="row">
                             <div class="form-group col-sm-2 col-xs-12">
                                <label for="logo">Logo Icon</label>
                                <input type="file" name="logo" id="logo" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="hospital_name">Hospital Name</label>
                                <input type="text" name="hospital_name" id="hospital_name" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="email">E-mail</label>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="contact">Contact No</label>
                                <input type="text" name="contact" id="contact" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12" style="margin-top: 25px;">
                                <button type="submit" class="pull-left btn btn-success">Create <i
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
        $("#hospital_form").on("submit", function (e) {
            e.preventDefault();
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Insert_data/hospital_name";
                $.ajax({
                    url: url,
                    type: "post",
                    dataType:"json",
                    data: new FormData( this ),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#hospital_form")[0].reset();
                        alert(data);
                        view();
                    }
                });
            }
        });
        function delete_data(id){
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Delete_data/hospital_name";
                $.ajax({
                    url: url,
                    type: "post",
                    dataType:"json",
                    data: {'id': id},
                    success: function (data) {
                        alert(data);
                        view();
                    }
                });
            }
        }
        function view(){
            $.ajax({
                url: "<?php echo base_url() ?>View_data/hospital_name",
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