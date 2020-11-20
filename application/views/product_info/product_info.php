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
<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div style="color: black;" class="no_print">
                    <form id="product_form">
                        <div class="box-body">
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: green; font-weight: bolder; text-align: center;" id="insert_title">
                                Add Product Info
                            </p>
                            <p style="font-size: 20px; margin: 0px; padding: 0px; 
                               color: blue; font-weight: bolder; text-align: center; display: none;" id="edit_title">
                                Edit Product Info
                            </p>
                            <input type="hidden" name="record_id" placeholder="Name" class="form-control"  id="record_id" >
                            <div class="row">
                                <div class="form-group col-sm-2 col-xs-12">
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

                                <div class="form-group col-sm-2 col-xs-12">
                                    <label for="sub_category">Select Sub Category</label>
                                    <select name="sub_category" id="sub_category" class="form-control selectpicker"
                                            data-container="body">
                                        <option value="">-- Select --</option>
                                        
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" name="name" placeholder="Product Name" class="form-control"  id="name" >
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <strong><label for="code">Code</label></strong>
                                        <input type="text" name="code" placeholder="Product Code" class="form-control"  id="code" >
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="brand">Brand</label>
                                        <select name="brand" class="form-control" id="brand">
                                            <option>--Select Brand--</option>
                                        <?php
                                            foreach($brands as $brand){
                                        ?>
                                        <option value="<?php echo $brand->record_id ?>">
                                            <?php echo $brand->brand ?>
                                        </option>
                                    <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <strong><label for="price">Price</label></strong>
                                        <input type="text" name="price"  placeholder="Price" class="form-control"  id="price" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <strong><label for="picture_1">Picture-1</label></strong>
                                        <input type="file" name="picture_1" class="form-control"  id="picture_1" >
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <strong><label for="picture_2">Picture-2</label></strong>
                                        <input type="file" name="picture_2" class="form-control"  id="picture_2" >
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <strong><label for="picture_3">Picture-3</label></strong>
                                        <input type="file" name="picture_3" class="form-control"  id="picture_3" >
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <strong><label for="picture_4">Picture-4</label></strong>
                                        <input type="file" name="picture_4" class="form-control"  id="picture_4" >
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <strong><label for="picture_5">Picture-5</label></strong>
                                        <input type="file" name="picture_5" class="form-control"  id="picture_5" >
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <strong><label for="picture_6">Picture-6</label></strong>
                                        <input type="file" name="picture_6" class="form-control"  id="picture_6" >
                                    </div>
                                </div>



                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <strong><label for="description">Description</label></strong>
                                        <textarea  name="description"  placeholder="Description" class="form-control"  id="description" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <strong><label for="specification">Specification</label></strong>
                                        <textarea  name="specification"  placeholder="Specification" class="form-control"  id="specification" rows="10"></textarea>
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
                           color: purple; font-weight: bolder; text-align: center;">
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
    <?php if($type == ""){ ?>
    $("#category").on("change paste keyup", function () {
        var category = $('#category').val();
        var post_data = {
            'category': category,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        };

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Get_data/get_sub_category",
            data: post_data,
            success: function (data) {
                $('#sub_category').html(data);
                $("#sub_category").selectpicker('refresh');
            }
        });
    });
    <?php } ?>
    $("#search_student").on("change paste keyup", function () {
        var input_data = $('#search_student').val();
        var post_data = {
            'student_id': input_data,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        };

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Get_ajax_value/get_student_info",
            data: post_data,
            success: function (data) {
                $('#show_info').html(data);
            }
        });
    });

    $("#product_form").on("submit", function (e) {
        e.preventDefault();
        //            var b = new FormData(this);
        //            for (var value of b.values()) {
        //                console.log(value);
        //            }
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Insert_data/product";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data);
                    $("#product_form")[0].reset();
                    $("#category").val('');
                    $("#category").selectpicker('refresh');
                    $("#sub_category").val('');
                    $("#sub_category").selectpicker('refresh');
                    alert(data);
                    view();
                }
            });
        }
    });

    function edit_data(id) {
        var url = "<?php echo base_url() ?>Get_data/product";
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {'id': id},
            success: function (data) {
                $("#product_form")[0].reset();
                $('#record_id').val(data[0].record_id);
                $('#name').val(data[0].name);
                $('#code').val(data[0].code);
                $('#brand').val(data[0].brand);
                $('#description').val(data[0].description);
                $('#specification').val(data[0].specification);
                $('#price').val(data[0].price);
                $('#category').val(data[0].category);
                $("#category").selectpicker('refresh');
                $('#sub_category').val(data[0].sub_category);
                $("#sub_category").selectpicker('refresh');
                $('#insert_title').hide();
                $('#edit_title').show();
                $('#insert_btn').hide();
                $('#edit_btn').show();
            }
        });
    }

    $("#click_edit").on("click", function () {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Edit_data/product";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: new FormData($('#product_form')[0]),
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#product_form")[0].reset();
                    $("#category").val('');
                    $("#category").selectpicker('refresh');
                    $("#sub_category").val('');
                    $("#sub_category").selectpicker('refresh');

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
            var url = "<?php echo base_url() ?>Delete_data/product";
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
            url: "<?php echo base_url() ?>View_data/product",
            success: function (data) {
                $("#view_table").html(data);
                datatable();
          //   console.log(data);
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
