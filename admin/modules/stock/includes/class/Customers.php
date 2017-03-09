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

class Customers extends App {
	

	/**
     * Constructor
     * @since 1.0.0
     */
	public function __construct(){
		parent::__construct();
		Tabs\CustomerTabs::getInstance();
	}
	

	/**
     * Get Customers
     * return void
     * @since 1.0.0
     */
	public function indexAction() {
		$data['customers'] = getDB()->findByColumn('users', 'user_type', 'user');
    	get_view(__FILE__, 'admin/customers/index', $data);
	}


	/**
     * Add Customer
     * return void
     * @since 1.0.0
     */
	public function addAction() {
		get_view(__FILE__, 'admin/customers/add');
	}


	/**
     * Edit Customer
     * return void
     * @since 1.0.0
     */
	public function editAction() {
		$id_customer = (isset($_GET['id']) && is_valid_int($_GET['id']) ) ? $_GET['id'] : 0;
		if( $id_customer < 1 ){
			header("Location: ". get_page_url('customers', __FILE__));
		}
		$data['customer'] = get_user_data($id_customer);
		get_view(__FILE__, 'admin/customers/edit', $data);
	}





//END CLASS	
}

