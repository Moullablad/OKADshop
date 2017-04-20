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

 
use Core\Database\Database;
use Core\i18n\Language;
require_once 'functions.php';

global $os_admin_menu;
$os_menu = $os_admin_menu->add('<i class="fa fa-bars"></i>'
	.l('Menu', "menu"), '?module=modules&slug=menus&page=menu_settings');


function os_menu_install(){
	global $common;
  	$file = module_base(__FILE__,'includes/db.sql') ;
  	$res = $common->run_sql_file( $file );
}

/**
 * FUNCTION MENU SETTING
 */
function page_menu_settings(){
	
 
	add_js('jquery.nestable', [
	  'src' =>  module_url(__FILE__, 'vendor/nestable/jquery.nestable.js'), 
	  'admin' => true,  
	  'front' => false  
	]);

	$data = array();
	global $hooks;
	$return = array();
	$return['result'] = array();
	$return['error'] = array();

	if (isset($_POST['submit'])) {
		$action = $_POST['action'];
		switch ($action) {
			case 'addmenu':
				if ($_POST['name'] == "") {
					$return['error'][] = "le nom du menu est vide";
					break;
				}
				$data = array(
					"name" => $_POST['name']
				);
				$res = $hooks->save("menu",$data);
				if ($res) {
					$return['result'][] = "le menu est bien ajouté";
				}else{
					$return['error'][] = "le menu n'a pas ajouté";
				}
				break;
			case 'save_menu':
				//var_dump($_POST);
				$hooks->delete("menu_location","where id_menu =".$_POST['id_menu']);
				if (isset($_POST['location']) && is_array($_POST['location']) && !empty($_POST['location'])) {
					foreach ($_POST['location'] as $key => $location) {
						$data = array(
							"id_menu" => $_POST['id_menu'],
							"id_location" => $location,
						);
						$hooks->save("menu_location",$data);
					}
				}
				if (isset($_POST['nestable_result']) && !empty($_POST['nestable_result'])) {
					$array = explode(",", $_POST['nestable_result']);
					foreach ($array as $key => $value) {
						$value = explode(":", $value);
						$data = array(
							"id_parent" => $value[1],
							"position" => $value[2],
						);
						$condition = " Where id = ".$value[0];
						$hooks->update("menu_item",$data,$condition);
					}
				}
				$return['result'][] = "votre menu à été mise à jour.";
				break;
			default:
				# code...
				break;
		}	
		$_POST = array();
	}

	$return = (object)$return;
	$menu_list = (object)$hooks->select("menu",array('*'));
	$menu_item_type = $hooks->select("menu_item_type",array('*'));
	$menu_location_lang = $hooks->select("menu_location_lang",array('*'));
	$languages = get_languages();
	$id_lang = Language::getLanguage()->id;
	

	$data['languages'] = $languages;
	$data['id_lang'] = $id_lang;
	$data['return'] = $return;
	$data['menu_list'] = $menu_list;
	$data['menu_item_type'] = $menu_item_type;
	$data['menu_location_lang'] = $menu_location_lang;

	get_view(__FILE__, 'admin/setting',$data);
}
add_admin_page(__FILE__, [
    'name' => 'menu_settings',
    'title' => 'Menu settings',
    'function' => 'page_menu_settings'
]);

/**
 * DIPLAY FUNCTION
 */

function display_menu_by_location($location,$id_menu = null){

	$db = Database::getInstance();
	
	if ($id_menu == null) {
		$query = "SELECT mi.*,mit.`slug` as type FROM `"._DB_PREFIX_."menu_location` ml,`"._DB_PREFIX_."menu_location_lang` mll 
			  , `"._DB_PREFIX_."menu_item` mi ,`"._DB_PREFIX_."menu_item_type` mit where mit.id = mi.id_type and ml.id_location = mll.`id` and 
			  ml.`id_menu` = mi.`id_menu` and mll.`name` = '$location' order by mi.position";
	}else{
		$query = "SELECT mi.*,mit.`slug` as type FROM `"._DB_PREFIX_."menu_location` ml,`"._DB_PREFIX_."menu_location_lang` mll 
			  , `"._DB_PREFIX_."menu_item` mi ,`"._DB_PREFIX_."menu_item_type` mit where mit.id = mi.id_type and ml.id_location = mll.`id` and 
			  ml.`id_menu` = mi.`id_menu` and mll.`name` = '$location' and  ml.`id_menu` = $id_menu order by mi.position";
	}
	$res = $db->query($query);
	$menu_items = get_html_menu_lists($res);
	return $menu_items;
	

}

