<?php namespace WPduel;
/**
* Plugin Activation
*/
class Activate {

	public function __construct()
	{
		register_activation_hook( dirname( dirname(__FILE__) ) . '/wpduel.php', array( $this, 'install' ) );
	}

	/**
	* Activation Hook
	*/
	public function install()
	{
		$this->setOptions();
		$this->createVotesTable();
	}

	/**
	* Set Default Options
	*/
	public function setOptions()
	{
		if ( !get_option('wpduel_post_type') ){
			update_option('wpduel_post_type', 'contender');
		}
		if ( !get_option('wpduel_show_image') ){
			update_option('wpduel_show_image', 'yes');
		}
		if ( !get_option('wpduel_custom_image_size') ){
			update_option('wpduel_custom_image_size', 'no');
		}
		if ( !get_option('wpduel_wp_image_size') ){
			update_option('wpduel_wp_image_size', 'thumbnail');
		}
		if ( !get_option('wpduel_image_width') ){
			update_option('wpduel_image_width', '150');
		}
		if ( !get_option('wpduel_image_height') ){
			update_option('wpduel_image_height', '150');
		}
		if ( !get_option('wpduel_track_votes') ){
			update_option('wpduel_track_votes', 'ip');
		}
		if ( !get_option('wpduel_output_styles') ){
			update_option('wpduel_output_styles', 'yes');
		}
		if ( !get_option('wpduel_output_js') ){
			update_option('wpduel_output_js', 'yes');
		}
	}


	/**
	* Create Votes Table
	*/
	public function createVotesTable()
	{
		global $wpdb;
		$tablename = $wpdb->prefix . 'wpduel_votes';
		if ( $wpdb->get_var('SHOW TABLES LIKE ' . $tablename) != $tablename ) :
			$sql = 'CREATE TABLE ' . $tablename . '(
				id INTEGER(10) UNSIGNED AUTO_INCREMENT,
				time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				user_ip VARCHAR(20),
				duel_id INTEGER(10),
				contender_one INTEGER(10),
				contender_two INTEGER(10),
				vote INTEGER(10),
				PRIMARY KEY  (id) )';
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		endif;
	}


}