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
<?php if (in_array("18", $view_id) || in_array("all", $view_id)) { ?>
<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div style="color: black;">
                    <form id="role_setting_form">
                    <div class="box-body">
                        <p style="font-size: 20px; margin: 0px; padding: 0px; 
                           color: black; font-weight: bolder; text-align: center;">
                            Role Setting
                        </p>
                        <div class="row">
                            <div class="form-group col-sm-3 col-xs-12">
                                <label for="full_name">Full Name</label>
                                <input type="text" name="full_name" id="full_name" class="form-control">
                            </div>
                            <div class="form-group col-sm-3 col-xs-12">
                                <label for="email">E-mail</label>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="mobile">Mobile</label>
                                <input type="text" name="mobile" id="mobile" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="user_name">Username</label>
                                <input type="text" name="user_name" id="user_name" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="password">Password</label>
                                <input type="text" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12" style="height: 155px;">
                                <label for="view_menu">View Menu</label>
                                <select name="view_menu[]" id="view_menu" class="form-control selectpicker"
                                        multiple >
                                    <option value="">-- Select --</option>
                                    <option value="all">All</option>
                                    <?php foreach ($all_menu as $info) { ?>
                                        <option value="<?php echo $info->record_id; ?>">
                                            <?php echo $info->menu_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-2 col-xs-12" style="display: none;">
                                <label for="insert_menu">Insert Menu</label>
                                <select name="insert_menu[]" id="insert_menu" class="form-control selectpicker"
                                         multiple>
                                    <option value="">-- Select --</option>
                                    <option value="all">All</option>
                                    <?php foreach ($all_menu as $info) { ?>
                                        <option value="<?php echo $info->record_id; ?>">
                                            <?php echo $info->menu_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="edit_menu">Edit Menu</label>
                                <select name="edit_menu[]" id="edit_menu" class="form-control selectpicker"
                                         multiple>
                                    <option value="">-- Select --</option>
                                    <option value="all">All</option>
                                    <?php foreach ($all_menu as $info) { ?>
                                        <option value="<?php echo $info->record_id; ?>">
                                            <?php echo $info->menu_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="delete_menu">Delete Menu</label>
                                <select name="delete_menu[]" id="delete_menu" class="form-control selectpicker"
                                       multiple>
                                    <option value="">-- Select --</option>
                                    <option value="all">All</option>
                                    <?php foreach ($all_menu as $info) { ?>
                                        <option value="<?php echo $info->record_id; ?>">
                                            <?php echo $info->menu_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control selectpicker"
                                        >
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
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

                    <div class="box-body table-responsive" id="view_table" style="width: 98%; overflow-x: scroll; color: black;"></div>
                </div>
            </section>
        </div>
    </section>
</aside>

<script>
        view();
        $("#role_setting_form").on("submit", function (e) {
            e.preventDefault();
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Insert_data/role_setting";
                //alert($(this).serialize());
                $.ajax({
                    url: url,
                    type: "post",
                    dataType:"json",
                    data: $(this).serialize(),
//                    beforeSend: function(){
//                                     
//                    },
                    success: function (data) {
                        $('#view_menu').val("");
                        $('#insert_menu').val("");
                        $('#edit_menu').val("");
                        $('#delete_menu').val("");
                        $("#view_menu").selectpicker('refresh');
                        $("#insert_menu").selectpicker('refresh');
                        $("#edit_menu").selectpicker('refresh');
                        $("#delete_menu").selectpicker('refresh');
                        $("#role_setting_form")[0].reset();
                        alert(data);
                        view();
                    }
                });
            }
        });
        
        function delete_data(id){
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Delete_data/role_setting";
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
        
         function change_status(id, status_value){
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Edit_data/change_status";
                $.ajax({
                    url: url,
                    type: "post",
                    dataType:"json",
                    data: {'id': id, 'status_value': status_value},
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
                url: "<?php echo base_url() ?>View_data/role_setting",
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