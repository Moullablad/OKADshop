<section class="newsletter_block">
	<div class="container">
	    <div class="row">	
	    	<div class="col-md-6 col-xs-12">
	    		<h4><?php trans_e("Subscribe to our newsletter.", "nl"); ?></h4>
	    	</div>
	    	<div class="col-md-6 col-xs-12">
	    		<form class="form-horizontal nl-block-form" onsubmit="return nl_subscribe(this);">
	    			<div class="input-group pull-right-lg">
					   <input type="email" id="nl-email" class="form-control" placeholder="<?php trans_e("Your Email...", "nl"); ?>" name="email" required>
					   <span class="input-group-btn">
					        <button type="submit" class="btn btn-default" name="submit">
					        	<i class="fa fa-send"></i>
					        </button>
					   </span>
					</div>
	    		</form>
	    	</div>
	    </div>
	</div>
</section>