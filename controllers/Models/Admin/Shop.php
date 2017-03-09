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


use Core\i18n\Language;
use Core\Models\Model;

class Shop extends Model
{



    /**
     * Table int
     * @var Table $table
     */
    protected $table = "shop";

    

    /**
     * UPDATE PRODUCT
     *
     * @param $data
     * @return boolean
     */
    public function update($data)
    {
        $id_shop = get_shop('id');
        $id_lang = read_cookie('shop_lang');
        if( !$id_lang ) $id_lang = get_lang('id');
        //update translation
        if( !empty($data['trans']) ){
            $data['trans']['id_shop'] = $id_shop;
            $data['trans']['id_lang'] = $id_lang;
            $data['trans']['udate'] = date("Y-m-d H:i:s");
            //check if translation exist
            if( $trans = $this->db->prepare("SELECT id FROM {$this->prefix}shop_trans WHERE id_shop=? AND  id_lang=?", [$id_shop, $id_lang], true) ){
                $this->db->update('shop_trans', $trans->id, $data['trans']);
            } else {
                $data['trans']['cdate'] = date("Y-m-d H:i:s");
                $this->db->create('shop_trans', $data['trans']);
            }
        }
        //update shop information
        if( !empty($data['shop']) ){
            return $this->db->update('shop', $id_shop, $data['shop']);
        }
        return true;
    }


//END CLASS
}