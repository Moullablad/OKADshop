<div class="form-group">
	<label class="col-md-3 control-label" for="home_url"><?php trans_e("Home URL", "pref"); ?></label>  
	<div class="col-md-4">
		<input id="home_url" name="shop[home_url]" type="text" value="<?=$shop->home_url;?>" class="form-control">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="domain"><?php trans_e("Domain", "pref"); ?></label>  
	<div class="col-md-3">
		<input id="domain" name="shop[domain]" type="text" value="<?=$shop->domain;?>" class="form-control">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="domain_ssl"><?php trans_e("Domain SSL", "pref"); ?></label>  
	<div class="col-md-3">
		<input id="domain_ssl" name="shop[domain_ssl]" type="text" value="<?=$shop->domain_ssl;?>" class="form-control">
	</div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3" for="ssl_active"><?php trans_e("SSL Active", "pref"); ?> *</label>
    <div class="col-lg-4">
        <input type="checkbox" name="shop[ssl_active]" class="active" id="ssl_active" value="1" <?=($shop->ssl_active=="1") ? 'checked' : '';?> data-on-text="<?php trans_e("YES", "core"); ?>" data-off-text="<?php trans_e("NO", "core"); ?>" />   
    </div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="physical_uri"><?php trans_e("Physical URI", "pref"); ?></label>  
	<div class="col-md-2">
		<input id="physical_uri" name="shop[physical_uri]" type="text" value="<?=$shop->physical_uri;?>" class="form-control">
	</div>
</div>

	



