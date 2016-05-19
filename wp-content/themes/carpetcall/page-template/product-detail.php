<?php
/* Template Name: home */
 get_header();?>
    
    <div class="container">
    <div class="wellblk"><div class="row">
    
    <div class="col-md-4">
    	<?php 
        $id=76;
        $welcome = get_post($id);
       
        ?>
        	<h1 class="intro"><?php  echo $welcome->post_title;?></h1>
            <p class="weltxt"><?php  echo $welcome->post_content;?> </p>
        <div class="clearfix"></div><!-- welcome end -->
        
        <div class="welist">
        	
            <?php    /**
                * Displays a navigation menu
                * @param array $args Arguments
                */
                $args = array(
                    'theme_location' => 'front-menu',
                    'menu' => '',
                    'container' => 'div',
                    'container_class' => 'welist',
                    'container_id' => '',
                    'menu_class' => '',
                    'menu_id' => '',
                    'echo' => true,
                    'fallback_cb' => ' ',
                    'before' => '',
                    'after' => '',
                    'link_before' => '',
                    'link_after' => '',
                    'items_wrap' => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
                    'depth' => 0,
                    'walker' => ''
                );
            
                wp_nav_menu( $args );?>
        </div><div class="clearfix"></div><!-- listing product end -->
        
    </div><!-- welcome and listing end -->
    <?php get_template_part('content');?>
   
    
    </div></div>
    </div><div class="clearfix"></div><!-- welcome section end -->
    
    <div class="container-fluid crpchoose">
    	<div class="container">
        	<div class="whych">
            <h2 class="cptil"> WHY CHOOSE CARPETCALL </h2>
            <p class="crtxt">Carpet Call is Australia’s largest independent flooring retailer stocking and installing all of your flooring needs with our huge range of flooring products. We have over 70 stores Australia wide completely stocked with all types of flooring including carpet, rugs, timber, laminate, vinyl floors, and much more. At Carpet Call you’ll find exactly what you need to brighten up any room in your home.  </p> 
            <p class="crtxtt">
            Our first Carpet Call store opened 40 years ago and since then we have grown to become one of Australia’s most well-known and best loved providers of quality flooring products. We are known for our professional and knowledgeable staff, so visit a Carpet Call store near you for expert advice about your next flooring purchase.
            </p>
            
            <div class="row">
            	<div class="col-md-4">
                <img src="<?php echo get_template_directory_uri() ;?>/images/shop-a.png" alt="shop" class="img-responsive"/>
                <h3 class="shom"> SHOP IN HOME </h3>
                <h4 class="shslg">WE BRING OUR RANGE TO YOU  </h4>
                </div><!-- shop end -->
                
                <div class="col-md-4">
                 <img src="<?php echo get_template_directory_uri() ;?>/images/shop-b.png" alt="shop" class="img-responsive"/>
                <h3 class="shom"> FREE </h3>
                <h4 class="shslg">MEASURE AND QUOTE  </h4>
                </div><!-- free end -->
                
                <div class="col-md-4">
                 <img src="<?php echo get_template_directory_uri() ;?>/images/shop-a.png" alt="shop" class="img-responsive"/>
                <h3 class="shom"> AUSTRALIA'S LARGEST</h3>
                <h4 class="shslg"> AT YOUR SERVICE SINCE 1975 </h4>
                </div><!-- australia largest end -->
                
            </div><div class="clearfix"></div><!-- image part selection  end -->
            
            </div>
        </div>
    </div><div class="clearfix"></div><!-- why choose end -->
    
    <div class="container">
    <div class="calbk"><div class="row">
    <div class="col-sm-2"><div class="cpt_supt"><img src="<?php echo get_template_directory_uri() ;?>/images/carpetcall-support-img.png" alt="support" class="img-responsive"/> </div></div><!-- support img end -->
    <div class="col-sm-6">
    <h3 class="bookcbk"> BOOK A CALLBACK </h3>
    <h4 class="cptspl"> WITH OUR FLOORING SPECIALISTS </h4>
    <div class="suptlst">
    <ul>
    <li> - ASK AN EXPERT </li>
    <li>-  BOOK AN IN HOME FREE MEASURE AND QUOTE </li>
    <li>-  BOOK A TIME TO MEET INSTORE  </li>
    </ul>
    </div><div class="clearfix"></div>
    </div><!-- support text end -->
    <div class="col-sm-4">
    <div class="cptin cptinn">
    <a href="#"> CONTACT US </a>
    </div>
    </div><!-- contact end -->
    </div></div>
    </div><div class="clearfix"></div><!-- contact us -->
    
    <div class="rtfloblk">
   		<div class="container"><div class="row">
        	<div class="col-sm-12">
            	<h5 class="flotle"> CHOOSE THE RIGHT FLOORING </h5><div class="clearfix"></div>
                
                <div class="flotb">
                		<div id="horizontalTab">
        <ul>
            <li><a href="#tab-1">CARPET</a></li><!-- carpet end --->
            
            <li><a href="#tab-2">HARD FLOORING</a></li><!-- hard flooring end --->
            
            <li><a href="#tab-3">RUGS</a></li><!-- rugs end --->
        </ul>

        <div id="tab-1">
            
            <div class="row">
            	<div class="col-md-4">
                <div class="limblk">
                	<h3> LAMINATE </h3>
                    <img src="<?php echo get_template_directory_uri() ;?>/images/lam-img.jpg" alt="carpet" class="img-responsive"/>
                    
                    <div class="limblkk">
                    <h4> CONSTRUCTION </h4>
                    <p>Scratch resistant </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> BENEFITS </h4>
                    <p>Create a premium look for less.  </p>
                    <p>Easy to install &amp; durable </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> PRICE </h4>
                    <p>$-$$ </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> RECOMMENDED FOR </h4>
                    <p>Kids &amp; Pets </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="shnow shnoww">
                    <a href="#"> SHOP NOW </a>
                    </div><div class="clearfix"></div>
                    
                </div>
                </div><!-- laminate end -->
                
                <div class="col-md-4">
                <div class="limblk">
                	<h3> VINYL </h3>
                    <img src="<?php echo get_template_directory_uri() ;?>/images/lam-img.jpg" alt="carpet" class="img-responsive"/>
                    
                    <div class="limblkk">
                    <h4> CONSTRUCTION </h4>
                    <p>Scratch resistant </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> BENEFITS </h4>
                    <p>Create a premium look for less.  </p>
                    <p>Easy to install &amp; durable </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> PRICE </h4>
                    <p>$-$$ </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> RECOMMENDED FOR </h4>
                    <p>Kids &amp; Pets </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="shnow shnoww">
                    <a href="#"> SHOP NOW </a>
                    </div><div class="clearfix"></div>
                    
                </div>
                </div><!-- vynil end -->
                
                <div class="col-md-4">
                <div class="limblk">
                	<h3> TIMBER </h3>
                    <img src="<?php echo get_template_directory_uri() ;?>/images/lam-img.jpg" alt="carpet" class="img-responsive"/>
                    
                    <div class="limblkk">
                    <h4> CONSTRUCTION </h4>
                    <p>Scratch resistant </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> BENEFITS </h4>
                    <p>Create a premium look for less.  </p>
                    <p>Easy to install &amp; durable </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> PRICE </h4>
                    <p>$-$$ </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> RECOMMENDED FOR </h4>
                    <p>Kids &amp; Pets </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="shnow shnoww">
                    <a href="#"> SHOP NOW </a>
                    </div><div class="clearfix"></div>
                    
                </div>
                </div><!-- timber end -->
                
            </div>
            
        </div><!-- carpet end --->
        
        <div id="tab-2">
           
           <div class="row">
            	<div class="col-md-4">
                <div class="limblk">
                	<h3> LAMINATE </h3>
                    <img src="<?php echo get_template_directory_uri() ;?>/images/lam-img.jpg" alt="carpet" class="img-responsive"/>
                    
                    <div class="limblkk">
                    <h4> CONSTRUCTION </h4>
                    <p>Scratch resistant </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> BENEFITS </h4>
                    <p>Create a premium look for less.  </p>
                    <p>Easy to install &amp; durable </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> PRICE </h4>
                    <p>$-$$ </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> RECOMMENDED FOR </h4>
                    <p>Kids &amp; Pets </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="shnow shnoww">
                    <a href="#"> SHOP NOW </a>
                    </div><div class="clearfix"></div>
                    
                </div>
                </div><!-- laminate end -->
                
                <div class="col-md-4">
                <div class="limblk">
                	<h3> VINYL </h3>
                    <img src="<?php echo get_template_directory_uri() ;?>/images/lam-img.jpg" alt="carpet" class="img-responsive"/>
                    
                    <div class="limblkk">
                    <h4> CONSTRUCTION </h4>
                    <p>Scratch resistant </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> BENEFITS </h4>
                    <p>Create a premium look for less.  </p>
                    <p>Easy to install &amp; durable </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> PRICE </h4>
                    <p>$-$$ </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> RECOMMENDED FOR </h4>
                    <p>Kids &amp; Pets </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="shnow shnoww">
                    <a href="#"> SHOP NOW </a>
                    </div><div class="clearfix"></div>
                    
                </div>
                </div><!-- vynil end -->
                
                <div class="col-md-4">
                <div class="limblk">
                	<h3> TIMBER </h3>
                    <img src="<?php echo get_template_directory_uri() ;?>/images/lam-img.jpg" alt="carpet" class="img-responsive"/>
                    
                    <div class="limblkk">
                    <h4> CONSTRUCTION </h4>
                    <p>Scratch resistant </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> BENEFITS </h4>
                    <p>Create a premium look for less.  </p>
                    <p>Easy to install &amp; durable </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> PRICE </h4>
                    <p>$-$$ </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> RECOMMENDED FOR </h4>
                    <p>Kids &amp; Pets </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="shnow shnoww">
                    <a href="#"> SHOP NOW </a>
                    </div><div class="clearfix"></div>
                    
                </div>
                </div><!-- timber end -->
                
            </div>
           
        </div><!-- hard flooring end --->
        
        <div id="tab-3">
            
            <div class="row">
            	<div class="col-md-4">
                <div class="limblk">
                	<h3> LAMINATE </h3>
                    <img src="<?php echo get_template_directory_uri() ;?>/images/lam-img.jpg" alt="carpet" class="img-responsive"/>
                    
                    <div class="limblkk">
                    <h4> CONSTRUCTION </h4>
                    <p>Scratch resistant </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> BENEFITS </h4>
                    <p>Create a premium look for less.  </p>
                    <p>Easy to install &amp; durable </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> PRICE </h4>
                    <p>$-$$ </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> RECOMMENDED FOR </h4>
                    <p>Kids &amp; Pets </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="shnow shnoww">
                    <a href="#"> SHOP NOW </a>
                    </div><div class="clearfix"></div>
                    
                </div>
                </div><!-- laminate end -->
                
                <div class="col-md-4">
                <div class="limblk">
                	<h3> VINYL </h3>
                    <img src="<?php echo get_template_directory_uri() ;?>/images/lam-img.jpg" alt="carpet" class="img-responsive"/>
                    
                    <div class="limblkk">
                    <h4> CONSTRUCTION </h4>
                    <p>Scratch resistant </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> BENEFITS </h4>
                    <p>Create a premium look for less.  </p>
                    <p>Easy to install &amp; durable </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> PRICE </h4>
                    <p>$-$$ </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> RECOMMENDED FOR </h4>
                    <p>Kids &amp; Pets </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="shnow shnoww">
                    <a href="#"> SHOP NOW </a>
                    </div><div class="clearfix"></div>
                    
                </div>
                </div><!-- vynil end -->
                
                <div class="col-md-4">
                <div class="limblk">
                	<h3> TIMBER </h3>
                    <img src="<?php echo get_template_directory_uri() ;?>/images/lam-img.jpg" alt="carpet" class="img-responsive"/>
                    
                    <div class="limblkk">
                    <h4> CONSTRUCTION </h4>
                    <p>Scratch resistant </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> BENEFITS </h4>
                    <p>Create a premium look for less.  </p>
                    <p>Easy to install &amp; durable </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> PRICE </h4>
                    <p>$-$$ </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="sublim">
                    <h4> RECOMMENDED FOR </h4>
                    <p>Kids &amp; Pets </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="shnow shnoww">
                    <a href="#"> SHOP NOW </a>
                    </div><div class="clearfix"></div>
                    
                </div>
                </div><!-- timber end -->
                
            </div>
            
        </div><!-- rugs end --->

    </div>
                </div><div class="clearfix"></div>
                
            </div>
        </div></div>
    </div><div class="clearfix"></div><!-- right flooring tabs end -->
    
    <div class="crptslide">
    	<div class="container"><div class="row">
        	<div class="col-md-12">
            	<div class="ourslid">
                	<h4 class="csldt"> ROOM VISUALISER </h4>
                    
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="slide/carpetcall.jpg" alt="carpetcall">
    </div>
    <div class="item">
      <img src="slide/carpetcall1.jpg" alt="carpetcall">
    </div>
    <div class="item">
      <img src="slide/carpetcall2.jpg" alt="carpetcall">
    </div>
    <div class="item">
      <img src="slide/carpetcall3.jpg" alt="carpetcall">
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
                    
                </div>
            </div><div class="clearfix"></div><!-- slide end -->
            
            <div class="hwrk"><div class="container"><div class="row">
            	<div class="col-md-6">
                <h3 class="hiwk"> HOW IT WORKS </h3>
                <p class="wktxt"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.  </p>
                <p class="wktxt"> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.   </p>
                <p class="wktxt"> Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.   </p>
                </div><!-- working content end -->
                
                <div class="col-md-6">
                <div class="wpnt">
                	<div class="pont"> 
                    <span class="badge"> 1 </span> 
                    <h4 class="owkm owkmm"><a href="#"> Lorem ipsum dolor </a></h4>
                    <p class="itsdet"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus orciugue, vehicula a nisi sit amet.
