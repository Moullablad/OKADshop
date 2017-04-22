<?php
/**
 * 2016 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 OKADshop
 */

class Seo {
	
	/**
     * Meta array
     * @var Meta $metas
     */
	public static $metas = [];
	
	/**
     * Meta array
     * @var Meta $settings
     */
	public static $settings = [];
	
	/**
     * Meta array
     * @var Meta $separator
     */
	public static $separator;

	/**
     * Shop array
     * @var Shop $pageName
     */
	public static $pageName;

	/**
     * Page array
     * @var Page $url
     */
	public static $url;

	/**
     * Shop array
     * @var Shop $title
     */
	public static $title;

	/**
     * Shop array
     * @var Shop $description
     */
	public static $description;

	/**
     * Shop array
     * @var Shop $keywords
     */
	public static $keywords;



	/**
     * Register Metas
     *
     * @param string $property
     * @param string $content
     * @param string $type
     * @param string $newline
     * @param void
     */
	public static function addMeta($property, $content = '', $type = 'name') {
		self::$metas[$property] = array(
			'id' => '',
			'content' => $content, 
			'type' => $type
		);
	}

	/**
     * Get Metas
     *
     * @return $metas array
     */
	public static function getMetas() {
		return self::$metas;
	}

	/**
     * Get Settings
     *
     * @return $settings array
     */
	public static function getSettings() {
		return self::$settings;
	}


	/**
     * Initialize Seo metas
     *
     * @return void
     */
	public static function metaInit() {
		$shop = get_shop();
		// self::$metas = get_seo_metas(); //Get metas
		// self::$settings = get_seo_settings(); //Get settings
		self::$separator = self::$settings['general']['title']['separator'];
		self::$url = get_current_url();
		$geoPosition = $shop->latitude .', '. $shop->longitude;

		if( empty(self::$pageName) ) self::$pageName = $shop->name;
		if( empty(self::$title) ){
			if( is_home() ) {
				self::$title = $shop->tagline;
			} else if( isset($_GET['Module']) ){
				self::$title = ucfirst($_GET['Module']);
				if( isset($_GET['ID']) ) {
					self::$title .= ' - '. ucfirst($_GET['ID']);
				}
			}
		}
		if( empty(self::$description) ) self::$description = $shop->meta_description;
		// if( empty(self::$keywords) && !is_home() ) self::$keywords = $shop->meta_keywords;
		// $keywords = self::$settings['general']['keywords'];
		// if( $keywords!='' ) self::$keywords = $keywords;
		// if( is_home() ) self::$keywords = $shop->meta_keywords;

	    //Set title and description
	    $max_title = self::$settings['general']['title']['max'];
	    $title = letters_limit(self::$title, $max_title);
	    $max_desc  = self::$settings['general']['description']['max'];
	    $description = letters_limit(self::$description, $max_desc);

	    //General
	    self::$metas['viewport']['content'] = self::$settings['general']['misc']['viewport'];
	    self::$metas['robots']['content'] = self::$settings['general']['misc']['robots'];
	    $canonical = self::$settings['general']['misc']['canonical'];
	    self::$metas['canonical']['content'] = ( $canonical == '1' ) ? site_url() : '';
	   
	    self::$metas['description']['content'] = $description;
	    $keywords = self::$settings['general']['keywords'];
	    $keywords = (is_array($keywords)) ? implode(', ', $keywords) : $keywords;
	    $keywords = ( $keywords != '' ) ? $keywords : self::$keywords;
		if( is_home() ) $keywords = $shop->meta_keywords;
	    self::$metas['keywords']['content'] = $keywords;

	    self::$metas['DC.Title.Alternative']['content'] = $title;
	    self::$metas['DC.Description']['content'] = $description;
	    self::$metas['DC.Subject']['content'] = $keywords;

	    self::$metas['copyright']['content'] = self::$settings['general']['misc']['copyright'];
	    self::$metas['geo.position']['content'] = $geoPosition;
	    self::$metas['author']['content'] = self::$settings['general']['misc']['author'];

		$publisher = self::$settings['general']['misc']['publisher'];
		if( $publisher != '' ){
	    	self::$metas['publisher']['content'] = 'https://plus.google.com/'. $publisher;
		}

		self::ogInit();	//Initialize Open Graph metas
		self::twitterInit(); //Initialize Twitter metas 
		self::webMasterInit(); //Initialize webmasters metas
	}


	/**
     * Initialize Open Graph metas
     *
     * @return void
     */
	public static function ogInit() {
	    $og_title = self::$metas['og:title']['content'];
	    self::$metas['og:title']['content'] = self::$title;
	    self::$metas['og:description']['content'] = self::$description;
	    self::$metas['og:url']['content'] = self::$url;
	    self::$metas['og:site_name']['content'] = get_shop('name');
	    self::$metas['og:type']['content'] = self::$settings['og']['type'];
	  	$lang = get_lang('locale');
	    $locale = str_replace('_', '-', $lang);
	    self::$metas['og:locale']['content'] = strtolower($locale);
	}


	/**
     * Initialize Twitter metas
     *
     * @return void
     */
	public static function twitterInit() {
	    $tw_title = self::$metas['twitter:title']['content'];
	    self::$metas['twitter:title']['content'] = ( $tw_title != '' ) ? $tw_title : self::$title;
	    self::$metas['twitter:description']['content'] = self::$description;
	    self::$metas['twitter:url']['content'] = self::$url;
	    self::$metas['twitter:card']['content'] = self::$settings['twitter']['card'];
	    self::$metas['twitter:site']['content'] = self::$settings['twitter']['site'];
	    self::$metas['twitter:creator']['content'] = self::$settings['twitter']['site'];
	}


	/**
     * Initialize web masters metas
     *
     * @return void
     */
	public static function webMasterInit() {
		//Webmasters Tools
	    self::$metas['google-site-verification']['content'] = self::$settings['webmasters']['google'];
	    self::$metas['google-signin-client_id']['content'] = self::$settings['webmasters']['client_id'];
	    self::$metas['msvalidate.01']['content'] = self::$settings['webmasters']['bing'];
	    self::$metas['alexaVerifyID']['content'] = self::$settings['webmasters']['alexa'];
	    self::$metas['p:domain_verify']['content'] = self::$settings['webmasters']['pinterest'];
	    self::$metas['yandex-verification']['content'] = self::$settings['webmasters']['yandex'];
	}



//END CLASS	
}

