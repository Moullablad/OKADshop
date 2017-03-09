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


/**
 * Register translation domain
 */
add_domain(__FILE__, 'account');



require 'tabs/account.php';
require 'class/account.php';

/**
 * Register Sections
 */
add_section('before_login', 'Before Login Form');
add_section('after_login', 'After Login Form');



/**
 * Register front pages
 */
function account_front_page(){
	$page = isset($_GET['ID']) ? $_GET['ID'] : '';
	$excludes = array('login', 'register', 'password');
	if ( !logged() && !in_array($page, $excludes) ) {
		header("Location: ". get_url('account/login'));
	}
	$account = new Account();
	$class_function = str_replace('-', '_', $page);
	if( $page != '' && method_exists($account, $class_function)) {
		$account->$class_function();
	} else {
		$data = array();
		//seo metatags
		if( function_exists('add_meta') ){
			set_meta_title( trans('My Account', 'account') );
			set_meta_description( trans('My Account gives you quick access to settings and tools for managing your dashboard.', 'account') );
		}
		get_view(__FILE__, 'front/dashboard', $data);
	}
}
add_front_page(__FILE__, 'account', 'account_front_page');


/**
 * Display account links.
 **/

function display_account_links(){
	get_view(__FILE__, 'front/blocks/blocklinks');
}
add_hook(__FILE__, 'top_right', 'display_account_links', 'Account links', 'Display account links.');




/**
 * Register javascripts and css
 */
if( is_page('account') ){
	add_css('account-css', [
		'src' => admin_url('modules/account/assets/css/account.css'), 
		'admin' => false
	]);

	/*add_js('account-js', [
		'src' => admin_url('modules/account/assets/js/account.js'), 
		'admin' => false
	]);*/
}