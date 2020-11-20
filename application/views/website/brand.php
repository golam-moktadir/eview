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
            <div class="span9">	
                <h4>Brands</h4>
                <ul class="thumbnails">
                    <?php foreach ($all_brand as $single_brand) {if(!empty($single_brand->brand)){ ?>
                        <li class="span3">
                            <div class="thumbnail">
                                <a href="#" onclick="view_brand_product('<?php echo $single_brand->brand; ?>')">
                                    <?php if (file_exists("assets/img/product/" . $single_brand->record_id . "_7.jpg")) { ?>
                                        <img src="<?php echo base_url(); ?>assets/img/product/<?php echo $single_brand->record_id . "_7.jpg"; ?>" 
                                             style="height:200px; width: 100%;" alt=""/>
                                         <?php } else { ?>
                                        <img src="<?php echo base_url(); ?>assets/img/no_image.jpg"
                                             style="height:200px; width: 100%;" alt=""/>
                                         <?php } ?>
                                </a>
                                <div class="caption" style="padding: 0px; margin: 0px;">
                                    <h5><?php echo $single_brand->brand; ?></h5>
                                    <h3 style="text-align:center">
                                        <a class="btn btn-success" onclick="view_brand_product('<?php echo $single_brand->brand; ?>')">View Product</a> 
                                    </h3>
                                </div>
                            </div>
                        </li>
                    <?php } }?>
                </ul>	

            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/template_web/themes/js/bootshop.js"></script>
