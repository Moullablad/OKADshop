<div class="form-group">
	<label class="col-md-3 control-label" for="meta_title"><?php trans_e("Meta title", "default"); ?></label>  
	<div class="col-md-6">
		<div class="input-group">
			<div class="input-group-addon"><?=$max_title?></div>
			<input id="meta_title" name="trans[meta_title]" type="text" value="<?=stripslashes($shop->meta_title);?>" class="form-control" maxlength="<?=$max_title?>">
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="meta_description"><?php trans_e("Meta description", "default"); ?></label>  
	<div class="col-md-6">
		<div class="input-group">
			<div class="input-group-addon"><?=$max_desc?></div>
			<textarea rows="5" id="meta_description" name="trans[meta_description]" class="form-control" maxlength="160"><?= stripslashes($shop->meta_description);?></textarea>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="meta_keywords"><?php trans_e("Meta keywords", "default"); ?></label>  
	<div class="col-md-6">
		<input id="meta_keywords" name="trans[meta_keywords]" type="text" value="<?=stripslashes($shop->meta_keywords);?>" class="form-control" maxlength="<?=$max_desc?>">
	</div>
</div>