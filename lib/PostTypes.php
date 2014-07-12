<?php namespace WPDuel;
/**
* Post Types for WP Duel
*/
class PostTypes {

	public function __construct()
	{
		add_action( 'init', array( $this, 'contenders') );
		add_action( 'init', array( $this, 'duels' ) );
	}


	/**
	* The Contenders
	*/
	public function contenders()
	{
		$display = ( get_option('wpduel_post_type') == 'contender' ) ? true : false;
		$labels = array(
			'name' => __('Contenders'),  
			'singular_name' => __('Contender'),
			'add_new_item'=> 'Add Contender',
			'edit_item' => 'Edit Contender',
			'view_item' => 'View Contender'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,  
			'show_ui' => $display,
			'menu_position' => 5,
			'capability_type' => 'post',  
			'hierarchical' => false,  
			'has_archive' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'rewrite' => array('slug' => 'contender', 'with_front' => false),
			'menu_icon' => 'dashicons-groups'
		);
		register_post_type( 'contender' , $args );
	}


	/**
	* The Duels
	*/
	public function duels()
	{
		$labels = array(
			'name' => __('Duels'),  
			'singular_name' => __('Duel'),
			'add_new_item'=> 'Add Duel',
			'edit_item' => 'Edit Duel',
			'view_item' => 'View Duel'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,  
			'show_ui' => true,
			'menu_position' => 5,
			'capability_type' => 'post',  
			'hierarchical' => false,  
			'has_archive' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'rewrite' => array('slug' => 'contender', 'with_front' => false),
			'menu_icon' => 'dashicons-sort'
		);
		register_post_type( 'duel' , $args );
	}

}