<?php get_header();?>
<?php
$term =  get_queried_object();
?>
<div class="container clearfix">
<div class="inerblock_serc">
<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
<?php if(function_exists('bcn_display')){
        bcn_display();
    }?>

</div>
<?php echo do_shortcode('[wpsl category="'.$term->slug.'" 
]'); ?>



</div>
</div><div class="clearfix"></div>



<?php get_footer();?>