<?php

 get_header();
?>

<div class="child-innerpg">
<div class="container clearfix">
<div class="inerblock_serc_child">
<?php
$parent_title = get_the_title($post->post_parent);
echo $parent_title;
?>
<?php if(empty( $post->post_parent)): ?>
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
<?php else: ?>
	<?php get_template_part('content','second');?>
<?php endif;?>	
</div>
</div>
</div>
<div class="clearfix"></div>

 <?php get_footer();


 ?>