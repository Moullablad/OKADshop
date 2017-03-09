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



function blockhtml_install(){
	$db = getDB();
	$query = "CREATE TABLE IF NOT EXISTS `".$db->prefix."blockhtml` (
		`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`icon` varchar(255) NOT NULL,
		`title` varchar(255) NOT NULL,
		`text` text NOT NULL,
		`cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  		`udate` datetime DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
 	$res = $db->pdo->query($query);
}


function display_blockhtml(){
	try {
		$data = array();
		$cols = "";
		$db = getDB();
		
		if ($tmp = get_meta_value("blockhtml_cols")) {
			$cols = $tmp;
		}
		//echo "string";
		$data["cols"] = $cols;
	 
		$data["blockhtml"] = $db->prepare("select * from `".$db->prefix."blockhtml` order by id asc");
		get_view(__FILE__, 'front/blockhtml',$data);
	} catch (Exception $e) {
		//blockhtml_install();
	}
	
}
add_hook(__FILE__, 'before_footer', 'display_blockhtml', 'blockhtml', 'display blockhtml.');

function page_blockhtml_settings(){
	try {
		$data = array();
		$cols = "";
		$db = getDB();
		if ($tmp = get_meta_value("blockhtml_cols")) {
			$cols = $tmp;
		}
		if (isset($_POST['submit'])) {
			
			//save option
			if (isset($_POST['cols']) && !is_empty($_POST['cols'])) {
				if (is_numeric($_POST['cols'])) {
					save_meta_value("blockhtml_cols",$_POST['cols']);
					$cols = $_POST['cols'];
				}
			}

			//add bloc data
			if (isset($_POST['action']) && $_POST['action'] == "add") {
				 
				$icon = $_POST['icon'];
				$title = $_POST['title'];
				$text = $_POST['text'];
				if (!is_empty($icon) && !is_empty($title)) {
					
					$fields = array(
						"icon" => $icon, 
						"title" => $title, 
						"text" => $text, 
					);
					$result = $db->create("blockhtml",$fields);
					$data['result'] = $result;
				}
			}

			if (isset($_POST['blockhtml_id']) && !is_empty($_POST['blockhtml_id'])) {
				$result = $db->delete("blockhtml",$_POST['blockhtml_id']);
			}

			//edit bloc html
			if (isset($_POST['action']) && $_POST['action'] == "edit") {
				$icon = $_POST['icon'];
				$title = $_POST['title'];
				$text = $_POST['text'];
				$id = $_POST['id'];

				$fields = array(
					"icon" => $icon, 
					"title" => $title, 
					"text" => $text, 
				);
				$result = $db->update("blockhtml",$id,$fields);
				$data['result'] = $result;
			}

		}

		$data["cols"] = $cols;
		$data["blockhtml"] = $db->all('blockhtml');

		get_view(__FILE__, 'admin/config',$data);
	} catch (Exception $e) {
		//blockhtml_install();
	}
	
}
add_admin_page(__FILE__, [
    'name' => 'blockhtml_settings',
    'title' => 'Blockhtml settings',
    'function' => 'page_blockhtml_settings'
]);