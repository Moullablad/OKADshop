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
$id_product = intval($_POST['id_product']);
if( !is_ajax() || $id_product < 1 ) return;


$db = getDB();
$result = $db->prepare("select COUNT('*') as count
	from (
    select id_product from {$db->prefix}order_detail
    union all
    select id_product from {$db->prefix}invoice_detail
	) a
	where id_product=?", [$id_product], true
);
if( $result->count > 0 ){
	$return['message']['body'] = trans("Can't delete product because it was already ordered.", "catalogs");
	$return['message']['type'] = 'danger';
} else {
	$db->prepare("DELETE FROM `{$db->prefix}product_associated` WHERE `id_product`=?", [$id_product]);
	$db->prepare("DELETE FROM `{$db->prefix}product_attachments` WHERE `id_product`=?", [$id_product]);
	$db->prepare("DELETE FROM `{$db->prefix}product_category` WHERE `id_product`=?", [$id_product]);
	$db->prepare("DELETE FROM `{$db->prefix}product_images` WHERE `id_product`=?", [$id_product]);
	$db->prepare("DELETE FROM `{$db->prefix}product_tags` WHERE `id_product`=?", [$id_product]);
	//$db->prepare("DELETE FROM `{$db->prefix}product_declinaisons` WHERE `id_product`=?", [$id_product]);
	$db->prepare("DELETE FROM `{$db->prefix}declinaisons` WHERE `id_product`=?", [$id_product]);
	$db->prepare("DELETE FROM `{$db->prefix}product_trans` WHERE `id_product`=?", [$id_product]);
	$db->prepare("DELETE FROM `{$db->prefix}products` WHERE `id`=?", [$id_product]);
	$return['message']['body'] = trans("Product was deleted.", "catalogs");
	$return['message']['type'] = 'success';
}
echo json_encode( $return );