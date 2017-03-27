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

namespace Core\Controllers\Front;

use Core\Session;
use Core\Cookie;
use Core\i18n\Language;
use Core\Database\Database;
use Core\Models\Admin\User;


class UserController extends FrontController
{

    /**
     * Table int
     * @var Table $table
     */
    protected $table = "users";  



    /**
     *
     * GET USER DATA BY ID
     *
     * @param $id_user
     * @return boolean
     */
    public static function getUser($id_user=null)
    {
        if( is_null($id_user) ) 
            $id_user = self::get('id');

        $db = Database::getInstance();
        $user = $db->prepare("SELECT * FROM `{$db->prefix}users` WHERE `id` = ? AND `active` = 'actived'", [$id_user], true);
        if( !is_empty($user) ){
            unset($user->password, $user->active, $user->cby, $user->uby, $user->cdate, $user->udate);
            return $user;
        }
        return false;
    }


    /**
     *
     * GET USER BY EMAIL
     *
     * @param $email
     * @return boolean
     */
    public static function getByEmail($email)
    {
        $db = getDB();
        $user = $db->prepare("SELECT * FROM `{$db->prefix}users` WHERE `email` = ? AND `active` = 'actived'", [$email], true);
        if( !is_empty($user) ){
            unset($user->password, $user->active, $user->cby, $user->uby, $user->cdate, $user->udate);
            return $user;
        }
        return false;
    }


    /**
     *
     * GET USER DATA BY KEY
     *
     * @return data object
     */
    public static function getData(){
        return Session::get('user');
    }



    /**
     *
     * GET USER DATA BY KEY
     *
     * @return data object
     */
    public static function get($key=null){
        $user = (array) self::getData();
        if( !is_null($key) && isset($user[$key]) ){
            return $user[$key];
        } else {
            return $user;
        }
        return false;
    }


    /**
     *
     * CREATE NEW USER
     *
     * @return data object
     */
    public function addUser($data){
        $user = $this->db->create($this->table, $data);
        return $user;
    }

    

    /**
     *
     * USER AUTHENTICATION
     *
     * @param $username
     * @param $password
     * @return boolean
     */
    public static function login($email, $password)
    {
        $db = Database::getInstance();
        $user = $db->prepare("SELECT * FROM `{$db->prefix}users` WHERE `email` = ? AND `active` = 'actived'", [$email], true);
        if( !is_empty($user) ){
            if( $user->password === md5($password) ){
                unset($user->password, $user->active, $user->cby, $user->uby, $user->cdate, $user->udate);
                if( Session::set('user', $user) ){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     *
     * LOGOUT
     *
     * @return boolean
     */
    public static function logout()
    {
        header("Location: ". generate_url('account/login')); 
    }


    /**
     *
     * CHECK IF USER LOGGED IN
     *
     * @return boolean
     */
    public static function logged(){
        return read_session('user');
    }


    /**
     *
     * USER REGISTER
     *
     * @param $data
     * @return boolean
     */
    public static function register($data)
    {       $db = getDB();
        $user = new User();
        $data['clt_number'] = $user->getNumber();
        $data['user_type'] = 'user';
        $data['active'] = 'actived';
        $data['id_lang'] = Language::getLanguage()->id;

        $id_user = $db->create("users", $data);
        if( $id_user ){
            $data['id'] = $id_user;
            unset($data['password']);
            unset($data['active']);
            if( Session::set('user', (object)$data) ){
                return true;
            }
        }
        return false;
    }


    /**
     *
     * Reset user password
     *
     * @return boolean
     */
    public static function resetPassword($email){
        $db = Database::getInstance();
        $password = rand_password();
        $md5_password = md5($password);
        $reset_pass = $db->prepare("UPDATE {$db->prefix}users SET password=? WHERE email=?", [$md5_password, $email]);
        if( $reset_pass ){
            $user = self::getByEmail($email);
            if( $user ){
                $headers = 'MIME-Version: 1.0'."\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                $headers .= "From: ". get_shop('email'); 
                $shop_name = get_shop('name');
                $to = $user->email; //change to ur mail address
                $subject = $shop_name . " - " . trans('Reset Password', 'admin');
                $message = "<b>". trans('Hi', 'admin') .", </b>" . $user->last_name;
                $message .= "<br>". trans('Your new password is:', 'admin') .' '. $password;
                if( !is_localhost() ){
                    return mail($to, $subject, $message, $headers);
                }
                return false;
            }
        }
        return false;
    }
    

    /**
     *
     * Update user informations
     *
     * @param $data
     * @param $id_user
     * @return boolean
     */
    public static function update($data, $id_user)
    {
        $db = getDB();
        $update = $db->update("users", $id_user, $data);
        if( $update ){
            return true;
        }
        return false;
    }
    

    /**
     *
     * CHECK IF USER EXIST
     *
     * @param $email
     * @return boolean
     */
    public static function userExist($email)
    {
        $db = Database::getInstance();
        $result = $db->prepare("SELECT count(*) as nbr FROM {$db->prefix}users WHERE email=?", [$email], true);
        if( $result->nbr == "0" ){
            return false;    
        }
        return true;
    }


    /**
     *
     * CHECK IF USER LOGGED IN
     *
     * @return boolean
     */
    public static function getUserZone(){
        $id_user = self::get('id');
        $db = Database::getInstance();
        $result = $db->prepare("SELECT c.id_zone FROM {$db->prefix}countries c LEFT JOIN {$db->prefix}users u ON u.id_country = c.id WHERE u.id = ?", [$id_user], true);

        return $result->id_zone;
    }




//END CLASS
}