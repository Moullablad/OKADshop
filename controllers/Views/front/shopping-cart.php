<!-- Table cart -->
<div class="row">
    <div class="col-sm-12 items_wrapper table-responsive">
        <table class="shop_table cart osTable">
            <thead>
                <tr>
                    <th class="product-thumbnail"><?php trans_e("Product", "core"); ?></th>
                    <th class="product-name"><?php trans_e("Name", "core"); ?></th>
                    <th class="product-quantity"><?php trans_e("Quantity", "core"); ?></th>
                    <th class="product-price"><?php trans_e("Price", "core"); ?></th>
                    <th class="product-subtotal"><?php trans_e("Total price", "core"); ?></th>
                    <th class="product-remove">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart->items as $key => $item) : ?>
                    <tr class="cart_item" data-prod="<?= $item->id_product; ?>" data-dec="<?= $item->id_dec; ?>">
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
                        <td class="product-quantity">
                            <div class="box-qty">
                                <a class="quantity-plus" href="#"><i class="fa fa-angle-up"></i></a>
                                <input class="input-text qty text" min="1" name="quantity" size="4" step="1" title="Qty" type="text" value="<?= $item->qty; ?>"> 
                                <a class="quantity-minus" href="<?= $item->link; ?>"><i class="fa fa-angle-down"></i></a>
                            </div>
                        </td>
                        <td class="product-price"><span class="amount"><?= format_price($item->price); ?></span></td>
                        <td class="product-subtotal"><span class="amount"><?= format_price($item->price * $item->qty); ?></span></td>
                        <td class="product-remove">
                            <a class="remove" href="#" data-prod="<?= $item->id_product; ?>" data-dec="<?= $item->id_dec; ?>"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<br>

<div class="row mb-30">
    <div class="col-sm-12 col-md-6">
    <?php if( isset($page) && $page === "summary" ) : ?>
        <div class="discount-codes">
            <form class="osForm" method="" id="coupon-code">
                <div class="input-group pull-right-lg">
                  <input class="form-control" placeholder="<?php trans_e("Coupon code.", "core");?>" type="text" id="code">
                  <span class="input-group-btn" style="font-size: 16px;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 15px;"><?php trans_e("APPLY COUPON", "core"); ?></button>
                  </span>
                </div>
                <p class="notice"><?php trans_e("Enter your coupon code if you have one.", "core"); ?></p>
            </form>
        </div>

      



        <?php if( isset($voucher_data) && !is_empty($cart->voucher_data) ) : ?>
        <table class="table table-bordered" style="margin-bottom: 0px;">
            <thead>
                <tr>
                    <th><?php trans_e("Name", "core"); ?></th>
                    <th><?php trans_e("Code", "core"); ?></th>
                    <th><?php trans_e("Amount", "core"); ?></th>
                    <th width="100"><?php trans_e("Action", "core"); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $cart->voucher_data->name; ?></td>
                    <td><?= $cart->voucher_data->code; ?></td>
                    <td><?= $cart->voucher_data->total_voucher; ?></td>
                    <td><a class="btn btn-danger" id="delete-coupon"><i class="fa fa-trash"></i> <?php trans_e("Delete Coupon", "core"); ?></a></td>
                </tr>
            </tbody>
        </table>
        <?php endif; ?>

    <?php endif; ?>
    </div>

    <div class="cart_totals col-sm-4 col-sm-offset-2 pull-right">
        <table class="table table-bordered" style="margin-bottom: 0px;">
            <tbody>
                <tr class="total_products">
                    <td><?php trans_e("Total products (tax incl.) :", "core"); ?></td>
                    <td width="120"><span class="amount"><?= with_currency($cart->total_products); ?></span></td>
                </tr>
                <?php if( $cart->total_voucher > 0 ) : ?>
                    <tr class="total_voucher">
                        <td><?php trans_e("Total coupon codes (tax incl.) :", "core"); ?></td>
                        <td><span class="amount"><?= with_currency($cart->total_voucher); ?></span></td>
                    </tr>
                <?php endif; ?>
                <?php if( $cart->total_discount > 0 ) : ?>
                    <tr class="total_discount">
                        <td><?php trans_e("Total discount (tax incl.) :", "core"); ?></td>
                        <td><span class="amount"><?= with_currency($cart->total_discount); ?></span></td>
                    </tr>
                <?php endif; ?>
                <?php if( $cart->total_shipping > 0 ) : ?>
                    <tr class="total_shipping">
                        <td><?php trans_e("Total shipping (tax incl.) :", "core"); ?></td>
                        <td><span class="amount"><?= with_currency($cart->total_shipping); ?></span></td>
                    </tr>
                <?php else : ?>
                    <tr class="total_shipping">
                        <td><?php trans_e("Total shipping (tax incl.) :", "core"); ?></td>
                        <td><?php trans_e("Free shipping", "core"); ?></td>
                    </tr>
                <?php endif; ?>
                <tr class="total_tax_excl">
                    <td><?php trans_e("Total (tax excl.) :", "core"); ?></td>
                    <td><span class="amount"><?= with_currency($cart->total_tax_excl); ?></span></td>
                </tr>
                <?php if( $cart->total_tax > 0 ) : ?>
                    <tr class="total_tax">
                        <td><?php trans_e("Total tax :", "core"); ?></td>
                        <td><span class="amount"><?= with_currency($cart->total_tax); ?></span></td>
                    </tr>
                <?php endif; ?>
                <tr class="total_tax_incl">
                    <td><?php trans_e("Total (tax incl.) :", "core"); ?></td>
                    <td><span class="amount"><?= with_currency($cart->total_tax_incl); ?></span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
