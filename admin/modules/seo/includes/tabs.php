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
 * SEO TABS
 * ------------------------------------------------------------------
 *
 */


/**
 * Register SEO Tabs
 */
$seo_tabs = array(
	'general' => array(
		'name' => trans("General", "seo"),
		'function' => 'seo_general_tab',
		'with_form' => true,
		'position' => 1
	),
	'webmasters' => array(
		'name' => trans("Webmasters Tools", "seo"),
		'function' => 'seo_webmasters_tab',
		'with_form' => true,
		'position' => 2
	),
	'open-graph' => array(
		'name' => trans("Open Graph", "seo"),
		'function' => 'seo_open_graph_tab',
		'with_form' => true,
		'position' => 3
	),
	'twitter' => array(
		'name' => trans("Twitter", "seo"),
		'function' => 'seo_twitter_tab',
		'with_form' => true,
		'position' => 4
	),
	'analytics' => array(
		'name' => trans("Analytics", "seo"),
		'function' => 'seo_analytics_tab',
		'with_form' => true,
		'position' => 5
	),
	'meta-tags' => array(
		'name' => trans("Meta tags", "seo"),
		'function' => 'seo_meta_tags_tab',
		'position' => 6
	),
);
add_tabs(__FILE__, 'seo', $seo_tabs);


/**
 * General
 */
function seo_general_tab(){
	$settings = get_seo_settings();
	$keywords = $settings['general']['keywords'];
	if( is_array($keywords) ){
		$settings['general']['keywords'] = implode(', ', $keywords);
	}
	//save seo metas
	if ( isset($_POST['general_form']) && !is_ajax() ){
		$post = $_POST;
		if( empty($post['general']['title']['position']) ) $post['general']['title']['position'] = 0;
		if( empty($post['general']['misc']['canonical']) ) $post['general']['misc']['canonical'] = 0;
		unset($post['general_form']);
		$settings = array_merge($settings, $post);
		save_seo_settings($settings);
	}
	$data['general'] = array_to_object($settings['general']);
	get_view(__FILE__, 'admin/tabs/general', $data);
}


/**
 * Webmaster Tools
 */
function seo_webmasters_tab(){
	$settings = get_seo_settings();
	//save seo metas
	if ( isset($_POST['webmasters_form']) && !is_ajax() ){
		$post = $_POST;
		unset($post['webmasters_form']);
		$settings = array_merge($settings, $post);
		save_seo_settings($settings);
	}
	$data['webmasters'] = array_to_object($settings['webmasters']);
	get_view(__FILE__, 'admin/tabs/webmasters', $data);
}


/**
 * Webmaster Tools
 */
function seo_open_graph_tab(){
	$settings = get_seo_settings();
	//save seo metas
	if ( isset($_POST['open-graph_form']) && !is_ajax() ){
		$post = $_POST;
		unset($post['open-graph_form']);
		if( empty($post['og']['enabled']) ) $post['og']['enabled'] = 0;
		//upload og image
        if( isset($_FILES['image']) && $_FILES['image']['size'] > 0 ){
			$upload = upload_medias($_FILES['image'], array(
	            'extensions' => array('jpg', 'jpeg', 'png'),
	            'uploadDir' => 'uploads/modules/seo/',
	            'maxSize' => '5',
	            'title' => 'default_og_image'
	        ));
			if( isset($upload['files']) ){
				$post['og']['image'] = 'uploads/modules/seo/' . $upload['files'][0];
			}
        } else {
        	$post['og']['image'] = $settings['og']['image'];
        }
		$settings = array_merge($settings, $post);
		save_seo_settings($settings);
	}
	$data['og'] = array_to_object($settings['og']);
	get_view(__FILE__, 'admin/tabs/open-graph', $data);
}


/**
 * Twitter
 */
function seo_twitter_tab(){
	$settings = get_seo_settings();
	//save seo metas
	if ( isset($_POST['twitter_form']) && !is_ajax() ){
		$post = $_POST;
		unset($post['twitter_form']);
		if( empty($post['twitter']['enabled']) ) $post['twitter']['enabled'] = 0;
		//upload twitter image
        if( isset($_FILES['image']) && $_FILES['image']['size'] > 0 ){
			$upload = upload_medias($_FILES['image'], array(
	            'extensions' => array('jpg', 'jpeg', 'png'),
	            'uploadDir' => 'uploads/modules/seo/',
	            'maxSize' => '5',
	            'title' => 'default_twitter_image'
	        ));
			if( isset($upload['files']) ){
				$post['twitter']['image'] = 'uploads/modules/seo/' . $upload['files'][0];
			}
        } else {
        	$post['twitter']['image'] = $settings['twitter']['image'];
        }
		$settings = array_merge($settings, $post);
		save_seo_settings($settings);
	}
	$data['twitter'] = array_to_object($settings['twitter']);
	get_view(__FILE__, 'admin/tabs/twitter', $data);
}

/**
 * Analytics
 */
function seo_analytics_tab(){
	$settings = get_seo_settings();
	//save seo metas
	if ( isset($_POST['analytics_form']) && !is_ajax() ){
		$post = $_POST;
		unset($post['analytics_form']);
		$settings = array_merge($settings, $post);
		save_seo_settings($settings);
	}
	$data['analytics'] = array_to_object($settings['analytics']);
	get_view(__FILE__, 'admin/tabs/analytics', $data);
}

/**
 * Analytics
 */
function seo_meta_tags_tab(){
	//save seo metas
	if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !is_ajax() ){
		if( $meta_tags = get_meta_value('seo_meta_tags') ){
	    	$meta_tags = json_decode($meta_tags, true);
	    } else {
	    	$meta_tags = array();
	    }
		if( isset($_POST['save']) ){
			$meta_id = ($_POST['meta_id']!='') ? intval($_POST['meta_id']) : time();
			$meta_key = searching_multidimensional($meta_tags, 'id', $meta_id);
			if( $meta_key && isset($meta_tags[$meta_key]) ){
				unset($meta_tags[$meta_key]);
			}
			$property = $_POST['property'];
			$meta_tags[$property] = array(
				'id'	  => $meta_id, 
				'content' => $_POST['content'], 
				'type' 	  => $_POST['type']
			);
			save_seo_metas($meta_tags);
			$data['message']['success'] = trans("Meta was saved successfully.", "seo");
		} else if( isset($_POST['delete']) ){
			$meta_id = intval($_POST['delete']);
			$meta_key = searching_multidimensional($meta_tags, 'id', $meta_id);
			if( $meta_key && isset($meta_tags[$meta_key]) ){
				unset($meta_tags[$meta_key]);
				save_seo_metas($meta_tags);
				$data['message']['success'] = trans("Meta was deleted successfully.", "seo");
			}
		}
	}
	$data['defaultMetas'] = include 'metas.php';
	Seo::metaInit();
	$data['metas'] = Seo::getMetas();
	get_view(__FILE__, 'admin/tabs/meta-tags', $data);
}
