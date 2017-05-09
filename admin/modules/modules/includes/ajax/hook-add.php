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

$module_name = $_POST['module_name'];
$section_name = $_POST['section_name'];
$hook_func = $_POST['hook_func'];
if( !is_ajax() || $hook_func == '' || $section_name == '' || $module_name == '' ) return;


$db = getDB();
$res = $db->prepare("SELECT position FROM {$db->prefix}module_hooks WHERE section_name=? ORDER BY position DESC", [$section_name], true);

if( isset($res->position) ){
	$position = $res->position + 1;
} else {
	$position = 1;
}

$insert = $db->create('module_hooks', array(
	'id_module' => get_module_by_name('id', $module_name),
	'section_name' => $section_name,
	'hook_function' => $hook_func,
	'position' => $position, 
	'cdate' => date("Y-m-d H:i:s") 
));
if( $insert ){
	$return['success'] = trans("Hook was added.", "modules");
} else {
	$return['error'] = trans("Unable to add hook.", "modules");
}
echo json_encode( $return );