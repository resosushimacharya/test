<?php 
/*
* Template Name: Map
*/
get_header();?>
<div class="body-wrapper">
<div class="container ">
<div class="col-md-12">
<div id="<?php echo the_ID();  ?>">


<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCN3lkABBKjsMdIzAyI1Rwy_6Z8cT8IEWc&libraries=places">
</script> 
<div class="cc-main-map-store" style="margin-top:20px">
       <?php get_template_part('content','main-store-map');?>
   </div>
<?php

/* query the wpsl_stores post type to get the lat and lond and location name and title;
@extract meta field that holds value of respective fields.
*/
$sll = array();
$args = array(
    'post_type'=>'wpsl_stores',
    'posts_per_page'=>'-1',
      /*'meta_query' => array (
            array (
              'key' => 'store_type',
              'value' => 'head_office',
            )
          )*/

 

    );
$loop = new WP_Query($args);
while($loop->have_posts()):
$loop->the_post();
$getinfo  = get_post_meta($post->ID);

$lat = $getinfo['wpsl_lat'];
$long = $getinfo['wpsl_lng'];
$stoLatLong=array($lat,$long);
$add = $getinfo['wpsl_address'][0];
$title = get_the_title();
$sll[] = array($title,$add,$stoLatLong);

endwhile;
wp_reset_query();

?>
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="container">
<div id="wpsl-wrap" class="wpsl-store-below wpsl-default-filters">
    <div id="wpsl-result-list">
        <div id="wpsl-stores">
        <?php 

            $args = array(
                'post_type'=>'wpsl_stores',
                'posts_per_page'=>'-1',
                'meta_query' => array (
                array (
                'key' => 'store_type',
                'value' => 'head_office',
                )
            ) 
          );

            $loop = new WP_Query($args);
        ?>
         <ul>

        <?php   

          while($loop->have_posts()):
                $loop->the_post();
        ?>
       
        <li class="col-md-4">
         <div>
            <p>
                <span class="cc-store-icon-label">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/markers/location.png">
                    <strong>
                    <a href="http://localhost/carpetcall/find-a-store/wa//midland/"><?php echo get_the_title();?></a>
                    </strong>
                </span>
            </p>
            <div class="clearfix"></div>
            <span class="wpsl-street"><?php echo get_post_meta($post->ID,'wpsl_address',true );?></span>
                
            <span> Midland WA</span>
            <span class="wpsl-country"><?php echo get_post_meta($post->ID,'wpsl_country',true );?></span>
            <span><strong>P</strong>: <?php echo get_post_meta($post->ID,'wpsl_phone',true );?></span>
            <span><strong>F</strong>: <?php echo get_post_meta($post->ID,'wpsl_fax',true );?></span>
                
                
            <div class="fcnt-or fcnt-orr clearfix">
                <a href="<?php echo get_the_permalink();?>">View Store Page</a>
            </div>
            <div class="fcnt-or fcnt-orr fcnt-orr-map clearfix">
                <a href="http://localhost/carpetcall/contact-us/?id=<?php echo $post->ID ; ?>" class="cc-contact-link  ">Contact Store</a>
            </div>         
        </div>
        <a class="wpsl-directions" target="_blank" href="https://maps.google.com/maps?saddr='australia'&amp;daddr='<?php echo get_post_meta($post->ID,'wpsl_address',true );?>'">Directions</a>
        </li>
    <?php endwhile;
    wp_reset_query(); ?>
        </ul>
        </div>
    </div>
</div>
</div>
<style>
.body-wrapper{
        margin:250px 0 38px 0;
}

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


<?php get_footer(); ?>