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
namespace Module\Admin\Stock\Tabs;

use Module\Admin\Stock\Customers;
use Core\Controllers\Front\UserController;

class CustomerTabs extends Customers {


	/**
     * Singleton int
     * @var Singleton $instance
     */
    private static $instance;


    /**
     * Get tab instance
     * @return object $instance
     */
    public static function getInstance() {
        if( is_null(self::$instance) ){
            self::$instance = new CustomerTabs();
        }
        return self::$instance;
    }


	public function __construct() {
		add_tabs(__FILE__, 'customer_edit', array(
			'infos' => array(
				'name' => trans("Informations", "stk"),
				'function' => array($this, 'infoTab'),
				'with_form' => true,
				'position' => 1
			),
			'quotes' => array(
				'name' => trans("Quotes", "stk"),
				'function' => array($this, 'quotesTab'),
				'with_form' => true,
				'position' => 2
			),
			'invoices' => array(
				'name' => trans("Invoices", "stk"),
				'function' => array($this, 'invoicesTab'),
				'with_form' => true,
				'position' => 3
			)
		));
	}


	/**
     * Informations Tab
     * @since 1.0.0
     */
	function infoTab(){
		//Get user id
		$id_user = (isset($_GET['id']) && is_valid_int($_GET['id']) ) ? $_GET['id'] : 0;
		if( $id_user < 1 ) header("Location: ". get_page_url('customers', __FILE__));

		//save user informations
		if ( isset($_POST['infos_form']) && !is_ajax() ){
			$post = $_POST;
			var_dump($post);
		}

		//Send data to view
		$data['infos'] = UserController::getUser($id_user);
		get_view(__FILE__, 'admin/customers/tabs/infos', $data);
	}


	/**
     * Quotes Tab
     * @since 1.0.0
     */
	function quotesTab(){
		$data['quotations'] = [];
		get_view(__FILE__, 'admin/customers/tabs/quotations', $data);
	}


	/**
     * Invoices Tab
     * @since 1.0.0
     */
	function invoicesTab(){
		$data['invoices'] = [];
		get_view(__FILE__, 'admin/customers/tabs/invoices', $data);
	}



//END CLASS	
}

