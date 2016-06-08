<?php

 get_header();
?>
<div class="container clearfix">
<div class="inerblock_serc">
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

</div>
</div><div class="clearfix"></div><?php 

 get_footer();


 ?>