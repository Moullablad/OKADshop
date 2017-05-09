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

define('_HOME_URL_', 'http://'.$_SERVER['HTTP_HOST'] . _PHYSICAL_URI_);
define('_BASE_URI_', str_replace('config', '', dirname(__FILE__)) );//$_SERVER['DOCUMENT_ROOT'] . _PHYSICAL_URI_
define('_LANG_DOMAIN_', _BASE_URI_ . 'languages/locale');

if( !defined('_LIVE_SITE_') )
	define("_LIVE_SITE_", false);

define("_OS_VERSION_", "1.0.0.1");
define("_MAX_SIZE_", ini_get('post_max_size'));

//defines
define('APP','OkadShop CMS');
define('DS','/');


// Restrict cookie path
// This is a web path, not a local path, so if you want to restrict cookies to your application directory
// and your URL is http://www.okadshop.com/demo/
// then set the cookie path to "/demo/" (cut off the domain)
define("COOKIE_PATH", _PHYSICAL_URI_);

// Cookies expire in one month
define("COOKIE_EXPIRATION", time()+60*60*24*30);