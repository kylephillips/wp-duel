<?php namespace WPDuel;
use \WP_Query;

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
	* Set the form Data
	*/
	private function setData()
	{
		$duel_id = sanitize_text_field($_POST['duel_id']);
		$vote = sanitize_text_field($_POST['vote']);
		$nonce = sanitize_text_field($_POST['wpduel-nonce']);
		$this->data = array(
			'nonce' => $nonce,
			'duel_id' => $duel_id,
			'vote' => $vote
		);
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
		$wpdb->insert( $tablename, 
			array( 
				'time' => date('Y-m-d H:i:s'), 
				'user_ip' => $this->user_ip, 
				'duel_id' => $this->data['duel_id'],
				'contender_one' => $this->contenders['one'],
				'contender_two' => $this->contenders['two'],
				'vote' => $this->data['vote']
			)
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
	*/
	private function displayError($message)
	{
		echo '<div class="error"><p>' . $message . '</p></div>';
	}


	/**
	* Get Contenders for Duel
	*/
	private function getContenders($duel_id)
	{
		$duel_query = new WP_Query(array('post_type'=>'duel','p'=>$duel_id));
		if ( $duel_query->have_posts() ) : while ( $duel_query->have_posts() ) : $duel_query->the_post();
			$contenders['one'] = get_post_meta(get_the_ID(), 'wpduel_contender_one', true);
			$contenders['two'] = get_post_meta(get_the_ID(), 'wpduel_contender_two', true);
			return $contenders;
		endwhile; endif; wp_reset_postdata();
	}


	/**
	* Set the contenders from form entry
	*/
	private function setContenders()
	{
		$this->contenders = $this->getContenders($this->data['duel_id']);
	}


}