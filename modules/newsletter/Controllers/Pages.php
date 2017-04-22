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
namespace Modules\Newsletter\Controllers;

use Core\Controllers\Admin\PageController;

class Pages extends PageController {



	/**
     * Settings page
     * @since 1.0.0
     */
	public function pageSettings() {
        $tabs = new Tabs();
        self::$title = trans('Newsletter', 'sauth');
        self::$icon = 'fa fa-envelope';
        self::$buttons = [];    
        return get_tabs(__FILE__, 'settings', ['ajax' => false]);
	}





//END CLASS	
}