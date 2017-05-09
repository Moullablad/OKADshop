<?php
/**
 * 2016 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 OKADshop
 */

?>
<?php if(isset($error)) : ?>
	<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" style="top: 0px;right: 5px;">×</button>
		<?=$error;?>
	</div>
<?php elseif(isset($success)) : ?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" style="top: 0px;right: 5px;">×</button>
		<?=$success;?>
	</div>
<?php endif; ?>