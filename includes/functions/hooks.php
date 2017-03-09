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
 * THIS FILE GROUP ALL HOOKS FUNCTIONS
 * ------------------------------------------------------------------
 *
 *
 */

use Core\Hook;


/**
 * Register Sections
 *
 * @param string $unique_id
 * @param string $name
 * @param string $description
 */
function add_section($unique_id, $name, $description="") {
	return Hook::addSection($unique_id, $name, $description);
}


/**
 * Get Section content
 *
 * @param $name string
 * @return $content html
 */
function get_section($name) {
	if( trim($name) == '' ) return;
	do_action('before_'.$name);
	$hooks = Hook::getBySection($name);
	if( !empty($hooks) ){
		foreach ($hooks as $key => $hook) {
			$hook_function = $hook->hook_function;
			if (function_exists( $hook_function ) ){
				echo '<div class="block">';
				print $hook_function();
				echo '</div>';
			}
		}
	}
	do_action('after_'.$name);
}

function execute_section_hooks($name) {
	get_section($name);
}


/**
 * Get Sections
 *
 * @return $sections array
 */
function get_sections() {
	return Hook::getSections();
}


/**
 * Register Hook
 *
 * add new hook from module files
 *
 * @param string $section_name
 * @param string $hook_function
 * @param string $name
 * @param string $description
 */
function add_hook($file, $section_name, $hook_function, $name, $description) {
	return Hook::addHook($file, $section_name, $hook_function, $name, $description);
}


/**
 * Get Hooks
 *
 * @return $hooks array
 */
function get_hooks() {
	return (object) Hook::getHooks();
}


/**
 * Get Section Hooks
 *
 * @param $section_name string
 * @return $hooks array
 */
function get_section_hooks($section_name=null) {
	return Hook::getSectionHooks($section_name);
}


/**
 * Get Hooks By Section
 *
 * @param string $section_name
 * @return array $hooks
 */
function get_hooks_by_section($section_name) {
	return Hook::getBySection($section_name);
}

/**
 * Get Hook By Name
 *
 * @param string $name
 * @return array $hooks
 */
function get_hook_by_name($name) {
	return Hook::getByName($name);
}

/**
 * Register default sections
 */
add_section('top_banner', 'Top Banner');
add_section('top_left', 'Top Left');
add_section('top_right', 'Top Right');
add_section('header', 'Header');
add_section('home_center', 'Home Center');
add_section('left_sidebar', 'Left sidebar');
add_section('right_sidebar', 'Right sidebar');
add_section('before_footer', 'Before Footer');
add_section('footer', 'Footer');
add_section('footer_copyright', 'Footer Copyright');