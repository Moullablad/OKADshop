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
error_reporting(0);
use Core\Database\Database;
use Core\i18n\Reader;
use Core\i18n\Language;
use Core\Models\Admin\Module;
use Core\Theme;
use Core\Session;


class Translate
{


    /**
     * Trans array
     * @var Trans $domains
     */
    public static $domains = array();


    /**
     * Files array
     * @var Files $files
     */
    protected static $files = array();

    /**
     * Translations array
     * @var Translations $trans
     */
    protected static $trans = array();


    /**
     * INITIALIZE TRANSLATIONS
     **/
    public static function init(){
        $language = language::getLanguage();
        $iso_code = $language->iso_code;
        if( isset($_GET['lang']) && $iso_code != $_GET['lang'] ){
            $id_lang = language::getByField('iso_code', $_GET['lang']);
            language::setlanguage($id_lang);
            $iso_code = $_GET['lang'];
            //reset cart content
            Session::destroy('cart_content');
        }
        return self::loadFiles($iso_code);
    }


    /**
     * Get trans
     *
     * @return $trans
     */
    public static function getTrans(){
        return self::$trans;
    }



    /**
     * Add trans domain
     *
     * @param string $file
     * @param string $name
     * @return void
     */
    public static function addDomain($file, $name){
        if( $modname = get_module_dirname($file) ){
            self::$domains[$name] = $modname;
        }
    }


    /**
     * PARSER TRANSLATIONS
     **/
    public static function parser($file){
        $parser = new Reader();
        $data = $parser->load($file);
        unset($data['']);
        return $data;//array_slice($data, 1, -1);
    }



    /**
     * LOAD FILES
     * @param string $iso_code
     * @return array $trans
     **/
    public static function loadFiles($iso_code){
        //check if language cached
        $cache = self::getCache($iso_code);
        if( !is_empty($cache) ) return $cache;
        
        //get translations strings
        self::modulesTrans($iso_code);
        self::themeTrans($iso_code);
        self::adminTrans($iso_code);

        //cache files
        return self::cacheLanguage(self::$trans, $iso_code);
    }


    /**
     * GET MODULE STRINGS
     * @param string $iso_code
     * @return array $paths
     */
    public static function modulesTrans($iso_code){
        $modules = get_active_modules();
        foreach ($modules as $name => $module) {
            $filePath = $module['path'] . 'languages/'. $iso_code .'.mo';
            if( file_exists($filePath) ){
                self::$trans[$name] = self::parser($filePath);
            }
        }
    }


    /**
     * GET THEME STRINGS
     * @param string $iso_code
     * @return array $path
     */
    public static function themeTrans($iso_code){
        $theme_slug = Theme::getTheme();
        $file_path = site_base('themes/'. $theme_slug .'/languages/'. $iso_code .'.mo');
        if( file_exists($file_path) ){
            self::$trans[$theme_slug] = self::parser($file_path);
        }
    }


    /**
     * GET ADMIN STRINGS
     * @param string $iso_code
     * @return array $path
     */
    public static function adminTrans($iso_code){
        $file_path = site_base('languages/'. $iso_code .'.mo');
        if( file_exists($file_path) ){
            self::$trans['core'] = self::parser($file_path);
        }
    }

    /**
     * CACHE LANGUAGE
     * @param array $array
     * @param array $file_path
     * @return boolean
     */
    public static function cacheLanguage($trans, $iso_code){
        $langDir = site_base('cache/languages/');
        if (!file_exists($langDir)) mkdir($langDir, 0777, true);
        $file_path = $langDir . $iso_code .'.php';
        $data = serialize($trans);
        if( file_put_contents($file_path, $data) ){
            return $trans;
        }
        return false;
    }


    /**
     * GET LANGUAGE CACHE
     * @param int $iso_code
     * @return data array
     */
    public static function getCache($iso_code){
        $cache_lang = site_base('cache/languages/'. $iso_code .'.php');
        if( file_exists($cache_lang) ){
            return unserialize( file_get_contents($cache_lang) );
        }
        return false;
    }





//END CLASS
}