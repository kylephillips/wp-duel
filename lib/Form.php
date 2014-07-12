<?php namespace WPDuel;
use \WP_Query;
require_once('Duel.php');
require_once('Results.php');
require_once('Helpers.php');

/**
* Form Handler for Voting
*/
class Form {

	/**
	* Form Data
	* @var array
	*/
	private $data;

	/**
	* User's IP Address
	* @var string
	*/
	private $user_ip;

	/**
	* Contenders for a duel
	* @var array
	*/
	private $contenders;


	public function __construct()
	{
		$this->user_ip = Helpers::getIP();
		$this->setData();
		$this->processForm();
	}


	/**
	* Set the form Data
	*/
	private function setData()
	{
		$this->data = [
			'nonce' => sanitize_text_field($_POST['wpduel-nonce']),
			'duel_id' => sanitize_text_field($_POST['duel_id']),
			'vote' => sanitize_text_field($_POST['vote'])
		];
	}


	/**
	* Process the form
	*/
	private function processForm()
	{
		if ( $this->validateData() ){
			$this->setContenders();
			$this->recordVote();
			$this->displayResults();
		}
	}


	/**
	* Validate the form Data
	*/
	private function validateData()
	{
		$data = $this->data;

		// Validate Nonce
		if ( !wp_verify_nonce( $data['nonce'], 'wpduel' ) ){
			$message = 'There was a problem processing your vote. Please try again.';
			$this->displayError($message);
			return false;
		}

		// Validate Duel ID
		if ( !is_numeric($this->data['duel_id']) ){
			$message = 'Invalid duel specified.';
			$this->displayError($message);
			return false;
		}

		// Validate Vote
		if ( !is_numeric($this->data['vote']) ){
			$message = 'Invalid vote specified.';
			$this->displayError($message);
			return false;
		}

		return true;
	}


	/**
	* Record the vote
	*/
	private function recordVote()
	{
		global $wpdb;
		$tablename = $wpdb->prefix . 'wpduel_votes';
		$wpdb->insert( $tablename,[
			'time' => date('Y-m-d H:i:s'), 
			'user_ip' => $this->user_ip, 
			'duel_id' => $this->data['duel_id'],
			'contender_one' => $this->contenders['one'],
			'contender_two' => $this->contenders['two'],
			'vote' => $this->data['vote']
			]
		);
		$_SESSION['duel'] = $this->data['duel_id'];
	}


	/**
	* Display the Results
	*/
	private function displayResults()
	{
		$results = new Results($duel = $this->data['duel_id'], $vote = $this->data['vote']);
		$results->showResults();
	}


	/**
	* Display a form error
	* @param string
	*/
	private function displayError($message)
	{
		echo '<div class="error"><p>' . $message . '</p></div>';
	}


	/**
	* Set the contenders from form entry
	*/
	private function setContenders()
	{
		$this->contenders = $this->getContenders($this->data['duel_id']);
	}


	/**
	* Get Contenders for Duel
	* @param int
	* @return array
	*/
	private function getContenders($duel_id)
	{
		$duel = new Duel($duel_id);
		$duel = $duel->getDuel();
		$contenders['one'] = $duel['contender_one']['id'];
		$contenders['two'] = $duel['contender_two']['id'];
		return $contenders;
	}


}