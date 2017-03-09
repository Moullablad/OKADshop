<section id="trending" class="visible-md visible-lg">
	<div class="container">
	    <div class="row m-xs-5">
	    	<h3><?php trans_e("Trending Now", "trending"); ?></h3>

	    	<ul class="nav nav-tabs">
	    		<?php 
	    			$i = 0;
					foreach ($category_trending as $key => $cat){ 
						if (is_empty($cat->products)) {
							continue;
						}
						$active = "";
						if ($i == 0) {
							$active = "active";
						}
					?>
	    			<li class="<?= $active ?>">
						<a data-toggle="tab" href="#cat_<?= $cat->id; ?>"><?= $cat->name; ?></a>
					</li>
	    		<?php $i++; } ?>
			</ul>

			<div class="tab-content">
				<?php 
	    			$i = 0;
					foreach ($category_trending as $key => $cat){ 

						if (is_empty($cat->products)) {
							continue;
						}

						$nb_products = (array)($cat->products);
						$nb_products = count($nb_products);
						

						$active = "";
						if ($i == 0) {
							$active = "in active";
						}
					?>
	    			<div id="cat_<?= $cat->id; ?>" class="tab-pane fade <?= $active; ?>">
	    			 	<?php if ($nb_products > 0) { ?>

						
	    			 	<div class="col-md-1 p-0">
				    		<a class="fa fa-chevron-left btn controls" href="#cat_<?= $cat->id; ?>-carousel"
	                    data-slide="prev"></a>
				    	</div>

				    	<div class="col-md-10 p-0">
				    		<div id="cat_<?= $cat->id; ?>-carousel" class="carousel slide" data-ride="carousel">
				            	<div class="carousel-inner">
				            	<?php 
				            		$j=1;
				            	?>
				            	<?php foreach ($cat->products as $key => $product): ?>
				            		
				            	<?php 
				            		$sell_price = number_format($product->sell_price, 2, '.', ''); 
									$discount = number_format($product->discount, 2, '.', ''); 
									$sell_price = $sell_price - $discount;
				            	?>
				            	 	<?php if( $j===1) : ?>
					                <div class="item active">
					                    <div class="row">
					                <?php endif; ?>

					                	<div class="col-sm-3 ">
				                            <div class="col-product">
				                                <div class="photo product-thumb">
				                                    <a href="<?= $product->link; ?>">
				                                    	<img src="<?= default_product_image($product->id, '360x360'); ?>" class="img-responsive" alt="<?= $product->name;  ?>" />
				                                    </a>
				                                </div>
				                                <div class="info">
				                                    <div class="row">
				                                        <div class="block">
				                                            <h5><a href="<?= $product->link; ?>" style="color: inherit;"><?= $product->name;  ?></a></h5>
				                                            <strong class="price"><?= with_currency($sell_price); ?></strong>
				                                            <a href="#" class="btn btn-default add_to_cart" data-prod="<?= $product->id; ?>"  data-dec="0">
				                                            	<i class="fa fa-shopping-cart"></i> <?= get_cart_label($product->id); ?>
				                                            </a>
				                                        </div>
				                                    </div>
				                                    <div class="separator clear-left">
				                                        <p class="btn-wishlist">
				                                            <i class="fa fa-star-o"></i>
				                                            <a href="#" class="hidden-sm"><?php trans_e("Add to wishlist", "trending"); ?></a>
				                                        </p>
				                                        <p class="btn-details">
				                                            <i class="fa fa-eye"></i>
				                                            <a href="#" class="hidden-sm"><?php trans_e("Quick View", "trending"); ?></a>
				                                        </p>
				                                    </div>
				                                    <div class="clearfix"></div>
				                                </div>
				                            </div>
				                        </div>

					                <?php if( $j == $nb_products) : ?>
					                	</div>
					                </div>
					            	<?php elseif( $j%4 == 0 ) : ?>
					            		</div>
					                </div>
					                <div class="item">
					                    <div class="row">
					                <?php endif; ?>

					            <?php $j++; ?>
				            	<?php endforeach ?>
				            	</div>
				            </div>
				        </div>

				        <div class="col-md-1 p-0">
				    		<a class="fa fa-chevron-right btn controls pull-right" href="#cat_<?= $cat->id; ?>-carousel"
	                        data-slide="next"></a>
				    	</div><!-- /.col-md-1 -->

				    	<?php } ?>
	    			 </div>
	    		<?php $i++; } ?>
 
			</div>
		</div>
	</div>
</section><!-- /#trending -->