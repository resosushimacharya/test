<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">PICK UP LOCATIONS </h4>
      </div>
      <div class="modal-body">
        	
            
            
            
            	
               
            <?php // head office section start ?>
            <div class="nearstore">
                
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
    
    

        ?><div class="col-md-4 pul-sec-cc">
                    <div class="str-two">
                        <h4><?php echo $state; ?></h4>
                        <div class="cc-store-pul-block">
                        <p><?php echo get_the_title();?> Head Office  </p>
                        <p><?php echo  $add ; ?></p>
                        <p><?php echo  $city.' '.$state.' '.$zip;?></p>
                        </div>
                        <h5> <span class="pclt">P :</span> <?php echo $phone;?></h5>
                    </div><div class="clearfix"></div>
                    </div> <!-- store one end -->
      
    <?php endwhile;
    wp_reset_query(); ?>
      
        </div></div>
        <div class="clearfix"></div>
            <?php // head office section end ?>
      </div>
      
    </div>

  </div>
</div>