function display_sec_menu(){
	$data['menu'] = display_menu_by_location('sec_menu');
	get_view(__FILE__, 'front/main-menu',$data);
}
add_hook(__FILE__, 'top_nav', 'display_sec_menu', 'main menu', 'Display primary menu.');


function display_sec_pretop_left(){
	display_menu_by_location('sec_pretop_left');
}
add_hook(__FILE__, 'sec_pretop_left', 'display_sec_pretop_left', 'menu left', 'Display menu on the top left.');

function display_sec_pretop_right(){
	display_menu_by_location('sec_pretop_right');
}
add_hook(__FILE__, 'sec_pretop_right', 'display_sec_pretop_right', 'menu right', 'Display menu on the top right.');


function display_sec_footer_menu(){
	$db = Database::getInstance();
	$query = "SELECT m.* FROM `"._DB_PREFIX_."menu` m, `"._DB_PREFIX_."menu_location` ml, 
			 `"._DB_PREFIX_."menu_location_lang` mll WHERE ml.id_location = mll.`id` and 
			  ml.`id_menu` = m.`id` and mll.`name` = 'sec_footer_menu' ORDER BY m.position = 0, m.position";
	$footer_meun = $db->query($query);

	foreach ($footer_meun as $key => $value) {
		$data['menu'] = getMenuTrans($value->id); 
		$data['menu_list'] = display_menu_by_location('sec_footer_menu',$value->id);

		get_view(__FILE__, 'front/footer-menu',$data);
	}
}
add_hook(__FILE__, 'footer', 'display_sec_footer_menu', 'footer menu', 'Display menu in footer.');

function get_html_menu_lists($data,$id_parent = 0){
	$result = "";
	$return = array();
	global $common;
	$i = 0;
	if (!empty($data)) {
		foreach ($data as $key => $value) {
			if ($value->id_parent != $id_parent) {
				continue;
			}
			$trans = getMenuItemTrans($value->id);
			switch ($value->type) {
				case 'cms':
					$cms = $common->select("cms",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($cms[0]) && !empty($cms[0])) {
						$href = get_home_url()."cms/".$cms[0]['id'].(!empty($cms[0]['permalink']) ? "-".$cms[0]['permalink'] : "");
						

					}
					break;
				case 'blog':
					$blog = $common->select("blog",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($blog[0]) && !empty($blog[0])) {
						$href = get_home_url()."blog-detail/".$blog[0]['id'].(!empty($blog[0]['permalink']) ? "-".$blog[0]['permalink'] : "");
						
					}
					break;
				case 'product_category':
					$categories = $common->select("categories",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($categories[0]) && !empty($categories[0])) {
						$href = get_home_url()."category/".$categories[0]['id'].(!empty($categories[0]['permalink']) ? "-".$categories[0]['permalink'] : "");
						



					}
					break;
				case 'blog_category':
					$categories = $common->select("blog_categories",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($categories[0]) && !empty($categories[0])) {
						$href = get_home_url()."blog-category/".(!empty($categories[0]['permalink']) ? $categories[0]['permalink'] : $categories[0]['id']);
						

					}
					break;
				case 'cms_category':
					$categories = $common->select("cms_categories",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($categories[0]) && !empty($categories[0])) {
						$href = get_home_url()."cms-category/".(!empty($categories[0]['permalink']) ? $categories[0]['permalink'] : $categories[0]['id']);
						$tmp = get_html_menu_lists($data,$value->id);
					}
					break;
				case 'link':
					$href = $value->link;
					/*if (strpos($href,'http://') === false && $href != "#"){
					    $href = 'http://'.$href;
					}*/
					

					break;
				case 'html':
					//$result .= $trans->content;
					break;
				default:
					break;
			}
			
			$tmp = get_html_menu_lists($data,$value->id);
			if (!isset($href)) {
				$href = null;
			}
			if (!isset($trans->title)) {
				$trans->title = null;
			}
			if (!isset($tmp)) {
				$tmp = null;
			}
			if (!isset($trans->content)) {
				$trans->content = null;
			}
			$return[] = (object) array(
				"link" => $href,
				"title" => $trans->title,
				"child" => $tmp,
				"content" => $trans->content
			);

		}
	}
	/*echo "<pre>";
	var_dump($return);
	echo "</pre>";*/
	//return $result;
	return (object)$return;
}