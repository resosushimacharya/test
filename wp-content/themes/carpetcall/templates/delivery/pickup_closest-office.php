<div class="nearstore">
<div>
      <div>
        <h4 class="modal-title">PICK UP LOCATIONS</h4>
      </div>
      <div>
        	<h2 class="fyns-blk"> FIND YOUR NEAREST STORE </h2>
            
            <div class="frm-blk clearfix">
            		
                    
                    <div class="input-group">
                      <input type="text"  placeholder="SUBURB OR POSTCODE" id="edit_dialog_keyword" name="edit_dialog_keyword" type="text" class="form-control controls"  onkeyup="customDialog(event);">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button" id="checkout_fetch_nearby_stores"><img src="<?php echo get_template_directory_uri().'/images/icon2.jpg';?>" style="float:right; margin-top:-5px;"></button>
                      </span>
                    </div>
                         
                         <span class="midlt"> OR </span>
                         
                          <button type="button" class="btn btn-default" id="checkout_fetch_nearby_stores_currentloc" >USE CURRENT LOCATION</button>
                      
            </div>
            <!-- <div id="dialog_list_id_s"></div> -->
            
            <div class="nearstore" id="dialog_list_id_s"> 
            <div class="cc-pul-headoff">
            	<?php
				global $current_user;
				$country = get_user_meta($current_user->ID,'billing_country',true);
				$address_1 = get_user_meta($current_user->ID,'billing_address_1',true);
				$address_2 = get_user_meta($current_user->ID,'billing_address_2',true);
				$city = get_user_meta($current_user->ID,'billing_city',true);
				$postcode = get_user_meta($current_user->ID,'billing_postcode',true);
				
		
		$address = $country.'+'.$city.'+'.$address_1.'+'.$address_2.'+'.$postcode;
		
		
        $prepAddr = str_replace(' ','+',$address);
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
        $output= json_decode($geocode);
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;
		
		
		$nearby_stores_html = get_nearby_stores(array('latitude'=>$latitude,'longitude'=>$longitude));
	
	/*	$store_ids = array();
		foreach($nearby_stores as $store){
			$store_ids[] = $store['id'];
			}
              $args = array(
                'post_type' => 'wpsl_stores',
                'posts_per_page'=>-1,
                'post__in' => $store_ids,
              );
              $loop = new WP_Query($args);
              if($loop->have_posts()){
                while($loop->have_posts()){
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
       		<input type="radio" name="pickup_store_id" value="<?php echo get_the_ID()?>">
            <h3><?php the_title();?></h3>
            <p class="address"><?php echo  $add .' '. $city.' '.$state.' '.$zip;?></p>
       </div>
                <?php
                }
                 wp_reset_query();
                }
              
			  
			  */?>
                <div id="nearby_stores_main_wrapper">
                <?php echo $nearby_stores_html; ?>
                </div>
              </div> 
            </div><div class="clearfix"></div>
            
      </div>
      
    </div>
</div>