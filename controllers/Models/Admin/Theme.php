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

class Theme extends Model
{



    /**
     * Theme array
     * @var Theme $themes
     */
    protected static $themes;


    /**
     * GET THEMES
     *
     * @return $themes
     */
    public static function all() {
        //get config files
        foreach(glob( _BASE_URI_ . 'themes/*/config.xml', GLOB_BRACE) as $path) {
            $xml = simplexml_load_file($path);
            $config = xml2array( $xml );
            $config['active'] = \Core\Theme::getTheme();
            self::$themes[$config['name']] = (object) $config;
        }
        return self::$themes;
    }




//END CLASS
}


