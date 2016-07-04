<?php 
get_header();?>

<div class="container clearfix">
<div class="inerblock_serc">
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
<?php if(function_exists('bcn_display')){
        bcn_display();
    }?>

</div>
<h3><?php echo get_the_title();?></h3>
<?php 

while(have_posts()):
the_post();
the_title();
the_content();
endwhile;?>
</div>
</div><div class="clearfix"></div>

<?php
get_footer();
?>