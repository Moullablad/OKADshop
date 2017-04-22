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

namespace Core\i18n;

use Core\Database\Database;
use Core\Cookie;
use Core\Session;

class Language
{


    /**
     *=============================================================
     * GET LANGUAGE BY FIELD
     *=============================================================
     * @return id int
     **/
    public static function getByField($field, $value){
        $language = getDB()->findByColumn('languages', $field, $value, ['id'], true);
        return $language->id;
    }




    /**
     *=============================================================
     * GET LANGUAGE FROM SESSION
     *=============================================================
     * @return id_lang int
     **/
    public static function getLanguage($key=null){
        //check session exist
        if( $session = read_session('language') ){
            $language = $session;
        } else {
            $language = self::setLanguage();
        }
        //return language
        if( !is_empty($language) ){
            if( !is_null($key) ){
                return $language->$key;
            } else {
                return $language;
            }
        }      
        return false;
    }



    /**
     *=============================================================
     * SET NEW LANGUAGE
     *=============================================================
     * @return id_lang int
     **/
    public static function setLanguage($id_lang=null){
        $db = getDB();
        erase_session('language');
        erase_session('shop');
        if( is_null($id_lang) ){
            //get user navigator language
            $iso_code = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if( $iso_code != '' ){
                $language = findByColumn('languages', 'iso_code', $iso_code, array('*'), true);
                if( !$language ){
                    $language = findByColumn('languages', 'default_lang', 1, array('*'), true);
                }
            }
        } else {
            $language = $db->find('languages', $id_lang);
        }
        //set random language
        if( !$language ) $language = $db->select('languages', ['*'], true);
        unset($language->active, $language->default_lang, $language->cby, $language->uby, $language->cdate, $language->udate);
        $language->direction = ($language->direction=='0') ? 'ltr' : 'rtl';
        create_session('language', $language);
        return $language;
    }


    /**
     *=============================================================
     * GET LANGUAGES LIST
     *=============================================================
     * @return langueges object
     **/
    public static function getLanguages(){
        return getDB()->findByColumn('languages', 'active', 1);
    }


    /**
     *=============================================================
     * GET DEFAULT ADMIN LANGUAGE
     *=============================================================
     * @return data object
     **/
    public static function getDefaultLanguage(){
        $default = getDB()->findByColumn('languages', 'default_lang', 1, ['id'], true);
        return $default->id;
    }



    /**
     *=============================================================
     * GET DATATABLE LANGUAGE
     *=============================================================
     * @return lang name int
     **/
    public static function getDatatableLanguage(){
        return false;
    }



//END CLASS
}