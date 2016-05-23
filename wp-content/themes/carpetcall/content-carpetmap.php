<div class="container"><!-- about and map section start here -->
       	<div class="abvist clearfix">
        	
            	<div class="col-md-6"><!-- about start here -->
                <div class="intro">
                <?php $about = get_post(317);
                 ?>
                	<h1> <?php echo $about->post_title; ?></h1>
                    <?php echo apply_filters('the_content',$about->post_content); ?>
                    
                    <div class="rmore rmoree"><a href="<?php echo get_permalink($about->ID); ?>"> Read More </a></div><div class="clearfix"></div>
                </div>
                </div><!-- about end here -->
                
                <div class="col-md-6"><!-- maps start here -->
                <div class="stmap">
                	<h2> VISIT OUR STORES </h2>
                    
                    <div class="store-map">
                    
                    <?php get_template_part('content','map');?>
                    </div><div class="clearfix"></div><!-- for store map end -->
                    
                    <div class="rmore rmoree"><a href="#"> Find a Store </a></div><div class="clearfix"></div>
                </div>
                </div><!-- maps end here -->
           
        </div><div class="clearfix"></div>
       </div><div class="clearfix"></div>