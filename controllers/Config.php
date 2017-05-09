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

namespace Core;

class Config {
	
	private $settings = [];
	private static $_instance;

	public function __construct()
	{
		$file = dirname(__DIR__) . '/config/config.inc.php';
		$this->settings = require($file);
	}

	public static function getInstance()
	{
		if( is_null(self::$_instance) ){
			self::$_instance = new Config();
		}
		return self::$_instance;
	}

	public function get($key)
	{
		if( !isset($this->settings[$key]) ){
			return null;
		}
		return $this->settings[$key];
	}



//END CLASS	
}