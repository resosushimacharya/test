<?php get_header();
if(have_posts()):
while(have_posts()):
    the_post();

the_title();
the_content();
echo '<a href="'.the_permalink().'">readmore'.'</a>';
    
endwhile;
else:
    echo 'page not found';

endif;

get_footer();

?>