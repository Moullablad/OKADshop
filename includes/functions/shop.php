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
 * THIS FILE GROUP ALL CORE FUNCTIONS
 * ------------------------------------------------------------------
 *
 *
 */

use Core\i18n\Translate;
use Core\Controllers\Front\ShopController;


/**
 * GET SHOP META
 *
 * @param string $field
 * @return string $value
 */
function get_shop($field=null){
	return ShopController::get($field);
}



/**
 * GET CURRENCY
 *
 * @return string $currency_sign
 */
function get_currency(){
	return $GLOBALS['os']->currency->sign;
}

/**
 * Get currencies
 *
 * @return array $currencies
 */
function get_currencies(){
	$db = getDB();
	return $db->prepare("SELECT * FROM `{$db->prefix}currencies` WHERE active=1");
}