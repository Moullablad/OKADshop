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
 * Register styles
 */
add_css('blockcart', ['src' => module_url(__FILE__, 'assets/css/blockcart.css')]);

/**
 * Display block cart.
 */
function display_block_cart(){
	$data['currency'] = get_currency();
    $data['cart'] = get_cart_items();
	get_view(__FILE__, 'front/blockcart', $data);
}
add_hook(__FILE__, 'header', 'display_block_cart', 'Block Cart', 'Display cart block.');