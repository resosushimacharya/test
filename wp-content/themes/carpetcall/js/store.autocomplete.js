function autocomplet() {
	var min_length = 0; // min caracters to display the autocomplete
	
	var keyword = jQuery('#dir_keyword').val();

	if(keyword){
	if (keyword.length >= min_length) {
		jQuery.ajax({
			url: wp_autocomplete.ajax_url,
			type: 'POST',
			data: {
				keyword:keyword,
				latitude:rs[0],
				longitude:rs[1],
				action: 'dir_autocmp'
				
			},
			success:function(data){
				
				jQuery("#after_dropdown").css("background-color"," #e7edf8");
				jQuery('#after_location').hide();
				jQuery('#after_browse').hide();
				jQuery('#before_heading').hide();
				jQuery('#after_heading').show();
				jQuery('#directory_list_id').hide();
				jQuery('#directory_list_id_s').show();
				jQuery('#directory_list_id_s').html(data);
			}
		});
	} else {
		jQuery('#directory_list_id_s').hide();
	}}
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	jQuery('#dir_keyword').val(item);
	// hide proposition list
	jQuery('#directory_list_id_s').hide();
} 