<?php
require_once('cbp_tracker_db.php');
require_once('cbp_tracker_settings.php');
require_once('cbp_tracker_reports.php');
require_once('cloudflare.ip_range_checker.php');

global $custom_banners_db_version;
$custom_banners_db_version = '1.02';

class CBP_Tracker
{
	var $root;
	var $base_file;
	var $post_type = 'banner';
	var $banners_to_track = array();
	var $tracking_slug = 'view_banner';
	
	function __construct($root, $base_file)
	{
		$this->root = $root;
		$this->base_file = $base_file;
		$this->db = new CBP_Tracker_DB();
		$this->reports = new CBP_Tracker_Reports($this->db);
		$this->settings = new CBP_Tracker_Settings();
		$this->add_stylesheets_and_scripts();
		$this->add_hooks();
	}
	
	function add_stylesheets_and_scripts()
	{				
		//$cssUrl = plugins_url( 'assets/css/custom-banners-admin-ui.css' , $this->base_file );
		//$this->root->add_admin_stylesheet('custom-banners-admin-ui',  $cssUrl);
	}
	
	function add_hooks()
	{
		if ( $this->settings->is_tracking_enabled() ) {
			// register tracking script
			add_action( 'wp_enqueue_scripts', array($this, 'setup_scripts') );
			
			// add AJAX hook to for logging impressions
			add_action( 'wp_ajax_custom_banners_pro_log_impression', array( $this, 'ajax_log_impression' ) );
			add_action( 'wp_ajax_nopriv_custom_banners_pro_log_impression', array( $this, 'ajax_log_impression' ) );

			// output hidden inputs after the banners to enable impression tracking
			add_filter('custom_banners_target_url', array($this, 'replace_url_with_tracking_link'), 10, 2);

			// rewrite the outbound links to enable click tracking
			add_filter('custom_banners_after_banner', array($this, 'append_tracking_input_to_banner'), 10, 3);

			// add the Performance column to the banner list
			add_filter('custom_banners_admin_columns_head', array($this, 'add_column_headers'), 10, 1);
			add_filter('custom_banners_admin_columns_content', array($this, 'output_column_contents'), 10, 2);		

			// catch tracking links
			add_action( 'init', array($this, 'add_banner_tracking_rewrite_rule') );
			add_filter( 'query_vars', array($this, 'add_banner_tracking_query_var') );
			add_action( 'template_redirect', array($this, 'catch_banner_redirects') );
			add_filter( 'generate_rewrite_rules', array($this, 'custom_rewrite') );			
			
			// add settings tabs
			add_filter('custom_banners_admin_settings_tabs', array($this, 'add_admin_tabs'), 10, 2 );
		}
	}
	
	function add_admin_tabs($tabs)
	{
		$new_tabs = array(
			array(
				'menu_slug' => 'custom-banners-tracking',
				'menu_title' => 'Tracking Options'
			),
			array(
				'menu_slug' => 'custom-banners-reports',
				'menu_title' => 'Reports'
			)
		);
		
		// insert at next-to-last position
		$insert_pos = count($tabs) - 1;
		array_splice( $tabs, $insert_pos, 0, $new_tabs );

		return $tabs;
	}
	
	function add_banner_tracking_rewrite_rule()
	{
		// slug followed by a slash, the banner ID, and then maybe another slash
		$rule = '^' . $this->tracking_slug . '/([0-9]+)/?$';
		add_rewrite_rule(
			$rule,
			'index.php?banner_id=$matches[1]',
			'top' // top priority, i.e., process before built-in WP rules
		);		
		flush_rewrite_rules( true );
	}
	
	function custom_rewrite( $wp_rewrite ) {
		$rule = '^' . $this->tracking_slug . '/([0-9]+)/?$';
		$new_rule = array(
			$rule  =>  'index.php?banner_id=' . $wp_rewrite->preg_index(1)
		);
	}

	function append_tracking_input_to_banner( $after, $banner_id, $atts = array() )
	{
		return $after . $this->get_tracking_input($banner_id);
	}
	
	function add_column_headers($columns)
	{
		$add_columns = array(
			"cbp_banner_performance" => "Performance",
		);
		$this->array_insert_after_key($columns, 'single_shortcode', $add_columns);		return $columns;
	}

	function output_column_contents($column_name, $post_ID)
	{
		if ($column_name == 'cbp_banner_performance') {
			$impressions = get_post_meta($post_ID, 'cbp_impressions', true);
			if ( empty ($impressions) ) {
				$impressions = 0;
			}
			$clicks = get_post_meta($post_ID, 'cbp_clicks', true);
			if ( empty ($clicks) ) {
				$clicks = 0;
			}
			$ctr = ($impressions > 0) ? round( ($clicks / $impressions) * 100, 2) : 0;
			echo '<table class="cbp_performance_table">';
			printf('<tr><td>Impressions:</td><td>%d</td></tr>', $impressions);
			printf('<tr><td>Clicks:</td><td>%d</td></tr>', $clicks);
			printf('<tr><td>CTR:</td><td>%.2f%%</td></tr>', $ctr);
			echo '</table>';
		}
	}
	
