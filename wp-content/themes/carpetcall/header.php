<?php
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta content="chj">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Cache-Control" content="no-store" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php /* if(is_singular('product')){

	
                                    $categories = get_the_terms(get_the_ID(), 'product_cat' ); 
                                    if ( $categories ){
                                        foreach($categories as $category) {
                                          $children = get_categories( array ('taxonomy' => 'product_cat', 'hide_empty'=>true, 'parent' => $category->term_id ));
                                          if ( count($children) == 0 ) {?>
											  <link rel="canonical" href="<?php echo get_term_link($category->term_id,"product_cat")?>">
											  
											 <?php }

                                        endforeach;
                                    endif;
	
	} */?> 



<link rel="shortcut icon" href="<?php
echo get_template_directory_uri();
?>/images/favicon.ico"/>


<title><?php
wp_title("");
?>
</title>
<?php 

 if(is_single() && get_post_type()=='product'){
    global $post;
   
    
    $image =  wp_get_attachment_url(get_post_thumbnail_id($post->ID));
   
    ?>
    




 
<meta property="fb:app_id" content="312823042383349"/>
<meta property="og:description" content="<?php echo get_the_excerpt();?>"/>

<meta property="og:title" content="<?php echo get_the_title(); ?>"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="<?php echo get_the_permalink();?>"/>
<meta property="og:image" content="<?php echo  $image; ?>"/>
<meta property="og:site_name" content="carpetcall"/>
<meta property="fb:admins" content="hansu.shrestha.9"/>



<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@psprakash045">
<meta name="twitter:title" content="<?php echo get_the_title(); ?>">
<meta name="twitter:description" content="<?php echo get_the_excerpt();?>">
<meta name="twitter:image" content="<?php echo  $image; ?>">

<meta name="description" content="<?php echo get_the_excerpt();?>">
 <link rel="image_src" href="<?php echo  $image; ?>" /> 
                <?php }
                ?>

<?php

 if(isset($_SESSION['testing'] ) && (time() - $_SESSION['testing'] > 3000)){
     $_SESSION['use_curr_loc']="0";unset($_SESSION['cc_loc_name']);
  }
?>

<!-- Bootstrap -->


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    

<!-- custom css -->
<?php if(get_post_type()!='wpsl_stores' &&  !is_page_template('templates/find-a-store.php')){
?><script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCN3lkABBKjsMdIzAyI1Rwy_6Z8cT8IEWc&libraries=places"></script>
<?php } ?>
    <script type="text/javascript">
 
      var lat;
     var long;
     rs = [];
     var map = null;
     var currentplace;


     function showlocation() {
         navigator.geolocation.getCurrentPosition(callback, errorHandler);
     }
     function showlocationdialog(){
        navigator.geolocation.getCurrentPosition(dialogcallback, errorHandler);
     }
      function showcurrentlocation(){
          navigator.geolocation.getCurrentPosition(locationcallback, errorHandler);
      }
     function errorHandler(error) {
         switch (error.code) {
             case error.PERMISSION_DENIED:
                 alert("User denied the request for Geolocation.");
                 break;
             case error.POSITION_UNAVAILABLE:
                 alert("Location information is unavailable.");
                 break;
             case error.TIMEOUT:
                 alert("The request to get user location timed out.");
                 break;
             case error.UNKNOWN_ERROR:
                 alert("An unknown error occurred.");
                 break;
         }
     }

     function callback(position) {

         lat = position.coords.latitude;
         lon = position.coords.longitude;
         rs = [lat, lon];
       autocomplet();
		codeLatLng_header(lat, lon);

     }
	 function codeLatLng_header(lat, lng) {

    var latlng = new google.maps.LatLng(lat, lng);

			if(typeof geocoder=="undefined"){
				var geocoder= new google.maps.Geocoder();
			}
			geocoder.geocode({'latLng': latlng}, function(results, status) {
			  if (status == google.maps.GeocoderStatus.OK) {
				if (results[1]) {
				 //formatted address
				currentplace =   results[0].formatted_address;
				if(jQuery('#user_curr_loc_hide__').length>0){
				   jQuery('#user_curr_loc_hide__').val(currentplace);
				}
				} else {
				  alert("No results found");
				}
			  } else {
				alert("Geocoder failed due to: " + status);
			  }
			});
  }
  function formStoreFinder_submit(){
    jQuery('#cc_cuurent_location_name1').val(jQuery('#user_curr_loc_hide__').val());
    document.formStoreFinder.submit();
  }
	 
	 
function codeLatLng(lat, lng) {

    var latlng = new google.maps.LatLng(lat, lng);

    if(typeof geocoder=="undefined"){
        var geocoder= new google.maps.Geocoder();
    }
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
      console.log(results)
        if (results[1]) {
         //formatted address
        currentplace =   results[0].formatted_address;
       	console.log(currentplace);
			console.log(jQuery('#cc_cuurent_location_name').length);
		if(jQuery('#cc_cuurent_location_name').length>0){
		   jQuery('#cc_cuurent_location_name').val(currentplace);
		}
		if(jQuery('form[name=locform]').length>0){
		 document.locform.submit();
		}


        } else {
          alert("No results found");
        }
      } else {
        alert("Geocoder failed due to: " + status);
      }
    });
  }
     function dialogcallback(position) {

         lat = position.coords.latitude;
         lon = position.coords.longitude;
         rs = [lat, lon];
       


     autocomplet_dialog();
     }
      function locationcallback(position) {

         lat = position.coords.latitude;
         lon = position.coords.longitude;
         rs = [lat, lon];
   
       codeLatLng(lat, lon) ;

         //document.getElementById("cc-map-control-finder").submit();
      
         //autocomplet_location();
     }
     function xyz(){
        alert("hello");
     }
       </script>

