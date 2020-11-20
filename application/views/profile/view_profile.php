<aside>
    <section class="content" style="padding: 10px;">
        <div class="row">
            <section class="col-xs-12 connectedSortable">
                <div style="color: black;">
                    <div class="box-body">
                        <h4 style="text-align: center;"><u>My Profile</u></h4>
                        <table id="datatable" class="datatable table table-bordered table-hover">
                            <thead>
                                <tr> <th style="text-align: center;">Name</th><th style="text-align: center;"><?php echo $this->session->ses_full_name; ?></th></tr>
                                <tr>  <th style="text-align: center;">Address</th><th style="text-align: center;"><?php echo $this->session->ses_address; ?></th></tr>
                                <tr><th style="text-align: center;">Mobile</th><th style="text-align: center;"><?php echo $this->session->ses_mobile; ?></th></tr>
                                <tr><th style="text-align: center;">Email</th><th style="text-align: center;"><?php echo $this->session->ses_email ?></th></tr>
                                <tr><th style="text-align: center;">Username</th><th style="text-align: center;"><?php echo $this->session->ses_user_name; ?></th></tr>
                                <tr><th style="text-align: center;">Password</th><th style="text-align: center;"><?php echo $this->session->ses_password; ?></th></tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </section>
</aside>