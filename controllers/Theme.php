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
use Core\Controllers\Front\UserController;
use Core\Session;

class Theme extends Controller
{

	/**
     * Singleton int
     * @var Singleton $instance
     */
    private static $instance;


    /**
     * GET THEME INSTANCE
     * @return object $instance
     */
    public static function getInstance()
    {
        if( is_null(self::$instance) ){
            self::$instance = new Theme();
        }
        return self::$instance;
    }


    /**
     * GET ACTIVE THEME
     * @return name string
     */
    public static function getTheme(){
        // create_cookie('front_theme', 'frochka');
        if( $cookie = read_cookie('front_theme') ){
            $active = $cookie;
        } else {
            $active = get_meta_value('default_shop_theme');
            if( !$active ) $active = 'frochka';
        }
        return $active;
    }



	/**
     * GET ACTIVE THEME
     * @return name string
     */
	public static function getThemeURI(){
        return _BASE_URI_ . 'themes/'. self::getTheme() .'/';
	}

    /**
     * GET TEMPLATE
     * @param string $view
     * @param object $variables
     */
    public static function getTemplate($view, $variables = []){
        // $UserController = new UserController();
        // $the_user = $UserController->getUserData();

        ob_start(); // Initiate the output buffer
        ob_clean();
        extract($variables);
        require_once( self::getViewPath('header') );
        if( self::getViewPath( $view ) ){
            require_once( self::getViewPath( $view ) );
        } else {
            require_once( self::getViewPath( 'default' ) ); 
        }

        require_once( self::getViewPath('footer') );
        $content = ob_get_clean();
        print $content;

        if (ob_get_length()) ob_end_flush();// Flush the output from the buffer
        exit;
    }


    /**
     * GET TEMPLATE
     * @param string $view
     */
    public static function getViewPath($view){
        $viewPath = '';
        $themeDir = get_theme_directory();

        $themeRootView = $themeDir . $view . '.php';
        $themeView = $themeDir .'/views/'. $view . '.php';
        $coreView = _BASE_URI_ . 'controllers/Views/'. $view . '.php';
        if( file_exists($themeRootView) ) {
            $viewPath = $themeRootView;
        } else if( file_exists($themeView) ) {
            $viewPath = $themeView;
        } else if( file_exists($coreView) ) {
            $viewPath = $coreView;
        }
        return ($viewPath!='') ? $viewPath : false;
    }



//END CLASS
}