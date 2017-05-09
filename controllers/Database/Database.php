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
     * @param string $columns
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
	public function findByColumn($table, $column, $value, $columns=array('*'), $one=false){
		$table_name = $this->prefix . $table;
		$columns_part = implode(', ', $columns);
		return self::$instance->prepare("SELECT {$columns_part} FROM {$table_name} WHERE {$column} = ?", [$value], $one);
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
	public function findByColumns($table, $conditions=[], $columns=array('*'), $one=false){
		$sql_part = '';
		$attributes = [];
		$columns_part = implode(', ', $columns);
		$table = $this->prefix . $table;
		foreach ($conditions as $k => $v) {
			if( $k === 0 ) {
				$sql_part .= 'WHERE `'. $v['key'] .'`=? ';

			} else {
				$sql_part .= $v['condition'] .' `'. $v['key'] .'`=?';
			}
			$attributes[] = $v['value'];
		}
		return self::$instance->prepare("SELECT {$columns_part} FROM {$table} $sql_part", $attributes, $one);
	}


	/**
     * GET ALL ELEMENTS FROM TABLE
     * @param string $table
     * @return datas array
     */
	public function all($table, $columns=array('*')){
		return self::$instance->select($table, $columns);
	}


	/**
     * INSERT A NEW COLOMN
     * @param string $columns
     * @return boolean
     */
	public function create($table, $columns){
		$table_name = $this->prefix . $table;
		$sql_parts = [];
		$attributes = [];
		foreach ($columns as $k => $v) {
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
     * @param array $columns
     * @return boolean
     */
	public function update($table, $id, $columns){
		$table_name = $this->prefix . $table;
		$sql_parts = [];
		$attributes = [];
		foreach ($columns as $k => $v) {
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


	/**
     * Get max value
     *
     * @param string $table
     * @param string $column
     *
     * @return int $max
     */
	public function getMax($table, $column){
		$table_name = $this->prefix . $table;
		$res = self::$instance->prepare("SELECT MAX({$column}) AS max FROM `{$table_name}`", [], true);
		return (isset($res->max)) ? $res->max : 0;
	}


	/**
	 * Get translation
	 *
	 * 
	 * @param array $args Query arguments
	 * $args = [
     *    'table' => [
     *        'c' => 'categories'
     *    ],
     *    'table_trans' => [
     *        'ct' => 'category_trans'
     *    ],
     *    'foreign_key' => 'id_category',
     *    'columns' => [
     *        'c' => '*',
     *        'ct' => '*',
     *        't2' => [
     *            'name' => 'parent_name'
     *        ]
     *    ],
     *    'conditions' => [
     *        [
     *            'key' => 'c.id_parent',
     *            'value' => 1,
     *            'operator' => '<',
     *            'relation' => 'AND'
     *        ]
     *    ],
     *    'joins' => [
     *        [
     *            'type' => 'LEFT JOIN',
     *            'table' => [
     *                't2' => 'category_trans'
     *            ],
     *            'relation' => 't2.id_category = c.id_parent'
     *        ]
     *    ],
     *    'id_lang' => 1,
     *    'orderby' => 'c.id',
     *    'order' => 'DESC',
     *    'limit' => 1,
     *    'debug' => true,
     * ];
	 *
	 * @version 1.0.0
	 * @copyright 2016 OKADshop
	 *
	 * @return array $trans | $query
	 */
	public function trans(array $args){
		// Exit if empty
		if( empty($args['multilangues']) ) 
			return false;

		// Primary table
		$primary_table = reset($args['multilangues'][0]['table']);
		$primary_table_prefix = key($args['multilangues'][0]['table']);

		// Primary table trans
		$primary_trans = reset($args['multilangues'][0]['table_trans']);
		$primary_trans_prefix = key($args['multilangues'][0]['table_trans']);

		// Foreign key
		$foreign_key = $args['multilangues'][0]['foreign_key'];

		// Merge default args with current
		$default = [
            'multilangues' => [],
            'columns' => [],
            'conditions' => [],
            'joins' => [],
            'id_lang' => get_lang()->id,
            'orderby' => $primary_table_prefix .'.id',
            'order' => 'ASC',
            'limit' => 0,
            'debug' => false
        ];
        $args = array_merge($default, $args);

        // Append table trans joins
        array_unshift($args['joins'], [
            'type' => 'LEFT JOIN',
            'table' => $args['multilangues'][0]['table_trans'],
            'relation' => $primary_trans_prefix .'.'. $foreign_key .' = '. $primary_table_prefix .'.id'
        ]);

        // prepare columns to select
		$columns_sql = '';
		if( !empty($args['columns']) ) : 
			foreach ($args['columns'] as $prefix => $cols) :
				if( is_array($cols) ) {
					if( $prefix == '*' ) {
						$columns_sql .= implode('.*, ', $cols) .'.*, ';
					} elseif( isAssoc($cols) ) {
						foreach ($cols as $key => $value) {
							$columns_sql .= $prefix .'.'. $key .' AS '. $value .', ';
						}
					} else {
						$columns_sql .= $prefix .'.'. reset($cols) .', ';
					}
				}
			endforeach;
			$columns_sql = rtrim($columns_sql, ', ');
		else :
			$columns_sql = '*';
		endif;

		// Prepare conditions
		$attributes = array();
		$conditions_sql = '';
		if( !empty($args['conditions']) ) : foreach ($args['conditions'] as $k => $v) :
			$conditions_sql .= $v['relation'] .' '. $v['key'] .' '. $v['operator'] .'? ';
			$attributes[] = $v['value'];
		endforeach; endif;

		// Prepare joins
		$joins_sql = '';
		if( !empty($args['joins']) ) : foreach ($args['joins'] as $k => $v) :
			$join_table = $this->prefix . reset($v['table']);
			$joins_sql .= $v['type'] .' `'. $join_table .'` AS '. key($v['table']) .' ON '. $v['relation'] .' ';
		endforeach; endif;

		$id_lang = $args['id_lang'];
		$orderby = 'ORDER BY '. $args['orderby'] .' '. $args['order'];
		$limit = (intval($args['limit']) > 0) ? ' LIMIT '. $args['limit'] : '';

		// Prepare CASES
		$cases_sql = '';
		if( !empty($args['multilangues']) ) : foreach ($args['multilangues'] as $k => $v) :
			$relation = 'WHERE';
			if( $k != 0 ) $relation = 'AND';

			$table = reset($v['table']);
			$table_prefix = key($v['table']);
			$table_trans = reset($v['table_trans']);
			$table_trans_prefix = key($v['table_trans']);
			$foreign_key = $v['foreign_key'];

			$cases_sql .= "{$relation} {$table_trans_prefix}.id_lang = CASE WHEN EXISTS(SELECT 1 FROM `{$this->prefix}{$table_trans}` AS {$table_trans_prefix} WHERE {$table_trans_prefix}.id_lang = {$id_lang} AND {$table_trans_prefix}.{$foreign_key} = {$table_prefix}.id) THEN ({$id_lang}) ELSE {$table_prefix}.id_lang END ";

		endforeach; endif;

		$query  = "SELECT {$columns_sql} FROM `{$this->prefix}{$primary_table}` AS {$primary_table_prefix} {$joins_sql} {$cases_sql} {$conditions_sql} {$orderby} {$limit}";

		// Return query string
		if( $args['debug'] === TRUE) {
			return $query;
		}

		// Set query limit
		$one = false;
		if(intval($args['limit']) == 1) $one = true;

		// Return query results
		return $this->prepare($query, $attributes, $one);
	}



//END CLASS
}