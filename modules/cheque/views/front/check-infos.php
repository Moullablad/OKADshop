<div class="alert alert-info">
	<strong><?php trans_e("Make your payment directly into your bank account.", "cheque");?></strong>
	<p><?php trans_e("Please use your Order ID as the payment reference. Your order cannot be shipped until the funds have cleared in your account.", "cheque");?></p>    
</div>
<div class="panel panel-default">
	<div class="panel-heading"><?php trans_e("YOUR CHECK MUST INCLUDE", "cheque");?></div>
	<div class="panel-body">
		<ul>
	    	<li>- <?php trans_e("Payment amount.", "cheque");?> <strong><?php echo $cart_total;?></strong></li>
	    	<li>- <?php trans_e("Payable to the order of", "cheque");?> <strong><?php echo $cheque_name;?></strong></li>
	    	<li>- <?php trans_e("Mail to", "cheque");?> <strong><?php echo $cheque_address;?></strong></li>
	    	<li>- <?php trans_e("Do not forget to include your order reference.", "cheque");?></li>
	    	<li>- <?php trans_e("An email has been sent to you with this information.", "cheque");?></li>
	    	<li>- <strong><?php trans_e("our order will be sent as soon as we receive your payment.", "cheque");?></strong></li>
	    	<li> - <?php trans_e("If you have questions, comments or concerns, please contact our", "cheque");?> <a href="<?php echo generate_url('contact');?>"><?php trans_e("customer service department.", "cheque");?></a>.</li>
	    </ul>
	</div>
</div>