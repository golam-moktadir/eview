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
<div>
    <aside>
        <section class="content" style="padding: 10px;">
            <div class="row">
                <section class="col-xs-12 connectedSortable">
                    <div style="color: black;" class="no_print">
                        <div>
                            <div class="box-body table-responsive"  id="view_table" style="width: 98%; overflow-x: scroll; color: black;"></div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </aside>
</div>

<script>
    view();
    function change_status(id, status_value) {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Edit_data/change_status";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {'id': id, 'status_value': status_value, 'db_name': "review"},
                success: function (data) {
                    alert(data);
                    view();
                }
            });
        }
    }
    function view() {
        $.ajax({
            url: "<?php echo base_url() ?>View_data/review",
            dataType: "json",
            success: function (data) {
                $("#view_table").html(data);
                datatable();
            }
        });
    }
    function delete_data(id) {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Delete_data/review";
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
    function datatable() {
        $('#datatable').dataTable({
            //"info":false,
            "autoWidth": false,
            "order": false
        });
    }
</script>