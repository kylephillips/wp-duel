<?php namespace WPDuel;

class Helpers {

	/**
	* Get User's IP
	* @return string
	*/
	public static function getIP()
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
	* Get Completed Duels by IP
	* @return array of ids completed
	*/
	public static function getCompletedByIP()
	{
		global $wpdb;
		$tablename = $wpdb->prefix . 'wpduel_votes';
		$ip = self::getIP();
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
	public static function getCompletedByCookie()
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

}