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
<?php if (in_array("17", $view_id) || in_array("all", $view_id)) { ?>
<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div style="color: black;" class="no_print">
                    <form id="balance_sheet_form">
                    <div class="box-body">
                        <p style="font-size: 20px; margin: 0px; padding: 0px; 
                           color: black; font-weight: bolder; text-align: center;">
                            Financial Year Wise Balance Sheet
                        </p>
                        <div class="row">
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="date_from">Year From</label>
                                <input type="text" class="form-control new_datepicker"
                                       placeholder="Insert Date" name="date_from" id="date_from" value="<?php echo date('Y')-1; ?>"
                                       autocomplete="off">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12">
                                <label for="date_to">Year To</label>
                                <input type="text" class="form-control new_datepicker"
                                       placeholder="Insert Date" name="date_to" id="date_to" value="<?php echo date('Y'); ?>"
                                       autocomplete="off">
                            </div>
                            <div class="form-group col-sm-2 col-xs-12" style="display:none;">
                                <label for="ac_type">A/C Type</label>
                                <select name="ac_type" id="ac_type" class="form-control"
                                        data-live-search="true">
                                    <option value="All">All</option>
                                        <option value="Morning">Morning</option>
                                        <option value="Evening">Evening</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2 col-xs-12" style="margin-top: 25px;">
                                <button type="submit" class="pull-left btn btn-success">Search <i
                                            class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

                <div id="view_table"></div>
            </section>
        </div>
    </section>
</aside>

<script>
        $("#balance_sheet_form").on("submit", function (e) {
            e.preventDefault();
            var url = "<?php echo base_url() ?>View_data/year_wise_balance_sheet";
            $.ajax({
                url: url,
                type: "post",
                dataType:"json",
                data: $(this).serialize(),
                success: function (data) {
                    console.log(data);
                    $("#view_table").html(data);
                    datatable();
                }
            });
        });
        function datatable() {
            $('#datatable').dataTable({
                //"info":false,
                "autoWidth": false,
                "order":false
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
     table.table-bordered{
        border: grey 1px solid;
        font-weight: bold;
        color: black;
        font-size: 13px;
    }
    table.table-bordered > thead > tr > th{
        border: grey 1px solid;
        font-weight: bold;
        color: black;
        font-size: 13px;
    }
    table.table-bordered > tbody > tr > td{
        border: grey 1px solid;
        font-weight: bold;
        color: black;
        font-size: 13px;
    }
</style>

<style type='text/css'>
  /* Style to hide Dates / Months */
  .ui-datepicker-calendar,.ui-datepicker-month { display: none; }​
</style>
<script type='text/javascript'>
  $(function(){
    $('.new_datepicker').datepicker({
        changeMonth: false,
        changeYear: true,
        showButtonPanel: true,
        yearRange: '2010:2050', // Optional Year Range
        dateFormat: 'yy',
        onClose: function(dateText, inst) { 
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, 0, 1));
        }});
    });
</script>
<?php } ?>