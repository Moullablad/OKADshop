<?php  
require_once '../../../config/bootstrap.php';
use Core\Database\Database;
use Core\i18n\Language;

global $common;
$return = "";
if (isset($_POST['action']) && !empty($_POST['action']) && isset($_POST['id_type'])) {
	$action = $_POST['action'];
	//$type = (isset($_POST['type'])? $_POST['type'] : null ) ;
	$id_menu = (isset($_POST['id_menu'])? $_POST['id_menu'] : null ) ;
	$type  = $common->select("menu_item_type",array("slug")," where id = ".$_POST['id_type']);
	if (isset($type[0]['slug'])) {
		$type = $type[0]['slug'];
	}else{
		$type = null;
	}
	if ($type != null && $action == "elementByType") {
		switch ($type) {
			case 'cms':
				$cms = $common->select("cms",array("*"));
				$return .= '<label class="control-label col-lg-3">'.l("page *", "smartmenu").'</label><div class="col-lg-4"> <select name="id_content" class="form-control element" id="id_content"><option value="0">Selectionner une page</option>';
				if (!is_empty($cms)) {
					foreach ($cms as $key => $value) {
						$return .= "<option value='$value[id]'>$value[title]</option>";
					}
				}
				$return .= '</select></div>';
				echo json_encode($return);
				break;
			case 'blog':
				$blog = $common->select("blog",array("*"));
				$return .= '<label class="control-label col-lg-3">'.l("Article *", "smartmenu").'</label><div class="col-lg-4"> <select name="id_content" class="form-control element" id="id_content"><option value="0">Selectionner une Article</option>';
				if (!is_empty($blog)) {
					foreach ($blog as $key => $value) {
						$return .= "<option value='$value[id]'>$value[title]</option>";
					}
				}
				
				$return .= '</select></div>';
				echo json_encode($return);
				break;
			case 'product_category':
				$cms = $common->select("categories",array("*"));
				$return .= '<label class="control-label col-lg-3">'.l("Categories *", "smartmenu").'</label><div class="col-lg-4"> <select name="id_content" class="form-control element" id="id_content"><option value="0">Selectionner une categorie</option>';
				if (!is_empty($cms)) {
					foreach ($cms as $key => $value) {
						$return .= "<option value='$value[id]'>$value[name]</option>";
					}
				}
				$return .= '</select></div>';
				echo json_encode($return);
				break;
			case 'blog_category':
				$cms = $common->select("blog_categories",array("*"));
				$return .= '<label class="control-label col-lg-3">'.l("catégorie d'Article *", "smartmenu").'</label><div class="col-lg-4"> <select name="id_content" class="form-control element" id="id_content"><option value="0">Selectionner une catégorie d\'Article</option>';
				if (!is_empty($cms)) {
					foreach ($cms as $key => $value) {
						$return .= "<option value='$value[id]'>$value[title]</option>";
					}
				}
				$return .= '</select></div>';
				echo json_encode($return);
				break;
			case 'cms_category':
				$cms = $common->select("cms_categories",array("*"));
				$return .= '<label class="control-label col-lg-3">'.l("catégorie des pages *", "menu").'</label><div class="col-lg-4"> <select name="id_content" class="form-control element" id="id_content"><option value="0">Selectionner une catégorie des pages</option>';
				if (!is_empty($cms)) {
					foreach ($cms as $key => $value) {
						$return .= "<option value='$value[id]'>$value[title]</option>";
					}
				}
				$return .= '</select></div>';
				echo json_encode($return);
				break;
			case 'link':
				$return .= '<label class="control-label col-lg-3">'.l("Url de lien *", "smartmenu").'</label><div class="col-lg-4"><input name="link" class="form-control element" id="link"/></div>';
				echo json_encode($return);
				break;
			default:
				# code...
				break;
			case 'html':
				$return .= '<label class="control-label col-lg-3">'.l("Contenu *", "smartmenu").'</label><div class="col-lg-4"><textarea name="content" class="form-control element summernote" rows="5" id="content"></textarea></div>';
				echo json_encode($return);
				break;
/*			case 'contact':
				$return .= '<label class="control-label col-lg-3">'.l("permalink *", "smartmenu").'</label><div class="col-lg-4"><input name="link" class="form-control element" value="contact" id="link"/></div>';
				echo json_encode($return);
				break;*/
			default:
				# code...
				break;
		}
	}

	
}

