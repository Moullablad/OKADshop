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

if (!defined('_OS_VERSION_'))
  exit;

/**
 * Register translation domain
 */
add_domain(__FILE__, 'wishlist');



include_once 'includes/wishlist.php';


/**
 * Register medias
 */
add_css('wishlist', ['src' => module_url(__FILE__, 'assets/wishlist.css')]);
add_js('wishlist', ['src' => module_url(__FILE__, 'assets/wishlist.js')]);


/**
 * Register front pages
 */
function wishlist_front_page(){
	$data = $products = array();
	$wishlist = read_cookie('wishlist');
	if( $wishlist ){
		foreach ($wishlist as $key => $id_product) {
			echo $id_product.'<br>';
		}
	}
	$data['wishlist'] = $products;
	get_view(__FILE__, 'front/wishlist', $data);
}
add_front_page(__FILE__, 'wishlist', 'wishlist_front_page');



// use Core\i18n\Translate;

// var_dump(Translate::$domains);