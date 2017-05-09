<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-cogs"></i> <?= l("Configure", "bw");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" method="post" action="">
  <div class="panel-heading"><?= l("Payment by check", "bw");?></div>
  <div class="panel-body">

    <?php if( !is_empty($message) ) : ?>
      <div class="alert alert-success"><?=$message;?></div>
    <?php endif; ?>

    <div class="alert alert-info">
      <p><strong><?php trans_e("This module allows you to accept secure payments by bank wire.", "bw"); ?></strong></p>
      <p><?php trans_e("If the client chooses to pay by bank wire, the order's status will change to 'Waiting for Payment.'", "bw"); ?></p>
      <p><?php trans_e("That said, you must manually confirm the order upon receiving the bank wire.", "bw"); ?></p>
    </div>

    <div class="form-group">
      <label class="control-label col-lg-2" for="owner"><?php trans_e("Account owner *", "bw");?></label>
      <div class="col-lg-4">
        <input type="text" name="owner" id="owner" class="form-control" required autofocus value="<?= $owner;?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-2" for="details"><?php trans_e("Details *", "bw");?></label>
      <div class="col-lg-4">
        <input type="text" name="details" id="details" class="form-control" required value="<?= $details;?>">
        <strong><?php trans_e("Such as bank branch, IBAN number, BIC, etc.", "bw"); ?></strong>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-2" for="address"><?php trans_e("Bank address *", "bw");?></label>
      <div class="col-lg-4">
        <input type="text" name="address" id="address" class="form-control" required value="<?= $address;?>">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-4 col-lg-offset-2">
        <button type="submit" class="btn btn-success"><?php trans_e("Save", "bw");?></button>
      </div>
    </div>




  </div><!--/ .panel-body -->
</div>