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
$section_name = $_POST['section_name'];
$positions  = json_decode($_POST['positions']);
if( !is_ajax() || $positions == '' || $section_name == '' ) return;

$fail = 0;
foreach ($positions as $function => $pos) {
	$update = $db->prepare("UPDATE `{$db->prefix}module_hooks` SET `position`=? WHERE `section_name`=? AND `hook_function`=?", [$pos, $section_name, $function], true);
	if( !$update ) $fail +=1;
}


if( $fail === 0 ){
	$return['success'] = trans("Positions was updated.", "modules");
} else {
	$return['error'] = trans("Unable to update positions.", "modules");
}
echo json_encode( $return );