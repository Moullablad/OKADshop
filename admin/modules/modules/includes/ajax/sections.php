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
if( !is_ajax() || $section_name == '' ) return;


$hooks = get_section_hooks($section_name);

if( isset($hooks['active']) && !is_empty($hooks['active']) ){
	$activeRows = '';
	foreach ($hooks['active'] as $function => $hook) {
		$activeRows .= '<tr data-func="'. $function .'" data-name="'. $hook['module_name'] .'"><td width="75"><img src="'. get_module_icon($hook['module_name']) .'" class="img-thumbnail"></td><td><strong>'. $hook['name'] .'</strong><p>'. $hook['description'] .'</p></td><td width="50"><a href="#" class="btn btn-danger btn-xs delete_hook" data-func="'. $function .'" data-name="'. $hook['module_name'] .'">Remove</a></td></tr>';
	}
} else {
	$activeRows = '<tr class="norecord"><td colspan="3"><div class="alert alert-info alert-white rounded" id="message" style="display: block;margin: 12px auto;"><div class="icon"><i class="fa fa-info-circle"></i></div><strong>'. trans("There is no hook in this section.", "modules") .'</strong></div></td></tr>';
}


$inactiveRows = '';
if( isset($hooks['inactive']) && !is_empty($hooks['inactive']) ) {
	foreach ($hooks['inactive'] as $function => $hook) {
		$inactiveRows .= '["<img src=\"'. get_module_icon($hook['module_name']) .'\" class=\"img-thumbnail\">", "<strong>'. $hook['name'] .'</strong><p>'. $hook['description'] .'</p>", "<a href=\"#\" class=\"btn btn-default btn-xs add_hook\" data-func=\"'. $function .'\" data-name=\"'. $hook['module_name'] .'\">Add</a>"],';
	}
}

$return['active'] = $activeRows;
$return['inactive'] = '['. trim($inactiveRows, ",") .']';
echo json_encode( $return );