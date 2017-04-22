<div class="container" id="main-container">
    <div class="row">
    	<!-- message notification -->
        <div class="col-sm-12">
        	<?php //get_view(__FILE__, 'alerts', $message); ?>
        </div>

        <div class="col-sm-4">
            <h2><?php trans_e("Login", "account"); ?></h2>
            <?php get_section('before_login'); ?>
            <form class="osForm"  role="form" method="POST" action="<?= get_url('account/login'); ?>">
            	<input type="hidden" name="redirect_to" value="<?=$redirect_to;?>">
            	<div class="form-group">
				    <label for="email"><?php trans_e("Username or email address", "account"); ?> *</label>
				    <input value="<?=(isset($user->email)) ? $user->email : '';?>" type="email" name="email" class="form-control" id="email" placeholder="<?php trans_e("Your E-mail or Username...", "account"); ?>" required>
				</div>
				<div class="form-group">
				    <label for="password"><?php trans_e("Password", "account"); ?> *</label>
				    <input type="password" name="password" class="form-control" id="email" placeholder="<?php trans_e("Your Password...", "account"); ?>" required>
				</div>
				<div class="form-group">
				    <label for="rememberme" class="inline">
				       <input name="rememberme" id="rememberme" value="forever" type="checkbox"> 
				       <?php trans_e("Remember me", "account"); ?>
                    </label>
                    <a href="<?= get_url().'account/password'; ?>" class="pull-right"><?php trans_e("Lost your password?", "account"); ?></a>
				</div>
				<div class="form-group">
				    <input type="submit" class="btn btn-large" value="<?php trans_e("Login", "account"); ?>">
				</div>
            </form>
            <?php get_section('after_login'); ?>
        </div><!-- /.col-sm-4 -->

        <div class="col-sm-4 col-sm-offset-2">
        	<form class="osForm" role="form" action="<?= get_url('account/register');?>" method="POST">
        		<input type="hidden" name="redirect_to" value="<?=$redirect_to;?>">
            	<h2><?php trans_e("Register", "account"); ?></h2>
            	<div class="form-group">
				    <label for="email"><?php trans_e("Email address", "account"); ?></label>
				    <input type="email" name="email" class="form-control" id="email" placeholder="<?php trans_e("Your E-mail...", "account"); ?>" required>
				</div>
				<div class="form-group">
				    <input type="submit" class="btn btn-large" value="<?php trans_e("Register", "account"); ?>">
				</div>
            </form>
        </div>
    </div><!-- /.row -->
</div><!-- /#reset-password -->