<?php
function ADD(){
	$user=new \Core\Form();
	$form = array(
		array('HIDDEN','module','50','module','module','attributes'),
		array('HIDDEN','redirect','50','redirect','redirect','attributes'),
		array('HIDDEN','mdir','50','mdir','mdir','products'),
		array('DIVSTART','','center-section'),
    	array('DIVSTART','','col-xs-12 col-sm-8'),
    		array('DIVSTART','','left-block'),
    			array('DIVSTART','','left-block'),
    			
    				/*start bleck*/
    				array('DIVSTART','','block'),
    					array('DIVSTART','','form-group'),
    						array('LABEL', l("Nom de l'attribut", "admin")/*Text*/,'control-label'/*class*/,''/*ID*/),
    						array('TEXT','name','form-control','form-control','name','','',''),
    					array('DIVEND'),


    					array('DIVSTART','','form-group'),
    						array('LABEL', l("Language", "admin")/*Text*/,'control-label'/*class*/,''/*ID*/),
    						array('COMBO','id_lang','form-control','id_lang', _DB_PREFIX_.'langs','id','name'),
    					array('DIVEND'),
    				array('DIVEND'),

    				array('DIVSTART','','block clearfix'),
			      	array('TITLE','','','','<h2>'. l("Vérifier tous vos information et cliquer sur le bouton save.", "admin") .'</h2>'),
			        array('DIVSTART','','top-menu-button'),
			        	array('BUTTON', l("Enregistrer l'attribute", "admin"),'send','btn btn-primary','send'),
			        	//array('CBUTTON','Cancel','close',"btn btn-default","close","$('#facebox').fadeOut();$('#overlay').fadeOut();"),
				    	array('DIVEND'),
				    array('DIVEND'),

    			array('DIVEND'),
    		array('DIVEND'),
  		array('DIVEND'),
  	array('DIVEND'),     
	  );

  $user->Draw($form);

//END USER ADD FUNCTION

}

function PADD(){
	$Post = array(
    array( _DB_PREFIX_.'attributes'),
    array('name','name','text','15','text'),
    /*array('id_category','id_category','text','54','text'),*/
    array('id_lang','id_lang','text','65','text'),

  );
  return $Post;
}

function EDIT($ID){


	$user=new Core\Form();
	$form = array(
		array( _DB_PREFIX_.'attributes'/*table*/,'id'/*id table*/,$ID),
	  array('HIDDEN','module','module',50,'module','module','attributes'),
	  array('HIDDEN','mdir','mdir',50,'mdir','mdir','products'),

		array('DIVSTART','','center-section'),
    	array('DIVSTART','','col-xs-12 col-sm-8'),
    		array('DIVSTART','','left-block'),
    			array('DIVSTART','','left-block'),
    			
    				/*start bleck*/
    				array('DIVSTART','','block'),
    					array('DIVSTART','','form-group'),
    						array('LABEL', l("Nom de l'attribute", "admin")/*Text*/,'control-label'/*class*/,''/*ID*/),
                array('TEXT','name'/*name field*/,'name'/*name post*/,'40'/*size post*/,'form-control'/*class*/,'name'/*id*/),
    					array('DIVEND'),

    					array('DIVSTART','','form-group'),
    						array('LABEL', l("Language", "admin")/*Text*/,'control-label'/*class*/,''/*ID*/),
    						//array('COMBO','id_lang','form-control','id_lang','langs','id','name'),
                array('COMBO','id_lang','id_lang','form-control','id_lang', _DB_PREFIX_.'langs','id','name'),
    					array('DIVEND'),
    				array('DIVEND'),
    				array('DIVSTART','','block clearfix'),
			      	array('TITLE','','','','<h2>'. l("Vérifier tous vos information et cliquer sur le bouton save.", "admin") .'</h2>'),
			        array('DIVSTART','','top-menu-button'),
			        	array('BUTTON', l("Enregistrer l'attribute", "admin"),'send','btn btn-primary','send'),
			        	//array('CBUTTON','Cancel','close',"btn btn-default","close","$('#facebox').fadeOut();$('#overlay').fadeOut();"),
				    	array('DIVEND'),
				    array('DIVEND'),

    			array('DIVEND'),
    		array('DIVEND'),
  		array('DIVEND'),
  	array('DIVEND'),     
	  );

  $user->EDraw($form);

//END USER ADD FUNCTION
}

function PEDIT()
{
    $Post = array();
    array_push($Post,array( _DB_PREFIX_.'attributes'/*table*/));
    array_push($Post,array('W'/*where*/,'id'/*field id*/,'ID'/*property id*/));
   	array_push($Post,array('name'/*name field*/,'name'/*name post*/,'text'/*type verification*/,'45'/*size post*/));
    array_push($Post,array('id_lang'/*name field*/,'id_lang'/*name post*/,'text'/*type verification*/,'45'/*size post*/));
   	return $Post;
}
