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
include '../../../../../config/bootstrap.php';

$name = $_POST['name'];
if( !is_ajax() || $name == '' ) return;

$save = save_meta_value('default_shop_theme', $name);
if( $save ){
	$return['success'] = trans("Theme was enabled.", "themes");
} else {
	$return['error'] = trans("Error occurred, please try again.", "themes");
}
echo json_encode( $return );