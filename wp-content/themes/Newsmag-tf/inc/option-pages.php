<?php

add_action('acf/init', 'ntm_options_page');
function ntm_options_page() {
	
	if( function_exists('acf_add_options_page') ) {
		
		$option_page = acf_add_options_page(array(
			'page_title'  => 'Opciones Generales',
			'menu_title'  => 'Opciones Generales',
			'menu_slug'   => 'theme-general-settings',
			'icon_url'    => 'dashicons-admin-settings',
		));
		
	}
	
}