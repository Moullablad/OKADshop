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
include '../../../config/bootstrap.php';

$email = $_POST['email'];
if( !is_ajax() || !isValidateEmail($email)  ) return;

use Modules\Newsletter\Controllers\Newsletter;

if( Newsletter::subscribe(['email' => $email]) ) {
	$return['success'] = trans("You have successfully subscribed to our newsletter.", "nl");
} else {
	$return['error'] = trans("Unable to subscribe, please try later", "nl");
}

echo json_encode($return);