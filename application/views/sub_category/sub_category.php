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
                        <form id="sub_category_form">
                            <div class="box-body">
                                <p style="font-size: 20px; margin: 0px; padding: 0px; 
                                   color: green; font-weight: bolder; text-align: center;" id="insert_title">
                                    Insert Sub Category
                                </p>
                                <p style="font-size: 20px; margin: 0px; padding: 0px; 
                                   color: blue; font-weight: bolder; text-align: center; display: none;" id="edit_title">
                                    Edit Sub Category
                                </p>
                                <input type="hidden" name="record_id" placeholder="Name" class="form-control"  id="record_id" >
                                <div class="row">
                                    <div class="form-group col-sm-3 col-xs-12">
                                        <label for="category">Select Category</label>
                                        <select name="category" id="category" class="form-control selectpicker"
                                                data-container="body">
                                            <option value="">-- Select --</option>
                                            <?php foreach ($category as $single_category) { ?>
                                                <option value="<?php echo $single_category->record_id; ?>">
                                                    <?php echo $single_category->category; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <strong><label for="sub_category">Sub Category</label></strong>
                                            <input type="text" name="sub_category" placeholder="Sub Category" class="form-control"  id="sub_category" >
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-1 col-xs-12" style="margin-top: 25px;" id="add_btn">
                                        <button type="button" class="pull-left btn btn-info">Add <i
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

                    <div class="box-body table-responsive" style="width: 98%; color: black; overflow-x: scroll;" id="content_list">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Action</th>
                                    <th style="text-align: center;">Category</th>
                                    <th style="text-align: center;">Sub Category</th>
                                </tr>
                            </thead>
                            <tbody id="added_content">

                            </tbody>
                            <tr>
                                <td colspan="19">
                                    <button type="button" class="pull-left btn btn-success" style="margin-top: 20px;"
                                            id="confirm_btn">Confirm <i class="fa fa-arrow-circle-right"></i></button>
                                </td>
                            </tr>
                        </table>
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
        var all_content = new Array();
        var content_count = 0;
        $("#add_btn").click(function () {
            var category_id = $('#category').val();
            var category = $('#category option:selected').text().trim();
            var sub_category = $('#sub_category').val();
    //        alert(category);
            all_content[content_count] = new Array(category_id, category, sub_category);
    //        var complete_total = 0;
            var full_table = "";
            for (var i = 0; i < all_content.length; i++) {
    //            complete_total += parseFloat(all_content[i][1]);
                full_table += "<tr><td style='text-align: center;'><button class='btn btn-danger fa fa-trash-o' onclick='delete_content(" + i + ")'></button></td>";
                for (var j = 1; j < all_content[i].length; j++) {
                    full_table += "<td style='text-align: center;'>" + all_content[i][j] + "</td>";
                }
                full_table += "</tr>";
            }

            $('#added_content').html(full_table);
    //        temp_total = complete_total;
            content_count++;
        });

        function delete_content(arr_no) {
            all_content.splice(arr_no, 1);
            var full_table = "";
            for (var i = 0; i < all_content.length; i++) {
    //            complete_total += parseFloat(all_content[i][1]);
                full_table += "<tr><td style='text-align: center;'><button class='btn btn-danger fa fa-trash-o' onclick='delete_content(" + i + ")'></button></td>";
                for (var j = 1; j < all_content[i].length; j++) {
                    full_table += "<td style='text-align: center;'>" + all_content[i][j] + "</td>";
                }
                full_table += "</tr>";
            }

            $('#added_content').html(full_table);
    //        temp_total = complete_total;
            content_count--;
        }

        $("#confirm_btn").click(function () {
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Insert_data/sub_category";
                var post_data = {
                    'all_content': all_content,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                };
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: post_data,
    //                processData: false,
    //                contentType: false,
                    success: function (data) {
                        $("#sub_category_form")[0].reset();
                        $('#category').val("");
                        $("#category").selectpicker('refresh');
                        all_content = new Array();
                        var full_table = "";
                        for (var i = 0; i < all_content.length; i++) {
    //            complete_total += parseFloat(all_content[i][1]);
                            full_table += "<tr><td style='text-align: center;'><button class='btn btn-danger fa fa-trash-o' onclick='delete_content(" + i + ")'></button></td>";
                            for (var j = 1; j < all_content[i].length; j++) {
                                full_table += "<td style='text-align: center;'>" + all_content[i][j] + "</td>";
                            }
                            full_table += "</tr>";
                        }

                        $('#added_content').html(full_table);
                        content_count = 0;
                        alert(data);
                        view();
                    }
                });
            }
        });

        function edit_data(id) {
            var url = "<?php echo base_url() ?>Get_data/sub_category";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {'id': id},
                success: function (data) {
                    $("#sub_category_form")[0].reset();
                    $('#record_id').val(data[0].record_id);
                    $('#category').val(data[0].category_id);
                    $('#category').selectpicker("refresh");
                    $('#sub_category').val(data[0].sub_category);
                    $('#insert_title').hide();
                    $('#edit_title').show();
                    $('#add_btn').hide();
                    $('#confirm_btn').hide();
                    $('#content_list').hide();
                    $('#edit_btn').show();
                }
            });
        }

        $("#click_edit").on("click", function () {
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Edit_data/sub_category";
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: new FormData($('#sub_category_form')[0]),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#sub_category_form")[0].reset();
                        $('#category').val("");
                        $('#category').selectpicker("refresh");
                        $('#insert_title').show();
                        $('#edit_title').hide();
                        $('#add_btn').show();
                        $('#confirm_btn').show();
                        $('#content_list').show();
                        $('#edit_btn').hide();
                        alert(data);
                        view();
                    }
                });
            }
        });
        function delete_data(id) {
            if (confirm("Are you sure?")) {
                var url = "<?php echo base_url() ?>Delete_data/sub_category";
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
                url: "<?php echo base_url() ?>View_data/sub_category",
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
