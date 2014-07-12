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


	/**
	* Calculate & Set a Contender's Win Ratio
	* @param int
	*/
	public static function setRatio($contender)
	{
		global $wpdb;
		$tablename = $wpdb->prefix . 'wpduel_votes';

		// Total Votes
		$sql = "SELECT COUNT(*) FROM $tablename WHERE contender_one = $contender OR contender_two = $contender";
		$total_votes = $wpdb->get_var($sql);
		
		// Total Wins
		$sql = "SELECT COUNT(*) FROM $tablename WHERE (contender_one = $contender OR contender_two = $contender) AND vote = $contender";
		$total_wins = $wpdb->get_var($sql);

		// Calculate the ratio
		$win_ratio = ( $total_wins / $total_votes ) * 100;
		$win_ratio = round($win_ratio);
		
		if ( get_post_meta($contender, 'wpduel_win_ratio') ){
			update_post_meta($contender, 'wpduel_win_ratio', $win_ratio);
		} else {
			add_post_meta($contender, 'wpduel_win_ratio', $win_ratio);
		}
		
	}

}