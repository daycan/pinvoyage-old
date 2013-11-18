// pinvoyage script.js
$(document).ready(function() {
	
	$('.show_on_hover').hide();
	
	$('.thumbnail').mouseenter(function() {
       $(this).find('.show_on_hover').show('fast');
   });
   
   $('.thumbnail').mouseleave(function() {
       $(this).find('.show_on_hover').hide();
   });
   
   $('#expand_map_button').click(function() {
	   $('#add_pin_button').fadeOut(1000);
   });


});


