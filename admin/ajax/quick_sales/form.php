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
$id_qs = intval($_POST['id_qs']);
$vflash = $_POST;
if( empty($vflash['active']) ) $vflash['active'] = 0;
if( $id_qs < 1 ) return;

//prepare data
$qs_content = strip_tags($_POST['value'], allowed_tags() );

//update meta value
$common->update('meta_value', array('value' => $qs_content ), "WHERE id=".$id_qs );
$common->update('meta_value', array('value' => $vflash['active'] ), "WHERE name='os_quick_sales_active'" );
$return['msg']  = l("Le Contenu a été bien mise à jour.", "core");
echo json_encode( $return );

