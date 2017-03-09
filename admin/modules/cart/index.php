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

include_once 'includes/tabs.php';
include_once 'includes/functions.php';



function cart_install(){
	$cart_labels = array(
		"add-to-cart" => array(
			"en" => "Add to cart",
			"fr" => "Ajouter au panier",
			"ar" => "أضف إلى السلة"
		),
		"try" => array(
			"en" => "Try",
			"fr" => "Essai",
			"ar" => "تجربة"
	 	),
		"subscribe" => array(
			"en" => "Subscribe",
			"fr" => "Souscrire",
			"ar" => "الاشتراك"
		),
		"ask-quotation" => array(
			"en" => "Ask quotation",
			"fr" => "Demande de devis",
			"ar" => "طلب اقتباس"
		),
		"book" => array(
			"en" => "Book Now",
			"fr" => "Réserver",
			"ar" => "حجز"
		),
		"buy" => array(
			"en" => "Buy",
			"fr" => "Acheter",
			"ar" => "شراء"
		)
	);
	$data = json_encode($cart_labels, JSON_UNESCAPED_UNICODE);
	save_meta_value('cart_labels', $data);
}


/**
 * Register javascripts
 *
 */
if( get_url_param('module') == 'catalogs' ){
	add_js('cart-module', [
		'src' => admin_url('modules/cart/assets/js/cart.js'), 
		'admin' => true,
		'front' => false
	]);
}
