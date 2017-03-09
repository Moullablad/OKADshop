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
use Core\Models\Admin\Product;


$product = new Product();
$db = Database::getInstance();

$id_comb = intval($_POST['id_comb']);
$id_product = intval($_POST['comb']['id_product']);
$combData = $_POST['comb'];
if( is_empty($combData) ) return false;


//default combination
$default_comb = $_POST['comb']['default_dec'];
if( !isset($default_comb) || empty($default_comb) ){
	$combData['default_dec'] = 0;
} 





//check if images selected
if( !empty($_POST['comb']['images']) ){
	$combData['images'] = json_encode($_POST['comb']['images']);
}

//start saving data
if( isset($id_comb) && $id_comb > 0){


	//get default value
	$default = $db->find('declinaisons', $id_comb, array('default_dec') );
	if( $combData['default_dec'] == "1" && $default->default_dec == "0" ){
		$db->prepare("UPDATE `{$db->prefix}declinaisons` SET `default_dec`=0 WHERE `id_product`=?", [$id_product]);
	}

	$db->update('declinaisons', $id_comb, $combData);
	$return['success'] = trans("Combinations was updated.", "default");

}else{

	if( $combData['default_dec'] == "1" ){
		$db->prepare("UPDATE `{$db->prefix}declinaisons` SET `default_dec`=0 WHERE `id_product`=?", [$id_product]);
	}
	$id_comb = $db->create('declinaisons', $combData);
	$return['success'] = trans("Combinations was created.", "default");
	$return['id_comb'] = $id_comb;

}





//Insert combinations
$attr_ids = array();
$attributes = json_decode($_POST['attributes']);
foreach ($attributes as $key => $attr) {
	$attr_ids[] = $attr->id_attribute;

	$id_product_attr = $product->attrExist($id_comb, $attr->id_attribute);
	if( $id_product_attr ){

		$db->update('product_declinaisons', $id_product_attr, array('id_value' => $attr->id_value) );
		
	} else {
		$fields = array(
			'id_declinaison' => $id_comb, 
			'id_attribute' => $attr->id_attribute, 
			'id_value' => $attr->id_value
		);
		$db->create('product_declinaisons', $fields);
	}

}

//delete old attrs
if( !empty($attr_ids) ){

	$ids = implode(',', $attr_ids);
	$db->prepare("DELETE FROM {$db->prefix}product_declinaisons WHERE id_declinaison=? AND id_attribute NOT IN ($ids)", [$id_comb]);

	echo json_encode( $return );

} else {
	unset($return['success']);
	$return['error'] = trans("Error occurred, please try again.", "default");
	echo json_encode( $return );
}