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


// Instanciate module
Modules\Newsletter\Controllers\Newsletter::getInstance();


// Register translation domain
add_domain(__FILE__, 'nl');


// Install function
function newsletter_install() {
	// Create table
	global $common;
  	$file = module_base(__FILE__, 'db_dump.sql');
  	$common->run_sql_file( $file );

  	// Copy default background
  	$distination = site_base('uploads/modules/newsletter/bg_image.jpg');
	if( ! file_exists(dirname($distination)) ) {
	    mkdir(dirname($distination), 0777, true);
	}
	copy(module_base(__FILE__, 'assets/img/bg_image.jpg'), $distination);

  	// Save options
  	save_meta_value('newsletter_options', serialize([
		'bg_image' => 'uploads/modules/newsletter/bg_image.jpg',
		'notice_message' => trans('Sign up to our email newsletter to be the first to hear about great offers.', 'nl')
	]));
}


function newsletter_before_footer(){
	return get_view(__FILE__, 'front/nl-block');
}
add_hook(__FILE__, 'before_footer', 'newsletter_before_footer', 'Block newsletter', 'Display newsletter block before footer section.');


$trans = trans('ABC', 'nl');