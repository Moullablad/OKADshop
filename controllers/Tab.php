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

class Tab {
	
	/**
     * Tabs array
     * @var Tabs $tabs
     */
	public static $tabs = [];


	/**
     * Get Tabs Group
     *
     * @param  $file string
     * @return $group_name string
     */
	public static function getGroup($file)
	{
		$group = $file;
		$siteBase = str_replace('\\', '/', $file);
		if ( strpos($siteBase, site_base()) !== false ){
			$replace = str_replace(site_base(), '', $file);
			$replace = str_replace('\\', '/', $replace);
			$replace = str_replace('/', '#', $replace);
			if (preg_match("/modules#([a-zA-Z0-9_]*)#/", $replace, $match) === 1) {
				$group = $match[1];
			}
		}
		return $group;
	}


	/**
     * Attach Tabs to specific location
     *
     * @param string $group
     * @param string $location
     * @param array $tabs
     */
	public static function attachTabs($group, $location, $tabs=array())
	{
		self::addTabs($group, $location, $tabs);
	}


	/**
     * Register Tabs
     *
     * @param string $file
     * @param string $location
     * @param array $tabs
     */
	public static function addTabs($file, $location, $tabs=array())
	{
		if( empty($tabs) ) return false;
		$group = self::getGroup($file);
		if( false !== $group ){
			$default = [
	            'with_form' => false,
				'with_head' => false,
				'multilang' => false,
				'position' => 1
	        ];
	        foreach ($tabs as $name => $tab) {
	        	$tabs_params = array_merge($default, $tab);
				self::$tabs[$group][$location][$name] = $tabs_params;
	        }
		}
	}


	/**
     * Get Tab By Name
     *
     * @param string $name
     * @return array $tabs
     */
	public static function getByName($name, $location, $group=null)
	{
		if( is_admin() && is_null($group) ){
			$group = get_url_param('module');
		}
		
		if( isset(self::$tabs[$group][$location][$name]) ){
			return (object) self::$tabs[$group][$location][$name];
		}
		return false;
	}

	/**
     * Get Tabs
     *
     * @param string $file
     * @param string $location
     */
	public static function getTabs($file, $location) {
		$group = self::getGroup($file);
		if( isset(self::$tabs[$group][$location]) ){
			return self::$tabs[$group][$location];
		}
		return false;
	}


	/**
     * Get All Tabs
     *
     */
	public static function debugTabs()
	{
		return self::$tabs;
	}






//END CLASS	
}