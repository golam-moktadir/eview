<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div>
                    <div class="box-header">
                        <div style="text-align: right; padding-right: 27px;" class="no_print">
                            <button  id="print" onclick="window.print()" class="btn btn-warning waves-effect waves-light">
                                <i class="fa fa-print"></i>
                            </button>
                        </div>
                        <p style="font-size: 20px; margin: 0px; padding: 0px; 
                           color: purple; font-weight: bolder; text-align: center;">
                            <u>Merchant Member Request Info.</u>
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
    function change_status(id, status_value) {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Edit_data/change_status_mer_reg";
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {'id': id, 'status_value': status_value, 'db_name': "mer_reg"},
                success: function (data) {
                    alert(data);
                    view();
                }
            });
        }
    }

    function delete_data(id) {
        if (confirm("Are you sure?")) {
            var url = "<?php echo base_url() ?>Delete_data/mer_reg";
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
            url: "<?php echo base_url() ?>View_data/mer_reg",
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
