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

$action = isset($_POST['action'])? $_POST['action'] : null ;


if ($action != null) {
	switch ($action) {
		case 'delete_img_ads':
			if (isset($_POST['img_id'])) {
				$img_id = $_POST['img_id'];
				$ads_images_data = json_decode( get_meta_value("ads_images_data") , 'true' );	
				$key = searchForId($img_id, $ads_images_data);
				if (is_numeric($key)) {
					unset($ads_images_data[$key]);
					save_meta_value("ads_images_data", json_encode($ads_images_data));
					echo json_encode("1");
				}else{
					echo json_encode("0");
				}
				
			}
			break;
		
		default:
			# code...
			break;
	}
}



function searchForId($id, $array) {
   foreach ($array as $key => $val) {
       if ($val['id'] === $id) {
           return $key;
       }
   }
   return null;
}