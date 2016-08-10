jQuery(document).ready(function($){

jQuery(document)
.ajaxStart(function(){
	 $("body").css("overflow","hidden"); // Disabling the Scroll while ajax is loading
	jQuery('#loading_overlay_div').show(); // Displaying the Loading gif during ajax call
	})
.ajaxStop(function(){
		jQuery('#loading_overlay_div').hide(); // Hiding the loading gid after ajax call is finished
		$("body").css("overflow","auto");// re-enabling the scroll after ajax request is complete
	});


$(window).scroll(function() {
	if(jQuery('#cc_load_more').is(':visible')){
   	var hT = $('#cc_load_more').offset().top,
       hH = $('#cc_load_more').outerHeight(),
       wH = $(window).height(),
       wS = $(this).scrollTop();
   if (wS > (hT+hH-wH)){
	   jQuery('#cc_load_more').hide();
	   $("body").css("overflow","hidden");
       jQuery(document).find('#cc_load_more').trigger('click');
	   
   }
		}
});


/*
* Change the main image when thumbnail is clicked in product single page.
*/
jQuery(document).on('click','.select-design-product-image a.select_design',function(e){
	e.preventDefault();
	var url = jQuery(this).attr('href');
	window.history.pushState("object or string", "Title", url);
	
	jQuery.get(url,function(response){
		document.getElementsByTagName('html')[0].innerHTML = response
		});
	});	
jQuery(document).on('change','select#cc-size',function(e){
	var url = jQuery(this).val();

	window.history.pushState("object or string", "Title", url);
	jQuery.get(url,function(response){
		document.getElementsByTagName('html')[0].innerHTML = response
		});
	});	
	
jQuery(document).on('click','.single-product .images .thumbnails img',function(e){
	e.preventDefault();
	var img = jQuery(this).attr('src');
	jQuery(this).parents('.images').find('.main-image-wrapper .woocommerce-main-image img').attr('srcset',img).attr('src',img);
	});


jQuery(document).on('click','.cc-product-sort a',function(){
		jQuery("#ajax_offset").val(0);
		jQuery("#child_cat_count").val(1);
		

	});
jQuery(document).on('click','.cc-count-clear',function(){
	jQuery('img.cc-tick-display').hide();
	jQuery('#selected_colors').val('');
	jQuery('input.price_range').removeAttr('checked');
	jQuery('#selected_price_ranges').val('');
	jQuery('input.size_option').removeAttr('checked');
	jQuery('#selected_sizes').val('');
	jQuery(this).hide();
	cc_trigger_ajax_load(function(output){
	output = jQuery.parseJSON(output);
	jQuery('#category_slider_block_wrapper').html(output.html);
	jQuery('.cat_slider.slick-slider').slick('unslick');
	init_slick_slider();
	});

	jQuery("#ajax_offset").val(0);
	jQuery("#child_cat_count").val(1);

	});
	
	
jQuery(document).on('click','.cc-color-var-item a.swatch, .cc-price-var-sec .checkbox input[type=checkbox], .cc-size-var-sec .checkbox input[type=checkbox], .cc-product-sort a, .cc-price-var-items .checkbox input[type=checkbox]',function(event){
	jQuery('.cc-count-clear').show();
	//var data = '';
		jQuery("#ajax_offset").val(0);
		jQuery("#child_cat_count").val(1);
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
		jQuery('.cc-tick-display:visible').each(function(index, element) {
			prepend = (color_comma_text == '')?'':',';
           color_comma_text +=prepend+jQuery(element).parent().attr('id'); 
		   jQuery('#selected_colors').val(color_comma_text);
		  
        });
	cc_trigger_ajax_load(function(output){
		output = jQuery.parseJSON(output);
		jQuery('#category_slider_block_wrapper').html(output.html);
		jQuery('.cat_slider.slick-slider').slick('unslick');
		init_slick_slider();
	});
	 //console.log(jQuery('.cc-tick-display:visible'));
	}else if(jQuery(trig_ele).hasClass('price_range')){
		jQuery('.price_range').each(function(index, element) {
            jQuery(this).prop('checked','');
        });
		jQuery(trig_ele).prop('checked','checked');
		jQuery('#selected_price_ranges').val(jQuery(trig_ele).val());
		/*
		jQuery('#selected_price_ranges').val('');
		var price_range_comma_text ='';
		var prepend = '';
		jQuery('.price_range:checked').each(function(index, element) {
			console.log(jQuery(element).val());
			prepend = (price_range_comma_text == '')?'':',';
           price_range_comma_text +=prepend+jQuery(element).val(); 
		   jQuery('#selected_price_ranges').val(price_range_comma_text);
		});
		
		*/
		
		
	cc_trigger_ajax_load(function(output){
	output = jQuery.parseJSON(output);
	jQuery('#category_slider_block_wrapper').html(output.html);
	jQuery('.cat_slider.slick-slider').slick('unslick');
	init_slick_slider();
	});
}else if(jQuery(trig_ele).hasClass('size_option')){
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
	jQuery('.cat_slider.slick-slider').slick('unslick');
	init_slick_slider();
	});	
	}

	//cc_trigger_ajax_load();

	});
