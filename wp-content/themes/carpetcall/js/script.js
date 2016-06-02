(function($) {
    $(document).ready(function() {
        $('#cssmenu').prepend('<div id="menu-button">Menu</div>');
        $('#cssmenu #menu-button').on('click', function() {
            var menu = $(this).next('ul');
            if (menu.hasClass('open')) {
                menu.removeClass('open');
            } else {
                menu.addClass('open');
            }
        });
    });
})(jQuery);
$(document).ready(function(e) {
    $('#storefinder_btn').hover(function() {
        $(this).parent('.dropdown').toggleClass('click-open');
        $("#after_dropdown").show();

        $("#storefinder_id").addClass('click-open');
       
      $('.woocomerce_dropdown').removeClass('open');
        $('.dropdown-menu').hide() ;
  
   

    });
    
     
    $(document).on('hover', function(event) {
        if (!$(event.target).closest('.storefinder_cntr').length &&
            !$(event.target).is('.storefinder_cntr')) {
            if ($('.storefinder_cntr').is(":visible")) {
                $('.storefinder_cntr').removeClass('click-open');
            }
        }
    });


    $(document).mouseup(function(e) {
        e.preventDefault();
        var container = $("#after_dropdown");
        var extra = $(".pac-container");
        var xclick = window.event.clientX;
  
        var yclick = window.event.clientY;
        yclick = yclick + 150;
        var compare = $("#after_dropdown").height();
        var posx = $("#after_dropdown").position();
       
        var postoptbox = $("#after_dropdown").offset().top + $("#after_dropdown").height();
        postoptbox = postoptbox + 100;


        var posleftbox = $("#storefinder_btn").offset().left + $("#after_dropdown").width();

        compare = compare + 150;
        if ((yclick > 900 )|| (xclick > posleftbox || xclick < $("#storefinder_btn").offset().left)) {

            jQuery('#after_dropdown').hide();
            $('.storefinder_cntr').removeClass('click-open');
        }



    });



});
jQuery(window).load(function() {

    jQuery('.carpetcall_slide .slider_overlay').hide();
    jQuery('.feature_pro .featured_overlay').hide();

});
$(window).scroll(function(event) {
    jQuery('.pac-container').hide();
});
$(window).scroll(function(event) {
    jQuery('#after_dropdown').hide();
    $('.storefinder_cntr').removeClass('click-open');
});