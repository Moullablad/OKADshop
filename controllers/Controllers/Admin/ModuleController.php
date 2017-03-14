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

namespace Core\Controllers\Admin;

use Core\Controllers\Admin\ViewController;
use Core\Models\Admin\Module;


class ModuleController extends Module
{

	/**
     * Module array
     * @var Module $categories
     */
	private static $categories = [];
	public static $modules = [];

	

	/**
     * Initialize Modules
     *
     * @return void
     */
	public static function init(){
		//Core Modules
        foreach(glob( admin_base('modules/*/index.php'), GLOB_BRACE) as $path) {
        	self::addNamespace('Module\Admin\\', $path);

			$name = \get_module_dirname($path);
			self::$modules[$name] = array(
				'type' => 'core',
				'path' => str_replace('index.php', '', $path)
			);

        	require_once($path);
        }
        //Custom Modules
		if( $modules = Module::getActive() ){
			foreach ($modules as $key => $name) {
				//check if index file exist
				if (0 !== strpos($name, 'core-')) {
					$modulePath = module_base($name, 'index.php');
					if( file_exists($modulePath) ){
						self::$modules[$name] = array(
							'type' => 'front',
							'path' => str_replace('index.php', '', $modulePath)
						);
						self::addNamespace('Module\Front\\', $modulePath);
						require_once($modulePath);
					}
				}
			}
		}
	}


	/**
     * Add Namespace
     *
     * @param string $path
     * @return void
     */
	public static function addNamespace($prefix, $path){
		// instantiate the loader
		$loader = new \Core\Psr4AutoloaderClass;
		$loader->register(); // register the autoloader
		$classDir = module_base($path, 'includes/controllers/');
    	$moduleName = get_module_dirname($path);
    	$moduleName = preg_replace("!-|_!", " ", $moduleName);
    	$moduleName = ucwords($moduleName);
    	$moduleName = str_replace(' ', '_', $moduleName);
    	$prefix .= $moduleName;
    	$loader->addNamespace($prefix, $classDir);
    }


	/**
     * Install Module
     *
     * @param $name string
     * @return bool
     */
	public static function install($name){
		$index = module_base($name, 'index.php');//modules_base($name .'/index.php');
		if( !file_exists($index) ){
			return false;
		}
		require_once($index);
		$db = getDB();
		$count = $db->prepare("SELECT COUNT('id') as nbr, MAX(position) as max FROM {$db->prefix}modules WHERE name=?", [$name], true);
		if( $count->nbr == '0' ){
			$fields = array(
				'name' => $name,
				'active' => 1,
				'position' => ($count->max + 1),
				'cdate' => date("Y-m-d H:i:s")
			);
			$insert = $db->create("modules", $fields);
		}
		//run install function
		$modname = str_replace('core-', '', $name);
		$module_name = str_replace('-', '_', $modname);
		$module_install = $module_name.'_install';
		if (function_exists( $module_install ) ){
			$module_install();
		} 
		self::deleteConfig();
		return self::addHooks($name);		
	}

	/**
     * Delete uninstall
     *
     * @param $name string
     * @return bool
     */
	public static function uninstall($name){
		$id_module = get_module_by_name('id', $name);
		if( $id_module ){
			$db = getDB();
			$delete = $db->prepare("DELETE FROM `{$db->prefix}modules` WHERE `id`=?", [$id_module]);
			if( $delete ){
				$db->prepare("DELETE FROM {$db->prefix}module_hooks WHERE id_module=?", [$id_module]);
				//run uninstall function
				$modname = str_replace('core-', '', $name);
				$module_name = str_replace('-', '_', $modname);
				$module_uninstall = $module_name.'_uninstall';
				if (function_exists( $module_uninstall ) ) $module_uninstall();
			}
		}
		self::deleteConfig();
		return true;
	}


	/**
     * Delete Module
     *
     * @param $name int
     * @return bool
     */
	public static function delete($name){
		if( self::uninstall($name) ){
			// $modules = get_modules();
			// $category = $modules[$name]['category'];
			// $index = get_module_index($name, $category);
			$module_dir = module_base($name);//dirname($index);
			remove_folders($module_dir);
		}
		return true;
	}


	/**
     * Activalte Module
     *
     * @param $name string
     * @return bool
     */
	public static function enable($name){
		$db = getDB();
		$count = $db->prepare("SELECT COUNT('id') as nbr FROM {$db->prefix}modules WHERE name=?", [$name], true);
		if( $count->nbr == '0' ){
			self::install($name);//Install module
		}
		$udate = date("Y-m-d H:i:s");
		$db->prepare("UPDATE `{$db->prefix}modules` SET `active`=1,`udate`=? WHERE `name`=?", [$udate, $name]);
		return self::addHooks($name);
	}


	/**
     * Disable Module
     *
     * @param $name string
     * @return bool
     */
	public static function disable($name){
		$db = getDB();
		$udate = date("Y-m-d H:i:s");
		return $db->prepare("UPDATE `{$db->prefix}modules` SET `active`=0,`udate`=? WHERE `name`=?", [$udate, $name]);
	}
	

	/**
     * Add Module Hooks
     *
     * @param $module_name string
     * @return bool
     */
	public static function addHooks($module_name){
		$db = getDB();
		// $modules = get_modules();
		// $category = $modules[$module_name]['category'];
		// $index = get_module_index($module_name, $category);
		$index = module_base($module_name, 'index.php');
		if( !file_exists($index) ){
			return false;
		}
		require_once($index);
		$hooks = get_hooks();
		$cdate = date("Y-m-d H:i:s");
		$pos = 1;
		$fail = 0;
		$id_module = get_module_by_name('id', $module_name);
		if( !$id_module ) return false;
		foreach ($hooks as $function => $hook) {
			if( $hook['module_name'] == $module_name ){
				$section_name = $hook['section_name'];
				$count = $db->prepare("SELECT COUNT('id') as nbr FROM {$db->prefix}module_hooks WHERE hook_function=? AND section_name=?", [$function, $section_name], true);
				if( $count->nbr == '0' ){
					$fields = array(
						'id_module' => $id_module,
						'section_name' => $section_name,
						'hook_function' => $function, 
						'position' => $pos, 
						'cdate' => $cdate
					);
					$insert = $db->create("module_hooks", $fields);
					if( !$insert ) $fail += 1;
					$pos++;
				}
			}
		}
		return ($fail==0) ? true : false;
	}



	/**
     * Delete config file
     *
     * @return void
     */
	public static function deleteConfig(){
		$configFile = site_base('modules/config.txt');
        if( file_exists($configFile) ){
        	unlink($configFile);
        }
    }



	/**
     * Get modules categories
     *
     * @return $categories
     */
	public static function getCategories(){
		return self::$categories;
    }


	/**
     * Add Categories
     *
     * @param $categories array
     * @return void
     */
	public static function addCategories($categories){
		foreach ($categories as $name => $displayName) {
			self::$categories[$name] = $displayName;
		}
    }



//END CLASS
}