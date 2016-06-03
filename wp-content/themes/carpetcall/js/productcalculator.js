function autocomplet() {
	var min_length = 0; // min caracters to display the autocomplete
	/*var str1.localeCompare(str2)*/
	var str1 = "";

	var keyword = jQuery('#dir_keyword').val();
		alert(keyword );
	if(keyword !="" || keyword!=null ){
	if (keyword.length >= min_length) {
		jQuery.ajax({
			url: wp_product_calculator.ajax_url,
			type: 'POST',
			data: {
				keyword:keyword,latitude:rs[0],
				longitude:rs[1],
				action: 'fun_product_calculator'
				
			},
			success:function(data){
				jQuery('#product_calculator_id').show();
				jQuery('#product_calculator_id').html(data);
			}
		});
	} else {
		jQuery('#product_calculator_id').hide();
	}
}
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	jQuery('#dir_keyword').val(item);
	// hide proposition list
	jQuery('product_calculator_id').hide();
} 