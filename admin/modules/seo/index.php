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

include_once 'includes/class/Seo.php';
include_once 'includes/functions.php';
include_once 'includes/tabs.php';


/**
 * Add menu links
 */
global $os_admin_menu;
$seo = $os_admin_menu->add( trans('SEO', 'seo'), get_page_url('settings', __FILE__));
	$seo->link->prepend('<span class="fa fa-line-chart"></span>');


/**
 * Register javascripts and css
 */
if( get_url_param('module') == 'seo' ){
	add_css('seo-css', [
		'src' => admin_url('modules/seo/assets/css/seo.css'), 
		'admin' => true,
		'front' => false
	]);

	add_js('seo-js', [
		'src' => admin_url('modules/seo/assets/js/seo.js'), 
		'admin' => true,
		'front' => false
	]);
}

/**
 * Seo settings page
 *
 */
function seo_settings(){
	$data['settings'] = array(); 
	get_view(__FILE__, 'admin/settings', $data);
}
add_admin_page(__FILE__, [
    'name' => 'settings',
    'title' => 'Settings',
    'function' => 'seo_settings'
]);



//print google analytics tracking script
function ga_tracking_script(){
$settings = get_seo_settings();
$code = $settings['analytics']['code'];
if( !isset($code) || $code == '' ) return false;
print "
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', '".$code."', 'auto');
    ga('send', 'pageview');
</script>\n";
}
add_action('os_head', 'ga_tracking_script', 100);
