<!--<style>
.footer {
   left: 0;
   bottom: 0;
   width: 100%;
   height: 50px;
   background-color: #5a9610;
   color: white;
   text-align: center;
/*   border-radius: 10px 10px 0px 0px;*/
}
</style>
<div class="footer">
    <p style="padding-top: 10px; font-size: 17px;">
        Copyright &copy; 2018. Designed & Developed by <a href="http://greensoftechbd.com/" target="_blank" style="color: yellow;">GREEN SOFTWARE &
            TECHNOLOGY</a>. All rights reserved
    </p>
</div>-->
<!--Datepicker-->
<script>
    $(function () {
        $(".new_datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            constrainInput: true,
            changeYear: true,
            changeMonth: true
        });
    });
</script>
<style>
    div.ui-datepicker{
        font-size:13px;
    }
    /*.ui-datepicker-calendar a.ui-state-default { background: cyan; }
    .ui-datepicker-calendar td.ui-datepicker-today a { background: red; }*/
    .ui-datepicker-calendar a.ui-state-hover { background: #066;color: white; } 
    .ui-datepicker-calendar a.ui-state-active { background: #066;color: white; } 
</style>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>adminlte/js/bootstrap.min.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url(); ?>adminlte/js/AdminLTE/app.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.min.js"></script>
</body>
</html>