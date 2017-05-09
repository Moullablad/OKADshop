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
CoreModules\Categories\Controllers\Categories::getInstance();


// Register translation domain
add_domain(__FILE__, 'cats');


// Install function
function categories_install() {
	// Create module tables
	global $common;
  	$file = module_base(__FILE__, 'inc/db_dump.sql');
  	$common->run_sql_file( $file );
}

// Register hooks
function display_block_categories() {
	$cat_tree = category_tree(1);
	return CoreModules\Categories\Controllers\Categories::drawCategoriesTree($cat_tree);
}
add_hook(__FILE__, 'left_sidebar', 'display_block_categories', 'Block categories', 'Display categories.');
add_hook(__FILE__, 'column_left', 'display_block_categories', 'Block categories', 'Display categories.');