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
 * THIS FILE GROUP ALL MODULE FUNCTIONS
 * ------------------------------------------------------------------
 *
 *
 */

use Core\Module;
use Core\Controllers\Admin\ModuleController;



/**
 * Modules categories
 *
 * @return $categories
 */
function add_modules_categories($categories){
	return ModuleController::addCategories($categories);
}

/**
 * Modules categories
 *
 * @return $categories
 */
function get_modules_categories(){
	return ModuleController::getCategories();
}

//default modules categories
$categories = array(
	"administration" => trans("Administration", "modules"),
	"advertising_marketing" => trans("Advertising and Marketing", "modules"),
	"analytics_stats" => trans("Analytics and Stats", "modules"),
	"checkout" => trans("Checkout", "modules"),
	"smart_shopping" => trans("Comparison site &amp; Feed management", "modules"),
	"dashboard" => trans("Dashboard", "modules"),
	"emailing" => trans("Emailing &amp; SMS", "modules"),
	"export" => trans("Export", "modules"),
	"front_office_features" => trans("Front office Feature", "modules"),
	"market_place" => trans("Marketplace", "modules"),
	"merchandizing" => trans("Merchandising", "modules"),
	"migration_tools" => trans("Migration Tools", "modules"),
	"payments_gateways" => trans("Payments and Gateways", "modules"),
	"pricing_promotion" => trans("Pricing and Promotion", "modules"),
	"quick_bulk_update" => trans("Quick / Bulk update", "modules"),
	"seo" => trans("SEO", "modules"),
	"shipping_logistics" => trans("Shipping and Logistics", "modules"),
	"slideshows" => trans("Slideshows", "modules"),
	"billing_invoicing" => trans("Taxes &amp; Invoicing", "modules"),
	"translation" => trans("Translation", "modules"),
	"others" => trans("Other Modules", "modules")
);
add_modules_categories($categories);



/**
 *
 * ADD ACTION HOOK
 *
 * @param string $name
 * @param string $function_to_add
 * @param int $priority
 * @return boolean
 */
function add_action( $name, $function_to_add, $priority = 1 ){
	if( $name == '' || $function_to_add == '' ) 
		return false;
	
	return Module::addAction( $name, $function_to_add, $priority );
}


/**
 *
 * EXECUTE ACTION HOOK
 *
 * @param int $name
 * @return boolean
 */
function do_action($name){
	if( $name !== '' ) {
		Module::doAction( $name );
	}
}


/**
 *
 * GET ACTION HOOK ARRAY
 *
 * @param int $name
 * @return boolean
 */
function get_action($name){
	if( $name == '' ) 
		return false;

	return Module::getAction($name);
}


/**
 * OKADshop action head
 *
 * @return void
 */
function os_head(){
	global $common;
	do_action('os_head');
	$common->os_render_styles();
}

/**
 * OKADshop action os_footer
 *
 * @return void
 */
function os_footer(){
	global $common;
	do_action('os_footer');
	$common->os_render_scripts();
}


/**
 * Get module icon
 *
 * @param string $name
 * @return icon
 */
function get_module_icon($name){
	$icon = module_base($name, 'icon.png');
	if( file_exists($icon) ){
		return str_replace(site_base(), site_url(), $icon);
	} else {
		return site_url('assets/img/icons/module_icon.png');
	}
}


/**
 * Get module index
 *
 * @param string $name
 * @param string $category
 * @return index
 */
function get_module_index($name, $category){
	if( $category != 'administration' ) {
		$index = module_base($name, 'index.php');
	} else {
		$index = admin_base('modules/'. $name . '/index.php');
	}
	return $index;
}



/**
 * Get Module directory name
 *
 * @param $file
 * @return $slug
 */
function get_module_dirname($file){
	$file = str_replace('\\', '/', $file);
	if (preg_match("!/modules/([a-z-]*)/!", $file, $match) === 1) {
		return $match[1];
	}
	return false;
}



/**
 * Get Module Base
 */
