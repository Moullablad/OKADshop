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
 *
 * ------------------------------------------------------------------
 * HERE WE REGISTER ALL ADMIN TABS
 * ------------------------------------------------------------------
 *
 */


use Core\Session;
use Core\Models\Admin\Product;



/**
 * Register Product Tabs
 *
 */
$product_tabs = array(
	'infos' => array(
		'name' => trans("Informations", "core"),
		'function' => 'product_informations_tab',
		'with_form' => true,
		'multilang' => true,
		'position' => 1
	),
	'prices' => array(
		'name' => trans("Prices", "core"),
		'function' => 'product_prices_tab',
		'with_form' => true,
		'position' => 2
	),
	'seo' => array(
		'name' => trans("Seo", "core"),
		'function' => 'product_seo_tab',
		'with_form' => true,
		'multilang' => true,
		'position' => 3
	),
	'associations' => array(
		'name' => trans("Associations", "core"),
		'function' => 'product_associations_tab',
		'with_form' => true,
		'position' => 4
	),
	'combinations' => array(
		'name' => trans("Combinations", "core"),
		'function' => 'product_combinations_tab',
		'with_form' => false,
		'position' => 5
	),
	'quantities' => array(
		'name' => trans("Quantities", "core"),
		'function' => 'product_quantities_tab',
		'with_form' => true,
		'position' => 5
	),
	'images' => array(
		'name' => trans("Images", "core"),
		'function' => 'product_images_tab',
		'with_form' => false,
		'position' => 6
	),
	'features' => array(
		'name' => trans("Features", "core"),
		'function' => 'product_features_tab',
		'with_form' => true,
		'position' => 7
	),
	'attachments' => array(
		'name' => trans("Attachments", "core"),
		'function' => 'product_attachments_tab',
		'with_form' => false,
		'position' => 8
	)
);
add_tabs(__FILE__, 'product', $product_tabs);





/**
 * Product informations
 *
 */
function product_informations_tab(){
	$data = array();
	$id_product = get_url_param('id');
	$id_product = (is_valid_int($id_product) ) ? $id_product : 0;

	//add or update product informations
	if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !is_ajax() ){
		$model = new Product();
		if( isset($_GET['id']) && is_numeric($_GET['id']) ){
			$update = $model->update($_POST);
			if( !$update ) {
				$data['message']['danger'] = trans("Unable to update Product, please try again.", "core");
			} else {
				$data['message']['success'] = trans("Product was Updated", "core");
			}
		} else {
			$id = $model->create($_POST);
			if( $id ){
				$url = get_page_url('edit&id='.$id, __FILE__);
				if( 'stock' == get_url_param('module') ) {
					$url = get_page_url('products&action=edit&id='.$id, 'stock');
				}
				header("Location: ". $url);
			} else {
				$data['message']['danger'] = trans("Unable to create Product, please try again.", "core");
			}
		}
	}
        
	$selected_lang = Session::get('selected_lang');
	$id_lang = ($selected_lang) ? $selected_lang : get_lang()->id;
	if( $id_product > 0 ){
		$model = new Product();
		$data['product'] = $model->getByID($id_product, $id_lang);
	}
	$data['id_lang'] = $id_lang;
	get_view(__FILE__, 'admin/tabs/product/infos', $data);
}



/**
 * Product Prices
 *
 */
function product_prices_tab(){
	$data = array();
	$id_product = get_url_param('id');
	$id_product = (is_valid_int($id_product) ) ? $id_product : 0;
	if( $id_product > 0 ){

		//add or update product informations
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !is_ajax() ){
			$model = new Product();
			$update = $model->update($_POST);
			if( !$update ) {
				$data['message']['danger'] = trans("Unable to update Prices, please try again.", "core");
			} else {
				$data['message']['success'] = trans("Prices was Updated", "core");
			}
		}
	
		$model = new Product();
		$selected_lang = Session::get('selected_lang');
		$id_lang = ($selected_lang) ? $selected_lang : get_lang()->id;
		$data['product'] = $model->getByID($id_product, $id_lang);
	}
	get_view(__FILE__, 'admin/tabs/product/prices', $data);
}


/**
 * Product Seo
 *
 */
function product_seo_tab(){
	$data = array();
	$id_product = get_url_param('id');
	$id_product = (is_valid_int($id_product) ) ? $id_product : 0;
	if( $id_product > 0 ){

		//add or update product informations
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !is_ajax() ){
			$model = new Product();
			$update = $model->update($_POST);
			if( !$update ) {
				$data['message']['danger'] = trans("Unable to update Seo, please try again.", "core");
			} else {
				$data['message']['success'] = trans("Seo was Updated", "core");
			}
		}
	
		$model = new Product();
		$selected_lang = Session::get('selected_lang');
		$id_lang = ($selected_lang) ? $selected_lang : get_lang()->id;
		$data['product'] = $model->getByID($id_product, $id_lang);
	}
	get_view(__FILE__, 'admin/tabs/product/seo', $data);
}



