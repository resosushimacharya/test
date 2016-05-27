 <div class="trade"><!-- trade section start here -->
       		<div class="container">
            	<div class="hamro_trade">
                	<h2>we are the experts in the trade </h2>
                   <div class="row">
                    <?php
                    
                    $ei = 2;

 $args=array(
          'post_type' => 'experts',

          'order' => 'ASC',
          'post_status' => 'publish',
          'posts_per_page' => -1,
          'ignore_sticky_posts'=> 1
          );
          //echo $tax_term->slug;
          $my_query = null;
          $my_query = new WP_Query($args);
          while ($my_query->have_posts()) : $my_query->the_post();
$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
  $highlight =get_field('highlight',$post->ID);
   $non_highlight_section =get_field('non_highlight_section',$post->ID);
    $link_title =get_field('link_title',$post->ID);
     $link =get_field('link',$post->ID);

                     ?>
                        <div class="col-md-6 <?php echo ($ei%2==0?'idea-left':'idea-right') ;?>">
                        <div class="measure_blk">
                          <div class="meas_img" style="background:url(<?php echo $feat_image;?>); min-width:482px; min-height:267px; background-size:cover;">
                            <img src="<?php echo $feat_image ;?>" alt="guide" class="img-responsive"/>
                            </div><div class="clearfix"></div>
                           
                           <div class="measr_cnt">
                            <h3>
                            <?php if(!empty($highlight)){?>
                            <span class="frcol"> <?php echo $highlight;?></span>
                            <?php }?> <?php echo $non_highlight_section ;?> </h3>
                            
                              <?php the_content();?>
                            
                           </div><div class="clearfix"></div>
                           
                           <div class="find_tb find_tbb">
                          <a href="<?php echo $link;?>"> <?php echo $link_title;?></a>
                           </div><div class="clearfix"></div>
                            
                        </div>
                        </div><!-- measuer end -->    

                     <?php 
                     $ei++;
                     endwhile;
                     wp_reset_query();?>
                     </div>

                   <div class="clearfix"></div>
                    
                </div><div class="clearfix"></div>
            </div>
       </div><div class="clearfix"></div>