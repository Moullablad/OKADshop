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
 * Add menu links
 */
/*global $os_admin_menu;
$medias = $os_admin_menu->add( trans('Medias', 'medias'), get_page_url('manage', __FILE__));
	$medias->link->prepend('<span class="fa fa-film"></span>');*/

/**
 * Register CSS and JS
 */
if( get_lang('direction') == 'rtl' ){
	add_css('bootstrap-rtl', [
		'src'=> site_url('assets/vendors/bootstrap/css/bootstrap-rtl.min.css'), 
	]);
}
add_css('medias', [
	'src' => admin_url('modules/medias/assets/css/medias.css'),
	'admin' => true,
	'front' => false
]);
add_js('medias', [
	'src' => admin_url('modules/medias/assets/js/medias.js'),
	'admin' => true,
	'front' => false
]);


/**
 * Register pages
 */
function manage_medias(){
	$data = array();
	get_view(__FILE__, 'admin/manage', $data); 
}
add_admin_page(__FILE__, [
    'name' => 'manage',
    'title' => 'Medias',
    'function' => 'manage_medias'
]);