jQuery("#cc_load_more").click(function(e) {
//$("#ajax_offset").val(parseInt($("#ajax_offset").val())+1);
	var perpage  = jQuery('#perpage_var').val();
//$("#ajax_offset").val(parseInt($("#ajax_offset").val())+perpage);
cc_trigger_ajax_load(function(output){
output = jQuery.parseJSON(output);
var is_first = jQuery("#cc_load_more").attr('first');
if(is_first == 'yes'){
	jQuery('#category_slider_block_wrapper').html(output.html);
	}else{
	jQuery('#category_slider_block_wrapper').append(output.html);
	}
jQuery("#cc_load_more").attr('first','no');	

jQuery("#child_cat_count").val(output.child_cat_count);
jQuery("#ajax_offset").val(output.offset);
jQuery('.cat_slider.slick-slider').slick('unslick');
init_slick_slider();
	});

});
function cc_trigger_ajax_load(handleData){
	var perpage  = jQuery('#perpage_var').val();
	var cat_id = $("#ajax_cat_id").val();
	var child_cat_count = $('#child_cat_count').val();
	var offset = $("#ajax_offset").val();
	var sort_by  = $("#ajax_sort_by").val();
	var sort_order  = $("#ajax_sort_order").val();
	var depth  = $("#cat_depth").val();
	var selected_colors  = $("#selected_colors").val();
	var selected_sizes  = $("#selected_sizes").val();
	var selected_price_ranges  = $("#selected_price_ranges").val();
	
	var data = {
				'action': 'show_category_slider_block' , 
				'perpage':perpage,
				'cat_id':cat_id,
				'child_cat_count':child_cat_count,
				'offset':offset,
				'sort_by':sort_by,
				'sort_order':sort_order,
				'depth':depth,
				'color':selected_colors,
				'size':selected_sizes,
				'price':selected_price_ranges,
		};
		//alert(ajaxurl);
		jQuery.post(woo_load_autocomplete.ajax_url, data, function(response) {
			output = jQuery.parseJSON(response);
			if(output.html == ''){
				var myObject = new Object();
				myObject.html = "<div><strong> No more results found !! </strong> </div>";
				myObject.child_cat_count = output.child_cat_count;
				myObject.offset = output.offset;
				myObject = JSON.stringify(myObject);
				response = myObject;
				jQuery('#cc_load_more').attr('disabled','disabled').hide();
				}else{
					jQuery('#cc_load_more').removeAttr('disabled').show();
					}
			handleData(response);
		});
		
		
	/*jQuery.ajax({
			url: woo_load_autocomplete.ajax_url,
			type: 'POST',
			data: {
				perpage:perpage,
				cat_id:cat_id,
				offset:offset,
				sort_by:sort_by,
				sort_order:sort_order,
				depth:depth,
				color:selected_colors,
				size:selected_sizes,
				price:selected_price_ranges,
				action: 'show_category_slider_block'
				
			},
			success:function(data){
				
			}
		});*/
	
	}
});