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

include '../../../../config/bootstrap.php';

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

$name = $_POST['name'];
$description = $_POST['description'];
$email = $_POST['email'];
$id_lang = intval($_POST['id_lang']);
if( empty($_POST['save_msg']) ) $save_msg = 0;
if( $name == "" ) return;

//prepare data
global $common;
global $_CONFIG;

//save contact
$id_contact = $common->save("contact", array("email" => $email, "save_msg" => $save_msg));
//add contact trans
if( $id_contact ){
	$languages = $common->select("langs", array("id"));
	foreach ($languages as $key => $lang) {
		$trans = $common->save(
			"contact_trans", 
			array("id_contact" => $id_contact, "id_lang" => $lang['id'], "name" => $name, "description" => $description)
		);
	}
}
$return['msg']  = l("Le contact a été bien enregistrer.", "core");
echo json_encode( $return );