<?php

 get_header();
?>
<div class="container">
<?php 
if(have_posts()):

    while(have_posts()):
      the_post();

       the_title();

       the_content();

    endwhile;


	else:
		echo "not found";


	endif;

?>
</div><?php 

 get_footer();


 ?>