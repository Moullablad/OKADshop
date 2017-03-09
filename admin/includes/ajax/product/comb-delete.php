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


$id_comb = intval($_POST['id_comb']);
if( $id_comb < 1 ) return;

use Core\Database\Database;
$db = Database::getInstance();
$default = $db->find('declinaisons', $id_comb, array('default_dec') );

$delete_comb = $db->delete('declinaisons', $id_comb);
if( $delete_comb ){
	$delete_attrs = $db->prepare("DELETE FROM {$db->prefix}product_declinaisons WHERE id_declinaison=?", [$id_comb]);
	if( $delete_attrs ){

		if( $default->default_dec == "1" ){

			$random = $db->select('declinaisons', array('id'), true);
			if( $random ){
				$db->prepare("UPDATE `{$db->prefix}declinaisons` SET `default_dec`=1 WHERE id=?", [$random->id]);
			}

		}



		$return['success'] = trans("Combinations was deleted.", "default");
	} else {
		$return['error'] = trans("Error occurred, please try again.", "default");
	}
	echo json_encode( $return );
}