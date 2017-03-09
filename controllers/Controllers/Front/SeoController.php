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


class SeoController extends FrontController
{
    private static $meta_description = "";
    private static $meta_keywords = "";
    private static $meta_title = ""; 
    private static $meta_static = "";

    public static function get_meta($key){
        switch ($key) {
            case 'meta_description':
                return self::$meta_description;
                break;
            case 'meta_keywords':
                return self::$meta_keywords;
                break;
            case 'meta_title':
                try {
                    $SeoController = new SeoController();
                    $shop = $SeoController->getShop();
                    return  $shop->name . " - " .self::$meta_title;
                } catch (Exception $e) {
                    return "";
                }
                break;
            case 'geo_position':
                try {
                    $SeoController = new SeoController();
                    $shop = $SeoController->getShop();
                    return  $shop->latitude . "," .$shop->longitude;
                } catch (Exception $e) {
                    return "";
                }
                break;
            default:
                return null;
                break;
        }
        return null;
    }

    public static function set_meta($key,$value){
        if (trim($value) === "") {
            return;
        }
        $value = trim(preg_replace('/\s\s+/', ' ', $value));
        switch ($key) {
            case 'meta_description':
                self::$meta_description =  $value;
                break;
            case 'meta_keywords':
                self::$meta_keywords =  $value;
                break;
            case 'meta_title':
                self::$meta_title =  $value;
                break;
            case 'meta_static':
                self::$meta_static =  $value;
                break;
            default:
                break;
        }
    }

    public function getShop()
    {
         

        try {

            $shop = $this->db->query("SELECT * FROM {$this->prefix}shop",true);
            if( !empty($shop) ){
                return $shop;
            }

            return false;

        } catch (ControllerException $e) {
          $this->getException($e);
        }
    }

    public static function all_meta(){
        $seo = new SeoController();
        $shop = $seo->getShop();
        if (trim(self::$meta_description) === "") {
            self::$meta_description = $shop->meta_description;
        }
        if (trim(self::$meta_keywords) === "") {
            self::$meta_keywords = $shop->meta_keywords;
        }
        if (trim(self::$meta_title) === "") {
            self::$meta_title = $shop->name;
        }else{
            self::$meta_title = $shop->name . " - " . self::$meta_title;
        }

        self::$meta_static .= $shop->meta_static;

        $return = array(
            "meta_title" => self::$meta_title,
            "meta_description" => self::$meta_description,
            "meta_keywords" => self::$meta_keywords,
            "geo_position" => $shop->latitude . "," . $shop->longitude,
            "meta_static" => self::$meta_static,
        );
 

        return (object)$return;
    }

}