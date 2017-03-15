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
namespace Modules\Stock\Controllers;

use Core\Controllers\Admin\PageController;

class Pages extends PageController {



	/**
     * Get Statistics
     * return void
     * @since 1.0.0
     */
    public function pageStatistics() {
        self::$icon = 'fa fa-bar-chart';
        self::$buttons = [];
        $data['statistics'] = [];
        get_view(__FILE__, 'admin/statistics/index', $data);
    }


    /**
     * Get Invoices
     * return void
     * @since 1.0.0
     */
    public function pageInvoices() {
        self::$icon = 'fa fa-address-card';
        $data['invoices'] = [];
        get_view(__FILE__, 'admin/invoices/index', $data);
    }


    // 'statistics'  => 'fa fa-bar-chart',
    //      'invoices'    => 'fa fa-address-card',
    //      'quotes'      => 'fa fa-quora',
    //      'companies'   => 'fa fa-building-o',
    //      'payments'    => 'fa fa-credit-card',
    //      'customers'   => 'fa fa-address-book',
    //      'products'    => 'fa fa-book',
    //      'settings'    => 'fa fa-cog',
    //      'templates'   => 'fa fa-envelope'





//END CLASS	
}