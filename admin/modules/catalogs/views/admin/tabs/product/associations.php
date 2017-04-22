<script src="<?=site_url();?>assets/vendors/multinestedlists/tree.js" type="text/javascript" position="12"></script>
<?php if( isset($product->id_product) ) : ?>
	<input type="hidden" name="id_product" id="id_product" value="<?=$product->id_product; ?>">
	<div class="alert alert-info">
		<strong><?php trans_e("Radio Button", "core"); ?></strong> for default category and <strong>And Checkbox</strong> for product associations.
	</div>
	<div class="col-md-6 col-md-offset-3" id="tree">
		<?php 
		$ids = array();
		foreach ($categories as $key => $category) {
			$ids[] = $category->id_category;
		}
		$cat_tree = category_tree(0);
		$cat_default = $product->id_category_default;
		echo make_list($cat_tree, $ids, $cat_default);
		?>
	</div>
<?php else: ?>
	<div class="alert alert-warning alert-white rounded" id="message">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
        <div class="icon">
            <i class="fa fa-warning"></i>
        </div>
        <?php trans_e("You must save this product before adding associations.", "core"); ?>
    </div> 
<?php endif; ?>


<!--div class="form-group">
	<label class="col-md-3 control-label" for="sell_price"><?//=l("Catégories associées", "default");?></label>  
	<div class="col-md-6">
		<div class="assoc_categories">
			<div class="panel panel-custom" style="border-bottom: 0px none;margin-bottom: 0px;">
				<div class="panel-heading">
					<a onclick="colapse_all(); return false;" class="btn btn-default"><i class="fa fa-minus-square"></i> <?//=l("Réduire tout", "default");?></a>
					<a onclick="develope_all(); return false;" class="btn btn-default"><i class="fa fa-minus-square"></i> <?//=l("Ouvrire tout", "default");?></a>
					<a onclick="checkAllCategories(); return false;" class="btn btn-default"><i class="fa fa-check-square"></i> <?//=l("Tout cocher", "default");?></a>
					<a onclick="uncheckAllCategories(); return false;" class="btn btn-default"><i class="fa fa-square-o"></i> <?//=l("Tout décocher", "default");?></a>
				</div>
				<div class="panel-body">
					<?php //echo $os_product->getCategories(0,$cat_list);?>
				</div>
			</div>
		</div>
	</div>
</div-->