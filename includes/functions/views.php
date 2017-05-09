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
 *
 * ------------------------------------------------------------------
 * THIS FILE GROUP ALL VIEWS FUNCTIONS
 * ------------------------------------------------------------------
 *
 *
 */

use Core\View;


/**
 * Get View
 *
 * @param string $view
 * @param array $variables
 */
function get_view($file, $view, $variables=[]){
	View::getView($file, $view, $variables);
}