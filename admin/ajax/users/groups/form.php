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


//prepare data
global $common;
$id_ug = intval($_POST['id_ug']);
$group_data = $_POST;
if( empty($group_data['active']) ) $group_data['active'] = 0;
unset($group_data[id_ug]);

if( $id_ug < 1 )
{
	$insert = $common->save('users_groups', $group_data );
	if( $insert ){
		$return['id_ug'] = $insert;
		$return['msg']  = l("Le groupe a été bien enregistrer.", "core");
		echo json_encode( $return );
	}
}else{
	$update = $common->update('users_groups', $group_data, "WHERE id=".$id_ug );
	if( $update ){
		$return['msg']  = l("Le groupe a été bien mise à jour.", "core");
		echo json_encode( $return );
	}
}

