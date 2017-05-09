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

$db = getDB();
$hook_func = $_POST['hook_func'];
$section_name = $_POST['section_name'];
if( !is_ajax() || $hook_func == '' || $section_name == '' ) return;

$delete = $db->prepare("DELETE FROM {$db->prefix}module_hooks WHERE section_name=? AND hook_function=?", [$section_name, $hook_func]);
if( $delete ){
	$return['success'] = trans("Hook was deleted.", "modules");
} else {
	$return['error'] = trans("Unable to delete hook.", "modules");
}
echo json_encode( $return );