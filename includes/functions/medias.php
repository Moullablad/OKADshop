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
 * THIS FILE GROUP ALL MEDIAS FUNCTIONS
 * ------------------------------------------------------------------
 *
 *
 */

use Core\Media;



/**
 * Upload Medias
 *
 * @param $files array
 * @param $options array
 *
 * @return $files || $errors
 */
function upload_medias($files, $options){
	return Media::upload($files, $options);
}


/**
 * Register a CSS stylesheet.
 *
 * @param string $unique_id
 * @param array  $params
 *
 * @return void
 */
function add_css($unique_id, $params=[]){
	return Media::addCSS($unique_id, $params);
}

/**
 * Register a javascript.
 *
 * @param string $unique_id
 * @param array  $params
 *
 * @return void
 */
function add_js($unique_id, $params=[]){
	return Media::addJS($unique_id, $params);
}


/**
 * Render styles.
 *
 * @return void
 */
function render_styles(){
	$styles = Media::getStyles();
	if( empty($styles) )
		return false;

	$output = '';
	foreach ($styles as $unique_id => $s) {
		$version = ($s['version']) ? "?v=".$s['version'] : "";
		$output .= '<link id="'. $unique_id .'" href="'. $s['src'] . $version .'" rel="stylesheet" type="text/css" media="'. $s['media'] .'" />'. "\n\t";
	}
	print $output ."\n";
}
add_action('os_head', 'render_styles');


/**
 * Render scripts.
 *
 * @return void
 */
function render_scripts(){
	$scripts = Media::getScripts();
	if( empty($scripts) )
		return false;

	$output = '';
	foreach ($scripts as $unique_id => $s) {
		$version = ($s['version']) ? "?ver=".$s['version'] : "";
		$output .= '<script id="'. $unique_id .'" src="'. $s['src'] . $version .'" type="text/javascript"></script>'. "\n";
	}
	print $output;
}
add_action('os_footer', 'render_scripts');












/**
 * Register global CSS and JS
 */
//Jquery
add_js('jquery', [
	'src' => site_url('assets/vendors/jquery/jquery-2.1.4.min.js'), 
	'admin' => true
]);

//Bootstrap
add_js('bootstrap', [
	'src' => site_url('assets/vendors/bootstrap/js/bootstrap.min.js'), 
	'admin' => true
]);
add_css('bootstrap', [
	'src'=> site_url('assets/vendors/bootstrap/css/bootstrap.min.css'), 
	'admin' => true
]);
add_css('bootstrap-mp', [
	'src'=> site_url('assets/vendors/bootstrap/css/margin-padding.css'), 
	'admin' => true
]);



//Font Awesome
add_css('font-awesome', [
	'src'=> site_url('assets/vendors/font-awesome/css/font-awesome.min.css'),
	'admin' => true,
	'version' => '470'
]);

//Bootstrap datetime picker
add_js('raphael', [
	'src' => site_url('assets/vendors/datepicker/js/raphael-min.js'),
	'admin' => true,
	'front' => false 
]);
add_js('morris', [
	'src' => site_url('assets/vendors/datepicker/js/morris.min.js'),
	'admin' => true,
	'front' => false  
]);
add_js('moment', [
	'src' => site_url('assets/vendors/datepicker/js/moment.js'),
	'admin' => true,
	'front' => false  
]);
add_js('datepicker', [
	'src' => site_url('assets/vendors/datepicker/js/bootstrap-datepicker.min.js'),
	'admin' => true,
	'front' => false  
]);
add_js('datetimepicker', [
	'src' => site_url('assets/vendors/datepicker/js/bootstrap-datetimepicker.min.js'),
	'admin' => true,
	'front' => false  
]);

//autocomplete
add_js('autocomplete', [
	'src' => site_url('assets/vendors/autocomplete/jquery.autocomplete.min.js'),
	'admin' => true,
	'front' => false  
]);






//Datatable
add_css('datatables', [
	'src'=> site_url('assets/vendors/datatables/css/datatables.bootstrap.min.css'), 
	'admin' => true
]);
add_js('jquery-bootstrap', [
	'src' => site_url('assets/vendors/datatables/js/jquery.datatables.min.js'),
	'admin' => true
]);
add_js('datatables-bootstrap', [
	'src' => site_url('assets/vendors/datatables/js/datatables.bootstrap.min.js'),
	'admin' => true
]);

