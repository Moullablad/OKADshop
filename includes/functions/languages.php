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

use Core\i18n\Translate;
use Core\i18n\Language;


/**
 * Add trans domain
 *
 * @param string $file
 * @param string $name
 * @return void
 */
function add_domain($file, $name){
	return Translate::addDomain($file, $name);
}


/**
 * GET LANGUAGES LIST
 *
 * @return object $languages
 */
function get_languages(){
	return Language::getLanguages();
}


/**
 * GET CURRENT LANGUAGE
 *
 * @return object $language
 */
function get_lang($key=null){
	return Language::getLanguage($key);
}


/**
 * Get data by field name
 *
 * @param $field string
 * @param $value string
 * @return object $result
 */
function get_by_field($field, $value){
	return Language::getByField($field, $value);
}


/**
 * TRANSLATE GIVING STRING
 *
 * @param string $msgid
 * @param string $domain
 * @return string $string
 */
function trans($msgid, $domain){
	$domains = Translate::$domains;
	if( isset($domains[$domain]) ){
		$domain = $domains[$domain];
	}
	if( isset($GLOBALS['os']->trans[$domain][$msgid]) ){
		return $GLOBALS['os']->trans[$domain][$msgid];
	}
	return $msgid;
}


/**
 * TRANSLATE GIVING STRING
 *
 * @param string $msgid
 * @param string $domain
 * @return string $string
 */
function trans_e($msgid, $domain){
	echo trans($msgid, $domain);
}


function l($msgid, $domain='core'){
	return trans($msgid, $domain);
}



/**
 * GET TRANSLATION
 *
 * 
 * @param string $table Parent table
 * @param string $table_trans Table contain strings
 * @param int    $foreign_key
 * @param int 	 $id_lang
 * @param string $condition Aditional condition to filter results
 * @param bool   $one Limit results to 1 if true
 *
 * @version 1.0.0
 * @copyright 2016 OKADshop
 *
 * @return object $trans
 */
function get_trans($table, $table_trans, $foreign_key, $condition=null, $id_lang=null, $one=false){
	if( is_null($id_lang) ) $id_lang = get_lang()->id;
	$db = getDB();
	$table_parent = $db->prefix . $table;
	$table_trans  = $db->prefix . $table_trans;
	return $db->prepare("
		SELECT t.*, p.* FROM `{$table_parent}` p
		LEFT JOIN `{$table_trans}` t ON t.{$foreign_key} = p.id
		WHERE t.id_lang = CASE 
		    WHEN EXISTS(
		        SELECT 1 
		        FROM `{$table_trans}` t 
		        WHERE t.id_lang = {$id_lang}
		        AND t.{$foreign_key} = p.id
		    )
		    THEN (
		        {$id_lang}
		    ) 
		    ELSE p.id_lang
		END
		{$condition}
	", [], $one);
}