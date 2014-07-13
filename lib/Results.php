<?php namespace WPDuel;

require_once('Duel.php');
require_once('Contender.php');

class Results {

	/**
	* Duel ID
	* @var int
	*/
	private $duel_id;


	/**
	* Contender ID
	* @var int 
	*/
	private $vote;


	/**
	* Duel Results
	* @var array
	*/
	private $results;


	public function __construct($duel_id = null, $vote = null)
	{
		$this->duel_id = $duel_id;
		$this->vote = $vote;
		$this->getDuel();
	}


	/**
	* Get the Duel
	*/
	private function getDuel()
	{
		$duel = new Duel($this->duel_id);
		$duel = $duel->getDuel();
		$this->setResults($duel);
	}


	/**
	* Results View
	*/
	public function showResults()
	{
		$view = ( get_option('wpduel_results_view') == 'text' ) ? 'wpduel-results.php' : 'wpduel-results-chart.php';
		include( dirname( dirname(__FILE__) ) . '/views/' . $view);
	}


	/**
	* Set the Results
	* @param int
	*/
	private function setResults($duel)
	{
		$this->results->contender_one['title'] = $duel['contender_one']['title'];
		$this->results->contender_one['id'] = $duel['contender_one']['id'];
		$this->results->contender_one['image'] = $duel['contender_one']['image']['src'];
		$this->results->contender_one['total_votes'] = $this->getTotalVotes($duel['contender_one']['id']);
		$this->results->contender_two['title'] = $duel['contender_two']['title'];
		$this->results->contender_two['id'] = $duel['contender_two']['id'];
		$this->results->contender_two['image'] = $duel['contender_two']['image']['src'];
		$this->results->contender_two['total_votes'] = $this->getTotalVotes($duel['contender_two']['id']);
		$this->results->total_votes = $this->totalDuelVotes();
		$this->results->contender_one['percentage'] = $this->winningPercentage($this->results->contender_one['total_votes']);
		$this->results->contender_two['percentage'] = $this->winningPercentage($this->results->contender_two['total_votes']);
		if ( $this->vote ) $this->results->vote = $this->getContenderTitle();
	}


	/**
	* Get Total Votes for a Contender
	* @param int
	* @return int
	*/
	private function getTotalVotes($contender_id)
	{
		global $wpdb;
		$tablename = $wpdb->prefix . 'wpduel_votes';
		$sql = "SELECT COUNT(vote) FROM $tablename WHERE duel_id = $this->duel_id AND vote = $contender_id";
		$count = $wpdb->get_var($sql);
		return $count;
	}


	/**
	* Total Votes for the Duel
	* @return int
	*/
	private function totalDuelVotes()
	{
		$total = $this->results->contender_one['total_votes'] + $this->results->contender_two['total_votes'];
		return $total;
	}	


	/**
	* Get Contender winning percentage for the duel
	* @param int
	* @return int
	*/
	private function winningPercentage($total_votes)
	{
		$percentage = ( $total_votes / $this->totalDuelVotes() ) * 100;
		$percentage = round($percentage);
		return $percentage;
	}


	/**
	* Get Contender Name User Voted for
	*/
	private function getContenderTitle()
	{
		$contender = new Contender;
		$contender = $contender->getContender($this->vote);
		$contender_title = $contender['title'];
		return $contender_title;
	}

}