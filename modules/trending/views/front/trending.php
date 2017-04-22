<section id="trending" class="visible-md visible-lg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3><?php trans_e("Trending Now", "trending"); ?></h3>
				<ul class="nav nav-tabs">
					<?php
					$firstTab = false;
					foreach ($categories as $key => $cat) : 
					if ( is_empty($cat->products) ) {
						continue;
					} else if( !$firstTab ) {
						$active = "in active";
						$firstTab = true;
					} else {
						$active = '';
					}
					?>
					<li class="<?= $active ?>">
						<a data-toggle="tab" href="#cat_<?= $cat->id; ?>"><?= $cat->name; ?></a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>	
		</div>
	</div>

	<div class="tab-content">
	<?php 
	$firstTab = false;
	foreach ($categories as $key => $cat) : 
		if ( is_empty($cat->products) ) {
			continue;
		} else if( !$firstTab ) {
			$active = "in active";
			$firstTab = true;
		} else {
			$active = '';
		}
	?>
	<div id="cat_<?= $cat->id; ?>" class="tab-pane fade <?= $active; ?>">
		<div class="col-md-12 products grid-view">
    		<div id="cat_<?= $cat->id; ?>-carousel" class="carousel slide" data-ride="carousel">
            	<div class="carousel-inner">
            	<?php foreach ($cat->products as $key => $product):

            		if( $key == 3 ) break;

            		get_view(__FILE__, 'front/product-item', [
            			'product' => $product
            		]);

				endforeach ?>
            	</div>
            </div>
        </div>
	</div>
	<?php endforeach; ?>
	</div>
</section>