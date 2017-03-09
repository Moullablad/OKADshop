<div class="container" style="margin:25px auto;">
	<div class="panel panel-default">
		<div class="panel-heading"><?php trans_e("BANK-WIRE PAYMENT", "bw"); ?></div>
		<div class="panel-body">
			<ul>
		    	<li><strong><?php trans_e("You have chosen to pay by bank wire. Here is a short summary of your order:", "bw"); ?></strong></li>
		    	<li><?php trans_e("The total amount of your order comes to:", "bw"); ?> <strong><?=$cart_total;?></strong> (tax incl.)</li>
		    	<li><?php trans_e("Bank wire account information will be displayed on the next page.", "bw"); ?></li>
		    	<li><?php trans_e("Please confirm your order by clicking 'I confirm my order'.", "bw"); ?></li>
		    </ul>
		</div>
	</div>
	<form method="post" action="<?= generate_url( 'order/payment/bankwire' ); ?>">
		<a class="button pull-left" href="<?= generate_url( 'order/payment' ); ?>"><?php trans_e("Other payment methods", "bw"); ?></a>
		<input type="hidden" name="confirm" value="1">
		<button type="submit" class="button checkout-button pull-right"><?php trans_e("I confirm my order", "bw"); ?></a>
	</form>
</div>