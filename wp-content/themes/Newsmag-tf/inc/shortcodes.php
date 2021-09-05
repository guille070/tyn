<?php

//Content Partners logos grid
function cpartners_logos_grid( $atts , $content = null ) {
	ob_start();

	get_template_part( 'template-parts/cpartners-logos-grid' );
	
	return ob_get_clean();
}
add_shortcode( 'cpartners_logos_grid', 'cpartners_logos_grid' );


//Content Partners logos slide
function cpartners_logos_slide( $atts , $content = null ) {
	ob_start();

	get_template_part( 'template-parts/cpartners-logos-slide' );
	
	return ob_get_clean();
}
add_shortcode( 'cpartners_logos_slide', 'cpartners_logos_slide' );



?>