<div class="container">
	<?php if( !is_empty($wishlist) ) : ?>
		<?php get_view(__FILE__, 'alerts', array('info' => trans("Here all products added to wishlist.", "wishlist"))); ?>
		<div class="products grid-view" id="wishlist-items">
        <?php $lastItem = count( $wishlist ); $i=1; ?>
		<?php foreach ($wishlist as $key => $product) : ?>
            <?php if( $i==1) : ?><div class="row"><?php endif; ?>
			<?php
			$data = array(
				'product' => $product,
				'class' => 'col-sm-6 col-md-3'
			);
			get_template_view('product-item', $data); ?>

            <?php if( $i == $lastItem) : ?>
                </div><!-- /.row -->
            <?php elseif( $i%4 == 0 ) : ?>
                </div><!-- /.row --><div class="row">
            <?php endif; ?>

            <?php $i++; ?>
		<?php endforeach; ?>
        </div><!-- /.products -->
	<?php else : ?>
		<?php get_view(__FILE__, 'alerts', array('info' => trans("Your wishlist is empty.", "wishlist"))); ?>
	<?php endif; ?>
</div>