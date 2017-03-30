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
 *
 * ------------------------------------------------------------------
 * THIS FILE GROUP ALL CORE FUNCTIONS
 * ------------------------------------------------------------------
 *
 *
 */


use Core\Cookie;
use Core\Session;
use Core\Image;
use Core\Module;
use Core\Controllers\Front\SeoController;
use Core\Controllers\Front\ShopController;
use Core\Database\Database;



/**
 * Get database
 *
 */
function getDB(){
	return Database::getInstance();
}	


/**
 * Find elements by column
 * @param string $table
 * @param string $column
 * @param string $value
 * @param bool $one
 * @return $datas array
 */
function findByColumn($table, $column, $value, $one=false){
	return Database::getInstance()->findByColumn($table, $column, $value, $one);
}


/**
 * Tell if a page is being called via Ajax
 *
 */
function is_ajax(){
	return ( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}

/*
 * Check if home page
 *
 */
function is_home(){
	if( !isset($_GET['Module']) || $_GET['Module'] == '' ){
		return true;
	}
	return false;
}

/*
 * Tell if a page is being called via Ajax
 *
 */
function is_valid_int($number){
	return is_numeric( $number ) && $number >= 0;
}


function is_localhost() {
	$whitelist = array("localhost", "127.0.0.1", "::1", "192.168.1.10");
    if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) )
        return true;
}




/**
 *
 * GENERATE URL FROM PATH
 *
 * @param $path string
 * @return url string
 **/
function generate_url( $path = null, $id_lang=null ) {
	//get language code
	$lang_code = '';
	if( is_null($id_lang) ){
		$lang_code = get_lang('iso_code');
		if( is_empty($lang_code) ) $lang_code = '';		
	} else {
		$db = getDB();
        $lang = $db->prepare("SELECT iso_code FROM {$db->prefix}langs WHERE id= ?", [$id_lang], true);
        if( isset($lang->iso_code) ){
        	$lang_code = $lang->iso_code;
        }
    }


	//if path null get home url
	if( is_null($path) ) {
		$url = get_shop('home_url') . $lang_code .'/';
		return $url;
	}

	//set scheme type
	$scheme = 'http://';
	$ssl_active = get_shop('ssl_active');
	if( $ssl_active ) $scheme = 'https://';

	//get shop domain
	$shop_domain = get_shop('domain');
	if( is_empty($shop_domain) ) $shop_domain = $_SERVER['HTTP_HOST'];
	
	//get shop physical uri
	$physical_uri = get_shop('physical_uri');
	if( is_empty($physical_uri) ) $physical_uri = '/';

	//get full url
	return $scheme . $shop_domain . $physical_uri . $lang_code . '/' . $path;   
}


/**
 *
 * GET URL
 *
 * @return $url string
 **/
function get_url( $path = null ){
	return generate_url($path);
}


/**
 *
 * Get current url
 *
 * @return $url string
 */
function get_current_url($iso_code=null){
	$uri = 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	if( !is_null($iso_code) && $lang = get_url_param('lang') ){
		return str_replace('/'.$lang, '/'.$iso_code, $uri);
	}
	return $uri;
}


/**
 *
 * Check if file exists from the url
 *
 * @param $url string
 * @return bool
 */
function remote_file_exists($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if( $httpCode == 200 ){return true;}
    return false;
}



/**
 *
 * GET HOME PAGE URL
 *
 * @return URL string
 */
function get_home_url(){
	return generate_url();
}


/**
 *
 * PHP TEST IF ITEMS IN ARRAY OR OBJECT ARE EMPTY
 *
 * @url http://technify.me/code-snippets/php-test-if-items-in-array-or-object-empty/
 * @param int $o
 * @return boolean
 */
function is_empty($o){
	if ( empty($o) ){
		return true;
	} else if ( is_numeric($o) ){
		return false;
	} else if ( is_string($o) ){
		return !strlen(trim($o)); 
	} else if (is_object($o)){
		return is_empty( (array) $o );
	}

	// It's an array!
	foreach($o as $element){
		if ( is_empty($element) ){
			continue; // so far so good.
		} else {
			return false; 
		}
	}

	// all good.
	return true;
}




