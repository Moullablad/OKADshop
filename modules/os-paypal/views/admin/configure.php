<div class="panel panel-default">
<form class="form-horizontal" method="post" action="">
  <div class="panel-heading"><?= l("Pay with Paypal", "paypal");?></div>
  <div class="panel-body">

    <div class="alert alert-info">
      <h4>Get PayPal credentials</h4>
      <p style="margin-bottom: 8px;">Click on the button below and fill in your information to get access credentials.</p>
      <a onclick="openPaypalPage();" class="btn btn-default" href="#" role="button">Get credentials</a>
    </div>

    <div class="form-group">
      <label class="control-label col-lg-2" for="username"><?=l("Username *", "paypal");?></label>
      <div class="col-lg-4">
        <input type="text" name="username" id="username" class="form-control" required autofocus value="<?= $username;?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-2" for="password"><?=l("Password *", "paypal");?></label>
      <div class="col-lg-4">
        <input type="text" name="password" id="password *" class="form-control" required value="<?= $password;?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-2" for="signature"><?=l("Signature *", "paypal");?></label>
      <div class="col-lg-4">
        <input type="text" name="signature" id="signature *" class="form-control" required value="<?= $signature;?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-2" for="direction"><?=l("Test mode", "core");?></label>
      <div class="col-lg-4">
        <input type="checkbox" name="test_mode" class="active" id="test_mode" value="1" <?=($test_mode == "1") ? 'checked' : '';?> data-on-text="<?=l("YES", "core");?>" data-off-text="<?=l("NO", "core");?>" />
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-4 col-lg-offset-2">
        <button type="submit" class="btn btn-primary"><?=l("Save credentials", "paypal");?></button>
      </div>
    </div>

  </div><!--/ .panel-body -->
</div>

<script>
    function openPaypalPage() {
        var myWindow = window.open("https://www.paypal.com/us/cgi-bin/webscr?cmd=_get-api-signature&generic-flow=true", "", "left=500,width=600,height=600");

    }
</script>