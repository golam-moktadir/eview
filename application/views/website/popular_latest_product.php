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
        <h4>Popular Products</h4>
        <ul class="thumbnails">
          <?php foreach ($popular_products as $popular_product) { ?>
          <li class="span3">
            <div class="thumbnail">
              <a href="#" onclick="view_product_details('<?php echo $popular_product->record_id; ?>')">
                <?php if (file_exists("assets/img/product/" . $popular_product->record_id . "_1.jpg")) { ?>
                  <img src="<?php echo base_url(); ?>assets/img/product/<?php echo $popular_product->record_id . "_1.jpg"; ?>" style="height:200px; width: 100%;" alt=""/>
                <?php } else { ?>
                  <img src="<?php echo base_url(); ?>assets/img/no_image.jpg" style="height:200px; width: 100%;" alt=""/>
                <?php } ?>
               </a>
               <div class="caption" style="padding: 0px; margin: 0px;">
                 <h5><?php echo $popular_product->name; ?></h5>
                 <h5 style="color: #066;"><?php echo $popular_product->price; ?> BDT</h5>
                 <h3 style="text-align:center">
                   <a class="btn btn-info" onclick="view_product_details('<?php echo $popular_product->record_id; ?>')">View</a> 
                   <a class="btn btn-warning" onclick="add_to_cart('<?php echo $popular_product->record_id; ?>', '<?php echo $popular_product->name; ?>',
                    '<?php echo $popular_product->code; ?>','<?php echo $popular_product->price; ?>')">Add to <i class="fa fa-shopping-cart" style="font-size: 17px;"></i></a> 
                 </h3>
               </div>
            </div>
          </li>
          <?php } ?>
        </ul>	
        <h4><?php echo $head . " "; ?>Products</h4>
        <ul class="thumbnails">
          <?php foreach ($all_product as $single_product) { ?>
          <li class="span3">
            <div class="thumbnail">
              <a href="#" onclick="view_product_details('<?php echo $single_product->record_id; ?>')">
                <?php if (file_exists("assets/img/product/" . $single_product->record_id . "_1.jpg")) { ?>
                <img src="<?php echo base_url(); ?>assets/img/product/<?php echo $single_product->record_id . "_1.jpg"; ?>" 
                         style="height:200px; width: 100%;" alt=""/>
                     <?php } else { ?>
                <img src="<?php echo base_url(); ?>assets/img/no_image.jpg"
                         style="height:200px; width: 100%;" alt=""/>
                     <?php } ?>
              </a>
                <div class="caption" style="padding: 0px; margin: 0px;">
                    <h5><?php echo $single_product->name; ?></h5>
                    <h5 style="color: #066;"><?php echo $single_product->price; ?> BDT</h5>
                    <h3 style="text-align:center">
                        <a class="btn btn-info" onclick="view_product_details('<?php echo $single_product->record_id; ?>')">View</a> 
                        <a class="btn btn-warning" onclick="add_to_cart('<?php echo $single_product->record_id; ?>', '<?php echo $single_product->name; ?>',
                    '<?php echo $single_product->code; ?>','<?php echo $single_product->price; ?>')">Add to <i class="fa fa-shopping-cart" style="font-size: 17px;"></i></a> 
                    </h3>
                </div>
            </div>
          </li>
        <?php } ?>
        </ul>	
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/template_web/themes/js/bootshop.js"></script>
