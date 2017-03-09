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


//get posted data
$id_order = intval($_POST['id_order']);
if( $id_order < 1 ) return;

$order_detail = $_POST;
$order_detail['product_name'] = addslashes($_POST['product_name']);

use Core\Controllers\Front\UserController;
$user = new UserController();
$order_detail['cby'] = $user->get('id');;

global $common;
$id_detail = $common->save('order_detail', $order_detail);
if( $id_detail ){

	$row['row'] = '<tr id="'.$id_detail.'">
						<td><input type="text" value="'.stripslashes($_POST['product_name']).'" class="form-control name"></td>
						<td><input type="text" value="'.$_POST['product_reference'].'" class="form-control reference"></td>
						<td><input type="number" min="0" step="0.01" value="'.$_POST['product_price'].'" class="form-control price"></td>
						<td><input type="number" min="1" step="1" value="'.$_POST['product_quantity'].'" class="form-control quantity"></td>
						<td><input type="number" min="0" step="0.01" value="'.$_POST['product_weight'].'" class="form-control weight"></td>
						<td style="text-align:center;">
			      	<a href="javascript:;" class="btn btn-default update" title="'.l("Mettre à jour", "core").'"><i class="fa fa-refresh"></i></a>
			      	<a href="javascript:;" class="btn btn-danger delete" title="'.l("Supprimer ce produit", "core").'"><i class="fa fa-trash"></i></a>
			      </td>
					</tr>';
	echo json_encode($row);
}