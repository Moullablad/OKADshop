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

class Invoices extends App {


	/**
     * Constructor
     * @since 1.0.0
     */
	public function __construct(){
		parent::__construct();
		Tabs\InvoiceTabs::getInstance();
	}


	/**
     * Get Invoices
     * return void
     * @since 1.0.0
     */
	public function indexAction() {
    	$data['invoices'] = [];
    	get_view(__FILE__, 'admin/invoices/index', $data);
	}


	/**
     * Add Invoice
     * return void
     * @since 1.0.0
     */
	public function addAction() {
		//add or update product informations
		if ( isset($_POST['invoice_form']) ){
			$data = $_POST;
			if( intval($data['id_customer']) < 1 ) {
				$data['message']['danger'] = trans("Please choose a customer.", "stk");
			} else {	
				unset($data['invoice_form']);
				$id_invoice = $this->create($data);
				if( $id_invoice ) {
					$url = get_page_url('invoices', __FILE__) . '&action=edit&id='. $id_invoice;
					header("Location: $url");
				} else {
					$data['message']['danger'] = trans("Unable to create new invoice.", "stk");
				}
			}
		}

		$data['taxes'] = [];
		get_view(__FILE__, 'admin/invoices/add', $data);
	}


	/**
     * Edit Invoice
     * return void
     * @since 1.0.0
     */
	public function editAction() {
		$id_invoice = (isset($_GET['id']) && is_valid_int($_GET['id']) ) ? $_GET['id'] : 0;
		if( $id_invoice < 1 ){
			header("Location: ". get_page_url('invoices', __FILE__));
		}
		$data['invoice'] = []; //$this->get($id_invoice);
		get_view(__FILE__, 'admin/invoices/edit', $data);
	}


	/**
     * Get Invoice By ID
     * return array $invoice
     * @since 1.0.0
     */
	public function get($id_invoice) {
		return getDB()->find('stock_invoices', $id_invoice);
	}


	/**
     * Get Quotation items
     * @param $id_quotation int
     * @return $items array
     * @since 1.0.0
     */
	public function getItems($id_quotation) {
		$products = [
			[
				'id' => 1,
				'name' => 'Iphone 8',
				'reference' => 'IP1254',
				'price' => 10,
				'tax' => 10,
				'discount' => 20,
				'quantity' => 4 
			],
			[
				'id' => 2,
				'name' => 'Samsung galaxy Edge',
				'reference' => 'SAM5548',
				'price' => 10,
				'tax' => 0,
				'discount' => 0,
				'quantity' => 2 
			],
			[
				'id' => 3,
				'name' => 'LG G5',
				'reference' => 'LG5502',
				'price' => 15,
				'tax' => 0,
				'discount' => 0,
				'quantity' => 1 
			],
		];
		return array_to_object($products);
	}
	

	/**
     * Create Invoice
     * return int $id_invoice
     * @since 1.0.0
     */
	public function create($data) {
		return getDB()->create('stock_invoices', $data);
	}




//END CLASS	
}

