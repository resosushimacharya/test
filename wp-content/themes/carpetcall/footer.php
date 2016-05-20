<div class="footer_c">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="fot_logo">
                    <img src="<?php echo get_template_directory_uri() ;?>/images/carpetcall-logo.png" alt="logo" class="img-responsive"/>
                </div>

                <div class="subcat">
                    <div class="row"><!--my style ---->

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
                </div>
                <div class="clearfix"></div><!-- sub category listing end -->
                <div class="social">
                    <ul>
                        <li> <span class="gtku">GET TO KNOW US</span>  </li>
                        <?php echo '<li><a href="'.get_theme_mod('carpet-social-facebook').'"
                        target="_balnk"
                        ><i class="fa fa-facebook-square" aria-hidden="true"></i> </a></li>';
                        echo '<li><a href="'.get_theme_mod('carpet-social-youtube').'"
                        target="_balnk"
                        ><i class="fa fa-youtube-play" aria-hidden="true"></i> </a></li>';
                        echo '<li><a href="'.get_theme_mod('carpet-social-pininterest').'"
                        target="_balnk"
                        > <i class="fa fa-pinterest" aria-hidden="true"></i> </a></li>';
                        echo '<li><a href="'.get_theme_mod('carpet-social-googleplus').'"
                        target="_balnk"
                        ><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>';
                        echo '<li><a href="'.get_theme_mod('carpet-social-instagram').'"> <i class="fa fa-instagram" aria-hidden="true"></i> </a></a></li>';?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div><!-- social end -->
            </div><!-- left footer end -->

            <div class="col-md-4">

                <h2 class="calcall"> “Call, Call, Carpetcall the experts in the trade” </h2>
                <h3 class="calspl">CALL&nbsp;<?php echo get_field('telephone',89);?></h3>
                <h4 class="bcwfsp"> BOOK A CALLBACK WITH OUR FLOORING SPECIALISTS </h4>

                <div class="againlt">
                    <ul>

                        <?php $booklink=get_field('contactlink',89);?>
                        <?php
                            foreach($booklink as $singlelink){

                                echo '<li><a href="'.$singlelink['contact_url'].'"'.'target="_blank">'.$singlelink['_ask_an_expert'].'</a></li>';
                            }
                        ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>

<div class="fcnt-or fcnt-orr clearfix"><a href="#" target="_blank"> CONTACT US</a> </div>

</div><div class="clearfix"></div><!-- right footer end -->
</div></div><div class="clearfix"></div>

<div class="container"><div class="row">
<div class="col-md-12">
<div class="fot_cpy">
<ul>
<li><span class="cpyrt"> © Copyright 2016 Carpet CalL</span> </li>
<li><a href="#"> SITE MAP </a></li>
<li><a href="#" class="last-child"> TERMS AND CONDITIONS </a></li>
</ul><div class="clearfix"></div>
</div><div class="clearfix"></div>
</div>
</div></div><div class="clearfix"></div>


</div><div class="clearfix"></div><!-- footer end -->



</div><!-- main wrapper end -->
<script>
// Initiate Lightbox
$(function() {
$('.ourgallery a').lightbox();
});
</script>
<script type="text/javascript">
$(document).ready(function () {
var $tabs = $('#horizontalTab');
$tabs.responsiveTabs({
rotate: false,
startCollapsed: 'accordion',
collapsible: 'accordion',
setHash: true,
activate: function(e, tab) {
$('.info').html('Tab <strong>' + tab.id + '</strong> activated!');
console.log(tab);
var slider_cnt=$(tab.selector).find('.regular-slider');
// alert('hji');
if($(slider_cnt).length){
$(slider_cnt).slick({
dots: true,
infinite: true,
slidesToShow: 3,
slidesToScroll: 3
});
}

},
activateState: function(e, state) {
//console.log(state);
$('.info').html('Switched from <strong>' + state.oldState + '</strong> state to <strong>' + state.newState + '</strong> state!');

}
});
$('#start-rotation').on('click', function() {
$tabs.responsiveTabs('startRotation', 1000);
});
$('#stop-rotation').on('click', function() {
$tabs.responsiveTabs('stopRotation');
});
$('#start-rotation').on('click', function() {
$tabs.responsiveTabs('active');
});
$('#enable-tab').on('click', function() {
$tabs.responsiveTabs('enable', 3);
});
$('#disable-tab').on('click', function() {
$tabs.responsiveTabs('disable', 3);
});
$('.select-tab').on('click', function() {
$tabs.responsiveTabs('activate', $(this).val());
});
});
</script>
<?php wp_footer();?>
</body>
</html>