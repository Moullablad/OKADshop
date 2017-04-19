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
use Core\Cookie;
use Core\Controllers\Front\ProductController;
use Core\Controllers\Front\CarrierController;
use Core\Controllers\Front\UserController;
use Core\Database\Database;

class CartController extends FrontController
{


    /**
     *=============================================================
     * GET BLOCK CART
     *=============================================================
     * @return string $cart_html
     */
    public function getBlockCart(){ 
        $data = array();       
        $data['currency'] = $GLOBALS['os']->currency->sign;
        $data['cart'] = $this->getCartItems();
        get_template_view('block-cart', $data);
    }




	/**
     *=============================================================
     * ADD TO CART
     *=============================================================
     * @param object $args
     * @return boolean
     */
	public function addToCart($args){
        Session::destroy('cart_content');
        $cart = Session::get('cart');
        if( !$cart ) $cart = new \stdClass;

        $id_product = $args->id_product;
        $id_declinaison = $args->id_declinaison;
        $quantity = intval($args->qty);

        //update item quantity
        if( $id_declinaison > 0 ){
            if( !isset($cart->items[$id_product][$id_declinaison]) ) {
                $cart->items[$id_product][$id_declinaison] = 0;
            }
            $cart->items[$id_product][$id_declinaison] += $quantity;
        } else {
            if( !isset($cart->items[$id_product]['qty']) ) {
                $cart->items[$id_product]['qty'] = 0;
            }
            $cart->items[$id_product]['qty'] += $quantity;
        }

        return Session::set('cart', $cart);
	}


    /**
     *=============================================================
     * ADD TO CART
     *=============================================================
     * @param object $args
     * @return boolean
     */
    public function removeFromCart($id_product, $id_declinaison){
        Session::destroy('cart_content');

        $cart = Session::get('cart');

        if( $id_declinaison > 0 ){
            unset($cart->items[$id_product][$id_declinaison]);
        } else {
            unset($cart->items[$id_product]);
        }

        if( is_empty($cart->items) ){
            return Session::destroy('cart');
        } else {
            return Session::set('cart', $cart);
        }
    }


    /**
     *=============================================================
     * GET CART CONTENT
     *=============================================================
     * @return array content
     */
    public static function cartContent(){
        return Session::get('cart_content');
    }


    /**
     *=============================================================
     * GET BLOCK CART ITEMS
     *=============================================================
     * @param object $args
     * @return html string
     */
    public function getCartItems(){
        //get cart results
        $cart_content = self::cartContent();
        if( $cart_content ) return $cart_content;

        //prepare vars
        $product = new ProductController();
        $results = $ids_products = array();
        $items_count = $total_products = $total_discount = $total_tax = 0;

        $cart = Session::get('cart');
        // var_dump($cart->items);exit;

        if( isset($cart->items) ){
            foreach ($cart->items as $id_product => $item) {
                //push id_product to ids_products array
                array_push($ids_products, $id_product);

                $product_data = new \stdClass;
                if( isset($item['qty']) ){
                    //get translated product data
                    $data = $product->getProduct($id_product);

                    //prepare data
                    $product_data->id_product = $data->id;
                    $product_data->id_dec = 0;
                    $product_data->name = $data->name;
                    $product_data->price = $data->sell_price;

                    $items_count += (int) $item['qty'];
                    $total_products += (int) $item['qty'] * $product_data->price;
                    $total_discount += (int) $item['qty'] * $data->discount;

                    $product_data->stock = $data->quantity;
                    $product_data->qty = (int) $item['qty'];
                    $product_data->min_quantity = (int) $data->min_quantity;
                    $product_data->cover = $data->cover;
                    $product_data->attrs = [];
                    $product_data->link = $data->link;

                    $results['items'][] = $product_data;

                } elseif( !empty($item) ) {
                    foreach ($item as $id_combination => $qty) {
                        $data = $product->getCombinationByID($id_product, $id_combination);
                        
                        $items_count += (int) $qty;
                        $total_products += (int) $qty * $data->price;
                        $total_discount += (int) $qty * $data->discount;

                        $data->qty = (int) $qty;

                        $results['items'][] = $data;
                    }
                }        
            }
        }


        $total_shipping = CarrierController::getShippingPrice();
        $results['count'] = $items_count;
        $results['id_carrier'] = CarrierController::getDefault();
        $results['id_cart_rule'] = 0;
        $results['currency'] = $GLOBALS['os']->currency->sign;
        $results['total_products'] = format_price($total_products);
        $results['total_voucher'] = 0;
        $results['total_discount'] = format_price($total_discount);
        $results['total_shipping'] = format_price($total_shipping);
        $results['total_tax'] = $total_tax;
        $total_tax_excl = ($total_products + $total_discount) + $total_shipping;
        $results['total_tax_excl'] = $total_tax_excl;
        $results['total_tax_incl'] = format_price( $total_tax_excl + $total_tax );
        $results = (object) $results;

        if( isset($cart->id_cart_rule) ){
            $voucher = $this->getVoucher( $cart->id_cart_rule, $ids_products, $results );
            if( $voucher->free_shipping == "1" ) $results->total_shipping = 0;
            $results->total_voucher   = format_price( $voucher->total_voucher );
            $results->total_tax_excl -= format_price( $voucher->total_voucher );
            $results->total_tax_incl -= format_price( $voucher->total_voucher );
            $results->voucher_data = $voucher;
        }

        //save cart results
        if( isset($cart->items) )
            Session::set('cart_content', $results);

        return $results;
    }



