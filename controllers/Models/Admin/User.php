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

class User extends Model
{

    /**
     * Get customer number
     *
     * @return $number
     */
    public function getNumber(){
        $last_id = $this->db->select('users', array('id'), true);
        $user_id = intval($last_id->id) + 1;
        $number  = 'CL'.sprintf("%06d", $user_id);
        return $number;
    }



}