if (isset($_POST['title']) && !isset($_POST['action'])) {
	if (isset($_POST['content'])) {
		$_POST['content'] = addslashes($_POST['content']);
	}
	$res = $common->save("menu_item",$_POST);
	if ($res) {
		echo json_encode("1");
	}
}

if (isset($_POST['action']) && isset($_POST['id_menu']) && $_POST['action'] == "refrechMenu") {
	$res  = array();
	$res['menu_item'] = '<div class="dd">';
	$menu_item = $common->select("menu_item",array("*")," where id_menu = ".$_POST['id_menu'] ." order by position");

	if (!empty($menu_item)) {
		$res['menu_item'] .=  getNestableChild($menu_item,0);
	}
	$res['menu_item'] .= '</div>';
	

	$res['menu_location'] = $common->select("menu_location",array("id_location")," where id_menu = ".$_POST['id_menu']);

	echo json_encode($res);
}

if (isset($_POST['action']) && isset($_POST['id_menu']) && $_POST['action'] == "deleteMenu") {

	$common->delete("menu"," where id = ".$_POST['id_menu']);
	$common->delete("menu_item"," where id_menu = ".$_POST['id_menu']);

	echo json_encode("1");
}

if (isset($_POST['action']) && isset($_POST['id_menu_item']) && $_POST['action'] == "deleteMenuItem") {

	$common->delete("menu_item"," where id = ".$_POST['id_menu_item']);

	echo json_encode("1");
}

if (isset($_POST['action']) && isset($_POST['id_menu_item']) && $_POST['action'] == "getMenuItem") {

	$res = array();
	$MenuItemTrans = getMenuItemTrans($_POST['id_menu_item']);
	if ($MenuItemTrans) {
		$res = array(
			'title' =>  $MenuItemTrans->title,
			'content' => $MenuItemTrans->content,
			'link' =>  $MenuItemTrans->link
		);
	}

	echo json_encode($res);
}
if (isset($_POST['action']) && isset($_POST['id_menu_item']) && isset($_POST['id_lang']) && $_POST['action'] == "getMenuItemTrans") {
	$res = array();
	$MenuItemTrans = getMenuItemTrans($_POST['id_menu_item'],$_POST['id_lang']);
	if ($MenuItemTrans) {
		$res['title'] =  $MenuItemTrans->title;
		$res['content'] =  $MenuItemTrans->content;
	}

	echo json_encode($res);
}
//var_dump($_POST);

if (isset($_POST['action']) && isset($_POST['id_menu_item']) && isset($_POST['id_lang']) && $_POST['action'] == "saveMenuItemTrans" && isset($_POST['title'])) {
 
 	$data = array(
 		"title" => $_POST['title'],
 		"link" => $_POST['link'],
 		"content" => $_POST['content']
 	);
	$res = saveMenuItemTrans($_POST['id_menu_item'],$_POST['id_lang'],$data);
	if ($res) {
		echo json_encode("1");
	}

	
}

if (isset($_POST['action']) && isset($_POST['id_menu']) && isset($_POST['id_lang']) && $_POST['action'] == "getMenuTrans") {
	$res = array();
	$MenuTrans = getMenuTrans($_POST['id_menu'],$_POST['id_lang']);
	if ($MenuTrans) {
		$res['name'] =  $MenuTrans->name;
		$res['position'] =  $MenuTrans->position;
	}

	echo json_encode($res);
}




