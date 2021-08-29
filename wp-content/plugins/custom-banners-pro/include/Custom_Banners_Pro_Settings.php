<?php
	class Custom_Banners_Pro_Settings
	{
		function __construct( $factory )
		{
			add_action( 'admin_init', array( $this, 'create_settings' ) );
			$this->options = get_option( 'b_a_options' );
			$this->Factory = $factory;
		}
		
		function create_settings()
		{
			$this->add_license_settings();			
		}
		
		function add_license_settings()
		{
			register_setting( 'custom-banners-pro-license-group', 'custom_banners_pro_registered_key', array($this, 'handle_check_software_license') );
		}

		function output_pro_settings_fields()
		{		
			$this->settings_page_top();
			$license_key = $this->get_license_key();			
			?>							
				<h3>Custom Banners Pro Settings</h3>			
				<p>Pro settings page.</p>
				<?php if ( $this->is_activated() ): ?>		
				<?php endif; ?>			
			<?php 
			$this->settings_page_bottom();
		}
		
		/*
		 * Verifies the provided pro credentials before they are saved. Intended to
		 * be called from the sanitization callback of the registration options.
		 *
		 * @param string $new_api_key The API key that's just been entered into the 
		 * 								settings page. Passed by WordPress to the 
		 * 								sanitization callback. Optional.
		 */
		function handle_check_software_license($new_api_key = '')
		{
			// abort if required field is missing
			$lm_action = strtolower( filter_input(INPUT_POST, '_gp_license_manager_action') );
			if ( empty($new_api_key) || empty($lm_action) ) {
				return $new_api_key;
			}
			
			$updater = $this->Factory->get('GP_Plugin_Updater');

			if ( $lm_action == 'activate' ) {
				// attempt to activate the new key with the home server
				$result = $updater->activate_api_key($new_api_key);
			}
			else if ( $lm_action == 'deactivate' ) {
				// attempt to deactivate the key with the home server
				$result = $updater->deactivate_api_key($new_api_key);	
			}
			
			return $new_api_key;
		}
		
		function render_license_information_page()
		{
			// setup the Sajak tabs for this screen
			$this->tabs = new GP_Sajak( array(
				'header_label' => 'Custom Banners Pro - License',
				'settings_field_key' => 'custom-banners-pro-license-group', // can be an array
			) );		
			
			$this->tabs->add_tab(
				'custom_banners_pro_license', // section id, used in url fragment
				'Pro License', // section label
				array( $this, 'output_registration_options' ), // display callback
				array( // tab options
					'icon' => 'key',
					'show_save_button' => false
				)
			);
			
			// render the page
			$this->settings_page_top();	
			$this->tabs->display();
			$this->settings_page_bottom();
		}
		
		function output_registration_options()
		{		
			$this->settings_page_top();
			$license_key = $this->get_license_key();
			?>							
				<h3>Custom Banners Pro License</h3>			
				<p>With an active API key, you will be able to receive automatic software updates and contact support directly.</p>
				<?php if ( $this->is_activated() ): ?>		
				<div class="has_active_license" style="color:green;margin-bottom:20px;">
					<?php $expiration = $this->license_expiration_date();
					if ( $expiration == 'lifetime' ):
					?>
					<p><strong>&#x2713; Your API Key has been activated.</p>
					<?php else: ?>				
					<p><strong>&#x2713; Your API Key is active through <?php echo $this->license_expiration_date(); ?></strong>.</p>
					<?php endif; ?>
				</div>
				<input type="hidden" name="_gp_license_manager_action" value="deactivate" />
				<input type="hidden" name="custom_banners_pro_registered_key" value="<?php echo htmlentities( $license_key ); ?>" />
				<button class="button">Deactivate</button>
				<?php else: ?>			
				<p>You can find your API key in the email you received upon purchase, or in the <a href="https://goldplugins.com/members/?utm_source=easy_testimonials_pro_plugin&utm_campaign=get_api_key_from_member_portal">Gold Plugins member portal</a>.</p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="custom_banners_pro_registered_key">API Key</label></th>
						<td><input type="text" class="widefat" name="custom_banners_pro_registered_key" id="custom_banners_pro_registered_key" value="<?php echo htmlentities( $license_key ); ?>" autocomplete="off" />
						</td>
					</tr>
				</table>			
				<input type="hidden" name="_gp_license_manager_action" value="activate" />
				<button class="button">Activate</button>
				<?php endif; ?>			
			<?php 
			$this->settings_page_bottom();
		}
		
		function get_license_key()
		{
			return trim ( get_option('custom_banners_registered_key', '') );
		}
		
		function is_activated()
		{
			$key = $this->get_license_key();
			if ( empty($key) ) {
				return false;
			}
			
			$updater = $this->Factory->get('GP_Plugin_Updater');
			return $updater->has_active_license();
		}
		
		function license_expiration_date()
		{
			$updater = $this->Factory->get('GP_Plugin_Updater');
			$expiration = $updater->get_license_expiration();
			
			// handle lifetime licenses
			if ('lifetime' == $expiration) {
				return 'lifetime';
			}
			
			// convert to friendly date
			return ( !empty($expiration) )
				   ? date_i18n( get_option('date_format', 'M d, Y'), $expiration)
				   : '';
		}
		
	
		//output top of settings page
		function settings_page_top($show_tabs = true)
		{
			global $pagenow;
			$title = 'Custom Banners ' . __('Settings', 'custom-banners');
			if( isset($_GET['settings-updated']) 
				&& $_GET['settings-updated'] == 'true' 
				&& $_GET['page'] != 'custom-banners-license-settings' 
				&& strpos($_GET['page'], 'license-settings') !== false
			) {
				$this->messages[] = "Settings updated.";
			}
		?>
			<div class="wrapxx xxcustom_banners_admin_wrap">
		<?php
			if( !empty($this->messages) ){
				foreach($this->messages as $message){
					echo '<div id="messages" class="gp_updated fade">';
					echo '<p>' . $message . '</p>';
					echo '</div>';
				}
				
				$this->messages = array();
			}
		?>
			<div id="icon-options-general" class="icon32"></div>
			<?php
		}
		
		//builds the bottom of the settings page
		//includes the signup form, if not pro
		function settings_page_bottom()
		{
			?>
			</div>
			<?php
		}
		
	}