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

define('STK_BASE', dirname(__FILE__));

include STK_BASE . '/includes/menu-links.php';


/**
 * Register CSS and JS
 */
add_css('orders-style', [
	'src' => admin_url('modules/stock/assets/css/stock.css'), 
	'admin' => true
]);
add_js('orders-scripts', [
	'src' => admin_url('modules/stock/assets/js/stock.js'), 
	'admin' => true
]);



/**
 * set module admin pages
 */
/*function set_stock_admin_pages() {
	// if( get_url_param('module') !== 'stock' ) return;
	$module = get_url_param('module');
	$page = get_url_param('page');
	// $className = '\Module\\'. $location .'\\'. ucfirst($module) .'\\'. ucfirst($page);
	
	$module_index = get_module_index($module);
	$location = (is_core_module($module)) ? 'Admin' : 'Front';
	$className = '\Module\\'. $location .'\\'. ucfirst($module) .'\\Pages';

	if( class_exists($className) ) {
		$controller = new $className(); // Get class Instance
		return $controller->setAdminPage();


	var_dump($controller);exit;
		$action = get_url_param('action');
		$buttons = array();
		if( !$action ) $action = 'index';
		if( $page != 'statistics' ) {
			if( $action == 'index' ) {
				$buttons[] = array(
					'label' => trans('Create '. substr(ucfirst($page), 0, -1), 'stk'),
					'class' => 'btn btn-primary',
					'icon' => 'fa fa-plus',
					'link' => get_page_url($page.'&action=add', $module_index)
				);
			} else {
				$buttons[] = array(
					'label' => trans('View '. ucfirst($page), 'stk'),
					'class' => 'btn btn-success',
					'icon' => 'fa fa-arrow-left',
					'link' => get_page_url($page, $module_index)
				);
			}
		}
		$icons = array(
			'statistics'  => 'fa fa-bar-chart',
			'invoices'    => 'fa fa-address-card',
			'quotes' 	  => 'fa fa-quora',
			'companies'   => 'fa fa-building-o',
			'payments'    => 'fa fa-credit-card',
			'customers'   => 'fa fa-address-book',
			'products'    => 'fa fa-book',
			'settings'    => 'fa fa-cog',
			'templates'   => 'fa fa-envelope'
		);
		$page_name = ucfirst($page);
		if( $action == 'add' ) $page_name = 'Create '. substr(ucfirst($page), 0, -1);
		if( $action == 'edit' ) $page_name = 'Update '. substr(ucfirst($page), 0, -1);
		add_admin_page($module_index, [
			'name' => $page, 
			'title' => trans($page_name, 'stk'), 
			'function' => array($controller, $action),
			'icon' => (isset($icons[$page])) ? $icons[$page] : 'fa fa-archive',
			'with_nav' => true,
			'buttons' => $buttons
		]);
	}
} 
add_action('init', 'set_stock_admin_pages');*/