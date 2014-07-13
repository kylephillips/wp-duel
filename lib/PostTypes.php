<?php namespace WPDuel;
/**
* Post Types for WP Duel
*/
class PostTypes {

	public function __construct()
	{
		add_action( 'init', [ $this, 'contenders' ] );
		add_action( 'init', [ $this, 'duels' ] );
	}


	/**
	* The Contenders
	*/
	public function contenders()
	{
		$display = ( get_option('wpduel_post_type') == 'contender' ) ? true : false;
		$labels = [
			'name' => __('Contenders'),  
			'singular_name' => __('Contender'),
			'add_new_item'=> 'Add Contender',
			'edit_item' => 'Edit Contender',
			'view_item' => 'View Contender'
		];
		$args = [
			'labels' => $labels,
			'public' => true,  
			'show_ui' => $display,
			'menu_position' => 5,
			'capability_type' => 'post',  
			'hierarchical' => false,  
			'has_archive' => true,
			'supports' => ['title', 'editor', 'thumbnail'],
			'rewrite' => ['slug' => 'contender', 'with_front' => false],
			'menu_icon' => 'dashicons-groups'
		];
		register_post_type( 'contender' , $args );
	}


	/**
	* The Duels
	*/
	public function duels()
	{
		$labels = [
			'name' => __('Duels'),  
			'singular_name' => __('Duel'),
			'add_new_item'=> 'Add Duel',
			'edit_item' => 'Edit Duel',
			'view_item' => 'View Duel'
		];
		$args = [
			'labels' => $labels,
			'public' => true,  
			'show_ui' => true,
			'menu_position' => 5,
			'capability_type' => 'post',  
			'hierarchical' => false,  
			'has_archive' => true,
			'supports' => ['title', 'editor', 'thumbnail'],
			'rewrite' => ['slug' => 'duel', 'with_front' => false],
			'menu_icon' => 'dashicons-sort'
		];
		register_post_type( 'duel' , $args );
	}

}