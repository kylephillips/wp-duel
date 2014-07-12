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
		add_action( 'save_post', [ $this, 'saveMeta' ]);
	}

	/**
	* Register the Duels Meta Box
	*/
	public function addMeta() 
	{
		add_meta_box( 
			'duel-meta-box', 
			'Duels', 
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
		?>
		<div class="wpduel-meta">
			<?php echo $this->duels($post); ?>
		</div>
		<?php
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
			$out .= '<p><a href="' . get_edit_post_link(get_the_ID()) . '">' . get_the_title($one) . ' vs ' . get_the_title($two) . '</a></p>';
		endwhile;
			return $out;
		else :
			return '<p>Not part of any duels at this time.</p>';
		endif; wp_reset_postdata();
	}

}