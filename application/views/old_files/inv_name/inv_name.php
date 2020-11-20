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
<?php if (in_array("3", $view_id) || in_array("all", $view_id)) { ?>
<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div style="color: black;">
                    <form id="inv_name_form">
                        <div class="box-body">
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: black; font-weight: bolder; text-align: center;">
                                Create Investigation Name 
                                <!--<b id="msg" style="text-align: right;"></b>-->
                            </p>
                            <div class="row">
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="category">Category</label>
                                    <input type="text" name="category" id="category" class="form-control" required="">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="sub_category">Sub-category</label>
                                    <input type="text" name="sub_category" id="sub_category" class="form-control" required="">
                                </div>
                                <div class="form-group col-sm-4 col-xs-12">
                                    <label for="investigation_name">Investigation Name</label>
                                    <input type="text" name="investigation_name"  id="investigation_name" class="form-control" required="">
                                </div>
                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="rate">Rate</label>
                                    <input type="text" name="rate"  id="rate" class="form-control" required="">
                                </div>
                                <div class="form-group col-sm-1 col-xs-12" style="margin-top: 25px;">
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
    $("#inv_name_form").on("submit", function (e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Insert_data/inv_name";
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
                    $("#inv_name_form")[0].reset();
                    alert(data);
                    view();
                }
            });
        }
    });
    function delete_data(id){
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Delete_data/inv_name";
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
            url: "<?php echo base_url() ?>View_data/inv_name",
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