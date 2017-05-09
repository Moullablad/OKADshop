<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */

include '../../../config/bootstrap.php';

//This is an ajax request
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}


//check if we have a slug
$dir_name = $_POST['slug'];
if($dir_name == '') return;

//find module boot file
global $hooks;
$module_path = "../../../modules/" . $dir_name;
$module_boot = preg_grep( '~\.(module.php)$~', scandir( $module_path ) );
$boot_path	 = $module_path .'/'. implode('', $module_boot);
if( !file_exists($boot_path) ) return;

//include module to read infos
require $boot_path;
$module_infos = $hooks->modules_infos[$dir_name];

//check require infos
if(  
	   !isset($module_infos['name']) 		 || $module_infos['name'] 		== ""
	|| !isset($module_infos['author']) 	 || $module_infos['author']   == ""
	|| !isset($module_infos['website'])  || $module_infos['website']  == ""
	|| !isset($module_infos['category']) || $module_infos['category'] == ""
	|| !isset($module_infos['version'])  || $module_infos['version']  == ""
) return;

//modules class instance
$modules = new modules();

//prepare module infos
$infos['name']				= $module_infos['name'];
$infos['slug']				= $dir_name;
$infos['author']			= $module_infos['author'];
$infos['website']			= $module_infos['website'];
$infos['version']			= $module_infos['version'];
$infos['id_category'] = $modules->get_category_by_slug($module_infos['category']);
if( isset($module_infos['description']) ) $infos['description']	= $module_infos['description'];

//check if module already exist
$exist = $modules->get_module_by_slug($dir_name);
if( ! $exist ){

	//insert new module
	$id_module = $modules->save('modules', $infos);
	if( $id_module > 0 ){
		//run install function
		$module_name = str_replace('-', '_', $dir_name);
		$module_install = $module_name.'_install';
		if (function_exists( $module_install ) ) $module_install();
	}

}else{

	//update module infos
	$condition = "WHERE slug='".$dir_name."'";
	$modules->update('modules', $infos, $condition);
	//run install function
	$module_name = str_replace('-', '_', $dir_name);
	$module_install = $module_name.'_install';
	if (function_exists( $module_install ) ) $module_install();

}



//insert module positions
$module = $hooks->select('modules', array('id'), "WHERE slug='". $dir_name ."'" );
if( $module[0]['id'] != "" ){

	$id_module   = $module[0]['id'];
	$hook_functions = "";


	//loop for all hooks in module
	foreach ($hooks->hooks_array as $key => $section) {
		//get position by slug
		$id_section = $hooks->getPositionIDBySlug($key);

		//insert position hooks
		if( isset($section[$dir_name]) ){
			foreach ($section[$dir_name] as $function => $description) {
				//add function to hook_functions string
				$hook_functions .= "'".$function."', ";
				//get new position
				$condition = "WHERE `id_section`=". $id_section ." ORDER BY `position` DESC LIMIT 1";
			  $position  = $hooks->select('modules_sections', array('position'), $condition);
			  if( $position != null ){
			  	$new_position = ($position[0]['position'])+1;
		    }else{
		    	$new_position = 1;
		    }
		    //insert section if not exist
		    $exist = $hooks->select('modules_sections', array('id'), "WHERE hook_function='". $function ."' LIMIT 1" );
		    if( !$exist ){
		    	//prepare data and save
			    $position_data = array(
			      'id_section' 		=> $id_section,
			      'id_module'  		=> $id_module,
			      'hook_function' => $function,
			      'description'	  => $description,
			      'position'   		=> $new_position
			    );
			    $save = $hooks->save('modules_sections', $position_data);
		    }
				
			}
		}//END POSITION HOOKS INSERTING
		
	}//END LOOP

}

//delete old sections
if( $hook_functions != "" ){
	
	$functions = substr($hook_functions, 0, -2);
	global $DB;
	$query = "DELETE FROM `"._DB_PREFIX_."modules_sections` WHERE id_module=". $id_module ." AND `hook_function` NOT IN ($functions)";
	$DB->pdo->query($query);
}else{
	$hooks->delete('modules_sections', "WHERE id_module=".$id_module );
}

//well done
$response['success'] = l("Opération Effectué", "core");
echo json_encode($response);