/**
 * Product associations
 *
 */
function product_associations_tab(){
	$data = array();
	$id_product = get_url_param('id');
	$id_product = (is_valid_int($id_product) ) ? $id_product : 0;
	if( $id_product > 0 ){
		$model = new Product();
		//save product associations
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !is_ajax() ){
			if( $model->update($_POST) ) {
				$save_assoc = $model->saveAssociations($id_product, $_POST['categories']);
				if( $save_assoc ){
					$data['message']['success'] = trans("associations was Updated", "core");
				}
			} else {
				$data['message']['danger'] = trans("Unable to update associations, please try again.", "core");
			}
		}
		$selected_lang = Session::get('selected_lang');
		$id_lang = ($selected_lang) ? $selected_lang : get_lang()->id;
		$data['product'] = $model->db->prepare("SELECT `id`, `id_category_default` FROM `{$model->db->prefix}products` WHERE id=?", [$id_product], true);
		$data['categories'] = $model->getCategories($id_product);
	}
	get_view(__FILE__, 'admin/tabs/product/associations', $data);
}


/**
 * Product combinations
 *
 */
function product_combinations_tab(){
	$data = array();
	$id_product = get_url_param('id');
	$id_product = (is_valid_int($id_product) ) ? $id_product : 0;
	if( $id_product > 0 ){
		$model = new Product();
		$data['id_product'] = $id_product;
		$data['attributes'] = $model->getAttributes();
        $data['images'] = $model->getImages($id_product);
		$data['combinations'] = $model->getCombinations($id_product);
	}
	get_view(__FILE__, 'admin/tabs/product/combinations', $data);
}


/**
 * Product quantities
 *
 */
function product_quantities_tab(){
	$data = array();
	$id_product = get_url_param('id');
	$id_product = (is_valid_int($id_product) ) ? $id_product : 0;
	if( $id_product > 0 ){
		$model = new Product();
		//save product quantities
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !is_ajax() ){
			if( $model->update($_POST) ) {
				$save_qty = $model->updateQuantities($_POST['quantities']);
				if( $save_qty ){
					$data['message']['success'] = trans("Quantities was Updated", "core");
				}
			} else {
				$data['message']['danger'] = trans("Unable to update quantities, please try again.", "core");
			}
		}
		$data['product'] = $model->db->prepare("SELECT `id`, `quantity`, `min_quantity` FROM `{$model->db->prefix}products` WHERE id=?", [$id_product], true);
		$data['combinations'] = $model->getCombinations($id_product);
	}
	get_view(__FILE__, 'admin/tabs/product/quantities', $data);
}

/**
 * Product images
 *
 */
function product_images_tab(){
	$data = array();
	$id_product = get_url_param('id');
	$id_product = (is_valid_int($id_product) ) ? $id_product : 0;
	if( $id_product > 0 ){
		$model = new Product();
		$data['id_product'] = $id_product;
		$data['images'] = $model->getImages($id_product);
	}
	get_view(__FILE__, 'admin/tabs/product/images', $data);
}


/**
 * Product features
 *
 */
function product_features_tab(){
	$data = array();
	$id_product = get_url_param('id');
	$id_product = (is_valid_int($id_product) ) ? $id_product : 0;
	if( $id_product > 0 ){
		$model = new Product();
		//save product features
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !is_ajax() ){
			$fdata['features'] = json_decode($_POST['features'], true);
			$fdata['ids'] = $_POST['features_ids'];
			$update = $model->updateFeatures($fdata);
			if( $update ) {
				$data['message']['success'] = trans("Features was Updated", "core");
			} else {
				$data['message']['danger'] = trans("Unable to update features, please try again.", "core");
			}
		}
		$selected_lang = Session::get('selected_lang');
		$id_lang = ($selected_lang) ? $selected_lang : get_lang()->id;
		$data['id_product'] = $id_product;
		$data['id_lang'] = $id_lang;
		$data['features'] = $model->getFeatures($id_lang);
	}
	get_view(__FILE__, 'admin/tabs/product/features', $data);
}



/**
 * Product attachments
 *
 */
function product_attachments_tab(){
	$data = array();
	$id_product = get_url_param('id');
	$id_product = (is_valid_int($id_product) ) ? $id_product : 0;
	if( $id_product > 0 ){
		$model = new Product();
		//save product attachments
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !is_ajax() ){
			if( $_FILES['files']['size'][0] > 0 ){
				$update = $model->saveAttachment($_FILES['files'], $_POST['attachment']);
				if( $update ) {
					$data['message']['success'] = trans("Attachment was Uploaded.", "core");
				}
			} else {
				$message['error'] = trans("Unable to upload attachment, please try again.", "core");
			}
		}
		$data['id_product'] = $id_product;
		$data['attachments'] = $model->getAttachments($id_product);
	}
	get_view(__FILE__, 'admin/tabs/product/attachments', $data);
}