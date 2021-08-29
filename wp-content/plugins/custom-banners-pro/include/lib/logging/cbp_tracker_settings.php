<?php
require_once('cbp_tracker_db.php');

global $custom_banners_db_version;
$custom_banners_db_version = '1.02';

class CBP_Tracker_Settings
{
	var $settings_key = 'custom_banners_pro_tracking_settings';
	var $impression_tracker;
	var $root;
	
	function __construct()
	{
		$this->shed = new Custom_Banners_GoldPlugins_BikeShed();
		$this->add_hooks();	
		
		//instantiate Sajak so we get our JS and CSS enqueued
		new GP_Sajak();		
	}
	
	function add_hooks()
	{		
		add_action( 'admin_init', array($this, 'register_settings' ), 10, 2 );
		add_action( 'custom_banners_admin_settings_submenu_pages', array($this, 'add_settings_tab' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array($this, 'register_styles') );
	}
	
	function register_settings()
	{
		register_setting( 'custom-banners-tracking-settings-group',
						  $this->settings_key, 
						  array( $this, 'settings_updated') );
	}
	
	function add_settings_tab($submenu_pages, $top_level_slug = '')
	{
		$my_page[] = array(
			'parent_slug' => $top_level_slug,
			'page_title' => 'Tracking Options',
			'menu_title' => 'Tracking Options',
			'capability' => 'administrator',
			'menu_slug' => 'custom-banners-tracking',
			'callback' => array($this, 'tracking_settings_page')
		);
		$this->insert_submenu_page_after_target($submenu_pages, 'custom-banners-style-settings', $my_page);
		return $submenu_pages;
	}
	
	/**
	* Inserts a new page into an existing list of submenu pages.
	* Insertion is performed *after* the first array item who's
	* menu_slug key matches the target
	*
	* @param array      $submenu_pages	The array of pages. Modified directly.
	* @param string 	$target_slug	The menu_slug to match against
	* @param mixed      $insert			The submenu page to insert
	*/
	function insert_submenu_page_after_target(&$submenu_pages, $target_slug, $insert)
	{
		$pos = count($submenu_pages) - 1; // default to last position
		
		// find the target slug in the list of pages
		foreach ($submenu_pages as $index => $page) {
			if ( $page['menu_slug'] == $target_slug ) {
				$pos = $index;
				break;
			}
		}

		// insert the new page at the target position
		$submenu_pages = array_merge(
			array_slice($submenu_pages, 0, $pos + 1),
			$insert,
			array_slice($submenu_pages, $pos + 1)
		);
	}

	function tracking_settings_page()
	{		
		wp_enqueue_style('custom_banners_it_settings');
		do_action('custom_banners_admin_settings_page_top');
		
		$extra_buttons = array();
		
		//instantiate tabs object for output basic settings page tabs
		$tabs = new GP_Sajak( array(
			'header_label' => 'Tracking Options',
			'settings_field_key' => 'custom-banners-tracking-settings-group', // can be an array	
			'show_save_button' => true, // hide save buttons for all panels   		
			'extra_buttons_header' => $extra_buttons, // extra header buttons
			'extra_buttons_footer' => $extra_buttons // extra footer buttons
		) );
	
		$tabs->add_tab(
			'tracking', // section id, used in url fragment
			'Tracking Settings', // section label
			array($this, 'output_tracking_settings'), // display callback
			array(
				'class' => 'extra_li_class', // extra classes to add sidebar menu <li> and tab wrapper <div>
				'icon' => 'gear' // icons here: http://fontawesome.io/icons/
			)
		);
		
		$tabs->display();
	}
	
	//outputs the tracking settings
	function output_tracking_settings(){
		$disabled = false; //!(isValidCBKey());
		$current_settings = $this->load_settings();	
		?>
			<h3>Tracking Options</h3>
			<p>These options control which impressions, if any, are recorded for your visitors.</p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<label>Enable Tracking</label>
					</th>
					<td>
						<div class="bikeshed bikeshed_text">
							<div class="text_wrapper">
								<?php
									$checked = $current_settings['tracking_enabled'] == '1'
											   ? 'checked="checked"'
											   : '' ;
								?>
								<input type="hidden" value="0" name="custom_banners_pro_settings[tracking_enabled]">
								<label for="custom_banners_pro_settings_tracking_enabled">								
									<input type="checkbox" value="1" <?php echo $checked; ?> id="custom_banners_pro_tracking_settings_tracking_enabled" name="custom_banners_pro_tracking_settings[tracking_enabled]">
									Enable impression and click tracking
								</label>
							</div>
							<p class="description">When enabled, impressions and clicks will be recorded for all banners. Click-through URLs for your banners will be masked with a 301 redirect to enable click tracking.</p>
						</div>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">
						<label>Grace Period</label>
					</th>
					<td>
						<div class="bikeshed bikeshed_text">
							<div class="text_wrapper">
								<input type="text" class="input_time_number" value="<?php echo htmlentities($current_settings['grace_period_number'])?>" id="custom_banners_pro_tracking_settings_grace_period_number" name="custom_banners_pro_tracking_settings[grace_period_number]">
								<select class="select_time_unit" id="custom_banners_pro_tracking_settings_grace_period_unit" name="custom_banners_pro_tracking_settings[grace_period_unit]">
								<?php
								foreach ( $this->get_time_units() as $val => $label ) {
									$selected = $current_settings['grace_period_unit'] == $val
												? 'selected="selected"'
												: '' ;
									printf( '<option %s value="%s">%s</option>', $selected, $val, $label );
								}
								?>
								</select>
							</div>
							<p class="description">Ignore repeated impressions and clicks by the same visitor on the same banner for this period of time.</p>
						</div>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="custom_banners_pro_count_admin_users">Count Impressions &amp; Clicks From Logged In Users</label></th>
					<td>
						<fieldset class="gp_fieldset_plain">
							<label title="Ignore All Logged In Users">
								<input type="radio" <?php echo ($current_settings['count_logged_in_users'] == 'ignore_all' ? 'checked="checked"' : ''); ?> value="ignore_all" name="custom_banners_pro_tracking_settings[count_logged_in_users]">
								<span>Ignore impressions &amp; clicks from <strong>ALL</strong> logged in users</span>
							</label>
							<br />
							<label title="Only Count Subscribers">
								<input type="radio" <?php echo ($current_settings['count_logged_in_users'] == 'subscribers_only' ? 'checked="checked"' : ''); ?> value="subscribers_only" name="custom_banners_pro_tracking_settings[count_logged_in_users]">
								<span>Count impressions &amp; clicks from <strong>Subscribers</strong>, but ignore higher roles</span>
							</label>
							<br />
							<label title="Count All Logged In Users">
								<input type="radio" <?php echo ($current_settings['count_logged_in_users'] == 'count_all' ? 'checked="checked"' : ''); ?> value="count_all" name="custom_banners_pro_tracking_settings[count_logged_in_users]">
								<span>Count impressions &amp; clicks from <strong>ALL</strong> logged in users</span>
							</label>
							<br />
						</fieldset>
						<p class="description">Impressions and clicks from your normal (non-logged in) visitors are not affected by this setting.</p>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><label for="custom_banners_pro_tracking_settings_ip_blacklist">IP Blacklist</label></th>
					<td>
						<div class="textarea_wrapper">
							<textarea rows="4" id="custom_banners_pro_tracking_settings_ip_blacklist" name="custom_banners_pro_tracking_settings[ip_blacklist]" style="max-width: 550px; height: auto"><?php echo htmlentities($current_settings['ip_blacklist']); ?></textarea>
						</div>
						<p class="description">Impressions from these addresses will not be counted. Enter one address per line. Accepts most formats, including wildcards. </p>
					</td>
				</tr>
			</table>
		<?php
	}
	
	function text_input($name, $label, $description = '', $default_val = '', $disabled = false)
	{
		$val = get_option($name, $default_val);
		if (empty($val)) {
			$val = $default_val;
		}
		$this->shed->text(
			array(
				'name' => $name,
				'label' => $label,
				'value' => $val,
				'description' => $description,
				'disabled' => $disabled
			)
		);
	}
	
	function load_settings()
	{
		$defaults =  array(
			'grace_period' => '30 minutes',
			'grace_period_number' => '30',
			'count_logged_in_users' => 'ignore_all',
			'ip_blacklist' => '',
			'tracking_enabled' => false
		);
		$settings = get_option( $this->settings_key, array() );
		return array_merge($defaults, $settings);
	}
	
	/**
	 * Callback function for when the Impressing Tracking settings are updated
	 */
	function settings_updated($settings)
	{
		// combine grace period's number and units into one string
		$settings = $this->collect_grace_period($settings);
								
		// return the updated settings so they can be saved
		return $settings;
	}
	
	/**
	 * Registers the custom_banners_it_settings stylesheet, which styles the
	 * impression tracking settings pages. It must still be enqueued.
	 */
	function register_styles()
	{
		$cssUrl = plugins_url( 'assets/css/settings.css' , __FILE__ );
		wp_register_style( 'custom_banners_it_settings', $cssUrl );
	}
	
	/*
	 * In the settings array, combine the specified grace_period_number and
	 * grace_period_unit into a strtotime compatible string, grace_period.
	 *
	 * @param array $settings Array of settings to consider, containing the keys
	 *						  grace_period_number (int, 0-999) and 
	 *					  	  grace_period_unit (seconds, minutes, hours, days).
	 *						  If an invalid value is specified either, defaults 
	 *						  will be used (30 for number, 'minutes' for units).
	 *
	 * @return array The updated array of settings, with grace_period set to a
	 *				 strtotime compatible string.
	 */	 
	function collect_grace_period($settings)
	{	 
		// collect and sanitize the number portion of the grace period
		$filter_options = array( 
			'options' => array(
				'default' => 30,
				'min_range' => 0,
				'max_range' => 999
			)
		);
		$grace_period_number = filter_var( $settings['grace_period_number'],
										   FILTER_VALIDATE_INT, 
										   $filter_options );

		// collect and sanitize the unit portion of the grace period
		$valid_time_units = $this->get_time_units( false );
		$grace_period_unit = filter_var( $settings['grace_period_unit'],
										 FILTER_SANITIZE_STRING );
		$grace_period_unit = strtolower( $grace_period_unit );
		$grace_period_unit = in_array($grace_period_unit, $valid_time_units)
							 ? $grace_period_unit
							 : 'minutes'; // default

		// combine the collected number + unit into the grace period
		$settings['grace_period'] = sprintf('%d %s',
											$grace_period_number,
											$grace_period_unit);
		
		// save the sanitize grace_period_number and grace_period_unit values
		$settings['grace_period_number'] = $grace_period_number;
		$settings['unit'] = $grace_period_unit;
								
		// return the updated settings
		return $settings;
	}
	
	function get_time_units($include_labels = true)
	{
		$units = array(
			'seconds' => 'Minutes',
			'minutes' => 'Minutes',
			'hours' => 'Hours',
			'days' => 'Days',
		);
		
		// remove the labels if not requested
		if ( !$include_labels ) {
			$units = array_keys($units);
		}
		
		return $units;
	}
	
	function is_tracking_enabled()
	{
		$settings = get_option( $this->settings_key, array() );
		return ( !empty($settings['tracking_enabled']) );		
	}
	
	
}
