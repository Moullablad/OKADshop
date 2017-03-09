<div class="form-group">
	<label class="col-md-3 control-label" for="logo"><?php trans_e("Logo", "themes"); ?> *</label>  
	<div class="col-md-3">
		<div class="input-group file-upload">
	        <input type="text" class="form-control" readonly>
	        <label class="input-group-btn">
	            <span class="btn btn-primary">
	                <?php trans_e("Browse", "themes"); ?> 
	                <input type="file" name="logo" id="logo" accept="image/*">
	            </span>
	        </label>
	        
	    </div>
	</div>
</div>
<?php if($identity->logo != '') : ?>
<div class="form-group">
	<div class="col-md-3 col-md-offset-3">
		<img src="<?php echo site_url() . $identity->logo;?>" width="90" class="img-thumbnail">
	</div>
</div>
<?php endif; ?>	        	
<div class="form-group">
	<label class="col-md-3 control-label" for="favicon"><?php trans_e("Favicon", "themes"); ?> *</label>  
	<div class="col-md-3">
		<div class="input-group file-upload">
	        <input type="text" class="form-control" readonly>
	        <label class="input-group-btn">
	            <span class="btn btn-primary">
	                <?php trans_e("Select Image", "themes"); ?> 
	                <input type="file" name="favicon" id="favicon" accept="image/*">
	            </span>
	        </label>
	    </div>
	</div>
</div>
<?php if($identity->favicon != '') : ?>
<div class="form-group">
	<div class="col-md-3 col-md-offset-3">
		<img src="<?php echo site_url() . $identity->favicon;?>" width="90" class="img-thumbnail">
	</div>
</div>
<?php endif; ?>	
<!--div class="form-group">
	<label class="col-md-3 control-label" for="title"><?php trans_e("Site Title", "themes"); ?> *</label>  
	<div class="col-md-3">
		<input name="title" class="form-control" id="title" type="text" value="<?php echo $identity->title;?>" required>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="tagline"><?php trans_e("Tagline", "themes"); ?> *</label>  
	<div class="col-md-3">
		<input name="tagline" class="form-control" id="tagline" type="text" value="<?php echo $identity->tagline;?>" required>
	</div>
</div-->