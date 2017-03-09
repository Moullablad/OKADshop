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

use Core\Image;


global $common;
$id_c 	= intval($_POST['id_c']);
$c_data = $_POST;
unset($c_data[id_c]);
if( !isset($c_data['hidden']) ) $c_data['hidden'] = 1;
$c_data['id_lang'] = 1;



//category image
function get_category_image($files, $category_id)
{
	if( isset($files) && $files['size'] > 0 ){
		global $common;
		$upload_dir  = "../../../files/category/". $category_id . "/";
		$file_target = Image::uploadImage($files, $upload_dir, $category_id);
		if( !is_empty($file_target) ){
			$file_name = str_replace( $upload_dir , '', $file_target[0] );
			$image_path = $upload_dir .'/'. $file_name;
			$crop = Image::resizeImage($image_path, array('846x280', '226x55'));
			if( $crop ) return $file_name;
		}
	}
	return false;
}


if( $id_c > 0 )
{
	$file_name = get_category_image($_FILES['image_cat'], $id_c);
	if( $file_name != "" ){
		$c_data['image_cat'] = $file_name;
		$return['image_cat'] = $file_name;
	}
	$update = $common->update('categories', $c_data, "WHERE id=".$id_c );
	if( $update ){
		$return['id_c'] = $id_c;
		$return['msg']  = l("La Catégorie a été bien mise à jour.", "core");
		echo json_encode( $return );
	}

}else{

	$insert = $common->save('categories', $c_data);
	if( $insert ){
		$file_name = get_category_image($_FILES['image_cat'], $insert);
		if( $file_name != "" ){
			$common->update('categories', array('image_cat' => $file_name), "WHERE id=".$insert );
			$c_data['image_cat'] = $file_name;
			$return['image_cat'] = $file_name;
		}
		$return['id_c'] = $insert;
		$return['msg']  = l("La Catégorie a été bien ajouter.", "core");
		echo json_encode( $return );
	}

}