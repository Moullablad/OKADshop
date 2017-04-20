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
namespace Modules\Newsletter\Controllers;


class Newsletter {

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

        add_css('newsletter-css', [
            'src' => module_url(__FILE__, 'assets/css/newsletter.css'), 
            'admin' => true
        ]);

        add_js('newsletter-js', [
            'src' => module_url(__FILE__, 'assets/js/newsletter.js'), 
            'admin' => false
        ]);


    }


    public static function subscribe($data) {
        if( $data['email'] == '' ) return false;

        // Get databse instance
        $db = getDB();

        // Prepare newsletter data
        $date = date("Y-m-d H:i:s");
        $default = array(
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'udate' => $date
        );
        $columns = array_merge($default, $data);
        
        // Dont show popup again for this user
        create_cookie('nl_dont_show_again', 1);

        // Subscribe user to newsletter
        $result = $db->findByColumn('newsletter', 'email', $columns['email'], ['id']);
        if( isset($result[0]->id) ) {
            return getDB()->update('newsletter', $result[0]->id, $columns);
        } else {
            $columns['cdate'] = $date;
            return getDB()->create('newsletter', $columns);
        }
    }



//END CLASS 
}