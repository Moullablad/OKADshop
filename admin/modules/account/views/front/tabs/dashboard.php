<div class="col-sm-12 mb-20">
	<div class="general-infos">
		<div class="row welcome p-30">
			<div class="col-md-10">
				<h3><?php trans_e("Welcome to your account.", "account"); ?></h3>
				<p><?php trans_e("Here you can manage all of your personal information and orders.", "account"); ?></p>
			</div>
			<div class="col-md-2">
				<a href="<?=get_url('account/logout');?>" class="signout">
					<i class="fa fa-sign-out"></i> <?php trans_e("Sign Out", "account"); ?>
				</a>
			</div>
		</div><!-- /.row -->
		<div class="row states m-0">
			<div class="col-md-2 box">
				<strong>0</strong>
				<p><?php trans_e("All Orders", "account"); ?></p>
			</div>
			<div class="col-md-2 box">
				<strong>0</strong>
				<p><?php trans_e("Awaiting payment", "account"); ?></p>
			</div>
			<div class="col-md-2 box">
				<strong>0</strong>
				<p><?php trans_e("Awaiting Delivery", "account"); ?></p>
			</div>
			<div class="col-md-2 box">
				<strong>0</strong>
				<p><?php trans_e("Awaiting feedback", "account"); ?></p>
			</div>
			<div class="col-md-2 box">
				<strong>0</strong>
				<p><?php trans_e("Dispute", "account"); ?></p>
			</div>
			<div class="col-md-2 box">
				<strong>0</strong>
				<p><?php trans_e("More", "account"); ?></p>
			</div>
		</div><!-- /.row -->
	</div>
</div>
<div class="col-sm-12">
	<div class="info box">
		<!--div class="avatar">
			<img src="<?//=get_avatar($user->id);?>" width="70" class="img-circle">
			<ul>
				<li><?php //trans_e("Feedback", "account"); ?> <span class="orange">0</span></li>
				<li><?php //trans_e("Unread Messages", "account"); ?> <span class="orange">0</span></li>
			</ul>
		</div-->
		<h1><?php trans_e("Your Personal information", "account"); ?></h1>	
		<?php //get_view(__FILE__, 'front/register'); ?>


		<ul class="user-info">
			<li><?= $user->first_name .' '. $user->last_name;?></li>
			<li><?= $user->address; ?></li>
			<li><?= $user->phone; ?></li>
			<li><?= $user->mobile; ?></li>
			<li><?= $user->city; ?></li>
			<li><?= $user->country; ?></li>
			<li><?= date('d F Y', strtotime($user->birthday)); ?></li>
		</ul>
		<a href="<?=get_url('account/update');?>" class="btn btn-orange pull-right" style="width: 128px;"><?php trans_e("Update", "account"); ?></a>
		<div class="clearfix"></div>
	</div>

</div>