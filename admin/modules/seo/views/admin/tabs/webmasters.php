<div class="form-group">
	<label class="col-md-3 control-label" for="google"><?php trans_e("Google", "seo"); ?></label>  
	<div class="col-md-3">
		<input name="webmasters[google]" class="form-control" id="google" type="text" value="<?=isset($webmasters->google) ? $webmasters->google : '';?>">
	</div>
	<p class="help-block"><?php trans_e("Google site verification code", "seo"); ?></p>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="client_id"><?php trans_e("Google client ID", "seo"); ?></label>  
	<div class="col-md-3">
		<input name="webmasters[client_id]" class="form-control" id="client_id" type="text" value="<?=isset($webmasters->client_id) ? $webmasters->client_id : '';?>">
	</div>
	<p class="help-block"><?php trans_e("Google signin client ID", "seo"); ?></p>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="bing"><?php trans_e("Bing", "seo"); ?></label>  
	<div class="col-md-3">
		<input name="webmasters[bing]" class="form-control" id="bing" type="text" value="<?=isset($webmasters->bing) ? $webmasters->bing : '';?>">
	</div>
	<p class="help-block"><?php trans_e("Bing site verification code", "seo"); ?></p>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="alexa"><?php trans_e("Alexa", "seo"); ?></label>  
	<div class="col-md-3">
		<input name="webmasters[alexa]" class="form-control" id="alexa" type="text" value="<?=isset($webmasters->alexa) ? $webmasters->alexa : '';?>">
	</div>
	<p class="help-block"><?php trans_e("Alexa site verification code", "seo"); ?></p>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="pinterest"><?php trans_e("Pinterest", "seo"); ?></label>	<div class="col-md-3">
		<input name="webmasters[pinterest]" class="form-control" id="pinterest" type="text" value="<?=isset($webmasters->pinterest) ? $webmasters->pinterest : '';?>">
	</div>
	<p class="help-block"><?php trans_e("Interest site verification code", "seo"); ?></p>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="yandex"><?php trans_e("Yandex", "seo"); ?></label>	<div class="col-md-3">
		<input name="webmasters[yandex]" class="form-control" id="yandex" type="text" value="<?=isset($webmasters->yandex) ? $webmasters->yandex : '';?>">
	</div>
	<p class="help-block"><?php trans_e("Yandex site verification code", "seo"); ?></p>
</div>