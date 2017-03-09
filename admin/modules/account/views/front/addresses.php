<div class="container">
    <div class="row">
    <?php if( !is_empty($addresses) ) : ?>
        <div class="col-md-12">
            <div class="mb-20 mt-20">
                <?php get_view(__FILE__, 'alerts', $message); ?>
            </div>           
            <div class="alert alert-info">
                <h4><?php trans_e("Your addresses are listed below.", "account"); ?></h4>
                <ul>
                    <li><?php trans_e("Please configure your default billing and delivery addresses when placing an order.", "account"); ?></li>
                    <li><?php trans_e("You may also add additional addresses, which can be useful for sending gifts or receiving an order at your office.", "account"); ?></li>
                    <li><?php trans_e("Be sure to update your personal information if it has changed.", "account"); ?></li>
                </ul>
            </div>
        </div>

        <?php foreach ($addresses as $address) : ?>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title pull-left"><?= $address->name; ?></h3>
                        <span class="pull-right">
                            <form method="POST">
                                <a class="btn btn-primary btn-xs" href="<?= generate_url('account/address/'.$address->id);?>">
                                    <i class="fa fa-pencil"></i> <span><?php trans_e("Update", "account"); ?></span>
                                </a>
                                <input type="hidden" name="id_address" value="<?= $address->id; ?>">
                                <button name="delete_address" type="submit" class="btn btn-danger btn-xs">
                                    <i class="fa fa-trash"></i> <span><?php trans_e("Delete", "account"); ?></span>
                                </button>
                            </form>
                        </span>
                    </div>
                    <div class="list-group">
                        <div class="list-group-item">
                            <label><?php trans_e("Name", "account"); ?></label>
                            <h4 class="list-group-item-heading"><?= $address->firstname .', '. $address->lastname; ?></h4>
                        </div>
                        <div class="list-group-item">
                            <label><?php trans_e("Company", "account"); ?></label>
                            <h4 class="list-group-item-heading"><?= $address->company; ?></h4>
                        </div>
                        <div class="list-group-item">
                            <label><?php trans_e("Address", "account"); ?></label>
                            <h4 class="list-group-item-heading">
                                <?= $address->addresse; ?><br>
                                <?= $address->city .', '. $address->codepostal; ?>
                            </h4>
                        </div>
                        <div class="list-group-item">
                            <label><?php trans_e("Country", "account"); ?></label>
                            <h4 class="list-group-item-heading"><?= $address->country; ?></h4>
                        </div>
                        <a class="list-group-item" href="tel://<?= $address->phone; ?>">
                            <label><?php trans_e("Home phone", "account"); ?></label>
                            <h4 class="list-group-item-heading"><?= $address->phone; ?> <i class="fa fa-skype pull-right"></i></h4>
                        </a> 
                        <a class="list-group-item" href="tel://<?= $address->mobile; ?>">
                            <label><?php trans_e("Mobile phone", "account"); ?></label>
                            <h4 class="list-group-item-heading"><?= $address->mobile; ?> <i class="fa fa-skype pull-right"></i></h4>
                        </a> 
                    </div>
                </div>
            </div>  
        <?php endforeach; ?>

        <div class="col-sm-12">
            <a href="<?= generate_url('account');?>" class="btn btn-large pull-left"><i class="fa fa-long-arrow-left"></i> <?php trans_e("Back to your account", "account"); ?></a> 
            <a class="btn btn-orange pull-right" href="<?= generate_url('account/address');?>"><?php trans_e("Add a new address", "account"); ?></a> 
        </div>

    <?php else : ?>
        <div class="col-md-12">
            <div class="alert alert-info">
                <h4><?php trans_e("No address found.", "account"); ?></h4>
                <p>
                    <a href="<?= generate_url('account/address');?>" class="btn btn-orange"><?php trans_e("Add your first address.", "account"); ?></a>
                </p>
            </div>
        </div>
    <?php endif; ?>
    </div><!-- /.row -->
</div><!-- /#reset-password -->