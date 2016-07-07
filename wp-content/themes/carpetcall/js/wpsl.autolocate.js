jQuery(document).ready(function($){
jQuery(".cc-map-control").click(function(e) {
	jQuery.ajax({
			url: cc_map_autolocate.ajax_url,
			type: 'POST',
			data: {
				check:'hello',
				
				action: 'cc_map_autolocate_func'
				
			},
			success:function(data){				
				//jQuery('.woo-added').html(data);
				
				location.reload();
				  

			}
		});

});
jQuery(".cc-map-control-finder").click(function(e) {
	jQuery.ajax({
			url: cc_map_autolocate.ajax_url,
			type: 'POST',
			data: {
				check:'hello',
				
				action: 'cc_map_autolocate_func'
				
			},
			success:function(data){				
				//jQuery('.woo-added').html(data);
				
				window.location.href=site_url+'/carpet-call-stores/';
				  

			}
		});

});
});
