<input type="hidden" name="id_category" id="id_category" value="<?=(isset($category->id_category)) ? $category->id_category : 0; ?>">
<?php if( get_url_param('id') != 1 ) : ?>
<div class="form-group">
	<label class="col-md-3 control-label" for="id_parent"><?php trans_e("Parent", "cats"); ?> *</label>  
	<div class="col-md-4">
		<select class="form-control" name="category[id_parent]" id="id_parent" required>
			<?php if(!empty($cats)) : foreach ($cats as $key => $cat) : 
				$selected = (isset($category->id_parent) && $category->id_parent==$cat->id_category) ? 'selected' : '';
			?>
				<option value="<?php echo $cat->id_category; ?>" <?php echo $selected; ?>><?php echo $cat->name; ?></option>
			<?php endforeach; endif; ?>
		</select>
	</div>
</div>
<?php endif; ?>
<div class="form-group">
	<label class="col-md-3 control-label" for="name"><?php trans_e("Name", "cats"); ?> *</label>  
	<div class="col-md-4">
		<input id="name" name="trans[name]" type="text" value="<?php echo (isset($category->name)) ? $category->name : ''; ?>" class="form-control" maxlength="70" required>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="description"><?php trans_e("Description", "cats"); ?></label>  
	<div class="col-md-6">
		<textarea rows="5" id="description" class="form-control" name="trans[description]"><?php echo (isset($category->description)) ? $category->description : ''; ?></textarea>
	</div>
</div>
<?php if( get_url_param('id') != 1 ) : ?>
<div class="form-group">
	<label class="col-md-3 control-label" for="active"><?php trans_e("Active", "cats"); ?></label>  
	<div class="col-md-4">
		<input type="checkbox" name="category[active]" class="active" id="active" value="1" <?=(isset($category->active) && $category->active == '1') ? 'checked' : ''; ?> data-on-text="<?php trans_e('Yes', 'cats'); ?>" data-off-text="<?php trans_e('No', 'cats'); ?>" />
	</div>
</div>
<?php else : ?>
	<input type="hidden" name="category[active]" value="1">
<?php endif; ?>