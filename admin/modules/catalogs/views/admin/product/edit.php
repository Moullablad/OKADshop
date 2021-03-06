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
        <h3><i class="fa fa-pencil"></i> <?php trans_e("Edit:", "default"); ?> <span class="pname"><?php //echo $product->information->name; ?></span></h3>
    </div>
    <div class="top-menu-button">
    	<a target="_blank" href="<?php //echo $product->information->link; ?>" class="btn btn-primary product_link"><i class="fa fa-eye"></i> <?php trans_e("View Product", "default"); ?></a>
	</div>
</div><br>

<?php get_tabs(__FILE__, 'product', ['multilang' => true]); ?>