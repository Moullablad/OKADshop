<?php
/**
 * The template for PAYMENT.
 *
 * @link https://okdashop.com
 *
 * @package OKADshop
 */
?>
<div class="container" id="main-container">

	<?php get_template_view('order-steps', array('page' => $page)); ?>
    <?php get_template_view('shopping-cart', array('cart' => $cart)); ?>

    <div class="row">
        <div class="col-xs-12">
        <?php if( !is_empty($methodes) ) : ?>
            <table class="table table-bordered" id="methodes">
            <?php foreach ($methodes as $slug => $value) : ?>
                <tr>
                    <?php $link = generate_url( 'order/payment/'. $slug ); ?>
                    <td width="64"><a class="<?= $slug; ?>" href="<?=$link?>"><img src="<?= get_module_icon($slug); ?>" width="64"></a></td>
                    <td><a class="<?= $slug; ?>" href="<?=$link?>"><?= $value->name; ?></a></td>
                    <td><strong><a class="<?= $slug; ?>" href="<?=$link?>">(<?= $value->description; ?>)</a></strong></td>
                    <td width="15">
                        <a class="<?= $slug; ?>" href="<?=$link?>"><i class="fa fa-chevron-right fa-3x"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </table>
        <?php endif; ?>
        </div>
    </div>  
	
</div>