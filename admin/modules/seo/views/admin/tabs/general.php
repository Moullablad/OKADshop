<div class="panel-subheading">
	<i class="fa fa-pencil"></i>
	<strong><?php trans_e("Title", "seo"); ?></strong>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="separator"><?php trans_e("Separator", "seo"); ?> *</label>  
	<div class="col-md-3">
		<input name="general[title][separator]" class="form-control" id="separator" type="text" value="<?=isset($general->title->separator) ? $general->title->separator : '-';?>" required>
	</div>
	<p class="help-block"><?php trans_e("Chose separator, default:", "seo"); ?> (-)</p>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="max"><?php trans_e("Max", "seo"); ?> *</label>  
	<div class="col-md-3">
		<input name="general[title][max]" class="form-control" id="max" type="number" step="1" value="<?=isset($general->title->max) ? $general->title->max : '55';?>" required>
	</div>
	<p class="help-block"><?php trans_e("Max title length, default:", "seo"); ?> (55)</p>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="position"><?php trans_e("Position", "seo"); ?></label>  
	<div class="col-sm-3 col-md-2">
		<input type="checkbox" name="general[title][position]" class="switch" id="position" value="1" <?= (isset($general->title->position) && $general->title->position=="1") ? 'checked' : '';?> data-on-text="<?php trans_e("Left", "seo"); ?>" data-off-text="<?php trans_e("Right", "seo"); ?>" />
	</div>
</div>


<div class="panel-subheading">
	<i class="fa fa-list"></i>
	<strong><?php trans_e("Description", "seo"); ?></strong>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="max"><?php trans_e("Max", "seo"); ?> *</label>  
	<div class="col-md-3">
		<input name="general[description][max]" class="form-control" id="max" type="number" step="1" value="<?=isset($general->description->max) ? $general->description->max : '155';?>" required>
	</div>
	<p class="help-block"><?php trans_e("Max description length, default:", "seo"); ?> (155)</p>
</div>


<div class="panel-subheading">
	<i class="fa fa-tags"></i>
	<strong><?php trans_e("Keywords", "seo"); ?></strong>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="keywords"><?php trans_e("Keywords", "default"); ?></label>  
	<div class="col-md-6">
		<input id="meta_keywords" name="general[keywords]" type="text" value="<?=($general->keywords!='' ) ? $general->keywords : '';?>" class="form-control" maxlength="70">
	</div>
</div>


<div class="panel-subheading">
	<i class="fa fa-info-circle"></i>
	<strong><?php trans_e("Miscellaneous", "seo"); ?></strong>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="canonical"><?php trans_e("Canonical", "seo"); ?></label>  
	<div class="col-sm-3 col-md-2">
		<input type="checkbox" name="general[misc][canonical]" class="switch" id="canonical" value="1" <?= (isset($general->misc->canonical) && $general->misc->canonical=="1") ? 'checked' : '';?> data-on-text="<?php trans_e("Yes", "seo"); ?>" data-off-text="<?php trans_e("No", "seo"); ?>" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="robots"><?php trans_e("Robots", "seo"); ?> *</label>  
	<div class="col-md-3">
		<input name="general[misc][robots]" class="form-control" id="robots" type="text" value="<?=isset($general->misc->robots) ? $general->misc->robots : 'index, follow';?>" required>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="viewport"><?php trans_e("Viewport", "seo"); ?></label>  
	<div class="col-md-3">
		<input name="general[misc][viewport]" class="form-control" id="viewport" type="text" value="<?=isset($general->misc->viewport) ? $general->misc->viewport : 'width=device-width, initial-scale=1';?>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="author"><?php trans_e("Author", "seo"); ?></label>  
	<div class="col-md-3">
		<input name="general[misc][author]" class="form-control" id="author" type="text" value="<?=isset($general->misc->author) ? $general->misc->author : '';?>">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="copyright"><?php trans_e("Copyright", "seo"); ?></label>
	<div class="col-md-3">
		<input name="general[misc][copyright]" class="form-control" id="copyright" type="text" value="<?=isset($general->misc->copyright) ? $general->misc->copyright : '';?>" placeholder="<?=site_url('terms');?>">
	</div>
	<p class="help-block"><?php trans_e("Provide author name or link to page contain copyrights.", "seo"); ?></p>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="publisher"><?php trans_e("Publisher", "seo"); ?></label>  
	<div class="col-md-3">
		<input name="general[misc][publisher]" class="form-control" id="publisher" type="text" value="<?=isset($general->misc->publisher) ? $general->misc->publisher : '';?>" placeholder="+OKADshop">
	</div>
	<p class="help-block">https://plus.google.com/[<?php trans_e("YOUR PERSONAL G+ PROFILE HERE", "seo"); ?>]</p>
</div>

