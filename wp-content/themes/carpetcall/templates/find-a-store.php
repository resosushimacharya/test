<?php
/* 
** Template Name: Store Main page
*/
?>
<?php get_header();?>

<div class="cc-store-hd-title">
	<div class="container">
    <div class="cc-bread-crumb-str">
                      <span>CARPET CALL STORES</span>
                  </div>
                  <div class="cc-finder-title">
                      <h3>STORE FINDER</h3>
                  </div>
                  <div class="cc-options-wrapper-nh">
                      <form method="post" >
                          <input type="hidden" name="check-near-id" value="check near value"/>
                          <input type="submit" id="cc-but-near" class="cc-but-near-con" value="FIND YOUR NEAREST STORE" name="cc-but-near-name"/>
                      </form >
                      <form method="post">
                          <input type="hidden" name="check-head-id" value="check head value"/>
                          <input type="submit" id="cc-but-head" class="cc-but-head-con" value="HEAD OFFICES" name="cc-but-head-name"/>
                      </form>
                  </div>
    </div>
</div><div class="clearfix"></div><!-- upper section end here ---------------->

<div class="cc-store-bdy-contr">
	<div class="container">
    
                  <?php  
                
                    echo  do_shortcode('[wpsl template="custom" ]');
            
                    ?>

                  <?php if(!isset($_POST["cc-current-location-store"]) && !isset($_POST["wpsl-search-input"])){
                                  if(isset($_POST["check-near-id"])){?>
                     

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
                              endforeach; ?>
                        </div>

                    <?php    }
                        elseif(isset($_POST["check-head-id"])){?>
                       <div id="Map" style="width: 100%; height: 450px;"></div>
                      
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
        <div class="cc-head-office-wrap">
        <div class="cc-head-office-secn"> <ul class="cc-head-office-list">

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
         <div class="cc-head-office-list-item">

            <p><div class="cc-head-office-label">
                <span class="cc-store-icon-label">
                    <img src="http://localhost/carpetcall/wp-content/themes/carpetcall/images/blue.png">
                    <strong>
                    <a href="http://localhost/carpetcall/find-a-store/wa//midland/"><?php echo get_the_title();?></a>
                    </strong>
                </span>
                </div>
            </p>
            <div class="clearfix"></div>
            <span class="wpsl-hf-street"><?php echo get_post_meta($post->ID,'wpsl_address',true );?></span>
                
            <span class="wpsl-hf-street-a"><?php echo get_post_meta($post->ID,'wpsl_zip',true ).' '.get_post_meta($post->ID,'wpsl_city',true ).' '.get_post_meta($post->ID,'wpsl_state',true );?></span>
            <span class="wpsl-hf-country"><?php echo get_post_meta($post->ID,'wpsl_country',true );?></span>
            <span class="wpsl-hf-street-b"><strong>P: </strong> <?php echo get_post_meta($post->ID,'wpsl_phone',true );?></span>
            <span class="wpsl-hf-street-c"><strong>F: </strong> <?php echo get_post_meta($post->ID,'wpsl_fax',true );?></span>
                
                
            <div class="hf-fcnt-or hf-fcnt-orr clearfix">
                <a href="<?php echo get_the_permalink();?>">View Store Page</a>
            </div>
            <div class="hfc-fcnt-or hfc-fcnt-orr hfc-fcnt-orr-map clearfix">
                <a href="http://localhost/carpetcall/contact-us/?id=<?php echo $post->ID ; ?>" class="cc-contact-link  ">Contact Store</a>
            </div>         
        </div>
       
        </li>
    <?php endwhile;
    wp_reset_query(); ?>
        </ul>
        </div></div>
               <?php } 
                    
                      else {?>
                       
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
                              endforeach; ?>
                        </div>
                      <?php }
                    }
                      ?>
    </div>
</div><div class="clearfix"></div><!-- main conternt end here -->




<?php get_footer(); ?>



                         <?php 
                            if(!isset($_POST["cc-current-location-store"]) && !isset($_POST["wpsl-search-input"])){
                                  if(isset($_POST["check-near-id"])){
                                           get_template_part('content','main-store-map');
                                  }
                                  elseif(isset($_POST["check-head-id"])){
                                    
                                    
                                      get_template_part('content','auxuliary');
                                  }
                                 
                                  else{
                                    get_template_part('content','main-store-map');
                                  }
   
                             }
     
?>
