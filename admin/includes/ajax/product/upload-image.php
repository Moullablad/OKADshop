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

include '../../../../config/bootstrap.php';

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}


//exit if not have id_product
$id_product = intval($_POST['id_product']);
if( $id_product < 1 ) return;


use Core\Image;
use Core\Database\Database;

$db = Database::getInstance();

try {

	error_reporting(E_ALL);
	set_time_limit(0);
	ini_set('memory_limit', '20000M');
	ini_set('max_execution_time', 0);
	date_default_timezone_set('Europe/London');


	$added_images = array();



	//upload attachement
	if( isset($_FILES['files']) && $_FILES['files']['size'][0] > 0 ){
		$uploadDir = site_base() . 'files/products/' . $id_product . '/';
		$uploadUri = site_url() . 'files/products/' . $id_product . '/';

		//upload images
		$fileTarget = Image::uploadImage($_FILES['files'], $uploadDir);
		$itemImages = array();
		if( !empty($fileTarget) ){

			//get old position
			$result = $db->prepare("SELECT position FROM {$db->prefix}product_images WHERE id_product = ? ORDER BY position DESC", [$id_product], true);
			if( isset($result->position) ){
				$position = intval($result->position) + 1;
			} else {
				$position = 1;
			}

			foreach ($fileTarget as $key => $image_path) {
				if( $image_path != "" ){
					//resize image
					$image_sizes = array("45x45", "76x76", "80x80", "100x122", "120x45", "200x200", "360x360", "570x697", "828x220");
					$resize = Image::resizeImage($image_path, $image_sizes);
					if( $resize ){
						$image_name = str_replace( $uploadDir , '', $image_path );
						$fields = array('id_product' => $id_product, 'position' => $position, 'name' => $image_name);
						$id_image = $db->create('product_images', $fields);//save image

						$ext = Image::getExtension($image_name);
						$name  = str_replace(".".$ext, "", $image_name);
						$added_images[$id_image] = $uploadUri . $name . '-80x80.' . $ext;

						$position++;
					}
				}
			}
		}


	}

	if( !empty($added_images) ){
		$return['success'] = trans("Images was uploaded.", "default");
		$return['images'] = $added_images;
	} else {
		$return['error'] = trans("Error occurred, please try again.", "default");
	}

	echo json_encode( $return );

} catch (Exception $e) {
	exit;
}