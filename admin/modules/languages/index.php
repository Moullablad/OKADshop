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

// No direct access
if (!defined('_OS_VERSION_'))
  exit;

// Include module functions
include module_base(__FILE__, 'inc/functions.php');

// Instanciate module
CoreModules\Languages\Controllers\Languages::getInstance();


// Register translation domain
add_domain(__FILE__, 'lang');


// Install function
function languages_install() {
	// Create table
	global $common;
  	$file = module_base(__FILE__, 'inc/db_dump.sql');
  	$common->run_sql_file( $file );

  	// Save options
  	/*save_meta_value('newsletter_options', serialize([
		'bg_image' => 'uploads/modules/newsletter/bg_image.jpg',
		'notice_message' => trans('Sign up to our email newsletter to be the first to hear about great offers.', 'nl')
	]));*/
}