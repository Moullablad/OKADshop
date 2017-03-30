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

use Core\Models\Admin\Product;

include 'includes/tabs/product.php';
include 'includes/class/product.php';



/**
 * add menu links
 *
 */
global $os_admin_menu;
$catalog = $os_admin_menu->add( trans('Catalogs', 'ctg'), get_page_url('', __FILE__));
	$catalog->link->prepend('<span class="fa fa-book"></span>');
	$catalog->add( trans('Products', 'ctg'), get_page_url('', __FILE__));
	$catalog->add( l("Catégories", "ctg"), '?module=categories');
	// $catalog->add( l("Manufacturers", "ctg"), '?module=manufacturers');
	$catalog->add( l("Product Attributes", "ctg"), '?module=attributes');
	$catalog->add( l("Product Values", "ctg"), '?module=values');
	$catalog->add( l("Characteristics", "ctg"), '?module=features');
	$catalog->add( l("Keywords (Tags)", "ctg"), '?module=tags');



/**
 * Register javascripts
 *
 */
if( get_url_param('module') == 'catalogs' ){
	add_js('catalogs-js', [
		'src' => admin_url('modules/catalogs/assets/js/catalogs.js'), 
		'admin' => true
	]);
	add_js('catalogs-product', [
		'src' => admin_url('modules/catalogs/assets/js/product.js'), 
		'admin' => true
	]);
}


/**
 * get produts list
 *
 */
function catalog_product_list(){
	$model = new Product();
    $data['products'] = $model->all();
    get_view(__FILE__, 'admin/product/index', $data);
}
add_admin_page(__FILE__, [
    'name' => 'index',
    'title' => 'Products',
    'function' => 'catalog_product_list'
]);


/**
 * get catalogs tabs
 *
 */
function catalog_product_add(){
	get_view(__FILE__, 'admin/navigation', array('name' => 'Add new product', 'icon' => 'gift')); 
	get_tabs(__FILE__, 'product', ['multilang' => true]);
}
add_admin_page(__FILE__, [
    'name' => 'add',
    'title' => 'Add new',
    'function' => 'catalog_product_add'
]);


function catalog_product_edit(){
	get_view(__FILE__, 'admin/navigation', array('name' => 'Edit Product', 'icon' => 'gift')); 
	get_tabs(__FILE__, 'product', ['multilang' => true]);
}
add_admin_page(__FILE__, [
    'name' => 'edit',
    'title' => 'Edit Product',
    'function' => 'catalog_product_edit'
]);





/**
 * Register front pages
 */
//get product by ID
function cataglogs_product(){
	if( !isset($_GET['ID']) ) {
		header("Location: ". get_url());
	}
	$id_product = explode('-', $_GET['ID'])[0];
	$product = new Catalog_Product();
	return $product->get($id_product);
}
add_front_page(__FILE__, 'product', 'cataglogs_product');

//get products by category
function cataglogs_category(){
	if( !isset($_GET['ID']) ) {
		header("Location: ". get_url());
	}
	$id_category = explode('-', $_GET['ID'])[0];
	$product = new Catalog_Product();
	return $product->category($id_category);
}
add_front_page(__FILE__, 'category', 'cataglogs_category');