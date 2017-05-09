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

if (!defined('_OS_VERSION_'))
  exit;

/**
 * Register translation domain
 */
add_domain(__FILE__, 'qv');


/**
 * Register medias
 */
add_css('quickview', ['src' => module_url(__FILE__, 'assets/quickview.css')]);
add_js('quickview', ['src' => module_url(__FILE__, 'assets/quickview.js')]);
