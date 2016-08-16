<?php 
$url = site_url();
$url =explode('/',$url);

if(strcasecmp($url[2],'localhost')==0){
  
$aboutID =317;
$storeID =1770;
}
else{
  
$aboutID =317;
$storeID =26771 ;
}


 ?>
<div class="container"><!-- about and map section start here -->
<div class="abvist clearfix">
    
    <div class="col-md-6 no-pl"><!-- about start here -->
    <div class="intro">
        <?php 
            $about = get_post($aboutID);            
        ?>
        <h1><?php echo get_field('home_about_heading','option') ;?></h1>
        <?php 
            // load About Us Home Content from About Us page ( custom field )
            $about_us_home_content = get_field( 'about_carpetcall_home_content' , $aboutID );
            echo apply_filters( 'the_content' , $about_us_home_content ); 
        ?>            
        <div class="rmore rmoree">
            <a href="<?php echo get_the_permalink( $aboutID ); ?>" title="<?php echo $about->post_title; ?>"><?php _e('Read More' , 'carpetcall'); ?></a>
        </div>
        <div class="clearfix">  </div>
    </div>
    </div><!-- about end here -->
    
    <div class="col-md-6"><!-- maps start here -->
    <div class="stmap" >
        <h2> VISIT OUR STORES </h2>
        
        <div class="store-map">
            
            <?php get_template_part('templates/cotents/content','map');?>
            </div><div class="clearfix"></div><!-- for store map end -->
            <?php $storelink = get_field('visit_our_store_link',$storeID);
            ?>
            <div class="rmore rmoree"><?php echo $storelink;?></div><div class="clearfix"></div>
        </div>
        </div><!-- maps end here -->
        
        </div><div class="clearfix"></div>
        </div><div class="clearfix"></div>
        