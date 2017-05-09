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


//exit if not have id_image
$id_image = intval($_POST['id_image']);
$id_product = intval($_POST['id_product']);
if( $id_image < 1 || $id_product < 1 ) return;


use Core\Database\Database;
$db = Database::getInstance();


$db->prepare("UPDATE `{$db->prefix}product_images` SET `futured`=0 WHERE `futured`=1 AND `id_product`=?", [$id_product]);


$update_cover = $db->prepare("UPDATE `{$db->prefix}product_images` SET `futured`=1 WHERE `id`=? AND `id_product`=?", [$id_image, $id_product]);


if( !empty($update_cover) ){
	$return['success'] = trans("Cover image was changed.", "default");
} else {
	$return['error'] = trans("Unable to change Image cover.", "default");
}

echo json_encode( $return );



