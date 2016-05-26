<?php ?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta content="chj">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Cache-Control" content="no-store" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php bloginfo('title');?>|<?php echo bloginfo('description');?></title>
<meta http-equiv="Cache-Control" content="no-cache"/>


<?php wp_head();?>

<!-- Bootstrap -->


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<!-- custom css -->
<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?sensor=false">
    </script>
    <script type="text/javascript">
      var lat ;
      var long;
      var rs =[];
        var map = null;
            function showlocation() {
               // One-shot position request.
                 navigator.geolocation.getCurrentPosition(callback, errorHandler);
                  setTimeout(function(){ autocomplet(); }, 2000);
                 
            }

//..
 
function errorHandler(error) {
  switch(error.code) {
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
        rs=[lat,lon];
        console.log(rs);
        alert(rs);
         
             document.getElementById('latitude').innerHTML = lat;
         document.getElementById('longitude').innerHTML = lon;
             
        var latLong = new google.maps.LatLng(lat, lon);
         
                var marker = new google.maps.Marker({
                    position: latLong
                });      
                 
                marker.setMap(map);
        map.setZoom(8);
        map.setCenter(marker.getPosition());
      }
       
      google.maps.event.addDomListener(window, 'load', initMap);
      function initMap() {
        var mapOptions = {
          center: new google.maps.LatLng(0, 0),
          zoom: 1,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map-canvas"), 
                                          mapOptions);
       
      }
    </script>


<!-- js -->



</head>

<body <?php body_class();?> >

<div class="container-fluid wrapper clearfix">
 	
    <div class="container-fluid banner clearfix">
    	<div class="container"><div class="row">
        	<div class="col-md-12">
            	<div class="col-md-4 no-lr"><div class="logo"><a href="<?php echo site_url(); ?>"> <img src="<?php echo get_theme_mod('carpet-logo');?>" alt="carpetcall" class="img-responsive"/> </a></div></div><!-- logo end -->
                <div class="col-md-4">
                <div class="searchm">
                <?php get_search_form ( );
    ?>
        </div>
                </div><!-- search end -->
                
                <div class="col-md-4 no-lr">
                <div class="callinfo">
                	<h2 class="calme callmea"><a href="tel:1300 502 427"> CALL 1300 502 427 </a></h2>
                    <h3 class="subcl">OR BOOK A CALL BACK WITH</br>
						OUR FLOORING SPECIALISTS </h3>
                     <div class="contblk"><a href="<?php echo get_permalink(89);?>">  CONTACT US </a></div>
                </div>
                </div><!-- call info end -->
                
            </div><div class="clearfix"></div><!-- header section end here ---->
           
 
            <div class="navsrchblk clearfix">
            <div class="col-md-12">
            	<div class="col-md-7 no-lr">
                <?php $defaults = array(

	'theme_location'  => 'header-menu',

	'menu'            => 'carpet_front',

	'container'       => 'div',

	'container_class' => '',

	'container_id'    => 'cssmenu',

	'menu_class'      => '',

	'menu_id'         => '',

	'echo'            => true,

	'fallback_cb'     => '',

	'link_before'     => '',

	'link_after'      => '',

	'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',

	'depth'           => 0,

	'walker'          => new JC_Walker_Nav_Menu()



);
wp_nav_menu($defaults);?>




                </div><!-- menu end -->
                <!-- store finder begin -->
                <div class="col-md-3 no-lr">
                <div class="sfind">
                  <?php get_template_part('content','store');?>
                
                </div>
                </div><!-- store finder end -->
                <div class="col-md-2 no-lr">
                
                 <?php get_template_part('content','navwoo');?>
               
                
                
                </div><!-- my cart end -->
                
                </div>
                
                
                </div></div><div class="clearfix"></div><!-- navi section end here ----------->
            
            
        </div></div>
    </div><div class="clearfix"></div><!-- banner end -->

    <script type="text/javascript">

    function load_minicart(){
jQuery.ajax({
      // url: wp_ccwoocommerce_autocomplete.ajax_url,
      type: 'POST',
      url: "<?php echo admin_url('admin-ajax.php'); ?>",
      data: {
        keyword:'123',
        action: 'woocommerce_cc',
        
      },
      success:function(data){       
        
       jQuery('#woo_control').html(data);
        ajax_count++;
      }
    });


    }

        jQuery(document).ready(function(){
    
    jQuery("#mywoosection").click(function(e){
load_minicart();
jQuery('#woo_control').show();
    
});
  });
        var ajax_count=0;
 jQuery(document).on('click', '.ajax_add_to_cart', function() {
 // alert('User clicked on "foo."');
  ajax_count=1;
});

        jQuery(document).ajaxSuccess(function() {
         //alert(ajax_count);
          if(ajax_count==1){
             load_minicart();
          }
         
 
});

    </script>