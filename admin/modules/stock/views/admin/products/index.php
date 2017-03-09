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
    <?php if( !is_empty($products) ) : foreach ($products as $key => $product) : ?>
        <tr>
            <td width="10"><?= $product->id; ?></td>
            <td width="80">
            	<img src="<?= $product->cover; ?>" width="80">
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
				        <a class="edit btn btn-default" href="<?=get_page_url('products&action=edit&id='. $product->id, __FILE__); ?>" title="Edit"><i class="fa fa-pencil"></i> <?php trans_e("Edit", "default"); ?></a>
				        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i>&nbsp;</button>
				        <ul class="dropdown-menu">
				        	<li><a href="<?= $product->link; ?>" title="<?php trans_e("Preview", "default"); ?>" target="_blank"><i class="fa fa-eye"></i> <?php trans_e("Preview", "default"); ?></a></li>
							<li class="divider"></li>
				            <li>
				            	<a class="deleteAction" href="<?=get_page_url('products&action=delete&id='. $product->id, __FILE__); ?>" title="<?php trans_e("Delete", "stk"); ?>"><i class="fa fa-trash"></i> <?php trans_e("Delete", "stk"); ?></a>
				            </li>
				        </ul>
				    </div>
				</div>
            </td>
        </tr>
	<?php endforeach; endif; ?>
	</tbody>
</table>
</div>
