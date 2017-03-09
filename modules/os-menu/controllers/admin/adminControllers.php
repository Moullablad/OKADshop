<?php
/**
 * ADMIN CONTROLLERS
 */

 
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

