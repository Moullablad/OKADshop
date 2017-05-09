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

class Cookie
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
            self::$instance = new Cookie();
        }
        return self::$instance;
    }


	/**
     * GET COOKIE BY KEY
     * @param $key int
     * @return $key || false
     */
	public static function get($key){
        if( array_key_exists($key, $_COOKIE) && !empty($_COOKIE[$key]) ){
            global $_COOKIES;
            $cookie_value = $_COOKIE[$key];
            $data = @unserialize($cookie_value);
            if ($data !== false) {
                return $data;
            } else {
                return $cookie_value;
            }
        }

        return false;		
	}


    /**
     * SET COOKIE KEY
     * @param $key int
     * @param $value int
     * @return boolean
     */
    public static function set($key, $value, $expire=null, $path=null){
        if( is_empty($key) || is_empty($value) )
            return false;

        if( is_null($expire) ) $expire = COOKIE_EXPIRATION;
        if( is_null($path) ) $path = COOKIE_PATH;

        $serialized = serialize($value);
        return setcookie($key, $serialized, $expire, $path);
    }


    /**
     * COOKIE DESTROY ELEMENT
     * @param $key int
     * @return boolean
     */
    public static function destroy($key){
        if( !self::get($key) )
            return false;

        //empty value and expiration one hour before
        unset($_COOKIE[$key]);
        setcookie($key, '', time() - 3600, COOKIE_PATH);
        return true;
    }



//END CLASS
}