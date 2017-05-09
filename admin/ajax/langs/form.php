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


//prepare data
global $common;
$id_lang = intval($_POST['id_lang']);
$lang_data = $_POST;
if( empty($lang_data['active']) ) $lang_data['active'] = 0;
if( empty($lang_data['direction']) ) $lang_data['direction'] = 0;
if( empty($lang_data['default_lang']) ) $lang_data['default_lang'] = 0;
unset($lang_data[id_lang]);

//reset default lang
$common->update('langs', array('default_lang' => 0));

//store id lang in session
$_SESSION['default_id_lang'] = $id_lang;



if( $id_lang < 1 )
{
	$update = $common->save('langs', $lang_data );
	if( $update ){
		$return['msg']  = l("La langue a été bien mise enregistrer.", "core");
		echo json_encode( $return );
	}
}else{
	$update = $common->update('langs', $lang_data, "WHERE id=".$id_lang );
	if( $update ){
		$return['msg']  = l("La langue a été bien mise à jour.", "core");
		echo json_encode( $return );
	}
}

