<?php
function Show_database($Table,$Field,$IDV,$ID)
{		
	if(file_exists('includes/Classes/DB/DB.class.php')){
		require_once 'includes/Classes/DB/DB.class.php';
	}else{
		die('EF DB');
	}
	if(file_exists('includes/Classes/Config/Config.class.php')){
		require_once 'includes/Classes/Config/Config.class.php';
	}else{
		die('EF Conf');
	}		
	$session = new Session();
	$session->getSession('ESYA');
	$dbserver = $session->getSession('DBSERVER');
	$bdpassword = $session->getSession('BDPASSWORD');
	$dbuser = $session->getSession('DBUSER');
	$dbdatabase = $session->getSession('DBDATABASE');
	$DB = new Database($dbserver,$dbuser,$bdpassword,$dbdatabase);		
	if($DB->pdo->Show_tables($Table))
	{				
		 if(strstr($ID,'.')){
			list($table,$ID)=split('[.]',$ID);
		 }			 
		 if($DB->pdo->Show_field($ID,$Table)){		 	
			$SQL = "select $Field from $Table where $ID = $IDV";				
			$RESAULT = $DB->pdo->Query($SQL);							
			while($ROW = $DB->pdo->FArray($RESAULT)){				
				$sOutput .= '<p><div id="">'.$ROW[0].'</div></p>';	
			}
			die ($sOutput);			 
		 }else{
			die('<script>window.location=window.location;</script>');				 
		 }		
	}else{
		die('<script>window.location=window.location;</script>');	
	}
}
?>