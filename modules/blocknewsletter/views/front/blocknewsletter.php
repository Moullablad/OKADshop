 
<section id="newsletter">
	<div class="container">
	    <div class="row">
	    	<div class="col-xs-12 col-md-12">
	    		<?php if (isset($result) && $result): ?>
	    			<div class="alert alert-success" role="alert">
		    			<i class="fa fa-check-circle fa-2x"></i>   <?php trans_e("Vous avez réussi à ajouter votre email", "blocknewsletter"); ?>
		    		</div>
		    	<?php elseif(isset($result) && !$result): ?>	
		    		<div class="alert alert-danger" role="alert">
		    			<i class="fa fa-exclamation-circle fa-2x"></i>  <?php trans_e("Vous n'avez pas réussi à ajouter votre email", "blocknewsletter"); ?>
		    		</div>
	    		<?php endif ?>
	    		
	    	</div>	
	    	<div class="col-md-6 col-xs-12">
	    		<p><?php trans_e("Subscribe to our newsletter.", "blocknewsletter"); ?></p>
	    	</div>
	    	<div class="col-md-6 col-xs-12">
	    		<form class="form-horizontal" action="" method="POST">
	    			<div class="input-group pull-right-lg">
					   <input type="email" class="form-control" placeholder="Your Email..." name="email">
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
</section><!-- /#newsletter -->