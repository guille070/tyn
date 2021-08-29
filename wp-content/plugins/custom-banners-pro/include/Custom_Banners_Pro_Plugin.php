<?php
include('Custom_Banners_Pro_Settings.php');
include('Custom_Banners_Pro_Factory.php');

class Custom_Banners_Pro_Plugin
{
	function __construct($base_file)
	{
		$this->base_file = $base_file;
		$this->Factory = new Custom_Banners_Pro_Factory($base_file);
		$this->Settings = new Custom_Banners_Pro_Settings( $this->Factory );
		$this->add_hooks();
		$this->tracker = new CBP_Tracker($this, $base_file);
		$this->shed = $this->Factory->get('BikeShed');

		// initialize automatic updates
		$this->init_updater();		

		// initialize Galahad so it can add its hooks
		$this->init_galahad();		
	}
	
	function add_hooks()
	{
		// add Pro Admin Contact Form tab
		add_filter( 'custom_banners_admin_help_tabs', array($this, 'add_help_tab'), 10, 1 );
		
		$just_activated = get_transient('custom_banners_pro_just_activated');
		if ( !empty( $just_activated ) ) {
			add_action( 'init', array($this, 'activation_hook') );
			delete_transient('custom_banners_pro_just_activated');
		}
		
		// add pro themes config array
		add_filter( 'cb_theme_array', array($this,'add_pro_themes'), 10 );

		// front end javascript
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_js') );
		
		// front end css, including pro themes
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_css') );		
		
		// admin javascript
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_js') );

		// admin css. also include pro themes CSS for theme preview
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin_css'), 10, 1 );
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_css') );
	
		// add menus
		add_filter('custom_banners_admin_settings_submenu_pages', array($this, 'add_submenus'), 10, 2 );
		
		// add tabs
		add_filter('custom_banners_admin_settings_tabs', array($this, 'add_admin_tabs'), 10, 2 );

		// add pro transitions
		add_filter('custom_banners_available_transitions', array($this, 'add_transitions'), 10, 1 );

		// add Pro CSS for CTA button and caption
		add_filter('custom_banners_cta_button_style', array($this, 'add_cta_styles'), 10, 2 );		
		add_filter('custom_banners_caption_style', array($this, 'add_caption_styles'), 10, 2 );		

		// add Google web fonts if needed
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_webfonts') );
	}
	
	
	
	function activation_hook()
	{
		// clear cached data
		delete_transient('custom_banners_pro_just_activated');
		
		// show "thank you for installing, please activate" message
		$updater = $this->Factory->get('GP_Plugin_Updater');
		if ( !$updater->has_active_license() ) {
			$updater->show_admin_notice('Thanks for installing Custom Banners Pro! Activate your plugin now to enable automatic updates.', 'success');
			// TODO: make sure this is the correct URL
			wp_redirect( admin_url('admin.php?page=custom-banners-license-information') );
			exit();
		}
	}
	
	function add_submenus($submenu_pages, $top_level_slug)
	{
		$style_page = array(
			array(
				'parent_slug' => $top_level_slug,
				'page_title' => 'Style Options',
				'menu_title' => 'Style Options',
				'capability' => 'administrator',
				'menu_slug' => 'custom-banners-style-settings',
				'callback' => array($this, 'style_settings_page')
			)
		);
		
		// add Lincense Info page
		$license_info_page = array(
			array(
				'parent_slug' => $top_level_slug,
				'page_title' => __('License Information', 'custom-banners'),
				'menu_title' => __('License Information', 'custom-banners'),
				'capability' => 'manage_options',
				'menu_slug' => 'custom-banners-license-information',
				'callback' =>  array($this->Settings, 'render_license_information_page')
			)
		);		
		
		// insert style page at next-to-last position
		$insert_pos = count($submenu_pages) - 1;
		array_splice( $submenu_pages, $insert_pos, 0, $style_page );

		// insert license info page at next-to-last position (and after Style page)
		$insert_pos = count($submenu_pages) - 1;
		array_splice( $submenu_pages, $insert_pos, 0, $license_info_page );

		return $submenu_pages;		
	}
	
