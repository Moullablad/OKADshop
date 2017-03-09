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

class Session
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
            self::$instance = new Session();
        }
        return self::$instance;
    }


	/**
     * GET SESSION BY KEY
     * @param $key int
     * @return $key || false
     */
	public static function get($key){
        if( array_key_exists($key, $_SESSION) && !empty($_SESSION[$key]) )
            return $_SESSION[$key];

        return false;		
	}


    /**
     * SET SESSION KEY
     * @param $key int
     * @param $value int
     * @return boolean
     */
    public static function set($key, $value){
        if( is_empty($key) || is_empty($value) )
            return false;
        
        return $_SESSION[$key] = $value;
    }


    /**
     * SESSION DESTROY ELEMENT
     * @param $key int
     * @return boolean
     */
    public static function destroy($key){
        if( !self::get($key) )
            return false;

        unset($_SESSION[$key]);
        return true;
    }





//END CLASS
}