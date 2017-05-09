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
include '../../../config/bootstrap.php';

use Core\Cookie;


$id_product = intval($_POST['id_product']);
if( !is_ajax() || $id_product < 1 ) return;


$wishlist = array();
$cookie_wishlist = Cookie::get('wishlist');
if( $cookie_wishlist ){
	$wishlist = unserialize($cookie_wishlist);
}
array_push($wishlist, $id_product);

if ( Cookie::set('wishlist', serialize($wishlist)) ){

	ob_start(); // Initiate the output buffer
    ob_clean();
    get_view(__FILE__, 'front/success', $data);
	$content = ob_get_clean();
	$return['content'] = $content;

} else {
	$return['error'] = trans("Unable to add product to wishlist.", "wishlist");
}

echo json_encode($return);