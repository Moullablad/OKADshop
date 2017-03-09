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


include '../../../../config/bootstrap.php';

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

use Core\Database\Database;

$id_attachment = intval($_POST['id_attachment']);
$id_product = intval($_POST['id_product']);
$att_name = $_POST['att_name'];
$full_path = site_base() . 'files/attachments/'. $id_product .'/'. $att_name;
if($id_product <= 0 && $id_attachment <= 0 && $att_name == '') return;
$db = Database::getInstance();
$delete = $db->prepare("DELETE FROM {$db->prefix}product_attachments WHERE id=?", [$id_attachment]);
if( $delete ){
	if( file_exists($full_path) ) unlink($full_path);
	$return['success'] = trans("Attachment was deleted.", "default");	
} else {
	$return['error'] = trans("Unable to delete Attachment.", "default");	
}
echo json_encode($return);