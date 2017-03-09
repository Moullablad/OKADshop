<div class="container">

    <h1><?php trans_e("ORDER RECEIVED", "core"); ?></h1>
    <h4><?php trans_e("Thank you. Your order has been received", "core"); ?></h4>
    <table style="margin:25px 0px 0px">
        <tr>
            <td width="100"><?php trans_e("ORDER:", "core"); ?></td>
            <td width="250"><?php trans_e("DATE:", "core"); ?></td>
            <td><?php trans_e("TOTAL:", "core"); ?></td>
        </tr>
        <tr>
            <th>#<?php echo $order->id;?></th>
            <th><?php echo $order->date;?></th>
            <th><?= with_currency($order->total_tax_incl); ?></th>
        </tr>
    </table>
    <table style="margin:5px 0px 25px 0px">
        <tr>
            <td width="300"><?php trans_e("PAYMENT METHOD:", "core"); ?></td>
        </tr>
        <tr>
            <th><?php echo $order->method;?></th>
        </tr>
    </table>

    <div class="row">
        <div class="col-sm-12">
            <?php do_action('os_before_order_details'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h3><?php trans_e("ORDER DETAILS", "core"); ?></h3>
            <table class="shop_table cart osTable">
                <thead>
                    <tr>
                        <th width="150" class="product-thumbnail"><?php trans_e("Product", "core"); ?></th>
                        <th class="product-name"><?php trans_e("Name", "core"); ?></th>
                        <th class="product-quantity"><?php trans_e("Quantity", "core"); ?></th>
                        <th class="product-price"><?php trans_e("Price", "core"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order->products as $key => $item) : ?>
                        <tr class="cart_item">
                            <td class="product-thumbnail" style="padding: 0px;">
                                <a href="<?= $item->link; ?>"><img alt="" src="<?= $item->cover; ?>"></a>
                            </td>
                            <td class="product-name">
                                <a href="<?= $item->link; ?>"><?= $item->name; ?></a>
                                <?php if( !is_empty($item->attrs) ) : ?>
                                <dl class="variation">
                                    <?php foreach ($item->attrs as $key => $value) : ?>
                                        <dt class="variation-Color"><?=$key;?>:</dt>
                                        <dd class="variation-Color">
                                            <p><?=$value;?></p>
                                        </dd>
                                    <?php endforeach; ?>
                                </dl>
                                <?php endif; ?>
                            </td>
                            <td class="product-quantity"><?= $item->qty; ?></td>
                            <td class="product-subtotal"><span class="amount"><?= format_price($item->price * $item->qty); ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="cart_totals col-sm-4 col-sm-offset-8 padding0">
        <table class="table table-bordered" style="margin-top: 20px;">
            <tbody>
                <tr class="total_products">
                    <td><?php trans_e("Cart subtotal :", "core"); ?></td>
                    <td width="120"><span class="amount"><?= with_currency($order->subtotal); ?></span></td>
                </tr>
                <?php if( $order->shipping > 0 ) : ?>
                    <tr class="total_shipping">
                        <td><?php trans_e("Shipping (tax incl.)", "core"); ?></td>
                        <td><span class="amount"><?= with_currency($order->shipping); ?></span></td>
                    </tr>
                <?php else : ?>
                    <tr class="total_shipping">
                        <td><?php trans_e("Shipping (tax incl.)", "core"); ?></td>
                        <td><?php trans_e("Free shipping", "core"); ?></td>
                    </tr>
                <?php endif; ?>
                <tr class="total_tax_incl">
                    <td><?php trans_e("Order Total", "core"); ?></td>
                    <td><span class="amount"><?= with_currency($order->total_tax_incl); ?></span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php do_action('os_after_order_details'); ?>
        </div>
    </div>

    <a class="button btn btn-default pull-left" href="<?= generate_url( 'account/?tab=orders' ); ?>" title="<?php trans_e("Go to your order history page", "core"); ?>"><i class="fa fa-long-arrow-left"></i> <?php trans_e("View your order history", "core"); ?></a>
</div>