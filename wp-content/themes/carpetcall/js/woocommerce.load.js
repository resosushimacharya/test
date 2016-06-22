jQuery(document).ready(function($){
jQuery("#cc_load_more").click(function(e) {
alert($("#cc_count").val());

var cc_count = $("#cc_count").val();
var cc_catname = $("#category_name").val();
var cc_catid  = $("#category_id").val();
	jQuery.ajax({
			url: woo_load_autocomplete.ajax_url,
			type: 'POST',
			data: {
				count:cc_count,
				catname:cc_catname,
				catid:cc_catid,
				action: 'woo_load'
				
			},
			success:function(data){
				
				jQuery('.woo-added').html(data);
				  

			}
		});

});
});