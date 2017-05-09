<?php  
	//upload attachement
	if( isset($_FILES['ads_image']) && $_FILES['ads_image']['size'] > 0 ){
		$options = array(
            'extensions' => array('jpg', 'gif', 'png'),
            'uploadDir' => 'files/modules/ads/',
            'title' => array('auto', 15)
        );
	 	$upload = upload_medias($_FILES['ads_image'], $options);
	 	if( isset($upload['files'][0]) ){ //upload success
 			$file_name = $upload['files'][0];

 			$ads_images_data[] = array(
 				"filename" => 'files/modules/ads/'.$file_name,
 				"id" => strval ( time() )
 			);
 			save_meta_value("ads_images_data", json_encode($ads_images_data));
		} else { //upload fail
 

	 	}
	}
?>
<style type="text/css">
	.table-ads img{
		max-height: 300px;
	}
</style>
<div class="panel panel-default">
	<div class="panel-body">
		<form class="" action="" method="post" enctype="multipart/form-data">
			 <div class="form-group">
			 	<label class="control-label"><?php trans_e("Ajouter des images", "ads"); ?></label>
				<input id="ads_image" type="file" class="file" name="ads_image">
			 </div>
			 <div class="form-group">
			 	<input type="submit" class="btn btn-primary" value="Enregistrer" name="submit"/>
			 </div>
		</form>
		
		<table class="table table-ads" >
			<tr>
				<th>#</th>
				<th><?php trans_e("Image", "ads"); ?></th>
				<th><?php trans_e("Action", "ads"); ?></th>
			</tr>
			
			<?php foreach ($ads_images_data as $key => $img): ?>
				<tr>
					<td>
						<input type="checkbox" name="">
					</td>
					<td>
						<img src="<?= site_url().$img['filename'] ?>" />
					</td>
					<td>
						<a href="#" class="del_ads" data-id="<?= $img['id']; ?>" id="<?= $img['id']; ?>"><i class="fa fa-trash"></i> </a>
					</td>
				</tr>
			<?php endforeach ?>
		</table>
		
			
	</div>
</div>

<script type="text/javascript">
	$('.del_ads').click(function(){
		var img_id = $(this).data('id');
		var url = '../modules/ads/ajax/ajax.php';
		var data = {
		   img_id: img_id,
		   action: 'delete_img_ads'
		};
		ajax_handler(url, data, 'post', function(response) {
		   if( response == 0 ){
		    	message_notif("la suppression a échoué", {type : "danger", align : "right", width : "100"});
		    } else if( response == 1 ){
		    	$("#"+img_id).closest("tr").hide("slow");
		    	message_notif("supprimé avec succès", {align : "right", width : "100"});
		   	}

		});
		return false;
	});
</script>