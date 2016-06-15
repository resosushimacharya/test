jQuery(document).ready( function() {
	jQuery( '#wpsl_store_categorychecklist li').click( function() {
		alert( jQuery(this).children('input[type=checkbox]').val() );
	});
});