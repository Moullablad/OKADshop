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

namespace Core;

use Core\Database\Database;

class Hook {
	
	/**
     * Hook array
     * @var Hook $hooks
     */
	private static $hooks = [];
	

	/**
     * Sec array
     * @var Sec $sections
     */
	private static $sections = [];


	/**
     * Get Hooks
     *
     * @return $hooks array
     */
	public static function getHooks() {
		return self::$hooks;
	}


	/**
     * Get Section Hooks
     *
     * @return $hooks array
     */
	public static function getSectionHooks($section_name=null) {
		if( is_null($section_name) ){
			$sections = get_sections();
			reset($sections);
			$section_name = key($sections);
		}
		$result = array();
		$hooks = self::getHooks();
		$activeHooks = self::getBySection($section_name);
		foreach ($activeHooks as $key => $hook) {
			$result['active'][$hook->hook_function] = $hooks[$hook->hook_function];
			unset($hooks[$hook->hook_function]);
		}
		$result['inactive'] = $hooks;
		return $result;
	}


	/**
     * Get Hook By Name
     *
     * @param string $name
     *
     * @return array $hooks
     */
	public static function getByName($name) {
		if( isset(self::$hooks[$name]) ){
			return self::$hooks[$name];
		}
		return false;
	}


	/**
     * Get Hooks By Section
     *
     * @param string $section_name
     *
     * @return array $hooks
     */
	public static function getBySection($section_name) {
		$db = getDB();
		return $db->prepare("SELECT h.* FROM {$db->prefix}module_hooks h LEFT JOIN {$db->prefix}modules m ON m.id = h.id_module WHERE h.section_name=? AND m.active=1 ORDER BY h.position ASC", [$section_name]);
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
	public static function addHook($file, $section_name, $hook_function, $name, $description="") {
		if( trim($section_name) !== '' && trim($hook_function) !== '' ){
			$module_name = get_module_dirname($file);
			if (strpos($file, get_admin_dirname()) !== false) {
				$module_name = 'core-'. $module_name;
			}
			return self::$hooks[$hook_function] = [
				'module_name' => ($module_name) ? $module_name : '',
				'section_name' => $section_name,
				'name' => $name,
				'description' => $description
			];
		}
		return false;
	}




	/**
     * Register Sections
     *
     * @param string $unique_id
     * @param string $name
     * @param string $description
     */
	public static function addSection($unique_id, $name, $description="") {
		if( trim($unique_id) !== '' && trim($name) !== '' ){
			return self::$sections[$unique_id] = ['displayName' => $name, 'description' => $description];
		}
		return false;
	}


	/**
     * Get Sections
     *
     * @return $sections array
     */
	public static function getSections() {
		return self::$sections;
	}



//END CLASS	
}