/**
 *
 * GET WEBSITE URL
 *
 * @return URL string
 **/
function site_url($path=''){
	$home_url = ShopController::get('home_url');
	return $home_url . $path;
}


/**
 * GET WEBSITE BASE URL
 * @return URL string
 **/
function site_base($path=''){
	return str_replace('\\', '/', _BASE_URI_) . $path;
	// $physical_uri = ShopController::get('physical_uri');
	// return $_SERVER['DOCUMENT_ROOT'] . $physical_uri . $path;
}


/**
 * PHP array to object
 *
 * @param $array
 * @return $object
 */ 
function array_to_object($array) {
	$json = json_encode($array);
	return json_decode($json);
}


/**
 *
 * GET META HEADER
 *
 * @return string
 **/
function get_meta($key){
	return SeoController::get_meta($key);
}

/**
 *
 * GET ALL META HEADER
 *
 * @return string
 **/
function all_meta(){
	$meta = SeoController::all_meta();
	$result = "";
	$result .= '<meta name="description" content="'.$meta->meta_description.'" />'."\n\t";
	$result .= '<meta name="keywords" content="'.$meta->meta_keywords.'" />'."\n\t";
	$result .= '<meta name="geo.position" content="'.$meta->geo_position.'" />'."\n\t";
	$result .= $meta->meta_static."\n\t";
	$result .= '<title>'.$meta->meta_title.'</title>'."\n";
	return $result;
}

function os_initialize_ogdata($data){
 	$data = (object)$data;
	$og_data = "";
    $og_data .= '<meta property="og:url" content="'.site_url(). $data->url .'" />'."\n";
    $og_data .= '<meta property="og:type" content="article" />'."\n";
    $og_data .= '<meta property="og:title" content="'.$data->meta_title.'" />'."\n";
    $og_data .= '<meta property="og:description" content="'.$data->description.'" />'."\n";
    $og_data .= '<meta property="og:image" content="'.site_url().$data->image.'" />'."\n";

    os_initialize_meta('meta_static',$og_data);
}


function os_initialize_meta($type,$value){
   SeoController::set_meta($type,$value);
   return;
}


function os_countries(){
	$db = Database::getInstance();
	$res  = $db->prepare("SELECT * FROM `{$db->prefix}countries`");
	return $res;
}

/**
 *
 * GET META VALUE
 *
 * @param string $name
 * @return string
 **/
function get_meta_value($name){
	$db = Database::getInstance();
	$meta = $db->prepare("SELECT `value` FROM `{$db->prefix}meta_value` WHERE `name`=?", [$name], true);
	if( isset($meta->value) )
		return $meta->value;
	return false;
}

/**
 *
 * GET META VALUE
 *
 * @param string $name
 * @param string $value
 * @return string
 **/
function save_meta_value($name, $value){
	$mata = get_meta_value($name);
	$db = Database::getInstance();
	$date = date("Y-m-d H:i:s");
	if( $mata === false ){
		return $db->create('meta_value', array('name' => $name, 'value' => $value, 'cdate' => $date ));
	} else {
		return $db->prepare("UPDATE `{$db->prefix}meta_value` SET `value`=?,`udate`=NOW() WHERE `name`=?", [$value, $name], true);
	}
	return false;
}

/**
 *
 * DELETE META VALUE
 *
 * @param string $name
 * @return boolean
 **/
function remove_meta_value($name){
	$db = Database::getInstance();
	return $db->prepare("DELETE FROM `{$db->prefix}meta_value` WHERE `name`=?", [$name], true);
}


/**
 *
 * Searching multidimensional arrays
 *
 * @param array $array
 * @param string $arr_key
 * @param string $arr_val
 * @throws Exception
 */
