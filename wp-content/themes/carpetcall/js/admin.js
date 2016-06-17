/*
	* customizing WP Store Locator edit page
	* make State field readonly
	* on Category selection , populate Category name to State field
*/
jQuery(document).ready(function( $ ) {
	if( $('#wpsl-state').length ) {
		// make State field readonly
		$('#wpsl-state').attr( 'readonly' , 'readonly' );

		// on Category change , assign to State
		$('#wpsl_store_category_taxradiolist li').click(function() {
			var state = $(this).text().trim();

			if( state.length > 4 ) state = '';
			
			// populate State field
			$('#wpsl-state').val( state );
		});
	}
});