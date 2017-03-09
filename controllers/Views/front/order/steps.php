<div class="f1-steps mt-50 mb-50">
    <div class="f1-progress">
        <div class="f1-progress-line" data-now-value="12.5" data-number-of-steps="5" style="width: 12.5%;"></div>
    </div>
    <div class="f1-step <?= ($page == 'summary') ? 'active' : '';?>">
        <div class="f1-step-icon"><i class="fa fa-list-ol"></i></div>
        <p><?php trans_e("Summary", "core"); ?></p>
    </div>
    <div class="f1-step">
        <div class="f1-step-icon"><i class="fa fa-key"></i></div>
        <p><?php trans_e("Sign in", "core"); ?></p>
    </div>
    <div class="f1-step <?= ($page == 'address') ? 'active' : '';?>">
        <div class="f1-step-icon"><i class="fa fa-map-marker"></i></div>
        <p><?php trans_e("Address", "core"); ?></p>
    </div>
    <div class="f1-step <?= ($page == 'shipping') ? 'active' : '';?>">
        <div class="f1-step-icon"><i class="fa fa-truck"></i></div>
        <p><?php trans_e("Shipping", "core"); ?></p>
    </div>
    <div class="f1-step <?= ($page == 'payment') ? 'active' : '';?>">
        <div class="f1-step-icon"><i class="fa fa-credit-card-alt"></i></div>
        <p><?php trans_e("Payment", "core"); ?></p>
    </div>
</div><!-- ./Step Checkout-->