jQuery ( function () {
	// fix the thickbox links in the plugin update screens	
	jQuery('a.thickbox').each(function () {
		var my_href = jQuery(this).attr('href');
		if ( my_href.indexOf('https://goldplugins.com') === 0 ) {
			jQuery(this).removeClass('thickbox')
						.addClass('gp_unboxed')
						.attr('target', '_blank');
		}
	});	
});