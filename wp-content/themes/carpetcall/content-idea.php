<?php

 ?><div class="container">
					<div class="row">
					<div class="col-md-12">
					<ul>

					</ul>
					</div></div></div>



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
            <?php
                            $tax = 'guide'; 
						$tax_terms = get_terms($tax);
						
						foreach($tax_terms as $tax_term)
						{
						echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="'.get_term_link($tax_term).'">'.$tax_term->name.'</li></a>';
						}

				?>
            </ul><div class="clearfix"></div>
            
            </div><!-- end here --><!-- testing phase end -->
            
            </div><div class="clearfix"></div><!-- guide end here -->
            
            
            </div><!-- idea left side end here -->
            
            <div class="col-md-6">
            
            <div class="care_pro" style="background:url(<?php echo get_template_directory_uri().'/images/care.png';?>); float:right; background-color:#0a71cf;">
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
            
					<?php
                            $tax = 'faq'; 
						$tax_terms = get_terms($tax);
						
						foreach($tax_terms as $tax_term)
						{
						echo '<li><i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;<a href="'.get_term_link($tax_term).'">'.$tax_term->name.'</li></a>';
						}

				?>
            </ul><div class="clearfix"></div>
                
            </div>
            
            </div><div class="clearfix"></div><!-- faq end here -->
            
            
            </div><div class="clearfix"></div><!-- idea right side end here -->
        </div><div class="clearfix"></div>
        
        
        
        </div><div class="clearfix"></div>
       </div><div class="clearfix"></div>