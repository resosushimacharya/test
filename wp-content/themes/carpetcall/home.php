<?php
/* Template Name: home */
 get_header();?>
    
        <?php/*    why choose us section          */?>

    <?php 
        $id=114;
        $choose = get_post($id);
       
        ?>
       
       <div class="container-fluid carpetcall_slide">
       	<section class="center slider">
    <div>
    <div class="hamro">
      	<h3> Room Visualiser </h3>
        <h4> Ideas &amp; Advice  </h4>
        <h5 class="tryit tryita"><a href="#"> TRY IT NOW </a></h5>
      </div>
      <img src="<?php echo get_template_directory_uri().'/slide/slide.jpg';?>" alt="images" class="img-responsive">
      
    </div>
    <div>
      <img src="<?php echo get_template_directory_uri().'/slide/carpetcall.jpg';?>" alt="images" class="img-responsive">
    </div>
    <div>
      <img src="<?php echo get_template_directory_uri().'/slide/carpetcall1.jpg';?>" alt="images" class="img-responsive">
    </div>
    <div>
      <img src="<?php echo get_template_directory_uri().'/slide/carpetcall2.jpg';?>" alt="images" class="img-responsive">
    </div>
    <div>
      <img src="<?php echo get_template_directory_uri().'/slide/carpetcall3.jpg';?>" alt="images" class="img-responsive">
    </div>
    <div>
      <img src="<?php echo get_template_directory_uri().'/slide/carpetcall4.jpg';?>" alt="images" class="img-responsive">
    </div>
    <div>
       <img src="<?php echo get_template_directory_uri().'/slide/carpetcall4.jpg';?>" alt="images" class="img-responsive">
    </div>
   
    
  </section>
       </div><div class="clearfix"></div><!-- slider end --> 
       
       <div class="meroshop"><div class="container">
        	
            <div class="col-md-12">
            	<div class="col-md-4">
                <div class="shopping">
                
                	<div class="aag">
                    <img src="<?php echo get_template_directory_uri().'/images/shop-icon.png';?>" width="37" height="49" alt="icon" style="float:left;"/>
                    <h3 class="so_title so_titlee"><a href="#"> Shop Online </a></h3>
                    <p>Shop Online &amp; Collect in participating stores </p>
                    
                    </div><div class="clearfix"></div>
                    
                </div>
                </div><!-- shop online end here -->
                
                <div class="col-md-4">
                <div class="shopping">
                
                	<div class="aag_a">
                    <img src="<?php echo get_template_directory_uri().'/images/free-icon.png';?>" width="52" height="45" alt="icon" style="float:left;"/>
                    <h3 class="aag_ab aag_ab"><span class="merof"> FREE </span><a href="#">delivery </a></h3>
                    <p>for all Online Rug orders within Australia</p>
                    
                    </div><div class="clearfix"></div>
                    
                </div>
                </div><!-- free delivery end here  -->
                
                <div class="col-md-4">
                <div class="shopping">
                
                	<div class="aag_c">
                    <img src="<?php echo get_template_directory_uri().'/images/like-icon.png';?>" width="41" height="43" alt="icon" style="float:left;"/>
                    <h3 class="aag_cd aag_cdd"><span class="merof">100%</span> <a href="#"> Product &amp; Delivery </a></h3>
                    <p>Satisfaction Rate</p>
                    
                    </div><div class="clearfix"></div>
                    
                </div>
                </div><!-- product delivery end here  -->
                
            </div><div class="clearfix visible-md"></div>
            
        </div></div><div class="clearfix"></div><!-- parcel delivery end here -->      
    
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
    
       <div class="feature_pro">
        	<div class="container">
            	<div class="meropro_blk">
                <h1> Featured Products </h1>
                
                <div class="col-md-12">
                
                	<div class="responsive">
                      <div class="pro_one">
                      <img src="<?php echo get_template_directory_uri().'/images/product-a.jpg';?>" alt="product" class="img-responsive"/>
                      <div class="sublk_prom">
                      		<div class="ptxt">
                            	<h3>Faded oak </h3>
                                <h4> Carpet </h4>
                            </div><div class="clearfix"></div>
                           <div class="nowsp nowspp"><a href="#"> SHOP NOW </a></div><div class="clearfix"></div> 
                      </div><div class="clearfix"></div>
                      
                      </div><!-- product one end  -->
                      
                      <div class="pro_two">
                      <img src="<?php echo get_template_directory_uri().'/images/product-b.jpg';?>" alt="product" class="img-responsive"/>
                      <div class="sublk_prom">
                      		<div class="ptxt">
                            	<h3>CLASSIC 1050 </h3>
                                <h4> LAMINATE FLOORING </h4>
                                <h5> A$28.00/sqm </h5>
                            </div><div class="clearfix"></div>
                           <div class="nowsp nowspp"><a href="#"> SHOP NOW </a></div><div class="clearfix"></div> 
                      </div><div class="clearfix"></div>
                      </div><!--  product two end -->
                      
                      <div class="pro_thr">
                       <img src="<?php echo get_template_directory_uri().'/images/product-c.jpg';?>" alt="product" class="img-responsive"/>
                      <div class="sublk_prom">
                      		<div class="ptxt">
                            	<h3>Trim </h3>
                                <h4> ACCESSORIES </h4>
                                <h5> A$32.00 </h5>
                            </div><div class="clearfix"></div>
                           <div class="nowsp nowspp"><a href="#"> SHOP NOW </a></div><div class="clearfix"></div> 
                      </div><div class="clearfix"></div>
                      </div><!-- product three end  -->
                      
                      <div class="pro_for">
                       <img src="<?php echo get_template_directory_uri().'/images/product-d.jpg';?>" alt="product" class="img-responsive"/>
                      <div class="sublk_prom">
                      		<div class="ptxt">
                            	<h3>DESIGNER COLLECTION  </h3>
                                <h4> RUGS</h4>
                                <h5> A$225.00 </h5>
                            </div><div class="clearfix"></div>
                           <div class="nowsp nowspp"><a href="#"> SHOP NOW </a></div><div class="clearfix"></div> 
                      </div><div class="clearfix"></div>
                      </div><!-- product four end  -->
                      
                      <div class="pro_fiv">
                       <img src="<?php echo get_template_directory_uri().'/images/product-e.jpg';?>" alt="product" class="img-responsive"/>
                      <div class="sublk_prom">
                      		<div class="ptxt">
                            	<h3>Faded oak </h3>
                                <h4> Carpet </h4>
                            </div><div class="clearfix"></div>
                           <div class="nowsp nowspp"><a href="#"> SHOP NOW </a></div><div class="clearfix"></div> 
                      </div><div class="clearfix"></div>
                      </div><!-- product five end  -->
                      
                      <div class="pro_six">
                       <img src="<?php echo get_template_directory_uri().'/images/product-f.jpg';?>" alt="product" class="img-responsive"/>
                      <div class="sublk_prom">
                      		<div class="ptxt">
                            	<h3>Faded oak </h3>
                                <h4> Carpet </h4>
                            </div><div class="clearfix"></div>
                           <div class="nowsp nowspp"><a href="#"> SHOP NOW </a></div><div class="clearfix"></div> 
                      </div><div class="clearfix"></div>
                      </div><div class="clearfix"></div><!-- product six end  -->
                      
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
            
            <div class="faq_blk" style="background:<?php echo get_template_directory_uri().'/images/faq.png';?>; float:right; background-color:#15489f;">
            <img src="<?php echo get_template_directory_uri().'/images/faq.png';?>" alt="room" class="img-responsive" style="float:right;"/>
            
            <div class="quest_cont">
            	<h4> FAQ'S </h4>
                <ul class="guide_list">
            <li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp; <a href="#"> Carpet </a></li>
            <li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp; <a href="#"> Rugs </a></li>
            <li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp; <a href="#"> Hard Floor </a></li>
            <li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp; <a href="#"> Vinyls </a></li>
            <li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp; <a href="#"> Bamboo </a></li>
            </ul><div class="clearfix"></div>
                
            </div>
            
            </div><div class="clearfix"></div><!-- faq end here -->
            
            
            </div><div class="clearfix"></div><!-- idea right side end here -->
        </div><div class="clearfix"></div>
        
        
        
        </div><div class="clearfix"></div>
       </div><div class="clearfix"></div><!-- ideas and advice end here -->
                 
       <div class="trade">
       		<div class="container">
            	<div class="hamro_trade">
                	<h2>we are the experts in the trade </h2>
                    
                    <div class="row">
                    	<div class="col-md-6">
                        <div class="measure_blk">
                        	<div class="meas_img" style="background:<?php echo get_template_directory_uri().'/images/trade-a.jpg';?>";>
                            <img src="<?php echo get_template_directory_uri().'/images/trade-a.jpg';?>" alt="guide" class="img-responsive"/>
                            </div><div class="clearfix"></div>
                           
                           <div class="measr_cnt">
                           	<h3><span class="frcol"> FREE</span> MEASURE AND QUOTE </h3>
                            <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                            <p> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.  </p>
                           </div><div class="clearfix"></div>
                           
                           <div class="find_tb find_tbb">
                          <a href="#"> FIND OUT MORE </a>
                           </div><div class="clearfix"></div>
                            
                        </div>
                        </div><!-- measuer end -->
                        
                        <div class="col-md-6">
                        <div class="measure_blk">
                        	<div class="meas_img" style="background:<?php echo get_template_directory_uri().'/images/trade-b.jpg';?>";>
                            <img src="<?php echo get_template_directory_uri().'/images/trade-b.jpg';?>" alt="guide" class="img-responsive"/>
                            </div><div class="clearfix"></div>
                           
                           <div class="measr_cnt">
                           	<h3> CARPETCALL INSTALLATION </h3>
                            <p> Carpetcall offers flooring installation for our laminate, vinyl, bamboo, cork, timber &amp; carpet products. </p>
                            <p> One of our Flooring Specialist can meet you in your home, where they can accurately measure and quote on your installation.  </p>
                           </div><div class="clearfix"></div>
                           
                           <div class="find_tb find_tbb">
                          <a href="#"> CONTACT US </a>
                           </div><div class="clearfix"></div>
                            
                        </div>
                        </div><!-- installation end -->
                        
                    </div><div class="clearfix"></div>
                    
                </div><div class="clearfix"></div>
            </div>
       </div><div class="clearfix"></div><!-- trade end here -->
       
       <div class="container">
       	<div class="abvist">
        	<div class="row">
            	<div class="col-md-6">
                <div class="intro">
                	<h1> ABOUT CARPETCALL </h1>
                    <p>Carpet Call is Australia’s largest independent flooring retailer stocking and installing all of your flooring needs with our huge range of flooring products. We have over 70 stores Australia wide completely stocked with all types of flooring including carpet, rugs, timber, laminate, vinyl floors, and much more. At Carpet Call you’ll find exactly what you need to brighten up any room in your home. </p>
                    <p> Our first Carpet Call store opened 40 years ago and since then we have grown to become one of Australia’s most well-known and best loved providers of quality flooring products. We are known for our professional and knowledgeable staff, so visit a Carpet Call store near you for expert advice about your next flooring purchase.</p>
                </div>
                </div><!-- about end here -->
                
                <div class="col-md-6">asdfasdf</div><!-- maps end here -->
                
            </div><div class="clearfix"></div>
        </div><div class="clearfix"></div>
       </div><div class="clearfix"></div><!-- about and visit content end here -->
       
    
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
   
   
