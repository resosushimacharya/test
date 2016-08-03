jQuery(document).ready(function($){
	
jQuery('.cc-color-var-item a.swatch, .cc-price-var-sec .checkbox input[type=checkbox], .cc-size-var-sec .checkbox input[type=checkbox]').on('click',function(event){
	var data = '';
	$("#ajax_offset").val(0);
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
		//jQuery("#child_cat_count").val(1);
	
	});
	 //console.log(jQuery('.cc-tick-display:visible'));
	}else if(jQuery(trig_ele).hasClass('price_range')){
		jQuery('#selected_price_ranges').val('');
		var price_range_comma_text ='';
		var prepend = '';
		jQuery('.price_range:checked').each(function(index, element) {
			console.log(jQuery(element).val());
			prepend = (price_range_comma_text == '')?'':',';
           price_range_comma_text +=prepend+jQuery(element).val(); 
		   jQuery('#selected_price_ranges').val(price_range_comma_text);
		});
	cc_trigger_ajax_load(function(output){
	output = jQuery.parseJSON(output);
	jQuery('#category_slider_block_wrapper').html(output.html);
	jQuery('.cat_slider.slick-slider').slick('unslick');
	init_slick_slider();
	//jQuery("#child_cat_count").val(1);
	});
}else if(jQuery(trig_ele).hasClass('size_option')){
			//alert('size');
	}

	//cc_trigger_ajax_load();

	});
jQuery("#cc_load_more").click(function(e) {
//$("#ajax_offset").val(parseInt($("#ajax_offset").val())+1);
var perpage  = 1;
$("#ajax_offset").val(parseInt($("#ajax_offset").val())+perpage);
cc_trigger_ajax_load(function(output){
output = jQuery.parseJSON(output);
jQuery('#category_slider_block_wrapper').append(output.html);
jQuery("#child_cat_count").val(output.child_cat_count);
jQuery('.cat_slider.slick-slider').slick('unslick');
init_slick_slider();
	});

});
function cc_trigger_ajax_load(handleData){
	var perpage  = 1;
	var cat_id = $("#ajax_cat_id").val();
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