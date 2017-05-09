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


	public static $name;
	public static $title;
	public static $icon = 'fa fa-file-o';
	public static $buttons = [];
	public static $with_nav = false;


	/**
	 * Set Admin Page
	 *
	 * @since 1.0.0
	 */
	public function setAdminPage() {
		$module = get_url_param('module');
		self::$name = get_url_param('page');
		self::$title = ucfirst(self::$name);
		self::$with_nav = true;
		$module_index = get_module_index($module);

		if (0 === strpos(self::$name, 'edit')) {
			$page_name = str_replace('edit_', '', self::$name);
			self::$title = trans('Edit '. $page_name, 'core');
			self::$buttons[] = array(
				'label' => trans('Create new '. ucfirst($page_name), 'core'),
				'class' => 'btn btn-primary',
				'icon' => 'fa fa-plus',
				'link' => get_page_url('create_'. $page_name, $module_index)
			);
		} else if (0 === strpos(self::$name, 'create')) {
			$page_name = str_replace('create_', '', rtrim(self::$name, 's'));
			self::$title = trans('Create '. $page_name, 'core');
			self::$buttons[] = array(
				'label' => trans(ucfirst($page_name), 'core'),
				'class' => 'btn btn-primary',
				'icon' => 'fa fa-arrow-left',
				'link' => get_page_url($page_name.'s', $module_index)
			);
		} else {
			$page_name = rtrim(self::$name, 's');
			self::$buttons[] = array(
				'label' => trans('Create new '. ucfirst($page_name), 'core'),
				'class' => 'btn btn-primary',
				'icon' => 'fa fa-arrow-left',
				'link' => get_page_url('create_'.$page_name, $module_index)
			);
		}

		add_admin_page($module_index, [
			'name' => self::$name, 
			'title' => trans(self::$title, 'core'), 
			'function' => array($this, 'page' . self::$title),
		]);
	}


	/**
	 * Get page by name
	 *
	 * @param $name string
	 */
	public static function render($name){
		if( !isset($_GET['module']) ) return;
		$module = $_GET['module'];
		if( isset(Module::$admin_pages[$module][$name]) ){
			ob_start(); ob_clean(); // Initiate the output buffer
			$page = (object) Module::$admin_pages[$module][$name];
			$method = $page->function;
			if( is_array($method) ) {
				$class = new $method[0]();
				call_user_func_array(array($class, $method[1]), array());
			} else if( function_exists($method) ){
				call_user_func_array($method, array());
			}
			$content = ob_get_clean();

			$data = array(
				'content' => $content,
				'title' => self::$title, 
				'icon' => self::$icon, 
				'buttons' => self::$buttons, 
				'with_nav' => self::$with_nav, 
			);

			ViewController::getTemplate('page', $data);
		}
	}



//END CLASS
}