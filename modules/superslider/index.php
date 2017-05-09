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




function superslider_install(){
	global $common;
  	$file = module_base(__FILE__,'includes/db.sql') ;
  	$res = $common->run_sql_file( $file );
 
}

function superslider_uninstall(){
	return true;
}


function getImageSlider(){
	global $DB;
	$sql = "SELECT * FROM "._DB_PREFIX_."superslider_images";
	$res = $DB->pdo->query($sql);
	return $res->fetchAll(PDO::FETCH_ASSOC);
}


function page_slidersettings() {
	global $hooks;

	if (isset($_FILES['image_cat']) && $_FILES['image_cat']['size'] > 0) {
		$nbpic = count(array_filter($_FILES['image_cat']['name']));
		$tmp = false;
		for ($i=0; $i <$nbpic ; $i++) {
			$file_name = time().'-'.$i;
			$info = pathinfo($_FILES['image_cat']['name'][$i]);
			$ext = $info['extension']; // get the extension of the file

			$newname = $file_name.".".$ext; 
			$dir = '../modules/superslider/images/';
			$target = $dir.$newname;
			if (!file_exists($dir)) {
			    mkdir($dir, 0777, true);
			}
			if(move_uploaded_file($_FILES['image_cat']['tmp_name'][$i], $target)){
				
				$data = array(
					'file_name' => $newname 
				);
				$hooks->save('superslider_images',$data);
				$tmp = true;
			}
		}
		if ($tmp) {
			echo('<br><div class="alert alert-info" role="alert">'.l('Bien enregistre','superslider').'</div>');
		}
	}
	if (isset($_POST['slider_description']) && !empty($_POST['slider_description'])) {
		$slider_description = strip_tags($_POST['slider_description'],allowed_tags());
		$slider_description = addslashes($slider_description);
		$return = $hooks->save_mete_value('superslider_description',$slider_description);
		if ($return && (!isset($tmp) || !$tmp)) {
			echo('<br><div class="alert alert-info" role="alert">'.l('Bien enregistre','superslider').'</div>');
		}
	}
	if (isset($_GET['deleteImg']) && !empty($_GET['deleteImg'])) {
		$condition = ' WHERE id ='.$_GET['deleteImg'];
		$return = $hooks->delete('superslider_images',$condition);
		if ($return) {
			echo('<br><div class="alert alert-info" role="alert">'.l('Bien Supprimé','superslider').'</div>');
		}
	}

	$output = '<fieldset ><form  method="POST" enctype="multipart/form-data" action="">';
	$output .= 	'<input type="hidden" name="module" value="'.$_GET['module'] .'" />
				 <input type="hidden" name="slug" value="'.$_GET['slug'] .'" />
				 <input type="hidden" name="page" value="'.$_GET['page'] .'" />';
	$description =  $hooks->select_mete_value("superslider_description");
	$output .= '<div class="form-group">
					<label class="control-label" for="short_description">'.l('Slider Description','superslider').'</label>                  
					<textarea class="form-control summernote" name="slider_description">';
	if ($description ) {
		$output .= htmlspecialchars_decode($description);
	}
	$output .= '</textarea>
				</div>';


	$output .= '<div class="form-group">
		            <label class="control-label" for="attachments">'.l('Uploader nouveaux images de SuperSlider','superslider').'</label>  
		            <input type="file" name="image_cat" id="filer_input">
		            <input type="submit" name="submitImageCat" id="submitImageCat" class="btn btn-primary"/>
	          	</div>
	          </form>
	          	';
	$res = getImageSlider();
	if(isset($res) && !empty($res)){
		$output .= '<div class="">
						<i class="fa fa-picture-o"></i>
						<strong>'.l('Sélectionnez l\'image en vedette.','superslider').'</strong>
					</div>
					<div class="col-sm-12">
						<ul class="list-inline" id="images">';

		$pos = 	strpos($_SERVER['REQUEST_URI'],'&deleteImg');
		if ($pos) {
			$url = substr($_SERVER['REQUEST_URI'], 0,$pos);
		}else{
			$url = $_SERVER['REQUEST_URI'];
		}
		foreach ($res as $key => $image){
			$uploadDir = '../modules/superslider/images/';
			$img_src 	= $uploadDir.$image['file_name'];
			$output .='<li id="'.$image['id'].'">
							<label for="'.$image['id'].'">
								<img style="width: 80px;height: 80px;" src="'.$img_src.'" class="img-thumbnail" id="'.$image['id'].'">
							</label>
							<div class="text-center">
								<a data-name="'.$image['file_name'].'" id="'.$image['id'].'" class="btn btn-danger delete_img" href="'.$url.'&deleteImg='.$image['id'].'"><i class="fa fa-trash"></i></a>
							</div>
						</li>';
		}
		$output .='</ul>';
	}
	$output .='</fieldset>';

	echo $output;
}
add_admin_page(__FILE__, [
    'name' => 'slidersettings',
    'title' => 'Slider settings',
    'function' => 'page_slidersettings'
]);



// add_hook('sec_home_center', 'superslider', 'superslider_displayFront', 'super slider display Front');

 

function display_slider(){
	$data = array();
	$images = getImageSlider();
	$data['images'] = $images;
	if (!is_empty($images)) {
		get_view(__FILE__, 'front/slider',$data);
	}
}
add_hook(__FILE__, 'column_right', 'display_slider', 'Display slider', 'Display home slider.');
