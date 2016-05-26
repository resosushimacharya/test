function storecomplet() {
	var min_length = 1; // min caracters to display the autocomplete
	
	var keyword = jQuery('#dir_keyword').val();
	
	
	if (keyword.length >= min_length) {
		jQuery.ajax({
			url: wp_autocomplete_store.ajax_url,
			type: 'POST',
			data: {
				keyword:keyword,
				action: 'dir_store',
				latitude:rs[0],
				longitude:rs[1]
			},
			success:function(data){
				jQuery('#before_heading').hide();
				jQuery('#after_heading').show();
				jQuery('#directory_list_id').hide();
				jQuery('#directory_list_id').html(data);
			}
		});
	} else {
		jQuery('#directory_list_id').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_store(item) {
	// change input value
	jQuery('#dir_keyword').val(item);
	// hide proposition list
	jQuery('#directory_list_id').hide();
}