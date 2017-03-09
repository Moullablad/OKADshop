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
	$section = $_POST['section'];
	$cat_slug = $_POST['cat_slug'];
	if($section == '' || $cat_slug == '') return;

	global $hooks;
	$inactive_hooks = $hooks->get_inactive_hooks( $section );

	//module filter
	$args = array('cat_slug' => $cat_slug);
	$hook_filter = $hooks->modules_filter( $inactive_hooks, $args);

	$ul = '';
	if( !empty($hook_filter) ){
		foreach ($hook_filter as $key => $hook) {
			// prepare items list
			$ul .= '<div class="module" id="'. $key .'">';
			$ul .= '<strong>'. $hook['mod_name'] .'</strong>';
			$ul .= '<a type="button" class="btn btn-success btn-sm pull-right enable_hook">
							<i class="fa fa-plus"></i></a>';
			if( $hook['description'] != "" ){
				$ul .= '<p>'. $hook['description'] .'</p>';
			}
			$ul .= '</div>';
		}
	}

	if( $ul != "" ){
		echo $ul;
	}else{
		echo '<center>'.l("Aucun Hook Trouvé.", "core").'</center>';
	}
	
	
} catch (Exception $e) {
	exit;
}
 