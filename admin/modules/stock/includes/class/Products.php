<?php
/**
 * 2016 - 2017 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 - 2017 OKADshop
 */
namespace Module\Admin\Stock;

use Core\Models\Admin\Product;

class Products extends App {


	/**
     * Get Customers
     * @return void
     * @since 1.0.0
     */
	public function indexAction() {
		$model = new Product();
	    $data['products'] = $model->all(); //admin_base('modules/catalogs/index.php')
	    get_view(__FILE__, 'admin/products/index', $data);
	}


	/**
     * Add Product
     * @return void
     * @since 1.0.0
     */
	public function addAction() {
		get_view(__FILE__, 'admin/products/add');
	}


	/**
     * Edit Product
     * @return void
     * @since 1.0.0
     */
	public function editAction() {
		$id_product = (isset($_GET['id']) && is_valid_int($_GET['id']) ) ? $_GET['id'] : 0;
		if( $id_product < 1 ){
			header("Location: ". get_page_url('products', __FILE__));
		}
		$data['product'] = array(); //$this->get($id_product);
		get_view(__FILE__, 'admin/products/edit', $data);
	}


	/**
     * Delete Product
     * @return void
     * @since 1.0.0
     */
	public function deleteAction() {
		$id_product = get_url_param('id');
		$db = getDB();
		$result = $db->prepare("select COUNT('*') as count
			from (
		    select id_product from {$db->prefix}order_detail
		    union all
		    select id_product from {$db->prefix}invoice_detail
			) a
			where id_product=?", [$id_product], true
		);
		if( $result->count > 0 ){
			set_flash_message('danger', trans("Can't delete product because it was already ordered.", "stk"));
			header("Location: ". get_page_url('products', __FILE__));exit;
		} else {
			$db->prepare("DELETE FROM `{$db->prefix}product_associated` WHERE `id_product`=?", [$id_product]);
			$db->prepare("DELETE FROM `{$db->prefix}product_attachments` WHERE `id_product`=?", [$id_product]);
			$db->prepare("DELETE FROM `{$db->prefix}product_category` WHERE `id_product`=?", [$id_product]);
			$db->prepare("DELETE FROM `{$db->prefix}product_images` WHERE `id_product`=?", [$id_product]);
			$db->prepare("DELETE FROM `{$db->prefix}product_tags` WHERE `id_product`=?", [$id_product]);
			$db->prepare("DELETE FROM `{$db->prefix}declinaisons` WHERE `id_product`=?", [$id_product]);
			$db->prepare("DELETE FROM `{$db->prefix}product_trans` WHERE `id_product`=?", [$id_product]);
			$db->prepare("DELETE FROM `{$db->prefix}products` WHERE `id`=?", [$id_product]);
			set_flash_message('success', trans("Product was deleted.", "stk"));
			header("Location: ". get_page_url('products', __FILE__));exit;
		}
	}




//END CLASS	
}