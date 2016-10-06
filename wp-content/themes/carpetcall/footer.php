<div class="mobile cc_to_top_cntr cearfix">
  <div class="to_top_btn">
    <i class="fa fa-angle-up"></i>
  </div>
</div>

<div class="footer_c">
    <div class="container">
        <div class="row">
            <div class="col-md-8 idea-left">
                <div class="fot_logo">
                    <img src="<?php echo get_template_directory_uri() ;?>/images/carpetcall-logo.png" alt="logo" class="img-responsive"/>
                </div>

                <div class="subcat footer_nav_desktop">
                    <!--my style ---->
                    <!--- -->
                    <?php    /**
                    * Displays a navigation menu
                    * @param array $args Arguments
                    */
                    $args = array(
                    'theme_location'  => 'footer-menu',
                    'menu'            => 'footlist',
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'footlist',
                    'menu_id'         => '',
                    'echo'            => true,
                    'fallback_cb'     => '',

                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth'           => 2,
                    'walker'          => new JC_Footer_Nav_Menu()
                    );
                    wp_nav_menu($args);?>

                    <div class="clearfix"></div>
                </div>

                <div class="subcat footer_nav_mobile">
                    <!--my style ---->
                    <!--- -->
                    <?php    /**
                    * Displays a navigation menu
                    * @param array $args Arguments
                    */
                    $args = array(
                    'theme_location'  => 'footer-mobile-menu',
                    'menu'            => 'foot_mob',
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'foot_mob',
                    'menu_id'         => '',
                    'echo'            => true,
                    'fallback_cb'     => '',

                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth'           => 2,
                    'walker'          => new JC_Footer_Nav_Menu()
                    );
                    wp_nav_menu($args);?>

                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div><!-- sub category listing end -->
                
                <div class="social">
                    <ul>
                        <li> <span class="gtku">GET TO KNOW US</span>  </li>
                   
                        <?php
                       /* if(get_theme_mod('carpet-social-facebook')){ echo '<li><a href="'.get_theme_mod('carpet-social-facebook').'"
                         target="_blank"
                        ><i class="fa fa-facebook-square" aria-hidden="true"></i> </a></li>';
                    }
                       if(get_theme_mod('carpet-social-youtube')){ echo '<li><a href="'.get_theme_mod('carpet-social-youtube').'"
                         target="_blank"
                        ><i class="fa fa-youtube-play" aria-hidden="true"></i> </a></li>';
                    }if(get_theme_mod('carpet-social-pininterest')){
                        echo '<li><a href="'.get_theme_mod('carpet-social-pininterest').'"
                        target="_blank"
                        > <i class="fa fa-pinterest" aria-hidden="true"></i> </a></li>';
                    }if(get_theme_mod('carpet-social-googleplus')){
                        echo '<li><a href="'.get_theme_mod('carpet-social-googleplus').'"
                         target="_blank"
                        ><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>';
                    }if(get_theme_mod('carpet-social-instagram')){
                        echo '<li><a href="'.get_theme_mod('carpet-social-instagram').'" target="_blank"> <i class="fa fa-instagram" aria-hidden="true"></i> </a></a></li>';}*/
                        $soclinks=get_field('social_links',89);
                        foreach($soclinks as $soclink){
                            if($soclink['social_link_url']){?>
                               <li><a href="<?php echo $soclink['social_link_url'] ;?>" target="_blank">
                       
                        <i class="fa  <?php echo $soclink['class_name'] ;?>" aria-hidden="true"></i></a></li>
                           <?php }
                        }
                     
                        ?>
                    </ul>
                    <div class="clearfix"></div>
                </div><div class="clearfix"></div><!-- social end -->
                
                
                
                
            </div><!-- left footer end -->
           
            <div class="col-md-4 idea-right">

                <h2 class="calcall"> “<?php echo bloginfo('description');?>” </h2>
                <h3 class="calspl calspll">
                  <?php 
                     $telephone_link =  get_field('telephone_link', '89',false); 
                     $x = preg_replace('/\s+/', '', $telephone_link);
                     $x = preg_replace( '/^[0]{1}/', '', $x );
                     $i = 1;
                     $x = '+61'.$x;   
                  ?>
                  <a href="tel:<?php echo $x; ?>"><?php echo __( 'CALL ', 'carpetcall' ) . $telephone_link;?></a>
                </h3>
                <h4 class="bcwfsp"><?php echo get_field('footer_contact_title_label',89);?> </h4>

                <div class="againlt footer-menu-none">
                    <ul>

                        <?php $booklink=get_field('contactlink',89);?>
                        <?php
                            foreach($booklink as $singlelink){

                                 echo '<li> ' . $singlelink['ask_an_expert'] . '</li>';
                            }
                        ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>

