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
namespace CoreModules\Languages\Controllers;


class Languages {

    protected static $instance;


    /**
     * Get instance.
     *
     * @wp-hook plugins_loaded
     * @see    __construct()
     * @return void
     */
    public static function getInstance()
    {
        if( is_null(self::$instance) ){
            self::$instance = new self;
        }
        return self::$instance;
    }


    /**
     * Register the action
     */
    public function __construct()
    {
        // Add admin menu links
        global $os_admin_menu;
        $langs = $os_admin_menu->add( trans('Languages', 'lang'), get_page_url('langs', __FILE__));
        $langs->link->prepend('<span class="fa fa-language"></span>');
        $langs->add( trans('Languages', 'lang'), get_page_url('langs', __FILE__));
        $langs->add( trans('Strings translations', 'lang'), get_page_url('strings', __FILE__));
        $langs->add( trans('Settings', 'lang'), get_page_url('settings', __FILE__));

        add_css('languages-css', [
            'src' => module_url(__FILE__, 'assets/css/languages.css'), 
            'admin' => true
        ]);

        add_js('languages-js', [
            'src' => module_url(__FILE__, 'assets/js/languages.js'), 
            'admin' => false
        ]);

    }


//END CLASS 
}