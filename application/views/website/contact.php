<div id="mainBody">
    <div class="container">
        <div class="row">
            <!-- Sidebar ================================================== -->
            <div id="sidebar" class="span3">
                <!--<div class="well well-small"><a id="myCart" href="product_summary.html"><img src="<?php echo base_url(); ?>assets/template_web/themes/images/ico-cart.png" alt="cart">3 Items in your cart  <span class="badge badge-warning pull-right">$155.00</span></a></div>-->
                <ul id="sideManu" class="nav nav-tabs nav-stacked">
                    <?php
                    $c = 0;
                    foreach ($cat as $info) {
                        $c++;
                        ?>
                        <li class="subMenu"><a href="#"><?php echo $info->category; ?></a>
                            <ul style="display:none">
                                <?php foreach (${"sub_cat" . $c} as $sub_info) { ?>
                                    <li><a href="#" onclick="product_by_subcat('<?php echo $sub_info->record_id; ?>', '<?php echo $sub_info->sub_category; ?>')"><i class="icon-chevron-right"></i><?php echo $sub_info->sub_category; ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- Sidebar end=============================================== -->
            <div class="span1"></div>
            <div class="span4">
                <h4>Contact Details</h4>
                <p>	
                    <?php
                    foreach ($contact as $info) {
                        echo $info->details;
                    }
                    ?>
                </p>		
            </div>
            <div class="span4">
                <h4>Opening Hours</h4>
                <h5> Saturday - Thursday</h5>
                <p>09:00am - 09:00pm<br/><br/></p>
                <h5>Friday</h5>
                <p>04:00pm - 09:00pm<br/><br/></p>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/template_web/themes/js/bootshop.js"></script>