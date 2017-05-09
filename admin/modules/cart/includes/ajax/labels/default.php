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
include '../../../../../../config/bootstrap.php';

//This is an ajax request
if( !is_ajax() )
{
	die();
}

$id_product = $_POST['id_product'];
$slug = $_POST['slug'];
if( $id_product < 1 || $slug == '' ) return;

$label_default = get_default_cart_label();;
$label_default[$id_product] = $slug;
$save_default = save_default_cart_label($label_default);

if( $save_default ){
	$return['success'] = trans("Default label was changed.", "default");
} else {
	$return['error'] = trans("Unable to change default label.", "default");
}
echo json_encode( $return );



