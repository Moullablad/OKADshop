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
$id_dec = intval($_POST['id_dec']);
if( $id_dec < 1 ) return;

//get product declinaisons
global $DB;
global $common;
$query = "SELECT p.id as id_product, p.name as product_name, d.reference as product_reference, 
          d.sell_price as product_price, p.buy_price as product_buyprice, d.min_quantity as product_min_quantity,
          p.discount as product_discount, p.discount_type, p.packing_price as product_packing, p.loyalty_points,
					d.weight as product_weight, p.height as product_height, p.width as product_width, p.depth as product_depth, 
          d.quantity as product_stock, d.images
					FROM "._DB_PREFIX_."declinaisons d, "._DB_PREFIX_."products p
					WHERE d.id=". $id_dec ." AND d.id_product=p.id";
if($row = $DB->pdo->query($query)){
  $data = $row->fetch(PDO::FETCH_ASSOC);
  if( !empty($data) ){
  	$images = $data['images'];
  	if( $images != "" ){
  		$image = $common->select('product_images', array('name'), "WHERE id IN ($images) ORDER BY id DESC LIMIT 1");
  		$data['product_image'] = $image[0]['name'];
  	}
  	echo json_encode($data);
  }else{
    echo json_encode("empty");
  }
}else{
  echo json_encode("query error");
}