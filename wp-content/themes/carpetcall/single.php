<?php

 get_header();?>
 <div class="container clearfix">
<div class="inerblock_serc">
 <?php
global $post;
if(have_posts()):

    while(have_posts()):
      the_post();

       the_title();
       $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

       the_content();
       echo '<img src="'.$feat_image.'" alt="'.the_title().'"/>';

    endwhile;


	else:
		echo "not found hello";


	endif;?>
</div>
</div><div class="clearfix"></div>

  <?php 

do_action('pr',get_post_meta($post->ID));

 get_footer();


 ?>