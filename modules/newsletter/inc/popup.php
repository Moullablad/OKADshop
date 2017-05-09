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
include '../../../config/bootstrap.php';


if( !is_ajax() ) return;

$options = unserialize( get_meta_value('newsletter_options') );
$bg_image = module_url(__FILE__, 'assets/img/bg-popup.jpg');
if( isset($options['bg_image']) ) {
	$bg_image = $options['bg_image'];
}

$notice_message = trans('Don’t show this popup again', 'nl');
if( isset($options['notice_message']) ) {
	$notice_message = $options['notice_message'];
}

ob_start();

get_view(__FILE__, 'front/nl-popup', [
	'bg_image' => $bg_image,
	'notice_message' => $notice_message
]);

$content = ob_get_clean();

echo json_encode(['content' => $content]);