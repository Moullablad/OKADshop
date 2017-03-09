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


use Core\i18n\Language;
use Core\Module;



/**
 * Register styles
 */
add_css('blocksocial', ['src' => module_url(__FILE__, 'assets/css/blocksocial.css')]);



/**
 * Module install
 */
function blocksocial_install(){
    $links = array('facebook' => 'https://www.facebook.com/OKADshop', 'twitter' => 'https://twitter.com/okadshop', 'youtube' => 'https://www.youtube.com/channel/UC_NLvUcKRmqUq_arEKn7KlA', 'google_plus' => 'https://plus.google.com/112035582044146693504', 'rss' => 'rss');
    save_meta_value('blocksocial_links', serialize($links));
}


/**
 * Display block social icons.
 **/
function display_block_social(){
    $links = get_meta_value('blocksocial_links');
    $data['bs']  = (object) unserialize($links);
	get_view(__FILE__, 'front/blocksocial', $data);
}
add_hook(__FILE__, 'top_left', 'display_block_social', 'Social icons', 'Display social icons block.');



//settings page
function blocksocial_links(){
    //proccess posted code
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
        save_meta_value('blocksocial_links', serialize($_POST));
        $data['message']['success'] = trans("Links was updated successfully.", "socila");
    }
    $links = get_meta_value('blocksocial_links');
    $data['bs']  = (object) unserialize($links);
    get_view(__FILE__, 'admin/settings', $data);
}
add_admin_page(__FILE__, [
    'name' => 'settings',
    'title' => 'Social Links',
    'function' => 'blocksocial_links'
]);