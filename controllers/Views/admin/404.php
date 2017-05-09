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
get_view(__FILE__, 'admin/navigation', array('name' => 'Page not Found', 'icon' => 'map-signs')); 
?>
<div class="alert alert-danger" style="border-radius: 0px;">
	<h1 style="font-size: 4em;margin-top: 0px;">404 <small style="font-size: 16px;display: inline;"><?php trans_e("Page not found.", "core"); ?></small></h1>
	<p><?php trans_e("Looks like the page you're trying to visit doesn't exist. Please check the URL and try your luck again.", "core"); ?></p><br>
	<a href="index.php" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> <?php trans_e("Take Me Dashboard", "core"); ?></a>
</div>