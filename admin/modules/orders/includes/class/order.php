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

use Core\Theme;
use Core\Payment;
use Core\Controllers\Front\CartController;
use Core\Controllers\Front\CarrierController;
use Core\Controllers\Front\OrderController;

class Order {
	

	/**
     * Order summary
     *
     * @return void
     */
	public function summary() {
		$data = array();
		$data['page'] = 'summary';
		$data['currency'] = get_currency();
		$controller = new CartController();
		$data['cart'] = $controller->getCartItems();
		create_session('order_step', 'summary');
		Theme::getTemplate('order-summary', $data);
	}

	/**
     * Order summary
     *
     * @return void
     */
	public function address() {
		//check if user logged in
		if( !logged() ){ 
			create_session('order_step', 'address');
			header("Location: ". get_url('account/login') );
		}
		$order_step = read_session('order_step');
		if( $order_step != "summary" && $order_step != "address" || !read_session('cart') ){
			header("Location: ". get_url('order/summary') );
		}
		create_session('order_step', 'address');
		$data = array();
		$data['page'] = 'address';
		$id_user = get_user('id');
		//get user addresses
		$addresses = get_addresses($id_user);
		if( false == $addresses ){
			header("Location: ". get_url('account/address') );
		}
		//get delivery address
		$id_delivery = read_session('addr_delivery');
		if( $delivery_address = get_address($id_delivery) ){
			$id_billing = read_session('addr_billing');
			$billing_address = $delivery_address;
			if( $baddress = get_address($id_billing) ){
				$billing_address = $baddress;
			}
			$data['delivery'] = $delivery_address;
			$data['billing']  = $billing_address;
		} else {
			$data['delivery'] = $addresses[0];
			$data['billing']  = $addresses[0];
			create_session('addr_delivery', $addresses[0]->id);
			create_session('addr_billing', $addresses[0]->id);
		}
		$data['same_address'] = read_session('use_same_address');
		$data['addresses'] = $addresses;
		Theme::getTemplate('order-address', $data);
	}


	/**
     * Order shipping
     *
     * @return void
     */
	public function shipping() {
		//check if user logged in
		if( !logged() ){ 
			header("Location: ". get_url('account/login') );
		}
		$order_step = read_session('order_step');
		if( $order_step != "address" || !read_session('cart') ){
			header("Location: ". get_url('order/summary') );
		}
		create_session('order_step', 'shipping');
		$data = array();
		$data['page'] = 'shipping';
		//get available carriers
		$id_delivery = read_session('addr_delivery');
		$carrier = new CarrierController();
		$data['carriers'] = $carrier->getUserCarriers($id_delivery);
		$data['currency'] = get_currency();
		//next step
		$cart = read_session('cart_content');
		$cart_total = $cart->total_tax_incl;
		$action = (floatval($cart_total) > 0) ? 'order/payment' : 'order/details';
		$data['form_action'] = get_url( $action );
		Theme::getTemplate('order-shipping', $data);
	}
	
	/**
     * Order payment
     *
     * @return void
     */
	public function payment() {
		//check if user logged in
		if( !logged() ){ 
			header("Location: ". get_url('account/login') );
		}
		//get carrier ID
		$id_carrier = 0;
		$order_step = read_session('order_step');
		if( isset($_POST['id_carrier']) ){
			$id_carrier = intval($_POST['id_carrier']);
		} else if( $session = read_session('id_carrier') ){
			$id_carrier = intval($session);
		}
		//chack for errors
		if( 
			!read_session('cart') 
			|| $id_carrier < 1
			|| $order_step != "shipping" 
			&& $order_step != "payment"
		){
			header("Location: ". get_url('order/summary') );
		}
		$data['page'] = 'payment';

		//confirm page
		if( isset($_GET['ID2']) && $_GET['ID2'] != '' ){
			//check if function exist
			$method = Payment::getMethod($_GET['ID2']);
			if( !$method ){
				Theme::getTemplate('front/order/invalid-gatway');
			}
			create_session('payment_method', $method->slug);
			$module_funtion = $method->function;
			if( function_exists( $module_funtion ) ){
				//execute module function
				$result = $module_funtion();
				if( is_array($result) ){
					$result = (object) $result;
					if( $result->status === 'success' ){
						header("Location: ". generate_url( 'order/details' ) );
					} elseif( $result->status === 'error' ){
						$data['message'] = ($result->message) ? $result->message : trans("Your order is not complete.", "orders");
						Theme::getTemplate('front/order/fail', $data);
					} else {
						Theme::getTemplate('front/order/invalid-gatway');
					}
				}
			}
		} else {
			$controller = new CartController();
			$data['cart'] = $controller->getCartItems();
			$data['methodes'] = Payment::getPaymentMethodes();
			create_session('id_carrier', $id_carrier);
			create_session('order_step', 'payment');
			Theme::getTemplate('order-payment', $data);
		}
	}
	

	/**
     * Order details
     *
     * @return void
     */
	public function details() {
		//check if user logged in
		if( !logged() ){ 
			header("Location: ". get_url('account/login') );
		}
		//get carrier ID
		if( isset($_POST['id_carrier']) && read_session('cart')){
			$id_carrier = intval($_POST['id_carrier']);
			create_session('id_carrier', $id_carrier);
		} elseif( !read_session('cart') || !read_session('id_carrier') ){
			header("Location: ". get_url('order/summary') );
		}
		//save order
		do_action('os_before_order_save');
		$order_data = OrderController::save();
		if( !$order_data ){
			$data['message'] = trans("Error saving order data.", "orders");
			Theme::getTemplate('front/order/fail', $data);
		}
		$data['order'] = $order_data;
		$data['message'] = trans("Your order is complete.", "orders");
		do_action('os_after_order_save');
		Theme::getTemplate('front/order/details', $data);
	}


//END CLASS
}