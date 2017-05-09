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

//This is an ajax request
if( !is_ajax() ){
	die();
}



$id_billing = intval($_POST['id_billing']);
if( $id_billing == 0 ){
	erase_session('addr_billing');
	create_session('use_same_address', 1);
}