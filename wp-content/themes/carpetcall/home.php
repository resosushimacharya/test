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
       <?php get_template_part('content','headings');?><!-- parcel delivery end here -->      
    
       <div class="container">
    <div class="calbk"><div class="row">
    <div class="col-sm-3"><div class="cpt_supt"><img src="<?php echo get_template_directory_uri() ;?>/images/carpetcall-support-img.png" alt="support" class="img-responsive"/> </div></div><!-- support img end -->
    <div class="col-sm-5">
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
    
       <div class="feature_pro">
        	<div class="container">
            		<div class="row">
            	<div class="meropro_blk">
                <h1> Featured Products </h1>
                
                <div class="col-md-12 no-lr">
                
                	<div class="responsive">
                     <!-- product six end  -->
                     <?php get_template_part('content','featured'); ?>
                      
                    </div><div class="clearfix"></div>
                    
                </div><div class="clearfix"></div>
                
                </div></div><div class="clearfix"></div>
            </div>
     </div><div class="clearfix"></div><!-- featured product end here -->
       <!--ideas and advice strats here -->
       <?php get_template_part('content','idea');?>
      <!-- ideas and advice end here -->
       <!-- trade starts here -->
         <?php get_template_part('content','expert');?>        
      <!-- trade end here -->
       
       <?php get_template_part('content','carpetmap');?><!-- about and visit content end here -->
       
    
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
   
   