	/**
	* Inserts an array into the given array after the specified key.
	* Works with associative arrays.
	*
	* @param array      $array		The array to modify. Passed by reference.
	* @param string 	$find_key	The key after which to insert the new array
	* @param mixed      $insert		The array to insert
	*/
	function array_insert_after_key(&$array, $find_key, $insert)
	{
		$pos   = array_search( $find_key, array_keys($array) );
		$array = array_merge(
			array_slice($array, 0, $pos + 1),
			$insert,
			array_slice($array, $pos + 1)
		);
	}
	
	function track_banner($banner_id)
	{
		if (array_search($banner_id, $this->banners_to_track) === FALSE) {
			$this->banners_to_track[] = $banner_id;
		}
	}
	
	function get_tracking_input($banner_id)
	{
		$nonce_key = $this->get_nonce_key($banner_id);
		$nonce = wp_create_nonce($nonce_key);
		$html = sprintf('<input type="hidden" class="custom_banners_pro_tracking_input" name="_custom_banners_pro_track_banner[]" value="%d" data-nonce="%s" />', $banner_id, $nonce);
		return apply_filters('custom_banners_pro_hidden_tracking_input', $html, $banner_id);
	}
	
	
	function setup_scripts()
	{
		$localize_vars = array(
			'custom_banners_tracking_vars' => array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			)
		);
		$this->register_tracking_script();
		$this->enqueue_tracking_script( $localize_vars );
	}

	function register_tracking_script()
	{
		wp_register_script(
			'custom_banners_pro-impression_tracker',
			plugins_url('assets/js/cb_tracker.js', $this->base_file),
			array( 'jquery' ),
			false,
			true
		);
	}

	function enqueue_tracking_script( $localize_vars = array() )
	{
		wp_enqueue_script( 'custom_banners_pro-impression_tracker' );
		if ( !empty($localize_vars) ) {
			foreach ($localize_vars as $key => $value) {
				wp_localize_script('custom_banners_pro-impression_tracker', $key, $value);
			}
		}
	}
	
	function ajax_log_impression()
	{
		$banner_id = isset($_REQUEST['banner_id']) ? intval($_REQUEST['banner_id']) : 0;
		$nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : '';
		$nonce_key = $this->get_nonce_key($banner_id);
		
		echo "1";

		// fail if nonce cannot be verified
		if ( !wp_verify_nonce( $nonce, $nonce_key ) ) {
			wp_die();
		}
		
		// fail if this impression should not be counted
		if ( !$this->should_count_impression($banner_id) ) {
			wp_die();
		}
		
		// track the impression!
		$this->db->log_impression( $banner_id,  $this->get_client_ip() );
		
		wp_die();
	}
	
	function get_nonce_key($banner_id)
	{
		return sprintf('custom_banners_pro_track_impression_%d', $banner_id);
	}
	
	function should_count_impression( $banner_id, $ip_address = '', $grace_period = false )
	{
		// determine IP automatically if not specified
		$ip_address = !empty($ip_address) ? $ip_address : $this->get_client_ip();

		// decide whether to count this impression
		$should_count = $this->should_count('impression', $banner_id, $ip_address, $grace_period);
				
		// allow the decision to be modified via filter before returning it
		return apply_filters('custom_banners_should_count_impression', $should_count, $ip_address);

	}
	
	function should_count_click( $banner_id, $ip_address = '', $grace_period = false )
	{
		// determine IP automatically if not specified
		$ip_address = !empty($ip_address) ? $ip_address : $this->get_client_ip();
				
		// decide whether to count this click
		$should_count = $this->should_count('click', $banner_id, $ip_address, $grace_period);
		//die( 'sc: ' . ($should_count ? 't' : 'f') );
		// allow the decision to be modified via filter before returning it
		return apply_filters('custom_banners_should_count_click', $should_count, $ip_address);
	}	
	
	function should_count( $impression_or_click, $banner_id, $ip_address = '', $grace_period = false )
	{
		$should_count = true;

		// determine IP automatically if not specified
		if ( empty($ip_address) ) {
			$ip_address = $this->get_client_ip();
		}

		// default grace period to 30 minutes
		if ( empty($grace_period) ) {
			$grace_period = $this->get_setting_value('grace_period', '30 minutes');
		}
		
		// make sure this IP is not blacklisted
		if ( $this->is_ip_blacklisted($ip_address) ) {
			$should_count = false;
		}
		
		// if we've already recorded an impression within the grace period 
		// then ignore this one
		if ( $impression_or_click == 'impression' && $this->db->find_recent_impression($banner_id, $ip_address, $grace_period) ) {
			$should_count = false;
		} else if ( $impression_or_click == 'click' && $this->db->find_recent_click($banner_id, $ip_address, $grace_period) ) {
			$should_count = false;
		}
		
		// if the current user is at least an Author ignore the impression
		// see: https://codex.wordpress.org/Roles_and_Capabilities
		$count_logged_in_users = $this->get_setting_value('count_logged_in_users', 'subscribers_only');		
				
		switch ($count_logged_in_users) {
			case 'subscribers_only':
				if ( current_user_can('publish_posts') ) {
					$should_count = false;
				}
				break;

			case 'count_all':
				// don't do anything - we won't turn the setting OFF,
				// but we shouldn't turn it back ON either in case
				// this impression was ignored via another rule
				break;			
				
			default:
			case 'ignore_all':
				$should_count = false;
				break;
		}
		
		return $should_count;
	}
	
	function is_ip_blacklisted($ip_to_check)
	{
		$blacklist = $this->get_ip_blacklist();
		
		// do a simple check first (exact match) 
		$is_on_blacklist = in_array($ip_to_check, $blacklist);
		
		// simple check failed, so try each IP in the blacklist as a netmask
		if (!$is_on_blacklist) {
			$range_checker = new CloudFlare_IP_Range_Checker();
			foreach ($blacklist as $range) {
				if ( $range_checker->is_ip_in_range($ip_to_check, $range) ) {
					$is_on_blacklist = true;
					break;
				}
			}
		}
				
		// allow a chance to override the decision via filter before returning it
		return apply_filters('custom_banners_pro_is_ip_blacklisted', $is_on_blacklist, $ip_to_check, $blacklist);		
	}
	
	/*
	 * Returns the IP blacklist as an array. 
	 * 
	 * @filter custom_banners_pro_ip_blacklist
	 */
	function get_ip_blacklist()
	{
		$blacklist_raw = $this->get_setting_value('ip_blacklist', '');
		$blacklist = preg_split('/[\r\n]+/', $blacklist_raw);
		return apply_filters('custom_banners_pro_ip_blacklist', $blacklist);
	}
	
	function get_client_ip()
	{
		$ip = '';
		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED'];
		}
		else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_FORWARDED_FOR'];
		}
		else if(isset($_SERVER['HTTP_FORWARDED'])) {
			$ip = $_SERVER['HTTP_FORWARDED'];
		}
		else if(isset($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}		
		
		return apply_filters('custom_banners_get_client_ip', $ip);
	}
	
	function catch_banner_redirects($tmpl = '')
	{
		if ( get_query_var('banner_id') )
		{
			$banner_id = get_query_var('banner_id');
			$target_url = get_post_meta($banner_id, '_ikcf_target_url', true);
			$target_url = apply_filters('custom_banners_tracking_redirect_url', $target_url, $banner_id);

			if ( !empty($target_url) ) {
				
				// count the click if needed
				$nonce = !empty($_GET['n']) ? $_GET['n'] : '';
				$my_ip = $this->get_client_ip();
				if ( $this->verify_click_nonce($banner_id, $nonce) && $this->should_count_click($banner_id, $my_ip) ) {
					$this->db->log_click( $banner_id,  $my_ip );
				}

				// send them on to the target URL
				$status_code = apply_filters('custom_banners_tracking_redirect_status', '301', $banner_id, $target_url);
				wp_redirect($target_url, $status_code);
				exit;
			} else {
				// no target URL specified - send user to homepage instead
				wp_redirect( home_url(),  302 );
				exit;
			}
		}
	}
	
	function add_banner_tracking_query_var($query_vars)
	{
		$query_vars[] = 'banner_id';		
		return $query_vars;
	}	
	
	function replace_url_with_tracking_link($url, $banner_id)
	{
		if ( empty($url) || $url == '#' ) {
			return $url;
		}
		$nonce = wp_create_nonce('custom_banners_click_tracking_' . $banner_id);
		$rand = rand(1000, 30000);
		$tracking_path = sprintf('/%s/%d/?n=%s&r=%s', $this->tracking_slug, $banner_id, urlencode($nonce), urlencode($rand) );
		$tracking_url = home_url($tracking_path);
		return $tracking_url;
	}
	
	function get_setting_value($key, $default_value = '')
	{
		if ( empty($this->tracking_settings) ) {
			$this->tracking_settings = get_option('custom_banners_pro_tracking_settings');
		}
		
		if ( !empty($this->tracking_settings) && isset($this->tracking_settings[$key]) ) {
			return $this->tracking_settings[$key];
		} else {
			return $default_value;
		}		
	}
	
	function verify_click_nonce($banner_id, $nonce)
	{
		$nonce_action = 'custom_banners_click_tracking_' . $banner_id;
		return wp_verify_nonce($nonce, $nonce_action);		
	}
	
}