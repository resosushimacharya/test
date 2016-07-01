<?php
/* 
** Template Name: Visit Store
*/
?>
<?php get_header();?>



<div class="cbg_blk cc-clearance-blk clearfix">
 <div class="container ">
<div class="inerblock_serc cc-wrapper-whole">
<div class="col-md-6">					
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
<?php if(function_exists('bcn_display')){
        bcn_display();
    }?>

</div>

<?php 
 	while(have_posts()){
     	the_post();
        $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
?>  
 	<h3><?php echo  get_the_title();?></h3>
             
	<?php  the_content();?>
             	
<?php
	 }
     wp_reset_query();
?>
</div>
<div class="cc-contact-side col-md-6">
<img src="<?php echo $feat_image ;?>" class="img-responsive">
</div>

</div>
</div>
</div>
<style>
.cc-wrapper-blk{
background:#f0f2f1 !important;
}
.cc-wrapper-whole h3{
	text-decoration:none !important;
	border:none;

}
.cc-contact-side{
	
}
.cc-form-wrapper{
	padding:5px;
}
</style>
<?php 
get_footer();

?>