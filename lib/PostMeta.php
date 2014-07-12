<?php namespace WPDuel;
/**
* Custom Post Meta
*/
class PostMeta {

	public function __construct()
	{
		add_action( 'add_meta_boxes', [ $this, 'addMeta' ]);
		add_action( 'save_post', [ $this, 'saveMeta' ]);
	}


	/**
	* Register the Contenders Meta Box
	*/
	public function addMeta() 
	{
		add_meta_box( 
			'wpsl-meta-box', 
			'Contenders', 
			array($this, 'metaFields'), 
			'duel', 
			'normal', 
			'high' 
		);
	}


	/**
	* Meta Boxes for Output
	*/
	public function metaFields($post)
	{
		wp_nonce_field( 'my_wpduel_meta_box_nonce', 'wpduel_meta_box_nonce' ); 
		$contender_one = get_post_meta( $post->ID, 'wpduel_contender_one', true );
		$contender_two = get_post_meta( $post->ID, 'wpduel_contender_two', true );
		?>
		<div class="wpduel-meta">
			<p>
				<label for="wpduel_contender_one">Contender One</label>
				<select type="text" name="wpduel_contender_one" id="wpduel_contender_one">
					<?php echo $this->getContenderOptions($contender_one); ?>
				</select>
			</p>
			<p class="right">
				<label for="wpsl_city">Contender Two</label>
				<select type="text" name="wpduel_contender_two" id="wpduel_contender_two">
					<?php echo $this->getContenderOptions($contender_two); ?>
				</select>
			</p>
		</div>
		<?php
	}


	/**
	* Get a list of Contenders
	* @return array
	* @todo add post type logic for CPT
	*/
	private function getContenders()
	{
		$post_type = get_option('wpduel_post_type');
		$cont_query = new \WP_Query(['post_type'=>$post_type]);
		if ( $cont_query->have_posts() ) : while ( $cont_query->have_posts() ) : $cont_query->the_post();
			$contender[get_the_ID()] = get_the_title();
		endwhile; endif; wp_reset_postdata();
		return $contender;
	}


	/**
	* Get a list of options of contenders
	* @param Contender ID
	* @return HTML options
	*/
	private function getContenderOptions($id)
	{
		$contenders = $this->getContenders();
		$out = '';
		foreach ( $contenders as $key=>$contender ) {
			$out .= '<option value="' . $key . '"';
			if ( $key == $id ) $out .= ' selected';
			$out .= '>' . $contender . '</option>';
		}
		return $out;
	}


	/**
	* Save the custom post meta
	*/
	public function saveMeta( $post_id ) 
	{
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		// Verify the nonce & permissions.
		if( !isset( $_POST['wpduel_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wpduel_meta_box_nonce'], 'my_wpduel_meta_box_nonce' ) ) return;
		if( !current_user_can( 'edit_post' ) ) return;

		// Save Contender One
		if( isset( $_POST['wpduel_contender_one'] ) )
			update_post_meta( $post_id, 'wpduel_contender_one', esc_attr( $_POST['wpduel_contender_one'] ) );

		// Save Contender Two
		if( isset( $_POST['wpduel_contender_two'] ) )
			update_post_meta( $post_id, 'wpduel_contender_two', esc_attr( $_POST['wpduel_contender_two'] ) );
	}

}