<div class="container">
    <div class="row">
    <?php if( !is_empty($addresses) ) : ?>
        <div class="col-md-12">         
            <div class="alert alert-info">
                <h4><?php trans_e("Your addresses are listed below.", "account"); ?></h4>
                <a class="btn btn-orange pull-right" href="<?= generate_url('account/address');?>"><?php trans_e("Add a new address", "account"); ?></a> 
                <ul>
                    <li><?php trans_e("Please configure your default billing and delivery addresses when placing an order.", "account"); ?></li>
                    <li><?php trans_e("You may also add additional addresses, which can be useful for sending gifts or receiving an order at your office.", "account"); ?></li>
                    <li><?php trans_e("Be sure to update your personal information if it has changed.", "account"); ?></li>
                </ul>
            </div>


            <table class="osTable" id="addresses">
                <thead>
                    <tr>
                        <th><?php trans_e("Label", "account"); ?></th>
                        <th><?php trans_e("Full name", "account"); ?></th>
                        <th><?php trans_e("Company", "account"); ?></th>
                        <th><?php trans_e("Address", "account"); ?></th>
                        <th><?php trans_e("Country", "account"); ?></th>
                        <th><?php trans_e("Phone", "account"); ?></th>
                        <th width="90"><?php trans_e("Actions", "account"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($addresses as $key => $address) : ?>
                        <tr>
                            <td><?= $address->name; ?></td>
                            <td><?= $address->firstname .', '. $address->lastname; ?></td>
                            <td><?= $address->company; ?></td>
                            <td><?= $address->addresse; ?></td>
                            <td><?= $address->country; ?></td>
                            <td><?= $address->phone; ?></td>
                            <td>
                                <form method="POST">
                                    <a class="btn btn-primary btn-xs" href="<?= generate_url('account/address/'.$address->id);?>">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <input type="hidden" name="id_address" value="<?= $address->id; ?>">
                                    <button onclick="return confirm('<?php trans_e("Are you sure you want to delete this Address?", "account"); ?>');" name="delete_address" type="submit" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php else : ?>
        <div class="col-md-12">
            <div class="alert alert-info alert-white rounded" id="message">
            <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
            <div class="icon">
                <i class="fa fa-info-circle"></i>
            </div>
            <strong><?php trans_e("No address found.", "account"); ?></strong> 
        </div> 
        <p>
            <a href="<?= generate_url('account/address');?>" class="btn btn-orange"><?php trans_e("Add your first address.", "account"); ?></a>
        </p>
        </div>
    <?php endif; ?>
    </div><!-- /.row -->
</div><!-- /#reset-password -->