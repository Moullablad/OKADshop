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

if (!defined('_OS_VERSION_'))
  exit;

// include 'includes/functions.php';


/**
 * Register CSS and JS
 *
 */
add_css('tabs-style', [
	'src' => admin_url('modules/tabs/assets/css/tabs.css'), 
	'admin' => true,
]);
add_js('tabs-scripts', [
	'src' => admin_url('modules/tabs/assets/js/tabs.js'), 
	'admin' => true,
]);