function searching_multidimensional($array, $arr_key, $arr_val) {
	foreach ($array as $key => $item){
		if( is_object ( $item ) ){
			if( $item->$arr_key === $arr_val ) return $key;
		} elseif ( $item[ $arr_key ] === $arr_val ){
			return $key;
		} 
	}
	return false;
}


/**
 * Sort a 2 dimensional array based on 1 or more indexes.
 * 
 * array_sort() can be used to sort a rowset like array on one or more
 * 'headers' (keys in the 2th array).
 * 
 * @param array        $array      The array to sort.
 * @param string|array $key        The index(es) to sort the array on.
 * @param int          $sort_flags The optional parameter to modify the sorting 
 *                                 behavior. This parameter does not work when 
 *                                 supplying an array in the $key parameter. 
 * 
 * @return array The sorted array.
 */
function array_sort($array, $key, $sort_flags = SORT_REGULAR) {
	if (is_array($array) && count($array) > 0) {
		if (!empty($key)) {
			$mapping = array();
			foreach ($array as $k => $v) {
				$sort_key = '';
				if (!is_array($key)) {
					$sort_key = $v[$key];
				} else {
					// This should be fixed, now it will be sorted as string
					foreach ($key as $key_key) {
						$sort_key .= $v[$key_key];
					}
					$sort_flags = SORT_STRING;
				}
				$mapping[$k] = $sort_key;
			}
			asort($mapping, $sort_flags);
			$sorted = array();
			foreach ($mapping as $k => $v) {
				$sorted[] = $array[$k];
			}
			return $sorted;
		}
	}
	return $array;
}

function query_trans($table,$trans_table,$id_source,$id_join,$fields,$trans_fields,$id_lang,$id_def_lang,$condition = ""){
	$fields = implode(",", $fields);
	$query = "select $fields ";
	foreach ($trans_fields as $field) {
		$query .= ", coalesce(\n";
		$query .= "      (select $field from $trans_table where $id_join = t2.$id_source";
		$query .= "      and $field <> '' and id_lang = $id_lang),\n";
		$query .= "      (select $field from $trans_table where $id_join = t2.$id_source and";
		$query .= "       $field <> '' and id_lang = $id_def_lang)\n";
		$query .= ") as $field \n";
	}
	$query .= " from $table t2\n";
	if ($condition != "") {
		$query .= "WHERE ".$condition."\n";
	}
	return $query;
}



/**
 *
 * GET FILE NAME FROM URL OR STRING
 *
 * @return file string
 */
function get_filename($file){
	return Image::getFileName($file);
}


/**
 * Slugify
 *
 * @param string $text
 * @return $slug
 */
function slugify($text) {
	// replace non letter or digits by -
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);
	// transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);
	// trim
	$text = trim($text, '-');
	// remove duplicate -
	$text = preg_replace('~-+~', '-', $text);
	// lowercase
	$text = strtolower($text);
	if (empty($text))
	{
		return time();
	}
	return $text;
}


/**
 * Ajax parse url
 *
 * @return $exploded array
 */
function ajax_parse_url(){
	$params = parse_url($_SERVER['HTTP_REFERER']);
	$exploded = array();
	if( isset($params['query']) ){
		parse_str($params['query'], $exploded);
	}
	return $exploded;
}


/**
 * Get Url param
 *
 * @param string $name
 * @return $param_value
 */
function get_url_param($name){
	//check if ajax request
	if( is_ajax() ){
		//$params = parse_url($_SERVER['HTTP_REFERER']);
		//$exploded = array();
		//parse_str($params['query'], $exploded);
		$exploded = ajax_parse_url();
		if( isset($exploded[$name]) ){
			return $exploded[$name];
		}
	} else if( isset($_GET[$name]) ){
		return $_GET[$name];
	}
	return false;
}


/**
 * function xml2array
 *
 * This function is part of the PHP manual.
 *
 * The PHP manual text and comments are covered by the Creative Commons 
 * Attribution 3.0 License, copyright (c) the PHP Documentation Group
 *
 * @author  k dot antczak at livedata dot pl
 * @date    2011-04-22 06:08 UTC
 * @link    http://www.php.net/manual/en/ref.simplexml.php#103617
 * @license http://www.php.net/license/index.php#doc-lic
 * @license http://creativecommons.org/licenses/by/3.0/
 * @license CC-BY-3.0 <http://spdx.org/licenses/CC-BY-3.0>
 */
