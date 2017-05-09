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
 * CUSTOMIZE TABS
 * ------------------------------------------------------------------
 *
 */


/**
 * Register Customize Tabs
 *
 */
$customize_tabs = array(
	'identity' => array(
		'name' => trans("Site Identity", "themes"),
		'function' => 'theme_identity_tab',
		'with_form' => true,
		'with_head' => false,
		'position' => 1
	),
	'colors' => array(
		'name' => trans("Colors", "themes"),
		'function' => 'theme_colors_tab',
		'with_form' => true,
		'with_head' => false,
		'position' => 2
	)
);
add_tabs(__FILE__, 'customize', $customize_tabs);


/**
 * Theme identity tab
 *
 */
function theme_identity_tab(){
	$data = array();
	//save theme colors
	if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !is_ajax() ){
		$params = unserialize( get_meta_value('theme_options') );
		$options = array(
            'extensions' => array('jpg', 'gif', 'png', 'ico'),
            'uploadDir' => 'uploads/themes/'
        );
		//upload logo
        if( isset($_FILES['logo']) && $_FILES['logo']['size'] > 0 ){
        	$options['title'] = 'logo';
			$upload = upload_medias($_FILES['logo'], $options);
			if( isset($upload['files']) ){
				$params['logo'] = 'uploads/themes/' . $upload['files'][0];
			}
        }
		//upload favicon
        if( isset($_FILES['favicon']) && $_FILES['favicon']['size'] > 0 ){
        	$options['title'] = 'favicon';
			$upload = upload_medias($_FILES['favicon'], $options);
			if( isset($upload['files']) ){
				$params['favicon'] = 'uploads/themes/' . $upload['files'][0];
			}
        }
		// $params['title'] = $_POST['title'];
		// $params['tagline'] = $_POST['tagline'];
		save_meta_value('theme_options', serialize($params));
		$data['message']['success'] = trans("Site identity was Updated", "themes");
	}
	$data['identity'] = (object) unserialize( get_meta_value('theme_options') );
	get_view(__FILE__, 'admin/tabs/identity', $data);
}


/**
 * Theme colors tab
 *
 */
function theme_colors_tab(){
	$data = array();
 
	$data['css'] = (object) unserialize( get_meta_value('theme_options_custom_style') );
	/*$data['css'] = (object)  array(
		"bgcolor" => (object) array(
				"selector"  	=> "body",
				"attribute" 	=> "background-color",
				"value"     	=>	""
			),
		"text_color" => (object) array(
				"selector"  	=> "p",
				"attribute" 	=> "color",
				"value"     	=>	""
			),
		"link_color" => (object) array(
				"selector"  	=>	"a",
				"attribute" 	=>	"color",
				"value"     	=>	""
			),
		"top_nav_color" => (object) array(
				"selector"  	=> "#top-nav",
				"attribute" 	=> "background-color",
				"value"  		=> ""),
		"trending_background" 	=> (object) array(
				"selector"  	=> "#trending .nav-tabs>li.active>a, #trending .nav-tabs>li.active>a:focus, #trending .nav-tabs>li.active>a:hover",
				"attribute" 	=> "background-color",
				"value"  		=> ""),
		"header_searchbox" 	=> (object) array(
				"selector"  	=> "#header_top #searchbox [type='submit']",
				"attribute" 	=> "background-color",
				"value"  		=> "")
	);*/
 

	//save theme colors
	if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !is_ajax() ){
		$params = unserialize( get_meta_value('theme_options') );
		
		foreach ($_POST['css'] as $key => $value) {
			$data['css']->$key->value = $value;
		}
		$params['css'] = $data['css'];
		save_meta_value('theme_options', serialize($params));
		$data['message']['success'] = trans("Colors was Updated", "themes");
	}
	
	$params = (object) unserialize( get_meta_value('theme_options') );

	/*echo "<pre>";
	var_dump($params);
	echo "</pre>";*/
	//echo "<pre>";
	if (!is_empty($params->css)) {
		//$tmp = array();
		//var_dump($data['css']);
		foreach ($data['css'] as $key => $value) {
 
			if (isset($params->css->$key) && !isset($data['css']->$key->protected) ) {
				//var_dump($params->css->$key);
				$data['css']->$key = $params->css->$key;
			}
			//var_dump($params->css);
			/*if (isset($params->css->$key)) {
				$params->css->$key = $value;
			}*/
		}

		//var_dump($data['css']);

		//var_dump($params->css);
		//$data['css'] = $tmp;
	}
	//echo "</pre>";
	get_view(__FILE__, 'admin/tabs/colors', $data);
}