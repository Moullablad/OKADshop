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

use Core\Theme;
use Core\Controllers\Front\ShopController;
use Core\Controllers\ControllerException;

use Core\Database\Database;


abstract class Controller
{

	/**
     * PDO object
     * @var PDO $db
     */
	public $db;


	/**
     * PDO object
     * @var PDO $db
     */
	protected $prefix;


	/**
     * Constructor
     */
	
	public function __construct(){
		$this->db = Database::getInstance();
		$this->prefix = _DB_PREFIX_;
	}



	/**
     * REDIRECT TO NOT FOUND PAGE
     */
	public static function notFound(){
		header("HTTP/1.0 404 Not Found");
		Theme::getTemplate('404');
	}



	/**
	 *=============================================================
	 * GET STRING BETWEEN
	 *=============================================================
	 * @param string $string
	 * @param string $start
	 * @param string $end
	 * @return string $match
	 **/
	public static function getStringBetween($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }


    /**
	 *=============================================================
	 * VALIDATE POSTED DATA
	 *=============================================================
	 * @param array $data
	 * @param array $fields
	 * @return boolean
	 **/
    public static function validateData($data, $fields){
		if( !is_array($data) || !is_array($fields) )
			return false;

		$data_keys = array_keys($data);
		foreach ($data_keys as $key => $data_key) {
			if( !in_array($data_key, $fields) )
				return false;
		}

		return true;
	}




//END CLASS
}