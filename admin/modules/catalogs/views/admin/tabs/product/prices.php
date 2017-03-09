<?php if( isset($product->id) ) : ?>
	<input type="hidden" name="id_product" id="id_product" value="<?=$product->id; ?>">
	<div class="form-group">
		<label class="col-sm-3 control-label" for="buy_price"><?php trans_e("Buy price (unit)", "default"); ?></label>  
		<div class="col-sm-3 col-md-2">
			<input id="buy_price" name="product[buy_price]" type="number" min="0" step="0.01" value="<?=$product->buy_price; ?>" placeholder="00.00" class="form-control">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label" for="sell_price"><?php trans_e("Sell price (unit)", "default"); ?></label>  
		<div class="col-sm-3 col-md-2">
			<input id="sell_price" name="product[sell_price]" type="number" min="0" step="0.01" value="<?=$product->price_tax_excl; ?>" placeholder="0" class="form-control">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label" for="wholesale_price"><?php trans_e("Unit price (tax excl.)", "default"); ?></label>  
		<div class="col-sm-3 col-md-2">
			<input id="wholesale_price" name="product[wholesale_price]" type="number" min="0" step="0.01" value="<?=$product->wholesale_price; ?>" placeholder="00.00" class="form-control">
		</div>
		<div class="col-sm-3 col-md-2 left0">
			<div class="input-group">
				<div class="input-group-addon"><?php trans_e("Per", "default"); ?></div>
				<input id="wholesale_per_qty" name="product[wholesale_per_qty]" type="number" min="1" value="<?=$product->wholesale_per_qty; ?>" placeholder="1" class="form-control">
				<div class="input-group-addon"><?php trans_e("(unit)", "default"); ?></div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label" for="loyalty_points"><?php trans_e("Loyalty points", "default"); ?></label>  
		<div class="col-sm-3 col-md-2">
			<div class="input-group">
				<input id="loyalty_points" name="product[loyalty_points]" type="number" min="0" step="1" class="form-control" value="<?=$product->loyalty_points; ?>">
				<span class="input-group-btn">
					<select class="btn loyalty_state">
						<option value="0"><?php trans_e("Enabled", "default"); ?></option>
						<option value="1" <?=($product->loyalty_points=="0") ? 'selected' : ''; ?>><?php trans_e("Disabled", "default"); ?></option>
					</select>
				</span>
			</div>
		</div>
	</div><hr>

	<div class="form-group">
		<label class="col-md-3 control-label" for="id_tax"><?php trans_e("Tax rule", "default"); ?></label>  
		<div class="col-sm-4 col-md-3">
			<select class="form-control" id="id_tax" name="product[id_tax]">
				<option value="0" selected><?php trans_e("No Tax", "default"); ?></option>
				<?php if( !is_empty($taxes) ) : ?>
					<?php foreach ($taxes as $key => $tax) : ?>
					<option value="<?=$tax->id;?>" <?= ($product->id_tax==$tax->id ) ? 'selected' : ''; ?> ><?=$tax->name. ' '. $tax->rate .'%'; ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="discount"><?php trans_e("Discount", "default"); ?></label>  
		<div class="col-sm-3 col-md-2">
			<div class="input-group">
				<input name="product[discount]" type="number" min="0" step="0.01" placeholder="0.00" value="<?=$product->discount;?>" class="form-control" id="discount">
				<span class="input-group-addon" style="padding: 0px;border: 0px;">
					<select name="product[discount_type]" id="discount_type" class="form-control" style="width: 70px;">
						<option value="0" selected>%</option>
						<option value="1" <?= ($product->discount_type=="1") ? 'selected' : ''; ?>><?=get_currency();?></option>
					</select>
				</span>
			</div>
		</div>
	</div><hr>

	<div class="form-group">
		<label class="col-md-3 control-label" for="weight"><?php trans_e("Weight", "default"); ?></label>  
		<div class="col-sm-3 col-md-2">
			<div class="input-group">
				<input name="product[weight]" type="number" min="0" step="0.01" placeholder="0.00" value="<?=$product->weight;?>" class="form-control" id="weight">
				<span class="input-group-addon"><?php trans_e("Kg", "default"); ?></span>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="height"><?php trans_e("Height", "default"); ?></label>  
		<div class="col-sm-3 col-md-2">
			<div class="input-group">
				<input name="product[height]" type="number" min="0" step="0.01" placeholder="0.00" value="<?=$product->height; ?>" class="form-control" id="height">
				<span class="input-group-addon"><?php trans_e("cm", "default"); ?></span>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="width"><?php trans_e("Width", "default"); ?></label>  
		<div class="col-sm-3 col-md-2">
			<div class="input-group">
				<input name="product[width]" type="number" min="0" step="0.01" placeholder="0.00" value="<?=$product->width; ?>" class="form-control" id="width">
				<span class="input-group-addon"><?php trans_e("cm", "default"); ?></span>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="depth"><?php trans_e("Depth", "default"); ?></label>  
		<div class="col-sm-3 col-md-2">
			<div class="input-group">
				<input name="product[depth]" type="number" min="0" step="0.01" placeholder="0.00" value="<?=$product->depth; ?>" class="form-control" id="depth">
				<span class="input-group-addon"><?php trans_e("m", "default"); ?></span>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="alert alert-warning alert-white rounded" id="message">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
        <div class="icon">
            <i class="fa fa-warning"></i>
        </div>
        <?php trans_e("You must save this product before adding specific pricing.", "core"); ?>
    </div> 
<?php endif; ?>