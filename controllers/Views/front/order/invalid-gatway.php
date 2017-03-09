<div class="container">
	<div class="alert alert-danger">
		<h4><?php trans_e("Invalid payment gatway", "core"); ?></h4>
		<p><a class="btn btn-default" href="<?= generate_url( 'order/payment' );?>"><?php trans_e("Choose another payment gateway.", "core"); ?></a></p>
	</div>
</div>