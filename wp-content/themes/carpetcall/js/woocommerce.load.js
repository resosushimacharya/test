jQuery(document).ready(function($){
jQuery("#cc_load_more").click(function(e) {
alert($("#cc_count").val());
var cc_count = $("#cc_count").val();
	jQuery.ajax({
			url: woo_load_autocomplete.ajax_url,
			type: 'POST',
			data: {
				cc_count:cc_count,
				action: 'woo_load'
				
			},
			success:function(data){
				alert("hello");
				
				  

			}
		});

});
});