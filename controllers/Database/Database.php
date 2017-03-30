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

namespace Core\Database; 

// use Core\Config;
use \PDO;

class Database{ 


	/**
     * PDO object
     * @var PDO $pdo
     */
    public $pdo;


    /**
     * DB instance
     * @var instance $instance
     */
    private static $instance = null;


    /**
     * Prefix int
     * @var Database $prefix
     */
    public $prefix;


    /**
     * Constructor
     * @param array $config
     */
	private function __construct(){
		if( is_null($this->pdo) ){
			try {
				$pdo = new PDO('mysql:dbname='._DB_NAME_.';host='._DB_SERVER_, _DB_USER_, _DB_PASS_,
					array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
				);
				$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

				//Enable error on dev mode
				if( _LIVE_SITE_ === false){
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				}

				$this->pdo = $pdo;
			} catch (PDOException $e) {
				throw new pdoDbException($e); 
				//die("PDO CONNECTION ERROR: " . $e->getMessage() . "<br/>");
			}
		}
		$this->prefix = _DB_PREFIX_;
		return $this->pdo;
	}


	/**
     * Get Database instance
     * @return Database $instance
     */
	public static function getInstance()
	{		
		// Singleton pattern
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
	}

 
	/**
     * Query
     * @param string $statement
     * @param boolean $one
     * @return array $datas
     */
	public function query($statement, $one = false) 
	{ 
 
		$req = $this->pdo->query($statement);
		if( 
			strpos( $statement, "UPDATE" ) === 0 ||
			strpos( $statement, "INSERT" ) === 0 ||
			strpos( $statement, "DELETE" ) === 0 ||
			strpos( $statement, "CREATE" ) === 0
		){
			return $req;
		}

		$req->setFetchMode(PDO::FETCH_OBJ);
		if( $one ){
			$datas = $req->fetch();
		} else {
			$datas = $req->fetchAll();
		}
		return (object) $datas; 
	} 


	/**
     * Prepare
     * @param string $statement
     * @param array $attributes
     * @param boolean $one
     * @return array $datas
     */
	public function prepare($statement, $attributes=array(), $one = false, $mode='object'){
		try {
			
			$req = $this->pdo->prepare($statement);
			$res = $req->execute($attributes);
			if( 
				strpos( $statement, "UPDATE" ) === 0 ||
				strpos( $statement, "INSERT" ) === 0 ||
				strpos( $statement, "DELETE" ) === 0
			){
				if (strpos( $statement, "INSERT" ) === 0) {
					return $this->pdo->lastInsertId();
				}
				return $res;
			}

			switch ($mode) {
				case 'object':
					$mode = PDO::FETCH_OBJ;
					break;
				case 'assoc':
					$mode = PDO::FETCH_ASSOC;
					break;
			}

			$req->setFetchMode($mode);

			if( $one ){
				$datas = $req->fetch();
				return $datas;
			} else {
				$datas = $req->fetchAll();
				return $datas;// (object)
			}
			
			return false;

		} catch (Exception $e) {
			return false;
		}
	}


	/**
     * select COLOMNS
     * @param string $table
     * @param string $fields
     * @param boolean $one
     * @return boolean
     */
	public function select($table, $columns, $one = false){
		$table_name = $this->prefix . $table;
		$columns_part = implode(', ', $columns);
		return self::$instance->prepare("SELECT {$columns_part} FROM {$table_name} ORDER BY id DESC", null, $one);
	}


	/**
     * FIND ELEMENTS BY ID
     * @param string $table
     * @param int $id
     * @return datas array
     */
	public function find($table, $id, $columns=array('*')){
		$table_name = $this->prefix . $table;
		$columns_part = implode(', ', $columns);
		return self::$instance->prepare("SELECT {$columns_part} FROM {$table_name} WHERE id = ?", [$id], true);
	}


	/**
     * Find elements by column
     * @param string $table
     * @param string $column
     * @param string $value
     * @param bool $one
     * @return $datas array
     */
	public function findByColumn($table, $column, $value, $one=false){
		$table_name = $this->prefix . $table;
		return self::$instance->prepare("SELECT * FROM {$table_name} WHERE {$column} = ?", [$value], $one);
	}

	/**
     * Find elements by columns
     *
     * @param string $table
     * @param string $column
     * @param string $value
     * @param bool $one
     *
     * @return $datas array
     */
	public function findByColumns($table, $conditions=[], $one=false){
		$sql_part = '';
		$attributes = [];
		$table = $this->prefix . $table;
		foreach ($conditions as $k => $v) {
			if( $k === 0 ) {
				$sql_part .= 'WHERE `'. $v['key'] .'`=? ';

			} else {
				$sql_part .= $v['condition'] .' `'. $v['key'] .'`=?';
			}
			$attributes[] = $v['value'];
		}
		return self::$instance->prepare("SELECT * FROM {$table} $sql_part", $attributes, $one);
	}


	/**
     * GET ALL ELEMENTS FROM TABLE
     * @param string $table
     * @return datas array
     */
	public function all($table){
		return self::$instance->select($table, array('*'));
	}


	/**
     * INSERT A NEW COLOMN
     * @param string $fields
     * @return boolean
     */
	public function create($table, $fields){
		$table_name = $this->prefix . $table;
		$sql_parts = [];
		$attributes = [];
		foreach ($fields as $k => $v) {
			$sql_parts[] = "$k = ?";
			$attributes[] = $v;
		}
		$sql_part = implode(',', $sql_parts);
		return self::$instance->prepare("INSERT INTO {$table_name} SET $sql_part", $attributes, true);
	}
	

	/**
     * GET LAST INSERTED ID
     * @return int last_id
     */
	public function lastInsertId(){
		return $this->pdo->lastInsertId();
	}


	/**
     * UPDATE COLOMN
     * @param string $table
     * @param int $id
     * @param array $fields
     * @return boolean
     */
	public function update($table, $id, $fields){
		$table_name = $this->prefix . $table;
		$sql_parts = [];
		$attributes = [];
		foreach ($fields as $k => $v) {
			$sql_parts[] = "$k = ? ";
			$attributes[] = $v;
		}
		$attributes[] = $id;
		$sql_part = implode(',', $sql_parts);
 
		return self::$instance->prepare("UPDATE {$table_name} SET $sql_part WHERE id = ?", $attributes, true);
	}


	/**
     * DELETE COLOMN
     * @param string $table
     * @param int $id
     * @return boolean
     */
	public function delete($table, $id){
		$table_name = $this->prefix . $table;
		return self::$instance->prepare("DELETE FROM {$table_name} WHERE id = ?", [$id], true);
	}





//END CLASS
}