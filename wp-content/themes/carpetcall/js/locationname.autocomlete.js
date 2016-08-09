function autocomplet() {

	
	

			jQuery.ajax({
				url: location_autocomplete.ajax_url,
				type: 'POST',
				data: {
					keyword:keyword,
					latitude:rs[0],
					longitude:rs[1],
					
					action: 'location_autocmp'				
			},
			success:function(data){
				
				jQuery("#edit_dir_keyword").val('');
				
				jQuery("#after_heading").css("color","#1858b8");
				jQuery("#after_dropdown").css("background-color"," #e7edf8");
				jQuery('#after_location').hide();
				jQuery('#after_browse').hide();
				jQuery('#before_heading').hide();
				jQuery('#after_heading').show();
				jQuery('#directory_list_id').show();
				jQuery('#directory_list_id_s').show();
				jQuery('#directory_list_id_s').html(data);
				jQuery("#edit_dir_keyword").focus();
             rs= null;
             stoLocation = [];
				  

			}
		
	
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	jQuery('#dir_keyword').val(item);
	// hide proposition list
	jQuery('#directory_list_id_s').hide();
} 