(function($) {

  // Document Ready
  jQuery(document).ready(function() {

    // HomePage Hero Slider
    var left_offset = jQuery(".container").offset().left - 10;

    if( jQuery('.center').length){
    jQuery('.center')
    .on('init', function(slick) {            
      jQuery('.center').fadeIn(3000);
    })
    .slick({
      centerMode: true,
      centerPadding: left_offset + 'px',
      slidesToShow: 1,
      arrows: true,
      dots: true,
      draggable:false,
      lazyLoad: 'ondemand',
      speed: 1000,
      responsive: [
        {
          breakpoint: 769,
          settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '40px',
            slidesToShow: 3,
            draggable:true,
          }
        },
        {
          breakpoint: 481,
          settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '40px',
            slidesToShow: 1,
            draggable:true,        
          }
        }
      ]
    }); 
    jQuery('.center').show();}
    // HomePage Hero Slider End

    // HomePage Featured Product Slider 
    if( jQuery('.center').length){   
    jQuery('.responsive').slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 4,
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
      ]
    });}
    // HomePage Featured Product Slider End

    // CSS MENU
    jQuery('#cssmenu').prepend('<div id="menu-button">Menu</div>');
    jQuery('#cssmenu #menu-button').on('click', function() {
      var menu = jQuery(this).next('ul');
      if (menu.hasClass('open')) {
        menu.removeClass('open');
      } else {
        menu.addClass('open');
      }
    });
    // CSS MENU END

    // Store Finder Btn Header
    
    function storeFinderClick(){
      jQuery('#storefinder_btn').click(function() {
        jQuery(".dropdown-content").toggle();
        jQuery(this).parent('.dropdown').toggleClass('click-open');
        jQuery('.woocomerce_dropdown').removeClass('open');
      });
    }
    storeFinderClick();
    // Store Finder Btn Header End

    
    jQuery(document).on("click",function(e) {
      var container = jQuery("#after_dropdown");
      var bannerHeight = jQuery('.banner').outerHeight(true);
      var extra = jQuery(".pac-container");
      var xclick = window.event.clientX;

      var yclick = window.event.clientY;
      yclick = yclick + bannerHeight;
      var compare = jQuery("#after_dropdown").height();
      var posx = jQuery("#after_dropdown").position();
      var postoptbox = jQuery("#after_dropdown").offset().top + jQuery("#after_dropdown").height();
      postoptbox = postoptbox + 100;
      var posleftbox = jQuery("#storefinder_btn").offset().left + jQuery("#after_dropdown").width();
      compare = compare + bannerHeight;
      if ((yclick > 900 )|| (xclick > posleftbox || xclick < jQuery("#storefinder_btn").offset().left)) {
        jQuery('#after_dropdown').hide();
        jQuery('.storefinder_cntr').removeClass('click-open');
      }
    });

    jQuery(document).on('click','.product-remove a',function(){
      setTimeout(function(){ load_minicart(); }, 1500);
    });

    if(jQuery('.ia-block').length){
      window.addEventListener('resize', ia_right_offset);
      ia_right_offset();
      function ia_right_offset(){
        var left_offset = jQuery('.ia-block .container').offset().left;
        var parent_width = jQuery('.cc-ia-banner').parents('.ia-img').outerWidth();
        jQuery('.cc-ia-banner').width( parent_width + left_offset + 20);
      }
    }

    if(jQuery('.cc-clearance-blk').length){
      window.addEventListener('resize', ia_right_offset);
      ia_right_offset();
      function ia_right_offset(){
        var left_offset = jQuery('.cc-clearance-blk .container').offset().left;
        var parent_width = jQuery('.cc-ia-banner-a').parents('.ia-imgg').outerWidth();
        jQuery('.cc-ia-banner-a').width( parent_width + left_offset + 20);
      }
    }

    // INIT slick slider of category
    // INIT slick slider of category End


    jQuery('#wpsl-search-btn').on('click', function() {
      var attr = jQuery('#wpsl-search-input').attr('onkeyup');
      if (typeof attr !== typeof undefined && attr !== false) {
        jQuery("#wpsl-search-input").removeAttr("onkeyup");
      }
    });

    // Text change of Shop our range to shop from 800px
    if($('.top_shop').length){
      function shop_text(){
        if( $(window).width() <= 800 ){
          $('.top_shop > a').text('Shop');
        }else{
          $('.top_shop > a').text('Shop our range');
        }
      }
      shop_text();
      window.addEventListener('resize', shop_text);
    }


    // Clone strore finder Dropdown from 800px

    if($('.sfind').length){     
      function cloneShopDrop(){
        if( $(window).width() <= 800 ){
          var toClone = $('.sfind');
          toClone.clone().appendTo('.top-mobile-icons .top-map-icon');
          toClone.remove();
          storeFinderClick();
        }else{

        }
      }
      cloneShopDrop();
      window.addEventListener('resize', cloneShopDrop);
    }

  });

  // Document Ready End

  jQuery(window).scroll(function(event) {
    jQuery('.pac-container').hide();
  });


  jQuery(window).scroll(function(event) {
    jQuery('#after_dropdown').hide();
    jQuery('.storefinder_cntr').removeClass('click-open');
  });


  // Window Load Start
  jQuery(window).load(function() {

    jQuery('.carpetcall_slide .slider_overlay').hide();
    jQuery('.feature_pro .featured_overlay').hide();

    jQuery('#tag-description').remove();

    // Home Page slider Nav Position
    // 
    function slider_position(){
      var left_offset = jQuery(".container").offset().left - 10;  
      var left_arrow = jQuery(".slider .slick-prev").css({ 'left': left_offset + 10 });
        var left_arrow = jQuery(".slider .slick-next").css({ 'right': left_offset + 10 });  
    }
    slider_position();
    var slider_inner = jQuery('.hamro').show();

  });
  // Window Load End

})(jQuery);
