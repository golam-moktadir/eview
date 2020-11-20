<!DOCTYPE html>
<html class="bg-black">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <title>Satkhira Hospital | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url(); ?>adminlte/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>adminlte/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>adminlte/css/AdminLTE.css" rel="stylesheet" type="text/css" />

    </head>
    <body class="bg-black">

        <?php echo form_open('Log_in_out/login_check'); ?>

        <div class="form-box" id="login-box">
            <div class="header bg-blue">Sign In</div>

            <div class="body bg-gray"  align="center">
                <div class="form-group" style="border: #066 1px solid;">
                    <input type="text" name="username" class="form-control" placeholder="Username">
                </div>
                <div class="form-group" style="border: #066 1px solid;">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>  

                <div class="form-group" style="color: red;">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group" style="color: red;">
                    <?php echo $wrong_msg; ?>
                </div>
            </div>
            <div class="footer">                                                               
                <button type="submit" class="btn bg-blue btn-block">Sign in</button> 
            </div>

        </div>

    </form>
    <!-- jQuery 2.0.2 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>adminlte/js/bootstrap.min.js" type="text/javascript"></script>        

</body>
</html>