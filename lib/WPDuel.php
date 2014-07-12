<?php namespace WPDuel;

require_once('Activate.php');
require_once('PostTypes.php');
require_once('Settings.php');
require_once('PostMetaDuel.php');
require_once('PostMetaContender.php');
require_once('Dependencies.php');
require_once('Shortcodes.php');
require_once('Cookie.php');

/**
* Primary Plugin Class
*/
class WPDuel {

	/**
	* Plugin Version
	*/
	private $version;


	public function __construct()
	{
		$this->version = 0.1;
		add_filter( 'plugin_action_links_' . 'wpduel/wpduel.php', [ $this, 'settingsLink' ] );
		add_filter( 'the_content', [ $this, 'duel_single_view' ]);
		$this->init();
	}

	/**
	* Set the Plugin Version
	*/
	private function setVersion()
	{
		if ( !get_option('wpduel_version') ){
			update_option('wpduel_version', $this->version);
		}
		elseif ( get_option('wpduel_version') < $this->version ){
			update_option('wpduel_version', $this->version);	
		}
	}

	/**
	* Initialize Plugin
	*/
	public function init()
	{
		new Activate;
		new PostTypes;
		new Settings;
		new PostMetaDuel;
		new PostMetaContender;
		new Dependencies;
		new Shortcodes;
		$this->setVersion();
		$this->loadCookie();
	}


	/**
	* Add a link to the settings on the plugin page
	*/
	public function settingsLink($links)
	{ 
		$settings_link = '<a href="options-general.php?page=wp_duel">Settings</a>'; 
		array_unshift($links, $settings_link); 
		return $links; 
	}


	/**
	* Add the form/results to the Single View
	*/
	public function duel_single_view($content)
	{
		global $post;
		if ( is_singular('duel') ){
			$shortcode = new Shortcodes;
			$excluded = $shortcode->excludeDuels();
			if ( $excluded ){
				if ( !in_array($post->ID, $excluded) ){
					$content .= $shortcode->wp_duel_form(['duel' => $post->ID]);
				} else {
					$results = new Results($post->ID);
					$results->showResults();
				}
			} else {
				$content .= $shortcode->wp_duel_form(['duel' => $post->ID]);
			}
		}
		return $content;
	}


	/**
	* Load Cookie
	*/
	public function loadCookie()
	{
		if ( get_option('wpduel_track_votes') == 'cookie' ) $cookies = new Cookie;
	}

}