	function add_admin_tabs($tabs)
	{
		$style_tab = array(
			array(
				'menu_slug' => 'custom-banners-style-settings',
				'menu_title' => 'Style Options'
			)
		);
		
		// insert at next-to-last position
		$insert_pos = count($tabs) - 1;
		array_splice( $tabs, $insert_pos, 0, $style_tab );

		return $tabs;
	}
	
	function enqueue_js($hook)
	{
		// TODO: enqueue tracking JS
		
		// advanced transition js
		$jsUrl = plugins_url( 'assets/js/wp-banners.js' , $this->base_file );		
		wp_enqueue_script(
			'wp-banners',
			$jsUrl,
			array( 'jquery', 'gp_cycle2' ),
			false,
			true
		);
		
		// admin only scripts
		if (is_admin() && strpos($hook,'custom-banners') !== false){
			wp_enqueue_script(
				'gp-admin_ui',
				plugins_url('assets/js/gp-admin_ui.js', $this->base_file),
				array( 'jquery' ),
				false,
				true
			);
		}
	}
	
	function enqueue_css()
	{		
		//pro themes css
		$proCssUrl = plugins_url( 'assets/css/wp-banners-pro.css' , $this->base_file );
		wp_enqueue_style( 'wp-banners-pro', $proCssUrl );
	}
	
	//array merge our pro themes into the base pro themes array
	//base pro themes array is empty in the Free plugin
	function add_pro_themes($pro_themes)
	{
		$additional_pro_themes = array(
			'card' => array(
				'card' => 'Card Theme',
				'card-white' => 'Card Theme - White',
				'card-yellow' => 'Card Theme - Yellow',
				'card-purple' => 'Card Theme - Purple',
				'card-salmon' => 'Card Theme - Salmon',
				'card-black' => 'Card Theme - Black',
			),
			'window' => array(
				'window' => 'Window',
				'window-white' => 'Window - White',
				'window-salmon' => 'Window - Salmon',
				'window-green' => 'Window - Green',
				'window-aqua' => 'Window - Aqua',
				'window-red' => 'Window - Red',
			),			
			'classic' => array(
				'classic' => 'Classic Theme',
				'classic-standard' => 'Classic Theme - Standard',
				'classic-yellow' => 'Classic Theme - Yellow',
				'classic-green' => 'Classic Theme - Green',
				'classic-blue' => 'Classic Theme - Blue',
				'classic-white' => 'Classic Theme - White',
			),			
			'corporate' => array(
				'corporate' => 'Corporate Theme',
				'corporate-black' => 'Corporate Theme - Black',
				'corporate-salmon' => 'Corporate Theme - Salmon',
				'corporate-sky_blue' => 'Corporate Theme - Sky Blue',
				'corporate-green_hills' => 'Corporate Theme - Green Hills',
				'corporate-sandy_beach' => 'Corporate Theme - Sandy Beach'
			),
			'deco' => array(
				'deco' => 'Deco Theme',
				'deco-grey' => 'Deco Theme - Grey',
				'deco-blue' => 'Deco Theme - Blue',
				'deco-fuschia' => 'Deco Theme - Fuschia',
				'deco-lavendar' => 'Deco Theme - Lavendar',
				'deco-smoke' => 'Deco Theme - Smoke',
			),
			'tile' => array(
				'tile' => 'Tile Theme',
				'tile-slate' => 'Tile Theme - Slate',
				'tile-gold' => 'Tile Theme - Gold',
				'tile-red' => 'Tile Theme - Red',
				'tile-blue' => 'Tile Theme - Blue',
				'tile-green' => 'Tile Theme - Green',
			),			
			'modern' => array(
				'modern' => 'Modern Theme',
				'modern-white' => 'Modern Theme - White',
				'modern-black' => 'Modern Theme - Black',
				'modern-purple' => 'Modern Theme - Purple',
				'modern-blue' => 'Modern Theme - Blue',
				'modern-green' => 'Modern Theme - Green',
			),
			'classic_tile' => array(
				'classic_tile' => 'Classic Tile Theme',
				'classic_tile-black' => 'Classic Tile Theme - Black',
				'classic_tile-salmon' => 'Classic Tile Theme - Salmon',
				'classic_tile-blue' => 'Classic Tile Theme - Blue',
				'classic_tile-green' => 'Classic Tile Theme - Green',
				'classic_tile-orange' => 'Classic Tile Theme - Orange',
			),
			'banner' => array(
				'banner' => 'Banner Theme',
				'banner-light_grey' => 'Banner Theme - Light Grey',
				'banner-salmon' => 'Banner Theme - Salmon',
				'banner-green' => 'Banner Theme - Green',
				'banner-orange' => 'Banner Theme - Orange',
				'banner-fuscia' => 'Banner Theme - Fuscia',
			)
		);		
		
		return array_merge($pro_themes, $additional_pro_themes);
	}
	
