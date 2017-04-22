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
 *
 * ------------------------------------------------------------------
 * SHOP TABS
 * ------------------------------------------------------------------
 *
 */
use Core\Models\Admin\Shop;


/**
 * Register shop preferences Tabs
 */
$shop_tabs = array(
	'details' => array(
		'name' => trans("Contact details", "pref"),
		'function' => 'pref_details_tab',
		'with_form' => true,
		'multilang' => true,
		'position' => 1
	),
	'seo' => array(
		'name' => trans("SEO", "pref"),
		'function' => 'pref_seo_tab',
		'with_form' => true,
		'multilang' => true,
		'position' => 2
	),
	'urls' => array(
		'name' => trans("URLS", "pref"),
		'function' => 'pref_urls_tab',
		'with_form' => true,
		'position' => 3
	),
);
add_tabs(__FILE__, 'shop', $shop_tabs);


/**
 * Shop details
 */
function pref_details_tab(){
	$id_lang = read_cookie('shop_lang');
	if(!$id_lang) $id_lang = get_lang('id');
	$db = getDB();
	//save details
	if ( isset($_POST['details_form']) && !is_ajax() ){
		$data = $_POST;
		$model = new Shop();
		$update = $model->update($data);
	}
	$data['shop'] = get_trans('shop', 'shop_trans', 'id_shop', null, $id_lang, true);
	$data['countries'] = $db->select('countries', array('id', 'name'));
	get_view(__FILE__, 'admin/tabs/shop/details', $data);
}

/**
 * Shop seo
 */
function pref_seo_tab(){
	$id_lang = read_cookie('shop_lang');
	if(!$id_lang) $id_lang = get_lang('id');
	$data = array();
	$settings = get_seo_settings();

	//save details
	if ( isset($_POST['seo_form']) && !is_ajax() ){
		$data = $_POST;
		$model = new Shop();
		$update = $model->update($data);
	}
	$data['max_title'] = $settings['general']['title']['max'];
	$data['max_desc'] = $settings['general']['description']['max'];
	$data['shop'] = get_trans('shop', 'shop_trans', 'id_shop', null, $id_lang, true);
	get_view(__FILE__, 'admin/tabs/shop/seo', $data);
}

/**
 * Shop URLS
 */
function pref_urls_tab(){
	$id_lang = read_cookie('shop_lang');
	if(!$id_lang) $id_lang = get_lang('id');
	$data = array();
	//save details
	if ( isset($_POST['urls_form']) && !is_ajax() ){
		$data = $_POST;
		if( !isset($_POST['shop']['ssl_active']) ) {
			$data['shop']['ssl_active'] = 0;
		}
		$model = new Shop();
		$update = $model->update($data);
	}
	$data['shop'] = get_trans('shop', 'shop_trans', 'id_shop', null, $id_lang, true);
	get_view(__FILE__, 'admin/tabs/shop/urls', $data);
}


/* before_tab_ urls 
function common_data(){
	$a['data']['urls'] = 'addd';
	extract($a);
}
add_action('before_tab_location_shop', 'common_data');*/