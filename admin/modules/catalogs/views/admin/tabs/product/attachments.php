<?php if( isset($id_product) ) : ?>

	<form class="form-horizontal" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id_product" id="id_product" value="<?=$id_product; ?>">

		<div class="form-group">
			<label class="col-md-3 control-label" for="attachment_name"><?php trans_e("Filename *", "default"); ?></label><div class="col-md-6">
				<input type="text" name="attachment[name]" id="attachment_name" value="" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="description"><?php trans_e("Description", "default"); ?></label>  
			<div class="col-md-6">
				<textarea rowspan="5" id="description" name="attachment[description]" class="form-control"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="files"><?php trans_e("File", "default"); ?></label>  
			<div class="col-md-6">
				<input type="file" name="files" id="files" class="attachments">	
				<strong style="margin-top: 10px;display: block;"><?php trans_e("Upload a file from your computer", "default"); ?> (<?=_MAX_SIZE_;?> <?php trans_e("max.", "default"); ?>)</strong>
				<small><?php trans_e("Authorized formats :", "default"); ?> .jpg, .gif, .png, .doc, .ppt, .odt, .docx, .xlsx, .pptx, .psd , .rar, .zip</small>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-3">
				<button type="submit" name="attachments_form" class="btn btn-success"><i class="fa fa-cloud-upload"></i> <?php trans_e("Upload attachment", "default"); ?></button>
			</div>
		</div>
	</form>


	<div class="panel-subheading">
		<i class="fa fa-file"></i>
		<strong><?php trans_e("Attached file list.", "default"); ?></strong>
	</div>
	<div class="table-responsive">
		<table class="table" id="attachments">
			<thead>
				<tr class="nodrag nodrop">
					<th width="200"><?php trans_e("Filename", "default"); ?></th>
					<th><?php trans_e("Description", "default"); ?></th>
					<th width="105"><?php trans_e("Actions", "default"); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if(!empty($attachments)) : ?>
					<?php foreach ($attachments as $key => $file) : ?>
					<tr id="<?=$file->id;?>">
						<td><?=$file->name;?></td>
						<td><?=$file->description;?></td>
						<td><a href="javascript:;" id="<?=$file->id;?>" data-attachment="<?=$file->attachment;?>" class="btn btn-danger delete_att"><i class="fa fa-trash"></i> <?php trans_e("Delete", "default"); ?></a></td>
					</tr>	
					<?php endforeach; ?>
				<?php else : ?>
				<tr>
					<td colspan="6">
						<center>
							<i class="fa fa-warning fa-4x"></i><br> 
							<?php trans_e("No attachment found.", "default"); ?>
						</center>
					</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	


<?php else: ?>
	<div class="alert alert-warning alert-white rounded" id="message">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
        <div class="icon">
            <i class="fa fa-warning"></i>
        </div>
        <?php trans_e("You must save this product before adding attachments.", "core"); ?>
    </div>
<?php endif; ?>