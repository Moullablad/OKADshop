<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */

include '../../../config/bootstrap.php';




$product = new OS_Product();
$id_declinaison = $_POST['id'];

//Declinaison data
$dec_data = $product->getDeclinaisonByID($id_declinaison);
$id_product = $dec_data['id_product'];
$return = array();

//Product Combinations
$combinations = $product->getCombinations($id_product, $id_declinaison);
$comb_options = '';
if(isset($combinations) && !empty($combinations)){
	foreach ($combinations as $key => $value) {
		$comb_options .= '<option value="'.$value['id_value'].'" groupid="'.$value['id_attribute'].'">'.$value['attr_name'].'&nbsp;&nbsp; : '.$value['value_name'].'</option>';
	}
}

//Generate Json attributes 
$comb_json = $product->CombinationsToJson($id_declinaison);
$json_combinations  = '';
if(!empty($comb_json)){
	$json_combinations = '{';;
	foreach ($comb_json as $key => $comb) {
		$json_combinations .= ('"'.$key.'": {"id_value":"'.$comb['id_value'].'","id_attribute":"'.$comb['id_attribute'].'"},');
	}
	$json_combinations = substr($json_combinations, 0, -1);
	$json_combinations .= '}';
}

//Return
$return['dec_data'] 		= $dec_data;
$return['combinations'] = $comb_options;
$return['comb_json'] 		= $json_combinations;
echo json_encode($return);