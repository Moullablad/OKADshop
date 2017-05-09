<div class="container">
    <div class="row">
    <?php if( !is_empty($orders) ) : ?>
        <div class="col-md-12">
            <div class="alert alert-info">
                <h4><?php trans_e("Order history.", "orders"); ?></h4>
                <p><?php trans_e("Here are the orders you've placed since your account was created.", "orders"); ?></p>
            </div>
        </div>

        <div class="col-md-12">
            <table cellspacing="0" class="osTable" id="orders" width="100%">
                <thead>
                    <tr>
                        <th><?php trans_e("Order reference", "orders"); ?></th>
                        <th><?php trans_e("Date", "orders"); ?></th>
                        <th><?php trans_e("Total price", "orders"); ?></th>
                        <th><?php trans_e("Payment", "orders"); ?></th>
                        <th><?php trans_e("Status", "orders"); ?></th>
                        <th><?php trans_e("Invoice", "orders"); ?></th>
                        <th width="100"><?php trans_e("Actions", "orders"); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if( !is_empty($orders) ) : ?>
                    <?php foreach ($orders as $key => $order) : ?>
                    <tr>
                        <td><?= $order->reference; ?></td>
                        <td><?= $order->cdate; ?></td>
                        <td>-- <!--<? //= $order->total_price; ?>--></td>
                        <td><?= $order->payment_method; ?></td>
                        <td>-- <!--<?//= $order->status; ?>--></td>
                        <td>-- <!--<? //= $order->invoice; ?>--></td>
                        <td>    
                            <a class="btn btn-primary" href="<?= generate_url('account/order-details/'.$order->id);?>">
                                <?php trans_e("Details", "orders"); ?> 
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    <?php else : ?>
        <div class="col-md-12">
            <div class="alert alert-info alert-white rounded mb-10" id="message">
                <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
                <div class="icon">
                    <i class="fa fa-info-circle"></i>
                </div>
                <strong><?php trans_e("You have not placed any orders.", "orders"); ?></strong> 
            </div> 
        </div>
    <?php endif; ?>
    </div><!-- /.row -->
</div><!-- /.container -->