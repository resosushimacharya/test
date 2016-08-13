jQuery(document).ready(function($){
jQuery(document).on('change' ,"#cc-store-name",function(e) {

var store= jQuery("#cc-store-name").val();
 


	jQuery.ajax({
			url: wp_email_address_autocomplete.ajax_url,
			type: 'POST',
			data: {
				store:store,
				action: 'email_address'
				
			},
			success:function(data){
				
				
				 jQuery('#send_email_address').val(data);

			}
		});

});
});
jQuery(document).ready(function($){
jQuery("#cc-state-type-only").change(function(e) {

var staterel= jQuery("#cc-state-type-only").val();
 


	jQuery.ajax({
			url: wp_email_address_state_autocomplete.ajax_url,
			type: 'POST',
			data: {
				staterel:staterel,
				action: 'email_address_state'
				
			},
			success:function(data){
				
				
				 jQuery('#send_email_address').val(data);

			}
		});

});
});