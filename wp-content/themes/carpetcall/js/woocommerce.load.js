$=jQuery.noConflict();
function init_slick_slider(){
	if(jQuery('.cat_slider').length){
      jQuery('.cat_slider').slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows:false,        
      });
  }
    }
    
$(function () {
	if( $('[data-toggle="tooltip"]').length){
		$('[data-toggle="tooltip"]').tooltip({html:true});
		}
    init_slick_slider();

 
});
jQuery(document).ready(function($){
jQuery(document).on('focusout','#billing_postcode, #shipping_postcode',function(){
	var postcode = jQuery(this).val();
	if(postcode.match(/^\d{4}$/)){
		jQuery(this).parent('.validate-postcode').removeClass('woocommerce-invalid');
		jQuery(this).parent('.validate-postcode').addClass('woocommerce-validated');
		jQuery(this).parent('.validate-postcode').find('.required').html('*');
		}else{
		jQuery(this).parent('.validate-postcode').addClass('woocommerce-invalid');
		jQuery(this).parent('.validate-postcode').find('.required').html('* Invalid Postcode');
		jQuery(this).parent('.validate-postcode').removeClass('woocommerce-validated');
		return false;
		}
	});
	
jQuery(document).on('focusout','#billing_phone:visible, #shipping_phone:visible',function(){
	var phoneNumber = jQuery(this).val();
	var phoneExpression = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/;
	if (phoneNumber.match(phoneExpression))
	   {
			jQuery(this).parent('.validate-phone').removeClass('woocommerce-invalid');
			jQuery(this).parent('.validate-phone').addClass('woocommerce-validated');
			jQuery(this).parent('.validate-phone').find('.required').html('* Required Field');
	   }else{
			jQuery(this).parent('.validate-phone').addClass('woocommerce-invalid');
			jQuery(this).parent('.validate-phone').find('.required').html('* Invalid Phone');
			jQuery(this).parent('.validate-phone').removeClass('woocommerce-validated');
			return false;
		}
   
	});
	
	
jQuery(document).on('click','#checkout_fetch_nearby_stores',function(){
	var keyword = jQuery('#edit_dialog_keyword').val().trim();
	
	var data = {
			'action': 'get_nearby_stores', 
			'address':keyword,
	};
	//alert(ajaxurl);
	jQuery.post(woo_load_autocomplete.ajax_url, data, function(response) {
		response = jQuery.parseJSON(response);
		jQuery('#nearby_stores_main_wrapper').html(response);
		jQuery('#nearby_stores_main_wrapper').find('.input-radio').wrap('<label class="inner-radio-label"></label');
		jQuery('#nearby_stores_main_wrapper').find('.input-radio').css('opacity','0');
	});
});
jQuery(document).on('click','#checkout_fetch_nearby_stores_currentloc',function(){
	navigator.geolocation.getCurrentPosition(CheckoutCurrentLocation);
	function CheckoutCurrentLocation(position) {
			 lat = position.coords.latitude;
			 lon = position.coords.longitude;
			 
	var data = {
				'action': 'get_nearby_stores', 
				'latitude':lat,
				'longitude':lon,
		};
		//alert(ajaxurl);
		jQuery.post(woo_load_autocomplete.ajax_url, data, function(response) {
			response = jQuery.parseJSON(response);
			jQuery('#nearby_stores_main_wrapper').html(response);
			jQuery('#nearby_store_main_wrapper').find('input[type=radio]').each(function(index, element) {
                if(!jQuery(this).parent().hasClass('inner-radio-label')){
					jQUery(this).wrap('<label class="inner-radio-label"></label>');
					jQuery(element).parent('label')[element.checked?'addClass':'removeClass'](jQuery(element).is(':radio')?'radio-check-label':''); 
					
					}
            });
			});
	}	
	
});

jQuery(document).on('change','.delivery_option_rugs #nearby_stores_main_wrapper .pickup_location_list input[type=radio]',function(e){
			jQuery('.delivery_option_rugs #nearby_stores_main_wrapper .pickup_location_list .inner-radio-label.radio-check-label').removeClass('radio-check-label');
			if(jQuery(this).is(':checked')){
				 jQuery(this).parent('label').addClass('radio-check-label');
				}else{
					jQuery(this).parent('label').removeClass('radio-check-label');
					}
        
	});

jQuery('.acc_list_item .acc_qnty .quantity select.qty').val(0).trigger('click');
if(jQuery("input#price_range_filter").length > 0){
	jQuery("input#price_range_filter").slider().on('slide',(function(ev){
		value = ev.value;
		 jQuery('.range_slider .price_from').text(value[0]);
		 jQuery('.range_slider .price_to').text(value[1]);
		  })
		  ).on('slideStop',function(){
			  		jQuery('.cc-count-clear').show();
					jQuery("#ajax_offset").val(0);
					//jQuery("#child_cat_count").val(1);
					jQuery('#cc_load_more').attr('first','yes');

			  	jQuery('#price_range_filter').val(jQuery('#price_range_filter').attr('data-value'));
	
	  	
				cc_trigger_ajax_load(function(output){
					output = jQuery.parseJSON(output);
					jQuery('#category_slider_block_wrapper').html(output.html);
					jQuery('.cc-cat-title-count .post_count').text(output.found_prod);
						jQuery("#ajax_offset").val(output.offset);
						//jQuery("#child_cat_count").val(output.child_cat_count);
						jQuery('.cat_slider.slick-slider').slick('unslick');
						init_slick_slider();
					});
				
	
	});
}


$ = jQuery.noConflict();
$(document).ready(function() {
 	//$('.cc-quantiy-section #quantity-control #sel_cart').attr('selected','selected');
       // $loadref=$('#store-count-quantity').attr('href');
		
        $('#store-count-quantity, .acc_add_to_cart').attr('href','javascript:void(0)');
          $('#store-count-quantity, .acc_add_to_cart').removeClass('add_to_cart_button');
           $('#store-count-quantity, .acc_add_to_cart').removeClass('ajax_add_to_cart');
        
          
       $(document).on('change','.cc-quantiy-section #quantity-control',function(){
		   $loadref= jQuery('.select-design-product-image.pro-active a.select_design').attr('href');
          $stoq = $('.cc-quantiy-section  #quantity-control').val(); 
		   var sizem2 = jQuery('#sizem2').val(); 
              if($stoq.toLowerCase()!='please select'){
         $('#store-count-quantity').attr('href',$loadref);

          $('#store-count-quantity').addClass('add_to_cart_button');
           $('#store-count-quantity').addClass('ajax_add_to_cart');
            $(".add_to_cart_button").attr('data-quantity',$stoq);
              $(".add_to_cart_button").data('quantity',$stoq);
			  if(sizem2){
				  var total_cov = $stoq*sizem2;
				  jQuery('.total_coverage .coverage_value').text((total_cov.toFixed(2)));
				  jQuery('.acc_list_item.underlay .acc_rec_qty').each(function(index, element) {
                    if(jQuery(this).attr('tpm_ratio')){
						var rec_qty = Math.ceil(Number(total_cov)/Number(jQuery(this).attr('tpm_ratio')));
						jQuery(this).text(rec_qty);
						jQuery(this).parents('.acc_qnty').find('select.qty').val(rec_qty);
						jQuery(this).parents('.acc_qnty').find('select.qty').trigger('change');
						}
                });
				  }
         }
         else{
           /*  $('#store-count-default').show();
          $('#store-count-quantity').hide();*/
         $('#store-count-quantity').attr('href','javascript:void(0)');
          $('#store-count-quantity').removeClass('add_to_cart_button');
           $('#store-count-quantity').removeClass('ajax_add_to_cart');
           
         }
       
        

          });
		
		$(document).on('change','.acc_qnty .quantity select',function(){
			 if(jQuery(this).val().toLowerCase()!='please select'){
				 var target_atc = jQuery(this).parents('.acc_list_item').find('a.acc_add_to_cart');
				 jQuery(target_atc).attr('data-quantity',jQuery(this).val());
				
				jQuery(target_atc).addClass('add_to_cart_button');
           		jQuery(target_atc).addClass('ajax_add_to_cart');
            
			
				 jQuery(target_atc).attr('href', jQuery(target_atc).attr('link'));
				 
//jQuery(this).parents('.acc_list_item').find('a.acc_add_to_cart').attr('data-quantity',jQuery(this).val());
//jQuery(this).parents('.acc_list_item').find('a.acc_add_to_cart').attr('data-quantity',jQuery(this).val());
				 }else{
				 
				 }

			//jQuery(this).parents('.acc_qnty').find('a.acc_add_to_cart').attr('data-quantity',jQuery(this).val());
			});
     


     });


jQuery(document).on('mouseover','.acc_list_item',function(){
	

	});

jQuery(document).find('.main-image-wrapper a.zoom').removeAttr('data-rel');
/*jQuery(document)
.ajaxStart(function(){
	 $("body, banner ").addClass('ovelay_hidden_class'); // Disabling the Scroll while ajax is loading
	jQuery('#loading_overlay_div').show(); // Displaying the Loading gif during ajax call
	})
.ajaxStop(function(){
		jQuery('#loading_overlay_div').hide(); // Hiding the loading gid after ajax call is finished
		$("body ,banner ").removeClass("ovelay_hidden_class");// re-enabling the scroll after ajax request is complete
	});
	
	*/

/*
$(window).scroll(function() {
	if(jQuery('#cc_load_more').is(':visible')){
   	var hT = $('#cc_load_more').offset().top,
       hH = $('#cc_load_more').outerHeight(),
       wH = $(window).height(),
       wS = $(this).scrollTop();
   if (wS > (hT+hH-wH)){
	   jQuery('#cc_load_more').hide();
       jQuery(document).find('#cc_load_more').trigger('click');
   }
		}
});
*/



/*
* Change the main image when thumbnail is clicked in product single page.
*/
jQuery(document).on('click','.select-design-product-image a.select_design',function(e){
	e.preventDefault();
	var url = jQuery(this).attr('href');
	window.history.pushState("object or string", "Title", url);
	 $("body, .banner ").addClass('ovelay_hidden_class');// Disabling the Scroll while ajax is loading
	jQuery('#loading_overlay_div').show(); // Displaying the Loading gif during ajax call

	jQuery.get(url,function(response){
		update_content_from_ajax(response);
			 $("body, .banner ").removeClass('ovelay_hidden_class'); // Disabling the Scroll while ajax is loading
			jQuery('#loading_overlay_div').hide();
			jQuery('#store-count-quantity').attr('href','javascript:void(0)');
          	jQuery('#store-count-quantity').removeClass('add_to_cart_button');
           	jQuery('#store-count-quantity').removeClass('ajax_add_to_cart');
			
		jQuery('.product_single_thumb_slider').slick({
		  dots: true,
		  infinite: true,
		  speed: 300,
		  slidesToShow: 1,
		  adaptiveHeight: true
		});
      		//largeImgMob();
			var bigImg = $(".single-product-thumb-img");      
			$(bigImg).each(function() {
			  var bigImgHref = $(this).attr('href');
			  $(this).find("img").attr("src", bigImgHref);
			});
	
	
		    // Displaying the Loading gif during ajax call

		});
	});	
	
	
	
jQuery(document).on('change','select#cc-size',function(e){
	var url = jQuery(this).val();
	window.history.pushState("object or string", "Title", url);
		  $("body, .banner ").addClass('ovelay_hidden_class'); // Disabling the Scroll while ajax is loading
	jQuery('#loading_overlay_div').show(); // Displaying the Loading gif during ajax call

	jQuery.get(url,function(response){
		update_content_from_ajax(response);
			  $("body, .banner ").removeClass('ovelay_hidden_class');// Disabling the Scroll while ajax is loading
			jQuery('#loading_overlay_div').hide(); // Displaying the Loading gif during ajax call

		//jQuery(document).find(".main-image-wrapper a.zoom").removeAttr('data-rel').prettyPhoto({hook:"data-rel",social_tools:!1,theme:"pp_woocommerce",horizontal_padding:20,opacity:.8,deeplinking:!1});
		});
	});	
	
function update_content_from_ajax(response){
		var images_section = jQuery(response).find('.images').html();
		var summary_entry_summary = jQuery(response).find('.summary.entry-summary').html();
		var tab_accesories = jQuery(response).find('#tab-accesories_tab').html();
		var tab_additional_info = jQuery(response).find('#tab-additional_information').html();
		var tab_specification = jQuery(response).find('#tab-specifications_tab').html();
		var tab_guides = jQuery(response).find('#tab-guides_tab').html();
		var tab_faq = jQuery(response).find('#tab-faq_tab').html();
		var tab_ret = jQuery(response).find('#tab-ret_tab').html();
		var you_may_like =jQuery(response).find('#you_may_like-content').html();
		
		jQuery(document).find('.images').html(images_section);
		jQuery(document).find('.summary.entry-summary').html(summary_entry_summary);
		jQuery(document).find('#tab-accesories_tab').html(tab_accesories);
		jQuery(document).find('#tab-additional_information').html(tab_additional_info);
		jQuery(document).find('#tab-specifications_tab').html(tab_specification);
		jQuery(document).find('#tab-guides_tab').html(tab_guides);
		jQuery(document).find('#tab-faq_tab').html(tab_faq);
		jQuery(document).find('#tab-ret_tab').html(tab_ret);
		jQuery(document).find('#you_may_like-content').html(you_may_like);
		jQuery(document).find(".main-image-wrapper a.zoom").removeAttr('data-rel').prettyPhoto({hook:"data-rel",social_tools:!1,theme:"pp_woocommerce",horizontal_padding:20,opacity:.8,deeplinking:!1});
	}	

jQuery(document).on('click','.single-product .images .thumbnails img',function(e){
	e.preventDefault();
	var img = jQuery(this).parent('a').attr('href');
	jQuery(this).parents('.images').find('.main-image-wrapper .woocommerce-main-image img').attr('srcset',img).attr('src',img);
	jQuery(this).parents('.images').find('.main-image-wrapper a.woocommerce-main-image').attr('href',img);
	});

jQuery(document).on('click','.cc-product-sort a',function(){
		jQuery("#ajax_offset").val(0);
		//jQuery("#child_cat_count").val(1);
		
	});
jQuery(document).on('click','.cc-count-clear',function(){
	jQuery("input#price_range_filter").slider('refresh');
	jQuery('a.clear_color_selection').hide();
	jQuery('img.cc-tick-display').hide();
	jQuery('#selected_colors').val('');
	//jQuery('#child_cat_count').val(1);
	jQuery('#ajax_offset').val(0);
	jQuery('input.price_range').removeAttr('checked');
	jQuery('#price_range_filter').val('');
	jQuery('#selected_shop_range').val('');
	jQuery('input.size_option').removeAttr('checked');
	jQuery('input.shop_range').removeAttr('checked');
	jQuery('#selected_sizes').val('');
	jQuery(this).hide();
	cc_trigger_ajax_load(function(output){
	output = jQuery.parseJSON(output);
	//jQuery('#category_slider_block_wrapper').append(output.html);
	jQuery('#category_slider_block_wrapper').html(output.html);
	jQuery('.cc-cat-title-count .post_count').text(output.found_prod);
	jQuery('.cat_slider.slick-slider').slick('unslick');
	init_slick_slider();
	
	});

	jQuery("#ajax_offset").val(output.offset);

	//jQuery("#child_cat_count").val(output.child_cat_count);

	});
jQuery(document).on('click','a.clear_color_selection',function(){

	jQuery('img.cc-tick-display').hide();
	jQuery('#selected_colors').val('');
	//jQuery('#child_cat_count').val(1);
	jQuery('#ajax_offset').val(0);
	jQuery(this).hide();
	cc_trigger_ajax_load(function(output){
	output = jQuery.parseJSON(output);
	//jQuery('#category_slider_block_wrapper').append(output.html);
	jQuery('#category_slider_block_wrapper').html(output.html);
	jQuery('.cc-cat-title-count .post_count').text(output.found_prod);
	jQuery('.cat_slider.slick-slider').slick('unslick');
	init_slick_slider();
	});
	jQuery("#ajax_offset").val(output.offset);
	//jQuery("#child_cat_count").val(output.child_cat_count);

		});
	
	
jQuery(document).on('click','.cc-color-var-item a.swatch, .cc-shop-range-select .checkbox input[type=checkbox], .cc-size-var-sec .checkbox input[type=checkbox], .cc-product-sort a, .cc-price-var-items .checkbox input[type=checkbox]',function(event){
	jQuery('.cc-count-clear').show();
	//var data = '';
		jQuery("#ajax_offset").val(0);
		//jQuery("#child_cat_count").val(1);
		jQuery('#cc_load_more').attr('first','yes');

	var trig_ele = event.target;
	//console.log(trig_ele);
	if(jQuery(trig_ele).hasClass('swatch') || jQuery(trig_ele).parent().hasClass('swatch')){
		if( jQuery(trig_ele).parent().hasClass('swatch')){
			trig_ele = jQuery(trig_ele).parent();
		}
		jQuery('#selected_colors').val('');
		jQuery(trig_ele).find('img.cc-tick-display').toggle();
		var color_comma_text ='';
		var prepend = '';
		
		if(jQuery('.cc-tick-display:visible').length >0){
			jQuery('.clear_color_selection').show();
			}else{
				jQuery('.clear_color_selection').hide();
			}
		jQuery('.cc-tick-display:visible').each(function(index, element) {
			prepend = (color_comma_text == '')?'':',';
           color_comma_text +=prepend+jQuery(element).parent().attr('id'); 
		   jQuery('#selected_colors').val(color_comma_text);
		  
        });
	cc_trigger_ajax_load(function(output){
		output = jQuery.parseJSON(output);
		jQuery('#category_slider_block_wrapper').html(output.html);
		jQuery('.cc-cat-title-count .post_count').text(output.found_prod);
			jQuery("#ajax_offset").val(output.offset);
			//jQuery("#child_cat_count").val(output.child_cat_count);
		jQuery('.cat_slider.slick-slider').slick('unslick');
		init_slick_slider();
	});
	 //console.log(jQuery('.cc-tick-display:visible'));
	}/*else if(jQuery(trig_ele).hasClass('price_range')){
		jQuery('.price_range').each(function(index, element) {
            jQuery(this).prop('checked','');
        });
		jQuery(trig_ele).prop('checked','checked');
		jQuery('#selected_price_ranges').val(jQuery(trig_ele).val());
	cc_trigger_ajax_load(function(output){
	output = jQuery.parseJSON(output);
	jQuery('#category_slider_block_wrapper').html(output.html);
			jQuery("#ajax_offset").val(output.offset);
			jQuery("#child_cat_count").val(output.child_cat_count);
	jQuery('.cat_slider.slick-slider').slick('unslick');
	init_slick_slider();
	});
}*/else if(jQuery(trig_ele).hasClass('size_option')){
		jQuery('#selected_sizes').val('');
		var size_comma_text ='';
		var prepend = '';
		jQuery('.size_option:checked').each(function(index, element) {
			//console.log(jQuery(element).val());
			prepend = (size_comma_text == '')?'':',';
           size_comma_text +=prepend+jQuery(element).val(); 
		   jQuery('#selected_sizes').val(size_comma_text);
		});
	cc_trigger_ajax_load(function(output){
	output = jQuery.parseJSON(output);
	jQuery('#category_slider_block_wrapper').html(output.html);
	jQuery('.cc-cat-title-count .post_count').text(output.found_prod);
			jQuery("#ajax_offset").val(output.offset);
			//jQuery("#child_cat_count").val(output.child_cat_count);
	jQuery('.cat_slider.slick-slider').slick('unslick');
	init_slick_slider();
	});
	}else if(jQuery(trig_ele).hasClass('shop_range')){
		jQuery('#selected_shop_range').val('');
		var shop_range_comma_text ='';
		var prepend = '';
		jQuery('.shop_range:checked').each(function(index, element) {
			//console.log(jQuery(element).val());
			prepend = (shop_range_comma_text == '')?'':',';
           shop_range_comma_text +=prepend+jQuery(element).val(); 
		   jQuery('#selected_shop_range').val(shop_range_comma_text);
		});
	cc_trigger_ajax_load(function(output){
	output = jQuery.parseJSON(output);
	jQuery('#category_slider_block_wrapper').html(output.html);
	jQuery('.cc-cat-title-count .post_count').text(output.found_prod);
			jQuery("#ajax_offset").val(output.offset);
			//jQuery("#child_cat_count").val(output.child_cat_count);
	jQuery('.cat_slider.slick-slider').slick('unslick');
	init_slick_slider();
	});
	
		}
else if(jQuery(trig_ele).parent().hasClass('sort_key')){
	jQuery('.sort_key').removeClass('cc-count-active');
	jQuery(trig_ele).parent('li').addClass('cc-count-active');
	
	var sort_key = jQuery(this).attr('sort');
	jQuery('#ajax_sort_order').val('ASC');
	if(sort_key == 'popular'){
		jQuery('#ajax_sort_by').val('popular');
		jQuery('#ajax_sort_order').val('DESC');
		}else if(sort_key == 'price_low'){
			jQuery('#ajax_sort_by').val('price');
			}else if(sort_key == 'price_high'){
				jQuery('#ajax_sort_by').val('price');
				jQuery('#ajax_sort_order').val('DESC');
				}
	cc_trigger_ajax_load(function(output){
	output = jQuery.parseJSON(output);
	jQuery('#category_slider_block_wrapper').html(output.html);
	jQuery('.cc-cat-title-count .post_count').text(output.found_prod);
			jQuery("#ajax_offset").val(output.offset);
			//jQuery("#child_cat_count").val(output.child_cat_count);
	jQuery('.cat_slider.slick-slider').slick('unslick');
	init_slick_slider();
	});	
	}

	//cc_trigger_ajax_load();

	});
jQuery("#cc_load_more").click(function(e) {
	
	//$("body, .banner ").addClass('ovelay_hidden_class'); // Disabling the Scroll while ajax is loading
	//jQuery('#loading_overlay_div').show(); // Displaying the Loading gif during ajax call


var perpage  = jQuery('#perpage_var').val();
cc_trigger_ajax_load(function(output){
output = jQuery.parseJSON(output);
/*
var is_first = jQuery("#cc_load_more").attr('first');
if(is_first == 'yes'){
	jQuery('#category_slider_block_wrapper').html(output.html);
	}else{
	jQuery('#category_slider_block_wrapper').append(output.html);
	}
	*/
jQuery('#category_slider_block_wrapper').append(output.html);
var prev_cnt = parseInt(jQuery('.cc-cat-title-count .post_count').html());
var new_found = parseInt(output.found_prod);
var newsum = prev_cnt+new_found;
jQuery('.cc-cat-title-count .post_count').html(newsum);
jQuery("#cc_load_more").attr('first','no');	

//jQuery("#child_cat_count").val(output.child_cat_count);
jQuery("#ajax_offset").val(output.offset);
jQuery('.cat_slider.slick-slider').slick('unslick');
init_slick_slider();
//$("body, .banner ").removeClass('ovelay_hidden_class'); // Disabling the Scroll while ajax is loading
//jQuery('#loading_overlay_div').hide(); // Displaying the Loading gif during ajax call
	});

});
function cc_trigger_ajax_load(handleData){
$("body, .banner ").addClass('ovelay_hidden_class'); // Disabling the Scroll while ajax is loading
jQuery('#loading_overlay_div').show(); // Displaying the Loading gif during ajax call
	var perpage  = jQuery('#perpage_var').val();
	var cat_id = $("#ajax_cat_id").val();
	//var child_cat_count = $('#child_cat_count').val();
	var offset = $("#ajax_offset").val();
	var sort_by  = $("#ajax_sort_by").val();
	var sort_order  = $("#ajax_sort_order").val();
	var depth  = $("#cat_depth").val();
	var selected_colors  = $("#selected_colors").val();
	var selected_sizes  = $("#selected_sizes").val();
	var shop_ranges		= jQuery('#selected_shop_range').val();
	var selected_price_ranges  = $("#price_range_filter").val();
	var data = {
				'action': jQuery('#cc_load_more').attr('callto'), 
				'perpage':perpage,
				'cat_id':cat_id,
				//'child_cat_count':child_cat_count,
				'offset':offset,
				'sort_by':sort_by,
				'sort_order':sort_order,
				'depth':depth,
				'color':selected_colors,
				'size':selected_sizes,
				'price':selected_price_ranges,
				's': jQuery('#search_query').val(),
				'shop_range':shop_ranges,
		};
		//alert(ajaxurl);
		jQuery.post(woo_load_autocomplete.ajax_url, data, function(response) {
			output = jQuery.parseJSON(response);
			if(output.html == ''){
//				var myObject = new Object();
//				myObject.html = "";
//				myObject.child_cat_count = output.child_cat_count;
//				myObject.offset = output.offset;
//				myObject = JSON.stringify(myObject);
//				response = myObject;
				jQuery('#cc_load_more').attr('disabled','disabled').val('No More Products');
				}else{
					jQuery('#cc_load_more').removeAttr('disabled').val('Load More');
					}
			handleData(response);
			
		}).done(function(){
	$("body, .banner ").removeClass('ovelay_hidden_class'); // Disabling the Scroll while ajax is loading
	jQuery('#loading_overlay_div').hide(); // Displaying the Loading gif during ajax call
	if(output.found_prod == 0){
		jQuery('#cc_load_more').hide();
		}else{
			jQuery('#cc_load_more').show();
			}		
			});

	}
});
jQuery(document).ready(function(e) {
    jQuery('abbr.required').each(function(index, element) {
   // jQuery(this).html('* Requird Field');
});

});