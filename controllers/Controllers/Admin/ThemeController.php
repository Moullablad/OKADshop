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
use Core\Models\Admin\Theme;

class ThemeController extends AdminController
{


    public static function init(){
        if( is_admin() ) {
            $functions = get_admin_theme_directory() . '/functions.php';
            if( file_exists($functions) ){
                require_once( $functions );
            }
        }
        //get front functions
        $functions = get_theme_directory() . '/functions.php';
        if( file_exists($functions) ){
            require_once( $functions );
        }
    }



    /**
     * Get active admin theme
     *
     * @return $theme_name
     */
    public static function getTheme(){
        return 'default';
    }



    /**
     * Themes list
     *
     * @return $themes
     */
    /*public function index()
    {
        $data['themes'] = Theme::all(); 
        ViewController::getTemplate('themes/index', $data);
    }*/
    

    
    /**
     * Themes install
     *
     * @return $themes
     */
    /*public function install()
    {
        ViewController::getTemplate('themes/install');
    }*/






//END CLASS
}