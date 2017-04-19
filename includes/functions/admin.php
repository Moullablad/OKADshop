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
 * THIS FILE GROUP ALL ADMIN FUNCTIONS
 * ------------------------------------------------------------------
 *
 */

use Core\Module;
use Core\Controllers\Admin\ThemeController;
use Core\Controllers\Admin\ViewController;
use Core\Controllers\Admin\UserController;
use Core\Models\Admin\Product;




/**
 * Check if admin area 
 *
 * @return bool
 */
function is_admin(){
    if( is_ajax() ) {
        $root = $_SERVER['DOCUMENT_ROOT'] .'/';
        $dirname = str_replace($root, '', site_base());
    } else {
        $physical_uri = get_shop('physical_uri');
        $filename = $_SERVER['SCRIPT_NAME'];
        $dirname = preg_replace("!$physical_uri|index.php|/!", "", $filename);
    }
    return ( $dirname != '' ) ? true : false;
}



/**
 * Get admin directory name
 *
 * @return $dirname
 */
function get_admin_dirname(){
    global $GLOBALS;
    $siteroot = site_base();
    $physical_uri = $GLOBALS['os']->physical_uri;
    $dirname = '';
    if( ! is_ajax() ) {
        $filename = $_SERVER['SCRIPT_NAME'];
        $dirname = preg_replace("!$physical_uri|index.php|/!", "", $filename);
    }
    if( $dirname == '' ){
        foreach(glob( $siteroot . '*/okadshop.admin', GLOB_BRACE) as $path) {
            $dirname = preg_replace("!$siteroot|/okadshop.admin!", '', $path);
        }
    }
    return $dirname;
}


/**
 * Get admin base directory
 *
 * @return directory
 */
function admin_base($path=''){
    return site_base($GLOBALS['os']->admin_dirname .'/'. $path);
}

/**
 * Get admin Url
 *
 * @return $url
 */
function admin_url($path=''){
    return site_url($GLOBALS['os']->admin_dirname .'/'. $path);
}


/**
 * Get active admin theme name
 *
 * @return $name string
 */
function get_admin_theme(){
    return ThemeController::getTheme();
}


/**
 * Get theme directory path
 *
 * @return directory
 */
function get_admin_theme_directory($path=''){
    return admin_base('themes/'. get_admin_theme() .'/'. $path);
}


/**
 * Get theme url
 *
 * @return uri
 */
function get_admin_theme_url($path=''){
    return admin_url('themes/'. get_admin_theme() .'/'. $path);
}



/**
 * ADD ADMIN PAGE
 *
 * @param string $file
 * @param string $name
 * @param string $title
 * @param string $function_to_add
 * @return true
 */
function add_admin_page($file, $args=[]) {
	return Module::setAdminPage($file, $args);
}



/**
 * GET CURRENT ADMIN PAGE
 *
 * @return function
 */
function get_current_admin_page(){
	return Module::getCurrentAdminPage();
}



/**
 * Get page uri
 *
 * @param $file string
 * @param $name string
 * @return uri
 */
function get_page_url($name, $file){
    $moduleName = $file;
    if( $module = get_module_dirname($file) ) {
        $moduleName = $module;
    }
    $url = admin_url('index.php?module='. $moduleName);
    if( $name != '' ){
        $url .= '&page='. $name; 
    } else {
        $url .= '&page=index'; 
    }
    return $url;
}


/**
 * Get favicon
 *
 * @return url
 */
function get_favicon(){
    $favicon = get_theme_option('favicon');
    if( $favicon ){
        return $favicon;
    }
    return 'assets/img/icons/favicon.ico';
}



/**
 * Get view
 *
 * @return directory
 */
function get_admin_view($view, $variables = []){
    ViewController::getView( $view, $variables );
}





/**
 * Get admin data by key
 *
 * @param $key string
 * @return data
 */
function get_admin($key){
    return UserController::get($key);
}


/**
 * GET CATEGORY TREE
 *
 * @param $parent
 * @return $children
 */
function category_tree($parent=0) {
    $children = array();
    $model = new Product();
    $categories = $model->getCategoriesByParent($parent);
    foreach($categories as $key => $category){
        $children[$category->id_category.'|'.$category->link_rewrite.'|'.$category->name] = category_tree($category->id_category);
    }
    return $children;
}

/**
 * MAKE A LIST FROM AN ARRAY
 *
 * @param $array array
 * @param $cat_ids array
 * @param $cat_default int
 * @return $output
 */
function make_list($array, $cat_ids, $cat_default)
{
    //Base case: an empty array produces no list
    if (empty($array)) return '';

    //Recursive Step: make a list with child lists
    $output = '<ul>';
    foreach ($array as $key => $subArray) {
        $key_value = explode('|', $key);
        $cat_ID = $key_value[0];//preg_replace('|{.*|', '', $key);
        $cat_name = $key_value[2];
        $checked = (in_array($cat_ID, $cat_ids)) ? 'checked' : '';  
        $rchecked = ($cat_ID==$cat_default) ? 'checked' : '';  

        $output .= '<li class="parent_'.$cat_ID.'">';
        $output .= '<span>'. $cat_name .'</span>';
        $output .= '<div class="pull-right">';
        $output .= '<input type="radio" name="product[id_category_default]" value="'. $cat_ID .'" '.$rchecked.' required>';
        $output .= '<input type="checkbox" name="categories[]" value="'. $cat_ID .'" '.$checked.'>';
        $output .= '</div>';

        $output .= make_list($subArray, $cat_ids, $cat_default) . '</li>';
    }
    $output .= '</ul>';
    
    return $output;
}