<div class="alert alert-info">
	<strong><?php trans_e("Make your payment directly into your bank account.", "bw"); ?></strong>
	<p><?php trans_e("Please use your Order ID as the payment reference. Your order cannot be shipped until the funds have cleared in your account.", "bw"); ?></p>    
</div>
<div class="panel panel-default">
	<div class="panel-heading"><?php trans_e("YOUR CHECK MUST INCLUDE", "bw"); ?></div>
	<div class="panel-body">
		<ul>
			<li><?php trans_e("Please send us a bank wire with", "bw"); ?></li>
	    	<li>- <?php trans_e("Amount", "bw"); ?> <strong><?php echo $cart_total;?></strong></li>

	    	<li>- <?php trans_e("Name of account owner", "bw"); ?> <strong><?php echo $owner;?></strong></li>
	    	<li>- <?php trans_e("Include these details", "bw"); ?> <strong><?php echo $details;?></strong></li>
	    	<li>- <?php trans_e("Bank name", "bw"); ?> <strong><?php echo $address;?></strong></li>
	    	
	    	<li>- <?php trans_e("Do not forget to include your order reference in the subject of your bank wire.", "bw"); ?></li>
	    	<li>- <?php trans_e("An email has been sent to you with this information.", "bw"); ?></li>
	    	<li>- <strong><?php trans_e("Your order will be sent as soon as we receive your payment.", "bw"); ?></strong></li>
	    	<li> - <?php trans_e("If you have questions, comments or concerns, please contact our", "bw"); ?> <a href="<?php echo generate_url('contact');?>"><?php trans_e("customer service department.", "bw"); ?></a>.</li>
	    </ul>
	</div>
</div>