<!-- Block Cart -->
<div class="block-cart">
	<a class="icon" href="<?= generate_url( 'order/summary' );?>">Cart <span class="count"><?=$cart->count;?></span></a>
	<div class="block-cart-content" style="<?= ($cart->count == 0) ? "display:none" : "display:block";?>">
		<ul class="cart-products">
		<?php if( isset($cart->items) && !empty($cart->items) ) : ?>
		    <?php foreach ($cart->items as $key => $item) : 
				$attrs = '';
		        if( !is_empty($item->attrs) ){
		            foreach ($item->attrs as $key => $value){
		                $attrs .= $key . ':' . $value . ', ';
		            }
		        }
				$sub_total += floatval($item->price) * intval($item->qty);
		    ?>
		        
		    <li class="cart_item">
		        <div class="product-thumb">
		            <a href="<?= $item->link; ?>"><img alt="" src="<?= $item->cover; ?>"></a>
		        </div>
		        <div class="product-info">
		            <h5 class="product-name"><a href="<?= $item->link; ?>"><?= $item->name; ?></a></h5>
		            <span class="price"><?= with_currency($item->price); ?></span>
		            <span class="qty">Qty: <?= $item->qty; ?></span>
		            <span class="attrs"><?= rtrim($attrs, ', '); ?></span>
		            <a class="remove" href="#" data-prod="<?= $item->id_product; ?>" data-dec="<?= $item->id_dec; ?>"><?php trans_e("remove", "core"); ?></a>
		        </div>
		    </li>
		    <?php endforeach; ?>
		<?php endif; ?>
		</ul>

		<p class="sub-toal-wapper">
	        <span><?php trans_e("Shipping", "core"); ?></span> 
	        <span class="shipping">
	        	<?php if( isset($cart->shipping) && $cart->shipping > 0 ) : ?>
		            <i class="price"><?= with_currency($cart->shipping); ?></i>
		        <?php else : ?>
		            <i class="price"><?php trans_e("Free shipping", "core"); ?></i>
		        <?php endif; ?>
	        </span><br>
	        <span><?php trans_e("Total", "core"); ?></span> 
	        <?php if( isset($sub_total) ) : ?>
		        <span class="sub-toal">
		            <i class="price"><?= with_currency($sub_total); ?></i>
		        </span>
		    <?php endif; ?>
	    </p>
	    <a class="btn-check-out" href="<?= generate_url( 'order/summary' ); ?>"><?php trans_e("PROCESS TO CHECK OUT", "core"); ?></a>
    </div>
</div>
<!-- ./Block Cart -->