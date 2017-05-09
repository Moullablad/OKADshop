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

if (!defined('_OS_VERSION_'))
  exit;


use Core\Session;
use Core\Module;
use Core\Payment;

define('CHEQUE_PATH', dirname(__FILE__) );
define('CHEQUE_SLUG', 'cheque' );


/**
 * module install
 **/
function cheque_install(){
    save_meta_value('cheque_name', ''); 
    save_meta_value('cheque_address', ''); 
    add_order_state('Awaiting check payment', 'cheque');
}

/**
 * module uninstall
 **/
function cheque_uninstall(){
    remove_meta_value('cheque_name'); 
    remove_meta_value('cheque_address');
}


//register payment method
$params = array(
    "name" => trans("Pay by check", "cheque"),
    "slug" => "cheque",
    "description" => trans("order processing will be longer", "cheque"),
    "function" => "cheque_checkout_page",
);
Payment::setMethod(__FILE__, $params);


//cheque checkout page
function cheque_checkout_page(){
    if( is_empty($_POST['confirm']) ){
        header("Location: ". generate_url( 'cheque-confirm' ) );
    } else {
        add_action('os_before_order_details', 'get_cheque_infos');

        $result = array(
            'status' => 'success',
        );
        return $result;
    }
}


//cheque confirm order
Module::setPage(__FILE__, 'cheque-confirm', 'cheque_confirm');
function cheque_confirm(){
    $cart = Session::get('cart_content');
    $data['cart_total'] = with_currency( $cart->total_tax_incl );
    Module::getView(__FILE__, 'front/check-payment', $data);
}


//cheque configure page
function cheque_configure(){
    //proccess posted code
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
        $res = save_meta_value('cheque_name', $_POST['cheque_name']);
        save_meta_value('cheque_address', $_POST['cheque_address']);
        $data['message'] = "Data was updated successfully.";
    }
    $data['cheque_name'] = get_meta_value('cheque_name');
    $data['cheque_address'] = get_meta_value('cheque_address');

    Module::getView(__FILE__, 'admin/configure', $data);
}
add_admin_page(__FILE__, [
    'name' => 'configure',
    'title' => 'Cheque Configuration',
    'function' => 'cheque_configure'
]);


function get_cheque_infos(){
    $cart = Session::get('cart_content');
    $data['cart_total'] = with_currency( $cart->total_tax_incl );
    $data['cheque_name'] = get_meta_value('cheque_name');
    $data['cheque_address'] = get_meta_value('cheque_address');
    Module::getView(__FILE__, 'front/check-infos', $data);
}