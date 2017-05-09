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


/**
 * Register translation domain
 */
add_domain(__FILE__, 'bw');


/**
 * module install
 **/
function bankwire_install(){
    save_meta_value('bank_wire_owner', ''); 
    save_meta_value('bank_wire_details', ''); 
    save_meta_value('bank_wire_address', ''); 
    add_order_state('Awaiting bank wire payment', 'bankwire');
}

/**
 * module uninstall
 **/
function bankwire_uninstall(){
    remove_meta_value('bank_wire_owner'); 
    remove_meta_value('bank_wire_details'); 
    remove_meta_value('bank_wire_address'); 
}


//register payment method
$params = array(
    "name" => trans("Pay by bank wire", "bw"),
    "slug" => "bankwire",
    "description" => trans("Order processing will be longer", "bw"),
    "function" => "bankwire_checkout_page",
);
Payment::setMethod(__FILE__, $params);


//bankwire checkout page
function bankwire_checkout_page(){
    if( is_empty($_POST['confirm']) ){
        header("Location: ". generate_url( 'bankwire-confirm' ) );
    } else {
        add_action('os_before_order_details', 'get_bankwire_infos');

        $result = array(
            'status' => 'success',
        );
        return $result;
    }
}

//bankwire confirm order
Module::setPage(__FILE__, 'bankwire-confirm', 'bankwire_confirm');
function bankwire_confirm(){
    $cart = Session::get('cart_content');
    $data['cart_total'] = with_currency( $cart->total_tax_incl );
    Module::getView(__FILE__, 'front/payment', $data);
}

//bankwire configure page
function bankwire_configure(){
    //proccess posted code
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
        save_meta_value('bank_wire_owner', $_POST['owner']);
        save_meta_value('bank_wire_details', $_POST['details']);
        save_meta_value('bank_wire_address', $_POST['address']);
        $data['message'] = "Data was updated successfully.";
    }
    $data['owner']   = get_meta_value('bank_wire_owner');
    $data['details'] = get_meta_value('bank_wire_details');
    $data['address'] = get_meta_value('bank_wire_address');

    Module::getView(__FILE__, 'admin/configure', $data);
}
add_admin_page(__FILE__, [
    'name' => 'configure',
    'title' => 'Bankwire Configuration',
    'function' => 'bankwire_configure'
]);


function get_bankwire_infos(){
    $cart = Session::get('cart_content');
    $data['cart_total'] = with_currency( $cart->total_tax_incl );
    $data['owner']      = get_meta_value('bank_wire_owner');
    $data['details']    = get_meta_value('bank_wire_details');
    $data['address']    = get_meta_value('bank_wire_address');
    Module::getView(__FILE__, 'front/details', $data);
}