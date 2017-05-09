<div class="form-group">
    <label class="control-label col-lg-3" for="name"><?php trans_e("Shop name", "pref"); ?> *</label>
    <div class="col-lg-4">
        <input type="text" name="trans[name]" id="name" value="<?=$shop->name;?>" class="form-control" required autofocus>     
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3" for="tagline"><?php trans_e("Tagline", "pref"); ?></label>
    <div class="col-lg-4">
        <input type="text" name="trans[tagline]" id="tagline" value="<?=$shop->tagline;?>" class="form-control">     
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3" for="address1"><?php trans_e("Address", "pref"); ?></label>
    <div class="col-lg-4">
        <input type="text" name="shop[address1]" id="address1" value="<?=$shop->address1;?>" class="form-control" required>     
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3" for="address2"><?php trans_e("Address (line 2)", "pref"); ?></label>
    <div class="col-lg-4">
        <input type="text" name="shop[address2]" id="address2" value="<?=$shop->address2;?>" class="form-control">     
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3" for="zip_code"><?php trans_e("ZIP/Postal code", "pref"); ?></label>
    <div class="col-lg-4">
        <input type="text" name="shop[zip_code]" id="zip_code" value="<?=$shop->zip_code;?>" class="form-control">     
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3" for="city"><?php trans_e("City", "pref"); ?></label>
    <div class="col-lg-4">
        <input type="text" name="shop[city]" id="city" value="<?=$shop->city;?>" class="form-control">     
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3" for="country"><?php trans_e("Country", "pref"); ?> *</label>
    <div class="col-lg-4">
        <select name="shop[id_country]" class="form-control" id="country" required>
            <option value="" style="font-weight: bold"><?php trans_e("Choose a country", "pref"); ?></option>
            <?php if( !empty($countries) ) : foreach ($countries as $key => $country) : ?>
                <?php $selected = ($shop->id_country==$country->id) ? "selected" : ""; ?>
                <option value="<?=$country->id;?>" <?=$selected;?>><?php trans_e($country->name, "core"); ?></option>
            <?php endforeach; endif; ?>
        </select>  
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3" for="fax"><?php trans_e("Home phone", "pref"); ?></label>
    <div class="col-lg-4">
        <input type="text" name="shop[fax]" id="fax" value="<?=$shop->fax;?>" class="form-control">     
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3" for="phone"><?php trans_e("Mobile phone", "pref"); ?></label>
    <div class="col-lg-4">
        <input type="text" name="shop[phone]" id="phone" value="<?=$shop->phone;?>" class="form-control">     
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3" for="email"><?php trans_e("Email", "pref"); ?></label>
    <div class="col-lg-4">
        <input type="text" name="shop[email]" id="email" value="<?=$shop->email;?>" class="form-control">     
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3" for="immatriculation"><?php trans_e("Matriculation", "pref"); ?></label>
    <div class="col-lg-4">
        <input type="text" name="shop[immatriculation]" id="immatriculation" value="<?=$shop->immatriculation;?>" class="form-control">     
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3"><?php trans_e("GPS coordinates", "pref"); ?></label>
    <div class="col-lg-2 col-sm-3">
        <input placeholder="33.968198" type="text" name="shop[latitude]" id="latitude" value="<?=$shop->latitude;?>" class="form-control">
    </div>
    <div class="col-lg-2 col-sm-3">
        <input placeholder="-6.860241" type="text" name="shop[longitude]" id="longitude" value="<?=$shop->longitude;?>" class="form-control">
    </div>
</div>