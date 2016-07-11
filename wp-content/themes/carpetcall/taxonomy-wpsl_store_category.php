<?php get_header();?>
<?php
$term =  get_queried_object();

?>
<div class="container clearfix">
<div class="inerblock_serc">
<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
<?php 
  echo '<h4><span class="cc-locator-sub"><a href="'.site_url().'/find-a-store/">'. 'find a store'.'</a></span>'.'>'.'<span class="cc-locator-root"><a href="'.site_url().'/find-a-store/'.$term->slug.'">'. $term->slug.'</a></span></h4>';?>

</div>
<?php echo do_shortcode('[wpsl category="'.$term->slug.'" 
]'); ?>



</div>
</div><div class="clearfix"></div>

<style>


#wpsl-stores{
	overflow:visible !important;
}

</style>

<?php get_footer();?>