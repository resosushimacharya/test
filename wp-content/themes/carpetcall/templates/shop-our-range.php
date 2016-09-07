<?php
/* Template Name: Shop Our Range Template
*/
get_header();
?>
<?php while(have_posts()){
	the_post();?>
<div class="body-wrapper">
<div class="ia-block clearfix shop-our-range-cntr">
<div class="container">
        <div class="col-md-12 no-pl cc-ia-content">
        <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }?>

</div>
        <h1><?php the_title();?> </h1>
        <p><?php echo $post->post_content;?> </p>
        </div>
        
</div>
</div>



		<div class="gpf-block clearfix">
        <div class="container">
        <div class="cc-rugs-sor-cntr clearfix">
		<?php 
        $shop_ranges = get_field('shopping_ranges',get_the_ID());
		if(!empty($shop_ranges)){
			foreach($shop_ranges as $shop){?>
           
            <div class="cc-ia-item-cover shop_range col-sm-2">
             <div class="sor-single-wrap">
				<a href="<?php echo $shop['shop_range_url']?>"><div class="shop_range_cat_block" style="background-image:url('<?php echo $shop['shop_range_image'] ?>')">
            </div>
            <h3><?php _e( $shop['shop_range_title'],'carpetcall')?></h3></a><div class="clearfix"></div>
            </div>
            </div>
            
            
				<?php }
			}
    ?>
                  </div>
                </div>
                </div>                
</div>
<?php }
get_footer();
?>