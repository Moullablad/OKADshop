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

use Core\Controllers\Admin\ModuleController;

$name = $_POST['name'];
if( !is_ajax() || $name == '' ) return;

//activate module
$activate = ModuleController::enable($name);
if( $activate ){
	$return['success'] = trans("Module was activated.", "modules");
} else {
	$return['error'] = trans("Unable to activate module.", "modules");
}
echo json_encode( $return );