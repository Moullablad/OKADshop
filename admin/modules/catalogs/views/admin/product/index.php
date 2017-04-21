<?php
/**
 * 2016 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 OKADshop
 */

?>
<div class="top-menu padding0">
    <div class="top-menu-title">
        <h3><i class="fa fa-tags"></i> <?php trans_e("Products", "default"); ?></h3>
    </div>
	<div class="top-menu-button">
        <a class="btn btn-primary" href="?module=catalogs&page=add"><?php trans_e("Add a Product", "default"); ?></a>
    </div>
</div>

<?php if( !is_empty($products) ) : ?>
<div class="table-responsive">
<table cellspacing="0" class="table table-striped table-bordered" id="datatable" width="100%">
    <thead>
        <tr>
            <td><?php trans_e("ID", "default"); ?></th>
			<td><?php trans_e("Image", "default"); ?></th>
			<td><?php trans_e("Name", "default"); ?></th>
			<td><?php trans_e("Reference", "default"); ?></th>
			<td><?php trans_e("Default Category", "default"); ?></th>
			<td><?php trans_e("Sell price", "default"); ?></th>
			<td><?php trans_e("Buy price", "default"); ?></th>
			<td><?php trans_e("Quantity", "default"); ?></th>
			<td><?php trans_e("Status", "default"); ?></th>
			<td width="80"><?php trans_e("Actions", "default"); ?></th>
        </tr>
    </thead>
    <tbody>
    	<?php foreach ($products as $key => $product) : ?>
        <tr>
            <td width="10"><?= $product->id_product; ?></td>
            <td width="80">
            	<img src="<?= product_image_by_size($product->cover_name, $product->id_product, '76x76'); ?>" width="80">
            </td>
            <td><?= $product->name; ?></td>
            <td><?= $product->reference; ?></td>
            <td><?= $product->category; ?></td>
            <td><?= $product->sell_price; ?></td>
            <td><?= $product->buy_price; ?></td>
            <td><?= $product->quantity; ?></td>
            <td align="center">
            	<?php if( $product->active == '1' ) : ?>
	           		<i class="fa fa-check-circle"></i>
	           	<?php else : ?>
	           		<i class="fa fa-times" style="color: #d9534f;"></i>
	           	<?php endif; ?>
            </td>
            <td>
            	<div class="btn-group-action">
				    <div class="btn-group pull-right">
				        <a class="edit btn btn-default" href="?module=catalogs&page=edit&id=<?= $product->id_product; ?>" title="Edit"><i class="fa fa-pencil"></i> <?php trans_e("Edit", "default"); ?></a>
				        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i>&nbsp;</button>
				        <ul class="dropdown-menu">
				        	<li><a href="<?= $product->link; ?>" title="<?php trans_e("Preview", "default"); ?>" target="_blank"><i class="fa fa-eye"></i> <?php trans_e("Preview", "default"); ?></a></li>
							<li class="divider"></li>
				            <li>
				                <a class="deleteProduct" data-id="<?= $product->id_product; ?>" href="#" title="<?php trans_e("Delete", "default"); ?>"><i class="fa fa-trash"></i> <?php trans_e("Delete", "default"); ?></a>
				            </li>
				        </ul>
				    </div>
				</div>
            </td>
        </tr>
	    <?php endforeach; ?>
	</tbody>
</table>
</div>

<?php else : ?>
	<div class="alert alert-info">
		<h3><?php trans_e("No item found.", "default"); ?></h3>
		<p>
			<?php trans_e("There is no product.", "default"); ?>
			<a href="?module=catalogs&page=add" class="btn btn-primary"><?php trans_e("Create a product", "default"); ?></a>
		</p>
	</div>
<?php endif; ?>
