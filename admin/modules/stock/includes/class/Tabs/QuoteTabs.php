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

use Module\Admin\Stock\Quotes;

class QuoteTabs extends Quotes {


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
            self::$instance = new QuoteTabs();
        }
        return self::$instance;
    }


	public function __construct() {
		//Register Quote Tabs
		add_tabs(__FILE__, 'quote_edit', array(
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
	function detailsTab(){
		$id_quotation = (isset($_GET['id']) && is_valid_int($_GET['id']) ) ? $_GET['id'] : 0;

		if( $id_quotation < 1 ) {
			header("Location: ". get_page_url('quotes', __FILE__));
		}

		//save user informations
		if ( isset($_POST['products_form']) && !is_ajax() ){
			$post = $_POST;
			var_dump($post);
		}

		//Send data to view
		$controller = new Quotes();
		$data['items'] = $controller->getItems($id_quotation);
		get_view(__FILE__, 'admin/quotes/tabs/details', $data);
	}


	/**
     * Preview Tab
     * @since 1.0.0
     */
	function previewTab(){
		$data = array();
		get_view(__FILE__, 'admin/quotes/tabs/preview', $data);
	}



//END CLASS	
}

