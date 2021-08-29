<?php
/*
Plugin Name: Custom Banners Pro
Plugin Script: custom-banners-pro.php
Plugin URI: http://goldplugins.com/our-plugins/custom-banners-pro/
Description: Pro Addon for Custom Banners. Requires the Custom Banners plugin.
Version: 3.0.1
Author: Gold Plugins
Author URI: http://goldplugins.com/
*/

add_action( 'custom_banners_bootstrap', 'custom_banners_pro_init' );

function custom_banners_pro_init()
{
	require_once('include/Custom_Banners_Pro_Plugin.php');
	//require_once('include/lib/BikeShed/bikeshed.php');
		
	$custom_banners_pro = new Custom_Banners_Pro_Plugin( __FILE__ );

	// create an instance of BikeShed that we can use later
	global $Custom_Banners_BikeShed;
	if ( is_admin() && empty($Custom_Banners_BikeShed) ) {
		//$Custom_Banners_BikeShed = new Custom_Banners_GoldPlugins_BikeShed();
	}
}

function custom_banners_pro_activation_hook()
{
	set_transient('custom_banners_pro_just_activated', 1);
}
add_action( 'activate_custom-banners-pro/custom-banners-pro.php', 'custom_banners_pro_activation_hook' );
