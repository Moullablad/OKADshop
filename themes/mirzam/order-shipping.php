<?php
/**
 * The template for shipping.
 *
 * @link https://okdashop.com
 *
 * @package OKADshop
 *
 *
 * 
 *
 */
?>
<div class="container" id="main-container">
	<?php get_template_view('order-steps', array('page' => $page)); ?>
	

	<?php if( !is_empty($carriers) ) : ?>
	<form method="post" action="<?=$form_action;?>">
		<div class="row">
			<?php get_view(__FILE__, 'alerts', array('info' => trans("Choose a shipping option for this address.", "mirzam"))) ?>
			<table class="table table-bordered" id="carriers">
	            <tbody>
	            	<?php foreach ($carriers as $key => $carrier) : ?>
	                <tr>
	                    <td align="center" width="50">
	                        <input checked="checked" name="id_carrier" type="radio" value="<?= $carrier->id; ?>">
	                    </td>
	                    <td width="95"><img alt="My carrier" src="files/carriers/<?= $carrier->logo; ?>"></td>
	                    <td><strong><?= $carrier->name; ?></strong><br><?= $carrier->description; ?></td>
	                    <td align="center">
	                    	<?php if( $carrier->is_free ) : ?>
	                        	Free
	                        <?php else : ?>
	                        	<?= $carrier->fees .' '. $currency; ?> (tax incl.)
							<?php endif; ?>
	                    </td>
	                </tr>
	                <?php endforeach; ?>
	            </tbody>
	        </table>

	        <div class="alert alert-info">
	        	<label for="terms">
			        <input id="terms" type="checkbox" required>
			        <?php trans_e("I agree to the terms of service and will adhere to them unconditionally.", "mirzam"); ?>
		        </label>
	        </div>
		</div>

        <div class="row">
			<div class="col-sm-12 p-0">
				<a class="btn btn-large pull-left" href="<?= generate_url( 'order/address' );?>"><i class="fa fa-long-arrow-left"></i> <?php trans_e("Addresses", "mirzam"); ?></a> 
	            <button type="submit" class="btn btn-orange pull-right"><?php trans_e("Checkout", "mirzam"); ?> <i class="fa fa-long-arrow-right"></i></button>
			</div>
		</div>

	</form>


	<?php else : ?>
		<?php get_view(__FILE__, 'alerts', array('info' => trans("No career match your delivery address.", "mirzam"))) ?>
        <a class="btn btn-large" href="<?= get_url('order/address');?>">
            <i class="fa fa-long-arrow-left"></i> <?php trans_e("Choose another address", "mirzam"); ?>
        </a>
	<?php endif; ?>
	


	
</div>