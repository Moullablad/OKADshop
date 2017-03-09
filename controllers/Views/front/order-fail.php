<div class="container" style="margin: 50px auto;">
    <div class="alert alert-danger">
		<h4><?php trans_e("Payment failed", "core"); ?></h4>
		<p><?php trans_e("ERROR MESSAGE:", "core"); ?> <?= $message; ?></p>
		<p><a class="btn btn-default" href="<?= generate_url( 'order/payment' );?>"><?php trans_e("Choose another payment gateway.", "core"); ?></a></p>
	</div>
</div>