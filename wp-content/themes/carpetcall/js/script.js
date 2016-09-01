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
        speed: 600,
        autoplay: true,
        autoplaySpeed: 6000,
        responsive: [
          {
            breakpoint: 801,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '0',
              slidesToShow: 1,
              draggable:true,
            }
          }
        ]
      }); 
      jQuery('.center').show();
    }
    // HomePage Hero Slider End

    // HomePage Featured Product Slider 
    if( jQuery('.responsive').length){   
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
            breakpoint: 801,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 481,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }      
        ]
      });
    }
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
        jQuery(this).next(".dropdown-content").toggle();
        jQuery(this).parent('.dropdown').toggleClass('click-open');
        jQuery('.woocomerce_dropdown').removeClass('open');
      });
    }
    storeFinderClick();
    // Store Finder Btn Header End

    
    jQuery(document).on("click",function(e) {
     // e.preventDefault();
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
      if($(window).innerWidth() >= 800){
        if ((yclick > 900 )|| (xclick > posleftbox || xclick < jQuery("#storefinder_btn").offset().left)) {
          jQuery('#after_dropdown').hide();
          jQuery('.storefinder_cntr').removeClass('click-open');
        }
      }else{
        if (yclick > 2000) {
          jQuery('#after_dropdown').hide();
          jQuery('.storefinder_cntr').removeClass('click-open');
        }
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

    // Clone Cart Dropdown from 800px
    if($('#mywoosection').length){
      function cloneCartDrop(){
        if( $(window).width() <= 800 ){
          var toCartClone = $('#mywoosection');
          toCartClone.clone().appendTo('.top-mobile-icons .top-cart-icon');
          toCartClone.remove();          
        }else{

        }
      }
      cloneCartDrop();
      window.addEventListener('resize', cloneCartDrop);
    }

    // Accordion for footer Menu
    if($('.footer_nav_mobile').length){
      $('.footer_nav_mobile .foot_mob li.menu-item-has-children').prepend('<span class="fa fa-angle-down footer-open"></span>');          
       function footer_menu_toggle(){
        jQuery('.footer_nav_mobile .foot_mob li.menu-item-has-children span.footer-open').click(function(j) {
          if(jQuery(this).parent('li').hasClass('open')){          
            jQuery(this).parent('li').find('ul.sub-menu').slideUp();
            jQuery(this).parent('li').removeClass('open');
          }else{
            jQuery('.footer_nav_mobile .foot_mob li.menu-item-has-children ul.sub-menu' ).slideUp();
            jQuery('.footer_nav_mobile .foot_mob li.menu-item-has-children.open' ).removeClass('open');
            jQuery(this).parent('li').addClass('open');
            var dropDown = jQuery(this).parent('li').find('ul.sub-menu');             
            dropDown.stop(false, true).slideToggle();        
          }
          if (jQuery(this).hasClass('active')) {
            jQuery(this).removeClass('active fa-angle-up').addClass('fa-angle-down');          
          } else {
            jQuery(this).removeClass('fa-angle-down').addClass('active fa-angle-up');
            jQuery('.footer_nav_mobile .foot_mob li.menu-item-has-children span.footer-open.active').removeClass('active fa-angle-up').addClass('fa-angle-down'); 
            jQuery(this).removeClass('fa-angle-down').addClass('active fa-angle-up');
          }
                   
        });    
      }
      footer_menu_toggle();
    }

    // Header Nav Scripts
    if($('#cssmenu').length){

      responsive_nav();

      function responsive_nav(){
        if($(window).innerWidth() <= 800){          
          $('#cssmenu ul li ul li.sub-menu-item').append('<span class="fa fa-angle-right right_arrow"></span>');

          var parentLink = $('#cssmenu ul li ul li.sub-menu-item');
          $(parentLink).each(function(){
            var $this = $(this);
            var selected_link = $this.children('a').attr('href');
            var selected_link_text = $this.children('a').text();
            if($(this).find('.selected-link-cntr').length <= 0){
              $this.children('ul.menu-depth-2').prepend('<div class="selected-link-cntr"><span class="go-back"><i class="fa fa-angle-left"></i></span><span class="selected_link_text">'+ selected_link_text +'</span></span><span class="selected_main_link"><a href=\"'+selected_link+'\">ALL</a></span></div>')
            }
          });
        }else{
          $('.right_arrow').remove();
          $('.selected-link-cntr').remove();
        }
      }

      $('#cssmenu > ul > li.main-menu-item > a').on('click', function(e){
        if($(window).innerWidth() <= 800 ){
          e.preventDefault();
          var liParent = $(this).parent('li');        

          if(liParent.hasClass('open_sub_nav')){                    
            liParent.find('ul.menu-depth-1').removeClass('is-visible');
            liParent.removeClass('open_sub_nav');          
          }else{
            jQuery('#cssmenu > ul > li.main-menu-item ul.sub-menu' ).removeClass('is-visible');
            jQuery('#cssmenu > ul > li.main-menu-item.open_sub_nav' ).removeClass('open_sub_nav');
            $('#cssmenu ul li ul li.sub-menu-item.open_inner_nav').removeClass('open_inner_nav');
            liParent.addClass('open_sub_nav');
            liParent.find('ul.menu-depth-1').addClass('is-visible');
          }

          if($(this).hasClass('show_nav')){
            $(this).removeClass('show_nav');
          }else{
            $(this).addClass('show_nav');
            $('#cssmenu > ul > li.main-menu-item > a.show_nav').removeClass('show_nav');
            $(this).addClass('show_nav');
          }
        }
      });

      $('#cssmenu ul li ul.menu-depth-1 li.sub-menu-item span.right_arrow').on('click', function(){        
         if($(window).innerWidth() <= 800 ){
          var innerParent = $(this).parent('li');
          var mainParent = $(this).parents('li.open_sub_nav');

          if(innerParent.hasClass('open_inner_nav')){
            innerParent.find('ul.menu-depth-2').removeClass('is-visible');
            innerParent.removeClass('open_sub_nav');
            $('#cssmenu ul li ul li.sub-menu-item.open_inner_nav').removeClass('open_inner_nav');
          }else{
            jQuery('#cssmenu > ul > li.main-menu-item ul.menu-depth-1' ).removeClass('is-visible');
            jQuery('#cssmenu > ul > li.main-menu-item ul.sub-menu li ul.menu-depth-2' ).removeClass('is-visible');
            jQuery('#cssmenu > ul > li.main-menu-item.open_sub_nav ul li.open_inner_nav' ).removeClass('open_inner_nav');
            innerParent.addClass('open_inner_nav');
            innerParent.find('ul.menu-depth-2').addClass('is-visible');
          }
        }
      }); 

      $('.selected-link-cntr span.go-back').on('click', function(){
        if($(window).innerWidth() <= 800 ){
          $(this).parents('ul.menu-depth-2').removeClass('is-visible');
          $(this).parents('ul.menu-depth-1').addClass('is-visible');
          $(this).parents('ul.menu-depth-1').find('li.open_inner_nav').removeClass('open_inner_nav');
        }
      });

    }
    // Header Nav Scripts End
     
    
    // Product Sidebar Mobile
    if($('#product-side-filter').length){

      $('.rugm-blk .open-product-sidebar').on('click', function(){        
        $('#product-side-filter').addClass('open-sidebar');
      });

      $('.go-back-text, .mobile-apply-btn a').on('click', function(e){
        e.preventDefault();
        $('#product-side-filter').removeClass('open-sidebar');
      });
    }

    // Close accordion of Sidebar in Mobile
    if($('#accordion-color').length){
      if($(window).innerWidth()<=800){
        $('#accordion-color').find('.panel-collapse').removeClass('in');
      }
    }

    // Checkout form custom radio buttons
    if($('.radiogroup_wrap').length){
      $('.radiogroup_wrap input[type="checkbox"]').wrap('<label class="css-label"></label>');
      $('.radiogroup_wrap input[type="checkbox"]').css({'opacity':0});
      $('.radiogroup_wrap input[type="radio"]').wrap('<label class="radio-label"></label>');
      $('.radiogroup_wrap input[type="radio"]').css({'opacity':0});      
      var checkbox_checked = 'radio-check-label',
          radiochecked = 'radio-check-label',
          radioParentClass = 'radio-checked',
          checkboxParentClass = 'radio-checked',
          elms=$('.radiogroup_wrap input[type="checkbox"], .radiogroup_wrap input[type="radio"]');

      function setLabelClass() {
        elms.each(function(i,e) {
          $(e).parent('label')[e.checked?'addClass':'removeClass']($(e).is(':radio')?radiochecked:checkbox_checked);
          $(e).parents('.delivery_option_item')[e.checked?'addClass':'removeClass']($(e).is(':radio')?radioParentClass:checkboxParentClass);
        });
      }

      elms.on('change', setLabelClass);
      setLabelClass();
      
      $('.delivery_option_item').on('click', function(){
        var radBtn = $(this).find('input[type=radio]');
        $(radBtn).prop("selected", true);        
        setLabelClass();
      });
    }

    // Custom Radio
    if($('.pickup_location_list').length){
      $('.delivery_option_rugs #nearby_stores_main_wrapper .pickup_location_list input[type=radio]').wrap('<label class="inner-radio-label"></label>');
      $('.delivery_option_rugs #nearby_stores_main_wrapper .pickup_location_list input[type=radio]').css({'opacity':0});
      var innerradiochecked = 'radio-check-label'; 
      elm=$('.delivery_option_rugs #nearby_stores_main_wrapper .pickup_location_list input[type=radio]');

      function setRadioClass() {
        elm.each(function(i,e) {
          $(e).parent('label')[e.checked?'addClass':'removeClass']($(e).is(':radio')?innerradiochecked:innercheckbox_checked);          
        });
      }

      elm.on('change', setRadioClass);
      setRadioClass();  
    }

    // Custom Checkbox
    if($('#ship-to-different-address').length){
      $('.delivery_option_rugs #ship-to-different-address input[type=checkbox]').wrap('<label class="inner-check-label"></label>');
      $('.delivery_option_rugs #ship-to-different-address input[type=checkbox]').css({'opacity':0});
      var innercheckchecked = 'radio-check-label'; 
      chk=$('.delivery_option_rugs #ship-to-different-address input[type=checkbox]');

      function setCheckClass() {
        chk.each(function(i,e) {
          $(e).parent('label')[e.checked?'addClass':'removeClass']($(e).is(':radio')?innerradiochecked:innercheckchecked);          
        });
      }

      chk.on('change', setCheckClass);
      setCheckClass();  
    } 

    // To Top
    if($('.cc_to_top_cntr').length){
      $('.to_top_btn').on('click', function (e) {
          e.preventDefault();
          $('html,body').stop().animate({
              scrollTop: 0
          }, 600);
      });
    }

    // Display large image in mobile
    if($(".product_single_thumb_slider").length){
      function largeImgMob(){
        var bigImg = $(".single-product-thumb-img");      
        $(bigImg).each(function() {
          var bigImgHref = $(this).attr('href');
          $(this).find("img").attr("src", bigImgHref);
        });
      }
      largeImgMob();
    }
    
    // Accordion Add and Remove Active class on heading
    $(function() {
      $('.single-produc-acc-cntr')
      .on('show.bs.collapse', function(e) {
        $(e.target).prev('.panel-heading').addClass('active');
      })
      .on('hide.bs.collapse', function(e) {
        $(e.target).prev('.panel-heading').removeClass('active');
      });          
    });
      

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
