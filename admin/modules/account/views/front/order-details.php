<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="crimson-text font-italic"><?php trans_e("Order details", "account"); ?></h2>
            <div class="mb-20 mt-20">
                <?php get_view(__FILE__, 'alerts', array("info" => trans("Follow your order's status step-by-step", "account"))); ?>
            </div>
        </div>
    </div><!-- /.row -->


    <table class="shop_table cart osTable">
        <thead>
            <tr>
                <th><?php trans_e("Reference", "mirzam"); ?></th>
                <th><?php trans_e("Product", "mirzam"); ?></th>
                <th><?php trans_e("Quantity", "mirzam"); ?></th>
                <th><?php trans_e("Unit price", "mirzam"); ?></th>
                <th><?php trans_e("Total price", "mirzam"); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $key => $item) : ?>
              <tr>
              	<td><?= $item->product_reference;?></td>
              	<td><?= $item->product_name;?></td>
              	<td><?= $item->product_quantity;?></td>
              	<td><?= $item->product_price;?></td>
              	<td><?= $item->product_price * $item->product_quantity;?></td>
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</div><!-- /#reset-password -->