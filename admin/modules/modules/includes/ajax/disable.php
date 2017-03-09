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
$disable = ModuleController::disable($name);
if( $disable ){
	$return['success'] = trans("Module was disabled.", "modules");
} else {
	$return['error'] = trans("Unable to disable module.", "modules");
}
echo json_encode( $return );