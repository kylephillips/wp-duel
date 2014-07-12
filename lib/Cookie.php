<?php namespace WPDuel;
/**
* Cookies
*/
class Cookie {

	public function __construct()
	{
		add_action('init', array($this, 'startSession'));
		add_action('init', array($this, 'storeCookie'));
	}

	/**
	* Start Session
	*/
	public function startSession()
	{
		if ( !session_id() ) session_start();
	}

	/**
	* Store Cookie
	*/
	public function storeCookie()
	{
		if ( isset($_SESSION['duel']) ){
			$completed = explode(',', $_COOKIE['duel']);
			if ( !in_array($_SESSION['duel'], $completed) ){
				$cookie = $_COOKIE['duel'] . ',' . $_SESSION['duel'];
				setcookie('duel', $cookie);
			}
		}
	}

}