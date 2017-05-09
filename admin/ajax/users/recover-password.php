<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */


//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}


try {
	include '../../../config/bootstrap.php';

	//prepare data
	global $common;
	$receiver = $_POST['email'];
	if( $receiver == "" ) return;

	//check if user exist
	$exist = $common->select("users", array('id', 'last_name'), "WHERE email='".$receiver."'");
	if( !$exist[0]['id'] ){
		$return['error']  = l("No user registered with that email address.", "core");
		echo json_encode( $return );
		exit;
	}

	$last_name = "";
	if( $exist[0]['last_name'] != "" ) $last_name = $exist[0]['last_name'];

	//get admin email
	$admin = $common->select("users", array('email'), "WHERE user_type='admin' ORDER BY id ASC");

	//generate new password
	$password = $common->generate_random_string(8);

	//update user password
	$update_success = $common->update("users", array('password' => md5($password)), "WHERE id=".$exist[0]['id']);

	if( $update_success )
	{
		//prepare args
		$headers  = "From: ".APP." <".$admin[0]['email'].">\r\n". 
								"MIME-Version: 1.0" . "\r\n" . 
								"Content-type: text/html; charset=UTF-8" . "\r\n"; 
		$subject  = 'Reset Your Password';
		$message  = '<strong>Hi '.$last_name.',</strong><br>';
		$message .= 'We got a request to reset your admin aria pasword.<br>';
		$message .= 'This is your new password : '.$password.'<br>';
		$success  = mail($receiver, $subject, $message, $headers); 

		//return message
		if( $success ){
			$return['success'] = l("Email with password was sent to your Inbox.", "core");
			echo json_encode( $return );
		}else{
			$return['error'] = l("Error sending email.", "core");
			echo json_encode( $return );
		}

	}else{
		$return['error'] = l("Error updating password, try again.", "core");
		echo json_encode( $return );
	}

	
} catch (Exception $e) {
	exit;
}