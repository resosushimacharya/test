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
				
				window.location.href=site_url+'/find-a-store/';
				  

			}
		});

});
});
    function mymapwpsl(e) {
        var input = document.getElementById('wpsl-search-input');
       var options = { types: ['geocode'],componentRestrictions: {country: "AU"} };
        var types = document.getElementById('type');
      var check = input.value;
        e.which = e.which || e.keyCode;
   
       
        var autocomplete = new google.maps.places.Autocomplete(input,options);
      //  console.log(autocomplete);
      

        
        autocomplete.addListener('place_changed', function() {
         
          var place = autocomplete.getPlace();
           stoLocation.push(place);
          stoLocation = [place.geometry.location.lat(),place.geometry.location.lng()];
          //input.value="";

         
          if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
          }

          
          

         
        });
      document.addEventListener("keydown", KeyCheck);
       


       
      }