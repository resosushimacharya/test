jQuery(document).ready(function($){
jQuery("#cc-store-name").change(function(e) {

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