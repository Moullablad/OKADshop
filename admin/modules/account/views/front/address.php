<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <form class="osForm" action="<?=get_url('account/address');?>" role="form" method="POST">              
                <?php if( !is_empty($address->name) ) : ?>
                    <h2><?php trans_e("Modify address", "account"); ?> "<?=$address->name;?>"</h2>
                <?php else : ?>
                    <h2><?php trans_e("New address", "account"); ?></h2>
                <?php endif; ?>

                <!--div class="mb-20 mt-20">
                    <?php //get_view(__FILE__, 'alerts', $message); ?>
                </div-->

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label><?php trans_e("First name", "account"); ?> <span class="required">*</span></label>
                        <input type="text" name="firstname" id="firstname" class="form-control" value="<?= $address->firstname; ?>" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label><?php trans_e("Last name", "account"); ?> <span class="required">*</span></label>
                        <input type="text" name="lastname" id="lastname" class="form-control" value="<?= $address->lastname; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label><?php trans_e("Company name", "account"); ?></label>
                    <input type="text" name="company" id="company" class="form-control" value="<?= $address->company; ?>">
                </div>
                <div class="form-group">
                    <label><?php trans_e("Address", "account"); ?> <span class="required">*</span></label>
                    <input type="text" name="addresse" id="addresse" class="form-control" value="<?= $address->addresse; ?>" required>
                </div>
                <div class="form-group">
                    <label><?php trans_e("Address (Line 2)", "account"); ?></label>
                    <input type="text" name="addresse2" id="addresse2" class="form-control" value="<?= $address->addresse2; ?>">
                </div>
                <div class="form-group">
                    <label><?php trans_e("Zip/postal code", "account"); ?><span class="required">*</span></label>
                    <input type="text" name="codepostal" id="codepostal" class="form-control" value="<?= $address->codepostal; ?>" required>
                </div>
                <div class="form-group">
                    <label><?php trans_e("City", "account"); ?><span class="required">*</span></label>
                    <input type="text" name="city" id="city" class="form-control" value="<?= $address->city; ?>" required>
                </div>
                <div class="form-group">
                    <label><?php trans_e("Country", "account"); ?><span class="required">*</span></label>
                    <select id="country" name="id_country" >
                        <?php if ( !is_empty($countries) ) : ?>
                           <?php foreach ($countries as $key => $country) : ?>
                                <?php $selected = ($address->id_country == $country->id) ? 'selected' : 'dd'; ?>
                                <option <?= $selected; ?> class="form-control" value="<?= $country->id; ?>"><?= $country->name; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php trans_e("Home phone", "account"); ?><span class="required">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-control" value="<?= $address->phone; ?>" required>
                </div>
                <div class="form-group">
                    <label><?php trans_e("Mobile phone", "account"); ?><span class="required">*</span></label>
                    <input type="text" name="mobile" id="mobile" class="form-control" value="<?= $address->mobile; ?>" required>
                </div>
                <div class="form-group">
                    <label><?php trans_e("Additional information", "account"); ?></label>
                    <textarea rows="5" name="info" id="info" class="form-control"><?= $address->info; ?></textarea>
                </div>
                <div class="form-group">
                    <label><?php trans_e("Address title", "account"); ?><span class="required">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= ($address->name!='') ? $address->name : 'My address'; ?>" required>
                    <strong><?php trans_e("Please assign an address title for future reference.", "account"); ?></strong>
                </div>
                <div class="form-group mt-20">
                    <a class="btn btn-large pull-left" href="<?= generate_url( 'account/?tab=addresses' );?>">
                        <i class="fa fa-long-arrow-left"></i> <?php trans_e("Back to your addresses", "account"); ?>
                    </a>
                    <?php if( !is_empty($address->name) ) : ?>
                        <button type="submit" class="btn btn-orange pull-right"><?php trans_e("Update address", "account"); ?></button>
                    <?php else : ?>
                        <button type="submit" class="btn btn-orange pull-right"><?php trans_e("Save address", "account"); ?></button>
                    <?php endif; ?>
                </div>
            </form>
        </div><!-- /.col-sm-6 -->
    </div><!-- /.row -->
</div><!-- /#reset-password -->