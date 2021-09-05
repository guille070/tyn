jQuery(document).ready(function($) {
	if(!window.$) window.$ = jQuery; // $ Global
	
	$(".owl-carousel.logos-cpartners").owlCarousel({
		items: 5,
		loop: true,
		dots: false,
		autoplay: true,
		autoplayTimeout: 1500,
		//autoHeight: true
	});

});