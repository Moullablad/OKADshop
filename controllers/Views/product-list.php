<?php 

    
    if (!isset($class) || is_empty($class)) {
       $class = "col-sm-3";
    }
?>
<?php if (is_empty($products)): ?>
    <div class="alert alert-warning" role="alert"><?= trans('No product available!','core') ?></div>
<?php else: ?>
<div class="row">
<?php foreach ($products as $key => $product): ?>
	<?php 
        if (!$product) {
            continue;
        }
		$sell_price = number_format($product->sell_price, 2, '.', ''); 
		$discount = number_format($product->discount, 2, '.', ''); 
		$sell_price = $sell_price - $discount;
	 ?>
	<div class="<?= $class; ?> mb-xs-20">
		<div class="col-product">
			<div class="product-thumb">
				<a href="<?= $product->link; ?>">
					<img src="<?= default_product_image($product->id, '360x360'); ?>" class="img-responsive" alt="<?= $product->name; ?>" />
				</a>
				
			</div>
            <div class="product-info">
                <div class="row">
                    <div class="block">
                        <h5>
                            <a href="<?= $product->link; ?>" style="color: inherit;">
                                <?= $product->name; ?>
                            </a>
                        </h5>
                        <strong class="price"><?= with_currency($sell_price); ?></strong>
                        <a href="#" class="btn btn-default add_to_cart" data-prod="<?= $product->id; ?>"  data-dec="0">
                        	<i class="fa fa-shopping-cart"></i> <?= get_cart_label($product->id); ?>
                        </a>
                    </div>
                </div>
                <div class="separator clear-left">
					<p class="btn-wishlist">
                        <i class="fa fa-star"></i>
                        <a href="#"><?php trans_e("Add to wishlist", "core");?></a>
                    </p>
                    <p class="btn-details">
                        <i class="fa fa-eye"></i>
                        <a href="#"><?php trans_e("Quick View", "core");?></a>
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<?php endforeach ?>
</div>
<?php endif ?>

 