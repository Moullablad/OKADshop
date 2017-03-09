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

try {
	$slug = $_POST['slug'];
	$modules = new modules();
	global $hooks;

	//$module_dir = MODULES_PATH . $slug;
	$module_dir = "../../../modules/" . $slug;
	$module_boot = preg_grep( '~\.(module.php)$~', scandir( $module_dir ) );
	if ( $module_boot ){
		$file = implode('', $module_boot);
		//require $module_dir .'/'. $file;
		$module_name = str_replace('-', '_', $slug);
		$module_uninstall = $module_name.'_uninstall';
		if (function_exists( $module_uninstall ) ) $module_uninstall();//$module_install()
	}

	//delete module positions
	$module = $hooks->get_module_by_slug($slug);
	$id_module = $module['id'];
	$hooks->delete('modules_sections', "WHERE id_module=".$id_module );
	//delete module from db
	$condition="WHERE `slug`='". $slug ."'";
	$delete = $modules->delete('modules',$condition);

	//if (function_exists('uninstall')) uninstall();
} catch (Exception $e) {
	exit();
}