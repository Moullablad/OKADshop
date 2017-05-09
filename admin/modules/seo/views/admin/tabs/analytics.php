<div class="form-group">
	<label class="col-md-3 control-label" for="code"><?php trans_e("Analytics Code", "seo"); ?></label>
	<div class="col-md-3">
		<input name="analytics[code]" class="form-control" id="code" type="text" value="<?=isset($analytics->code) ? $analytics->code : '';?>">
	</div>
	<p class="help-block"><?php trans_e("EX: UA-XXXXXXXX-X", "seo"); ?></p>
</div>

