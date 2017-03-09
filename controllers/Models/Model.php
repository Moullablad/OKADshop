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
namespace Core\Models;


use Core\Database\Database;


abstract class Model
{

	/**
     * PDO object
     * @var PDO $db
     */
	public $db;


	/**
     * Prefix string
     * @var Prefix $prefix
     */
	public $prefix;


	/**
     * Constructor
     */
	
	public function __construct(){
		$this->db = Database::getInstance();
		$this->prefix = _DB_PREFIX_;
	}



    /**
	 * VALIDATE DATA
	 *
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