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

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

$id_product = intval($_POST['id_product']);
$id_lang = intval($_POST['id_lang']);
if( $id_product < 1 || $id_lang < 1 ) return false;


use Core\Session;
use Core\Models\Admin\Product;

$modul = new Product();
$trans = $modul->getByID($id_product, $id_lang);

if( $trans ){
	Session::set('product_id_lang', $id_lang);
	echo json_encode( $trans );
}