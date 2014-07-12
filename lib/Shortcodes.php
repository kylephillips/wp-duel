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
		add_shortcode('wp_duel_form', [ $this, 'wp_duel_form' ] );
	}


	/**
	* Exclude based on plugin setting
	* @return array of ids to exclude
	*/
	public function excludeDuels()
	{
		$exclude = ( get_option('wpduel_track_votes') == 'ip' ) ? Helpers::getCompletedByIP() : Helpers::getCompletedByCookie();
		return $exclude;
	}


	/**
	* The Form Shortcode
	* @param Shortcode Parameters
	*/
	public function wp_duel_form($params)
	{
		$a = shortcode_atts([
			'duel' => null,
			'content' => null
		], $params );
		
		// Process the form or show it
		( isset($_POST['vote']) ) ? $form_handler = new Form : $this->formView($a);
	}


	/**
	* Form View
	* @return html
	*/
	private function formView($a)
	{
		$exclude = $this->excludeDuels();
		$duel = new Duel($duel_id = $a['duel'], $exclude = $exclude);
		$duel = $duel->getDuel();

		if ( $duel ) {
			$view = ( get_option('wpduel_output_js') == 'yes' ) ? 'wpduel-form.php' : 'wpduel-form-nojs.php';
			include( dirname( dirname(__FILE__) ) . '/views' . '/' . $view);
		} else {
			include( dirname( dirname(__FILE__) ) . '/views/all-complete.php');
		}
	}


}