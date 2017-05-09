<div class="container" id="main-container">
	<?php get_template_view('order-steps', array('page' => $page)); ?>

	<div class="row">
		<form class="osForm">
		<div class="col-sm-3">
			<div class="form-group">
				<label><?php trans_e("Choose a delivery address:", "mirzam"); ?></label>
				<select id="delivery_address" class="form-control">
					<option value="0" selected><?php trans_e("Choose an address.", "mirzam"); ?></option>
					<?php if( !is_empty($addresses) ) : ?>
						<?php foreach ($addresses as $key => $address) : ?>
							<?php $selected = ( $address->id == $delivery->id) ? 'selected' : ''; ?>
							<option value="<?= $address->id; ?>" <?=$selected;?>><?= $address->name; ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
		</div>
		<div class="col-sm-3 col-sm-offset-3 billing <?= ( $same_address ) ? 'hidden' : '';?>">
			<div class="form-group">
				<label><?php trans_e("Choose a billing address:", "mirzam"); ?></label>
				<select id="billing_address" class="form-control">
					<option value="0" selected><?php trans_e("Choose an address.", "mirzam"); ?></option>
					<?php if( !is_empty($addresses) ) : ?>
						<?php foreach ($addresses as $key => $address) : ?>
							<?php $selected = ( $address->id == $billing->id ) ? 'selected' : ''; ?>
							<option value="<?= $address->id; ?>" <?=$selected;?>><?= $address->name; ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
		</div>
		<div class="col-sm-12">
			<input type="checkbox" id="sameAddresses" value="1" <?= ( $same_address ) ? 'checked' : '';?>>
			<label for="sameAddresses"><?php trans_e("Use the delivery address as the billing address.", "mirzam"); ?></label>
		</div>
		</form>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading"><?php trans_e("Your delivery address", "mirzam"); ?></div>
				<div class="panel-body">
					<?php if( !is_empty($delivery) ) : ?>
						<ul id="delivery">
							<li class="fullname"><?= $delivery->firstname; ?> <?= $delivery->lastname; ?></li>
							<li class="company"><?= $delivery->company; ?></li>
							<li class="addresse"><?= $delivery->addresse; ?></li>
							<li class="codepostal"><?= $delivery->codepostal; ?> <?= $delivery->city; ?></li>
							<li class="country"><?= $delivery->country; ?></li>
							<li class="phone"><?= $delivery->phone; ?></li>
							<li class="mobile"><?= $delivery->mobile; ?></li>
						</ul>
					<?php endif; ?>
					<a href="<?= generate_url( 'account/address/'. $delivery->id );?>" class="btn btn-primary edit_delivery_addr"><i class="fa fa-pencil"></i> <?php trans_e("Edit", "mirzam"); ?></a>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading"><?php trans_e("Your billing address", "mirzam"); ?></div>
				<div class="panel-body">
					<?php if( !is_empty($billing) ) : ?>
						<ul id="billing">
							<li class="fullname"><?= $billing->firstname; ?> <?= $billing->lastname; ?></li>
							<li class="company"><?= $billing->company; ?></li>
							<li class="addresse"><?= $billing->addresse; ?></li>
							<li class="codepostal"><?= $billing->codepostal; ?> <?= $billing->city; ?></li>
							<li class="country"><?= $billing->country; ?></li>
							<li class="phone"><?= $billing->phone; ?></li>
							<li class="mobile"><?= $billing->mobile; ?></li>
						</ul>
					<?php endif; ?>
					<a href="<?= generate_url( 'account/address/'. $billing->id );?>" class="btn btn-primary edit_billing_addr"><i class="fa fa-pencil"></i> <?php trans_e("Edit", "mirzam"); ?></a>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
        	<a href="<?= generate_url( 'account/address' );?>" class="btn btn-success"><i class="fa fa-plus"></i> <?php trans_e("Add a new address", "mirzam"); ?></a>
        </div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-sm-12">
			<a class="btn btn-large pull-left" href="<?= generate_url( 'order/summary' );?>"><i class="fa fa-long-arrow-left"></i> <?php trans_e("Summary", "mirzam"); ?></a> 
            <a href="<?= generate_url( 'order/shipping' );?>" class="btn btn-orange pull-right"><?php trans_e("Checkout", "mirzam"); ?> <i class="fa fa-long-arrow-right"></i></a>
		</div>
	</div>

</div>