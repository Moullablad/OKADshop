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

class View {
	
	


	/**
     * GET CORE VIEW
     *
     * @param string $file
     * @param string $view
     * @param object $variables
     */
    public static function getView($file, $view, $variables = []){
        //format base url
        $replace = str_replace(site_base(), '', $file);
        $replace = str_replace('\\', '/', $replace);
        $replace = str_replace('/', '#', $replace);
        $view_path = '';

        //check if called from admin
        if( is_admin() ){

            if (preg_match("/modules#([a-zA-Z0-9_-]*)#/", $replace, $match) === 1) {
                //check if front modules
                if (strpos($replace, get_admin_dirname()) !== false){
                    $module_view = admin_base() .'modules/'. $match[1] .'/views/'. $view . '.php';
                } else {
                    $module_view = site_base() .'modules/'. $match[1] .'/views/'. $view . '.php';
                }
                //get front theme view
                $theme_view = get_theme_directory() .'modules/'. $match[1] .'/views/'. $view . '.php';
                if( file_exists( $theme_view ) ) {
                    $view_path =  $theme_view;
                } else if( file_exists( $module_view ) ) {
                    $view_path =  $module_view;
                }
            } else if (preg_match("/themes#([a-zA-Z0-9_-]*)#/", $replace, $match) === 1) {
                $admin_themes = admin_base() .'modules/'. $match[1] .'/views/'. $view . '.php';
                if( file_exists( $admin_themes ) ){
                    $view_path =  $admin_themes;
                }
            }
        } else {

            if (preg_match("/modules#([a-zA-Z0-9_-]*)#/", $replace, $match) === 1) {
                //check if front modules
                if (strpos($replace, get_admin_dirname()) !== false){
                    $module_view = admin_base() .'modules/'. $match[1] .'/views/'. $view . '.php';
                } else {
                    $module_view = site_base() .'modules/'. $match[1] .'/views/'. $view . '.php';
                }
                //get front theme view
                $theme_view = get_theme_directory() .'modules/'. $match[1] .'/views/'. $view . '.php';
                if( file_exists( $theme_view ) ) {
                    $view_path =  $theme_view;
                } else if( file_exists( $module_view ) ) {
                    $view_path =  $module_view;
                }
            } else {
                //module front page
                if( isset($_GET['Module']) && is_page($_GET['Module']) ){
                    $path = 'views/'. $view . '.php';
                    $path = get_front_page_module($_GET['Module'], $path);
                    if( $path ){
                        $path = site_base($path);
                        if( file_exists( $path ) ) {
                            $view_path =  $path;
                        }
                    }
                }
            }
 
        }

        //default view from core
        if( $view_path == '' ) {
            //get front theme view
            $coreView  = _BASE_URI_ . 'controllers/Views/'. $view .'.php';
            $theme_view = get_theme_directory() .'/views/'. $view . '.php';
            if( file_exists( $theme_view ) ) {
                $view_path =  $theme_view;
            }else if( file_exists($coreView) ) {
                $view_path = $coreView;
            } else {
                $view_path = _BASE_URI_ . 'controllers/Views/default.php';
            }
        }

        if( !empty($variables) )
            extract($variables);

        if( $flash = get_flash_message() ) {
            $message[$flash['type']] = $flash['content'];
        }

        //show notif message
        if( isset($message) && !empty($message) ){
            extract($message);
            require( _BASE_URI_ . 'controllers/Views/alerts.php' );
        }
        
        require( $view_path );
    }

    


//END CLASS	
}