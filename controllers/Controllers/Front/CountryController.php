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

use Core\Database\Database;

class CountryController extends FrontController
{

	/**
     * Table int
     * @var Table $table
     */
    protected $table = "countries";  


    /**
     *=============================================================
     * GET COUNTRIES LIST
     *=============================================================
     * @return countries object
     */
    public static function getCountries(){
        $db = Database::getInstance();
        return $db->prepare("SELECT * FROM `{$db->prefix}countries` WHERE `active`=1 ORDER BY `name` ASC");
    }


    /**
     *=============================================================
     * GET COUNTRY BY ID
     *=============================================================
     * @return country object
     */
    public static function getCountryByID($id_country){
        $db = Database::getInstance();
        return $db->find('countries', $id_country, true);
    }








//END CLASS
}