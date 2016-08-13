jQuery(document).ready(function($){

jQuery(document).on('change',"#cc-state-type", function(e) {


var state = jQuery("#cc-state-type").val();


	jQuery.ajax({
			url: wp_contact_store_autocomplete.ajax_url,
			type: 'POST',
			data: {
				state:state,
				action: 'contact_store_control'
				
			},
			success:function(data){
				
				jQuery('#cc-store-name').html(data);
				  

			}
		});

});
});
