<?php
/**
    * Fichero PHP
    *
    * Option pages related functions
    *
    * @copyright Copyright (c) 2020 Dandy Agency
*/

/**
* ACF Options page
*/
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> __('Opciones Generales del Tema', THEME_TEXTDOMAIN),
		'menu_title'	=> __('Opciones Generales', THEME_TEXTDOMAIN),
		'menu_slug' 	=> 'theme-general-settings',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Opciones del Footer', THEME_TEXTDOMAIN),
		'menu_title'	=> __('Footer', THEME_TEXTDOMAIN),
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> __('Scripts', THEME_TEXTDOMAIN),
		'menu_title'	=> __('Scripts', THEME_TEXTDOMAIN),
		'parent_slug'	=> 'theme-general-settings',
	));
	
}
?>
