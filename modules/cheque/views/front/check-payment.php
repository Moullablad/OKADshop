<div class="container" style="margin:25px auto;">
	<div class="panel panel-default">
		<div class="panel-heading"><?php trans_e("Check payment", "cheque");?></div>
		<div class="panel-body">
			<ul>
		    	<li><strong><?php trans_e("You have chosen to pay by check. Here is a short summary of your order:", "cheque");?></strong></li>
		    	<li><?php trans_e("The total amount of your order comes to:", "cheque");?> <strong><?=$cart_total;?></strong> (tax incl.)</li>
		    	<li><?php trans_e("We accept several currencies to receive payments by check.", "cheque");?></li>
		    	<li><?php trans_e("Check owner and address information will be displayed on the next page.", "cheque");?></li>
		    	<li><?php trans_e("Please confirm your order by clicking 'I confirm my order'.", "cheque");?></li>
		    </ul>
		</div>
	</div>
	<form method="post" action="<?= generate_url( 'order/payment/cheque' ); ?>">
		<a class="button pull-left" href="<?= generate_url( 'order/payment' ); ?>"><?php trans_e("Other payment methods", "cheque");?></a>
		<input type="hidden" name="confirm" value="1">
		<button type="submit" class="button checkout-button pull-right"><?php trans_e("I confirm my order", "cheque");?></a>
	</form>
</div>