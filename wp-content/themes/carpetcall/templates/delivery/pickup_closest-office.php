<div class="nearstore">
<div>
      <div>
        <h4 class="modal-title">PICK UP LOCATIONS</h4>
      </div>
      <div>
     
<?php /*?>     
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
           
<?php */?>           
           
            <!-- <div id="dialog_list_id_s"></div> -->
            
            <div class="nearstore" id="dialog_list_id_s"> 
            <div class="cc-pul-headoff">
            	<?php
				global $current_user;
				if(is_user_logged_in()){
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
					}else{
					$nearby_stores_html = get_nearby_stores(array('address'=>'Sydney Australia'));
					}
		
	
	?>
                <div id="nearby_stores_main_wrapper">
                <?php echo $nearby_stores_html; ?>
                </div>
              </div> 
            </div><div class="clearfix"></div>
            
      </div>
      
    </div>
</div>