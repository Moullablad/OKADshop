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
 * Register styles
 */
add_css('blocklanguages', ['src' => module_url(__FILE__, 'assets/css/blocklanguages.css')]);


/**
 * Display block language.
 **/
function i18n_block_languages(){
    $data['current'] = get_lang();
    $data['languages'] = get_languages();
    get_view(__FILE__, 'front/blocklanguages', $data);
}
add_hook(__FILE__, 'top_right', 'i18n_block_languages', 'Block languages', 'Display languages block.');


//print block languages style
function block_languages_style(){
	print "<style>.language  .dropdown-menu img{vertical-align: middle; margin: 13px 0px 0px 0px !important; position: absolute; right: 0; }.header .top-header-right ul{float: left; margin-left: 13px; }</style>";
}
add_action('os_head', 'block_languages_style', 99);



function get_language_uri($iso_code){
	if( isset($_GET['Module']) && $_GET['Module'] != '' ){
		$request = strstr($_SERVER['REQUEST_URI'], $_GET['Module']);
		return site_url() . $iso_code .'/'. $request;
	} else {
		return site_url() . $iso_code;
	}
}