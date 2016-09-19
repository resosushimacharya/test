(function($) {

  // Document Ready
  jQuery(document).ready(function() {

    // HomePage Hero Slider    

     window.addEventListener("resize", left_offset);
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
      
    }
	jQuery(document).on('click','#storefinder_btn',function() {
        jQuery(this).next(".dropdown-content").toggle();
        jQuery(this).parent('.dropdown').toggleClass('click-open');
        jQuery('.woocomerce_dropdown').removeClass('open');        
      });
	  
    //storeFinderClick();
     window.addEventListener('resize', storeFinderClick);
    // Store Finder Btn Header End

    jQuery('.popup-overlay-div').on("click", function(){
      $('#storefinder_id').removeClass('click-open');
      $('li#woo_control').removeClass('open');
      $('#after_dropdown').hide();
      $(this).removeClass('open-overlay');
    });
	
	jQuery(document).on('click',function(e){
		 if (jQuery(e.target).parents('#storefinder_id').length == 0) {
			
			jQuery("#after_dropdown.dropdown-content").hide();
			jQuery('#storefinder_id.dropdown').removeClass('click-open');
			jQuery('.woocomerce_dropdown').removeClass('open');    
		}
		
	})
    // Top Cart DropDown
    
   
     /* jQuery(document).on("click",function(e) {
		   if(jQuery(window).width() > 800){
			   // e.preventDefault();
				var container = jQuery("#after_dropdown");
				var bannerHeight = jQuery('.banner').outerHeight(true);
				var extra = jQuery(".pac-container");
				var xclick = e.screenX;
		
				var yclick = e.screenY;
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
		   }
      });
*/

    jQuery(document).on('click','.product-remove a',function(){
      setTimeout(function(){ load_minicart(); }, 1500);
    });

    if(jQuery('.ia-block .container').length > 0){
      window.addEventListener('resize', ia_right_offset);
      ia_right_offset();
      function ia_right_offset(){
        var left_offset = jQuery('.ia-block .container').offset().left;
        var parent_width = jQuery('.cc-ia-banner').parents('.ia-img').outerWidth();
        jQuery('.cc-ia-banner').width( parent_width + left_offset + 20);
      }
    }

    if(jQuery('.cc-clearance-blk .container').length > 0){
      window.addEventListener('resize', ia_right_offset);
      ia_right_offset();
      function ia_right_offset(){
        if($(window).width() > 800){
          var left_offset = jQuery('.cc-clearance-blk .container').offset().left;
          var parent_width = jQuery('.cc-ia-banner-a').parents('.ia-imgg').outerWidth();
          jQuery('.cc-ia-banner-a').width( parent_width + left_offset + 20);
        }
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
          var toClone = $('.navsrchblk').find('.sfind');
          toClone.clone().appendTo('.top-mobile-icons .top-map-icon');
          toClone.remove();
          storeFinderClick();
        }else{
          var cloneBack = $('.top-mobile-icons .top-map-icon').find('.sfind');
          cloneBack.clone().appendTo('.navsrchblk .top-map-icon');
          cloneBack.remove();
          storeFinderClick();
        }
      }
      cloneShopDrop();
      window.addEventListener('resize', cloneShopDrop);
    }

    // Clone Cart Dropdown from 800px
    

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

      window.addEventListener('resize', responsive_nav);
      responsive_nav();

      function responsive_nav(){
        if($(window).innerWidth() <= 800){          
          $('#cssmenu ul li ul li.sub-menu-item.menu-item-has-children').append('<span class="fa fa-angle-right right_arrow"></span>');

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

      $(document).on('click touchend','#cssmenu > ul > li.main-menu-item > a', function(e){
        if($(window).innerWidth() <= 800 ){}
      });



      $(document).on('click', '#cssmenu ul li ul.menu-depth-1 li.sub-menu-item span.right_arrow', function(){ 
	       
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
    if($('.cc-cat-pro-section-left').length){
      if($(window).innerWidth()<=800){
        $('.cc-color-var-section').find('.panel-collapse.in').removeClass('in');
        $('.cc-product-sub-category-list').find('.panel-collapse.in').removeClass('in');
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
        $(e.target).parent('.panel-default').addClass('active');
        $(e.target).prev('.panel-heading').addClass('active');
      })
      .on('hide.bs.collapse', function(e) {
        $(e.target).parent('.panel-default').removeClass('active');
        $(e.target).prev('.panel-heading').removeClass('active');
      });          
    });
	
  	// Table Responsive function
  	function resTable(tableName){
  		var $th = $(this).find("th");
  		var $td = $(this).find("tbody tr td");
  		$($td).attr('data-attr', function () {
  			return $th.eq($(this).index()).text();
  		});
  	}
  	
  	resTable(".cbg_content.cc-condn-page .woocommerce table.shop_table");

    // Select a product dropdown in Mobile
    if($('.select-design-wrapper').length){
      var $activePro = $('.pro-active');
      var $activeText = $($activePro).find(".selected-pro-name").text();
      var $activeImage = $($activePro).find("img");
      
      $activeImage.clone().appendTo(".selected-product-img");
      $(".selected-product-name span").html($activeText);

      $('.select-dropdown-wrap').on('click', function(){
        $(this).parent().find('.cc-select-design-pro-all').toggle();
      });
    }	

    // Active Accessories Text
    if($(".access_active_type_cntr").length){
      var activeAccText  = $(".accessories_inner_tab_select").find("li.active a").text();
      $('.access_tab_active span').text(activeAccText);

      $(".access_tab_active").on("click", function(){
        $(this).parent().find("ul.accessories_inner_tab_select").toggle();
      });

      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var activeAccText = $(e.target).text() // activated tab
        $('.access_tab_active span').text(activeAccText);
        $(this).parents("ul.accessories_inner_tab_select").hide();
      });
    }

    // Carpets Mobile dropdown
    function openCarSide(){
      $(".cc-carpet-subcat-list").on("click", function(){
        $(this).find("ul.guide_list_cbg").toggle();
      });
    }
    window.addEventListener('resize', openCarSide); 
    
    

    // Clone Carpets Sidebar
    if($('.cc-carpet-subcat-list').length){
      function cloneCarSide(){
        if( $(window).width() <= 800 ){
          var toSideClone = $('.cc-cat-pro-section-left').find('.cc-carpet-subcat-list');
          toSideClone.clone().appendTo('.carpets-cat-dropdown');
          toSideClone.remove();
          openCarSide();          
        }else{
          var cloneBackSide = $('.carpets-cat-dropdown').find('.cc-carpet-subcat-list');
          cloneBackSide.clone().appendTo('.cc-cat-pro-section-left');
          cloneBackSide.remove();          
        }
      }
      cloneCarSide();
      window.addEventListener('resize', cloneCarSide); 
    }

    // Remove ::before in FAQ table

    if($('.panel-body-table table').length){
      var faqTableTd = $('.panel-body-table table tr');

      faqTableTd.each(function(){

         $(this).find('td').each(function(){
          if($(this).text().trim()==""){
            $(this).addClass('td-empty');
          }
         });
       
      });
    }

      

  });

  // Document Ready End

  /*jQuery(window).scroll(function(event) {
    jQuery('.pac-container').hide();
  });


  jQuery(window).scroll(function(event) {
    if($(window).width() > 800){
      jQuery('#after_dropdown').hide();
      jQuery('.storefinder_cntr').removeClass('click-open');
    }
  });*/


  // Window Load Start
  jQuery(document).ready(function() {

    jQuery('.carpetcall_slide .slider_overlay').hide();
    jQuery('.feature_pro .featured_overlay').hide();

    jQuery('#tag-description').remove();

    // Home Page slider Nav Position
    window.addEventListener("resize", slider_position);
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


///////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////// double tab go js /////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/

;(function($, window, document, undefined) {
	$.fn.doubleTapToGo = function(action) {

		if (!('ontouchstart' in window) &&
			!navigator.msMaxTouchPoints &&
			!navigator.userAgent.toLowerCase().match( /windows phone os 7/i )) return false;

		if (action === 'unbind') {
			this.each(function() {
				$(this).off();
				$(document).off('click touchstart MSPointerDown', handleTouch);	
			});

		} else {
			this.each(function() {
				var curItem = false;
	
				$(this).on('click', function(e) {
					var item = $(this);
					if (item[0] != curItem[0]) {
						e.preventDefault();
						curItem = item;
						if(jQuery(e.target).is('a')){
							//  e.preventDefault();
							  var liParent = $(this);        
					
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
					
							if($(this).find('a').hasClass('show_nav')){
								$(this).find('a').removeClass('show_nav');
							  }else{
								$(this).find('a').addClass('show_nav');
								$('#cssmenu > ul > li.main-menu-item > a.show_nav').removeClass('show_nav');
								$(this).find('a').addClass('show_nav');
							  }
						}
					}
				});
	
				$(document).on('click touchstart MSPointerDown', handleTouch); 
				
				function handleTouch(e) {
					var resetItem = true,
						parents = $(e.target).parents();
	
					for (var i = 0; i < parents.length; i++)
						if (parents[i] == curItem[0])
							resetItem = false;
	
					if(resetItem)
						curItem = false;
				}
			});
		}
		return this;	
	};
})(jQuery, window, document);
jQuery(document).ready(function(e) {
	
    jQuery('#menu-main > li:has(ul)').doubleTapToGo();
});
////////////////////////////////////////////////////////////////////////
