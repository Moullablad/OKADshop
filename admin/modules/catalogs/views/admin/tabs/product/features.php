<?php if( isset($id_product) ) : ?>

	<input type="hidden" name="id_product" id="id_product" value="<?=$id_product; ?>">
	<input type="hidden" name="id_lang" class="id_lang" value="<?=$id_lang;?>">

	<!-- Features Json -->
	<input type="hidden" name="features" value='<?=$json_features;?>' id="json_features">
	<input type="hidden" name="features_ids" value="" id="features_ids">
	
	<div class="alert alert-info">
		<h4><?php trans_e("Assign features to this product", "default"); ?></h4>
		<p><?php trans_e("Select Predefined values or set your Customized values.", "default"); ?></p>
	</div>

	<div class="table-responsive">
	<table class="table" id="features">
		<thead>
			<tr>
				<th><?php trans_e("Feature", "default"); ?></span></th>
				<th><?php trans_e("Pre-defined value", "default"); ?></span></th>
				<th><u><?php trans_e("or", "default"); ?></u> <?php trans_e("Customized value", "default"); ?></th>
				<th style="width: 60px;"><?php trans_e("Actions", "default"); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if( !empty($features) ) : ?>
			<?php foreach ($features as $key => $feature) : 
			$values = get_feature_values($feature->id, $id_lang);
			$f = get_product_features($feature->id, $id_product);
			$id_value = (isset($f->id_feature_value)) ? $f->id_feature_value : 0;
			$custom = (isset($f->custom)) ? $f->custom : 0;
			?>
				<tr>
					<td id="<?=$feature->id;?>"><?=$feature->name;?></td>
					<td>
						<select onchange="gen_features_json();" class="form-control" <?=(is_empty($values)) ? 'disabled' : '';?>>
							<option value="">---</option>
							<?php if(!empty($values)) : foreach ($values as $key => $value) : 
							$selected = ($id_value==$value->id_value ) ? 'selected' : '';
							?>
								<option value="<?=$value->id_value;?>" <?=$selected;?>><?=$value->value;?></option>
							<?php endforeach; endif; ?>
						</select>
					</td>
					<td><input onchange="gen_features_json();" type="text" value="<?=(isset($custom) && $custom != '') ? $custom : '';?>" class="form-control"></td>

					<td><a href="javascript:;" class="btn btn-danger clear"><i class="fa fa-undo"></i> <?php trans_e("Reset", "default"); ?></a></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
	</div>



<?php else: ?>
	<div class="alert alert-warning alert-white rounded" id="message">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
        <div class="icon">
            <i class="fa fa-warning"></i>
        </div>
        <?php trans_e("You must save this product before adding features.", "core"); ?>
    </div> 
<?php endif; ?>