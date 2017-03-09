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

class App {


	public $singular_name;
    public $plural_name;


	/**
     * Constructor
     * @since 1.0.0
     */
	public function __construct() {
		$page = get_url_param('page');
		$this->singular_name = substr($page, 0, -1);
		$this->plural_name = $page;
	}



	/**
     * Index page
     * @since 1.0.0
     */
	public function indexAction() {
		return $this->notFound();
	}

	/**
     * Add new Element
     * @since 1.0.0
     */
	public function addAction() {
		return $this->notFound();
	}

	/**
     * Edit Element
     * @since 1.0.0
     */
	public function editAction() {
		return $this->notFound();
	}

	/**
     * Delete Element
     * @since 1.0.0
     */
	public function deleteAction() {
		return $this->notFound();
	}
	

	/**
     * Not found
     * @since 1.0.0
     */
	public function notFound() {
		$module = get_url_param('module');
		$page = get_url_param('page');
		$action = get_url_param('action');
		if( !$action ) $action = 'index';
		$class_path = module_base(__FILE__, 'includes/class');
		$class_path = str_replace(site_base(), '', $class_path) .'/'. ucfirst($page) .'.php';
		$message  = trans('No view found, to solve this follow the following steps:', 'stk') . '<br>';
		$message .= trans('Create a Class in this path:', 'stk') . ' ['. $class_path .'] ';
		$message .= trans('With this content:', 'stk') .'<br><br>';
		$message .= 'class '. ucfirst($page) .' {<br>';
		$message .= '&nbsp;&nbsp;&nbsp;&nbsp;public function '. $action .'Action()<br>';
		$message .= '&nbsp;&nbsp;&nbsp;&nbsp;{<br>';
		$message .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$message .= 'get_view(__FILE__, \'path/to/view\', $data=[]);<br>';
		$message .= '&nbsp;&nbsp;&nbsp;&nbsp;}<br>';
		$message .= '}';
		get_view(__FILE__, 'alerts', ['info' => $message]);
	}


//END CLASS	
}

