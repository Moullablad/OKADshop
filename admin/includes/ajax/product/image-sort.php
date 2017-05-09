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

include '../../../../config/bootstrap.php';

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

$positions = json_decode($_POST['positions'], true);
if( $positions == '' ) return;


use Core\Database\Database;
$db = Database::getInstance();

foreach ($positions as $id_image => $position) {
	$db->prepare("UPDATE `{$db->prefix}product_images` SET `position`=? WHERE `id`=?", [$position, $id_image]);
}

$return['success'] = trans("Positions was updated.", "default");
echo json_encode( $return );