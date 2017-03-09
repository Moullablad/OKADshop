<?php
//account wishlist tab 
$wishlist_tabs = array(
	'wishlist' => array(
		'name' => trans("My Favorites", "wishlist"),
		'function' => 'account_wishlist_tab',
		'position' => 5
	)
);
attach_tabs('account', 'account', $wishlist_tabs);


/**
 * Get wishlist products
 */
function account_wishlist_tab(){
	$products = array();
	$wishlist = (isset($_COOKIE['wishlist'])) ? $_COOKIE['wishlist'] : null;
	if( $wishlist != null ){
		$content = json_decode($wishlist, true);
		if( !empty($content) ){
			foreach ($content as $key => $id_product) {
				$products[] = get_product($id_product);
			}
		}
	}
	$data['wishlist'] = $products;
	get_view(__FILE__, 'front/tabs/wishlist', $data);
}