function xml2array( $xmlObject, $out = array () )
{
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}


/**
 * Copy folders and files 
 *
 * @param string $source
 * @param string $target
 *
 * @return bool
 */      
function copy_folders($source, $target) {
	try {
		if( is_dir( $source ) ) {
			//create folders if not exist
			if (!file_exists( $target )) {
				mkdir($target, 0777, true);
			}
			$files = preg_grep('/^([^.])/', scandir($source));
			foreach ( $files as $file ) {
				if($file != "." && $file != "..") {
					copy_folders( "$source/$file", "$target/$file" );
				}
			}
		}elseif( file_exists( $source ) ) {
			copy( $source, $target );
		}
		return true;
	} catch (Exception $e) {
		return false;
	}
}


/**
 * Remove folders and files 
 *
 * @param string $dir
 *
 * @return bool
 */  
function remove_folders($dir) {
	try {
		if (is_dir($dir)) {
			$files = scandir($dir);
			foreach ($files as $file){
				if ($file != "." && $file != ".."){
					remove_folders("$dir/$file");
				}
			}
			chmod($dir, 0750);
			rmdir($dir);
		}elseif( file_exists($dir) )
		{
			// Everything for owner, read and execute for owner's group
			chmod($dir, 0750);
			unlink($dir);
		}
		return true;
	} catch (Exception $e) {
		return false;
	}
}



/**
 * Content Word Limit
 *
 * @param string $content
 * @param int $limit
 * @return $content
 */ 
function word_limit($content, $limit) {
	$limit += 1;
	$content = explode(' ', $content, $limit);
	if (count($content)>=$limit) {
		array_pop($content);
		$content = implode(" ", $content).'...';
	} else {
		$content = implode(" ", $content);
	} 
	$content = preg_replace('/\[.+\]/','', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}


/**
 * Limit text length
 *
 * @param string $content
 * @param int $limit
 * @return $content
 */ 
function letters_limit($content, $limit) {
	// strip tags to avoid breaking any html
	$content = strip_tags($content);
	if (strlen($content) > $limit) {
	    // truncate content
	    $stringCut = substr($content, 0, $limit);
	    // make sure it ends in a word so assassinate doesn't become ass...
	    $content = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
	}
	return $content;
}



/**
 * Create cookie
 *
 * @param string $name
 * @param string $value
 * @return bool
 */ 
function create_cookie($name, $value){
	return Cookie::set($name, $value);
}

/**
 * Read cookie
 *
 * @param string $name
 * @return $cookie_value
 */ 
function read_cookie($name){
	return Cookie::get($name);
}

/**
 * Erase cookie
 *
 * @param string $name
 * @return bool
 */ 
function erase_cookie($name){
	return Cookie::destroy($name);
}





/**
 * Create session
 *
 * @param string $name
 * @param string $value
 * @return bool
 */ 
function create_session($name, $value){
	return Session::set($name, $value);
}

/**
 * Read session
 *
 * @param string $name
 * @return $cookie_value
 */ 
function read_session($name){
	return Session::get($name);
}

/**
 * Erase session
 *
 * @param string $name
 * @return bool
 */ 
function erase_session($name){
	return Session::destroy($name);
}



/**
 * Set flash message
 *
 * @return $message array
 */
function set_flash_message($type, $message){
	return create_session('flash_message', ['type' => $type, 'content' => $message]);
}


/**
 * Get flash message
 *
 * @return $message array
 */
function get_flash_message(){
	if( $message = read_session('flash_message') ) {
		erase_session('flash_message');
		// unset($_SESSION['flash_message']);
		// var_dump($message);
		return $message;
	}
	return false;
}


function dd($var){
	echo '<pre>';
	print_r($var);
	echo '</pre>';
	exit;
}