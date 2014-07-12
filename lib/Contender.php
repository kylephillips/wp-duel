<?php namespace WPDuel;

class Contender {

	/**
	* Get a Contender
	* @return array
	*/
	public function getContender($id = null)
	{
		$contender_query = new \WP_Query(array('post_type'=>get_option('wpduel_post_type'), 'p'=>$id));
		if ( $contender_query->have_posts() ) : while ( $contender_query->have_posts() ) : $contender_query->the_post();

			// Get the correct size based on setting
			$size = ( get_option('wpduel_custom_image_size') == 'yes' ) ? 'wpduel' : get_option('wpduel_wp_image_size');
			$thumb_id = get_post_thumbnail_id(get_the_ID());
			$image_src = wp_get_attachment_image_src($thumb_id, $size);
			$image_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);

			$contender['id'] = get_the_ID();
			$contender['title'] = get_the_title();
			$contender['image']['src'] = $image_src[0];
			$contender['image']['alt'] = $image_alt;

		endwhile; endif; wp_reset_postdata();
		return $contender;
	}

}