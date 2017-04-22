<div class="form-group">
	<label class="col-md-3 control-label" for="lang_list"><?php trans_e("Languages", "lang"); ?></label>  
	<div class="col-md-4">
		<select id="lang_list" class="form-control chosen">
			<option value=""><?php trans_e("Choose a language", "lang"); ?></option>
			<?php foreach (get_languages_array() as $key => $value) : 
				$selected = (isset($lang->locale) && $lang->locale==$value['locale']) ? 'selected' : '';
			?>
				<option value="<?php echo $value['locale']; ?>" data-iso_code="<?php echo $value['iso_code']; ?>" data-direction="<?php echo $value['direction']; ?>" data-flag="<?php echo $value['flag']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
			<?php endforeach; ?>
		</select>
		<p class="help-block"><?php trans_e("You can choose a language in the list or directly edit it below.", "lang"); ?></p>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="name"><?php trans_e("Full name", "lang"); ?> *</label>  
	<div class="col-md-4">
		<input id="name" name="name" type="text" value="<?php echo (isset($lang->name)) ? $lang->name : ''; ?>" class="form-control" required>
		<p class="help-block"><?php trans_e("The name is how it is displayed on your site (for example: English).", "lang"); ?></p>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="locale"><?php trans_e("Locale", "lang"); ?> *</label>  
	<div class="col-md-4">
		<input id="locale" name="locale" type="text" value="<?php echo (isset($lang->locale)) ? $lang->locale : ''; ?>" class="form-control" required>
		<p class="help-block"><?php trans_e("Locale for the language (for example: en_US). You will need to install the .mo file for this language.", "lang"); ?></p>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="iso_code"><?php trans_e("Language code", "lang"); ?> *</label> 
	<div class="col-md-4">
		<input id="iso_code" name="iso_code" type="text" value="<?php echo (isset($lang->iso_code)) ? $lang->iso_code : ''; ?>" class="form-control" <?php echo (isset($lang->id)) ? 'disabled' : 'required'; ?> >
		<p class="help-block"><?php trans_e("Language code - preferably 2-letters ISO 639-1 (for example: en)", "lang"); ?></p>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="iso_code"><?php trans_e("Flag", "lang"); ?> *</label> 
	<div class="col-md-4">
		<div id="flag-strap"
			data-input-name="flag"
			data-input-id="flags"
			<?php if(isset($lang->flag)) : ?>
			data-selected-country="<?php echo strtoupper($lang->flag); ?>"
			<?php endif; ?>></div>
		<p class="help-block"><?php trans_e("Choose a flag for the language.", "lang"); ?></p>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="date_format"><?php trans_e("Date format", "lang"); ?> *</label> <div class="col-md-2 pr-0">
		<input id="date_format" name="date_format" type="text" value="<?php echo (isset($lang->date_format)) ? $lang->date_format : 'd/m/Y'; ?>" class="form-control" required>
	</div>
	<div class="col-md-2 pl-0">
		<input id="date_format_preview" type="text" value="<?php echo (isset($lang->date_format)) ? date($lang->date_format) : date('d/m/Y'); ?>" class="form-control" disabled>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="datetime_format"><?php trans_e("Datetime format", "lang"); ?> *</label> <div class="col-md-2 pr-0">
		<input id="datetime_format" name="datetime_format" type="text" value="<?php echo (isset($lang->datetime_format)) ? $lang->datetime_format : 'd/m/Y H:i:s'; ?>" class="form-control" required>
	</div>
	<div class="col-md-2 pl-0">
		<input id="datetime_format_preview" type="text" value="<?php echo (isset($lang->datetime_format)) ? date($lang->datetime_format) : date('d/m/Y H:i:s'); ?>" class="form-control" disabled>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="direction"><?php trans_e("Language Right-to-Left", "lang"); ?></label>  
	<div class="col-md-4">
		<input type="checkbox" name="direction" class="active" id="direction" value="1" <?=(isset($lang->direction) && $lang->direction == '1') ? 'checked' : ''; ?> data-on-text="<?php trans_e('Yes', 'lang'); ?>" data-off-text="<?php trans_e('No', 'lang'); ?>" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="default_lang"><?php trans_e("Default language", "lang"); ?></label>  
	<div class="col-md-4">
		<input type="checkbox" name="default_lang" class="active" id="default_lang" value="1" <?=(isset($lang->default_lang) && $lang->default_lang == '1') ? 'checked' : ''; ?> data-on-text="<?php trans_e('Yes', 'lang'); ?>" data-off-text="<?php trans_e('No', 'lang'); ?>" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="default_lang"><?php trans_e("Active", "lang"); ?></label>  
	<div class="col-md-4">
		<input type="checkbox" name="active" class="active" id="active" value="1" <?=(isset($lang->active) && $lang->active == '1') ? 'checked' : ''; ?> data-on-text="<?php trans_e('Yes', 'lang'); ?>" data-off-text="<?php trans_e('No', 'lang'); ?>" />
	</div>
</div>