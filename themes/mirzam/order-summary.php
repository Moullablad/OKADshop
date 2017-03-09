<div class="container">

    <?php if( isset($cart->items) && !is_empty($cart->items) ) : ?>

        <?php get_template_view('order-steps', array('page' => $page)); ?>
        <?php get_template_view('shopping-cart', array('cart' => $cart, 'page' => $page, 'currency' => $currency)); ?>

        <div class="row">
            <div class="col-sm-12 padding0">
                <a class="btn btn-large pull-left" onclick="history.back()"><i class="fa fa-long-arrow-left"></i> <?php trans_e("Continue shopping", "mirzam"); ?></a> 
                <a class="btn btn-orange checkout-button pull-right" href="<?= generate_url( 'order/address' );?>"><?php trans_e("Checkout", "mirzam"); ?> <i class="fa fa-long-arrow-right"></i></a> 
            </div>
        </div>

    <?php else : ?>
        <?php get_view(__FILE__, 'front/emptycart'); ?>
    <?php endif; ?>

</div>