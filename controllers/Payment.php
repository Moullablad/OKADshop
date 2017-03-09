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
use Core\Theme;

class Payment extends Controller
{

    /**
     * Singleton int
     * @var Singleton $instance
     */
    private static $instance;


	/**
     * Singleton int
     * @var Singleton $instance
     */
    private static $methodes = [];


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
     *=============================================================
     * REGISTER PAYEMENT METHOD
     *=============================================================
     * @param string $method
     * @param array $args
     * @return true
     *=============================================================
     * Use this function to add a new payment method to order payment page
     * First param is the slug to module page
     * Args: name => Module name
     *       description => Short description
     *       function => function to be executed 
     *       icon => Module image (64x64)
     */
    public static function setMethod($file, $args=[]){
        if( is_empty($args['name']) || is_empty($args['function']) )
            return false;

        if( !isset($args['icon']) )
            $args['icon'] = "assets/img/icons/cb.png";

        $module_name = Module::getDirname($file);
        self::$methodes[$module_name] = (object) $args;
    }


    /**
     *=============================================================
     * GET PAYMENT METHODE
     *=============================================================
     *
     */
    public static function getMethod($module_name){
        if( is_empty(self::$methodes[$module_name]) )
            return false;
        return (object) self::$methodes[$module_name];
    }


    /**
     *=============================================================
     * GET PAYMENT METHODES
     *=============================================================
     *
     */
    public static function getPaymentMethodes(){
        return (object) self::$methodes;
    }




//END CLASS
}