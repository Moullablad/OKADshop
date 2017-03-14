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

use Core\Controllers\Controller;
use Core\Database\Database;
use Core\Theme;

class Module extends Controller
{

    /**
     * Singleton int
     * @var Singleton $instance
     */
    private static $instance;


    /**
     * Pages array
     * @var Pages $front_pages
     */
    public static $front_pages;


    /**
     * Pages array
     * @var Pages $admin_pages
     */
    public static $admin_pages;



	/**
     * Actions array
     * @var Actions $actions
     */
    private static $actions;


    /**
     * GET THEME INSTANCE
     * @return object $instance
     */
    public static function getInstance()
    {
        if( is_null(self::$instance) ){
            self::$instance = new Module();
        }
        return self::$instance;
    }



    /**
     *
     * GET MODULE NAME FROM FILE
     *
     * @return array $pages
     */
    public static function getDirname($file){
        //get file location
        $location = str_replace('\\', '/', $file);
        return self::getStringBetween($location, 'modules/', '/');
    }


    /**
     *
     * GET VIEW PATH
     *
     * @param string $module_name
     * @param string $view_name
     * @return string $view_path
     */
    public static function getModuleViewPath($module_name, $view_name){
        $theme_uri  = Theme::getThemeURI();
        $theme_view_path = $theme_uri . 'modules/' . $module_name . '/views/' . $view_name .'.php';
        $module_view_path = _BASE_URI_ . 'modules/' . $module_name . '/views/' . $view_name .'.php';
        //check if view exist
        if( file_exists($theme_view_path) ){
            return $theme_view_path;
        } elseif( file_exists($module_view_path) ){
            return $module_view_path;
        }
        return false;
    }



    /**
     *
     * GET VIEW
     *
     * @param string $location
     * @param string $view_name
     * @param object $params
     * @return object $instance
     */
    public static function getView($file, $view_name, $variables=[]){
        //get module name
        $module_name = self::getDirname($file);
        $view_path = self::getModuleViewPath($module_name, $view_name);
        //require view and send params
        extract($variables);
        if( !is_empty($view_path) ){
            require $view_path;
        } else {
            self::notFound();
        }
        return false;
    }


    /**
     *
     * REGISTER MODULE PAGE
     *
     * @param string $name
     * @param string $function
     * @return true
     */
    public static function setPage($file, $name, $function_to_add){
        self::$front_pages[$name] = array(
            'module_name' => get_module_dirname($file), 
            'function' => $function_to_add
        );
    }


    /**
     *
     * Get front pages
     *
     * @return array $page
     */
    public static function getFrontPages(){
        return self::$front_pages;
    }


    /**
     *
     * REGISTER MODULE ADMIN PAGE
     *
     * @param string $file
     * @param string $name
     * @param string $title
     * @param string $function_to_add
     * @return true
     */
    public static function setAdminPage($file, $args=[]){
        $default = array(
            'name' => 'page_name',
            'title' => 'Exemple Page',
            'function' => '',
            'icon' => 'file-text',
            'with_nav' => false
        );
        $params = (object) array_merge($default, $args);
        $module = self::getDirname($file);
        self::$admin_pages[$module][$params->name] = $params;
    }


    /**
     *
     * GET CURRENT MODULE PAGE
     *
     * @return array $view_path
     */
    public static function getCurrentPage(){
        if( !is_empty( self::$front_pages ) && isset($_GET["Module"]) ){
            $page = $_GET["Module"];
            if ( array_key_exists($page, self::$front_pages ) ) {
                return self::$front_pages[$page];
            }
        }
        return false;
    }



    /**
     *
     * GET CURRENT MODULE ADMIN PAGE
     *
     * @return array $view_path
     */
    public static function getCurrentAdminPage(){
        if( !is_empty( self::$admin_pages ) ){
            $slug = $_GET["slug"];
            $page = $_GET["page"];
            if( isset(self::$admin_pages[$slug][$page]) ){
                $function = self::$admin_pages[$slug][$page];
                if( function_exists($function) ){
                    $function();
                } else {
                    echo '<div class="alert alert-warning">Function not found !</div>';
                }
            } else {
                echo '<div class="alert alert-warning">Page not found !</div>';
            }
        }
        return false;
    }

    
    /**
     *
     * GET MODULE PAGES
     *
     *
     */
    public static function PageRender(){
        $current_page = self::getCurrentPage();
        $module_page_function = $current_page['function'];
        /*$page_init = $module_page_function.'_init';
        if (function_exists($page_init)) {
            $page_init();
        }*/
        if( function_exists($module_page_function) ){
            ob_start(); // Initiate the output buffer
            ob_clean();
            $module_page_function(); //call function
            $content = ob_get_clean();
            require_once( Theme::getViewPath('header') );
            print $content;
            require_once( Theme::getViewPath('footer') );
            ob_end_flush(); // Flush the output from the buffer
            exit;
        }
    }


    /**
     * GET TEMPLATE
     * @param string $view
     * @param object $variables
     */
    public static function getPage($file, $view_name, $variables = []){
        ob_start(); // Initiate the output buffer
        
        ob_clean();
        extract($variables);
        require_once( self::getViewPath('header') );

        self::getView($file, $view_name, $variables);

        require_once( self::getViewPath('footer') );
        $content = ob_get_clean();
        print $content;

        ob_end_flush(); // Flush the output from the buffer
        exit;
    }





    /**
     *
     * ADD ACTION HOOK
     *
     * @param string $name
     * @param string $function_to_add
     * @param int $priority
     * @return boolean
     */
    public static function addAction( $name, $function_to_add, $priority ){
        self::$actions[$name][] = array('function' => $function_to_add, 'priority' => $priority);
    }


    /**
     *
     * EXECUTE ACTION HOOK
     *
     * @param int $name
     * @return boolean
     */
    public static function doAction( $name, $args=[] ){
        if( !is_empty( self::$actions ) ){
            if ( array_key_exists($name, self::$actions ) ) {
                $array = self::$actions[$name];
                $hooks = array_sort($array, 'priority');
                if( !is_empty( $hooks ) ){
                            // var_dump($args);exit;
                    foreach ($hooks as $key => $hook) {
                        $hook_function = $hook['function'];
                        if( function_exists($hook_function) ){
                            call_user_func_array($hook_function, [$args]);
                            // print $hook_function();
                        }
                    }
                }
            }
        }
    }

    /**
     *
     * GET ACTION HOOK
     *
     * @param string name
     * @return array actions
     */
    public static function getAction( $name ){
        return self::$actions[$name];
    }



    


//END CLASS
}