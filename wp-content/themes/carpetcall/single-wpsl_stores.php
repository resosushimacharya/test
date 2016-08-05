<?php 
get_header();?>
<?php 
global $post;

$state_post_parent = $post->post_parent;
$cat_names = wp_get_post_terms($post->ID, 'wpsl_store_category', array("fields" => "names"));
$cat_name = $cat_names[0];


?>
 <?php 
      
     $statename = "";
      $regions = array(
        'QLD' => 'Queensland',
        'NSW' =>'New South Wales',
        'SA' =>'South Australia',
        'TAS'=>'Tasmania',
        'VIC'=>'Victoria',
        'WA'=>'Western Australia',
        'ACT'=>'Australia Capital Territory',
        'NT'=>'Northern Territory'
        );
      foreach($regions as $key =>$value):
                if(strcasecmp($key,$cat_name)==0){
                  $statename = strtoupper($value); 

                }

        endforeach;
     ?>

<div class="container clearfix">
<div class="inerblock_serc_cde cc-locator-sec">
<div class="cc-locator-title-sec-z">
<?php 
 echo '<h4><span class="cc-locator-sub"><a href="'.site_url().'/find-a-store/">'. 'STORE FINDER'.'</a></span>'.'>'.'<span class="cc-locator-root"><a href="'.site_url().'/find-a-store/'.strtolower($cat_name).'">'. $statename .'</a></span>'.'>'.'
  <span class="cc-locator-current"><a href="'.get_the_permalink().'">'. strtoupper(get_the_title()).'</a></span></h4>';

?>

</div>
<div class="col-md-12 clearfix">
<div class="col-md-6 pull-left">
<?php 
$url = site_url();
$url =explode('/',$url);

$stateID ="";
if(strcasecmp($url[2],'localhost')==0){
  $stateID = '1770';
 
}
else{
  $stateID ='26771';
   }



 ?>
 
<h3><?php echo get_the_title();?></h3>
</div>
<div class="col-md-6 pull-right"><?php 
echo '<a href="'.get_the_permalink($stateID).'"><' ;?>
 VIEW ALL STORE</a>
</div>
</div>

<div class="cc-ad-map-strn col-md-12 clearfix">
<div class="col-md-5 wpsl-single-left">

<div class="cc-info-store clearfix">
<div class="wpsl-address-sec">
<h4>ADDRESS</h4>

	<?php echo do_shortcode('[wpsl_address id="'.$post->ID.'" name="true" address="true" address2="false" 
       city="true" state="false" zip="true" country="false" phone="false" title="false"
       fax="false" email="false" url="true"]');
       ?>
       <?php $url = get_post_meta($post->ID);


        ?>
       <a href="https://maps.google.com/maps?saddr=&daddr=<?php echo $url['wpsl_address'][0].' '.$url['wpsl_city'][0];?>" target="_blank">GET DIRECTION</a>
       </div>
       <div class="wpsl-phone-sec">
	<?php echo do_shortcode('[wpsl_address id="'.$post->ID.'" name="false" address="false" address2="false" 
       city="false" state="false" zip="false" country="false" phone="true" 
       fax="true" email="false" url="false"]');
       ?>
       <div class="cc-str-cntblk cc-str-cntblk-a cc-str-cntblk-a-map clearfix"><a href="http://staging.carpetcall.com.au/contact-us/?id=<?php echo $post->ID;?>" class="cc-contact-link">CONTACT STORE</a></div>
       </div>
       
</div>

<div class="wpsl-hour-sec clearfix">
       <span><strong>Opening Hours</strong></span>
       	<?php echo do_shortcode('[wpsl_hours id="'.$post->ID.'" hide_closed="true"]') ;?>
       </div>

</div>

<div class="col-md-7 wpsl-single-right">
   
	<?php echo do_shortcode('[wpsl_map id="'.$post->ID.'" width="500" height="350" zoom="5" map_type="roadmap" 
map_type_control="true" map_style="default" street_view="false" 
scrollwheel="true" control_position="left"]'); 
?>
</div>

</div>

</div>
</div><div class="clearfix"></div>
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
  padding:5px;}
#wpsl-stores{
  overflow:visible !important;
}
.fcnt-orr-map a {
  background:#fff;
  border:1px solid #1858b8;
  color:#1858b8;
} 
.fcnt-orr-map a:hover{
background:#fff;
}

</style>
<?php
get_footer();
?>