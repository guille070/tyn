<?php
require_once('cbp_tracker_db.php');

global $custom_banners_db_version;
$custom_banners_db_version = '1.02';

class CBP_Tracker_Reports
{
	var $settings_key = 'custom_banners_pro_tracking_settings';
	
	function __construct($db)
	{
		$this->db = $db;
		$this->add_hooks();
	}
	
	function add_hooks()
	{		
		add_action( 'custom_banners_before_add_settings_link', array($this, 'add_reports_link_to_banners_menu') );
		add_action( 'custom_banners_admin_settings_submenu_pages', array($this, 'add_settings_tab' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array($this, 'register_scripts') );
		add_filter( 'admin_body_class', array($this, 'add_body_class') );
	}
	
	function add_body_class( $classes ) {
		$classes .= ' custom_banners_reports';
		return $classes;
	}
	
	function register_scripts($hook)
	{	
		
		if( strpos($hook,'custom-banners') !== false ){
			// register flot and plugins
			$flot_js_url = plugins_url( 'assets/flot/jquery.flot.min.js' , __FILE__ );
			wp_register_script( 'jquery-flot', $flot_js_url, array('jquery') );
			
			$flot_js_axislabels_url = plugins_url( 'assets/flot/jquery.flot.axislabels.min.js' , __FILE__ );
			wp_register_script( 'jquery-flot-axislabels', $flot_js_axislabels_url, array('jquery', 'jquery-flot') );
			
			$flot_js_time_url = plugins_url( 'assets/flot/jquery.flot.time.min.js' , __FILE__ );
			wp_register_script( 'jquery-flot-time', $flot_js_time_url, array('jquery', 'jquery-flot') );

			$jsUrl = plugins_url( 'assets/js/reports.js' , __FILE__ );
			$deps = array(
				'jquery',
				'jquery-ui-datepicker',
				'jquery-flot',
				'jquery-flot-axislabels',
				'jquery-flot-time',
			);
			wp_register_script( 'custom_banners_reports', $jsUrl, $deps );

			$cssUrl = plugins_url( 'assets/css/jquery-ui.css' , __FILE__ );
			wp_register_style( 'custom_banners_jquery-ui-style', $cssUrl );
			
			$cssUrl = plugins_url( 'assets/css/reports.css' , __FILE__ );
			wp_register_style( 'custom_banners_reports', $cssUrl, array('custom_banners_jquery-ui-style') );
		}
	}
	
	function add_settings_tab($submenu_pages, $top_level_slug = '')
	{
		$my_page[] = array(
			'parent_slug' => $top_level_slug,
			'page_title' => 'Reports',
			'menu_title' => 'Reports',
			'capability' => 'administrator',
			'menu_slug' => 'custom-banners-reports',
			'callback' => array($this, 'display_reports_page')
		);		
		$this->insert_submenu_page_after_target($submenu_pages, 'custom-banners-style-settings', $my_page);
		
		return $submenu_pages;
	}
	
	function add_reports_link_to_banners_menu()
	{
		$hook_suffix = add_submenu_page( 'edit.php?post_type=banner', 'Reports', 'Reports', 'administrator', 'custom-banners-reports-redirect', array($this, 'reports_link_redirect') ); 
		add_action("load-$hook_suffix", array($this, 'reports_link_redirect'));
	}

	function reports_link_redirect()
	{
		$settings_page_url = admin_url('admin.php?page=custom-banners-reports');
		wp_redirect($settings_page_url);
		exit();
	}	
	
	function display_reports_page()
	{					
		wp_enqueue_script('custom_banners_reports');
		wp_enqueue_style('custom_banners_reports'); 
			
		//output the tabs at the top of the page, for continuity
		do_action('custom_banners_admin_settings_page_top');
		
	?>
		<div id="custom_banners_reports" class="wrap">
			<h2>Banner Reports</h2>
			<p>Track the performance of your banners.</p>
			<?php 
				$banners = $this->get_banners_to_display();
				$selected_banner_id = 0;
				if ( !empty($_GET['banner_id']) ) {
					$selected_banner_id = intval($_GET['banner_id']);
				}
		
				printf( '<form id="custom_banners_report_filters" action="%s">', add_query_arg( null, null ) );
				$this->output_banner_select_box($banners);
				$this->output_time_range_selector($banners);
				echo '<div class="submit_wrapper"><button type="submit" class="button-primary">Run Report</button></div>';
				echo '<input type="hidden" name="page" value="custom-banners-reports" />';
				echo '</form>';
				
				$period_start = !empty($_GET['period_start']) ? $_GET['period_start'] . ' 12:00:00AM' : '';
				$period_end = !empty($_GET['period_end']) ? $_GET['period_end']  . ' 11:59:59PM' : '';
				
				foreach ($banners as $banner) {
					if ( $selected_banner_id > 0 && $selected_banner_id !== $banner->ID ) {
						continue;
					} else {
						$my_report = $this->get_banner_report($banner->ID, $period_start, $period_end);
						$this->display_banner_report($my_report);
					}
				}
			?>
		</div>
		<?php
	}
	
	function output_banner_select_box($banners, $selected_banner_id = 0)
	{
		if ( $selected_banner_id == 0 && !empty($_GET['banner_id']) ) {
			$selected_banner_id = intval($_GET['banner_id']);
		}
		
		$option_template = '<option value="%s" %s>%s</option>';
		echo '<div class="filter_field">';
			echo '<label for="banner_id">Banners</label><br />';
			echo '<select class="custom_banners_select_banner" id="banner_id" name="banner_id">';
				echo '<option value="">All Banners</option>';
				foreach($banners as $banner) {
					//var_dump($banner);
					$selected_attr = ($selected_banner_id == $banner->ID) ? 'selected="selected"' : '';
					printf( $option_template, $banner->ID, $selected_attr, htmlentities($banner->post_title) );
				}
			echo '</select>';
		echo '</div>';
	}
	
	function output_time_range_selector()
	{
		$fmt = 'm/d/Y';
		$period_start = !empty($_GET['period_start']) ? $_GET['period_start'] : date( $fmt, strtotime('first day of this month midnight') );
		$period_end = !empty($_GET['period_end']) ? $_GET['period_end'] : date( $fmt, strtotime('today 11:59:59PM ') );
		
		echo '<div class="filter_field">';
			echo '<label for="period_start">Start Date</label><br />';
			printf('<input type="text" id="period_start" class="datepicker" name="period_start" value="%s" />', htmlentities($period_start) );
		echo '</div>';		

		echo '<div class="filter_field">';
			echo '<label for="period_end">End Date</label><br />';
			printf('<input type="text" id="period_end" class="datepicker" name="period_end" value="%s" />', htmlentities($period_end) );
		echo '</div>';		
	}
	

	function get_banners_to_display()
	{
		$args=array(
		  'post_type' => 'banner',
		  'post_status' => 'publish',
		  'posts_per_page' => -1,
		  'ignore_sticky_posts'=> 1
		);
		return get_posts( $args );
	}
	
	function get_banner_report($banner_id, $period_start = '', $period_end = '', $interval = 'day')
	{
		$mysql_format = 'Y-m-d H:i:s';
		if ( empty($period_start) || empty($period_end) ) {	
			$period_start = date( $mysql_format, strtotime('first day of this month midnight') );
			$period_end = date( $mysql_format, strtotime('today 11:59:59PM ') );
		}
		
		// find total impressions matching time period
		$impressions = $this->db->daily_impressions_for_period($period_start, $period_end, $banner_id);

		// find total clicks matching time period
		$clicks = $this->db->daily_clicks_for_period($period_start, $period_end, $banner_id);
		
		// determine CTR
		$ctr = 0;//($impressions > 0) ? number_format( ($clicks / $impressions) * 100, 2) : 0;
		$ctr = $this->db->daily_ctr_for_period($period_start, $period_end, $banner_id);
		
		// convert daily to weekly or monthly if needed
		if ($interval == 'week' || $interval == 'month') {
			$impressions = $this->convert_interval($impressions, $interval);
			$clicks = $this->convert_interval($clicks, $interval);
			$ctr = $this->convert_interval($ctr, $interval);
		}

		// collect and return the results
		return compact('banner_id', 'period_start', 'period_end', 'impressions', 'clicks', 'ctr');
	}
	
	function convert_interval($input, $interval)
	{
		$out = array();
		if ($interval == 'week') {
			// $date_fmt = 'W'; // week number (1-53)
			$key_tmpl = 'Week %s'; // sprintf template
		}
		else if ($interval == 'month') {
			// $date_fmt = 'F'; // month name and year (e.g., January 2016 - Dec 2016)
			$key_tmpl = '%s'; // sprintf template
		}
		else {
			// invalid interval: return array unchanged
			return $input;
		}
			
		foreach ($input as $date_key => $val) {
			//$new_date = date( $date_fmt, strtotime($date_key) );
			$new_key = sprintf($key_tmpl, $new_date);
			
			if ( empty( $out[$new_key] ) ) {
				$out [ $new_key ] = $val;
			} else {
				$out [ $new_key ] += $val;
			}			
		}
		
		return $out;
	}
	
	function display_banner_report($report)
	{
		$banner = get_post($report['banner_id']);
		$totals = array(
			'impressions' => 0,
			'clicks' => 0,
		);
		printf( '<div class="banner_report banner_report-%d">', $banner->ID );
		printf( '<h3 class="banner_report_heading">%s</h3>', $banner->post_title );
		if ( !empty($report['impressions']) ) {
			$dates = array_keys($report['impressions']);
			
			$this->display_graph($dates, $report, $banner->ID);
			
			print('<table class="custom_banners_report_table" cellpadding="0" cellspacing="0">');
			print('<thead>');
			print('<th>Date</th>');
			print('<th>Impressions</th>');
			print('<th>Clicks</th>');
			print('<th>CTR</th>');
			print('</thead>');
			foreach ( $dates as $date ) {
				print('<tr>');
				printf( '<td>%s</td>', date('M d, Y', strtotime($date)) );
				printf( '<td>%s</td>', $report['impressions'][$date] );
				printf( '<td>%s</td>', $report['clicks'][$date] );
				printf( '<td>%s%%</td>', $report['ctr'][$date] );
				print('</tr>');
				
				$totals['impressions'] += $report['impressions'][$date];
				$totals['clicks'] += $report['clicks'][$date];
			}
			// print totals
			$total_ctr = min( ($totals['impressions'] > 0) ? ($totals['clicks'] / $totals['impressions']) * 100 : 0, 100 );
			print('<tr class="totals_row">');
			printf( '<td>%s</td>', __('Total') );
			printf( '<td>%s</td>', $totals['impressions'] );
			printf( '<td>%s</td>', $totals['clicks'] );
			printf( '<td>%s%%</td>', number_format($total_ctr, 2) );
			print('</tr>');
			
			
			print('</table>');
		}
		print('</div>');
	}
	
	function display_graph($dates, $report, $banner_id = '')
	{
		$flot_data_1 = array();
		$flot_data_2 = array();
		$flot_data_3 = array();
		
		foreach ( $dates as $date )
		{
			$row = array();
			$js_date = date( '\g\d(Y, n, j)', strtotime($date) );			
			$flot_data_1[] = array( $js_date, $report['impressions'][$date] );
			$flot_data_2[] = array( $js_date, $report['clicks'][$date] );
			$flot_data_3[] = array( $js_date, $report['ctr'][$date] );
		}
		
		$json_1 = json_encode($flot_data_1);
		$json_2 = json_encode($flot_data_2);
		$json_3 = json_encode($flot_data_3);
		printf( '<div class="custom_banners_graph" id="graph-%s" data-flot-data1="%s" data-flot-data2="%s" data-flot-data3="%s"></div>', $banner_id, htmlentities($json_1), htmlentities($json_2), htmlentities($json_3) );
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
}