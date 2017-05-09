<div class="form-group">
	<label class="col-md-3 control-label" for="image"><?php trans_e("Default image", "themes"); ?></label>  
	<div class="col-md-3">
		<div class="input-group file-upload">
	        <input type="text" class="form-control" readonly>
	        <label class="input-group-btn">
	            <span class="btn btn-primary">
	                <?php trans_e("Browse", "themes"); ?> 
	                <input type="file" name="image" id="image" accept="image/*">
	            </span>
	        </label>
	    </div>
	    <p class="help-block"><?php trans_e("Image should be at least 200px in both dimensions, with 1500x1500 preferred. (Maximum image size is 5MB.)", "seo"); ?></p>
		<?php if($og->image != '') : ?>
			<img src="<?php echo site_url() . $og->image;?>" class="img-thumbnail">
		<?php endif; ?>	
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="enabled"><?php trans_e("Enabled", "seo"); ?></label>  
	<div class="col-sm-3 col-md-2">
		<input type="checkbox" name="og[enabled]" class="switch" id="enabled" value="1" <?= (isset($og->enabled) && $og->enabled=="1") ? 'checked' : '';?> data-on-text="<?php trans_e("Yes", "seo"); ?>" data-off-text="<?php trans_e("No", "seo"); ?>" />
	</div>
</div>
<!--div class="form-group">
	<label class="col-md-3 control-label" for="prefix"><?php //trans_e("Prefix", "seo"); ?></label>  
	<div class="col-md-3">
		<input name="og[prefix]" class="form-control" id="prefix" type="text" value="<?//=isset($og->prefix) ? $og->prefix : 'og:';?>">
	</div>
</div-->
<div class="form-group">
	<label class="col-md-3 control-label" for="type"><?php trans_e("Type", "seo"); ?></label>  
	<div class="col-md-3">
		<input name="og[type]" class="form-control" id="type" type="text" value="<?=isset($og->type) ? $og->type : 'website';?>">
	</div>
</div>
