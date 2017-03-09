

<?php foreach ($css as $key => $value): ?>
	<?php if (!isset($value->protected)): ?>
		<div class="form-group">
			<label class="col-md-3 control-label" for="<?= $key ?>"><?= $key ?> </label><div class="col-md-3">
				<div class="input-group colorpicker-component colorpicker">
				    <input type="text" name="css[<?= $key; ?>]" value="<?= $value->value; ?>" class="form-control" id="<?= $key; ?>" />
				    <span class="input-group-addon"><i></i></span>
				</div>
			</div>
		</div>
	<?php endif ?>
	
<?php endforeach ?>
