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
use Core\Database\Database;
use Core\Controllers\Front\UserController;

class CarrierController extends FrontController
{

	/**
     * Table int
     * @var Table $table
     */
    protected $table = "carrier";


	/**
     *=============================================================
     * GET CARRIER NAME
     *=============================================================
     * @param int $id
     * @return name string
     */
	public function getName($id){
		return $this->db->find($this->table, $id, array('name'));
	}


    /**
     *=============================================================
     * GET CARRIERS BY ZONE
     *=============================================================
     * @return object $carriers
     */
    public function getUserCarriers($id_delivery_adr){
        //get id_zone
        $result = $this->db->prepare("SELECT id_zone FROM {$this->prefix}countries c LEFT JOIN {$this->prefix}addresses a ON a.id_country = c.id WHERE a.id = ?", [$id_delivery_adr], true);

        if( !is_empty($result) ){
            //get carriers
            return $this->db->prepare("SELECT c.*, cz.fees FROM {$this->prefix}carrier c LEFT JOIN {$this->prefix}carrier_zones cz ON cz.id_carrier = c.id WHERE cz.id_zone = ? AND cz.active=1", [$result->id_zone]);
        }

        return false;

    }


    /**
     *=============================================================
     * GET SHIPPING PRICE
     *=============================================================
     * @return float $shippingprice
     */
    public static function getShippingPrice(){  
        $db = Database::getInstance();
        $carrier = $db->query("SELECT cz.fees FROM {$db->prefix}carrier c LEFT JOIN {$db->prefix}carrier_zones cz ON cz.id_carrier = c.id WHERE c.is_default = 1", true);
        if( isset($carrier->fees) )
            return $carrier->fees;
        return 0;
    }


    /**
     *=============================================================
     * GET DEFAULT CARRIER
     *=============================================================
     * @return int $id_carrier
     */
    public static function getDefault(){  
        //check session exist
        $id_carrier = Session::get('id_carrier');
        if( !is_empty($id_carrier) )
            return $id_carrier;

        $db = Database::getInstance();
        $carrier = $db->query("SELECT id FROM {$db->prefix}carrier WHERE is_default = 1", true);
        if( !is_empty($carrier) ){
            Session::set('id_carrier', $carrier->id);
            return $carrier->id;
        } else {
            $random = $db->query("SELECT id FROM {$db->prefix}carrier", true);
            if( !is_empty($random) ){
                Session::set('id_carrier', $random->id);
                return $random->id;
            }
        }
        return false;
    }





//END CLASS
}