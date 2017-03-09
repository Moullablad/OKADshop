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

class Statistics extends App {

	/**
     * Get Statistics
     * return void
     * @since 1.0.0
     */
	public function indexAction() {
    	$data['statistics'] = [];
    	get_view(__FILE__, 'admin/statistics/index', $data);
	}




//END CLASS	
}