<script type="text/javascript">
    var site_url="<?php echo site_url();?>";
    var latlang_string="";

</script>





<?php wp_head();?>
</head>
<body <?php body_class(); ?> >

<?php
if(get_post_type() == 'product'){?>
    <div id="loading_overlay_div"></div>
<?php } ?>

<div class="container-fluid wrapper clearfix">
    <div class="container-fluid banner clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4 no-lr cc-logo-cntr">
                        <div class="logo">
                            <a href="<?php echo site_url(); ?>"> 
                                <img src="<?php echo get_theme_mod('carpet-logo'); ?>" alt="carpetcall" class="img-responsive"/> 
                            </a>
                        </div>
                    </div><!-- logo end -->

                    <div class="top-mobile-icons mobile">
                        <div class="top-map-icon">
                            
                        </div><!-- store finder end -->
                        <div class="top-cart-icon">
                             
                        </div><!-- my cart end -->
                    </div>

                    <div class="col-md-4 header-search-cntr">
                        <div class="searchm">
                            <?php get_search_form(); ?>
                        </div>
                    </div><!-- search end -->

                    <div class="col-md-4 no-lr call-info-cntr">
                        <div class="callinfo">
                            <?php $x=  get_field('telephone', '89',false);
                            $x = preg_replace('/\s+/', '', $x);
                            $x = preg_replace( '/^[0]{1}/', '', $x );
                            $i = 1;
                            $x = '+61'.$x;   ?>
                            <h2 class="calme callmea">
                                <a href="tel:<?php
                                echo $x; ?>"><?php
                                echo __( 'CALL ', 'carpetcall' ) . get_field('telephone', '89',false);

                                ?> </a>
                            </h2>
                            <h3 class="subcl"><?php echo get_field('contact_label', '89',false); ?></h3>
                            <div class="contblk">
                                    <a href="<?php echo get_field('contact_url', '89'); ?>">
                                    <?php echo get_field('contact_link_title', '89',false); ?>                                    
                                </a>
                            </div>
                        </div>
                    </div><!-- call info end -->

                </div>

                <div class="clearfix"></div><!-- header section end here ---->

                <div class="navsrchblk clearfix">
                    <div class="col-md-12">
                        <div class="col-md-7 no-lr">
                            <?php
                                $defaults = array(
                                    'theme_location' => 'header-menu',
                                    'menu' => 'carpet_front',
                                    'container' => 'div',
                                    'container_class' => '',
                                    'container_id' => 'cssmenu',
                                    'menu_class' => '',
                                    'menu_id' => '',
                                    'echo' => true,
                                    'fallback_cb' => '',
                                    'link_before' => '',
                                    'link_after' => '',
                                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                    'depth' => 0,
                                    'walker' => new JC_Walker_Nav_Menu()
                                );
                                wp_nav_menu($defaults);
                            ?>
                        </div><!-- menu end -->
                        <!-- store finder begin -->
                        <div class="col-md-3 no-lr top-map-icon">
                            <div class="sfind">
                                <?php get_template_part('templates/contents/content', 'store');  ?>
                            </div>
                        </div><!-- store finder end -->
                        <div class="col-md-2 no-lr top-cart-icon">
                           <?php get_template_part('templates/contents/content', 'navwoo'); ?>
                        </div><!-- my cart end -->
                    </div>
                </div>
            </div>
            <div class="clearfix"></div><!-- navi section end here -->
        </div>
    </div>
</div>
<div class="clearfix"></div><!-- banner end -->

<input type="hidden" id="user_curr_loc_hide__">
<input type="hidden" id="current_page_id" value="<?php echo get_the_ID()?>">

<div class="wrap_body">

<script type="text/javascript">

    function load_minicart() {
        jQuery('#cc-mini-cart-cntr').html('<li class="cc-loader-cntr"><i class="fa fa-spinner  fa-spin" aria-hidden="true"></i></li>');
        jQuery.ajax({
            type: 'POST',
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {
                keyword: '123',
                action: 'woocommerce_cc',
            },
            dataType:"json",
            success: function(data) {
                // jQuery('#woo_control').html(data);
                jQuery('#count').html(data.count);
                jQuery('#counttest').html(data.count);
                jQuery('#cc-mini-cart-cntr').html(data.ul_html);
                ajax_count++;
            }
        });
    }

    jQuery(document).ready(function() {
        jQuery("#mywoosection").click(function(e) {
            load_minicart();
            jQuery('#after_dropdown').hide();
            $('.storefinder_cntr').removeClass('click-open');
            jQuery('#woo_control').show();
        });
    });

    var ajax_count = 0;
    jQuery(document).on('click', '.ajax_add_to_cart', function() {
        ajax_count = 1;
    });

    jQuery(document).ajaxSuccess(function() {
        if (ajax_count == 1) {
            load_minicart();
        }
    });

</script>