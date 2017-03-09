<?php  
 
	//upload attachement
	if( isset($_FILES['pub_image']) && $_FILES['pub_image']['size'] > 0 ){
		$options = array(
            'extensions' => array('jpg', 'gif', 'png'),
            'uploadDir' => 'modules/categorypanel/img/',
            'title' => array('auto', 15)
        );
	 	$upload = upload_medias($_FILES['pub_image'], $options);
	 	if( isset($upload['files'][0]) ){ //upload success
 			$file_name = $upload['files'][0];
 			save_meta_value("category_menu_img_pub",$file_name);
		} else { //upload fail
 

	 	}
	}
?>
<div class="panel panel-default">
	<div class="panel-body">
		<form class="" action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label class="control-label">Categorie Menu PUB</label>
				<img src="<?= $category_menu_img_pub ?>" alt="pub images" class="img-responsive">
			</div>
			 <div class="form-group">
			 	<label class="control-label">Changer L'image</label>
				<input id="pub_image" type="file" class="file" name="pub_image">
			 </div>
			 <div class="form-group">
			 	<input type="submit" class="btn btn-primary" value="Enregistrer" name="submit"/>
			 </div>
		</form>
	</div>
</div>