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


use Core\Payment;
use Core\Module;
use Core\Database\Database;
use Core\Controllers\Front\CartController;
use Omnipay\Common\GatewayFactory;
use Omnipay\Omnipay;


//defines
define('PAYPAL_PATH', dirname(__FILE__) );



/**
 * Register javascripts and css
 */
/*add_css('paypal-css', [
    'src' => site_url('modules/paypal/style.css'), 
    'admin' => true,
    'front' => false
]);*/



//register module pages
Module::setPage(__FILE__, 'paypal', 'paypal_cancel_page');
function paypal_cancel_page(){
    //display cancel page
    if( isset($_GET['ID']) && $_GET['ID'] == "cancel" ){
        Module::getView(__FILE__, 'front/cancel');
    }
}


//register payment method
$args = array(
    "name" => "Paypal",
    "description" => "Paypal payment processing",
    "function" => "paypal_checkout",
);
$res = Payment::setMethod(__FILE__, $args);

//payment method page
function paypal_checkout(){
    $controller = new CartController();
    $cart = $controller->getCartItems();

    //get paypal settings
    $username  = get_meta_value('paypal_username'); 
    $password  = get_meta_value('paypal_password'); 
    $signature = get_meta_value('paypal_signature'); 
    $test_mode = false;
    $test_mode = get_meta_value('paypal_test_mode'); 
    if( $test_mode == '1' ) $test_mode == true;

    //$db = Database::getInstance();
    //$options = $db->select('paypalexpress_setting', array('username', 'password', 'signature'), true);
    if( $username == '' || $password == '' || $signature == '' ){
        $result = array(
            'status' => 'error',
            'message' => 'Paypal account détails are empty !.',
        );
        return $result;
    }

    // Setup payment gateway
    $gateway = Omnipay::create('PayPal_Express');
    $gateway->setUsername( $username );
    $gateway->setPassword( $password );
    $gateway->setSignature( $signature );
    $gateway->setTestMode( $test_mode );

    //default params
    $params = array(
        'amount' => $cart->total_tax_incl,
        'currency' => 'USD',
        'description' => 'Reglement De commande',
        'returnUrl' => generate_url( 'order/payment/paypal' ),
        'cancelUrl' => generate_url( 'paypal/cancel' ),
    );

    // Send purchase request
    $response = $gateway->purchase($params)->send();
    // print_r($response->getMessage());exit;
    // Process response
    if ($response->isSuccessful()) {
        
        // Payment was successful
        $result = array(
            'status' => 'success',
            'message' => 'Payment processed successfully.',
        );
        // print_r($response);

    } elseif ($response->isRedirect()) {
        
        // Redirect to offsite payment gateway
        $response->redirect();

    } else {
        // Payment failed
        $result = array(
            'status' => 'error',
            'message' => $response->getMessage(),
        );
    }

    return $result;
}


/**
 * module install
 **/
function paypal_install(){
    save_meta_value('paypal_username', ''); 
    save_meta_value('paypal_password', ''); 
    save_meta_value('paypal_signature', ''); 
    save_meta_value('paypal_test_mode', '0'); 
    add_order_state('Awaiting paypal payment', 'paypal');
}

/**
 * module uninstall
 **/
function paypal_uninstall(){
    remove_meta_value('paypal_username'); 
    remove_meta_value('paypal_password'); 
    remove_meta_value('paypal_signature'); 
    remove_meta_value('paypal_test_mode'); 
    delete_order_state('paypal');
}


//configure page
function paypal_configure(){
    //proccess posted code
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
        $test_mode = (isset($_POST['test_mode'])) ? $_POST['test_mode'] : 0;
        save_meta_value('paypal_username', $_POST['username']);
        save_meta_value('paypal_password', $_POST['password']);
        save_meta_value('paypal_signature', $_POST['signature']);
        save_meta_value('paypal_test_mode', $test_mode);
        $data['message']['success']   = trans("Data was updated successfully.", "paypal");
    }
    $data['username']  = get_meta_value('paypal_username');
    $data['password']  = get_meta_value('paypal_password');
    $data['signature'] = get_meta_value('paypal_signature');
    $data['test_mode'] = get_meta_value('paypal_test_mode');
    //get configure view
    get_view(__FILE__, 'admin/configure', $data);
}
add_admin_page(__FILE__, [
    'name' => 'configure',
    'title' => 'Paypal Configuration',
    'function' => 'paypal_configure',
    'icon' => 'cogs',
    'with_nav' => true
]);