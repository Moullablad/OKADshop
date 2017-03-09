<div class="quick-view-popup">
	<div class="col-md-4">
		<div class="col-product">
			<div class="carousel slide" data-ride="carousel" id="carousel">
            	<div class="carousel-inner">
					<?php $i = 1;
            		foreach ($images as $key => $image) :
                		$active = ($i==1) ? 'active' : ''; ?>
                		<div class="item <?=$active;?>"><img src="<?= product_image_by_size($image->name, $product->id, '360x360'); ?>" class="img-responsive"></div>
	                <?php $i++; endforeach; ?>
                </div>
            </div><!-- /#carousel -->
            <div class="clearfix">
                <div class="carousel slide" data-interval="false" id="thumbs">
                	<a class="prev-items" data-slide="prev" href="#thumbs">
                		<i class="fa fa-arrow-circle-left"></i>
                	</a> 
                    <div class="carousel-inner">
	                	<?php 
	                	$i = 1; 
	                	$length = count($images);
                		foreach ($images as $key => $image) :
                			if( $i===1) : ?>
                            	<div class="item active">
                            <?php endif; ?>

	                		<div class="thumb" data-slide-to="<?=$key;?>" data-target="#carousel"><img src="<?= product_image_by_size($image->name, $product->id, '76x76'); ?>" width="45" class="img-responsive img-thumbnail"></div>
		                    
	                		<?php if( $i == $length) : ?>
			                	</div><!-- /product -->
			            	<?php elseif( $i%4 == 0 ) : ?>
			            		</div><div class="item">
			                <?php endif; ?>
		                <?php $i++; endforeach; ?>
                    </div><!-- /carousel-inner -->
	                <a class="next-items" data-slide="next" href="#thumbs">
                		<i class="fa fa-arrow-circle-right"></i>
                	</a> 
                </div><!-- /thumbs -->
            </div><!-- /clearfix -->
        </div><!-- /.col-product -->
	</div><!-- /.col-md-4 -->
	<div class="col-md-8">
		<div class="product-info">
			<h1><?= $product->name; ?></h1>
			<div class="excerpt"><?= strip_tags($product->excerpt); ?></div>
			<div class="row mt-30">
				<div class="col-sm-4">
					<div class="price">
		                <?php if( $product->discount > 0 ) : ?>
		                	<span><?= with_currency($product->price_tax_excl - $product->discount);?></span> /
		                	<del><?= with_currency($product->price_tax_excl);?></del>
		                <?php else : ?>
		                    <span><?= with_currency($product->price_tax_excl);?></span>
		                <?php endif; ?>
		            </div>
		            <table>
		                <?php if( !is_empty($product->reference) ) : ?>
		                    <tr>
		                        <th width="90"><?php trans_e("Reference", "qv"); ?></th>
		                        <td>: <?= $product->reference; ?></td>
		                    </tr>
		                <?php endif; ?>
		                <?php if( !is_empty($product->product_condition) ) : ?>
		                    <tr>
		                        <th><?php trans_e("Condition", "qv"); ?></th>
		                        <td>: <?= $product->product_condition; ?></td>
		                    </tr>
		                <?php endif; ?>
		            </table><br>

		            <form id="cart_form" action="" method="post">
                        <input id="idProduct" name="id_product" type="hidden" value="<?= $product->id; ?>"> 
                        <input id="idDeclinaison" name="id_declinaison" type="hidden" value="">
                        <div class="input-group pull-right-lg">
						   <input type="number" min="1" name="qty" value="1" class="input-text quantity" required>
						   <span class="input-group-btn">
						   		<button type="submit" id="add_to_cart" class="btn btn-primary"><?=get_cart_label($product->id);?></button>
						   </span>
						</div>
                    </form>
				</div><!-- /.col-sm-4 -->
				<div class="col-sm-8">
		            <?php if ( !is_empty($combinations) ) : ?>
					<form id="combinations">
	                    <?php foreach ($combinations as $key => $comb): ?>
	                        <div class="form-group">
	                            <label for="<?= $comb->attribute->name; ?>"><?= $comb->attribute->name; ?> :</label>
	                            <select data-id="<?= $comb->attribute->id; ?>" id="<?= $comb->attribute->name; ?>">
	                                <?php foreach ($comb->values as $key => $value): ?>
	                                    <option value="<?= $value->id; ?>"><?= $value->name; ?></option>
	                                <?php endforeach ?>
	                            </select>
	                        </div>
	                    <?php endforeach ?>
		                <p id="availability_statut"></p>
		            </form>
		           	<?php endif ?>
				</div><!-- /.col-sm-8 -->
			</div>          
        </div>
	</div><!-- /.col-md-8 -->
</div><!-- /.quick-view-popup -->