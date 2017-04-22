<div class="cancel-popup">
	<div class="message"><?php trans_e("Are you sure to delete this Item?", "core"); ?></div>
	<div class="buttons">
	<a onclick="jQuery.magnificPopup.close();" class="btn btn-default"><?php trans_e("No", "core"); ?></a>
	<a onclick="return jQuery(popup_target).trigger('click');" class="btn btn-danger pull-right"><?php trans_e("Yes", "core"); ?></a>
	</div>
</div>