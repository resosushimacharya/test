<?php get_header();?>

<div class="container clearfix">
<div class="inerblock_serc">
<?php 
while(have_posts()):
  the_post();
the_title();?>
<br>
<a href="<?php the_permalink();?>">read more</a>
<?php 	endwhile;
	?>
</div>
</div><div class="clearfix"></div>

<?php get_footer();?>