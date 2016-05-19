<?php
/* Template Name: design */
 get_header();?>
    
        <?php/*    why choose us section          */?>

    <?php 
        $id=114;
        $choose = get_post($id);
       
        ?>
       <!-- slider start -->

       <?php get_template_part('content','visualiser');?>
       <!-- slider end --> 
       <!-- parcel delivery end  --> 
       <?php get_template_part('content','headings');?>

      <!-- parcel delivery end here -->      
    
       <div class="container">
    <div class="calbk"><div class="row">
    <div class="col-sm-2"><div class="cpt_supt"><img src="<?php echo get_template_directory_uri() ;?>/images/carpetcall-support-img.png" alt="support" class="img-responsive"/> </div></div><!-- support img end -->
    <div class="col-sm-6">
    <h3 class="bookcbk"> BOOK A CALLBACK </h3>
    <h4 class="cptspl"> WITH OUR FLOORING SPECIALISTS </h4>
    <div class="suptlst">
    <?php $booklink=get_field('contactlink',89);
    //do_action('custom_hook_inspect_carpetcall',$booklink);?>
    <ul><?php
    foreach($booklink as $singlelink)
    {  
        
            echo '<li><a href="'.$singlelink['contact_url'].'"'.'target="_blank">'.$singlelink['_ask_an_expert'].'</li>';
        
       
    }



    
    ?>
    
    
    </ul>
    </div><div class="clearfix"></div>
    </div><!-- support text end -->
    <div class="col-sm-4">
    <div class="cptin cptinn">
    <a href="#"> CONTACT US </a>
    </div>
    </div><!-- contact end -->
    </div></div>
    </div><div class="clearfix"></div><!-- contact us end here -->
    <!-- featured product starts here -->
        <?php get_template_part('content','featured'); ?>
       <div class="feature_pro">
        	<div class="container">
            	<div class="meropro_blk">
                <h1> Featured Products </h1>
                
                <div class="col-md-12">
                
                	<div class="responsive"><!-- feautured -->
                      
                      
                
                      
                    
                      
                   
                      <!-- feautured -->
                    </div><div class="clearfix"></div>
                    
                </div><div class="clearfix"></div>
                
                </div><div class="clearfix"></div>
            </div>
     </div><div class="clearfix"></div><!-- featured product end here -->
       
       <div class="container">
       	<div class="thought_blk">
        <h2> IDEAS &amp; ADVICE </h2>
        <div class="row">
        	<div class="col-md-6">
            
            <div class="rmvisual" style="background:<?php echo get_template_directory_uri().'/images/room-visual.png';?>; float:right; background-color:#0a71cf;">
            <img src="<?php echo get_template_directory_uri().'/images/room-visual.png';?>" alt="room" class="img-responsive" style="float:right;"/>
            
            <div class="rmblk_cont">
            	<h3> ROOM VISUALISER </h3>
                <p> See how your choice of rug, carpet or hard flooring looks with this tool. </p>
                <div class="trynow trynoww"><a href="#"> TRY IT NOW </a> &nbsp; <i class="fa fa-angle-right" aria-hidden="true"></i> </div><div class="clearfix"></div>               
            </div>
            
            </div><div class="clearfix"></div><!-- room visualiser end here -->
            
            <div class="guide_a" style="background:<?php echo get_template_directory_uri().'/images/guides.png';?>; float:right; background-color:#15489f;">
            <img src="<?php echo get_template_directory_uri().'/images/guides.png';?>" alt="guide" class="img-responsive" style="float:right;"/>
            
            <div class="inner_cont">
            <h4> BUYING GUIDES  </h4>
            
            <ul class="guide_list">
            <li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp; <a href="#"> Carpet </a></li>
            <li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp; <a href="#"> Rugs </a></li>
            <li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp; <a href="#"> Hard Floor </a></li>
            <li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp; <a href="#"> Vinyls </a></li>
            <li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp; <a href="#"> Bamboo </a></li>
            </ul><div class="clearfix"></div>
            
            </div>
            
            </div><div class="clearfix"></div><!-- guide end here -->
            
            
            </div><!-- idea left side end here -->
            
            <div class="col-md-6">
            
            <div class="care_pro" style="background:<?php echo get_template_directory_uri().'/images/care.png';?>; float:right; background-color:#0a71cf;">
            	<img src="<?php echo get_template_directory_uri().'/images/care.png';?>" alt="room" class="img-responsive" style="float:right;"/>
                <div class="rmblk_cont">
            	<h3> PRODUCT CARE </h3>
                <p> Find comprehensive care and cleaning guides for all our quality flooring products. </p>
                <div class="trynow trynoww"><a href="#"> SEE IT NOW </a> &nbsp; <i class="fa fa-angle-right" aria-hidden="true"></i> </div><div class="clearfix"></div>               
            </div>
            </div><div class="clearfix"></div><!-- prodoct care end here -->
            
            <div class="faq_blk">
            asdf
            </div><div class="clearfix"></div><!-- faq end here -->
            
            </div><!-- idea right side end here -->
        </div><div class="clearfix"></div>
        
        
        
        </div><div class="clearfix"></div>
       </div><div class="clearfix"></div><!-- ideas and advice end here -->
                 
       <div class="expert">
    	<div class="container"><div class="row">
        <h4 class="mi_inst"> WE ARE THE EXPERTS IN TRADE </h4>
        <?php 
   $i=0; /* backgrounds */
           $args=array('post_type'=>'experts','post_status'=>'publish','order' => 'ASC');
           $experts=new WP_Query($args);
           while($experts->have_posts()):
            $experts->the_post();
        
        $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID));?>
        	<div class="col-md-6">
            <img src="<?php echo get_template_directory_uri() ;?>/images/trade-a.jpg" alt="trade" class="img-responsive"/>
            <h4 class="quote_a"><?php echo the_title(); ?></h4>
            <p> <?php echo get_the_content();?></p>
            
            <div class="mycnt mycntt"><a href="<?php echo get_permalink(89);?>"> CONTACT US </a></div>
            
            </div><!-- measure end -->
            
            <!-- installation end -->
            <?php
            $i++;
             endwhile;?>
        </div></div>
    </div><div class="clearfix"></div><!-- expert trade end -->
    
    <script type="text/javascript">
    $(document).on('ready', function() {
      var left_offset = jQuery(".container").offset().left;
	
      $('.center').slick({
		  centerMode: true,
		  centerPadding: left_offset + 'px',
		  slidesToShow: 1,
		  arrows: true,
		  dots: true,
		   draggable:false,
		  responsive: [
			{
			  breakpoint: 768,
			  settings: {
				arrows: false,
				centerMode: true,
				centerPadding: '40px',
				slidesToShow: 3,
				draggable:true,
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				arrows: false,
				centerMode: true,
				centerPadding: '40px',
				slidesToShow: 1,
				draggable:true,
				
			  }
			}
		  ]
		});		
		
				$('.responsive').slick({
		  dots: true,
		  infinite: false,
		  speed: 300,
		  slidesToShow: 4,
		  slidesToScroll: 4,
		  responsive: [
			{
			  breakpoint: 1024,
			  settings: {
				slidesToShow: 3,
				slidesToScroll: 3,
				infinite: true,
				dots: true
			  }
			},
			{
			  breakpoint: 600,
			  settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			  }
			}
			// You can unslick at a given breakpoint now by adding:
			// settings: "unslick"
			// instead of a settings object
		  ]
		});
     
    });
  </script>
    
   <?php get_footer();?>
   
   
