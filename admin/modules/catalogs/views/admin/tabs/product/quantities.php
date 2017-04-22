<?php if( isset($product->id_product) ) : ?>
	<input type="hidden" name="id_product" id="id_product" value="<?=$product->id_product; ?>">
	<input type="hidden" id="json_quantities" name="quantities" value="">

	<div class="form-group">
		<label class="col-sm-3 control-label" for="quantity"><?php trans_e("Available quantities", "default"); ?> *</label>  
		<div class="col-sm-4 col-md-3">
			<input id="quantity" name="product[quantity]" type="number" min="0" step="1" value="<?=$product->quantity; ?>" placeholder="0" class="form-control" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="quantity"><?php trans_e("Min quantity", "default"); ?> *</label>  
		<div class="col-sm-4 col-md-3">
			<input id="min_quantity" name="product[min_quantity]" type="number" min="1" step="1" value="<?=$product->min_quantity; ?>" placeholder="1" class="form-control" required>
		</div>
	</div>


	<div class="table-responsive col-sm-6 col-md-5 col-lg-offset-3">
	<table class="table" id="quantities">
		<thead>
			<tr>
				<th width="120">Quantity</th>
				<th width="10"></th>
				<th>Designation</th>
			</tr>
		</thead>
		<tbody>
		<?php if( !is_empty($combinations) ) : ?>
			<?php foreach ($combinations as $key => $comb) : ?>
			<tr id="<?=$comb->id;?>">
				<td><input type="number" min="0" name="comb_qty[]" placeholder="0" value="<?=$comb->quantity;?>" class="form-control qty" onchange="genQuantities();" required></td>
				<td></td>
				<td><?php 
					$data_comb = get_attributes($comb->id);
					if( !empty($data_comb) ){
					  $attr_string = '';
					  foreach ($data_comb as $key => $data) {
					    $attr_string .= $data->attr_name .' - '. $data->value_name .', ';
					  }
					  echo substr($attr_string, 0, -2);
					}
				?></td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
	</div>

<?php else: ?>
	<div class="alert alert-warning">
		<h4><?php trans_e("There is 1 warning.", "default"); ?></h4>
		<?php trans_e("You must save this product before adding combinations.", "default"); ?>
	</div>
<?php endif; ?>