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


use Core\Payment;


/**
 * add menu links
 */
global $os_admin_menu;
$modules = $os_admin_menu->add( trans('Modules', 'modules'), get_page_url('manage', __FILE__));
	$modules->link->prepend('<span class="fa fa-puzzle-piece"></span>');
	$modules->add( trans('Modules', 'modules'), get_page_url('manage', __FILE__));
	$modules->add( trans('Positions', 'modules'), get_page_url('positions', __FILE__));



/**
 * Register javascripts and css
 */
add_css('modules-css', [
	'src' => admin_url('modules/modules/assets/css/modules.css'), 
	'admin' => true
]);
if( get_url_param('module') == 'modules' ){
	add_js('modules-js', [
		'src' => admin_url('modules/modules/assets/js/modules.js'), 
		'admin' => true,
		'front' => false
	]);
}


/**
 * Register pages
 */
function os_manage_modules(){
	$data = array();
	$data['modules'] = get_modules();
	get_view(__FILE__, 'admin/manage', $data); 
}
add_admin_page(__FILE__, [
    'name' => 'manage',
    'title' => 'Modules',
    'function' => 'os_manage_modules'
]);


function os_modules_positions(){
	$data = array();
	$data['hooks'] = get_section_hooks();
	get_view(__FILE__, 'admin/positions', $data); 
}
add_admin_page(__FILE__, [
    'name' => 'positions',
    'title' => 'Positions',
    'function' => 'os_modules_positions'
]);



/**
 * Display block social icons.
 **/
function display_payment_methodes(){
	$methods = Payment::getPaymentMethodes();
	$output = '<ul id="payment_methodes" class="pull-right">';
	$output .= '<li>'.trans("We accept", "modules").' :</li>';
	foreach ($methods as $name => $method) {
		$output .= '<li><img title="'.$method->name.'" alt="'.$method->name.'" src="'. module_url($name, 'icon.png') .'" height="40" width="40" class="img-thumbnail"></li>';
	}
	$output .= '</ul>';
	print $output;
}
add_hook(__FILE__, 'footer_copyright', 'display_payment_methodes', 'Payment methodes', 'Display payment methodes.');