	function enqueue_admin_css($hook)
	{
		if ( strpos($hook, 'custom-banners') !== false 
			|| strpos($hook, 'custom_banners') !== false 
		) {
			wp_register_style( 'custom_banners_pro_css', plugins_url('include/assets/css/custom_banners_pro.css', $this->base_file) );
			wp_enqueue_style( 'custom_banners_pro_css' );
		}
	}
	
	/** 
	 * Adds Contact Help tabs to admin. Hooks into filter 
	 * "custom_banners_admin_help_tabs"
	 *
	 * @param array $tabs Array of GP_Sajak tabs. 
	 *
	 * @retutn array Modified list of tabs. All array entries require  
					 'id', 'label', 'callback', and 'options' keys.
	 */	 
	function add_help_tab($tabs)
	{
		$galahad = $this->Factory->get('GP_Galahad');
		$tabs[] = array(
			'id' => 'contact_support', 
			'label' => __('Contact Support', 'custom-banners'),
			'callback' => array($galahad, 'output_contact_page'),
			'options' => array('icon' => 'envelope-o')
		);
		return $tabs;
	}
	
	function init_updater()
	{
		$this->GP_Plugin_Updater = $this->Factory->get('GP_Plugin_Updater');		
	}	

	function init_galahad()
	{
		$this->GP_Galahad = $this->Factory->get('GP_Galahad');
	}	
	
//outputs the contents of the style settings tab	
	function style_settings_page()
	{
		//add upgrade button if free version
		
		//instantiate tabs object for output basic settings page tabs
		$tabs = new GP_Sajak( array(
			'header_label' => 'Style Options',
			'settings_field_key' => 'custom-banners-style-settings-group', // can be an array	
		) );
	
		do_action('custom_banners_admin_settings_page_top');
		$tabs->add_tab(
			'themes', // section id, used in url fragment
			'Style Settings', // section label
			array($this, 'output_style_settings'), // display callback
			array(
				'class' => 'extra_li_class', // extra classes to add sidebar menu <li> and tab wrapper <div>
				'icon' => 'gear' // icons here: http://fontawesome.io/icons/
			)
		);
		
		$tabs->display();			
	}
	
