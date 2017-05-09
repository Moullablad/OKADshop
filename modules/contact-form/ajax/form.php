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


//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

include '../../../config/bootstrap.php';

//colecte data
$name 	  = isset($_POST['name']) ? $_POST['name'] : '';
$sender   = isset($_POST['email']) ? $_POST['email'] : '';
$website  = isset($_POST['website']) ? $_POST['website'] : '';
$subject  = isset($_POST['subject']) ? $_POST['subject'] : '';
$message  = isset($_POST['content']) ? $_POST['content'] : '';
$receiver = get_shop('email');


//check errors
if( is_empty($name) || is_empty($sender) || is_empty($subject) || is_empty($message) )
	return false;

try {

	$headers  = "From: $name <$sender>\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$content  = "You have recieved an email from contact page :";
	$content .= "<br><strong>Name:</strong> " . $name;
	$content .= "<br><strong>Email:</strong> " . $sender;
	if( $website != '' ){
		$content .= "<br><strong>Website:</strong> " . $website;
	}
	$content .= "<br><strong>Subject:</strong> " . $subject;
	$content .= "<br><strong>Content:</strong> " . $message;
	$content .= "<br><br><br><strong>This message was sent from ". get_shop('home_url') .", using Contact Form module.</strong> ";

	if ( function_exists( 'mail' ) ){
		if (mail($receiver, $subject, $content, $headers)) {
			$return['success'] = trans("Message successfully sent, Thanks.", "cf");
		} else {
			$return['error'] = trans("Message delivery failed...", "cf");
		}
	} else {
		$return['error'] = trans("Function mail() has been disabled.", "cf");
	}  



	//notiffation
	echo json_encode($return);

} catch (Exception $e) {
	exit;	
}