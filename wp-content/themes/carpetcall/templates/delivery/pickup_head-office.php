<div class="nearstore">
   <h2> Select Your Pickup Location (Head Offices)</h2>             
                <div class="cc-pul-headoff">
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
                        
                         if(array_key_exists('wpsl_address',$getinfo)){
                          $add= $getinfo['wpsl_address'][0];
                         } 

                ?>
                
               <div class="pickup_location_list">
               		
                    <?php
                				woocommerce_form_field("pickup_store_id", array(
                											'type'              => 'radio',
                											'required'			=> true,
                											'options'           => array( 'get_the_ID()' => '<h3>'.the_title().'</h3>
                            <p class="address">'.$add .' '. $city.' '.$state.' '.$zip.'</p>' ),
                										), '' );
                			?>           
               </div>
        
         <!-- store one end -->
      
    <?php endwhile;
    wp_reset_query(); ?>
      
        </div>
</div>