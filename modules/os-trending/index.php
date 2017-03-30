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
use Core\Controllers\Front\CategoryController;


add_domain(__FILE__, 'trending');

function display_trending(){
	$data = array();
	$CategoryController = new CategoryController();
	$ProductController = new ProductController();

	$trending_data = json_decode( get_meta_value("trending_data") , 'true' );	
	if (is_array($trending_data)) {
 		$cat_id_list = array_column($trending_data, 'id');
 		if (!is_empty($cat_id_list)) {
			$ids =implode(',', $cat_id_list);
			$condition = "WHERE id in ($ids)";
			$category_trending = $CategoryController->allCategory($condition);
			$exist = false;
			if (!is_empty($category_trending)) {
				foreach ($category_trending as $key => $cat) {

					$args = array(
						"id_category_default" => $cat->id
					);
					$products = $ProductController->getProductsByCondition( $args);
					if (!is_empty($products)) {
						$exist = true;
					}
					$cat->products = $products;
				}
			}
			
			$data['categories'] = $category_trending;
			if ($exist) {
				get_view(__FILE__, 'front/trending', $data);
			}		
		}
	}
	
}
add_hook(__FILE__, 'home_center', 'display_trending', 'trending', 'display trending.');


function page_trending_settings(){
	$data = array();
	$trending_data = array();
	$CategoryController = new CategoryController();

	$tmp = json_decode( get_meta_value("trending_data") , 'true' );	
	if (is_array($tmp)) {
		$trending_data = $tmp;
	}

	if (isset($_POST['action']) && isset($_POST['cat_id'])) {
		$key = 'cat_'.$_POST['cat_id'];
		if (isset($trending_data[$key])) {
			unset($trending_data[$key]);
			save_meta_value("trending_data", json_encode($trending_data));
		}
		
	}

	if (isset($_POST['category']) && is_numeric($_POST['category'])) {
		$trending_data["cat_".$_POST['category']] = array(
			"id" => $_POST['category'],
			"position" => "1"
		);
		save_meta_value("trending_data", json_encode($trending_data));
	}

 
	$cat_id_list = array_column($trending_data, 'id');
	if (!is_empty($cat_id_list)) {
		$ids =implode(',', $cat_id_list);
		$condition = "WHERE id in ($ids)";
		$category_trending = $CategoryController->allCategory($condition);
		$data['category_trending'] = $category_trending;
	}
	
 
	

	
	$category_list = $CategoryController->allCategory();
	if (!is_empty($category_list)) {
		$data['category_list'] = $category_list;
		$data['trending_data'] = $trending_data;
		get_view(__FILE__, 'admin/config',$data);
	}
}
add_admin_page(__FILE__, [
    'name' => 'trending_settings',
    'title' => 'Settings',
    'function' => 'page_trending_settings'
]);