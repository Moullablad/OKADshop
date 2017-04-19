<?php if( isset($category->id_category) ) : ?>
	<input type="hidden" name="id_category" id="id_category" value="<?=$category->id_category; ?>">
	<div class="form-group">
		<label class="col-md-3 control-label" for="meta_title"><?php trans_e("Meta title", "cats"); ?></label>  
		<div class="col-md-6">
			<div class="input-group">
				<div class="input-group-addon">70</div>
				<input id="meta_title" name="trans[meta_title]" type="text" value="<?=stripslashes($category->meta_title);?>" class="form-control" maxlength="70">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="meta_description"><?php trans_e("Meta description", "cats"); ?></label>  
		<div class="col-md-6">
			<div class="input-group">
				<div class="input-group-addon">160</div>
				<textarea rows="5" id="meta_description" name="trans[meta_description]" class="form-control" maxlength="160"><?= stripslashes($category->meta_description);?></textarea>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="meta_keywords"><?php trans_e("Meta keywords", "cats"); ?></label>  
		<div class="col-md-6">
			<input id="meta_keywords" name="trans[meta_keywords]" type="text" value="<?=stripslashes($category->meta_keywords);?>" class="form-control tags" maxlength="70">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="link_rewrite"><?php trans_e("Friendly URL", "cats"); ?> *</label>  
		<div class="col-md-6">
			<input id="link_rewrite" name="trans[link_rewrite]" type="text" value="<?=$category->link_rewrite;?>" class="form-control" required>
			<div class="alert alert-warning" style="margin-top: 10px;">
				<p><?php trans_e("The category link will look like this", "cats"); ?></p>
				<strong class="friendly-url"><?=generate_url('category/') . $category->id_category .'-<span>'. $category->link_rewrite;?></span></strong>
			</div>
		</div>
	</div>
<?php else : ?>
	<?php get_view(__FILE__, 'alerts', [
		'warning' => trans("You must save this category before adding seo.", "cats")
	]); ?>
<?php endif; ?>