<?php if( isset($product->id) ) : ?>
	<input type="hidden" name="id_product" id="id_product" value="<?=$product->id; ?>">
	<input type="hidden" name="id_lang" class="id_lang" value="<?=$product->id_lang;?>">
	<div class="form-group">
		<label class="col-md-3 control-label" for="meta_title"><?php trans_e("Meta title", "default"); ?></label>  
		<div class="col-md-6">
			<div class="input-group">
				<div class="input-group-addon">70</div>
				<input id="meta_title" name="trans[meta_title]" type="text" value="<?=stripslashes($product->meta_title);?>" class="form-control" maxlength="70">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="meta_description"><?php trans_e("Meta description", "default"); ?></label>  
		<div class="col-md-6">
			<div class="input-group">
				<div class="input-group-addon">160</div>
				<textarea rows="5" id="meta_description" name="trans[meta_description]" class="form-control" maxlength="160"><?= stripslashes($product->meta_description);?></textarea>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="meta_keywords"><?php trans_e("Meta keywords", "default"); ?></label>  
		<div class="col-md-6">
			<input id="meta_keywords" name="trans[meta_keywords]" type="text" value="<?=stripslashes($product->meta_keywords);?>" class="form-control" maxlength="70">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="link_rewrite"><?php trans_e("Friendly URL", "default"); ?> *</label>  
		<div class="col-md-6">
			<input id="link_rewrite" name="trans[link_rewrite]" type="text" value="<?=$product->link_rewrite;?>" class="form-control" required>
			<div class="alert alert-warning" style="margin-top: 10px;">
				<p><?php trans_e("The product link will look like this", "default"); ?></p>
				<strong class="friendly-url"><?=generate_url('product/') . $product->id .'-<span>'. $product->link_rewrite;?></span></strong>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="alert alert-warning alert-white rounded" id="message">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
        <div class="icon">
            <i class="fa fa-warning"></i>
        </div>
        <?php trans_e("You must save this product before adding seo.", "core"); ?>
    </div>
<?php endif; ?>