licitudin suscipit ante. </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="pontt"> 
                    <span class="badge"> 2 </span> 
                    <h4 class="owkm owkmm"><a href="#"> Lorem ipsum dolor </a></h4>
                    <p class="itsdet"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus orciugue, vehicula a nisi sit amet.
licitudin suscipit ante. </p>
                    </div><div class="clearfix"></div>
                    
                     <div class="pontt"> 
                    <span class="badge"> 3 </span> 
                    <h4 class="owkm owkmm"><a href="#"> Lorem ipsum dolor </a></h4>
                    <p class="itsdet"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus orciugue, vehicula a nisi sit amet.
licitudin suscipit ante. </p>
                    </div><div class="clearfix"></div>
                    
                    <div class="strtblk strtblkk"><a href="#"> GET STARTED </a></div><div class="clearfix"></div>
                    
                </div>
                </div><!-- working list point end --->
                
                
                
            </div></div></div><div class="clearfix"></div><!-- how it work end -->
            
            
            
        </div></div>
    </div><div class="clearfix"></div><!-- slide part and content end -->
    
    <div class="mystor">
    	<div class="container"><div class="row">
        <h4 class="stor"> VISIT OUR STORES </h4>
        <div class="col-md-6">
        <div class="leftsec">
        <img src="<?php echo get_template_directory_uri() ;?>/images/support-a.jpg" alt="support" class="img-responsive"/>
        <h5 class="weher"> WE ARE HERE TO HELP </h5>
        <h6 class="onelin"> Our Flooring Specialists will help you : </h6>
        
        <ul>
        <li> - Make the right flooring choice </li>
        <li>- Book in your Measure &amp; Quote  </li>
        <li> - Manage your installation </li>
        <li> - Book a time to meet instore! </li>
        </ul><div class="clearfix"></div>
        
        <div class="mycnt mycntt"><a href="#"> CONTACT US </a></div>
        
        </div>
        </div><!-- one end -->
        
        <div class="col-md-6">
        <div class="leftsec">
        <img src="<?php echo get_template_directory_uri() ;?>/images/support-b.jpg" alt="support" class="img-responsive"/>
        <h5 class="weher"> VIST OUR INSTORE SHOWROOMS </h5>
        <h6 class="onelin"> Get a taste of what's possible with hundreds of options on display. </h6>
        
        <div class="findstr">
        	<h3 class="clostr">FIND YOUR CLOSEST STORE </h3>
            <div class="postcd">
            <form class="form-inline">
              <div class="form-group">
                <label class="sr-only" for="exampleInputCode">SUBURB OR POSTCODE</label>
                <input type="postcode" class="form-control" id="exampleInputCode" placeholder="SUBURB OR POSTCODE">
              </div>
              <button type="submit" class="btn btn-default">SEARCH</button>
            </form>
            </div><div class="clearfix"></div>
        </div><div class="clearfix"></div>
        
        </div>
        </div><!-- two end -->
        
        </div></div>
    </div><div class="clearfix"></div><!-- our store end -->
        
    <div class="expert">
    	<div class="container"><div class="row">
        <h4 class="mi_inst"> WE ARE THE EXPERT IN TRADE </h4>
        
        	<div class="col-md-6">
            <img src="<?php echo get_template_directory_uri() ;?>/images/trade-a.jpg" alt="trade" class="img-responsive"/>
            <h4 class="quote_a"><span class="fmm"> FREE </span> MEASURE AND QUOTE </h4>
            <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  </p>
            <p> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.  </p>
            
            <div class="mycnt mycntt"><a href="#"> CONTACT US </a></div>
            
            </div><!-- measure end -->
            
            <div class="col-md-6">
             <img src="<?php echo get_template_directory_uri() ;?>/images/trade-b.jpg" alt="trade" class="img-responsive"/>
            <h4 class="quote_a"> CARPETCALL INSTALLATION </h4>
            <p> Carpetcall offers flooring installation for our laminate, vinyl,
bamboo, cork, timber &amp; carpet products.  </p>
            <p> One of our Flooring Specialist can meet you in your home, where they can accurately measure and quote on your installation. </p>
            
            <div class="mycnt mycntt"><a href="#"> CONTACT US </a></div>
            </div><!-- installation end -->
            
        </div></div>
    </div><div class="clearfix"></div><!-- expert trade end -->
    
   <?php get_footer();?>