<div class="fcnt-or fcnt-orr clearfix">
  <a href="<?php echo get_field('contact_url','89'); ?>" target="_blank"><?php echo get_field('contact_link_title','89'); ?></a>
</div>

</div><div class="clearfix"></div><!-- right footer end -->
</div>
  </div><div class="clearfix"></div>
<div class="container">
<div class="col-md-12 no-pl">
<div class="fot_cpy">
<ul>
<li><span class="cpyrt"> © Copyright <?php echo date("Y"); ?> Carpet CalL</span> </li>
<?php
  # footer bottom menu
  
$url = site_url();
$url =explode('/',$url);

if(strcasecmp($url[2],'localhost')==0){
  echo '
  <li><a href="#"> SITE MAP </a></li>
  <li><a href="#" class="last-child"> TERMS AND CONDITIONS </a></li>';
}
else{
  $smID = 35294;
  $tncID = 35292;
  echo '
  <li><a href="' . get_permalink($smID) . '"> ' . get_the_title($smID) . ' </a></li>
  <li><a href="' . get_permalink( $tncID ) . '" class="last-child"> ' . get_the_title( $tncID ) . ' </a></li>';  
}
?>

</ul><div class="clearfix"></div>
</div><div class="clearfix"></div>
</div>
</div>


</div><div class="clearfix"></div><!-- footer end -->


</div><!-- main wrapper end -->
</div>





<?php 
  include('woocommerce/emails/email-header.php');
  include('woocommerce/emails/email-footer.php');


?>












<script>
// Initiate Lightbox
// (function() {
//     if(jQuery('.ourgallery').length>0)
//         jQuery('.ourgallery a').lightbox();
// });
</script>
<script type="text/javascript">
jQuery(document).ready(function () {
var $tabs = jQuery('#horizontalTab');
// $tabs.responsiveTabs({
// rotate: false,
// startCollapsed: 'accordion',
// collapsible: 'accordion',
// setHash: true,
// activate: function(e, tab) {
// jQuery('.info').html('Tab <strong>' + tab.id + '</strong> activated!');
// console.log(tab);
// var slider_cnt=jQuery(tab.selector).find('.regular-slider');
// // alert('hji');
// if(jQuery(slider_cnt).length){
// jQuery(slider_cnt).slick({
// dots: true,
// infinite: true,
// slidesToShow: 3,
// slidesToScroll: 3
// });
// }

// },
// activateState: function(e, state) {
// //console.log(state);
// jQuery('.info').html('Switched from <strong>' + state.oldState + '</strong> state to <strong>' + state.newState + '</strong> state!');

// }
// });
jQuery('#start-rotation').on('click', function() {
$tabs.responsiveTabs('startRotation', 1000);
});
jQuery('#stop-rotation').on('click', function() {
$tabs.responsiveTabs('stopRotation');
});
jQuery('#start-rotation').on('click', function() {
$tabs.responsiveTabs('active');
});
jQuery('#enable-tab').on('click', function() {
$tabs.responsiveTabs('enable', 3);
});
jQuery('#disable-tab').on('click', function() {
$tabs.responsiveTabs('disable', 3);
});
jQuery('.select-tab').on('click', function() {
$tabs.responsiveTabs('activate', jQuery(this).val());
});
});


</script>



<?php wp_footer();?>
</body>
</html>






<?php  
if(isset($_POST["wpsl-search-input"]) && isset($_POST["cc-control-map"]) ){?>
  <script>
 

 jQuery(".cc-map-control-finder").click(function(e) {
  var  a = '<?php echo json_encode($_POST["wpsl-search-input"]);?>';


jQuery('#wpsl-search-input').val(a);
jQuery('#wpsl-search-btn').trigger('click');

  });
  </script>


<?php }?>
 <script>
  jQuery(document).ready(function(){
    jQuery("input#price_range_filter").slider();
    
   /* jQuery('.cat_slider').slick({
          dots: true,
          infinite: false,
          speed: 300,
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows:false,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        });*/
  });


  </script>