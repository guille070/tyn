<?php
	require_once('lib/GP_Plugin_Updater/GP_Plugin_Updater.php');
	require_once('lib/GP_Galahad/GP_Galahad.php');
	require_once('lib/logging/cbp_tracker.php');

	define('COMPANY_DIRECTORY_PRO_PLUGIN_ID', 6998);
	define('COMPANY_DIRECTORY_PRO_STORE_URL', 'https://goldplugins.com');

	class Custom_Banners_Pro_Factory
	{		
		/*
		 * Constructor.
		 *
		 * @param string $_base_file The path to the base file of the plugin. 
		 *							 In most cases, pass the __FILE__ constant.
		 */
		function __construct($_base_file)
		{
			$this->_base_file = $_base_file;
		}
		
		function get($class_name)
		{
			
			switch ($class_name)
			{
				case 'BikeShed':
					return $this->get_bikeshed();
				break;
				
				case 'GP_Plugin_Updater':
					return $this->get_gp_plugin_updater();
				break;
				
				case 'GP_Galahad':
					return $this->get_gp_galahad();
				break;
				
				default:
					return false;
				break;				
			}
		}
		
		function get_bikeshed()
		{
			if ( empty($this->Custom_Banners_GoldPlugins_BikeShed) ) {	
				$this->Custom_Banners_GoldPlugins_BikeShed = new Custom_Banners_GoldPlugins_BikeShed();
			}
			return $this->Custom_Banners_GoldPlugins_BikeShed;
		}
		
		function get_gp_plugin_updater()
		{
			if ( empty($this->GP_Plugin_Updater) ) {
				$api_args = array(
					'version' 	=> $this->get_current_version(),
					'license' 	=> $this->get_license_key(),
					'item_id'   => COMPANY_DIRECTORY_PRO_PLUGIN_ID,
					'author' 	=> 'Gold Plugins',
					'url'       => home_url(),
					'beta'      => false
				);
				$options = array(
					'plugin_name' => 'Custom Banners Pro',
					'activate_url' => admin_url('admin.php?page=custom-banners-license-information'),
					'info_url' => 'https://goldplugins.com/downloads/custom-banners-pro/?utm_source=custom_banners_pro&utm_campaign=activate_for_updates&utm_banner=plugin_links',
				);
				$this->GP_Plugin_Updater = new GP_Plugin_Updater(
					COMPANY_DIRECTORY_PRO_STORE_URL, 
					$this->_base_file, 
					$api_args,
					$options
				);
			}
			return $this->GP_Plugin_Updater;
		}
		
		function get_gp_galahad()
		{
			if ( empty($this->GP_Galahad) ) {
				$gp_updater = $this->get('GP_Plugin_Updater');
				$options = array(
					'active_license' => $gp_updater->has_active_license(),
					'plugin_name' => 'Custom Banners Pro',
					'license_key' => $this->get_license_key(),
					'patterns' => array(
						'b_a_options',
						'custom-banners(.*)',
						'custom-banners(.*)',
						'custom_banners(.*)',
						'custom_banners(.*)',
					)
				);
				$this->GP_Galahad = new GP_Galahad( $options );
			}
			return $this->GP_Galahad;
		}
		
		function get_license_key()
		{
			$b_a_options = get_option( 'b_a_options' );
			return !empty($b_a_options) && !empty($b_a_options['api_key'])
				   ? $b_a_options['api_key']
				   : '';
		}

		function get_license_email()
		{
			$b_a_options = get_option( 'b_a_options' );
			return !empty($b_a_options) && !empty($b_a_options['api_key'])
				   ? $b_a_options['api_key']
				   : '';
		}
		
		function get_current_version()
		{
			if ( !function_exists('get_plugin_data') ) {
				include_once(ABSPATH . "wp-admin/includes/plugin.php");
			}
			$plugin_data = get_plugin_data( $this->_base_file );	
			$plugin_version = ( !empty($plugin_data['Version']) && $plugin_data['Version'] !== 'Version' )
							  ? $plugin_data['Version']
							  : '1.0';							
			return $plugin_version;
		}		
	}