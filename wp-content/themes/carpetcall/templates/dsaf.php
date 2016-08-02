<?php
/* 
** Template Name: Store Main page
*/
?>
<?php get_header();?>



<div class="cbg_blk cc-clearance-blk clearfix">
 <div class="container ">
<div class="inerblock_serc cc-wrapper-whole">
<div class="col-md-12">         
 <div class="cc-bread-crumb">
 <span class="cc-bread-store">CARPET CALL STORES</span>
 </div>
<div class="cc-finder-title">
<h3>STORE FINDER</h3>
<?php var_dump($_POST); ?>
</div>
<div class="cc-options-wrapper">
<form method="post">
<input type="hidden" name="check-near-id" value="check near value"/>
<input type="submit" id="cc-but-near" class="cc-but-near-con" value="FIND YOUR NEAREST STORE" name="cc-but-near-name"/>
</form >
<form method="post">
<input type="hidden" name="check-head-id" value="check head value"/>
<input type="submit" id="cc-but-head" class="cc-but-head-con" value="HEAD OFFICES" name="cc-but-head-name"/>
</form>
</div>
<?php if(isset$_POST("check-near-id")){
  get_template_part('content','main-store-map.php')
}
<ul class="nav nav-tabs cc-tab-store-section">
  <li class="active cc-tab-store"><a data-toggle="tab" href="#find_your_nearest_store">FIND YOUR NEAREST STORE</a></li>
  <li class="google-map-load cc-tab-store"><a data-toggle="tab" href="#head_offices">HEAD OFFICES</a></li>
  
</ul>

<div class="tab-content ">
  <div id="find_your_nearest_store" class="tab-pane fade in active">
    
    <p><?php
      if(!isset($_POST["cc-current-location-store"])) {

     echo do_shortcode('[wpsl template="custom"]');
     }
     else{
      echo do_shortcode('[wpsl]');
      }?></p>

    <?php 
    if(!isset($_POST["cc-current-location-store"]) && !isset($_POST["wpsl-search-input"]) ){?>
   
 

<div id="gmap" style="height: 500px; width:100%;"></div>

<div class="cc-store-list-section">

<h4>SHOWING STORES AUSTRALIA WIDE </h4>

    <?php 
      $tax = 'wpsl_store_category';
      $tax_terms = get_terms($tax, array('hide_empty' => true));
     
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
      foreach($tax_terms as $term):
       
        echo '<div class="cc-state-link"><a href="'.site_url().'/find-a-store/'.strtolower($term->name).'" >'.$regions[$term->name].'</a></div>';
        endforeach;

}

    ?>
  </div>
  </div>
  <div id="head_offices" class="tab-pane fade">
    <div class="body-wrapper">
<div class="container ">
<div class="col-md-12">
<div id="<?php echo the_ID();  ?>">
 <div id="Map" style="width: 100%; height: 450px;"></div>

</div>
</div>
</div>
<div class="clearfix"></div>
<div class="container">
<!-- <div id="wpsl-wrap" class="wpsl-store-below wpsl-default-filters">
    <div id="wpsl-result-list">
        <div id="wpsl-stores"> -->
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

              $getinfo  = get_post_meta($post->ID);

                  $lat = $getinfo['wpsl_lat'];
                  $long = $getinfo['wpsl_lng'];
                  $stoLatLong=array($lat,$long);
                  $add = $getinfo['wpsl_address'][0];
                  $title = get_the_title();
                  $sll[] = array($title,$add,$stoLatLong);

           
    

        ?>
       
        <li class="col-md-4">
         <div>
            <p>
                <span class="cc-store-icon-label">
                    <img src="http://localhost/carpetcall/wp-content/themes/carpetcall/images/blue.png">
                    <strong>
                    <a href="http://localhost/carpetcall/find-a-store/wa//midland/"><?php echo get_the_title();?></a>
                    </strong>
                </span>
            </p>
            <div class="clearfix"></div>
            <span class="wpsl-street"><?php echo get_post_meta($post->ID,'wpsl_address',true );?></span>
                
            <span class="wpsl-street-a"> Midland WA</span>
            <span class="wpsl-country"><?php echo get_post_meta($post->ID,'wpsl_country',true );?></span>
            <span class="wpsl-street-b"><strong>P</strong>: <?php echo get_post_meta($post->ID,'wpsl_phone',true );?></span>
            <span class="wpsl-street-c"> <strong>F</strong>: <?php echo get_post_meta($post->ID,'wpsl_fax',true );?></span>
                
                
            <div class="fcnt-or fcnt-orr clearfix">
                <a href="<?php echo get_the_permalink();?>">View Store Page</a>
            </div>
            <div class="fcnt-or fcnt-orr fcnt-orr-map clearfix">
                <a href="http://localhost/carpetcall/contact-us/?id=<?php echo $post->ID ; ?>" class="cc-contact-link  ">Contact Store</a>
            </div>         
        </div>
       
        </li>
    <?php endwhile;
    wp_reset_query(); ?>
        </ul>
        </div>
    </div>
<!-- </div>
</div>
  </div> -->
  
</div>


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
.cc-main-map-store{
    width:100%;
    height:465px;
}
.cc-store-list-section{
  margin:10px 0px;
}
.cc-store-list-section h4{
  padding:10px 0px;
  color:#15489f;

}
.cc-finder-title{
  margin:5px 0px;
}
.cc-finder-title h3{
   padding:10px 0px;
}
.cc-bread-crumb{
margin:5px 0px;
}
.cc-bread-crumb h3{
    padding:10px 0px;
}
.cc-tab-store{
  background:#ffffff;
  padding:5px;
}
.nav-tabs>li>a:hover>li.active>a, .nav-tabs>li>a:hover>li.active>a:focus, ..nav-tabs>li>a:hover>li.active>a:hover{
    border:none !important;
}
c-state-link{
  margin:5px 0px;
}
.cc-state-link a{
 padding:10px 0px;
 text-decoration:none;
}
</style>


<?php 
    get_footer();   
if(!isset($_POST["cc-current-location-store"])) {
  get_template_part('content','auxuliary'); }
    if(!isset($_POST["cc-current-location-store"]) && !isset($_POST["wpsl-search-input"])){
      
   
   get_template_part('content','main-store-map');
    }



?>
<script>
/*$(function(){

  $(document).ready()(function(){

    $('#cc-but-near').click

  });
});*/
</script>

