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

class Ajax {
	

    private static $actions = [];


    public static function addAction($name, $callable)
    {
        return self::$actions[$name] = $callable;
    }


    public static function getActions()
    {
        return self::$actions;
    }


    public static function doAction($name, $args=[])
    {
        if( !isset(self::$actions[$name]) )
            return false;

        $method = self::$actions[$name];
        if( is_array($method) ) {
            return call_user_func_array(array($method[0], $method[1]), [$args]);
        } else if( function_exists($method) ){
            return call_user_func_array($method, [$args]);
        }
        return false;
    }





//END CLASS	
}