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
namespace Core\Models\Admin;

use Core\Models\Model;

class Module extends Model
{



    /**
     * Module array
     * @var Module $modules
     */
    protected static $modules;


    /**
     * Get modules configuration
     *
     * @return $modules
     */
    public static function getConfig() {
        /*$configFile = site_base('modules/config.txt');
        if( file_exists($configFile) ){
            $content = file_get_contents($configFile);
            $content = unserialize($content);
            if( $content !== false )
                return $content;
        }*/
        //get core config files
        foreach(glob( admin_base('modules/*/config.xml'), GLOB_BRACE) as $path) {
            $config = self::xml2Array( $path );
            $module_name = 'core-'. $config['name'];
            self::$modules[$module_name] = $config;
        }
        //get core config files
        foreach(glob( site_base('modules/*/config.xml'), GLOB_BRACE) as $path) {
            $config = self::xml2Array( $path );
            $module_name = $config['name'];
            self::$modules[$module_name] = $config;
        }
        // $data = serialize(self::$modules);
        // file_put_contents($configFile, $data);
        return self::$modules;
    }

    /**
     * Get active Modules
     *
     * @return void
     */
    public static function getActive(){
        $db = getDB();
        $active = array();
        $result = $db->prepare("SELECT `name` FROM `{$db->prefix}modules` WHERE `active`=1 ORDER BY `position` ASC", [], false, 'assoc');
        foreach ($result as $key => $value) {
            $active[] = $value['name'];
        }
        return $active;
    }

    

    /**
     * XML to Array
     *
     * @return $array
     */
    public static function xml2Array($path) {
        $xml = simplexml_load_file($path);
        return xml2array( $xml );
    }
    



//END CLASS
}


