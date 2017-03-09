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

use Core\Controllers\Front\OrderController;
use Core\Database\Database;




/**
 *
 * ADD ORDER STATE
 *
 * @param $name string
 * @param $template string
 * @return boolean
 */
function add_order_state($name, $template){
	return OrderController::addOrderState($name, $template);
}


/**
 *
 * GET ORDER STATE
 *
 * @param $template string
 * @return boolean
 */
function get_order_state($template){
	return OrderController::getOrderState($template);
}

/**
 *
 * DELETE ORDER STATE
 *
 * @param $template string
 * @return boolean
 */
function delete_order_state($template){
	return OrderController::getOrderState($template);
}



/**
 * GENERATE RANDOM REFERENCE
 *
 * @param int    $length number of caracters.
 * @return string $reference.
 */
function generate_reference($table) {
	$lastID = Database::getInstance()->select($table, array('id'), true);
    $reference = intval($lastID->id) + 1;
    $char_length = 9 - strlen( $reference );
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    for ($i = 0; $i < $char_length; $i++) {
        $reference .= $characters[rand(0, $charactersLength - 1)];
    }
    return str_shuffle($reference);
}