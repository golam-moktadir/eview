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
<?php if (in_array("8", $view_id) || in_array("all", $view_id)) { ?>
    <aside>
        <section class="content" style="padding: 10px;">
            <div class="row">
                <section class="col-xs-12 connectedSortable">
                    <div style="color: black;" class="no_print">
                        <form id="photo_gallery_form">
                            <div class="box-body">
                                <p style="font-size: 20px; margin: 0px; padding: 0px; 
                                   color: green; font-weight: bolder; text-align: center;" id="insert_title">
                                    Insert Photo Gallery
                                </p>
                                <p style="font-size: 20px; margin: 0px; padding: 0px; 
                                   color: blue; font-weight: bolder; text-align: center; display: none;" id="edit_title">
                                    Edit Photo Gallery
                                </p>
                                <input type="hidden" name="record_id" placeholder="Name" class="form-control"  id="record_id" >
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <strong><label for="title">Title</label></strong>
                                            <input type="text" name="title" placeholder="title" class="form-control"  id="title" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <strong><label for="details">Details</label></strong>
                                            <textarea type="text" name="details" class="form-control"  id="details" rows="6" cols="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <strong><label for="picture">Picture</label></strong>
                                            <input type="file" name="picture" class="form-control"  id="picture" >
                                        </div>
                                    </div>


                                    <div class="form-group col-sm-1 col-xs-12" style="margin-top: 25px;" id="insert_btn">
                                        <button type="submit" class="pull-left btn btn-success">Insert <i
                                                class="fa fa-arrow-circle-right"></i></button>
                                    </div>
                                    <div class="form-group col-sm-1 col-xs-12" style="margin-top: 25px; display:none;"  id="edit_btn" >
                                        <button type="button" class="pull-left btn btn-info" id="click_edit">Edit <i
                                                class="fa fa-arrow-circle-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div>
                        <div class="box-header">
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: purple; font-weight: bolder; text-align: center;"></p>
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
        $("#photo_gallery_form").on("submit", function (e) {
            e.preventDefault();
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Insert_data/photo_gallery";
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#photo_gallery_form")[0].reset();
                        alert(data);
                        view();
                    }
                });
            }
        });

        function edit_data(id) {
            var url = "<?php echo base_url() ?>Get_data/photo_gallery";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {'id': id},
                success: function (data) {
                    $("#photo_gallery_form")[0].reset();
                    $('#record_id').val(data[0].record_id);
                    $('#title').val(data[0].title);
                    $('#details').val(data[0].details);
                    $('#insert_title').hide();
                    $('#edit_title').show();
                    $('#insert_btn').hide();
                    $('#edit_btn').show();
                }
            });
        }

        $("#click_edit").on("click", function () {
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Edit_data/photo_gallery";
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: new FormData($('#photo_gallery_form')[0]),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#photo_gallery_form")[0].reset();
                        $('#insert_title').show();
                        $('#edit_title').hide();
                        $('#insert_btn').show();
                        $('#edit_btn').hide();
                        alert(data);
                        view();
                    }
                });
            }
        });
        function delete_data(id) {
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Delete_data/photo_gallery";
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
                url: "<?php echo base_url() ?>View_data/photo_gallery",
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
                "order": false
            });
        }
    </script>

    <style>
        @media print {
            @page 
            {
                size: A4 landscape;   /* auto is the current printer page size */
                margin: -5mm 0mm 0mm 10mm;
            }
            html
            {
                background-color: #FFFFFF; 
                margin: 0px;  /* this affects the margin on the html before sending to printer */
            }
            .no_print {
                display: none;
            }
            ::-webkit-scrollbar{
                display: none;
            }
            .dataTables_filter {
                display: none;
            }
            .dataTables_paginate {
                display: none;
            }
            .dataTables_info {
                display: none;
            }
            .dataTables_length {
                display: none;
            }
            .dataTables_orderable{
                display: none;
            }
            table.dataTable thead .sorting:after,
            table.dataTable thead .sorting_asc:after,
            table.dataTable thead .sorting_desc:after {
                display: none;
            }
        }
    </style>
<?php } ?>
