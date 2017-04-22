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
<?php 
//Navigation
if( isset($with_nav) && $with_nav === true ) :
	get_view(__FILE__, 'admin/navigation', array('name' => $title, 'icon' => $icon, 'buttons' => $buttons)); 
endif;

//Flash message
if( $msg = get_flash_message() ) :
	get_view(__FILE__, 'alerts', [$msg['type'] => $msg['content']]);
endif;
?>
<?php echo $content; ?>