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

use Module\Admin\Stock\Invoices;

class InvoiceTabs extends Invoices {


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
            self::$instance = new InvoiceTabs();
        }
        return self::$instance;
    }


	public function __construct() {
		//Register Invoice Tabs
		add_tabs(__FILE__, 'invoice_edit', array(
			'details' => array(
				'name' => trans("Details", "stk"),
				'function' => array($this, 'detailsTab'),
				'with_form' => true,
				'position' => 1
			),
			'preview' => array(
				'name' => trans("Preview", "stk"),
				'function' => array($this, 'previewTab'),
				'position' => 2
			)
		));
	}


	/**
     * Details Tab
     * @since 1.0.0
     */
	public function detailsTab() {
		$data = array();
		$id_invoice = get_url_param('id');
		if( intval($id_invoice) < 1 ) {
			header("Location: ". get_page_url('invoices', __FILE__));
		}

		//save user informations
		if ( isset($_POST['details_form']) && !is_ajax() ){
			$post = $_POST;
			var_dump($post);
		}

		//Send data to view
		$data['items'] = $this->getItems($id_invoice);
		$data['terms'] = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in  culpa qui officia deserunt mollit anim id est laborum.";
		get_view(__FILE__, 'admin/invoices/tabs/details', $data);
	}


	/**
     * Preview Tab
     * @since 1.0.0
     */
	public function previewTab() {
		$data = array();
		get_view(__FILE__, 'admin/invoices/tabs/preview', $data);
	}



//END CLASS	
}

