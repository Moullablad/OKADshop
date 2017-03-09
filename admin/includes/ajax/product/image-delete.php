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

use Core\Database\Database;
$db = Database::getInstance();

$id_image = intval($_POST['id_image']);
$id_product = intval($_POST['id_product']);
if( $id_image < 1 || $id_product < 1 ) return;

$image = $db->prepare("SELECT `name` FROM `{$db->prefix}product_images` WHERE `id`=?", [$id_image], true);
if( isset($image->name) ){
	$db->prepare("DELETE FROM {$db->prefix}product_images WHERE id=?", [$id_image]);
	$filename = get_filename($image->name);
	$mask = site_base() . 'files/products/'. $id_product .'/' . $filename . '-*.*';
	$unlink = array_map('unlink', glob($mask));
	$return['success'] = trans("Image was deleted.", "default");	
} else {
	$return['error'] = trans("Unable to delete image.", "default");	
}

echo json_encode($return);