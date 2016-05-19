<?php /*            <div class="col-md-8">
    <div class="row">
        <?php
        
        $args = array('post_type'=>'visualisers','post_status'=>'publish');
        $loop = new WP_Query($args);
        while($loop->have_posts()):
        $loop->the_post();?>
        <div class="pimg">
            <?php
            the_post_thumbnail();?>
            <div class="phov">
                <img src="<?php echo get_template_directory_uri() ;?>/images/zbg.png" width="43" height="43" alt="bg"/>
            </div>
            <div class="phicn">
                <a href="#">
                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                </a>
            </div>
            <?php endwhile;
            ?>
        </div></div></div>
        */ ?>
        <?php
        $i = 0;

        /*<div class="pimg">
        <img src="images/product-a.jpg" alt="product" class="img-responsive"/>
        <div class="phov"><img src="images/zbg.png" width="43" height="43" alt="bg"/> </div>
        <div class="phicn"><a href="images/product-a.jpg"> <i class="fa fa-search-plus" aria-hidden="true"></i> </a></div>
        </div>*/
        $args = array('post_type'=>'visualisers','post_status'=>'publish');?>
        <?php $loop = new WP_Query($args);?>
        <div class="col-md-8">
            <?php while($loop->have_posts()): $loop->the_post();?>
            <?php if($i==0):?><div class="row"> <?php endif;?>
                <div class="<?php if($i==0):?> col-md-8<?php else:?> col-md-4<?php endif;?>">
                    <div class="pimg<?php if($i==2): echo "_a";endif;?>">
                        <?php 
                        $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

                        ?>
                        <img src="<?php echo $feat_image;?>" alt="product" class="img-responsive"/>
                        <div class="phov">
                            <img src="
                            <?php echo get_template_directory_uri() ;?>/images/zbg.png" width="43" height="43" alt="bg"/>
                        </div>
                        <div class="phicn">
                            <a href="<?php echo $feat_image;?>">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    

                </div>
            <?php if($i==2):?></div> <!-- /.row-<?php echo $i;?> --> <div class="clearfix"></div> <div class="belowblk"> <div class="row"><?php endif;?>
            <?php $i++;?>
            <?php endwhile;
            wp_reset_query();?>
            </div> <!-- /.md-4 /row -->

            </div><!-- /.md-4 belowblk -->
            <div class="clearfix"></div>

        </div>
      
        

      