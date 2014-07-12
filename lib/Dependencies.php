<?php namespace WPDuel;
/**
* Plugin Dependencies
*/
class Dependencies {

	public function __construct()
	{
		add_action( 'admin_head', [ $this, 'adminStyles' ]);
		add_action( 'wp_head', [ $this, 'highlightColor' ]);
		add_action( 'admin_enqueue_scripts', [ $this, 'adminScripts' ]);
		add_action( 'wp_enqueue_scripts', [ $this, 'frontEndStyles' ]);
		add_action( 'wp_enqueue_scripts', [ $this, 'frontEndScripts' ]);
	}

	/**
	* Admin Styles
	*/
	public function adminStyles($page)
	{
		echo '<link rel="stylesheet" href="' . plugins_url() . '/wpduel/assets/css/wpduel-admin.css' . '" type="text/css">';
		echo "\n";
	}

	/**
	* Admin Scripts
	*/
	public function adminScripts()
	{
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_style( 'wp-color-picker' );
	}

	/**
	* Front-end Styles
	*/
	public function frontEndStyles()
	{
		if ( get_option('wpduel_output_styles') == 'yes' ){
			wp_enqueue_style('wpduel', plugins_url() . '/wpduel/assets/css/wpduel.css', '', '1.0', 'all');
		}
	}

	/**
	* Highlight color option
	*/
	public function highlightColor()
	{
		if ( get_option('wpduel_highlight_color') ){
			echo '<style type="text/css">';
			echo '.highlight {color: ' . get_option('wpduel_highlight_color') . ' !important;}';
			echo '.highlightbg {background-color: ' . get_option('wpduel_highlight_color') . ' !important;}';
			echo '.wpduel-switch span {background-color: ' . get_option('wpduel_highlight_color') . ' !important;}';
			echo '.wpduel-form .contenders .contender.active h3 {color: ' . get_option('wpduel_highlight_color') . ' !important;}';
			echo '</style>';
		}
	}

	/**
	* Front-end Scripts
	*/
	public function frontEndScripts()
	{
		if ( get_option('wpduel_output_js') == 'yes' ){
			wp_enqueue_script('wpduel', plugins_url() . '/wpduel/assets/js/wpduel.min.js', array('jquery'), '1.0');
			wp_localize_script(
				'wpduel',
				'wpduel',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'locatorNonce' => wp_create_nonce( 'wpduel-duel-nonce' )
			));
		}
	}

}