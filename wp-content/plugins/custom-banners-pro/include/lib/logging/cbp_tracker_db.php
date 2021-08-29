<?php
global $custom_banners_pro_tracking_db_version;
$custom_banners_pro_tracking_db_version = '1.12';

class CBP_Tracker_DB
{
	function __construct($impressions_table_name = 'custom_banners_pro_impressions', $clicks_table_name = 'custom_banners_pro_clicks')
	{
		global $wpdb;
		$this->impressions_table_name = $wpdb->prefix . $impressions_table_name;
		$this->clicks_table_name = $wpdb->prefix . $clicks_table_name;
		$this->add_hooks();		
	}
	
	function add_hooks()
	{
		// make sure database tables are initialized
		add_action( 'plugins_loaded', array($this, 'update_db_check' ) );		
	}
	
	function log_impression($banner_id, $ip_address)
	{
		
		// record the impression in the global log
		global $wpdb;	
		$wpdb->insert(
			$this->impressions_table_name, 
			array( 
				'time' => current_time( 'mysql' ),
				'banner_id' => $banner_id,
				'ip_address' => $ip_address
			)
		);
		
		// increment the count on the banner itself
		$this->increment_view_count($banner_id);
	}
	
	function increment_view_count($banner_id, $to_add = 1)
	{
		// increment the count on the post itself
		$cur_val = get_post_meta($banner_id, 'cbp_impressions', true);
		if ( empty($cur_val) ) {
			$cur_val = 0;
		}
		
		$new_val = $cur_val + $to_add;
		$prev_val = $cur_val > 0 ? $cur_val : '';
		update_post_meta($banner_id, 'cbp_impressions', $new_val, $prev_val);
	}

	function find_recent_impression($banner_id, $ip_address, $grace_period = '30 minutes')
	{
		global $wpdb;
		/*$now = current_time( ); //RWG: i don't think this is used, and current_time needs to be passed 'timestamp' or 'mysql' to not throw a warning */
		$grace_period_starting_timestamp = strtotime( $grace_period . ' ago', current_time('timestamp') );
		$since = date( 'Y-m-d H:i:s', $grace_period_starting_timestamp);
		$sql = sprintf('SELECT * FROM %s WHERE `banner_id` = %d AND `ip_address` = "%s" AND time > "%s" LIMIT 1', $this->impressions_table_name, $banner_id, $ip_address, $since);
		$row = $wpdb->get_row($sql);
		return !empty($row);
	}
	
	function log_click($banner_id, $ip_address)
	{
		
		// record the click in the global log
		global $wpdb;	
		$r = $wpdb->insert(
			$this->clicks_table_name,
			array( 
				'time' => current_time( 'mysql' ),
				'banner_id' => $banner_id,
				'ip_address' => $ip_address
			)
		);

		// increment the count on the banner itself
		$this->increment_click_count($banner_id);
	}
	
	function increment_click_count($banner_id, $to_add = 1)
	{
		// increment the count on the post itself
		$cur_val = get_post_meta($banner_id, 'cbp_clicks', true);
		if ( empty($cur_val) ) {
			$cur_val = 0;
		}
		
		$new_val = $cur_val + $to_add;
		$prev_val = $cur_val > 0 ? $cur_val : '';
		update_post_meta($banner_id, 'cbp_clicks', $new_val, $prev_val);
	}

	function find_recent_click($banner_id, $ip_address, $grace_period = '30 minutes')
	{
		global $wpdb;
		/*$now = current_time( ); //RWG: i don't think this is used, and current_time needs to be passed 'timestamp' or 'mysql' to not throw a warning */
		$grace_period_starting_timestamp = strtotime( $grace_period . ' ago', current_time('timestamp') );
		$since = date( 'Y-m-d H:i:s', $grace_period_starting_timestamp);
		$sql = sprintf('SELECT * FROM %s WHERE `banner_id` = %d AND `ip_address` = "%s" AND time > "%s" LIMIT 1', $this->clicks_table_name, $banner_id, $ip_address, $since);
		$row = $wpdb->get_row($sql);
		return !empty($row);
	}
	
	function update_db_check()
	{
		global $custom_banners_pro_tracking_db_version;
		if ( get_site_option( 'custom_banners_pro_tracking_db_version' ) != $custom_banners_pro_tracking_db_version ) {
			$this->db_install();
		}
	}
	
	function db_install()
	{
		global $wpdb;
		global $custom_banners_pro_tracking_db_version;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );		
		$charset_collate = $wpdb->get_charset_collate();
		
