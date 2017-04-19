<div class="product <?=( isset($class) ) ? $class : 'col-sm-6 col-md-4'; ?>">
    <div class="col-product">
        <div class="product-thumb">
            <a href="<?= get_product_url($product->id, $product->link_rewrite); ?>">
                <?php if( $product->discount > 0 ) : ?>
                    <div class="percent-saleoff"> <span><label><?php echo intval($product->discount_percent); ?>%</label></span></div>
                <?php endif; ?>
                <img alt="<?=$product->name;?>" src="<?= default_product_image($product->id, '360x360'); ?>" class="img-responsive">
            </a>
        </div>
        <div class="product-info">
            <div class="row">
                <div class="block">
                    <h5><a href="<?= get_product_url($product->id, $product->link_rewrite); ?>"><?=$product->name;?></a></h5>
                    <strong class="price"><?=with_currency($product->sell_price);?></strong> 
                    <a class="btn btn-default add_to_cart" data-prod="<?= $product->id; ?>" data-dec="0"><i class="fa fa-shopping-cart"></i> <?php echo get_cart_label($product->id); ?><?php //trans_e("Add to cart", "core"); ?></a>
                    <p class="list"><?=strip_tags($product->excerpt);?></p>
                </div>
            </div>
            <div class="separator clear-left">
                <?php if(is_active('os-wishlist') ) : ?>
                    <p class="btn-wishlist">
                        <i class="fa fa-star-o"></i> 
                        <a class="add_to_wishlist" href="#" data-prod="<?= $product->id; ?>"><?php trans_e("Add to wishlist", "core"); ?></a>
                    </p>
                <?php endif; ?>
                <?php if(is_active('os-quick-view') ) : ?>
                    <p class="btn-details">
                        <i class="fa fa-eye"></i> 
                        <a class="quick-view" href="<?= get_product_url($product->id, $product->link_rewrite); ?>" data-prod="<?= $product->id; ?>"><?php trans_e("Quick View", "core"); ?></a>
                    </p>
                <?php endif; ?>
            </div>
            <div class="clearfix"></div>
        </div><!-- /.product-info -->
    </div>
</div>