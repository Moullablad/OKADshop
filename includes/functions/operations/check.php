<?php //
if(isset($_POST['FName']) && isset($_POST['FV']) && isset($_POST['ID']) && isset($_POST['Table']) && isset($_POST['IDF'])){
	$FName = $_POST['FName'];	 
	$FV = $_POST['FV'];
	$ID = $_POST['ID'];
	$Table = $_POST['Table'];
	$IDF = $_POST['IDF'];
	if(file_exists('../../includes/Classes/DB/DB.class.php')){
		require_once '../../includes/Classes/DB/DB.class.php';
	}else{
		die('EF DB');
	}
	if(file_exists('../../includes/Classes/Config/Config.class.php')){
		require_once '../../includes/Classes/Config/Config.class.php';
	}else{
		die('EF Config');
	}
	if(file_exists('../../includes/Classes/Security/RegX.class.php')){
		require_once '../../includes/Classes/Security/RegX.class.php';
	}else{
		die('EF RegX');
	}		
	$Security = new RegX;
	if(!$Security->check_numbers($ID)){
		$Error_ID = 1;
	}
	if(!$Security->check_noSpecialCaracters($FName)){
		$Error_FName = 1;
	}	
	if(!$Security->check_numbers($FV)){
		$Error_FV = 1;
	}	
	if(!$Security->check_noSpecialCaracters($Table)){
		$Error_Table = 1;
	}
	if(!$Security->check_noSpecialCaracters($IDF)){
		$Error_IDF = 1;
	}	
	if($Error_ID == 1 || $Error_IDF == 1 || $Error_FName == 1 || $Error_FV == 1 || $Error_Table == 1){
		die('ED');	//Error data
	}else{
		$session = new Session();
		$DB = new Database();	
		$SQL = "UPDATE "._DB_PREFIX_."$Table SET `$FName` = '$FV' WHERE $IDF = $ID";
		if($FV == 0){
			$FV = 1;
		}else{
			$FV = 0;
		}
		$SQLB = "UPDATE "._DB_PREFIX_."$Table SET `$FName` = '$FV' WHERE $IDF = $ID";
		//$DB->pdo->Query($SQL);
		$DB->pdo->Query($SQLB);		
		die('OK');
	}
}

if(isset($_POST['Verify_CSV_File']))
{
    if(file_exists('../../includes/Classes/CSV/GetCompte/GetCompte.class.php'))
    {
        require_once('../../includes/Classes/CSV/GetCompte/GetCompte.class.php');
        $GetCompte = new GetCompte();
        $File = $_POST['Verify_CSV_File'];
        //die($File);
        $GetCompte->GetCompteInfo($File);
    }else{
        die('File was not found file : includes/Classes/CSV/GetCompte/GetCompte.class.php line : '.__line__);
    }
}

?>