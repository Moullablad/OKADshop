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

if (!defined('_OS_VERSION_'))
  exit;



function display_ads(){
	$data = array();
	$ads_images_data = json_decode( get_meta_value("ads_images_data") , 'true' );	
	if (is_array($ads_images_data) && !is_empty($ads_images_data)) {
		$data['ads_images_data'] = $ads_images_data;
		get_view(__FILE__, 'front/ads',$data);
	}
}
add_hook(__FILE__, 'left_sidebar', 'display_ads', 'ads', 'Display ads.');

function page_ads_settings(){
	$data = array();
	$ads_images_data = array();
	$tmp = json_decode( get_meta_value("ads_images_data") , 'true' );	
	if (is_array($tmp)) {
		$ads_images_data = $tmp;
	}
	//var_dump($ads_images_data);
	$data['ads_images_data'] = $ads_images_data;
	get_view(__FILE__, 'admin/config',$data);
}
add_admin_page(__FILE__, [
    'name' => 'ads_settings',
    'title' => 'Ads settings page',
    'function' => 'page_ads_settings'
]);