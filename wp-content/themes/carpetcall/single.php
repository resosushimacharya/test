<?php

 get_header();

if(have_posts()):

    while(have_posts()):
      the_post();

       the_title();
       $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

       the_content();
       echo '<img src="'.$feat_image.'" alt="'.the_title().'"/>';

    endwhile;


	else:
		echo "not found";


	endif;



 get_footer();


 ?>