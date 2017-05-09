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
	    <p class="help-block"><?php trans_e("Default Image. (Maximum image size is 5MB.)", "seo"); ?></p>
		<?php if($twitter->image != '') : ?>
			<img src="<?php echo site_url() . $twitter->image;?>" class="img-thumbnail">
		<?php endif; ?>	
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="enabled"><?php trans_e("Enabled", "seo"); ?></label>  
	<div class="col-sm-3 col-md-2">
		<input type="checkbox" name="twitter[enabled]" class="switch" id="enabled" value="1" <?= (isset($twitter->enabled) && $twitter->enabled=="1") ? 'checked' : '';?> data-on-text="<?php trans_e("Yes", "seo"); ?>" data-off-text="<?php trans_e("No", "seo"); ?>" />
	</div>
</div>
<!--div class="form-group">
	<label class="col-md-3 control-label" for="prefix"><?php trans_e("Prefix", "seo"); ?></label>  
	<div class="col-md-3">
		<input name="twitter[prefix]" class="form-control" id="prefix" type="text" value="<?//=isset($twitter->prefix) ? $twitter->prefix : 'twitter:';?>">
	</div>
</div-->
<div class="form-group">
	<label class="col-md-3 control-label" for="card"><?php trans_e("Card", "seo"); ?></label>  
	<div class="col-md-3">
		<input name="twitter[card]" class="form-control" id="card" type="text" value="<?=isset($twitter->card) ? $twitter->card : 'summary';?>">
	</div>
	<p class="help-block"><?php trans_e("Supported card types : 'app', 'gallery', 'photo', 'player', 'product', 'summary', 'summary_large_image'.", "seo"); ?></p>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="site"><?php trans_e("Site", "seo"); ?></label>  
	<div class="col-md-3">
		<input name="twitter[site]" class="form-control" id="prefix" type="text" value="<?=isset($twitter->site) ? $twitter->site : '';?>">
	</div>
	<p class="help-block"><?php trans_e("Username EX: @okadshop.", "seo"); ?></p>
</div>

