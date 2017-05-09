<input type="hidden" id="id_comb" name="id_comb" value="0">
<input type="hidden" id="id_product" name="comb[id_product]" value="<?=$id_product;?>">
<div class="form-group">
	<label class="col-md-3 control-label" for="attribute_group"><?php trans_e("Attribute", "default"); ?></label>  
	<div class="col-md-3">
		<select class="form-control" id="attribute_group">
			<option value="">---</option>
			<?php foreach ($attributes as $key => $attribute) : ?>
				<option value="<?=$attribute->id;?>"><?=$attribute->name;?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="values_group"><?php trans_e("Value", "default"); ?></label>  
	<div class="col-md-6">
		<select class="form-control" id="values_group" disabled></select>
	</div>
	<div class="col-md-3">
		<a type="button" class="btn btn-default btn-block" onclick="add_attr();"><i class="fa fa-plus-square"></i> <?php trans_e("Add", "default"); ?></a>
	</div>
</div>
<div class="form-group">
	<div class="col-md-6 col-md-offset-3">
		<select id="attributes" style="padding: 5px;" multiple="multiple"></select>
		<input type="hidden" name="attributes" value="" id="json_attributes">
	</div>
	<div class="col-md-3">
		<a type="button" class="btn btn-default btn-block" onclick="del_attr();"><i class="fa fa-minus-square"></i> <?php trans_e("Delete", "default"); ?></a>
	</div>
</div>
<hr>
<div class="form-group">
	<label class="col-md-3 control-label" for="attr_reference"><?php trans_e("Reference code", "default"); ?></label>  
	<div class="col-md-5">
	 <input id="attr_reference" name="comb[reference]" type="text" class="form-control" value="">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="attr_ean13"><?php trans_e("EAN-13 or JAN barcode", "default"); ?></label>  
	<div class="col-md-3">
		<input id="attr_ean13" name="comb[ean13]" type="text" class="form-control" value="">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="attr_upc"><?php trans_e("UPC barcode", "default"); ?></label>  
	<div class="col-md-3">
		<input id="attr_upc" name="comb[upc]" type="text" class="form-control" value="">
	</div>
</div>
<hr>
<div class="form-group">
	<label class="col-md-3 control-label" for="price_impact"><?php trans_e("Impact on price", "default"); ?></label>  
	<div class="col-md-3">
		<select class="form-control" name="comb[price_impact]" id="price_impact" onchange="displayOrHide(this,'attribute_price')">
			<option value="0"><?php trans_e("None", "default"); ?></option>
			<option value="1"><?php trans_e("Increase", "default"); ?></option>
			<option value="2"><?php trans_e("Decrease", "default"); ?></option>
		</select>
	</div>
	<div class="input-group col-md-3 hidden" id="attribute_price">
		<span class="input-group-addon" style="width: 53px;"><?php echo get_currency();?></span>
		<input class="form-control" type="number" min="0" step="0.01" name="comb[price]" value="0" placeholder="0.00">
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="weight_impact"><?php trans_e("Impact on weight", "default"); ?></label>  
	<div class="col-md-3">
		<select class="form-control" name="comb[weight_impact]" id="weight_impact" onchange="displayOrHide(this,'attribute_weight')">
			<option value="0"><?php trans_e("None", "default"); ?></option>
			<option value="1"><?php trans_e("Increase", "default"); ?></option>
			<option value="2"><?php trans_e("Decrease", "default"); ?></option>
		</select>
	</div>
	<div class="input-group col-md-3 hidden" id="attribute_weight">
		<span class="input-group-addon" style="width: 53px;"><?php trans_e("KG", "default"); ?></span>
		<input class="form-control" type="number" min="0" name="comb[unity]" value="0" placeholder="0.00">
	</div>
</div><hr>
<div class="form-group">
	<label class="col-md-3 control-label" for="quantity"><?php trans_e("Quantity", "default"); ?> *</label>  
	<div class="col-md-3">
		<input maxlength="6" name="comb[quantity]" class="form-control" id="quantity" type="number" min="1" value="1" required>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="min_quantity"><?php trans_e("Minimum quantity", "default"); ?> *</label>  
	<div class="col-md-3">
		<input maxlength="6" name="comb[min_quantity]" class="form-control" id="min_quantity" type="number" min="1" value="1" required>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label" for="available_date"><?php trans_e("Availability date", "default"); ?> *</label>  
	<div class="col-md-3">
		<div class="input-group">
			<input class="form-control" id="available_date" name="comb[available_date]" value="<?= date('Y-m-d');?>" type="text" required>
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		</div>
	</div>
</div>

<?php if( !is_empty($images) ) : ?>
<div class="form-group">
	<label class="control-label col-lg-3" for="attribute_default"><?php trans_e("Image", "default"); ?></label>
	<div class="col-lg-9">
		<ul class="list-inline" id="dec_images">
			<?php foreach ($images as $key => $image) : ?>
			<?php $img_src = product_image_by_size($image->name, $id_product, '76x76'); ?>
			<li id="<?=$image->id;?>">
				<label for="<?=$image->id;?>">
					<img src="<?=$img_src;?>" class="img-thumbnail" id="<?=$image->id;?>">
				</label>
				<div class="text-center">
					<span class="btn btn-default">
						<input type="checkbox" value="<?=$image->name;?>" name="comb[images][]">
					</span>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>

<div class="form-group">
	<label class="control-label col-lg-3"><?php trans_e("Default", "default"); ?></label>
	<div class="col-lg-9">
		<p class="checkbox">
		<label for="default_dec">
			<input type="checkbox" name="comb[default_dec]" id="default_dec" value="1">
			<?php trans_e("Make this combination the default combination for this product.", "default"); ?>
		</label>
		</p>
	</div>
</div>