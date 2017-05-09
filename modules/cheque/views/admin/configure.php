<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-cogs"></i> <?= l("Configure", "cheque");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" method="post" action="">
  <div class="panel-heading"><?= l("Payment by check", "cheque");?></div>
  <div class="panel-body">

    <?php if( !is_empty($message) ) : ?>
      <div class="alert alert-success"><?=$message;?></div>
    <?php endif; ?>

    <div class="alert alert-info">
      <p><strong><?php trans_e("This module allows you to accept payments by check.", "cheque");?></strong></p>
      <p><?php trans_e("If the client chooses this payment method, the order status will change to 'Waiting for payment.'", "cheque");?></p>
      <p><?php trans_e("You will need to manually confirm the order as soon as you receive a check.", "cheque");?></p>
    </div>

    <div class="form-group">
      <label class="control-label col-lg-2" for="cheque_name"><?=l("Pay to the order of (name) *", "cheque");?></label>
      <div class="col-lg-4">
        <input type="text" name="cheque_name" id="cheque_name" class="form-control" required autofocus value="<?= $cheque_name;?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-2" for="cheque_address"><?=l("Address", "cheque");?></label>
      <div class="col-lg-4">
        <input type="text" name="cheque_address" id="cheque_address *" class="form-control" required value="<?= $cheque_address;?>">
        <strong><?php trans_e("Address where the check should be sent to.", "cheque");?></strong>
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-4 col-lg-offset-2">
        <button type="submit" class="btn btn-success"><?=l("Save", "cheque");?></button>
      </div>
    </div>




  </div><!--/ .panel-body -->
</div>