function module_base($file, $path=''){
    $file = str_replace('\\', '/', $file);
	if (0 === strpos($file, site_base())) {
		if (preg_match("!(.*?)modules/([a-z-]*)/!", $file, $match) === 1) {
			return $match[0] . $path;
		}
	} else if (0 === strpos($file, 'core-')) { // Core modules
		$file = str_replace('core-', '', $file);
		return admin_base('modules/'. $file .'/'. $path);
	} else {
		return site_base('modules/'. $file .'/'. $path);
	}
}


/**
 * Get Module URL
 */
function module_url($file, $path=''){
	$base = module_base($file, $path);
	return str_replace(site_base(), site_url(), $base);
	// $module_name = get_module_dirname($file);
	// return site_url() . 'modules/' . $module_name .'/'. $path;
}


/**
 * Get installed modules
 *
 * @return $modules
 */
function get_modules(){
	return ModuleController::getConfig();
}


/**
 * Get module field by name
 *
 * @param $field string
 * @param $module_name string
 * @return $result
 */
function get_module_by_name($field, $module_name){
	$db = getDB();
	$result = $db->prepare("SELECT $field as field FROM {$db->prefix}modules WHERE name=?", [$module_name], true);
	if( isset($result->field) ){
		return $result->field;	
	}
	return false;
}


/**
 * Get active modules
 *
 * @return $modules
 */
function get_active_modules(){
	return ModuleController::getActive();
}


/**
 * Check if module active
 *
 * @param $name string
 * @return bool
 */
function is_active($name){
	$modules = ModuleController::getActive();
	if( in_array($name, $modules) ){
		return true;
	}
	return false;
}


/**
 * Modules filter
 * $pairs = array('author' => 'abc', 'version' => 'all'); 
 * $array = array();
 *
 * @param array $array
 * @param array $pairs
 * @throws Exception
 * @return $hooks (array)
 */
function modules_filter(array $array, array $pairs){
	$filter = array();
	foreach ($array as $aKey => $aVal) {
		$coincidences = 0;
		foreach ($pairs as $pKey => $pVal) {
			if( $pKey == "name"){
				if (strpos( strtolower($aVal['name']), strtolower($pVal)) !== false) {
					$coincidences++;
				}
			}else{
				if (array_key_exists($pKey, $aVal) && strtolower($aVal[$pKey]) == strtolower($pVal)) {
					$coincidences++;
				}
			}
		}
		if ($coincidences == count($pairs)) {
			$filter[$aKey] = $aVal;
		}
	}
	return $filter;
}


/**
 * Register module page
 *
 * @param string $name
 * @param string $function
 * @return true
 */
function add_front_page($file, $name, $function_to_add) {
	return Module::setPage($file, $name, $function_to_add);
}


/**
 * Get current module page
 *
 * @return array $view_path
 */
function get_front_pages(){
	return Module::getFrontPages();
}


/**
 * Get module name by page
 *
 * @param $name string
 * @return array $module_name
 */
function get_front_page_module($name, $path=''){
	$pages = get_front_pages();
	if( isset($pages[$name]) ){
		$moduleName = $pages[$name]['module_name'];
		$modules = get_modules();
		if( isset($modules[$name]['category']) ){
			$category = $modules[$name]['category'];
			$index = get_module_index($name, $category);
			$module_dir = dirname($index);
			$module_dir = str_replace(site_base(), '', $module_dir);
			return $module_dir .'/'. $path;
		}
	}
	return false;
}



/**
 * Is the query for an existing front page
 *
 * @param $name string
 * @return bool
 */
function is_page($name){
	if( !isset($_GET['Module']) )
		return false;
	
	$pages = get_front_pages();
	if( !empty($pages) && $_GET['Module'] == $name ){
		return array_key_exists ( $name, $pages );
	}
	return false;
}


/**
 * Get page details
 *
 * @param $name string
 * @return bool
 */
/*function get_page($name){
	$pages = get_front_pages();
}*/