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


$id_comb = intval($_POST['id_comb']);
if( $id_comb < 1 ) return;



use Core\Models\Admin\Product;
$product = new Product();
$dec_data = $product->getCombByID($id_comb);

//Product Combinations
$attr_options = $json_combinations = '';
$attributes = $product->getAttributeValues($id_comb);
if( !is_empty($attributes) ){
	$json_combinations = '{';
	foreach ($attributes as $key => $attr) {
		$attr_options .= '<option value="'.$attr->id_value.'" groupid="'.$attr->id_attribute.'">'.$attr->attr_name.'&nbsp;&nbsp; : '.$attr->value_name.'</option>';

		//Generate Json attributes 
		$json_combinations .= ('"'.$key.'": {"id_value":"'.$attr->id_value.'","id_attribute":"'.$attr->id_attribute.'"},');
	}
	$json_combinations = substr($json_combinations, 0, -1);
	$json_combinations .= '}';
}

//Return
$return = array();
$return['dec_data'] = $dec_data;
$return['attributes'] = $attr_options;
$return['comb_json'] = $json_combinations;


echo json_encode($return);