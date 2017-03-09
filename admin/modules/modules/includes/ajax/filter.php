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
include '../../../../../config/bootstrap.php';

$db = getDB();
$keywords = $_POST['keywords'];
$adminModules = $_POST['admin_modules'];
if( !is_ajax() ) return;


$categories = get_modules_categories(); 
$args = array();
$modules = get_modules();
 
if( $_POST['status'] != '' ) {
	$active = get_active_modules();
	foreach ($modules as $name => $module) {
		if( in_array($name, $active) || $modules[$name]['category'] == 'administration' ){
			$modules[$name]['active'] = 1;
		} else {
			$modules[$name]['active'] = 0;
		}
	}
	$args['active'] = $_POST['status'];
}


if( $_POST['author'] != '' ) $args['author'] = $_POST['author'];
if( $_POST['category'] != '' ) $args['category'] = $_POST['category'];
$filter  = modules_filter($modules, $args);

$filterResults = '';
if( !is_empty($filter) ) {
	foreach ($filter as $modname => $module) {
		$description = (isset($module['description'])) ? $module['description'] : '';
		$mcategory = $module['category'];
		$category  = (isset($categories[$mcategory])) ? $categories[$mcategory] : $mcategory;

		$col1 = '<input type=\"checkbox\" value=\"'. $module['name'] .'\" data-name=\"'. $modname .'\">';
		
		$col2 = '<img src=\"'. get_module_icon($modname) .'\" width=\"64\">';
		
		$col3 = '<div class=\"module_name\">'. $module['displayName'] .'<p>'. $description .'</p>';
			$col3 .= '<ul class=\"module-info\"><li><b>'. trans("Version", "modules") .':</b> '. $module['version'] .'</li><li><b>'. trans("By", "modules") .'</b> '. $module['author'] .'</li><li><b>'. trans("Category", "modules") .'</b> '. $category .'</li>';

				if( isset($module['website'])) :
					$col3 .= '<li><b>'. trans("Website", "modules") .'</b> <a href=\"'. $module['website'] .'\" target=\"_blank\">'. $module['website'] .'</a></li>';
				endif;
		$col3 .= '</ul></div>';

		$col4 = '<div class=\"btn-group-action\"><div class=\"btn-group pull-right\">';
		if( $module['category'] != 'administration' ) : 
			if( is_active($module['name']) ) : 
				if( isset($module['config']) ) :
				$col4 .= '<a href=\"?module='. $module['name'] .'&page='. $module['config'] .'\" class=\"btn btn-success\"><i class=\"fa fa-cogs\"></i> '. trans("Configuration", "modules") .'</a>';
				else :
					$col4 .= '<a class=\"btn btn-danger disable\" href=\"#\"><i class=\"fa fa-power-off\"></i> '. trans("Disable", "modules") .'</a>';
				endif;
			else :
				$col4 .= '<a class=\"btn btn-default enable\" href=\"#\"><i class=\"fa fa-power-off\"></i> '. trans("Enable", "modules") .'</a>';
			endif;
				$col4 .= '<button aria-expanded=\"true\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"fa fa-caret-down\"></i>&nbsp;</button>';
				$col4 .= '<ul class=\"dropdown-menu\">';
					if( is_active($module['name']) ) :
						if( isset($module['config']) ) :
							$col4 .= '<li><a class=\"disable\" href=\"#\"><i class=\"fa fa-power-off\"></i> '. trans("Disable", "modules") .'</a></li>';
						endif;
						$col4 .= '<li><a class=\"uninstall\" href=\"#\"><i class=\"fa fa-times\"></i> '. trans("Uninstall", "modules") .'</a></li><li class=\"divider\"></li>';
					endif;
						$col4 .= '<li><a href=\"javascript:;\" class=\"delete\"><i class=\"fa fa-trash\"></i>'. trans("Delete", "modules") .'</a></li></ul>';
		else :
			if( isset($module['config']) ) :
				$col4 .= '<a href=\"?module='. $module['name'] .'&page='. $module['config'] .'\" class=\"btn btn-success\"><i class=\"fa fa-cogs\"></i> '. trans("Configuration", "modules") .'</a>';
			endif;
		endif;
		$col4 .= '</div></div>';

		if( $adminModules == 0  && $module['category'] != 'administration' ) {
			$filterResults .= '["'. $col1 .'", "'. $col2 .'", "'. $col3 .'", "'. $col4 .'"],';
		} else if( $adminModules == 1 ){
			$filterResults .= '["'. $col1 .'", "'. $col2 .'", "'. $col3 .'", "'. $col4 .'"],';
		}
	}
}


if( $filterResults != '' ){
	$return['filter'] = '['. trim($filterResults, ",") .']';
} else {
	$return['filter'] = '[]';
}
echo json_encode( $return );