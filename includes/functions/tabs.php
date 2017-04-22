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
 * THIS FILE GROUP ALL TABS FUNCTIONS
 * ------------------------------------------------------------------
 *
 *
 */

use Core\Tab;
use Core\Session;


/**
 * Get all Tabs
 *
 */
function debug_tabs(){
	return Tab::debugTabs();
}


/**
 * Attach Tabs to specific location
 *
 * @param string $group
 * @param string $location
 * @param array $tabs
 */
function attach_tabs($group, $location, $tabs=array()){
	return Tab::attachTabs($group, $location, $tabs);
}

/**
 * Register Tabs
 *
 * @param string $file
 * @param string $location
 * @param array $tabs
 */
function add_tabs($file, $location, $tabs=array()){
	return Tab::addTabs($file, $location, $tabs);
}


/**
 * Get Tabs
 *
 * @param string $file
 * @param string $location
 */
function get_tabs($file, $location, $options = []) {
	return Tab::render($file, $location, $options);
}


/**
 * Get Tab Contents
 *
 * @param string $active_tab
 */
function get_tab_contents($active_tab, $location, $args=[]){
	return Tab::getContents($active_tab, $location, $args);
}


/**
 * Sort Tabs
 *
 */
function sort_tabs($a, $b) {
	return $a['position'] - $b['position'];
}