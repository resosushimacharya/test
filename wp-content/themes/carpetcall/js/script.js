(function($) {
    $(document).ready(function() {
        $('#cssmenu').prepend('<div id="menu-button">Menu</div>');
        $('#cssmenu #menu-button').on('click', function() {
            var menu = $(this).next('ul');
            if (menu.hasClass('open')) {
                menu.removeClass('open');
            } else {
                menu.addClass('open');
            }
        });
    });
})(jQuery);
$(document).ready(function(e) {
    $('#storefinder_btn').hover(function() {
        $(this).parent('.dropdown').toggleClass('click-open');
        $("#after_dropdown").show();
        $("#storefinder_id").addClass('click-open');

    })
    $(document).on('hover', function(event) {
        if (!$(event.target).closest('.storefinder_cntr').length &&
            !$(event.target).is('.storefinder_cntr')) {
            if ($('.storefinder_cntr').is(":visible")) {
                $('.storefinder_cntr').removeClass('click-open');
            }
        }
    });



    $(document).mouseup(function(e) {
        var container = $("#after_dropdown");

        if (!container.is(e.target) // if the target of the click isn't the container...
            &&
            container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.hide();
            $('.storefinder_cntr').removeClass('click-open');
        }
    });

    $(document).on('click', '.dropdown-toggle', function() {
        $('.storefinder_cntr').removeClass('click-open');
    });


});
jQuery(window).load(function() {

    jQuery('.carpetcall_slide .slider_overlay').hide();
    jQuery('.feature_pro .featured_overlay').hide();

});
$(window).scroll(function(event) {
    jQuery('.pac-container').hide();
});
   $(window).scroll(function(event) {
    jQuery('#after_dropdown').hide();
      $('.storefinder_cntr').removeClass('click-open');
});