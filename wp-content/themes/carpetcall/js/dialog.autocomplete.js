function autocomplet_dialog() {

	var min_length = 0; // min caracters to display the autocomplete
	jQuery('#alert_msg').remove();
	var keyword = jQuery('#edit_dialog_keyword').val().trim();
	
     if((typeof diaLocation[0] == 'undefined' || rs[0]==null)){
     	jQuery("#edit_dialog_keyword").parent().parent().prepend('<h5 id="alert_msg">Please enter suburb or postcode.</h5>');
         
     }
      if(keyword!="" && keyword!=null && keyword.length>3 && (typeof diaLocation[0] != 'undefined')||rs[0]!=null)
	    {
	    	jQuery("#alert_msg").remove();
		jQuery.ajax({
			url: dialog_autocomplete_one.ajax_url,
			type: 'POST',
			data: {
				keyword:keyword,
				latitude:rs[0],
				longitude:rs[1],
				prelat:diaLocation[0],
				prelong:diaLocation[1],
				action: 'dialog_autocmp'
				
			},
			success:function(data){
				
				jQuery("#edit_dialog_keyword").val('');
				jQuery('#dialog_list_id_s').show();
				jQuery('#dialog_list_id_s').html(data);
				jQuery("#edit_dialog_keyword").focus();
             rs= null;
             stoLocation = [];
				  

			}
		});}
	
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	jQuery('#dir_keyword').val(item);
	// hide proposition list
	jQuery('#directory_list_id_s').hide();
} 