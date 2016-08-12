/**
*acoordion for faqs
*/
jQuery(window).load(function() {

    $('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".glyphicon-chevron-down").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".glyphicon-chevron-up").removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
});

});

$('.cc-cat-store-item-phone a ').attr('href',"tel:hello");
alert("hello")

