<?php namespace WPDuel;

require_once('Duel.php');
require_once('Form.php');

/**
* Shortcodes
*/
class Shortcodes {

	public function __construct()
	{
		add_shortcode('wp_duel_form', array($this, 'wp_duel_form'));
	}


	/**
	* Get User's IP
	* @return string
	*/
	private function getIP()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}


	/**
	* Exclude based on plugin setting
	* @return array of ids to exclude
	*/
	public function excludeDuels()
	{
		if ( get_option('wpduel_track_votes') == 'ip' ){
			$exclude = $this->getCompletedByIP();
		} else {
			$exclude = $this->getCompletedByCookie();
		}
		return $exclude;
	}


	/**
	* Get Completed Duels by IP
	* @return array of ids completed
	*/
	private function getCompletedByIP()
	{
		global $wpdb;
		$tablename = $wpdb->prefix . 'wpduel_votes';
		$ip = $this->getIP();
		$sql = "SELECT duel_id FROM $tablename WHERE user_ip = '" . $ip . "'";
		$duels = $wpdb->get_results($sql);
		if ( $duels ){
			foreach ( $duels as $duel ){
				$exclude[] = $duel->duel_id;
			}
			$exclude[] = $_SESSION['duel'];
		} else {
			$exclude = null;
		}
		return $exclude;
	}


	/**
	* Get Completed Duels by Cookie
	* @return array of ids completed
	*/
	private function getCompletedByCookie()
	{
		if ( isset($_COOKIE['duel']) ) {
			$completed = $_COOKIE['duel'];
			$exclude = explode(',', $completed);
			$exclude[] = $_SESSION['duel'];
		} else {
			$exclude = null;
		}
		return $exclude;
	}


	/**
	* The Form Shortcode
	*/
	public function wp_duel_form($atts)
	{
		// Shortcode Parameters
		$a = shortcode_atts(array(
			'duel' => null,
			'content' => null
		), $atts );
		
		// Process the form or show it
		if ( isset($_POST['vote']) ){
			$form_handler = new Form($user_ip = $this->getIP());
		} else {
			$exclude = $this->excludeDuels();
			$duel = new Duel($duel_id = $a['duel'], $exclude = $exclude);
			$duel = $duel->getDuel();

			if ( $duel ) :
				$view = ( get_option('wpduel_output_js') == 'yes' ) ? 'wpduel-form.php' : 'wpduel-form-nojs.php';
				include( dirname( dirname(__FILE__) ) . '/views' . '/' . $view);
			else :
				include( dirname( dirname(__FILE__) ) . '/views/all-complete.php');
			endif;
		}
	}


}