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
 *
 * ------------------------------------------------------------------
 * THEMES TABS
 * ------------------------------------------------------------------
 *
 */



/**
 * Register Themes Tabs
 *
 */
$themes_tabs = array(
	'featured' => array(
		'name' => trans("Featured", "themes"),
		'function' => 'themes_featured_tab',
		'with_head' => false,
		'with_form' => false
	),
	'popular' => array(
		'name' => trans("Popular", "themes"),
		'function' => 'themes_popular_tab',
		'with_head' => false,
		'with_form' => false
	),
	'latest' => array(
		'name' => trans("Latest", "themes"),
		'function' => 'themes_latest_tab',
		'with_head' => false,
		'with_form' => false
	),
	'upload' => array(
		'name' => trans("Upload Theme", "themes"),
		'function' => 'themes_upload_tab',
		'with_head' => false,
		'with_form' => false
	)
);
add_tabs(__FILE__, 'themes', $themes_tabs);


/**
 * Themes featured
 *
 */
function themes_featured_tab(){
	$data = array();
	get_view(__FILE__, 'tabs/themes/featured', $data);
}

/**
 * Themes popular
 *
 */
function themes_popular_tab(){
	$data = array();
	get_view(__FILE__, 'tabs/themes/popular', $data);
}

/**
 * Themes latest
 *
 */
function themes_latest_tab(){
	$data = array();
	get_view(__FILE__, 'tabs/themes/latest', $data);
}

/**
 * Themes upload
 *
 */
function themes_upload_tab(){
	$data = array();
	get_view(__FILE__, 'tabs/themes/upload', $data);
}