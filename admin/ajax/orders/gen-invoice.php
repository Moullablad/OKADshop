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


$id_order = intval($_POST['id_order']);
if( $id_order < 1 ) return;


$common = new OS_Common();
$os_orders = new Core\Controllers\Admin\OrderController();

//get quoattion data
$order = $common->select('orders', array('*'), "WHERE id=".$id_order );

//prepare new order data
$order = $order[0];
if( empty($order) ) return;
$order['id_order'] = $id_order;
$order['reference'] = $os_orders->get_reference_number('invoices');

use Core\Controllers\Front\UserController;
$user = new UserController();
$order['cby'] = $user->get('id');

//insert order
$exclude 	= array('id', 'id_quotation', 'cdate', 'uby', 'udate');
$id_invoice = $common->save('invoices', $order, $exclude);

if( $id_invoice ){
	
	//order carrier
	$carrier = $common->select('order_carrier', array('*'), "WHERE id_order=".$id_order );
	$carrier[0]['id_invoice'] = $id_invoice;
	$carrier[0]['cby'] = USER_ID;
	$exclude 	= array('id', 'id_order', 'uby', 'cdate', 'udate');
	$invoice_carrier = $common->save('invoice_carrier', $carrier[0], $exclude );
	
	if( $invoice_carrier ){
		
		//get quotation products
		$order_detail = $common->select('order_detail', array('*'), "WHERE id_order=".$id_order );
		$exclude 	= array('id', 'id_order', 'uby', 'cdate', 'udate');
		
		if( !empty($order_detail) ){
			foreach ($order_detail as $key => $detail) {
				//insert invoice_detail
				$detail['id_invoice'] = $id_invoice;
				$detail['cby'] = USER_ID;
				$common->save('invoice_detail', $detail, $exclude);
			}
		}

	}
		
	echo $id_invoice;
}