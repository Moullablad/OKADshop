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
namespace Core\Controllers\Admin;

use Core\Module;
use Core\Controllers\Admin\ViewController;

class PageController extends AdminController
{



	/**
	 * Get page by name
	 *
	 * @param $name string
	 */
	public static function get($name){
		if( !isset($_GET['module']) ) return;
		$data = array();
		$module = $_GET['module'];
		if( isset(Module::$admin_pages[$module][$name]) ){
			ob_start(); ob_clean(); // Initiate the output buffer
			$page = (object) Module::$admin_pages[$module][$name];
			$page_function = $page->function;
			if( is_array($page_function) ) {
				$class = $page_function[0];
				$action = $page_function[1].'Action';
				if( method_exists($class, $action) ) {
					$page_function[0]->$action();
				}
			} else if( function_exists($page_function) ){
				$page_function();
			}
			$content = ob_get_clean();
			$page->content = $content;
			unset($page->function);
			ViewController::getTemplate('page', ['page' => $page]);
		}
	}



//END CLASS
}