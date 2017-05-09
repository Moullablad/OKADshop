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

include '../../../config/bootstrap.php';

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}


global $common;
$id_m 	= intval($_POST['id_m']);
$m_data = $_POST;
unset($m_data[id_m]);
if( empty($m_data['active']) ) $m_data['active'] = 0;

//manufactures logo
if( isset($_FILES['logo']) && $_FILES['logo']['size'][0] > 0 ){
  $upload_dir = "../../../../files/m/";
  $file_target = $common->uploadImage($_FILES['logo'], $upload_dir);
  $logo_name = str_replace( $upload_dir , '', $file_target[0] );
  if( $logo_name != "" ){
  	$m_data['logo'] = $logo_name;
  	$return['logo'] = $logo_name;
  }
}

if( $id_m > 0 )
{

	$update = $common->update('manufacturers', $m_data, "WHERE id=".$id_m );
	if( $update ){
		$return['id_m'] = $id_m;
		$return['msg']  = l("Le Fabricant a été bien mise à jour.", "core");
		echo json_encode( $return );
	}

}else{

	$insert = $common->save('manufacturers', $m_data);
	if( $insert ){
		$return['id_m'] = $insert;
		$return['msg']  = l("Le Fabricant a été bien ajouter.", "core");
		echo json_encode( $return );
	}

}