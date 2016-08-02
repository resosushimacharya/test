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
                          
                      <?php  echo "hellos"; } 
                    
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
</div><div class="clearfix"></div><!-- main conternt end here ------------->




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
