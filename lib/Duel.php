<?php namespace WPDuel;

require_once('Contender.php');

class Duel {

	/**
	* Duel ID to get
	* @var int
	*/
	private $duel_id;

	/**
	* Duels to Exclude in Query
	* @var string (comma separated list)
	*/
	private $exclude;


	public function __construct($duel_id = null, $exclude = null)
	{
		$this->duel_id = $duel_id;
		$this->exclude = $exclude;
	}

	/**
	* Get a duel
	* @return array
	*/
	public function getDuel()
	{
		if ( $this->duel_id ){
			$args = [
				'post_type' => 'duel',
				'p' => $this->duel_id,
				'post__not_in' => $this->exclude,
				'posts_per_page' => 1
			];
		} else {
			$args = [
				'post_type' => 'duel',
				'post__not_in' => $this->exclude,
				'posts_per_page' => 1,
				'orderby' => 'rand'
			];
		}

		$duel_query = new \WP_Query($args);
		if ( $duel_query->have_posts() ) : 
			
			while ( $duel_query->have_posts() ) : $duel_query->the_post();

				$contender_one = get_post_meta(get_the_ID(), 'wpduel_contender_one', true);
				$contender_two = get_post_meta(get_the_ID(), 'wpduel_contender_two', true);

				$duel['title'] = get_the_title();
				$duel['duel_id'] = get_the_ID();
				$contender = new Contender;
				$duel['contender_one'] = $contender->getContender($contender_one);
				$duel['contender_two'] = $contender->getContender($contender_two);

			endwhile; 
		else :
			return false;
		endif; wp_reset_postdata();
		
		return $duel;
	}

}