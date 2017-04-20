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

if (!defined('_OS_VERSION_'))
  exit;

use Core\Controllers\Front\ProductController;
add_domain(__FILE__, 'advanced_search');

function os_advanced_search_install(){
	$advanced_search_attributes =  array() ;
	save_meta_value("advanced_search_attributes",json_encode($advanced_search_attributes));
}


function page_advanced_search_settings(){
	$data = array(); 
	$db = getDB();
	$data['attributes'] = $db->all("attributes");
	$advanced_search_attributes = json_decode( get_meta_value("advanced_search_attributes") , true) ;
	
	if (isset($_POST['submit'])) {
		$attribute = isset($_POST['attribute']) ? $_POST['attribute'] : null;
		$action = isset($_POST['action']) ? $_POST['action'] : null;
		$id = isset($_POST['id']) ? $_POST['id'] : null;

		if ($attribute != null) {
			if (!in_array($attribute, $advanced_search_attributes,true)) {
				array_push($advanced_search_attributes, $attribute);
				save_meta_value("advanced_search_attributes",json_encode($advanced_search_attributes));
			}
		}

		if ($action != null) {
			switch ($action ) {
				case 'delete':
					if ($id != null) {
						if(($key = array_search($id, $advanced_search_attributes)) !== false) {
						    unset($advanced_search_attributes[$key]);
						    save_meta_value("advanced_search_attributes",json_encode($advanced_search_attributes));
						}
					}
					break;
				
				default:
					# code...
					break;
			}
		}
	}
	if (!is_empty($advanced_search_attributes)) {
		$data['attribute_list'] =  $db->query("SELECT * FROM ".$db->prefix."attributes WHERE 
		id IN (".implode(',', $advanced_search_attributes).")");
	}
	
	get_view(__FILE__,'admin/config',$data);
}
add_admin_page(__FILE__, [
    'name' => 'advanced_search_settings',
    'title' => 'Advanced search settings',
    'function' => 'page_advanced_search_settings'
]);

add_js('advanced_search_script', ['src' =>  module_url(__FILE__, 'assets/js/script.js')]);
function advanced_search(){
	add_css('animate-css', ['src' =>  module_url(__FILE__, 'assets/css/animate.css')]);
	$data = array();
	$db = getDB();
	
	//price filter array
 	//$res = $db->select("products",array("MAX(sell_price) as max_price"),true);
 	$res = $db->query("SELECT MAX(sell_price) as max_price FROM ".$db->prefix."products WHERE active = 1",true);
 	if (is_empty($res->max_price)) {
 		return;
 	}
 
 	$max_price = (int) $res->max_price;
 	$interval = $max_price/5;
 	$filter_price = array();
 	for ($i=0; $i <= $max_price; $i= $i+$interval) { 
 		//var_dump($i);
 		if ($i == $max_price) {
 			array_push( $filter_price , array("min" => $i , "max" => null ));
 		}else{
 			array_push( $filter_price , array("min" => $i , "max" => $i + $interval ));
 		}
 		
 	}
	/*echo "<pre>";
 	var_dump($filter_price);
 	echo "</pre>";*/
 	$data['filter_price'] = $filter_price;
 	
 	$custom_condition = "";
 	
 	if (isset($_POST['min_price'])  && !is_empty($_POST['min_price'])){
 		$custom_condition .= " AND sell_price > ".$_POST['min_price'];
 	}

 	if (isset($_POST['max_price'])  && !is_empty($_POST['max_price'])){
 		$custom_condition .= " AND sell_price <= ".$_POST['max_price'];
 	}

 	if (isset($_POST['search_query']) && !is_empty($_POST['search_query'])) {
 		$custom_condition .= " AND id in (
	 		SELECT pt.id_product FROM  `".$db->prefix."product_trans` pt WHERE name like '%".$_POST['search_query']."%'
	 	)";
 	}

 	if (isset($_POST['data_attribute_value']) && !is_empty($_POST['data_attribute_value'])) {
 		$data_attribute_value = json_decode( $_POST['data_attribute_value'] , true) ;
 		if (!is_empty($data_attribute_value)) {
 			$tmp = "";
 			
 			foreach ($data_attribute_value as $key => $attribute) {
 				
 				$tmp .= " (pd.id_attribute = ".$attribute['attr_id']." AND pd.id_value = ".$attribute['val_id'].") OR";
 			}

 			$tmp = rtrim($tmp, 'OR');
 			if (!is_empty($tmp)) {
 				$custom_condition .= " AND id in (
	 				SELECT  `id_product` FROM `os_declinaisons` d INNER JOIN  os_product_declinaisons pd ON d.id = pd.id_declinaison WHERE $tmp
	 			)";
 			}
 		}
 	}

 	//var_dump($_POST['data_attribute_value']);

 	$product = new Core\Models\Admin\Product();

 	if (isset($_POST['sortby_option']) && !is_empty($_POST['sortby_option'])) {
 		$sortby = $_POST['sortby_option'];
 		switch ($sortby) {
 			case 'price-descending':
	 			$product->query_args['orderby'] = 'p.sell_price';
	 			$product->query_args['order'] = 'DESC';
 				break;
 			case 'price-ascending':
 				$product->query_args['orderby'] = 'p.sell_price';
	 			$product->query_args['order'] = 'ASC';
 				break;
 			case 'created-descending':
 				$product->query_args['orderby'] = 'pt.cdate';
	 			$product->query_args['order'] = 'DESC';
 				break;
 			case 'created-ascending':
 				$product->query_args['orderby'] = 'pt.cdate';
	 			$product->query_args['order'] = 'ASC';
 				break;
 			default:
 				# code...
 				break;
 		}
 	}
  
 	//SELECT  `id_product` FROM `os_declinaisons` d INNER JOIN  os_product_declinaisons pd ON d.id = pd.id_declinaison WHERE (pd.id_attribute = 5 AND pd.id_value = 3) OR (pd.id_attribute = 5 AND pd.id_value = 4)

 	//var_dump($custom_condition);

 	$ProductController = new ProductController();
 	$data['products'] = $product->all(); //$ProductController->getProductsByCondition(array(),$custom_condition);

 	//advanced search attributes
 	$filtre_block = array();
 	$advanced_search_attributes = json_decode( get_meta_value("advanced_search_attributes") , true) ;
	if (!is_empty($advanced_search_attributes)) {
		$attribute_list =  $db->query("SELECT * FROM ".$db->prefix."attributes WHERE 
		id IN (".implode(',', $advanced_search_attributes).")");
		//var_dump($attribute_list);
		foreach ($attribute_list as $key => $attribute) {
			$attribute_value =  $db->query("SELECT * FROM ".$db->prefix."attribute_values WHERE id_attribute = $attribute->id ");
			if (!is_empty($attribute_value)) {
				array_push($filtre_block,(object) array(
					"id" => $attribute->id,
					"name" => $attribute->name,
					"color" => $attribute->color,
					"attribute_value" => $attribute_value
				));
			}
		}
	}
	//echo "<pre>";
	//var_dump($filtre_block);
	$data['filtre_block'] = $filtre_block;
	//echo "</pre>";
	get_view(__FILE__,'front/search',$data);
}
add_front_page(__FILE__, 'search', 'advanced_search');