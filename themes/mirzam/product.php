<section id="single_product">
	<div class="container">
	  	<div class="row col-product">
	    	<div class="col-sm-4">
		        <div id="carousel" class="carousel slide" data-ride="carousel">

		        <?php if( $product->discount > 0 ) : ?>
		        	<?php $percent = ($product->discount/$product->sell_price) * 100; ?>
		        	<div class="percent-saleoff"> <span><label><?php echo intval($percent); ?>%</label></span></div>
		        <?php endif; ?>


		            <div class="carousel-inner">
		            	<?php $i=0; ?>
		            	<?php foreach ($images as $key => $image) : ?>
		            		<div class="product-thumb item <?php if($i == 0) { echo 'active'; $i++; } ?>">
			                    <img src="<?= product_image_by_size($image->name, $product->id, '360x360'); ?>" alt="<?= $product->name; ?>">
			                </div>
		            	<?php endforeach; ?>
		            </div>
		        </div> 
			    <div class="clearfix">
			        <div id="thumbcarousel" class="carousel slide" data-interval="false">
			            <div class="carousel-inner">

			            	<?php 
			            		$i = 1; 
			            		$nb_images = (array)$images;
			            		$nb_images = count($images);
			            	?>
		            		<?php foreach ($images as $key => $image) : ?>
		            			
		            			<?php if ($i == 1): ?>
		            				<div class="item active">
		            			<?php endif ?>

		            			 <div data-target="#carousel" data-slide-to="<?= ($i-1) ?>" class="thumb"><img src="<?= product_image_by_size($image->name, $product->id, '76x76'); ?>"></div>


		            			<?php if ( $nb_images == $i ): ?>
		            				</div><!-- /item -->
		            			<?php elseif ($i%4 == 0): ?>
		            				</div><!-- /item -->
		            				<div class="item">
		            			<?php endif ?>

		            		<?php $i++; ?>
		            		<?php endforeach; ?>

 


			            </div><!-- /carousel-inner -->
			            <a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
			                <span class="glyphicon glyphicon-chevron-left"></span>
			            </a>
			            <a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
			                <span class="glyphicon glyphicon-chevron-right"></span>
			            </a>
			        </div> <!-- /thumbcarousel -->
			    </div><!-- /clearfix -->
			</div> <!-- /col-sm-6 -->
		    <div class="col-sm-8 product-info">
		        <h1 class="product-title" ><?= $product->name; ?></h1>
		        
		        <p class="product-description"><?= $product->short_description; ?></p>

				<div class="product-price">

                    <p class="price">
                        <?php
                         if( $product->discount > 0 ) : ?>
                            <ins><?=$product->sell_price .' '. $currency;?></ins>
                            <del><span class="old-amount"><?=$product->old_price .' '. $currency;?></span></del>
                        <?php else : ?>
                            <ins><?=$product->sell_price .' '. $currency;?></ins>
                        <?php endif; ?>
                    </p>
				</div>

				<div class="product-attribute">
					<ul>
						<?php if( !is_empty($product->reference) ) : ?>
							<li>Reference : <?= $product->reference; ?></li>
						<?php endif; ?>
						<?php if( !is_empty($product->product_condition) ) : ?>
							<li>Condition : <?= $product->product_condition; ?></li>
						<?php endif; ?>
						
						<li>Availability : 
						<?php if ($product->quantity > 0): ?>
							<span class="green">In Stock</span>
						<?php else: ?>
							<span class="red">Sold Out</span>
						<?php endif ?>
						</li>
					</ul>
				</div>
				
				<div class="add-to-cart">
					<form action="" method="post" id="cart_form">
						<input id="idProduct" name="id_product" type="hidden" value="<?= $product->id; ?>"> 
                        <input id="idDeclinaison" name="id_declinaison" type="hidden" value="">
						<a class="btn btn-default qty-down btn-qty" href="#" role="button">-</a>
						<input type="text" name="qty" id="product_quantity" value="1" class="qty">
						<a class="btn btn-default qty-up btn-qty" href="#" role="button">+</a>
						<p>
	                        <button type="submit" id="add_to_cart" class="btn btn-default buy_now single_add_to_cart_button" data-prod="<?= $product->id; ?>" data-dec="0"> <?= get_cart_label($product->id); ?></button>
						</p>
					</form>
				</div>

		    </div> <!-- /col-sm-6 -->
	  	</div> <!-- /row -->
	</div> <!-- /container -->
</section>

 

<section id="trending" class="visible-md visible-lg product-tabs">
	<div class="container">
	    <div class="row m-xs-5">
	    	<ul class="nav nav-tabs">
	    		<?php $active = "active"; ?>
				<?php if( $product->long_description != "" ) : ?>
					
                    <li class="<?= $active; ?>">
                        <a data-toggle="tab" href="#tab_long_desc"><?php trans_e("Description", "frochka"); ?></a>
                    </li>
                    <?php $active = ""; ?>
                <?php endif; ?>
                <?php if( !is_empty($features) ) : ?>
                	
                    <li class="<?= $active; ?>">
                        <a data-toggle="tab" href="#tab_features"><?php trans_e("Product Features", "frochka"); ?></a>
                    </li>
                    <?php $active = ""; ?>
                <?php endif; ?>
                <?php if( !is_empty($tags) ) : ?>
                	
                    <li class="<?= $active; ?>">
                        <a data-toggle="tab" href="#tab_tags"><?php trans_e("Product tags", "frochka"); ?></a>
                    </li>
                    <?php $active = ""; ?>
                <?php endif; ?>

                 <?php if( !is_empty($attachements) ) : ?>

                    <li class="<?= $active; ?>">
                        <a data-toggle="tab" href="#attachements"><?php trans_e("Product attachements", "frochka"); ?></a>
                    </li>
                    <?php $active = ""; ?>
                <?php endif; ?>

			</ul>

			<div class="tab-content">
				
				<?php if( $product->long_description != "" ) : ?>
                    <div class="tab-pane fade in active" id="tab_long_desc">
                        <?= $product->long_description; ?>
                    </div>
                <?php endif; ?>
                <?php if( !is_empty($features) ) : ?>
                    <div class="tab-pane fade" id="tab_features">
                        <table class="table table-bordered">
                            <?php foreach ($features as $key => $feature) : ?>
                                <tr>
                                    <th width="100"><?= $feature->name; ?></th>
                                    <td><?= ($feature->custom != "") ? $feature->custom : $feature->value; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
                <?php if( !is_empty($tags) ) : ?>
                    <div class="tab-pane fade" id="tab_tags">
                        <div class="tagcloud">
                            <?php foreach ($tags as $key => $tag) : ?>
                                <a><?= $tag->name; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                 <?php if( !is_empty($attachements) ) : ?>
                    <div class="tab-pane fade" id="attachements">
                        <div class="">
                        	<table class="table table-striped" >
                        		<tr>
                        			<th><?= trans('File name','mirzame') ?></th>
                        			<th><?= trans('information','mirzame') ?></th>
                        			<th><?= trans('Action','mirzame') ?></th>
                        		</tr>
                        	
	                            <?php foreach ($attachements as $key => $attachement) : ?>
	                                
	                                <tr>
	                                	<td><b><?= $attachement->name; ?></b></td>
	                                	<td><?= $attachement->description; ?></td>
	                                	<td><a href="<?= $attachement->link; ?>" download><i class="fa fa-download"></i></a></td>
	                                </tr>
	                            <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

 



			</div>
		</div>
	</div>
</section><!-- /#trending -->
 