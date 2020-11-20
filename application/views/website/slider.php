<div id="carouselBlk" style="padding-bottom: 20px;">
    <div id="myCarousel" class="carousel slide">
        <div class="carousel-inner">
            <?php
            $count = 0;
            foreach ($all_slider as $single_slider) {
                $count++;
                ?>
                <div class="item <?php echo $count == 1 ? "active" : ""; ?>">
                    <div class="container">
                        <img src="<?php echo base_url(); ?>assets/img/slider/<?php echo $single_slider->picture; ?>" alt="" 
                             style="width: 100%; height: 350px; border-radius: 10px;"/>
                    </div>
                </div>
            <?php } ?>
        </div>
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div> 
</div>