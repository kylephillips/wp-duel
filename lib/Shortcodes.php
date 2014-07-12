<?php namespace WPDuel;

require_once('Duel.php');
require_once('Form.php');
require_once('Helpers.php');

/**
* Shortcodes
*/
class Shortcodes {

	public function __construct()
	{
		add_shortcode('wp_duel_form', array($this, 'wp_duel_form'));
	}


	/**
	* Exclude based on plugin setting
	* @return array of ids to exclude
	*/
	public function excludeDuels()
	{
		if ( get_option('wpduel_track_votes') == 'ip' ){
			$exclude = Helpers::getCompletedByIP();
		} else {
			$exclude = Helpers::getCompletedByCookie();
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
			$form_handler = new Form;
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