<?php 
/*hello */
get_header();

echo "hello";
if(have_posts()):
while(have_posts())
{
the_post();
the_title();
the_content();

}
endif;

get_footer();
?>

