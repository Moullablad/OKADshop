<?php
/**
 * 2016 - 2017 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 - 2017 OKADshop
 */
include '../../../../../config/bootstrap.php';

$db = getDB();
$query = $_GET['query'];
$products = $db->prepare("SELECT p.reference, p.buy_price, p.discount, p.quantity, t.name FROM {$db->prefix}products p LEFT JOIN {$db->prefix}product_trans t ON t.id_product = p.id WHERE t.name LIKE '%$query%' OR p.reference LIKE '%$query%'");

$result['suggestions'] = [];
if ( !empty($products) ) : foreach ($products as $key => $product) :

	$result['suggestions'][] = array(
		'value' => $product->name,
		'data' => $product
	);

endforeach; endif;

echo json_encode($result);