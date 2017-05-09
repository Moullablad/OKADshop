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
use Core\Payment;
use Core\Image;
use Core\Database\Database;

class OrderController extends FrontController
{


	/**
     *
     * SAVE ORDER
     *
     * @param int $id
     * @return name string
     */
	public static function save(){
        $cart = CartController::cartContent();
        if( is_empty($cart->items) )
            return false;

        //get order state
        $db = Database::getInstance();

        if( $slug = read_session('payment_method') ){
            $method = Payment::getMethod($slug);
            $state = self::getOrderState($method->slug);
            $id_state = ($state->id) ? $state->id : 0;
            $payment_method = $method->name;
        } else {
            $id_state = 0;
            $payment_method = 'Free';
        }
        //prepare order
        $order_data = array(
            'id_customer' => Session::get('user')->id,
            'id_state' => $id_state, 
            'id_carrier' => $cart->id_carrier, 
            'payment_method' => $payment_method, 
            'reference' => generate_reference('orders'), 
            // 'address_invoice' => , 
            // 'address_delivery' => , 
            'currency_sign' => $cart->currency, 
            'global_discount' => $cart->total_discount, 
        );
        if( isset($cart->voucher_data) ){
            $order_data['voucher_code'] = $cart->voucher_data->code;
            $order_data['voucher_value'] = $cart->voucher_data->total_voucher;
        }
        $id_order = $db->create('orders', $order_data);
        if( !$id_order ) return false;

        //order carrier
        $carrier_data = array(
            'id_order' => $id_order, 
            'id_carrier' => $cart->id_carrier, 
            'shipping_costs' => $cart->total_shipping,
        );
        $id_carrier = $db->create('order_carrier', $carrier_data);
        if( !$id_carrier ) return false;

        //order detail
        $order_detail = array();
        $item_success = true;
        foreach ($cart->items as $key => $item) {
            $item_data = array(
                'id_order' => $id_order, 
                'id_product' => $item->id_product, 
                'id_declinaisons' => $item->id_dec, 
                //'attributs' => , 
                'product_name' => $item->name, 
                //'product_reference' => , 
                'product_image' => Image::getFileName($item->cover),
                'product_price' => $item->price, 
                'product_quantity' => $item->qty, 
                //'product_discount' => , 
                //'discount_type'
            );
            $item_save = $db->create('order_detail', $item_data);
            if( !$item_save ){
                $item_success = false;
            }
        }
        if( !$item_success ) return false;

        //return order data
        $order = new \stdClass;
        $order->id = $id_order;
        $order->method = $payment_method;
        $order->status = $state->name;
        $order->date = date('l d, Y');
        $order->products = $cart->items;
        $order->product_count = $cart->count;
        $order->currency = $cart->currency;
        $order->id_carrier = $cart->id_carrier;
        $order->id_cart_rule = $cart->id_cart_rule;
        //totals
        $order->subtotal = $cart->total_products;
        $order->shipping = $cart->total_shipping;
        $order->total_tax = $cart->total_tax;
        $order->total_tax_excl = $cart->total_tax_excl;
        $order->total_tax_incl = $cart->total_tax_incl;

        return $order;
	}



    /**
     *
     * ADD ORDER STATE
     *
     * @param slring $name
     * @param slring $template
     * @return boolean
     */
    public static function addOrderState($name, $template){
        $db = Database::getInstance();
        $result = $db->prepare("SELECT count(*) as nbr FROM {$db->prefix}order_states WHERE template=?", [$template], true);
        if( $result->nbr != "0" ){
            return $db->create('order_states', array('name' => $name, 'template' => $template) );           
        }
        return false;
    }


    /**
     *
     * GET ORDER STATE
     *
     * @param slring $template
     * @return false || name
     */
    public static function getOrderState($template){
        $db = Database::getInstance();
        $result = $db->prepare("SELECT * FROM {$db->prefix}order_states WHERE template=?", [$template], true);
        return $result;
    }



    /**
     *
     * DELETE ORDER STATE
     *
     * @param int $id
     * @return name string
     */
    public static function deleteOrderState($template){
        $db = Database::getInstance();
        return $db->prepare("DELETE FROM {$db->prefix}order_states WHERE template=?", [$template], true);
    }


    /**
     *
     * GET USER ORDERS
     *
     * @param int $id_user
     * @return orders object
     */
    public static function getOrders($id_user){
        $db = Database::getInstance();
        return $db->prepare("SELECT * FROM {$db->prefix}orders WHERE id_customer=?", [$id_user]);
    }



//END CLASS
}