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

use Core\Controllers\Front\UserController;
use Core\Controllers\Front\OrderController;
use Core\Controllers\Front\AddressController;


/**
 * Get user data
 *
 * @param string $id_user
 * @return string $data
 */
function get_user_data($id_user=null){
	return UserController::getData();
}

/**
 * GET USER META
 *
 * @param string $key
 * @return string $meta
 */
function get_user($key=null){
	return UserController::get($key);
}

/**
 *
 * CHECK IF USER LOGGED
 *
 * @param string $key
 * @return string $meta
 */
function logged(){
	return UserController::logged();
}


/**
 * Generate password
 * 
 * @return string $password.
 **/
function rand_password() {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$password = '';
	for ($i = 0; $i < 10; $i++) {
	  $password .= $characters[rand(0, $charactersLength - 1)];
	}
	return $password;
}


/**
 * Get user avatar
 * 
 * @param $id_user int
 * @return string $avatar.
 */
function get_avatar($id_user){
	//We just return default avatar for this moment
	return site_url() . 'assets/img/icons/avatar.jpg';
}


/**
 * Get address by ID
 * 
 * @param $id_address int
 * @return array $address.
 */
function get_address($id_address){
	if( is_valid_int($id_address) ){
		return AddressController::getAddressByID($id_address);
	}
	return false;
}


/**
 * Get user addresses
 * 
 * @param $id_user int
 * @return array $addresses.
 */
function get_addresses($id_user){
	if( is_valid_int($id_user) ){
		return AddressController::getAddresses($id_user);
	}
	return false;
}

/**
 * Delete address by ID
 * 
 * @param $id_address int
 * @return bool.
 */
function delete_address($id_address){
	return AddressController::delete($id_address);
}


/**
 * Get user Orders
 * 
 * @param $id_user int
 * @return array $orders.
 */
function get_orders($id_user=null){
	if( is_null($id_user) ) {
		$id_user = get_user('id');	
	}
	return OrderController::getOrders($id_user);
}