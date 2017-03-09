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




//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

//get posted data
$id_product = intval($_POST['id_product']);
if( $id_product < 1 ) return;

//get product declinaisons
global $DB;
$query = "SELECT d.id as id_dec, a.name as attr_name, av.name as value_name
					FROM "._DB_PREFIX_."product_declinaisons pd, "._DB_PREFIX_."declinaisons d, "._DB_PREFIX_."attributes a, "._DB_PREFIX_."attribute_values av
					WHERE pd.id_declinaison=d.id
					AND pd.id_attribute=a.id
					AND pd.id_value=av.id
					AND d.id_product=$id_product";
if($row = $DB->pdo->query($query)){
  $product_comb = $row->fetchAll(PDO::FETCH_ASSOC);
  if( !empty($product_comb) ){
  	$options = '';
  	$dec_array = array();
		foreach ($product_comb as $key => $comb) {
			//$options .= '<option value="'. $comb['id_dec'] .'">'. $comb['attr_name'].' - '.$comb['value_name'] .'</option>';
			$dec_array[ $comb['id_dec'] ][] = $comb;
		}

		foreach ($dec_array as $dec_key => $dec) {
			$one_option = "";
			foreach ($dec as $key => $one) {
				$one_option .= $one['attr_name'].' - '.$one['value_name'].',';
			}
			$options .= '<option value="'. $dec_key .'">'. substr_replace($one_option, "", -1) .'</option>';
		}
		
		$response['dec'] = $options;
		echo json_encode($response);
  }else{
  	//get product data
  	$query = "SELECT p.id as id_product, p.name as product_name, p.reference as product_reference, 
  						p.sell_price as product_price, p.buy_price as product_buyprice, p.min_quantity as product_min_quantity,
          		p.discount as product_discount, p.discount_type, p.packing_price as product_packing, p.loyalty_points,
							p.weight as product_weight, p.height as product_height, p.width as product_width, p.depth as product_depth, 
							p.qty as product_stock, pi.name as product_image
							FROM `"._DB_PREFIX_."products` p
							LEFT JOIN "._DB_PREFIX_."product_images pi ON pi.id_product=p.id AND pi.futured=1
							WHERE p.id=". $id_product;
		if($row = $DB->pdo->query($query)){
		  $data = $row->fetch(PDO::FETCH_ASSOC);
		  if( !empty($data) ){
		  	echo json_encode($data);
		  }
		}
  }
}

