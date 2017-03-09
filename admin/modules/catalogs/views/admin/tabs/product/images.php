<?php if( isset($id_product) ) : ?>
	<input type="hidden" name="id_product" id="id_product" value="<?=$id_product; ?>">

	<div class="form-group">
		<label class="control-label col-lg-2" for="input_mages"><?php trans_e("Upload Images", "default"); ?></label>  
		<div class="col-lg-3">
			<input type="file" name="files[]" id="image_product" accept="image/*">
		</div>
    </div>

    <div class="form-group">
      <div class="col-lg-8 col-lg-offset-2">
      <table class="table" id="productImages">
        <thead>
          <tr>
            <th><?php trans_e("Image", "default"); ?></th>
            <th class="text-center"><?php trans_e("Position", "default"); ?></th>
            <th class="text-center"><?php trans_e("Cover Image", "default"); ?></th>
            <th width="90"><?php trans_e("Action", "default"); ?></th>
          </tr>
        </thead>
        <tbody class="sortable list">
          <?php if( !is_empty($images) ) : ?>
            <?php foreach ($images as $key => $image) : ?>
              <tr id="<?= $image->id; ?>">
                <td>
                  <a class="pop">
                    <img width="80" class="img-thumbnail" src="<?= product_image_by_size($image->name, $id_product, '80x80');?>">
                  </a>
                </td>
                <td align="center" class="pointer">
                  <span class="fa fa-arrows"></span>
                  <input type="text" value="<?= $image->position; ?>" disabled>
                </td>
                <td align="center">
                    <input type="radio" name="default" class="cover" value="<?= $image->name; ?>" id="cover_<?= $image->id; ?>" <?= ($image->futured == '1') ? "checked" : "";?>>
                    <label for="cover_<?= $image->id; ?>"></label>
                </td>
                <td>
                  <a data-id="<?= $image->id; ?>" class="delete pull-right btn btn-default">
                    <i class="fa fa-trash"></i> <?php trans_e("Delete this image", "default"); ?>
                  </a>
                </td>
              </tr>
            <?php endforeach;?>
          <?php endif;?>
        </tbody>
      </table>

      </div>
    </div>

    <script>
    $(document).ready(function() {
      var ajax_url = admin_dirname() + 'includes/ajax/product/';
      $('#image_product').filer({
        showThumbs: true,
        addMore: true,
        maxSize: 8,
        extensions: ['png', 'jpg', 'jpeg', 'gif'],
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: ' <li>{{fi-progressBar}}</li>',
            progressBar: '<div class="bar"></div>',
        },
        uploadFile: {
            url: ajax_url + 'upload-image.php',
            data: {
            id_product: $('#id_product').val()
            },
            type: 'POST',
            enctype: 'multipart/form-data',
            success: function(response, el){
              try {
                    var data = $.parseJSON(response);
                    var id_product = $('#id_product').val();
                    var rowCount = $('#productImages tbody tr').length + 1;

                if( data.error ){
                message_notif(data.error, {type : "danger"});
              } else if( data.success ){
                message_notif( data.success );
                if( data.images ){
                  $.each(data.images, function(id_image, link) {
                    var tableTR = $('<tr id="'+id_image+'">\
                            <td>\
                                <a class="pop"><img class="img-thumbnail" src="'+link+'" width="80"></a>\
                            </td>\
                            <td align="center" class="pointer">\
                              <span class="fa fa-arrows"></span>\
                              <input disabled type="text" value="'+rowCount+'">\
                            </td>\
                            <td align="center">\
                              <input id="cover_'+id_image+'" type="radio" name="default" class="cover" value="'+id_image+'">\
                              <label for="cover_'+id_image+'"></label>\
                            </td>\
                            <td>\
                                <a class="delete pull-right btn btn-default" data-id="'+id_image+'">\
                                <i class="fa fa-trash"></i> Delete this image</a>\
                            </td>\
                        </tr>');
                        if( $('#productImages > tbody > tr').length > 0 ){
                          $('#productImages > tbody > tr:last').after(tableTR);
                        } else {
                          $('#productImages > tbody').append(tableTR);
                        }
                  });
                }
              }

              set_sortable_height();


              $('.jFiler-input-caption').text( trans("Choose files To Upload", "default") );
                $("#image_product").prop("jFiler").reset();


                }catch (e) {
                    error_message();
                }
            },
            error: function(el){
                message_notif( trans("Unable to send the file.", "default") );
            },
            statusCode: null,
            onProgress: null,
            onComplete: null
        }
      });
    });
    </script>
	


<?php else: ?>
  <div class="alert alert-warning alert-white rounded" id="message">
      <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
      <div class="icon">
          <i class="fa fa-warning"></i>
      </div>
      <?php trans_e("You must save this product before adding images.", "core"); ?>
  </div> 
<?php endif; ?>