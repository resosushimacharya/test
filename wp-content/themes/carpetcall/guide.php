<?php 
/* Template Name: guide */
 get_header();
 ?>

<div class="container clearfix">
	<div class="inerblock_serc">
		<div class="col-md-2">
			<?php get_sidebar();?>
            <div class="clearfix"></div>
		</div>
		<div class="col-md-10">
			<?php while(have_posts()):the_post()?>
	     	<h3><?php  the_title(); ?><h3>
	     	<p><?php the_content();?></p>
	        <?php endwhile;?>
		</div>
</div>
</div><div class="clearfix"></div>

<?php get_footer();?>
?>