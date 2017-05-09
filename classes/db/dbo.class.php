<?php
use Core\Security;
class DBO
{
	
	public $POST;
	public $Key;
	Public $Value;
	public $Name;
	public $NValue;
	public $Count;
	public $Table;
	public $ERROR;
	public $RSQL = '';
	public $LSQL;
	public $text;
	

	public static function permalink($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}
	public function INSERT($Data)
	{
		/*
		if(!file_exists('../../includes/Classes/Config/Config.class.php'))
		{
			die('File not found file '.__file__.' At line : '.__line__);
		}*/
		// require_once '../../config/bootstrap.php';
		//require_once('../../includes/Classes/Security/RegX.class.php');
		//require_once('../../functions/Cryptography.fn.php');



		$RegX = new Security();
		//$Config = new Config();

		$this->Count = 0;
		$this->POST = $Data;
		foreach($this->POST as $this->Key=>$this->Value)
		{
			//echo $this->ERROR;
			if($this->ERROR==0)
			{
				if($this->Count==0 && !isset($this->Table))
				{
					$this->Table = $this->Value[0];
					$this->SQL ='INSERT INTO `'.$this->Table.'` (';
				}else{	 							
					if(!isset($_POST[$this->Value[1]]) && strstr('picture',$this->Value[1]))
					{														
						die('EF : Empty field "'.$this->Value[1].'"');
					}
					if(strtoupper($this->Value[4]) != strtoupper('password_confirm')){
						$this->LSQL .= ' `'.$this->Value[0].'`,';						
					}
					if(strtoupper($this->Value[4]) == strtoupper('password')){
						$this->LSQL .= ' `passwordsalt`,';						
					}													
					$this->SecMethode = strtoupper($this->Value[4]);					
					switch($this->SecMethode)
					{
						
						case 'NONE' :
						$this->RSQL .= ' \''.preg_replace("(\r\n|\n|\r)","",htmlentities(addslashes($_POST[$this->Value[1]]),ENT_QUOTES,'UTF-8')).'\',';
						break;
						case 'HTML' :
						$this->RSQL .= ' \''.preg_replace("(\r\n|\n|\r)","",htmlentities(addslashes($_POST[$this->Value[1]]),ENT_QUOTES,'UTF-8')).'\',';
						break;
						case 'TEXT' :	
						$value = (isset($_POST[$this->Value[1]])) ? $_POST[$this->Value[1]] : '';		
						$this->RSQL .= '\''.preg_replace("(\r\n|\n|\r)","",htmlentities(addslashes($value),ENT_QUOTES,'UTF-8')).'\',';
						break;
						case 'TIME' : 							
						if($RegX->check_time($_POST[$this->Value[1]]))
						{
                                                    $this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
						}else
						{
                                                    die('NE : Time error');
						}
						break;						
						case 'EMAIL' :
						if(!empty($_POST[$this->Value[1]]))
						{						
                                                    if($RegX->check_email($_POST[$this->Value[1]]))
                                                    {
                                                        $this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
                                                    }else
                                                    {
                                                        die('NE : Email error');
                                                    }
						}else{
							$this->RSQL .=' \'\',';
						}
						break;						
						///format number
						case 'NUMBER' :	
						if(!empty($_POST[$this->Value[1]]))
						{
							if($RegX->check_numbers($_POST[$this->Value[1]]))
							{
								if(isset($this->Value[5]))
								{
									if($RegX->check_numbers($this->Value[5]))
									{
										$this->RSQL .=' '.$this->Value[5].',';
									}else{
										die('NE : Number error'.$this->Value[1]);
									}
								}else{
									$this->RSQL .=' '.$_POST[$this->Value[1]].',';
								}							
							}else{
								die('NE : Number error'.preg_replace("(\r\n|\n|\r)","",htmlentities(addslashes($this->Value[1]),ENT_QUOTES,'UTF-8')));
							}	
						}else{
							$this->RSQL .='\'\' ,';
						}						
					
						break;
						///lien image tt les format
						case 'IMGLINK' : 
						if($RegX->check_IMG($_POST[$this->Value[1]]))
						{
							$this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
						}else
						{
							die('EV : Image link error');
						}						
						break;
						//lien jpg
						case 'JPGLINK' : 
						if($RegX->check_JPG($_POST[$this->Value[1]]) || $_POST[$this->Value[1]] == '')
						{
							$this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
						}else
						{
							die('EV : JPG link error');
						}						
						break;
						/// lien png
						case 'PNGLINK' : 
						if($RegX->check_PNG($_POST[$this->Value[1]]))
						{
							$this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
						}else
						{
							die('EV : PNG link error');
						}						
						break;	
						///lien bmp
						case 'BMPLINK' : 
						if($RegX->check_BMP($_POST[$this->Value[1]]))
						{
							$this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
						}else
						{
							die('EV : BMP link error');
						}						
						break;	
						//lien gif
						case 'GIFLINK' : 
						if($RegX->check_GIF($_POST[$this->Value[1]]))
						{
							$this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
						}else
						{
							die('EV : GIF link error');
						}						
						break;	
						/////lien pdf
						case 'PDFLINK' : 
						if($RegX->check_PDF($_POST[$this->Value[1]]))
						{
							$this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
						}else
						{
							die('EV : PDF link error');
						}
						/////Color
						case 'COLOR' : 
						if($RegX->check_COLOR($_POST[$this->Value[1]]))
						{
							$this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
						}else
						{
							die('EV : Color hexa error');
						}
						break;							
						/////lien site
						case 'HTTP' :
						if(!empty($_POST[$this->Value[1]]))
						{
							if($RegX->check_HTTP($_POST[$this->Value[1]]))
							{
								$this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
							}else
							{
								die('EV : HTTP link error');
							}
						}else{
							$this->RSQL .=' \'\',';
						}
						break;	
						/////lien site
						case 'IP' :
						if($RegX->check_ip($_POST[$this->Value[1]]))
						{
							$this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
						}else
						{
							die('EV : IP link error');
						}											
						break;	
						/////Date format francais
						case 'DATEFR' : 
						if($RegX->check_DateFR($_POST[$this->Value[1]])){
							
							$Date = substr($_POST[$this->Value[1]],6,4).'-'.substr($_POST[$this->Value[1]],3,2).'-'.substr($_POST[$this->Value[1]],0,2);
							//die($Date);
							$this->RSQL .= '\''.$Date.'\',';
							unset($Date);
						}else{
                                                    $Date = '0000-00-00';
                                                    $this->RSQL .= '\''.$Date.'\',';
                                                    unset($Date);
						}				
						break;
						/////Date format anglais
						case 'DATEEN' : 
						if($RegX->check_DateEN($_POST[$this->Value[1]])){
							$Date = date('Y-m-d', strtotime($_POST[$this->Value[1]]));
							$this->RSQL .= '\''.$Date.'\',';
							unset($Date);
						}else{
							die('NE : Date EN error');							
						}				
						break;
						
						/////Password
						case 'PASSWORD' :
												
						if($RegX->check_pwd($_POST[$this->Value[1]]) || $_POST[$this->Value[1]] == '')
						{
							$Salt = substr(md5(time()),0,10);
							//die(md5($_POST[$this->Value[1]].$Salt));
							$this->RSQL .=' \''.md5($_POST[$this->Value[1]].$Salt).'\',';	
							$this->RSQL .=' \''.$Salt.'\',';													
						}else
						{
							die('EV : PASSWORD error');
						}						
						break;
						/////Password_confirm
						case 'PASSWORD_CONFIRM' : 
							if($RegX->check_pwd($_POST[$this->Value[1]]))
							{							
                                if($_POST[$this->Value[1]] != $_POST[$this->Value[0]])
                                        {
                                            die('EV : PASSWORD CONFIRM error');
                                }
							}else
							{
                                //die('Format de champ \''.ucfirst($this->Value[1]).'\' est incorrect bon format est Float ex : XXXX.XX');
                                die('EV : PASSWORD CONFIRM error');
                            }
						break;
						/////float
						case 'FLOAT' : 
							if($RegX->check_float($_POST[$this->Value[1]]))
							{							
								$this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
							}else
							{
								die('Format de champ \''.ucfirst($this->Value[1]).'\' est incorrect bon format est decimal ex : XXXX.XX');
							}						
						break;
						/////nfloat
						case 'NFLOAT' : 
							if($RegX->check_nfloat($_POST[$this->Value[1]]))
							{							
								$this->RSQL .=' \''.$_POST[$this->Value[1]].'\',';
							}else
							{
								die('EV : NFLOAT error');
							}						
						break;																		
					}
				}
			}else{
					echo 'EFF';//error field format
			}
		}
		$this->SSQL = $this->LSQL;
		$this->ESQL = $this->RSQL;
		$this->SSQL = substr_replace($this->SSQL, "", -1 );
		$this->ESQL = substr_replace($this->ESQL, "", -1 );
		/*
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$Config->WS_DIR.'/includes/Classes/DB/DB.class.php'))
		{
			die('File not found ('.$_SERVER['DOCUMENT_ROOT'].'/'.$Config->WS_DIR.'/includes/Classes/DB/DB.class.php'.') on '.__file__.' at '.__line__);
		}
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/'.$Config->WS_DIR.'/includes/Classes/DB/DB.class.php');
		$session = new Session();
		$DB = new Database();
		*/
		$DB = getDB();
		$this->SQL = $this->SQL.$this->SSQL.',`cdate`) VALUES ('.$this->ESQL.',now());';		
		//die($this->SQL);
		if($DB->pdo->Query($this->SQL))
		{
                    echo '1';
		}else{
                    //die(mysql_error());
                    //$RES = $DB->Query($this->SQL);
                    echo 'Error ('.$this->SQL.')';//Unknown Error
		}
	}
	//////////////////////////////////////////////update
	public function UPDATE($Data)
	{
		// require_once '../../config/bootstrap.php';
		$RegX = new Security();
		$this->Count = 0;
		$this->POST = $Data;		
		foreach($this->POST as $this->Key=>$this->Value)
		{
			
			if($this->ERROR==0)
			{
				if($this->Count==0 && !isset($this->Table))
				{
					$this->Table = $this->Value[0];
					$this->SQL ='UPDATE `'.$this->Table.'` SET ';
					$this->Count++;

				}else{
					if($this->Count == 1)
					{
						$this->WHERE = ',`udate`=now() WHERE `'.$this->Value[1].'` = '.preg_replace("(\r\n|\n|\r)","",htmlentities(addslashes($_POST[$this->Value[2]]),ENT_QUOTES,'UTF-8'));
					}else{
						if(strtoupper($this->Value[2])!= strtoupper('password_confirm')){
							$this->LSQL .= ' `'.$this->Value[0].'`,';
						}
						$this->SecMethode = strtoupper($this->Value[2]);						
						switch ($this->SecMethode) {
							case 'NONE':
								$this->RSQL .= '`'.$this->Value[0].'`=\''.preg_replace("(\r\n|\n|\r)","",htmlentities(addslashes($_POST[$this->Value[1]]),ENT_QUOTES,'UTF-8')).'\',';							
							break;
							case 'HTML':
								$this->RSQL .= '`'.$this->Value[0].'`=\''.preg_replace("(\r\n|\n|\r)","",htmlentities(addslashes($_POST[$this->Value[1]]),ENT_QUOTES,'UTF-8')).'\',';
							break;
							case 'TEXT':
								$this->RSQL .= '`'.$this->Value[0].'`=\''.preg_replace("(\r\n|\n|\r)","",htmlentities(addslashes($_POST[$this->Value[1]]),ENT_QUOTES,'UTF-8')).'\',';
							break;
							case 'PERAMLINK':
								$permalink = $this::permalink($_POST[$this->Value[1]]);
								$this->RSQL .= '`'.$this->Value[0].'`=\''.$permalink.'\',';
							break;

							case 'NUMBER';
							if(!empty($_POST[$this->Value[1]]))
							{

								$this->RSQL .= '`'.$this->Value[0].'`=\''.preg_replace("(\r\n|\n|\r)","",htmlentities(addslashes($_POST[$this->Value[1]]),ENT_QUOTES,'UTF-8')).'\',';
							}else{
								$this->RSQL .= '`'.$this->Value[0].'`=\'\',';
							}
							break;
							///float number verification
							case 'FLOAT';
								if($RegX->check_float($_POST[$this->Value[1]])){
									$this->RSQL .= '`'.$this->Value[0].'`=\''.$_POST[$this->Value[1]].'\',';	
								}else{
                                                                    die('Format de champ \''.ucfirst($this->Value[1]).'\' est incorrect bon format est decimal ex : XXXX.XX');
								}
								$this->RSQL .= '`'.$this->Value[0].'`=\''.preg_replace("(\r\n|\n|\r)","",htmlentities(addslashes($_POST[$this->Value[1]]),ENT_QUOTES,'UTF-8')).'\',';
							break;
							///Color format verification
							case 'COLOR';
								if($RegX->check_COLOR($_POST[$this->Value[1]])){
									$this->RSQL .= '`'.$this->Value[0].'`=\''.$_POST[$this->Value[1]].'\',';	
								}else{
									die('NE : Color error');
								}
								$this->RSQL .= '`'.$this->Value[0].'`=\''.preg_replace("(\r\n|\n|\r)","",htmlentities(addslashes($_POST[$this->Value[1]]),ENT_QUOTES,'UTF-8')).'\',';
							break;

							case 'EMAIL';
							if(!empty($_POST[$this->Value[1]]))
							{
								if($RegX->check_email($_POST[$this->Value[1]])){
									$this->RSQL .= '`'.$this->Value[0].'`=\''.$_POST[$this->Value[1]].'\',';	
								}else{
									die('NE : Email error');
								}	
							}else{
								$this->RSQL .= '`'.$this->Value[0].'`=\'\',';	
							}										

							break;							
							case 'IMGLINK';
								if($RegX->check_IMG($_POST[$this->Value[1]])){
									$this->RSQL .= '`'.$this->Value[0].'`=\''.$_POST[$this->Value[1]].'\',';	
								}else{
									die('NE : Image link error');
								}
							break;	
							case 'GIFLINK';
								if($RegX->check_GIF($_POST[$this->Value[1]])){
									$this->RSQL .= '`'.$this->Value[0].'`=\''.$_POST[$this->Value[1]].'\',';	
								}else{
									die('NE : Image GIF error');
								}
							break;
							case 'PDFLINK';
								if($RegX->check_PDF($_POST[$this->Value[1]])){
									$this->RSQL .= '`'.$this->Value[0].'`=\''.$_POST[$this->Value[1]].'\',';	
								}else{
									die('NE : PDF error');
								}
							break;
							case 'HTTP';
							if(!empty($_POST[$this->Value[1]]))
							{
								if($RegX->check_HTTP($_POST[$this->Value[1]])){
									$this->RSQL .= '`'.$this->Value[0].'`=\''.$_POST[$this->Value[1]].'\',';	
								}else{
									die('NE : HTTP error');
								}
							}else{
								$this->RSQL .= '`'.$this->Value[0].'`=\'\',';
							}
							break;
							case 'IP';
								if($RegX->check_ip($_POST[$this->Value[1]])){
									$this->RSQL .= '`'.$this->Value[0].'`=\''.$_POST[$this->Value[1]].'\',';	
								}else{
									die('NE : IP error');
								}
							break;
							case 'DATEFR';
								if($RegX->check_DateFR($_POST[$this->Value[1]])){
									$Date = substr($_POST[$this->Value[1]],6,4).'-'.substr($_POST[$this->Value[1]],3,2).'-'.substr($_POST[$this->Value[1]],0,2);
									$this->RSQL .= '`'.$this->Value[0].'`=\''.$Date.'\',';
									unset($Date);
								}else{
									die('NE : Date FR FORMAT error');
								}
							break;
							case 'DATETIME';
								if($RegX->check_dateTime($_POST[$this->Value[1]])){
									$this->RSQL .= '`'.$this->Value[0].'`=\''.$_POST[$this->Value[1]].'\',';	
								}else{
									die('NE : DateTime error');									
								}
							break;
							
							case 'PASSWORD';
								if($RegX->check_pwd($_POST[$this->Value[1]])|| $_POST[$this->Value[1]]=='')
								{
									$Salt = substr(md5(time()),0,10);
									$Password = md5($_POST[$this->Value[1]].$Salt);
									$this->RSQL .='`'.$this->Value[0].'`=\''.$Password.'\',';
									$this->RSQL .='`'.$this->Value[0].'salt`=\''.$Salt.'\',';
									unset($Password);
								}else{
									die('NE : Password error');
								}
							break;
							/////Password_confirm
							case 'PASSWORD_CONFIRM' : 
							if($RegX->check_pwd($_POST[$this->Value[1]]))
							{							
								if($_POST[$this->Value[1]] != $_POST[$this->Value[0]]){	
										die('EV : PASSWORD error');						
								}
							}else
							{
								die('EV : PASSWORD error');
							}						
							break;																			
						}
					}
					$this->Count++;	
				}
			}else{	
				echo 'EFF';//error field format
			}
		}
		$this->ESQL = $this->RSQL;
		//die($this->ESQL);
		$this->ESQL = substr_replace($this->ESQL, "", -1 );
		$DB = getDB();
		//$DB = new Database();	
		$this->SQL = $this->SQL.$this->ESQL.$this->WHERE;
		//die($this->SQL);
		if($DB->pdo->Query($this->SQL))
		{
			echo '1';
		}else{
			die('Unkown Error : Request => '.$this->SQL);
		}
	}
}
?>