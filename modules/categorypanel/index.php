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

use Core\Module;
use Core\Controllers\Front\CategoryController;


function categorypanel_display(){
	global $hooks;
	$data = array();
	$CategoryController = new CategoryController();
	$main_category = $CategoryController->getChildrens(1);
	foreach ($main_category as $key => $category) {
		$sub_category = $CategoryController->getChildrens($category->id);
		$category->sub_category = $sub_category;
	}


	$data['main_category'] = $main_category;
	
	$category_menu_img_pub = get_meta_value("category_menu_img_pub");
	$data['category_menu_img_pub'] = site_url()."modules/categorypanel/img/".$category_menu_img_pub;
	
	Module::getView(__FILE__, 'front/category',$data);
}
add_hook(__FILE__, 'left_sidebar', 'categorypanel_display', 'Categories panel', 'Display categories panel.');
add_hook(__FILE__, 'column_left', 'categorypanel_display', 'Home categories', 'Display Home categories.');



function page_categorypanel_config(){

	$data  = array();
	$category_menu_img_pub = get_meta_value("category_menu_img_pub");
	$data['category_menu_img_pub'] = site_url()."modules/categorypanel/img/".$category_menu_img_pub;
	Module::getView(__FILE__, 'admin/config',$data);
}
add_admin_page(__FILE__, [
    'name' => 'categorypanel_config',
    'title' => 'Category Panel',
    'function' => 'page_categorypanel_config'
]);