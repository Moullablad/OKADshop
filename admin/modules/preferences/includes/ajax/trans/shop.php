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

include '../../../../../../config/bootstrap.php';

//This is an ajax request
if(!is_ajax())
{
	die();
}

$id_lang = intval($_POST['id_lang']);
if( $id_lang < 1 ) return false;

$trans = get_trans('shop', 'shop_trans', 'id_shop', null, $id_lang, true);
if( $trans ){
	// create_session('shop_id_lang', $id_lang);
	echo json_encode( $trans );
}