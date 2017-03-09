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


namespace Core\Controllers;

use Core\Config;


class ControllerException extends \Exception{




	/**
	*==============================================
	* GET EXCEPTION MESSAGE
	*==============================================
	* @param $e
	* @throws Exception
	*/
	public function getException($e){
		if( defined(_LIVE_SITE_) && false === _LIVE_SITE_ )
			return '<div class="alert alert-danger">\
			  <strong>ERROR AT LINE ['. $e->getLine() .']</strong> '. $e->getMessage() .'\
			</div>';

		return false;
	}
	
}