		$impressions_table_sql = "CREATE TABLE {$this->impressions_table_name} (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			banner_id mediumint(9) DEFAULT 0 NOT NULL,
			ip_address text NOT NULL,
			PRIMARY KEY  id (id),
			KEY time_banner_ip (time, banner_id, ip_address(50))
		) $charset_collate;";
		$impressions_res = dbDelta( $impressions_table_sql );	
		
		$clicks_table_sql = "CREATE TABLE {$this->clicks_table_name} (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			banner_id mediumint(9) DEFAULT 0 NOT NULL,
			ip_address text NOT NULL,
			PRIMARY KEY  id (id),
			KEY time_banner_ip (time, banner_id, ip_address(50))
		) $charset_collate;";
		$clicks_res = dbDelta( $clicks_table_sql );
		
		update_option( 'custom_banners_pro_tracking_db_version', $custom_banners_pro_tracking_db_version );
	}

	function daily_impressions_for_period($period_start, $period_end, $banner_id)
	{
		return $this->daily_totals_for_period($this->impressions_table_name, $period_start, $period_end, $banner_id);
	}

	function daily_clicks_for_period($period_start, $period_end, $banner_id)
	{
		return $this->daily_totals_for_period($this->clicks_table_name, $period_start, $period_end, $banner_id);
	}

	function daily_ctr_for_period($period_start, $period_end, $banner_id)
	{
		$clicks = $this->daily_clicks_for_period($period_start, $period_end, $banner_id);
		$impressions = $this->daily_impressions_for_period($period_start, $period_end, $banner_id);
		$ctrs = array();
		foreach ( array_keys($clicks) as $key ) {
			$i = $impressions[$key];
			$c = $clicks[$key];
			$my_ctr = ($i > 0) ? ($c / $i) * 100 : 0;
			$my_ctr = min($my_ctr, 100);
			$my_ctr = number_format($my_ctr, 2);
			$ctrs[$key] = $my_ctr;
		}
		return $ctrs;
	}

	function daily_totals_for_period($table_name, $period_start, $period_end, $banner_id)
	{
		global $wpdb;
		$sql_template = 
"SELECT  DATE(time) Date, COUNT(DISTINCT id) totalCount
FROM    %s
WHERE	banner_id = %d
AND		time > '%s'
AND		time < '%s'
GROUP   BY  DATE(time)";
		$mysql_format = 'Y-m-d H:i:s';
		$mysql_start = date( $mysql_format, strtotime($period_start) );
		$mysql_end = date( $mysql_format, strtotime($period_end) );
		$sql = sprintf($sql_template, $table_name, $banner_id, $mysql_start, $mysql_end);
		$res = $wpdb->get_results( $sql, ARRAY_A );
		
		$daily_totals = array();
		foreach ( $this->date_range($period_start, $period_end) as $date ) {
			$daily_totals[$date] = 0;
		}
		
		if( empty($res) ) {
			return $daily_totals; // no records in period
		}
		else {
			// build array keyed on dates, one for each day,
			// with all values initialized to 0
			$daily_totals = array();
			foreach ( $this->date_range($period_start, $period_end) as $date ) {
				$daily_totals[$date] = 0;
			}
					
			// now "merge" the results from the database with this array
			// and also count up a total
			if ( !empty($res) ) {
				foreach ( $res as $row ) {
					$daily_totals[ $row['Date'] ] = intval($row['totalCount']);
				}
			}
		}
		return $daily_totals;
	}
	
	/**
	 * Creating date collection between two dates
	 *
	 * Source: http://stackoverflow.com/a/9225875
	 *
	 * <code>
	 * <?php
	 * # Example 1
	 * date_range("2014-01-01", "2014-01-20", "+1 day", "m/d/Y");
	 *
	 * # Example 2. you can use even time
	 * date_range("01:00:00", "23:00:00", "+1 hour", "H:i:s");
	 * </code>
	 *
	 * @author Ali OYGUR <alioygur@gmail.com>
	 * @param string since any date, time or datetime format
	 * @param string until any date, time or datetime format
	 * @param string step
	 * @param string date of output format
	 * @return array
	 */
	function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {

		$dates = array();
		$current = strtotime($first);
		$last = strtotime($last);

		while( $current <= $last ) {

			$dates[] = date($output_format, $current);
			$current = strtotime($step, $current);
		}

		return $dates;
	}
}