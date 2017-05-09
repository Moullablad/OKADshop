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

$modules = json_decode($_POST['modules']);
$action = $_POST['action'];
if( !is_ajax() || $modules == '' || $action == '' ) return;

$module_list = get_modules();
$return['success'] = trans("Action was executed.", "modules");
foreach ($modules as $module) {
	if( $module_list[$module]['category'] !== 'administration' ){
		if( $action == 'activate' ){
			$activate = ModuleController::enable($module);
			if( $activate ){
				$return['success'] = trans("Modules was activated.", "modules");
			} else {
				$return['error'] = trans("Unable to activate modules.", "modules");
			}
		} else if( $action == 'deactivate' ){
			$disable = ModuleController::disable($module);
			if( $disable ){
				$return['success'] = trans("Modules was disabled.", "modules");
			} else {
				$return['error'] = trans("Unable to disable modules.", "modules");
			}
		} else if( $action == 'delete' ){
			$delete_module = ModuleController::delete($module);
			if( $delete_module ){
				$return['success'] = trans("Modules was deleted.", "modules");
			} else {
				$return['error'] = trans("Unable to delete Modules.", "modules");
			}
		}
	}
}
echo json_encode( $return );