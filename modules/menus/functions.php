<?php
use Core\Database\Database;
use Core\i18n\Language;

function getMenuItemTrans($id_menu_item,$id_lang = null){
 
	if( !is_numeric($id_menu_item) || $id_menu_item < 1 ) return fasle;
    if( is_null($id_lang) ) $id_lang = Language::getLanguage()->id;
    
 	$db = Database::getInstance();

 	$menu_item = $db->prepare("
        SELECT * FROM `{$db->prefix}menu_item` WHERE `id`=?",
        [$id_menu_item], true
    );
    if( !$menu_item ) return fasle;

    $trans = $db->prepare("
        SELECT * FROM `{$db->prefix}menu_item_trans` WHERE `id_menu_item`=? AND `id_lang`=?", 
        [$id_menu_item, $id_lang], true
    );
    
   	return (object) array_merge((array)$menu_item, (array)$trans);

}

function getMenuTrans($id_menu,$id_lang = null){
 	

	if( !is_numeric($id_menu) || $id_menu < 1 ) return fasle;
    if( is_null($id_lang) ) $id_lang = Language::getLanguage()->id;
    
 	$db = Database::getInstance();

 	$menu = $db->prepare("
        SELECT * FROM `{$db->prefix}menu` WHERE `id`=?",
        [$id_menu], true
    );
    if( !$menu ) return fasle;

    $trans = $db->prepare("
        SELECT * FROM `{$db->prefix}menu_trans` WHERE `id_menu`=? AND `id_lang`=?", 
        [$id_menu, $id_lang], true
    );

   	return (object) array_merge((array)$menu, (array)$trans);

}