    /**
     *=============================================================
     * GET CURRENCY
     *=============================================================
     * @return string $currency
     */
    public static function getCurrency(){
        //session get instance
        $currency = Session::get('currency');
        if( !is_empty($currency) )
            return $currency;

        //get default currency from db
        $columns = array('id', 'name', 'iso_code', 'iso_code_num', 'sign');
        $db = Database::getInstance();
        $default_currency = $db->select('currencies', $columns, true);
        if( !is_empty($default_currency) ){
            return Session::set('currency', $default_currency);
        }

        return false;
    }


    /**
     *==============================================
     * SET VOUCHER CODE
     *==============================================
     * @param $file_name (string)
     * @throws Exception
     */
    public function checkVoucherCode( $code )
    {
        if( empty($code) ) return false;

        $cart = $this->getCartItems();

        //prepare data
        $id_carrier = $cart->id_carrier;
        $id_user = get_user('id');
        $id_user = ( $id_user ) ? $id_user : 0;
        $id_group = ( $id_user ) ? $GLOBALS['os']->user->id_group : 0;
        $total_amount = format_price($cart->total_tax_incl);

        //check if cart rule exist
        $cart_rule = $this->db->prepare("SELECT * FROM {$this->prefix}cart_rule WHERE code = ? AND active=1", [$code], true);
        if( is_empty($cart_rule) ) return false;

        if( format_price($cart_rule->minimum_amount) > $total_amount ) return false;

        //check if cart rule valid
        $date_from = strtotime($cart_rule->date_from);
        $date_to   = strtotime($cart_rule->date_to);
        $current   = time();
        if( $date_from > $current || $date_to < $current ) return false;

        //check if customer allowed to use this cart rule
        if( $cart_rule->id_customer != 0 && $cart_rule->id_customer != $id_user ) return false;

        //check customer group
        $group_ids = array();
        if( $cart_rule->group_restriction != '' ) $group_ids = explode(',', $cart_rule->group_restriction);
        if( !empty($group_ids) && !in_array( $id_group, $group_ids ) ) return false;

        //check if selected carrier in list
        $carrier_ids = array();
        if( $cart_rule->carrier_restriction != '' ) $carrier_ids = explode(',', $cart_rule->carrier_restriction);
        if( !empty($carrier_ids) && !in_array( $id_carrier, $carrier_ids ) ) return false;

        return $cart_rule->id;
    }


    /**
     *==============================================
     * SET VOUCHER CODE
     *==============================================
     * @param $file_name (string)
     * @throws Exception
     */
    public function getVoucher( $id_cart_rule, $ids_products=[], $cart )
    {
        if( !is_numeric($id_cart_rule) ) return false;

        $cart_rule = $this->db->prepare("SELECT * FROM {$this->prefix}cart_rule WHERE id = ? AND active=1", [$id_cart_rule], true);
        if( is_empty($cart_rule) ) return false;

        $voucher = array(
            'id' => $cart_rule->id, 
            'name' => $cart_rule->name, 
            'code' => $cart_rule->code, 
            'free_shipping' => $cart_rule->free_shipping,
            'gift_product' => $cart_rule->gift_product,
            'gift_product_attribute' => $cart_rule->gift_product_attribute,
            'total_voucher' => 0,
        );

        $cart_total = $cart->total_tax_incl;
        $cart_items = $cart->items;
        $rule_reduction = $cart_rule->reduction;
        $discount_type = $cart_rule->apply_discount;


        //return reduction as it
        if( $cart_rule->reduction_type == "order" ){
            $voucher['total_voucher'] = $rule_reduction;
        }elseif( $cart_rule->reduction_type == "specific" ){//apply reduction to specific product
            $id_product = $cart_rule->reduction_product;
            if( in_array($id_product, $ids_products) ){
                $key = searching_multidimensional($cart_items, 'id_product', $id_product);
                $product_price = $cart_items[$key]->price;
                $reduction = percent_to_amount($product_price, $rule_reduction, $discount_type);
                $voucher['total_voucher'] = $reduction;
            }
        }elseif( $cart_rule->reduction_type == "selection" ){//apply reduction to each selected product
            $selection = explode(",", $cart_rule->product_restriction);
            $reduction = 0;
            foreach ($ids_products as $key => $id_product) {
                if( in_array($id_product, $ids_products) ){
                    $key = searching_multidimensional($cart_items, 'id_product', $id_product);
                    $product_price = $cart_items[$key]->price;
                    $reduction += percent_to_amount($product_price, $rule_reduction, $discount_type);
                }
                $voucher['total_voucher'] = $reduction;
            }
        }

        return (object) $voucher;
    }


    

//END CLASS
}