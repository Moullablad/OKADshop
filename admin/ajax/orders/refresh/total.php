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

$id_order = intval($_POST['id_order']);
$id_customer = intval($_POST['id_customer']);
if($id_order < 1 || $id_customer < 1 ) return;

global $common;
$o = $common->get_order($id_order, $id_customer);

//order total
$voucher_code  	 = $o['order']['voucher_code'];
$voucher_value 	 = $o['order']['voucher_value']; 
$global_discount = $o['order']['global_discount']; 
$avoir 					 = $o['order']['avoir'];
$total_products  = $o['total']['product_tht'];
$total_ht 			 = $o['total']['tht'];
$global_weight   = floatval($o['total']['weight']);
$shipping_costs  = $o['carrier']['shipping_costs'];

//totals
$totals = '<tr>
							<th width="150">'.l("Total produits HT", "core").'</th>
							<td><span class="total_products">'.$total_products.'</span></td>
						</tr>';
					if( $global_discount > 0 ){
						$totals .= '<tr>
							<th width="150">'.l("Remise globale", "core").'</th>
							<td><span class="discount">'. $global_discount .'</span></td>
						</tr>';
					}
						
					if( $voucher_value > 0 ){
						$totals .= '<tr>
							<th width="150">'.l("Bon de réduction", "core").'</th>
							<td><span class="reduction">'.$voucher_value.'</span></td>
						</tr>';
					}
						
					if( $avoir > 0 ){
						$totals .= '<tr>
							<th width="150">'.l("Avoir", "core").'</th>
							<td><span class="avoir">'.$avoir.'</span></td>
						</tr>';
					}
						
					if( $voucher_code != "" ){
						$totals .= '<tr>
							<th width="150">'.l("Code promo", "core").'</th>
							<td><span class="code">'.$voucher_code.'</span></td>
						</tr>';
					}

$totals .= '<tr>
							<th width="150">'.l("Frais de transport", "core").'</th>
							<td><span class="shipping">'.$shipping_costs.'</span></td>
						</tr>
						<tr>
							<th width="150">'.l("TOTAL HT", "core").'</th>
							<td><span class="tht">'.$total_ht.'</span></td>
						</tr>
						<!--tr>
							<th width="150">'.l("Acompte", "core").'</th>
							<td><span class="acompte"></span></td>
						</tr>
						<tr>
							<th width="150">'.l("Solde", "core").'</th>
							<td><span class="solde"></span></td>
						</tr-->
						<tr>
							<th width="150">'.l("Poids total", "core").'</th>
							<td><span class="weight">'.$global_weight.'</span></td>
						</tr>';

echo json_encode($totals);
exit;