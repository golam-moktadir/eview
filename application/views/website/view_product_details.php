<div id="mainBody">
    <div class="container">
        <div class="row">
            <!-- Sidebar ================================================== -->
            <div id="sidebar" class="span3">
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
                <div class="row">	  
                    <div id="gallery" class="span3">
                        <?php if (file_exists("assets/img/product/" . $product_info[0]->record_id . "_1.jpg")) { ?>
                            <a href="assets/img/product/<?php echo $product_info[0]->record_id . "_1.jpg"; ?>" title="<?php echo $product_info[0]->name; ?>">
                                <img src="assets/img/product/<?php echo $product_info[0]->record_id . "_1.jpg"; ?>" style="width:260px; height: 180px; margin-bottom: 10px;"
                                     alt="<?php echo $product_info[0]->name; ?>"/>
                            </a>
                        <?php } else { ?>
                            <a href="assets/img/no_image.jpg" title="<?php echo $product_info[0]->name; ?>">
                                <img src="assets/img/no_image.jpg" style="width:100%" alt="<?php echo $product_info[0]->name; ?>"
                                     style="width:260px; height: 180px; margin-bottom: 10px;" />
                            </a>
                        <?php } ?>
                        <div id="differentview" class="moreOptopm carousel slide">
                            <div class="carousel-inner">
                                <div class="item active">
                                    <?php for ($i = 1; $i <= 6; $i++) { ?>
                                        <?php if (file_exists("assets/img/product/" . $product_info[0]->record_id . "_" . $i . ".jpg")) { ?>
                                            <a href="assets/img/product/<?php echo $product_info[0]->record_id . "_" . $i . ".jpg"; ?>" title="<?php echo $product_info[0]->name; ?>">
                                                <img src="assets/img/product/<?php echo $product_info[0]->record_id . "_" . $i . ".jpg"; ?>" style="width:29%; height: 50px; margin-bottom: 4px;"
                                                     alt="<?php echo $product_info[0]->name; ?>"/>
                                            </a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="span6">
                        <h3><?php echo $product_info[0]->name; ?></h3>
                        <h6><?php echo "Code: " . $product_info[0]->code . ", Brand: " . $product_info[0]->brand; ?></h6>
                        <hr class="soft"/>
                        <form class="form-horizontal qtyFrm">
                            <div class="control-group">
                                <label class="control-label"><span><b><?php echo $product_info[0]->price . " BDT"; ?></b></span></label>
                                <div class="controls">
                                    <a class="btn btn-warning" onclick="add_to_cart('<?php echo $product_info[0]->record_id; ?>', '<?php echo $product_info[0]->name; ?>',
                                    '<?php echo $product_info[0]->code; ?>','<?php echo $product_info[0]->price; ?>')">Add to <i class="fa fa-shopping-cart" style="font-size: 17px;"></i></a> 
                                </div>
                            </div>
                        </form>
                        <hr class="soft clr"/>
                        <p style="text-align: justify;"><b>Specification</b><br>
                            <?php echo $product_info[0]->specification; ?>
                        </p><br>
                        <p style="text-align: justify;"><b>Description</b><br>
                            <?php echo $product_info[0]->description; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/template_web/themes/js/bootshop.js"></script>

