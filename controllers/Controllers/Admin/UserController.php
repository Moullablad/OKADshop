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

use Core\Session;
use Core\Cookie;
use Core\Database\Database;

class UserController extends AdminController
{

	/**
     * Table int
     * @var Table $table
     */
    protected $table = "users";  



   


    /**
     * GET ADMIN DATA
     * @return $session_user object
     */
    public static function getData(){
        //check session exist
        $session_user = Session::get('admin');
        if( $session_user && !is_empty($session_user))
            return $session_user;

        return false;
    }




    /**
     * GET ADMIN DATA BY KEY
     * @return data object
     */
    public static function get($key=null){
        if( $user_data = self::getData() ){
            if( !is_null($key) && isset($user_data->$key) ){
                return $user_data->$key;
            } else {
                return $user_data;
            }
        }
        return false;
    }
    

    /**
     * USER AUTHENTICATION
     * @param $username
     * @param $password
     * @return boolean
     */
    public static function login($email, $password)
    {
        $db = Database::getInstance();
        $admin = $db->prepare("SELECT `id`, `first_name`, `last_name`, `email`, `password`, `phone`, `mobile`, `city`, `user_type` FROM `{$db->prefix}users` WHERE `email` = ? AND `user_type` = 'admin' AND `active` = 'actived'", [$email], true);
        if( !is_empty($admin) ){
            if( $admin->password === md5($password) ){
                unset($admin->password);
                if( Session::set('admin', $admin) ){
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * CHECK IF USER LOGGED IN
     * @return boolean
     */
    public static function logout()
    {
        session_destroy();
        header("Location: index.php?module=Login");
    }

    /**
     * CHECK IF USER LOGGED IN
     * @return boolean
     */
    public static function logged(){
        if( ! self::get('id') ){
            header("Location: index.php?module=Login&redirect=". $_SERVER['QUERY_STRING']);
        }
    }


//END CLASS
}