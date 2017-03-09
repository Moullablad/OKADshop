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
	$tabs = Tab::debugTabs();
	if( !empty($tabs) ){
		$output = '<ul class="nav nav-stacked" id="debug-tabs">';
		foreach ($tabs as $name => $tab) {
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
	$tabs = Tab::getTabs($file, $location);
	if( empty($tabs) ) return false;

	do_action('before_tab_location_'.$location);
	
	$data = array();
	$default = array(
		'multilang' => false,
		'ajax' => true,
		'type' => 'ajax'
	);
	$data['args'] = array_merge($default, $options);
	$data['args']['group'] = Tab::getGroup($file);
	// $data['args']['ajax'] = ($data['args']['type']=='link') ? false : true;



	$id_lang = 0;
	if( $data['args']['multilang'] !== false ){
		$selected_lang = Session::get('selected_lang');
		$id_lang = ($selected_lang) ? $selected_lang : get_lang()->id;
	}

	uasort($tabs, "sort_tabs");
	$data['multilang'] = $default['multilang'];
	$data['location'] = $location;
	$data['tabs'] = $tabs;
	$data['id_lang'] = $id_lang;

	if( $active_tab = read_cookie($location.'_active_tab') ){
		$data['active_tab'] = $active_tab;
	} else {
		$keys = array_keys($tabs);
		$data['active_tab'] = (isset($_GET['tab'])) ? $_GET['tab'] : $keys[0];
	}
	$data['data_ajax'] = ($data['args']['ajax']) ? 'yes' : 'no';

	get_view($file, 'tabs/layout', $data);
}


/**
 * Get Tab Contents
 *
 * @param string $active_tab
 */
function get_tab_contents($active_tab, $location, $args=[]){
	$tab_view_exist = true;
	$data = array();
	$tab = Tab::getByName($active_tab, $location, $args['group']);
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
		get_view(__FILE__, 'tabs/content', $data);
	} else {
		get_view(__FILE__, 'tabs/notfound');
	}	
}


/**
 * Sort Tabs
 *
 */
function sort_tabs($a, $b) {
	return $a['position'] - $b['position'];
	// return strcmp($a["position"], $b["position"]);
}