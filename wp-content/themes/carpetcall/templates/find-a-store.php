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
                  if(isset($_POST['wpsl-search-input'])){
                    echo  do_shortcode('[wpsl template="custom" start_location="'.$_POST['wpsl-search-input'].'"]');
                  }
                  else{
                   echo  do_shortcode('[wpsl template="custom"]');
                  }
            
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
        <div class="cc-head-office-secn"> <ul class="cc-head-office-list ">

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
                  $phoneCon = false; // void condition '
                  $faxCon = false; // void condition 
                  if(array_key_exists('wpsl_phone',$getinfo)){
                  $phone = $getinfo['wpsl_phone'][0];
                  if($phone == ''){
                    $phoneCon = false;
                    break;
                  }
                  else{
                    $phoneCon = true;

                  }
                  $x=  $phone;
                  $x = preg_replace('/\s+/', '', $x);
                  $x = '+61'.$x;  
                  $phone = '<a class="phone" href="tel:'.$x.'">'.$phone.' </a>';
                  
                  }
                  if(array_key_exists('wpsl_fax',$getinfo)){
                  $fax = $getinfo['wpsl_fax'][0];
                  if($fax == ''){
                    $faxCon = false;
                    break;
                  }
                  else{
                    $faxCon = true;
                  }
                  
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
               <?php if ( $zip == '' ) { ?>
            <span class="wpsl-hf-street-a"><?php echo $city.' '.$state.' '.$zip;?></span>
            <?php } else { ?>
            <span class="wpsl-hf-street-a"><?php echo $city.', '.$state.' '.$zip;?></span>
            <?php } ?>
            
            </div>
            <div class="cc-phone-fax-wrapper">
                <?php if ( $phoneCon ) { ?>
                <span class="wpsl-hf-street-b"><strong>P: </strong><?php echo  $phone ;?></span>
                <?php } ?>
                <?php if ( $faxCon ) { ?>
                <span class="wpsl-hf-street-c"><strong>F: </strong> <?php echo $fax;?></span>
                <?php } ?>
            </div>

              
               
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
                          <form id="category-form-submit" method="post" action="<?php echo site_url(); ?>/find-a-store/" name="category-form-submit">
                            <input type="hidden" id="cc-wpsl-search-input-lat" name="wpsl-search-input">
                          </form>

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
                             
                              echo '<div class="cc-state-link"><a data-cat_name="'.strtolower($term->name).'" class="cc-cat-lat-submit" >'.$regions[$term->name].'</a></div>';
                              endforeach; ?>
                        </div>
                      <?php }
                    }
                      ?>
    </div>

    <script>
    jQuery(document).on('click','.cc-cat-lat-submit',function(e){
      e.preventDefault();
      var url="<?php echo site_url('/find-a-store/'); ?>";
      var append_cat=jQuery(this).data('cat_name');
      var new_url=url+append_cat;
      jQuery('#cc-wpsl-search-input-lat').val(append_cat);
      jQuery('#category-form-submit').attr('action',new_url)
      jQuery('form#category-form-submit').submit();
    })
    </script>
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
<script type="text/javascript">
jQuery( document ).ajaxComplete(function( event, xhr, settings ) {
  if(settings.url.indexOf('action=store_search') !== -1){
    if(typeof xhr.responseJSON!=="undefined"){
 
      jQuery('.cc-finder-title h3').html(jQuery('#wpsl-search-input').val());
 
  }

  }
});
</script>