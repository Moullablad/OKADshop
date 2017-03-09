<input type="hidden" name="id_product" id="id_product" value="<?=(isset($product->id)) ? $product->id : '';?>">
<input type="hidden" name="id_lang" class="id_lang" value="<?=$id_lang;?>">

<div class="form-group">
	<label class="col-sm-3 control-label" for="product[type]"><?php trans_e("Type", "default"); ?></label>  
	<div class="col-sm-4 col-md-3">
		<select name="product[type]" class="form-control" id="type">
			<option value="0" <?=(isset($product->type) && $product->type=='0') ? 'selected' : '';?>><?php trans_e("Standard product", "default"); ?></option>
			<option value="1" <?=(isset($product->type) && $product->type=='1') ? 'selected' : '';?>><?php trans_e("Pack of existing products", "default"); ?></option>
			<option value="2" <?=(isset($product->type) && $product->type=='2') ? 'selected' : '';?>><?php trans_e("Virtual product (services, booking, downloadable products, etc.)", "default"); ?></option>
		</select>
	</div>	
</div>

<div class="form-group">
	<label class="col-sm-3 control-label" for="name"><?php trans_e("Name", "default"); ?> *</label>  
	<div class="col-sm-6 col-md-5">
		<input id="name" name="trans[name]" type="text" class="form-control" value="<?=(isset($product->name)) ? $product->name : '';?>" required>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label" for="reference"><?php trans_e("Reference code", "default"); ?></label>  
	<div class="col-sm-3 col-md-2">
		<input id="reference" name="product[reference]" type="text" class="form-control" value="<?=(isset($product->reference)) ? $product->reference : '';?>">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label" for="ean13"><?php trans_e("EAN-13 or JAN barcode", "default"); ?></label>  
	<div class="col-sm-4 col-md-3">
		<input id="ean13" name="product[ean13]" type="text" class="form-control" value="<?=(isset($product->ean13)) ? $product->ean13 : '';?>">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label" for="upc"><?php trans_e("UPC barcode", "default"); ?></label>  
	<div class="col-sm-4 col-md-3">
		<input id="upc" name="product[upc]" type="text" class="form-control" value="<?=(isset($product->upc)) ? $product->upc : '';?>">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label" for="condition"><?php trans_e("Condition", "default"); ?></label>  
	<div class="col-sm-3 col-md-2">
		<select name="product[product_condition]" class="form-control" id="condition">
			<option value="new" selected><?php trans_e("New", "default"); ?></option>
			<option <?=(isset($product->product_condition) && $product->product_condition=='used') ? 'selected' : '';?> value="used"><?php trans_e("Used", "default"); ?></option>
			<option <?=(isset($product->product_condition) && $product->product_condition=='refurbished') ? 'selected' : '';?> value="refurbished"><?php trans_e("Refurbished", "default"); ?></option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" ><?php trans_e("Enabled", "default"); ?></label>  
	<div class="col-sm-3 col-md-2">
		<input type="checkbox" name="product[active]" class="switch" id="active" value="1" <?= (isset($product->active) && $product->active=="1") ? 'checked' : '';?> data-on-text="<?php trans_e("Yes", "default"); ?>" data-off-text="<?php trans_e("No", "default"); ?>" />
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label" for="excerpt"><?php trans_e("Short description", "default"); ?></label>  
	<div class="col-sm-8 col-md-7">
		<textarea class="form-control summernote" name="trans[excerpt]" id="excerpt"><?=(isset($product->excerpt)) ? $product->excerpt : '';?></textarea>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label" for="description"><?php trans_e("Description", "default"); ?></label>  
	<div class="col-sm-8 col-md-7">
		<textarea class="form-control summernote" name="trans[description]" id="description"><?=(isset($product->description)) ? $product->description : '';?></textarea>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label" for="cdate"><?php trans_e("Date", "default"); ?></label>  
	<div class="col-sm-4 col-md-2">
		<div class='input-group datetime'>
	        <input type='text' class="form-control" value="<?=(isset($product->cdate) && $product->cdate!='') ? $product->cdate : date("Y-m-d H:i:s");?>" name="product[cdate]" id="cdate" />
	        <span class="input-group-addon">
	            <span class="glyphicon glyphicon-calendar"></span>
	        </span>
	    </div>
	</div>
</div>

