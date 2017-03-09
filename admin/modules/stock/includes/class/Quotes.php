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

class Quotes extends App {


	/**
     * Constructor
     * @since 1.0.0
     */
	public function __construct(){
		parent::__construct();
		Tabs\QuoteTabs::getInstance();
	}


	/**
     * Get Quotes
     * return void
     * @since 1.0.0
     */
	public function indexAction() {
    	$data['quotes'] = [];
    	get_view(__FILE__, 'admin/quotes/index', $data);
	}


	/**
     * Add Quote
     * return void
     * @since 1.0.0
     */
	public function addAction() {
		get_view(__FILE__, 'admin/quotes/add');
	}


	/**
     * Edit Quote
     * return void
     * @since 1.0.0
     */
	public function editAction() {
		$id_quotation = (isset($_GET['id']) && is_valid_int($_GET['id']) ) ? $_GET['id'] : 0;
		if( $id_quotation < 1 ){
			header("Location: ". get_page_url('quotes', __FILE__));
		}
		$data['quote'] = $this->get($id_quotation);
		get_view(__FILE__, 'admin/quotes/edit', $data);
	}


	/**
     * Get Quotation
     * @param $id_quotation int
     * @return $quotation array
     * @since 1.0.0
     */
	public function get($id_quotation) {
		return [];
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





//END CLASS	
}

