<div class="white-popup">
	<div class="newsletter-popup" style="background: #fbfbfb url(<?php echo $bg_image; ?>) no-repeat bottom right;">
		<div class="popup-title">
			<h3><?php trans_e('Newsletter', 'nl'); ?></h3>
			<p class="notice"><?php echo $notice_message; ?></p>
		</div>
		<form class="nl-popup-form" onsubmit="return nl_subscribe(this);">
			<input id="nl-email" placeholder="<?php trans_e('Sign up your email...', 'nl'); ?>" type="email" required>
			<button type="submit" class="button"><?php trans_e('Subscribe', 'nl'); ?></button>
		</form>
		<div class="checkbox">
			<label><input type="checkbox" class="nl-dont-show-again"><?php trans_e('Don’t show this popup again', 'nl'); ?></label>
		</div>
	</div>
</div>