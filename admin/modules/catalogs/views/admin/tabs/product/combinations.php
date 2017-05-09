<?php if( isset($id_product) ) : ?>

	<?php if( !is_empty($combinations) ) : ?>
	<div class="alert alert-info">
		<ul>
			<li><?php trans_e("The star icon indicates the default combination.", "default"); ?></li>
			<li><?php trans_e("Each product that has combinations must have one default combination.", "default"); ?></li>
		</ul>
		<p style="margin-top: 8px;"><a class="btn btn-primary" data-id="0" data-toggle="modal" data-target="#comb_form"><i class="fa fa-plus"></i> <?php trans_e("Add new combination", "default"); ?></a></p>
	</div>

	
	<table class="table" id="combinations">
		<thead>
			<tr>
				<th><?php trans_e("Attribute - value pair", "default"); ?></th>
				<th class="center"><?php trans_e("Impact on price", "default"); ?></th>
				<th class="center"><?php trans_e("Impact on weight", "default"); ?></th>
				<th class="center"><?php trans_e("Reference", "default"); ?></th>
				<th class="center"><?php trans_e("EAN-13", "default"); ?></th>
				<th class="center"><?php trans_e("UPC", "default"); ?></th>
				<th class="center"><?php trans_e("Default", "default"); ?></th>
				<th class="center"><?php trans_e("Actions", "default"); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($combinations as $key => $comb) : ?>
			<tr id="<?=$comb->id;?>">
				<td>
					<?php 
						$attrs = get_attributes($comb->id);
						if( !is_empty($attrs) ){
						  $attr_line = '';
						  foreach ($attrs as $key => $attr) {
						    $attr_line .= $attr->attr_name .' - '. $attr->value_name .', ';
						  }
						  echo substr($attr_line, 0, -2);
						}
					?>
				</td>
				<td align="center">
					<?php if($comb->price_impact=="0") : ?>
						<?php trans_e("None", "default"); ?>
					<?php elseif($comb->price_impact=="1") : ?>
						<?=with_currency($comb->price);?> (++)
					<?php else : ?>
						<?=with_currency($comb->price);?> (--)
					<?php endif; ?>
				</td>
				<td align="center">
					<?php if($comb->weight_impact=="0") : ?>
						<?php trans_e("None", "default"); ?>
					<?php elseif($comb->weight_impact=="1") : ?>
						<?=$comb->weight;?> Kg (++)
					<?php else : ?>
						<?=$comb->weight;?> Kg (--)
					<?php endif; ?>
				</td>
				<td align="center"><?=$comb->reference;?></td>
				<td align="center"><?=$comb->ean13;?></td>
				<td align="center"><?=$comb->upc;?></td>
				<td align="center">
					<?php if( $comb->default_dec == "1" ) : ?><i class="fa fa-star"></i><?php endif;?>
				</td>
				<td align="center" width="110">
					<div class="btn-group-action">
					    <div class="btn-group pull-right">
					        <a class="btn btn-default" data-id="<?=$comb->id;?>" data-toggle="modal" data-target="#comb_form">
					        	<i class="fa fa-pencil"></i> <?php trans_e("Edit", "default"); ?>
					        </a> 
					        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i>&nbsp;</button>
					        <ul class="dropdown-menu">
					            <li>
					                <a class="delete_comb" href="" data-id="<?=$comb->id;?>"><i class="fa fa-trash"></i> <?php trans_e("Delete", "default"); ?></a>
					            </li>
					        </ul>
					    </div>
					</div>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php else : ?>
		<div class="col-md-6 col-md-offset-3">
			<h3>No combination for this product.</h3>
		<p style="margin-top: 8px;"><a class="btn btn-primary" data-id="0" data-toggle="modal" data-target="#comb_form"><i class="fa fa-plus"></i> <?php trans_e("Add new combination", "default"); ?></a></p>
		</div>
	<?php endif; ?>


	<!-- Combination Modal -->
	<div class="modal fade" id="comb_form" role="dialog">
		<div class="modal-dialog" style="width: 850px;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php trans_e("ADD OR MODIFY COMBINATIONS FOR THIS PRODUCT", "default"); ?></h4>
				</div>
				<form id="comb-form" class="form-horizontal">
					<div class="modal-body">
						
						<?php 
						$variables = array(
							'attributes' => $attributes, 
							'images' => $images,
							'id_product' => $id_product
						);
						get_view(__FILE__, 'admin/tabs/product/comb-form', $variables ); ?>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-undo"></i> <?php trans_e("Cancel modification", "default"); ?></button>
						<button id="save-comb" type="submit" class="btn btn-primary pull-right"><?php trans_e("Save and Close", "default"); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php else: ?>
	<div class="alert alert-warning alert-white rounded" id="message">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
        <div class="icon">
            <i class="fa fa-warning"></i>
        </div>
        <?php trans_e("You must save this product before adding combinations.", "core"); ?>
    </div> 
<?php endif; ?>