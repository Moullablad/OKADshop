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
	private static $tabs = [];


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
			if (preg_match("/modules#([a-zA-Z0-9_-]*)#/", $replace, $match) === 1) {
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
	 * Render Tabs
	 *
	 * @param string $file
	 * @param string $location
	 */
	public static function render($file, $location, $options = []) {
		$tabs = self::getTabs($file, $location);
		if( empty($tabs) ) return false;

		do_action('before_tab_'.$location);
		
		$data = array();
		$default = array(
			'multilang' => false,
			'ajax' => true,
			'type' => 'ajax'
		);
		$data['args'] = array_merge($default, $options);
		$data['args']['group'] = self::getGroup($file);

		// Define current lang
		if( read_cookie('tabs_selected_lang') ) {
			$id_lang = read_cookie('tabs_selected_lang');
		} else {
			$id_lang = get_lang()->id;
		}

		uasort($tabs, "sort_tabs");
		$data['multilang'] = $default['multilang'];
		$data['location'] = $location;
		$data['tabs'] = $tabs;
		$data['id_lang'] = $id_lang;
		$data['args']['id_lang'] = $id_lang;

		if( $active_tab = read_cookie($location.'_active_tab') ){
			$data['active_tab'] = $active_tab;
		} else {
			$keys = array_keys($tabs);
			$data['active_tab'] = (isset($_GET['tab'])) ? $_GET['tab'] : $keys[0];
		}
		$data['data_ajax'] = ($data['args']['ajax']) ? 'yes' : 'no';

		return get_view($file, 'tabs/layout', $data);
	}


	/**
	 * Get Tab Contents
	 *
	 * @param string $active_tab
	 * @param string $location
	 * @param array $args
	 *
	 * @return $view
	 */
	public static function getContents($active_tab, $location, $args=[]){
		$tab_view_exist = true;
		$data = array();
		$tab = self::getByName($active_tab, $location, $args['group']);
		if( $tab ){
			do_action('before_tab_'.$active_tab);
			$data['module'] = (isset($_GET['module'])) ? $_GET['module'] : '';
			$data['active'] = $active_tab;
			$data['tab_name'] = $tab->name;
			$data['with_form'] = $tab->with_form;
			$data['with_head'] = $tab->with_head;
			ob_start(); ob_clean(); // Initiate the output buffer
			$tab_function = $tab->function;
			if( is_array($tab_function) ) {
				$class = $tab_function[0];
				$method = $tab_function[1];
				if( method_exists($class, $method) ) {
					$tab_function[0]->$method();
				} else {
					$tab_view_exist = false;
				}
			} else if( function_exists($tab_function) ){
				$tab_function();
			}
			$data['content'] = ob_get_clean();
			$data['args'] = $args;
			if( empty($args) ){
				$data['args']['ajax'] = true;
			}
		}
		//Display tab content
		if( $tab_view_exist ) {
			return get_view(__FILE__, 'tabs/content', $data);
		} else {
			return get_view(__FILE__, 'tabs/notfound');
		}	
	}


	/**
     * Get All Tabs
     *
     */
	public static function debugTabs()
	{
		if( !empty(self::$tabs) ){
			$output = '<ul class="nav nav-stacked" id="debug-tabs">';
			foreach (self::$tabs as $name => $tab) {
				$output .= '<li>
					<a data-toggle="collapse" data-parent="#debug-tabs" href="#tab_'. $name .'">'. $name .'</a>
				    <ul id="tab_'. $name .'" class="collapse">';
				    foreach ($tab as $sub_name => $sub_tab) {
				    	$output .= '<li>
							<a data-toggle="collapse" data-parent="#debug-tabs" href="#sub_'. $sub_name .'">'. $sub_name .'</a>
						    <ul id="sub_'. $sub_name .'" class="collapse">';
						    	foreach ($sub_tab as $child_name => $childs) {
						    		$output .= '<li>'. $child_name .'</li>';
						    	}
						    $output .= '</ul></li>';
				    }
				    $output .='</ul></li>';
			}
			$output .= '</ul>';
		}
		echo $output;
	}



//END CLASS	
}