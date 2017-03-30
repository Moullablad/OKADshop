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


// Get physical URL
$dirname = str_replace("\\", "/", dirname(__DIR__));
$root = $_SERVER['DOCUMENT_ROOT'];
$physical_uri = '/';
if ( preg_match("!\\$root(.*)!", $dirname, $matches) === 1 ) {
	$physical_uri = $matches[1] .'/';
}
$GLOBALS['os'] = new \stdClass;
$GLOBALS['os']->physical_uri = $physical_uri;


//Get database configuration
if( file_exists(dirname(__FILE__).'/database.inc.php') ){
	require_once 'database.inc.php';
} else {
	//Redirect to install if no database file
	$uri = 'http://'. $_SERVER['HTTP_HOST'] . $physical_uri . 'install/index.php';
	header("location: $uri");
}

//includes settings
require_once 'defines.inc.php';
require_once 'config.inc.php';
require_once _BASE_URI_. 'vendor/autoload.php'; //composer autoloading

//namespaces
use Core\Theme;
use Core\i18n\Translate;
use Core\Database\Database;
use Core\Menu\Menu;
use Core\Controllers\Front\CartController;
use Core\Controllers\Admin\ThemeController;
use Core\Controllers\Admin\ModuleController;

//run session
if(!isset($_SESSION)) 
{ 
	session_set_cookie_params(0, _PHYSICAL_URI_); 
    session_start(); 
} 


require_once _BASE_URI_.'classes/commun/commun.class.php';
require_once _BASE_URI_.'classes/products/products.class.php';
require_once _BASE_URI_.'classes/features/features.class.php';

require_once _BASE_URI_.'classes/users/users.class.php';
require_once _BASE_URI_.'includes/functions/functions.php';
require_once _BASE_URI_.'classes/mpdf/mpdf.php';
require_once _BASE_URI_.'classes/modules/modules.class.php';
require_once _BASE_URI_.'classes/modules/hooks.class.php';


//Global variables
$GLOBALS['os']->currency = CartController::getCurrency();
$GLOBALS['os']->shop 	 = get_shop();
$GLOBALS['os']->language = get_lang();
$GLOBALS['os']->user 	 = get_user();
$GLOBALS['os']->theme 	 = Theme::getThemeURI();
$GLOBALS['os']->admin_dirname = get_admin_dirname();


//Admin Menu Instance
$os_admin_menu = new Menu;
$dashboard = $os_admin_menu->add( trans('Dashboard', 'core'), admin_url());
$dashboard->link->prepend('<span class="fa fa-dashboard"></span>');
require_once _BASE_URI_.'classes/modules/init.php';


// Database insatnce
$DB = Database::getInstance(); 
$common = new OS_Common();


//Show errors
if( _LIVE_SITE_ === false ){
	error_reporting(E_ALL);
	ini_set("display_errors", true);
}

/**
 * Initialize CMS
 * 
 * Load cms functionalities
 */
ModuleController::init();
ThemeController::init();
$GLOBALS['os']->trans = Translate::init(); //Initialize languages
do_action('init');//init action