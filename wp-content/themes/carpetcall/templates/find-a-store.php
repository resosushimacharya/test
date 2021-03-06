<?php
/* 
** Template Name: Store Main page
*/
?>
<?php 
  get_header();

  //head-selected
  $nearest = true;


  if(isset($_POST["check-head-id"])) $nearest = false;

?>

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
                      <div class="cc-find-store-au <?php if($nearest) echo ' store-finder-active-tab'; ?>">
                          <input type="hidden" name="check-near-id" value="check near value"/>
                          <input type="submit" id="cc-but-near" class="cc-but-near-con" value="FIND YOUR NEAREST STORE" name="cc-but-near-name"/>
                          </div>
                      </form >
                      <form method="post">
                      <div class="cc-find-store-au hf <?php if(!$nearest) echo ' store-finder-active-tab'; ?>">
                          <input type="hidden" name="check-head-id" value="check head value"/>
                          <input type="submit" id="cc-but-head" class="cc-but-head-con" value="HEAD OFFICES" name="cc-but-head-name"/>
                          </div>
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
                'orderby' => 'title',
                 'order' => 'ASC',
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
                 
                  $phone = '-';
                  $fax = '-';
                  $zip ='';
                  $state = '';
                  $city = '';
                  $direction = '';
                  $country  = '';
                  if(array_key_exists('wpsl_phone',$getinfo)){
                  $phone = $getinfo['wpsl_phone'][0];
                  $x=  $phone;
                  $x = preg_replace('/\s+/', '', $x);
                  $x = '+61'.$x;  
                  $phone = '<a class="phone" href="tel:'.$x.'">'.$phone.' </a>';
                  }
                  if(array_key_exists('wpsl_fax',$getinfo)){
                  $fax = $getinfo['wpsl_fax'][0];
                  }
                  if(array_key_exists('wpsl_city',$getinfo)){
                  $city  = $getinfo['wpsl_city'][0];
                  }
                  if(array_key_exists('wpsl_state',$getinfo)){
                  $state = $getinfo['wpsl_state'][0];
                  }
                  if(array_key_exists('wpsl_zip',$getinfo)){
                  $zip = $getinfo['wpsl_zip'][0];
                  }  
                 if(array_key_exists('wpsl_zip',$getinfo)){
                  $country = $getinfo['wpsl_country'][0];
                 } 
    

        ?>
       
        <li class="col-md-4 cc-map-list-control" id="cc_list_<?php echo $loop->post->ID ;?>">
         <div class="cc-head-office-list-item">

            <p><div class="cc-head-office-label">
                <span class="cc-store-icon-label">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/markers/location.png">
                    <strong>
                    <a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a>
                    </strong>
                </span>
                </div>
            </p>
            <div class="clearfix"></div>
            <div class="cc-store-map-last-cover clearfix"><span class="wpsl-hf-street"><?php echo get_post_meta($post->ID,'wpsl_address',true );?></span>
                
            <span class="wpsl-hf-street-a"><?php echo $zip.' '.$city.' '.$state;?></span>
            <span class="wpsl-hf-country"><?php echo $country;?></span>
            </div>
            <span class="wpsl-hf-street-b"><strong>P: </strong><?php echo  $phone ;?></span>
            <span class="wpsl-hf-street-c"><strong>F: </strong> <?php echo $fax;?></span>
                

            <div class="hfc-fcnt-or hfc-fcnt-orr hfc-fcnt-orr-map clearfix">
                <a href="<?php echo site_url();?>/contact-us/?id=<?php echo $post->ID ; ?>" class="cc-contact-link  ">Contact Store</a>
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
</div><div class="clearfix"></div><!-- main content end here -->

<?php get_footer(); ?>

<?php 
                            if(!isset($_POST["cc-current-location-store"]) && !isset($_POST["wpsl-search-input"])){
                                  if(isset($_POST["check-near-id"])){

                                           get_template_part('templates/contents/content','main-store-map');

                                  }

                                  elseif(isset($_POST["check-head-id"])){
                                    
                                    
                                      get_template_part('templates/contents/content','auxuliary');
                                  }
                                 
                                  else{

                                    get_template_part('templates/contents/content','main-store-map');

                                  }
   
                             }
     
?>