<?php namespace WPDuel;
use \WP_Query;
require_once('Contender.php');

/**
* Custom Post Meta for Contender Post Type
*/
class PostMetaContender {

	public function __construct()
	{
		add_action( 'add_meta_boxes', [ $this, 'addMeta' ]);
	}

	/**
	* Register the Duels Meta Box
	*/
	public function addMeta() 
	{
		add_meta_box( 
			'duel-meta-box', 
			'WP Duel', 
			array($this, 'metaFields'), 
			get_option('wpduel_post_type'), 
			'normal', 
			'high' 
		);
	}


	/**
	* Meta Boxes for Output
	*/
	public function metaFields($post)
	{
		echo '
		<div class="wpduel-contender-meta">
			<div class="duels"><ul>' .
			$this->duels($post) .
			'</ul></div>' . $this->getWinRatio($post);
		'</div>';
	}


	/**
	* Get the Duels this contender is part of
	* @param post object
	*/
	private function duels($post)
	{
		$duel_query = new WP_Query([
			'post_type' => 'duel',
			'posts_per_page' => -1,
			'meta_query' => [
				'relation' => 'OR',
				[
					'key' => 'wpduel_contender_one',
					'value' => $post->ID
				],
				[
					'key' => 'wpduel_contender_two',
					'value' => $post->ID
				]
			]
		]);
		if ( $duel_query->have_posts() ) : while ( $duel_query->have_posts() ) : $duel_query->the_post();
			$one = get_post_meta(get_the_ID(), 'wpduel_contender_one', true);
			$two = get_post_meta(get_the_ID(), 'wpduel_contender_two', true);
			$out .= '<li><a href="' . get_edit_post_link(get_the_ID()) . '">' . get_the_title($one) . ' vs ' . get_the_title($two) . '</a></li>';
		endwhile;
			return $out;
		else :
			return '<li>Not part of any duels at this time.</li>';
		endif; wp_reset_postdata();
	}


	/**
	* Get the Contender's Win Ratio
	*/
	private function getWinRatio($post)
	{
		if ( get_post_meta($post->ID, 'wpduel_win_ratio', true) ){
			return '<h3 class="win-ratio">Win Ratio: ' . get_post_meta($post->ID, 'wpduel_win_ratio', true) . '%</h3>';
		} else {
			return false;
		}
	}

}