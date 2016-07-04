<?php 
get_header();?>
<?php 
global $post;
 $xterm = get_the_terms($post->ID, 'wpsl_store_category' );
 foreach($xterm as $x){
 	$catid = $x->term_id;
 }


?>
<div class="container clearfix">
<div class="inerblock_serc">
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
<?php if(function_exists('bcn_display')){
        bcn_display();
    }?>

</div>
<div class="col-md-12">
<div class="col-md-6 pull-left">
<h3><?php echo get_the_title();?></h3>
</div>
<div class="col-md-6 pull-right"><?php 
echo '<a href="'.get_category_link($catid).'"><' ;?>
 VIEW ALL STORE</a>
</div>
</div>
<div class="col-md-4 wpsl-single-left">
<div class="wpsl-address-sec">
	<?php echo do_shortcode('[wpsl_address id="'.$post->ID.'" name="true" address="true" address2="false" 
       city="true" state="false" zip="true" country="false" phone="false" title="false"
       fax="false" email="false" url="true"]');
       ?>
       <?php $url = get_post_meta($post->ID);


        ?>
       <a href="https://maps.google.com/maps?saddr=balcatta,australia&daddr=<?php echo $url['wpsl_address'][0].' '.$url['wpsl_city'][0];?>" target="_blank">Direction</a>
       </div>
       <div class="wpsl-phone-sec">
	<?php echo do_shortcode('[wpsl_address id="'.$post->ID.'" name="false" address="false" address2="false" 
       city="false" state="false" zip="false" country="false" phone="true" 
       fax="true" email="false" url="false"]');
       ?>
       <div class="fcnt-or fcnt-orr fcnt-orr-map clearfix"><a href="http://staging.carpetcall.com.au/contact-us/?id=<?php echo $post->ID;?>" class="cc-contact-link">Contact Store</a></div>
       </div>
       <div class="wpsl-hour-sec">
       <span><strong>Opening Hours</strong></span>
       	<?php echo do_shortcode('[wpsl_hours id="'.$post->ID.'" hide_closed="true"]') ;?>
       </div>
</div>
<div class="col-md-8 wpsl-single-right">

	<?php echo do_shortcode('[wpsl_map id="'.$post->ID.'" width="500" height="350" zoom="5" map_type="roadmap" 
map_type_control="true" map_style="default" street_view="false" 
scrollwheel="true" control_position="left"]'); 
?>
</div>
</div>
</div><div class="clearfix"></div>

<?php
get_footer();
?>