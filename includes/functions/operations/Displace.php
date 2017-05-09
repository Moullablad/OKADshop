<?php //
if(isset($_POST['FID']) && isset($_POST['IDV']) && isset($_POST['table'])){
	$table = $_POST['table'];	 
	$FV = $_POST['FID'];
	$IDV = $_POST['IDV'];
	if(file_exists('../../includes/Classes/DB/DB.class.php')){
            require_once '../../includes/Classes/DB/DB.class.php';
            require_once '../../includes/Classes/Config/Config.class.php';
            require_once '../../includes/Classes/Security/RegX.class.php';
	}else{
            die('Erreur d\'include de l\'un des fichiers');
	}
	
	$Security = new RegX;
	if(!$Security->check_numbers($IDV)){
		$Error_IDV = 1;
	}
	if(!$Security->check_noSpecialCaracters($FV)){
		$Error_FV = 1;
	}
	if(!$Security->check_noSpecialCaracters($table)){
		$Error_table = 1;
	}		
	if($Error_IDV == 1 || $Error_IDF == 1 || $Error_table == 1){
		die('ED');	//Error data
	}else{
            $session = new Session();
            $DB = new Database();
            ///M = down   else = top
            if($FV == 'M')
            {
                $SQL = "SELECT max(`order`) from "._DB_PREFIX_."$table";
                //echo $SQL2;
                $RES = $DB->pdo->Query($SQL);
                $ROW = $DB->pdo->FArray($RES);
                if($ROW[0] == '' || $ROW[0] == 0)
                {
                    $SQL = "UPDATE "._DB_PREFIX_."$table set `order` = 1 limit 1";
                    //echo $SQL;
                    if($DB->pdo->Query($SQL))
                    {
                        echo "one field has 1\n";
                    }else{
                        echo "no field has 1\n";
                    }
                }else{
                    echo 'nice';
                }


                        
			$SQL = "SELECT `order` from "._DB_PREFIX_."$table";
                        //echo $SQL;
			$RES = $DB->pdo->Query($SQL);
                        while($ROW = $DB->pdo->FArray($RES))
                        {
                            if($ROW[0] == '' || $ROW[0] == 0)
                            {


                            }else{
                                echo 'good';
                            }
                        }
			$id = mysql_field_name($res, 0);
			$SQL = "UPDATE `"._DB_PREFIX_."$table` SET `order` = `order`+1 where $id = $IDV";			
			$SQL2 = "UPDATE `"._DB_PREFIX_."$table` SET `order` = `order`-1 where `order` = $ORDER+1";
			$DB->pdo->Query($SQL2);
			$DB->pdo->Query($SQL);
                        die();
			die('OK');			
		}else{
			$SQL = "SELECT order from "._DB_PREFIX_."$table";
			$res = $DB->pdo->Query($SQL);			
			$id = mysql_field_name($res, 0);
			$SQL = "UPDATE `"._DB_PREFIX_."$table` SET `order` = `order`-1 where $id = $IDV";			
			$SQL2 = "UPDATE `"._DB_PREFIX_."$table` SET `order` = `order`+1 where `order` = $ORDER-1";
			$DB->pdo->Query($SQL2);
			$DB->pdo->Query($SQL);
                        die($SQL2);
			die('OK');			
		}			
	}
}
?>