	//output the Style Settings
	function output_style_settings(){
		?>		
		<h3>Typography and Style Options</h3>
		<p>These options control the appearance of your banners and their captions.</p>
		<?php
	
		$disabled = false;
		
		?>
		<fieldset>
			<legend>Caption Background</legend>				
			<table class="form-table">
				<?php 
					$this->color_input('custom_banners_caption_background_color', 'Background Color', '#000000', $disabled);
					$this->text_input('custom_banners_caption_background_opacity', 'Background Opacity (percentage)', '', '70', $disabled);
				?>
			</table>
		</fieldset>

		<fieldset>
			<legend>Caption Text</legend>
			<table class="form-table">
				<?php
					$this->typography_input('custom_banners_caption_*', 'Caption Font', 'Please note: these settings can be overridden for each banner by using the Visual Editor.', '', '', '', '#ffffff', $disabled );
				?>
			</table>
		</fieldset>
					
		<fieldset>
			<legend>Call To Action (CTA) Button</legend>
			<table class="form-table">
				<?php
					$this->typography_input('custom_banners_cta_button_*', 'Font', '', '', '', '', '', $disabled);
					$this->color_input('custom_banners_cta_background_color', 'Background Color', '#ffa500', $disabled);
					$this->color_input('custom_banners_cta_border_color', 'Border Color', '#ff8c00', $disabled);
					$this->text_input('custom_banners_cta_border_radius', 'Border Radius', '', '5', $disabled);
				?>
			</table>
		</fieldset>
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
	
	function color_input($name, $label, $default_color = '#000000', $disabled = false)
	{		
		$val = get_option($name, $default_color);
		if (empty($val)) {
			$val = $default_color;
		}
		$this->shed->color(
			array(
				'name' => $name,
				'label' => $label,
				'default_color' => $default_color,
				'value' => $val,
				'disabled' => $disabled
			)
		);
	}	
	
	function typography_input($name, $label, $description = '', $default_font_family = '', $default_font_size = '', $default_font_style = '', $default_font_color = '#000080', $disabled = false)
	{
		$options = array(
			'name' => $name,
			'label' => $label,
			'default_color' => $default_font_color,
			'description' => $description,
			'google_fonts' => true,
			'values' => array(),
			'disabled' => $disabled			
		);
		$fields = array(
			'font_size' => $default_font_size,
			'font_family' => $default_font_family,
			'font_color' => $default_font_color,
			'font_style' => $default_font_style
		);
		foreach ($fields as $key => $default_value)
		{
			list($field_name, $field_id) = $this->shed->get_name_and_id($options, $key);
			$val = get_option($field_name, $default_value);
			if (empty($val)) {
				$val = $default_value;
			}			
			$options['values'][$key] = $val;
		}
		$this->shed->typography($options);
	}
	
	function add_transitions( $transitions )
	{
		$transitions = array_merge( 
			$transitions, 
			array(
				'scrollVert' => 'Vertical Scroll',
				'shuffle' => 'Shuffle',
				/*'carousel' => 'Carousel',*/
				'flipHorz' => 'Horizontal Flip',
				'flipVert' => 'Vertical Flip',
				'tileSlide' => 'Tile Slide'
			)
		);		
		ksort($transitions);
		return $transitions;
	}
	
	function add_cta_styles($styles, $banner_id)
	{
		$styles .= $this->build_typography_css('custom_banners_cta_button_');
		$styles .= $this->build_button_css('custom_banners_cta_');
		return $styles;
	}

	function add_caption_styles($styles, $banner_id)
	{
		$styles .= $this->build_typography_css('custom_banners_caption_');
		return $styles;
	}
	
	/*
	 * Builds a CSS string for the call to action button
	 *
	 * @param	$prefix		The prefix for the settings
	 *
	 * @returns	string		The completed CSS string, with the values inlined
	 */
	function build_button_css($prefix)
	{
		$css_rule_template = ' %s: %s;';
		$output = '';

		/* 
		 * Background Color
		 */
		$option_val = get_option($prefix . 'background_color', '');
		if (!empty($option_val)) {
			$output .= sprintf($css_rule_template, 'background-color', $option_val);
		}		
		
		/* 
		 * Border Color
		 */
		$option_val = get_option($prefix . 'border_color', '');
		if (!empty($option_val)) {
			$output .= sprintf($css_rule_template, 'border-color', $option_val);
		}		
		
		/* 
		 * Border Radius
		 */
		$option_val = get_option($prefix . 'border_radius', '');
		if (!empty($option_val)) {
			// append 'px' if needed
			if ( is_numeric($option_val) ) {
				$option_val .= 'px';
			}
			$output .= sprintf($css_rule_template, 'border-radius', $option_val);
		}

		// return the completed CSS string
		return trim($output);		
	}
	
	/*
	 * Builds a CSS string corresponding to the values of a typography setting
	 *
	 * @param	$prefix		The prefix for the settings. We'll append font_name,
	 *						font_size, etc to this prefix to get the actual keys
	 *
	 * @returns	string		The completed CSS string, with the values inlined
	 */
	function build_typography_css($prefix)
	{
		$css_rule_template = ' %s: %s;';
		$output = '';
		
		/* 
		 * Font Family
		 */
		 
		$option_val = get_option($prefix . 'font_family', '');
		if (!empty($option_val)) {
			// strip off 'google:' prefix if needed
			$option_val = str_replace('google:', '', $option_val);

		
			// wrap font family name in quotes
			$option_val = '\'' . $option_val . '\'';
			$output .= sprintf($css_rule_template, 'font-family', $option_val);
		}
		
		/* 
		 * Font Size
		 */
		$option_val = get_option($prefix . 'font_size', '');
		if (!empty($option_val)) {
			// append 'px' if needed
			if ( is_numeric($option_val) ) {
				$option_val .= 'px';
			}
			$output .= sprintf($css_rule_template, 'font-size', $option_val);
		}		
		
		/* 
		 * Font Color
		 */
		$option_val = get_option($prefix . 'font_color', '');
		if (!empty($option_val)) {
			$output .= sprintf($css_rule_template, 'color', $option_val);
		}

		/* 
		 * Font Style - add font-style and font-weight rules
		 * NOTE: in this special case, we are adding 2 rules!
		 */
		$option_val = get_option($prefix . 'font_style', '');

		// Convert the value to 2 CSS rules, font-style and font-weight
		// NOTE: we lowercase the value before comparison, for simplification
		switch(strtolower($option_val))
		{
			case 'regular':
				// not bold not italic
				$output .= sprintf($css_rule_template, 'font-style', 'normal');
				$output .= sprintf($css_rule_template, 'font-weight', 'normal');
			break;
		
			case 'bold':
				// bold, but not italic
				$output .= sprintf($css_rule_template, 'font-style', 'normal');
				$output .= sprintf($css_rule_template, 'font-weight', 'bold');
			break;

			case 'italic':
				// italic, but not bold
				$output .= sprintf($css_rule_template, 'font-style', 'italic');
				$output .= sprintf($css_rule_template, 'font-weight', 'normal');
			break;
		
			case 'bold italic':
				// bold and italic
				$output .= sprintf($css_rule_template, 'font-style', 'italic');
				$output .= sprintf($css_rule_template, 'font-weight', 'bold');
			break;
			
			default:
				// empty string or other invalid value, ignore and move on
			break;			
		}			

		// return the completed CSS string
		return trim($output);		
	}

	// Enqueue any needed Google Web Fonts
	function enqueue_webfonts()
	{
		$cache_key = '_custom_bs_webfont_str';
		$font_str = get_transient($cache_key);
		if ($font_str == false) {
			$font_list = $this->list_required_google_fonts();
			if ( !empty($font_list) ) {
				$font_list_encoded = array_map('urlencode', $font_list);
				$font_str = implode('|', $font_list_encoded);
			} else {
				$font_str = 'x';
			}
			set_transient($cache_key, $font_str);					
		}

		//don't register this unless a font is set to register
		if(strlen($font_str)>2) {
			$protocol = is_ssl() ? 'https:' : 'http:';
			$font_url = $protocol . '//fonts.googleapis.com/css?family=' . $font_str;
			wp_register_style( 'custom_banners_webfonts', $font_url );
			wp_enqueue_style( 'custom_banners_webfonts' );
		}
	}

	function list_required_google_fonts()
	{
		// check each typography setting for google fonts, and build a list
		$option_keys = array(
			'custom_banners_caption_font_family',
			'custom_banners_cta_button_font_family',
		);
		$fonts = array();
		foreach ($option_keys as $option_key) {
			$option_value = get_option($option_key);
			if (strpos($option_value, 'google:') !== FALSE) {
				$option_value = str_replace('google:', '', $option_value);
				
				//only add the font to the array if it was in fact a google font
				$fonts[$option_value] = $option_value;				
			}
		}
		return $fonts;
	}	
	
	
}