//Bootstrap chosen
add_js('chosen', [
	'src' => site_url('assets/vendors/chosen/js/chosen.jquery.min.js'), 
	'admin' => true 
]);
add_css('chosen', [
	'src'=> site_url('assets/vendors/chosen/css/chosen.css'), 
	'admin' => true 
]);

//Bootstrap switch
add_css('bootstrap-switch', [
	'src'=> site_url('assets/vendors/bootstrap-switch/css/bootstrap-switch.min.css'), 
	'admin' => true 
]);
add_js('bootstrap-switch', [
	'src'=> site_url('assets/vendors/bootstrap-switch/js/bootstrap-switch.min.js'), 
	'admin' => true 
]);

//Bootstrap sortable 
add_js('bootstrap-sortable ', [
	'src'=> site_url('assets/vendors/sortable/js/jquery.sortable.min.js'), 
	'admin' => true,
	'front' => false
]);

//Bootstrap growl
add_js('growl', [
	'src' => site_url('assets/vendors/bootstrap-growl/js/bootstrap-growl.min.js'), 
	'admin' => true
]);

//Magnific popup
add_css('magnific-popup', [
	'src' => site_url('assets/vendors/magnific-popup/magnific-popup.css'),
	'admin' => true
]);
add_js('magnific-popup', [
	'src' => site_url('assets/vendors/magnific-popup/jquery.magnific-popup.min.js'),
	'admin' => true
]);

//jQuery Filer
add_css('jquery-filer', [
	'src'=> site_url('assets/vendors/jquery-filer/css/jquery.filer.css'), 
	'admin' => true 
]);
add_js('jquery-filer', [
	'src' => site_url('assets/vendors/jquery-filer/js/jquery.filer.min.js'), 
	'admin' => true 
]);

//Tag input
add_css('tagsinput', [
	'src'=> site_url('assets/vendors/tagsinput/css/bootstrap-tagsinput.css'), 
	'admin' => true, 
	'front' => false 
]);
add_js('tagsinput', [
	'src'=> site_url('assets/vendors/tagsinput/js/bootstrap-tagsinput.js'), 
	'admin' => true, 
	'front' => false 
]);

//multiselect
add_js('multiselect', [
	'src'=> site_url('assets/vendors/multiselect/js/multiselect.min.js'), 
	'admin' => true, 
	'front' => false 
]);

//Summer Note
add_js('summernote', [
	'src'=> site_url('assets/vendors/summernote/js/summernote.min.js'), 
	'admin' => true,
	'front' => false
]);
add_css('summernote', [
	'src'=> site_url('assets/vendors/summernote/css/summernote.css'), 
	'admin' => true,
	'front' => false
]);

//Color picker
add_css('colorpicker', [
	'src'=> site_url('assets/vendors/colorpicker/css/bootstrap-colorpicker.min.css'), 
	'admin' => true,
	'front' => false 
]);
add_js('colorpicker', [
	'src'=> site_url('assets/vendors/colorpicker/js/bootstrap-colorpicker.min.js'),
	'admin' => true,
	'front' => false 
]);

//Multi nested lists
add_css('multinestedlists', [
	'src'=> site_url('assets/vendors/multinestedlists/tree.css'), 
	'admin' => true,
	'front' => false 
]);
add_js('multinestedlists', [
	'src'=> site_url('assets/vendors/multinestedlists/tree.js'), 
	'admin' => true,
	'front' => false 
]);

//dual-listbox
add_js('dual-listbox', [
	'src'=> site_url('assets/vendors/dual-listbox/dual-list-box.min.js'),
	'admin' => true,
	'front' => false 
]);

//globals
add_js('core-global', [
	'src' => site_url('assets/js/global.js'), 
	'admin' => true 
]);
add_css('core-global', [
	'src'=> site_url('assets/css/global.css'), 
	'admin' => true 
]);
add_js('core-cart', [
	'src' => site_url('assets/js/cart.js'), 
	'admin' => true 
]);
add_js('core-order-address', [
	'src' => site_url('assets/js/order-address.js'), 
	'admin' => true 
]);