<div class="container"><!-- about and map section start here -->
<div class="abvist clearfix">
    
    <div class="col-md-6"><!-- about start here -->
    <div class="intro">
        <?php $about = get_post(317);
        ?>
        <h1> <?php echo get_field('home_about_heading','option') ;?></h1>
        <?php echo apply_filters('the_content',$about->post_content); ?>
        
        <?php $aboutlink = get_field('about_carpetcall_link',317);
        ?>
        <div class="rmore rmoree"><?php echo $aboutlink;?></div><div class="clearfix"></div>
    </div>
    </div><!-- about end here -->
    
    <div class="col-md-6"><!-- maps start here -->
    <div class="stmap" >
        <h2> VISIT OUR STORES </h2>
        
        <div class="store-map">
            
            <?php get_template_part('content','map');?>
            </div><div class="clearfix"></div><!-- for store map end -->
            <?php $storelink = get_field('visit_our_store_link',878);
            ?>
            <div class="rmore rmoree"><?php echo $storelink;?></div><div class="clearfix"></div>
        </div>
        </div><!-- maps end here -->
        
        </div><div class="clearfix"></div>
        </div><div class="clearfix"></div>
        