if (isset($_POST['action']) && isset($_POST['id_menu']) && isset($_POST['id_lang']) && $_POST['action'] == "saveMenuTrans" && isset($_POST['name'])) {
 
 	$data = array(
 		"name" => $_POST['name'],
 		"position" => $_POST['position']
 	);

	$res = saveMenuTrans($_POST['id_menu'],$_POST['id_lang'],$data);
	if ($res) {
		echo json_encode("1");
	}

	
}


function getNestableChild($array,$id_parent = null,$id_lang = null){
	$result = '';
	foreach ($array as $key => $item) {
		$res = getMenuItemTrans($item['id'],$id_lang);
		if ($item['id_parent'] == $id_parent) {
			$result .= '<li class="dd-item" data-id="'.$item['id'].'"><div class="dd-handle">'.$res->title;
			$result .= '</div>

			<a href="javascript:;" class="edit-menu-item pull-right" 
			style="color:#000; position: absolute; right: 6%;margin-top: -6%;" >
			<i class="fa fa-pencil" aria-hidden="true"></i></a>

			<a href="javascript:;" class="delete-menu-item pull-right" 
			style="color:red; position: absolute; right: 3%;margin-top: -6%;" >
			<i class="fa fa-trash-o" aria-hidden="true"></i></a> ';

			$result .= getNestableChild($array,$item['id']);
			$result .= "</li>";
		}
	}
	if ($result != "") {
		$result = '<ol class="dd-list">' . $result .'</ol>';
	}
	return $result;
}

 


function saveMenuItemTrans($id_menu_item,$id_lang,$data){
	if( !is_numeric($id_menu_item) || !is_numeric($id_lang))
      return false;

  	try {


    	$db = Database::getInstance();

    	if (isset($data['link'])) {
    		$fields = array(
        		"link" => $data['link'],
        		"content" => $data['content']
        	);

    		$res = $db->update("menu_item", $id_menu_item , $fields );
    	}


      	$res = $db->query("SELECT * FROM {$db->prefix}menu_item_trans WHERE id_menu_item = $id_menu_item AND id_lang = $id_lang" , true );
      	$res = (array)$res;
        if( $res && isset($res['id'])){
        	$fields = array(
        		"title" => $data['title'],
        		"content" => $data['content']
        	);

        	
        	$res_update = $db->update("menu_item_trans", $res['id'], $fields);
           	if ($res_update) {
        		return true;
        	}	
        }else{
        	$fields = array(
        		"id_menu_item" => $id_menu_item,
        		"id_lang" => $id_lang,
        		"title" => $data['title']
        	);
        	$res_create = $db->create("menu_item_trans", $fields);
        	if ($res_create) {
        		return true;
        	}	
        }

        return false;

    } catch (ControllerException $e) {
      $this->getException($e);
    }
}

function saveMenuTrans($id_menu,$id_lang,$data){
	if( !is_numeric($id_menu) || !is_numeric($id_lang))
      return false;

  	try {


    	$db = Database::getInstance();

      	$res = $db->query("SELECT * FROM {$db->prefix}menu_trans WHERE id_menu = $id_menu AND id_lang = $id_lang" , true );
      	$res = (array)$res;
        if( $res && isset($res['id'])){
        	$fields = array(
        		"name" => $data['name']
        	);

         
        	$res_update = $db->update("menu_trans", $res['id'], $fields);
        	$res_update = $db->update("menu", $id_menu,array(
        		"position" => $data['position']
        	));

           	if ($res_update) {
        		return true;
        	}	
        }else{
        	$fields = array(
        		"id_menu" => $id_menu,
        		"id_lang" => $id_lang,
        		"name" => $data['name']
        	);
        	$res_create = $db->create("menu_trans", $fields);
        	$res_update = $db->update("menu", $id_menu ,array(
        		"position" => $data['position']
        	));
        	if ($res_create) {
        		return true;
        	}	
        }

        return false;

    } catch (ControllerException $e) {
      $this->getException($e);
    }
}

?>
 
 