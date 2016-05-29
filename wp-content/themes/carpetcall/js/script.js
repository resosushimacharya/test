( function( $ ) {
$( document ).ready(function() {
$('#cssmenu').prepend('<div id="menu-button">Menu</div>');
	$('#cssmenu #menu-button').on('click', function(){
		var menu = $(this).next('ul');
		if (menu.hasClass('open')) {
			menu.removeClass('open');
		}
		else {
			menu.addClass('open');
		}
	});
});
} )( jQuery );
$(document).ready(function(e) {
    $('#storefinder_btn').click(function(){
		$(this).parent('.dropdown').toggleClass('click-open');
	})
	$(document).on('click',function(event) { 	
		if(!$(event.target).closest('.storefinder_cntr').length &&
		   !$(event.target).is('.storefinder_cntr')) {
			if($('.storefinder_cntr').is(":visible")) {
				$('.storefinder_cntr').removeClass('click-open');
			}
		}        
	});
	
	$(document).on('click','.dropdown-toggle',function(){
		$('.storefinder_cntr').removeClass('click-open');
	})
	
	
});
jQuery(window).load(function(){

	jQuery('.carpetcall_slide .slider_overlay').hide();
	jQuery('.feature_pro .featured_overlay').hide();

});



