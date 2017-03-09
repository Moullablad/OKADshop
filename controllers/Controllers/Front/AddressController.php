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

class AddressController extends FrontController
{

	/**
     * Table int
     * @var Table $table
     */
    protected $table = "addresses";  



    /**
     *
     * INSERT ADDRESS
     *
     * @return id_address int
     */
    public static function save($data){
        $db = Database::getInstance();
        return $db->create("addresses", $data);
    }



    /**
     *
     * UPDATE ADDRESS
     *
     * @param id_address
     * @return boolean
     */
    public static function update($id_address, $data){
        $db = Database::getInstance();
        return $db->update("addresses", $id_address, $data);
    }



    /**
     *
     * DELETE ADDRESS
     *
     * @param id_address
     * @return boolean
     */
    public static function delete($id_address){
        $db = Database::getInstance();
        return $db->delete("addresses", $id_address);
    }



    /**
     *
     * GET USER ADDRESSES
     *
     * @return shop_data object
     */
    public static function getAddresses($id_user){
        //get shop data from database
        $db = Database::getInstance();
        $addresses = $db->prepare("SELECT a.`id`, a.`name`, a.`addresse`, a.`addresse2`, a.`firstname`, a.`company`, a.`lastname`, a.`city`, a.`codepostal`, a.`phone`, a.`mobile`, a.`ip`, a.`info` , c.`name` as country 
            FROM `{$db->prefix}addresses` a 
            LEFT JOIN `{$db->prefix}countries` c ON a.`id_country` = c.`id`
            WHERE a.`id_user` = ?", [$id_user]);
        if( !is_empty($addresses) ){
            return $addresses;
        }
        return false;
    }


    /**
     *
     * GET ADDRESS BY ID
     *
     * @return shop_data object
     */
    public static function getAddressByID($id_address){
        //get shop data from database
        $db = Database::getInstance();
        $address = $db->prepare("SELECT a.`id`, a.`id_country`, a.`name`, a.`addresse`, a.`addresse2`, a.`firstname`, a.`company`, a.`lastname`, a.`city`, a.`codepostal`, a.`phone`, a.`mobile`, a.`ip`, a.`info` , c.`name` as country 
            FROM `{$db->prefix}addresses` a 
            LEFT JOIN `{$db->prefix}countries` c ON a.`id_country` = c.`id`
            WHERE a.`id` = ?", [$id_address], true);
        if( !is_empty($address) ){
            return $address;
        }
        return false;
    }








//END CLASS
}