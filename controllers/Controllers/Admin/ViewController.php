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

class ViewController extends AdminController
{


    /**
     * GET TEMPLATE
     *
     * @param string $view
     * @param object $variables
     */
    public static function getTemplate($view, $variables = []){
        ob_start(); // Initiate the output buffer
        ob_clean();

        self::getHeader();
        require get_admin_theme_directory('partials/adminbar.php');
        require get_admin_theme_directory('partials/adminmenu.php');
        self::getView( $view, $variables );
        self::getFooter();

        $content = ob_get_clean();
        print $content;

        if (ob_get_level()>1) { ob_end_flush(); }
        // ob_end_flush(); // Flush the output from the buffer
        exit;
    }


    /**
     * GET HEADER
     *
     */
    public static function getHeader(){
        $theme = get_admin_theme(); //self::getTheme();
        require_once( admin_base() . 'themes/' . $theme .'/header.php' );
    }

    /**
     * GET FOOTER
     *
     */
    public static function getFooter(){
        $theme = get_admin_theme(); //self::getTheme();
        require_once( admin_base() . 'themes/' . $theme .'/footer.php' );
    }


	/**
     * GET ADMIN VIEW
     *
     * @param string $view
     * @param object $variables
     */
    public static function getView($view, $variables = []){
        $theme = get_admin_theme(); //self::getTheme();
        $viewTheme = admin_base() . 'themes/' . $theme .'/views/'. $view . '.php';
        $viewPath = site_base() . 'controllers/Views/admin/'. $view .'.php';
        if( file_exists($viewTheme) ){
            extract($variables);
            require_once( $viewTheme );
        } elseif( file_exists($viewPath) ){
            extract($variables);
            require_once( $viewPath );
        } else {
            require_once( site_base() . 'controllers/Views/admin/default.php' );
        }
    }

    



//END CLASS
}