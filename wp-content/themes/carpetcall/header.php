<?php
?><!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta charset="utf-8">
<meta content="chj">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Cache-Control" content="no-store" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php
echo get_template_directory_uri();
?>/images/favicon.ico"/>
<title><?php
wp_title("");?>



</title>
<?php if(is_single() && get_post_type()=='product'){
    global $post;
   
  
    $image =  wp_get_attachment_url(get_post_thumbnail_id($post->ID));
   
    ?>
<meta http-equiv="Cache-Control" content="no-cache"/>
<!-- facebook share   -->
<meta name="twitter:card" content="summary_large_image">
                <!-- <meta name="twitter:title" content="<?php //echo get_the_title(); ?>"> -->
<meta name="twitter:description" content="<?php echo get_the_title(); ?>">
<meta name="twitter:image" content="<?php echo  $image; ?>">             
<meta name="twitter:site" content="@carpetcall" />
<meta name="twitter:creator" content="@carpetcall">

<meta property="og:url" content="<?php echo get_permalink(); ?>" />
<meta property="og:site_name" content="Carpetcall" />
<meta property="og:title" content="<?php echo get_the_title(); ?> " />

<meta property="fb:app_id" content="312823042383349" />

<meta property="og:type" content="article" />
<meta itemprop="og:headline" content="<?php echo get_the_title(); ?> " />
<meta itemprop="og:description" content="<?php echo get_the_title(); ?>" />

<meta property="og:description" content="<?php echo get_the_title(); ?>" />

<meta property="og:image" content="<?php echo  $image; ?>" />
<link rel="image_src" href="<?php echo  $image; ?>"/>

<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
                <?php }
                ?>

<?php


wp_head();
 if(isset($_SESSION['testing'] ) && (time() - $_SESSION['testing'] > 30)){
     $_SESSION['use_curr_loc']="0";
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
<?php if(is_home() || (is_single() && get_post_type()=='product'))
{?><script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCN3lkABBKjsMdIzAyI1Rwy_6Z8cT8IEWc&libraries=places"></script>
<?php  } ?>
    <script type="text/javascript">
 
      var lat;
     var long;
     rs = [];
     var map = null;

     function showlocation() {


         navigator.geolocation.getCurrentPosition(callback, errorHandler);


     }
     function showlocationdialog(){
        navigator.geolocation.getCurrentPosition(dialogcallback, errorHandler);
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
     }

     function dialogcallback(position) {

         lat = position.coords.latitude;
         lon = position.coords.longitude;
         rs = [lat, lon];
       


     autocomplet_dialog();
     }
       </script>

<script type="text/javascript">
    var site_url="<?php echo site_url();?>";
    var latlang_string="";

</script>




</head>
<body <?php
body_class();
?> >
<div id="loading_overlay_div"></div>
<div class="container-fluid wrapper clearfix">
  
    <div class="container-fluid banner clearfix">
      <div class="container"><div class="row">
          <div class="col-md-12">
              <div class="col-md-4 no-lr"><div class="logo"><a href="<?php
echo site_url();
?>"> <img src="<?php
echo get_theme_mod('carpet-logo');
?>" alt="carpetcall" class="img-responsive"/> </a></div></div><!-- logo end -->
                <div class="col-md-4">
                <div class="searchm">
                <?php
get_search_form();
?>
        </div>
                </div><!-- search end -->
                
                <div class="col-md-4 no-lr">
                <div class="callinfo">
                  <h2 class="calme callmea"><a href="tel:<?php
                        echo get_field('telephone_link', '89',false);
                                ?>"><?php
echo get_field('telephone', '89',false);
?> </a></h2>
                    <h3 class="subcl"><?php
echo get_field('contact_label', '89',false);
?>"</h3>
                     <div class="contblk"><a href="<?php
echo get_field('contact_url', '89');
?>">
                     <?php
echo get_field('contact_link_title', '89',false);
?></a></div>
                </div>
                </div><!-- call info end -->
                
            </div><div class="clearfix"></div><!-- header section end here ---->
           
 
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
                <div class="col-md-3 no-lr">
                <div class="sfind">

                  <?php
                  
get_template_part('content', 'store');
?>
                
                </div>
                </div><!-- store finder end -->
                <div class="col-md-2 no-lr">
                
                 <?php
get_template_part('content', 'navwoo');
?>
               
                
                
                </div><!-- my cart end -->
                
                </div>
                
                
                </div></div><div class="clearfix"></div><!-- navi section end here -->
            
            
        </div></div>
    </div><div class="clearfix"></div><!-- banner end -->




    <script type="text/javascript">

     function load_minicart() {
        jQuery.ajax({
            type: 'POST',
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {

                keyword: '123',
                action: 'woocommerce_cc',

            },
            success: function(data) {

                jQuery('#woo_control').html(data);
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