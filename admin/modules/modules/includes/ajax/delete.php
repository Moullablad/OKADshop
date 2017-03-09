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

$module_name = $_POST['module_name'];
if( !is_ajax() || $module_name == '' ) return;

//disa module
$delete_module = ModuleController::delete($module_name);
if( $delete_module ){
	$return['success'] = trans("Module was deleted.", "modules");
} else {
	$return['error'] = trans("Unable to delete Module.", "modules");
}
echo json_encode( $return );