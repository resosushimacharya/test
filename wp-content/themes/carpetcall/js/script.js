(function($) {
    jQuery(document).ready(function() {
        jQuery('#cssmenu').prepend('<div id="menu-button">Menu</div>');
        jQuery('#cssmenu #menu-button').on('click', function() {
            var menu = jQuery(this).next('ul');
            if (menu.hasClass('open')) {
                menu.removeClass('open');
            } else {
                menu.addClass('open');
            }
        });
    });
})(jQuery);
$i=1;
jQuery(document).ready(function(e) {
    jQuery('#storefinder_btn').click(function() {
        

        jQuery(".dropdown-content").toggle();
         jQuery(this).parent('.dropdown').toggleClass('click-open');
    

     
       
      jQuery('.woocomerce_dropdown').removeClass('open');
        jQuery('.dropdown-menu').hide() ;

  
   

    });
    
    
   /* jQuery(document).on('hover', function(event) {
        if (!jQuery(event.target).closest('.storefinder_cntr').length &&
            !jQuery(event.target).is('.storefinder_cntr')) {
            if (jQuery('.storefinder_cntr').is(":visible")) {
                jQuery('.storefinder_cntr').removeClass('click-open');
            }
        }
    });*/


    jQuery(document).mouseup(function(e) {
        e.preventDefault();
        var container = jQuery("#after_dropdown");
        var extra = jQuery(".pac-container");
        var xclick = window.event.clientX;
  
        var yclick = window.event.clientY;
        yclick = yclick + 150;
        var compare = jQuery("#after_dropdown").height();
        var posx = jQuery("#after_dropdown").position();
       
        var postoptbox = jQuery("#after_dropdown").offset().top + jQuery("#after_dropdown").height();
        postoptbox = postoptbox + 100;


        var posleftbox = jQuery("#storefinder_btn").offset().left + jQuery("#after_dropdown").width();

        compare = compare + 150;
        if ((yclick > 900 )|| (xclick > posleftbox || xclick < jQuery("#storefinder_btn").offset().left)) {

            jQuery('#after_dropdown').hide();
            jQuery('.storefinder_cntr').removeClass('click-open');
        }



    });
	
	


});
jQuery(window).load(function() {

    jQuery('.carpetcall_slide .slider_overlay').hide();
    jQuery('.feature_pro .featured_overlay').hide();

});
jQuery(window).scroll(function(event) {
    jQuery('.pac-container').hide();
});
jQuery(window).scroll(function(event) {
    jQuery('#after_dropdown').hide();
    jQuery('.storefinder_cntr').removeClass('click-open');
});
jQuery(window).load(function() {

     jQuery('#tag-description').remove();

});


jQuery(document).ready(function(){
    if(jQuery('.ia-block').length){
	window.addEventListener('resize', ia_right_offset);
	ia_right_offset();
	function ia_right_offset(){
		var left_offset = jQuery('.ia-block .container').offset().left;
		var parent_width = jQuery('.cc-ia-banner').parents('.ia-img').outerWidth();
		jQuery('.cc-ia-banner').width( parent_width + left_offset + 20);

	}
}
});

jQuery(document).ready(function(){
    if(jQuery('.cc-clearance-blk').length){
	window.addEventListener('resize', ia_right_offset);
	ia_right_offset();
	function ia_right_offset(){
		var left_offset = jQuery('.cc-clearance-blk .container').offset().left;
		var parent_width = jQuery('.cc-ia-banner-a').parents('.ia-imgg').outerWidth();
		jQuery('.cc-ia-banner-a').width( parent_width + left_offset + 20);

	}
}
});
jQuery(document).ready(function(e) {
    init_slick_slider();
});

function init_slick_slider(){
	 jQuery('.cat_slider').slick({
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
        });
	}

jQuery(document).ready(function(){
jQuery('#wpsl-search-btn').on('click', function() {

var attr = jQuery('#wpsl-search-input').attr('onkeyup');


if (typeof attr !== typeof undefined && attr !== false) {
jQuery("#wpsl-search-input").removeAttr("onkeyup");

}

});

});
