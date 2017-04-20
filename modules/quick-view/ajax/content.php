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
include '../../../config/bootstrap.php';


$id_product = intval($_POST['id_product']);
if( !is_ajax() || $id_product < 1 ) return;


$product = get_product($id_product);
if ( !is_empty($product) ){


	//product tags
	// $data['tags'] = $controller->getTags($id_product);
	// $tmp = (array) $data['tags'];
	// $meta_keywords = "";
	// foreach ($tmp as $key => $value) {
	// 	$meta_keywords .= $value->name.",";
	// }

	$data['product'] = $product;
	$data['images'] = get_product_images($id_product);
	// $data['features'] = get_features($id_product);
	$data['combinations'] = get_combinations($id_product);

	ob_start(); // Initiate the output buffer
    ob_clean();
    get_view(__FILE__, 'front/quickview', $data);
	$content = ob_get_clean();
	$return['content'] = $content;

} else {
	$return['error'] = trans("unable to get product data.", "qv");
}

echo json_encode($return);