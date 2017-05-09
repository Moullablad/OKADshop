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
include '../../../../../config/bootstrap.php';


if( !is_ajax() || $_FILES['theme']['size'][0] < 1 ) return;

//$file_name = $_FILES['theme']['name'];

$upload = upload_medias($_FILES['theme'], array(
	    'extensions' => array('zip'),
	    'uploadDir' => 'uploads/tmp/themes/',
	    'title' => 'theme_upload'
	)
);
if( isset($upload['files']) ){

	//extract themes zip
	$zip = new ZipArchive;
	$zip_path = site_base() . 'uploads/tmp/themes/';
	$zip_archive = $zip_path . 'theme_upload.zip';
	$open_zip = $zip->open($zip_archive);
	if ($open_zip === TRUE) {

		//extract themes files
		$zip->extractTo($zip_path);
		$theme_name = trim($zip->getNameIndex(0), '/');
		$zip->close();
		unlink($zip_archive);

		//check if is a valid theme
		$theme_dir = $zip_path . $theme_name . '/';
		$required = array('index.php', 'header.php', 'footer.php', 'config.xml');
		$req_error = 0;
		foreach ($required as $key => $req) {
			if( !file_exists( $theme_dir . $req ) ){
				$req_error += 1;
			}
		}

		//move theme to themes directory
		if( $req_error === 0 ){
			$copy_theme = copy_folders($theme_dir, site_base() . 'themes/' . $theme_name);
	        if( !$copy_theme ){
	        	$remove = remove_folders($theme_dir);
	        	if( $remove ){
					$return['success'] = trans("Theme was installed.", "themes");
				} else {
					$return['error'] = trans("Error occurred, please try again.", "themes");
				}
	        }
		} else {
			$return['error'] = trans("The folowing files are required to install theme: \n (index.php, header.php, footer.php, config.xml.", "themes");
		}
	}

	echo json_encode( $return );
}