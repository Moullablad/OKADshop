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

/**
 * Register translation domain
 */
add_domain(__FILE__, 'cf');



//register module pages
function contact_form_page(){
	$data['shop'] = $GLOBALS['os']->shop;
	$page_title = get_shop('phone');
	$title = trans('Contact', 'contact') .' '. Seo::$pageName;
	set_meta_page($page_title);
	set_meta_title($title);
	get_view(__FILE__, 'front/contact', $data);
}
add_front_page(__FILE__, 'contact', 'contact_form_page');


/**
 * register module styles and scripts
 **/
add_css('cf-styles', ['src' => module_url(__FILE__, 'assets/css/styles.css')]);
add_js('cf-scripts', ['src' => module_url(__FILE__, 'assets/js/scripts.js')]);