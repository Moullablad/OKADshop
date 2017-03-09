<?php
//delete Row from table

class Remove
{

	function Delete($table, $field, $field_value)
	{
        //echo getcwd().;
        if(file_exists('../config/bootstrap.php')){
            require_once '../config/bootstrap.php';
        }else{
            die('File not found initialize');
        }
		$this->Table = $table;
		$this->IDV = $field;
		$this->ID = $field_value;
		//$session = new Session();			
		$Security = new Security;
		if($Security->check_noSpecialCaracters($this->Table))
		{
                    if($Security->check_noSpecialCaracters($this->ID))
                    {
                        if($Security->check_noSpecialCaracters($this->IDV))
                        {
                            $DB = Database::getInstance();
                            /*
                            if($DB->pdo->Show_tables($this->Table))
                            {
                                */
                                //$this->SQL = 'DELETE FROM '.$this->Table.' where '.$this->ID.'='.$this->IDV;
                                $this->SQL = 'update '. _DB_PREFIX_ . $this->Table.' set deleted = 1 where '.$this->ID.'='.$this->IDV;
                                //die($this->SQL);
                                if($DB->pdo->Query($this->SQL))
                                {
                                    return 'OK';
                                }else{
                                    return 'UE';//Unknown Error
                                }
                                /*
                            }else{
                                echo 'Probleme de nom de table : '.$this->Table;//table problem
                            }
                            */
                        }else{
                            echo 'Error Table Field Value';
                        }
                    }else{
                        echo '<center>Erreur : Nom de champs est incorrect<center><br>';
                    }
		}else{
                    echo 'Error Table Name';
		}
	}
}
?>
