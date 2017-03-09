<?php
namespace Core;

use \PDO;

class Form
{
	public $Form;
	public $Table;
	public $Key;
	public $Value;
	public $SDTable;
	public $SDValue;
	public $SDKey;
	public $Name;
	public $Size;
	public $WS_dir;
	public $Script;
	public $Post;
	public $db;
	public $FOLDER;
	public $CSS_FILE;
	

	public function Draw($Form)
	{
        /*
		$Config = new Config();
        */
		$this->Form = $Form;
                //echo '<script>$("#GlobalOverlay").fadeIn();</script>';
		foreach($this->Form as $this->SDTable => $this->Key)
		{
			foreach($this->Key as $this->SDValue=>$this->SDKey)
			{
				//Pass Word text
				if($this->SDKey=='HR')
				{
                                    $this->Name = $this->Key[1];
                                    $this->Class = $this->Key[2];
                                    $this->ID = $this->Key[3];
                                    $this->STYLE = $this->Key[4];
                                    $this->DIVTEXT = $this->Key[5];
                                    $this->DIVID = $this->Key[6];
                                    $this->DIVClass = $this->Key[7];
                                    $this->DIVStyle = $this->Key[8];
                                    echo '<div id="'.$this->DIVID.'" class="'.$this->DIVClass.'" style="'.$this->DIVStyle.'">'.$this->DIVTEXT.'</div><hr name="'.$this->Name.'" class="'.$this->Class.'" id="'.$this->ID.'" style="'.$this->STYLE.'">';
				}
				if($this->SDKey=='TEXT')
				{
					$this->Name = $this->Key[1];
					$this->Size = $this->Key[2];
					$this->Class = $this->Key[3];
					$this->ID = $this->Key[4];
                                        if(isset($this->Key[5]))
                                        {
                                            $this->TAB = $this->Key[5];
                                        }else{
                                            $this->TAB = '';
                                        }
                                        if(isset($this->Key[6]))
                                        {
                                            if($this->Key[6] == 'disabled' || $this->Key[6] == 'DISABLED')
                                            {
                                                $this->Disabled = ' disabled="disabled"';
                                            }else{
                                                $this->Disabled = '';
                                            }
                                        }else{
                                            $this->Disabled = '';
                                        }
                                        if(isset($this->Key[8]))
                                        {
                                            $this->Value = $this->Key[8];
                                        }else{
                                            $this->Value = '';
                                        }
                                        if(isset($this->Key[7]))
                                        {
                                            $this->Style = $this->Key[7];
                                        }else{
                                            $this->Style = '';
                                        }
                                        /*
                                        if($this->ID = $this->Key[6] != '')
                                        {
                                            $this->Value = $this->Key[6];
                                        }else{
                                            $this->Value = '';
                                        }*/
					//if(isset($this->Key[6]) && isset($this->Key[7])){

                                        echo '<INPUT TYPE=TEXT name="'.$this->Name.'" class="'.$this->Class.'" id="'.$this->ID.'" '.$this->Disabled.' maxlength="'.$this->Size.'" tabindex="'.$this->TAB.'" style="'.$this->Style.'" value="'.$this->Value.'">';
                                        echo '<script>$("#'.$this->ID.'").bind("keypress", function(e){if(e.keyCode==13){$("#send").click();}});</script>';
					$this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n"; 
					$this->Post .= $this->ID.':'.$this->ID.',';
				}
				//Pass Word text
				if($this->SDKey=='PASSWORD')
				{
					$this->Name = $this->Key[1];
					$this->Size = $this->Key[2];
					$this->Class = $this->Key[3];
					$this->ID = $this->Key[4];
					$this->TAB = $this->Key[5];
					echo '<INPUT TYPE="password" name="'.$this->Name.'" class="'.$this->Class.'" id="'.$this->ID.'" maxlength="'.$this->Size.'" tabindex="'.$this->TAB.'">';
                                        echo '<script>$("#'.$this->ID.'").bind("keypress", function(e){if(e.keyCode==13){$("#send").click();}});</script>';
					$this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n"; 
					$this->Post .= $this->ID.':'.$this->ID.',';
				}
				//Hidden
				if($this->SDKey=='HIDDEN' || $this->SDKey=='hidden')
				{
					$this->Name = $this->Key[1];
					$this->Size = $this->Key[2];
					$this->Class = $this->Key[3];
					$this->ID = $this->Key[4];
					$this->Val = $this->Key[5];
					echo '<INPUT TYPE="hidden" name="'.$this->Name.'" class="'.$this->Class.'" id="'.$this->ID.'" maxlength="'.$this->Size.'" value="'.$this->Val.'">';
                    $this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n";
					$this->Post .= $this->ID.':'.$this->ID.',';
				}	
				//Title
				if($this->SDKey == 'TITLE')
				{
                                    $this->Class = $this->Key[1];
                                    $this->ID = $this->Key[2];
                                    $this->STYLE = $this->Key[3];
                                    $this->TITLE = $this->Key[4];
                                    echo '<span id="'.$this->ID.'" class="'.$this->Class.'" style="'.$this->STYLE.'">'.$this->TITLE.'</span>';
				}	
				////
				if($this->SDKey=='LABEL')
				{
                                    $this->Name = $this->Key[1];
                                    $this->Class = $this->Key[2];
                                    $this->ID = $this->Key[3];
                                    if(isset($this->Key[4]) && $this->Key[4] == 'FORCED')
                                    {
                                            $FORCED = '<span style="color:red;margin-left:6px;margin-top:2px;position:absolute;">*</span>';
                                    }else{
                                            $FORCED = '';
                                    }
                                    echo '<LABEL class="'.$this->Class.'" id="'.$this->ID.'">'.$this->Name.$FORCED.'</label>';
				}
				if($this->SDKey=='SPAN')
				{
                                    $this->Name = $this->Key[1];
                                    $this->Class = $this->Key[2];
                                    $this->ID = $this->Key[3];
                                    if(isset($this->Key[4]) == 'FORCED')
                                    {
                                            $FORCED = '<span style="color:red;margin-left:6px;margin-top:2px;position:absolute;">*</span>';
                                    }else{
                                            $FORCED = '';
                                    }
                                    echo '<SPAN class="'.$this->Class.'" id="'.$this->ID.'">'.$this->Name.$FORCED.'</SPAN>';
				}
				/////pour cr�e un pour l'upload
				if($this->SDKey=='FILE' || $this->SDKey=='file')
				{
					$this->Name = $this->Key[1];
					$this->Class = $this->Key[2];
					$this->ID = $this->Key[3];					
					echo '<INPUT TYPE="file" NAME="'.$this->Name.'" CLASS="'.$this->Class.'" ID="'.$this->ID.'" >';
					$this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n"; 
					$this->Post .= $this->ID.':'.$this->ID.',';					
				}
				////pour cr�e un champ textarea
				if($this->SDKey=='TEXTAREA')
				{
					$this->Name = $this->Key[1];
					$this->Cols = $this->Key[2];
					$this->Class = $this->Key[3];
					$this->ID = $this->Key[4];
					$this->TAB = $this->Key[5];
					//$this->DISABLED = $this->Key[6];
					if(isset($this->Key[6])){
						$this->DISABLED = 'disabled="disabled"';
					}else{
						$this->DISABLED = '';
					}
					echo '<textarea NAME="'.$this->Name.'" CLASS="'.$this->Class.'" ID="'.$this->ID.'" cols="'.$this->Cols.'" rows="'.$this->Cols.'" "'.$this->DISABLED.'" tabindex="'.$this->TAB.'"></textarea>';
                    echo '<script>$("#'.$this->ID.'").bind("keypress", function(e){if(e.keyCode==13){$("#send").click();}});</script>';
                    if(strpos($this->Class, 'summernote') == true)
                    {
                        $this->Script .= "var ".$this->ID." = $('#".$this->ID."').code();\n";    
                    }else{
                        $this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n";
                    }
					///$this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n"; 
					$this->Post .= $this->ID.':'.$this->ID.',';
				}
				///simple button
				if($this->SDKey=='BUTTON')
				{
					$this->Value = $this->Key[1];
					$this->name = $this->Key[2];
					$this->Class = $this->Key[3];
					$this->ID = $this->Key[4];
					if(isset($this->Key[5]))
					{
						$this->TAB = $this->Key[5];
					}else{
						$this->TAB = '';
					}
					
					echo '<input type="button" name="'.$this->name.'" CLASS="'.$this->Class.'" ID="'.$this->ID.'" value="'.$this->Value.'" tabindex="'.$this->TAB.'">';
				}
				////click button
				if($this->SDKey=='CBUTTON')
				{
					$this->Value = $this->Key[1];
					$this->name = $this->Key[2];
					$this->Class = $this->Key[3];
					$this->ID = $this->Key[4];
					$this->ACTION = $this->Key[5];
					echo '<input type="button" name="'.$this->name.'" CLASS="'.$this->Class.'" ID="'.$this->ID.'" value="'.$this->Value.'" onclick="'.$this->ACTION.'">';
				}
				if($this->SDKey == 'RADIO' ||$this->SDKey == 'radio')
				{
                                    $this->Name = $this->Key[1];
                                    $this->Class = $this->Key[2];
                                    $this->ID = $this->Key[3];
                                    $this->VALUE = $this->Key[4];
                                    $this->CHECKED = $this->Key[5];
                                    if($this->CHECKED == 'TRUE' || $this->CHECKED == 'true')
                                    {
                                        $this->CHECKED = 'checked="checked"';
                                    }else{
                                        $this->CHECKED = '';
                                    }
                                    $this->LBLVAL = $this->Key[6];
                                    $this->LBLID = $this->Key[7];
                                    $this->LBLCLASS = $this->Key[8];
                                    echo '<input type="radio" name="'.$this->Name.'" id ="'.$this->ID.'" class="'.$this->Class.'" value="'.$this->VALUE.'" '.$this->CHECKED.' /><label id="'.$this->LBLID.'" class="'.$this->LBLCLASS.'" >'.$this->LBLVAL.'</label>';
                                    $this->Script .= "var ".$this->ID." = $('#".$this->ID.":checked').val();\n";
                                    
                                    //this need update if == indefined mean = 0
                                    $this->Post .= $this->ID.':'.$this->ID.',';
				}
				if($this->SDKey == 'CHECKBOX')
				{
                                    $this->Name = $this->Key[1];
                                    $this->Class = $this->Key[2];
                                    $this->ID = $this->Key[3];
                                    $this->VALUE = $this->Key[4];
                                    if($this->Key[5] == 'checked')
                                    {
                                        $this->CHECKED = 'checked="checked"';
                                    }else{
                                        $this->CHECKED = '';
                                    }
                                    echo '<input type="checkbox" id="'.$this->ID.'" name="'.$this->Name.'" class='.$this->Class.' value="'.$this->VALUE.'" '.$this->CHECKED.'/>';
				}
				
				
				if($this->SDKey=='UPLOAD')
				{
                    $this->DIVID = $this->Key[1];
                    $this->CLASSUPLOAD = $this->Key[2];
                    $this->IDUPLOAD = $this->Key[3];

                    $this->VALUPLOAD = $this->Key[4];
                    $this->IDPICTURE = $this->Key[5];
                    $this->SRCPICTURE = $this->Key[6];


                    $this->PICTURECONTROLE = $this->Key[7];
                    $this->EXTENSION = $this->Key[8];//jpg|png|jpeg|gif|bmp
                    $this->EXTENSIONSAVE = $this->Key[9];//jpg
                    $this->DIRTOSAVE = $this->Key[10];//jpg|png|jpeg|gif|bmp

                    $this->DIRECTORY = $this->Key[11];
                    $this->FILE = $this->Key[12];

                    if(isset($this->Key[13]) && $this->Key[13] != '')
                    {
                        $this->Function = $this->Key[13].'();';///fonction apres l'upload
                    }else{
                        $this->Function = '';
                    }
                        
                    echo '<div id="'.$this->DIVID.'" style="float:left"><input type="button" id="'.$this->IDUPLOAD.'" class="'.$this->CLASSUPLOAD.'" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$this->VALUPLOAD.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" style="margin-top:5px">';
                    echo '<input type="hidden" id="'.$this->IDPICTURE.'" name="'.$this->IDPICTURE.'" value ="" title="'.$this->SRCPICTURE.'" style="width:50px;height:50px"/>';
                    //src="images/Loading_File16.gif"
                    echo '<img  id="Loading'.$this->IDPICTURE.'" style="margin-left: 10px;margin-left: margin-left: 6px;margin-top: 9px;max-width: 80px;max-height: 80px;">';
                    echo '</div>';

                    echo '
                    <script language="javascript">

                    $().ready(function(){
                    new AjaxUpload("'.$this->IDUPLOAD.'", {
                                                    action: "'.$this->DIRECTORY.$this->FILE.'",
                                                    data: {Dir:"'.$this->DIRTOSAVE.'",EXT:"'.$this->EXTENSIONSAVE.'"},
                                                    name: \'File\',
                                                    autoSubmit: true,
                                                    responseType: false,
                                                    onSubmit : function(file,ext){
                                                    if (! (ext && /^('.$this->EXTENSION.')$/i.test(ext))){
                                                        // extension is not allowed
                                                        alert(\'Error: invalid file extension\');
                                                        return false;
                                                    }
                                                    $("#Loading'.$this->IDPICTURE.'").fadeIn();
                                            },
                                            onSubmit: function('.$this->IDUPLOAD.', file){$("#Loading'.$this->IDPICTURE.'").fadeIn();},
                                                onComplete : function(file,response){
                                                    if(response.match("Error"))
                                                    {
                                                        alert(response);
                                                    }else{
                                                        $("#Loading'.$this->IDPICTURE.'").attr("src","'. WS . _PHYSICAL_URI_ .'"+response);
                                                        $("#'.$this->IDPICTURE.'").attr("title",response);
                                                        $("#'.$this->IDPICTURE.'").val(response);
                                                        $("#span'.$this->IDPICTURE.'").html(response);
                                                        '.$this->Function.'
                                                    }
                                                }
                                            });
                    });
                    </script>';
                    $this->Script .= "var ".$this->IDPICTURE." = $('#".$this->IDPICTURE."').attr('title');\n";
                    $this->Post .= $this->IDPICTURE.':'.$this->IDPICTURE.',';
					
				}
				if($this->SDKey=='PICTURE')
				{

                                function GetHSizeOfFile($bytes){
                                        if($bytes<1024)
                                        {
                                                return ($bytes . " Kb");
                                        }elseif($bytes > 1023 && $bytes <104858)
                                        {
                                                $bytes = $bytes/1024;
                                                $bytes = number_format($bytes,2);
                                                return ($bytes . " Ko");
                                        }else{
                                                return  ($bytes/1000000 . " Mb");
                                        }
                                }

                                $this->DIVID = $this->Key[1];
                                $this->CLASSUPLOAD = $this->Key[2];
                                $this->IDPICTURE = $this->Key[3];
                                $this->SRCPICTURE = $this->Key[4];
                                $IMGARRAY = preg_split('[\/]',$this->SRCPICTURE);
                                $FileName = $IMGARRAY[count($IMGARRAY)-1];
                                $FILEXT = preg_split('[\.]',$FileName);
                                $FILESIZE = filesize($this->SRCPICTURE);
                                $FILECTIME = date("d/m/Y H:i:s", fileatime($this->SRCPICTURE));
                                $FILEUTIME = date("d/m/Y H:i:s", filemtime($this->SRCPICTURE));
                                //echo date("Y-m-d H:i:s", $timestamp);
                                $FILENAME = $FILEXT[0];
                                $FILEEXTENTION = strtoupper($FILEXT[1]);




                                echo '<div id="'.$this->DIVID.'" class="PICTURESHOW">';
                                        if(file_exists($this->SRCPICTURE))
                                        {
                                                echo '<img id="'.$this->IDPICTURE.'" src="'.$this->SRCPICTURE.'"/>';
                                                echo '<span class="pright" id="Title'.$this->IDPICTURE.'">Nom de fichier :&nbsp;</span><span class="pleft" >'.$FILENAME.'</span>';
                                                echo '<span class="pright" id="Type'.$this->IDPICTURE.'">Type :&nbsp; </span><span class="pleft" >'.$FILEEXTENTION.'</span>';
                                                echo '<span class="pright" id="Size'.$this->IDPICTURE.'">Taille :&nbsp; </span><span class="pleft" >'.GetHSizeOfFile($FILESIZE).'</span>';
                                                echo '<span class="pright" id="Date'.$this->IDPICTURE.'">Date Cr&eacute;ation :&nbsp; </span><span class="pleft" >'.$FILECTIME.'</span>';
                                                echo '<span class="pright" id="Date'.$this->IDPICTURE.'">Date Modification :&nbsp; </span><span class="pleft" >'.$FILEUTIME.'</span>';
                                        }else{
                                                echo '<span>Ican\'t find your picture :\'(</span>';
                                        }
                                echo '</div>';
                            }
            if($this->SDKey=='AUTOCOMPLETE')
            {
                if(sizeof($this->Key) === 10 || sizeof($this->Key) === 11 || sizeof($this->Key) === 12 || sizeof($this->Key) === 13)
                {
                        $this->FirstID = $this->Key[1];
                        $this->FirstClass = $this->Key[2];
                        $this->Name = $this->Key[3];
                        $this->TAB = $this->Key[4];
                        $this->Class = $this->Key[5];
                        $this->ID = $this->Key[6];
                        $this->Size = $this->Key[7];
                        $this->File = $this->Key[8];
                        $this->Parm = $this->Key[9];
                        if(isset($this->Key[10]) && $this->Key[10] != '')
                        {
                                $this->SDParm = $this->Key[10];
                                if($this->SDParm != '')
                                {
                                        $SDParm = 'var SDParm  = $("#'.$this->SDParm.'").val();';
                                }else{
                                        $SDParm = 'var SDParm = \'Nothing\;';
                                }
                        }else{
                                $SDParm = 'var SDParm = \'Nothing\';';
                        }
                        ///function to be executed in select
                        if(isset($this->Key[11]) && $this->Key[11])
                        {
                                if(isset($this->Key[12]) && $this->Key[12] != '')
                                {
                                        $this->FunctionParm = '\''.$this->Key[12].'\'';
                                }else{
                                        $this->FunctionParm = '';
                                }
                                //$this->Funnction = 'if($("#'.$this->ID.'").val() == undefined){}else{}';
                                $this->Funnction = $this->Key[11].'($("#'.$this->ID.'").val(),'.$this->FunctionParm.');';
                        }else{
                                $this->Funnction = '';
                        }
                        $this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n";
                        $this->Post .= $this->ID.':'.$this->ID.',';

                        echo '<input type="TEXT" maxlength="'.$this->Size.'" id="'.$this->FirstID.'" class="'.$this->FirstClass.'" tabindex="'.$this->TAB.'">';
                        echo '<input type="hidden" value="" maxlength="'.$this->Size.'" id="'.$this->ID.'" class="'.$this->Class.'" name="'.$this->Name.'" style="border: 1px solid #E4E5E5;color: #666666;float: left;margin-right: 20px;margin-top: 5px;padding: 3px;width: 180px;">';

                        $this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n";
                        $this->Post .= $this->ID.':'.$this->ID.',';

                        echo '<div id="'.$this->FirstID.'_bull" title="Erreur : valeur de champs introuvable"></div>';
                        echo '<style>#'.$this->FirstID.'_bull{
                            color: red;
                            display: none;
                            float: left;
                            font-size: 10px;
                            height: 10px;
                            margin-left: -20px;
                            margin-top: 11px;
                            max-width: 9px;
                            padding: 3px;
                            width: 14px;
                            cursor:pointer;
                        }</style>';
                        echo "<script language=\"javascript\">

                                $(\"#".$this->FirstID."\").keyup(function(){
                                                    var FSTParm = $(this).val();
                                                    ".$SDParm."
                                                 $(\"#".$this->FirstID."\").autocomplete({
                                                        minLength: 0,
                                                        source: '".$this->File."?FSTParmOne='+FSTParm+'&SDParm='+SDParm,
                                                        focus: function(ui) {
                                                            if(typeof ui != 'undefined' )
                                                            {
                                                                if(typeof ui.item != 'undefined' )
                                                                {
                                                                    console.log(ui.item);
                                                                   $(\"#".$this->FirstID."\").val(ui.item.value);
                                                                    return false;
                                                                }
                                                            }
                                                                
                                                        },
                                                        select: function(event, ui) {
                                                                $(\"#".$this->FirstID."\").val(ui.item.value);
                                                                $(\"#".$this->ID."\").val(ui.item.id);
                                                                return false;
                                                        }
                                                })
                                
                                });
/*
                                $(\"#".$this->FirstID."\").blur(function(){
                                        var FSTParm = $(this).val();
                                        ".$SDParm."
                                        $.ajax({
                                            type:'get',
                                            url:'".$this->File."/?FSTParmOne='+FSTParm+'&SDParm='+SDParm,
                                            success:function(data){
                                                if(data == 0)
                                                {
                                                    $(\"#".$this->ID."\").val('');
                                                    $(\"#".$this->FirstID."_bull\").show();
                                                    $(\"#".$this->FirstID."_bull\").attr('title','Verification de contenu invalide');
                                                    $(\"#".$this->FirstID."_bull\").css('background-image', 'url(images/error16.png)');
                                                    //$(\"#".$this->FirstID."\").select();
                                                }else{
                                                    $(\"#".$this->ID."\").val(data);
                                                    $(\"#".$this->FirstID."_bull\").attr('title','Verification de contenu valide');
                                                    $(\"#".$this->FirstID."_bull\").css('background-image', 'url(images/ok16.png)');
                                                    $(\"#".$this->FirstID."_bull\").show();
                                                    ".$this->Funnction."
                                                }
                                                if(data == '')
                                                {
                                                    console.log(\"Merci d\'ajouter la fonction blure pour ce champs il y a un ajax qui senvoies dans le blure sur ce champs\");
                                                }
                                            }
                                        });
                                });
*/

                        </script>";


                    }else{
                        echo '<div class="Error">Erreur de la cr&eacute;ation de l\'autocompl&egrave;tion !</div>';
                    }
				}
				if($this->SDKey=='COMBO')
				{
                           
                    $this->Name = $this->Key[1];
                    $this->Class = $this->Key[2];
                    $this->ID = $this->Key[3];

                    $this->Table = $this->Key[4];
                    $this->FField = $this->Key[5];
                    if(isset($this->Key[6])){
                        $this->SField = $this->Key[6];
                    }

                    //echo (sizeof($this->Key));
                    $this->DB = getDB();
                    //die(sizeof($this->Key));  
					switch(sizeof($this->Key))
					{
						case 6 :
                        
						echo '<select name="'.$this->Name.'" id="'.$this->ID.'" class="'.$this->Class.'">';
                                                    
						//echo '<option>'.$this->SQL.'</option>';
						if(isset($this->Key[4]) && isset($this->Key[5]) && isset($this->Key[6]))
						{
                            
                            ///le nom du champs qui contient la valeur 1
                            if(isset($this->Key[7]))
                            {
                                $this->Field_Has_One = $this->Key[7];
                                $this->Where = ' WHERE '.$this->Field_Has_One.'=1 and deleted = 0 order by 2' ;
                                //you have to check table existance.
                                $this->SQL="select `".$this->FField."`,`".$this->SField."` from ".$this->Table.$this->Where;
                            }else{
                                //you have to check table existance.
                                $this->SQL="select `".$this->FField."`,`".$this->SField."` from ".$this->Table.' where deleted = 0 order by 1';
                            }
                            //echo '<option>'.$this->SQL.'</option>';
                            
                            
                            $this->Result = $this->DB->fetchAll($this->SQL);
                            //echo '<option value="0">choisir</option>';
                            while($this->Row = $this->Result)
                            {
                                echo '<option value="'.$this->Row[$this->FField].'">'.$this->Row[$this->SField].'</option>';
                            }
                            echo '</select>';
                            $this->Script .= "var ".$this->ID." = $('#".$this->ID." :selected').val();\n";
                            $this->Post .= $this->ID.':'.$this->ID.',';

                            }elseif(isset($this->Key[4]) && isset($this->Key[5]))
                            {
                                    //echo '<option>5487</option>';
                                    $this->Ctrue = $this->Key[4];
                                    $this->Cfalse = $this->Key[5];
                                    echo '<option value="1">'.$this->Ctrue.'</option>';
                                    echo '<option value="0">'.$this->Cfalse.'</option>';
                                    echo '</select>';
                                    $this->Script .= "var ".$this->ID." = $('#".$this->ID." :selected').val();\n";
                                    $this->Post .= $this->ID.':'.$this->ID.',';

                            }else{
                                    die('<option>EF DB</option>');
                            }
							break;
						case 7 :			
						echo '<select name="'.$this->Name.'" id="'.$this->ID.'" class="'.$this->Class.'">';
						//echo '<option>'.$this->SQL.'</option>';
						if(isset($this->Key[4]) && isset($this->Key[5]) && isset($this->Key[6]))
						{
                                                     
							///le nom du champs qui contient la valeur 1
							if(isset($this->Key[7]))
							{		
                                                            $this->Field_Has_One = $this->Key[7];
                                                            $this->Where = ' WHERE '.$this->Field_Has_One.'=1  and deleted = 0 order by 2' ;
                                                            //you have to check table existance.
                                                            $this->SQL="select `".$this->FField."`,`".$this->SField."` from ".$this->Table.$this->Where;
							}else{
                                                            //you have to check table existance.
                                                            $this->SQL="select `".$this->FField."`,`".$this->SField."` from ".$this->Table.' order by 1 ';
							}
                                                        //echo '<option>'.$this->SQL.'</option>';
	

                                                        //$this->DB = new Database();
                                                        $this->Result = $this->DB->pdo->Query($this->SQL);
                                                        $this->Rows = ($this->Result->fetchAll(PDO::FETCH_BOTH));
                                                        foreach($this->Rows as $this->Row)
                                                        {
                                                            echo '<option value="'.$this->Row[$this->FField].'">'.ucfirst($this->Row[$this->SField]).'</option>';   
                                                        }
                                                       
                                                        echo '</select>';
                                                        $this->Script .= "var ".$this->ID." = $('#".$this->ID." :selected').val();\n";
                                                        $this->Post .= $this->ID.':'.$this->ID.',';
								
                                                    }elseif(isset($this->Key[4]) && isset($this->Key[5]))
                                                    {
                                                            $this->Ctrue = $this->Key[4];
                                                            $this->Cfalse = $this->Key[5];
                                                            echo '<option value="1">'.$this->Ctrue.'</option>';
                                                            echo '<option value="0">'.$this->Cfalse.'</option>';
                                                            echo '</select>';
                                                            $this->Script .= "var ".$this->ID." = $('#".$this->ID." :selected').val();\n";
                                                            $this->Post .= $this->ID.':'.$this->ID.',';
                                                    }else{
                                                            die('<option>EF DB</option>');
                                                    }
							break;
						case 8 : 
							$this->SValue = $this->Key[7];
							echo '<select name="'.$this->Name.'" id="'.$this->ID.'" class="'.$this->Class.'">';
                                                        
							if(isset($this->Key[4]) && isset($this->Key[5]) && isset($this->Key[6]))
							{
								///le nom du champs qui contient la valeur 1
								if(isset($this->Key[7]))
								{
									if(is_numeric($this->Key[7]))
									{
                                        //$this->Where = ' WHERE '.$this->FField.'='.$this->SValue.' order by 1' ;
                                        //you have to check table existance.
                                        $this->SQL="select `".$this->FField."`,`".$this->SField."` from ".$this->Table.$this->Where;
                                        //echo '<option value="0">'.$this->SQL.__line__.'</option>';
                                        $SessionName = $session->getSession('Company');
                                        $login = $session->getSession($SessionName);
                                        $this->DB = getDB();
                                        $this->Result=$this->DB->pdo->Query($this->SQL);
                                        while($this->Row = $this->DB->FArray($this->Result))
                                        {
                                            if($this->Key[7] == $this->Row[$this->FField])
                                            {
                                                echo '<option value="'.$this->Row[$this->FField].'" selected="selected">'.$this->Row[$this->SField].'</option>';
                                            }else{
                                                echo '<option value="'.$this->Row[$this->FField].'">'.$this->Row[$this->SField].'</option>';
                                            }
                                        }
                                        echo '</select>';
                                        $this->Script .= "var ".$this->ID." = $('#".$this->ID." :selected').val();\n";
                                        $this->Post .= $this->ID.':'.$this->ID.',';
									}else{
                                        $this->Field_Has_One = $this->Key[7];
                                        $this->Where = ' WHERE '.$this->Field_Has_One.'=1 order by 1 and deleted = 0' ;
                                        //you have to check table existance.
                                        $this->SQL="select `".$this->FField."`,`".$this->SField."` from ".$this->Table.$this->Where;

                                        $session = new Session();
                                        $SessionName = $session->getSession('Company');
                                        $login = $session->getSession($SessionName);
                                        $this->DB = getDB();
                                        $this->Result=$this->DB->pdo->Query($this->SQL);
                                        while($this->Row = $this->DB->FArray($this->Result))
                                        {
                                            echo '<option value="'.$this->Row[$this->FField].'">'.$this->Row[$this->SField].'</option>';
                                        }
                                        echo '</select>';
                                        $this->Script .= "var ".$this->ID." = $('#".$this->ID." :selected').val();\n";
                                        $this->Post .= $this->ID.':'.$this->ID.',';
									}							
								}
	
							}elseif(isset($this->Key[4]) && isset($this->Key[5]))
							{
                                $this->Ctrue = $this->Key[4];
                                $this->Cfalse = $this->Key[5];
                                echo '<option value="1">'.$this->Ctrue.'</option>';
                                echo '<option value="0">'.$this->Cfalse.'</option>';
                                echo '</select>';
                                $this->Script .= "var ".$this->ID." = $('#".$this->ID." :selected').val();\n";
                                $this->Post .= $this->ID.':'.$this->ID.',';

							}else{
								die('<option>EF DB</option>');
							}
							break;
					}
					//}
				}	
				////combo roller
				///How to use this plugin
				////
				if($this->SDKey=='COMBOROLLER')
				{
					$session = new Session();
					$login = $session->getSession('ESYA');
					$this->WBSite = $session->getSession('WEBSITE');
					$this->Name = $this->Key[1];
					$this->Class = $this->Key[2];
					$this->ID = $this->Key[3];	
					$this->FOLDER = $this->Key[4];
					$this->DIR = $this->Key[5];					
					/////demande des images	
					//die(var_dump(self::get_Pictures($this->FOLDER,$this->DIR)));							    					   
					    echo '<INPUT TYPE="hidden" NAME="'.$this->Name.'" CLASS="'.$this->Class.'" ID="'.$this->ID.'" value="">';				    
						echo '<div id="switcher_'.$this->ID.'" style="float:left;height:26px;margin-top:5px;position:relative;width:200px">';
							echo '<a href="#" ><span class="jquery-ui-themeswitcher-icon" ></span><span>Images : </span></a>';
						    echo '<div id="mdiv_'.$this->ID.'" >
								<ul>';
							foreach(self::get_Pictures($this->FOLDER,$this->DIR) as $cle=>$valeur)
						    {
						    	//$valeur = str_replace('../../','includes/',$valeur);
						    	//die($valeur);		
						    	   echo '<li>
								        <a href="#" class="Except">
								            <img title="UI Lightness" alt="UI Lightness" src="'.$valeur.'" style="float: left; border: 1px solid rgb(51, 51, 51); margin: 0pt 2px;width:100px;height:70px">
								        </a>
								   </li>';
						    }
						     echo '</ul>';
						     echo '</div>';						  
						echo '</div>';	
						
					     echo '<img src="" class="switcher_img_name_'.$this->ID.'">';
					/////
					$this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n"; 
					$this->Post .= $this->ID.':'.$this->ID.',';
					//////////////////	fin de demande			
				}				
				
				if($this->SDKey=='DIVSTART')
				{
					$this->ID = $this->Key[1];
					$this->Class = $this->Key[2];
					if(isset($this->Key[3]) && $this->Key[3] == 'HIDDEN')
					{
                                            $this->SHOW_HIDE = 'none';
					}else{
                                            $this->SHOW_HIDE = 'block';
					}
					if($this->Class == 'TInfo'){					
                                            echo '<div class="'.$this->Class.'" id="'.$this->ID.'"><fieldset ><legend>Type Facture :</legend>';
					}else{
                                            echo '<div class="'.$this->Class.'" id="'.$this->ID.'" style="display:'.$this->SHOW_HIDE.'">';
					}					
				}
				if($this->SDKey=='JS_FUNCTION')
				{
					if(strlen($this->Key[1])>2){
						$this->FUNSCRIPT = $this->Key[1]."()";			
					}	else{
						$this->FUNSCRIPT ='';	
					}
				}
				
				if($this->SDKey=='FXJS_FILE')
				{
					$JF = 1;
					$this->FXJS_FILE = '<script type="text/javascript" src="'.$this->Key[1].'"></script>';	
				}else{
					if(!isset($JF))
					{
						$this->FXJS_FILE = '';
					}
				}
				if($this->SDKey=='CSS_FILE')
				{
					$CF = 1;
					$this->CSS_FILE = '<link rel="stylesheet" href="'.$this->Key[1].'">';	
				}else{
					if(!isset($CF))
					{
						$this->CSS_FILE = '';
					}
				}
				if($this->SDKey=='DIVEND')
				{
                                    echo '</div>';
				}
				if($this->SDKey=='PSTART')
				{
					$this->ID = $this->Key[1];
					$this->Class = $this->Key[2];
					echo '<p class="'.$this->Class.'" id="'.$this->ID.'">';					
				}
				if($this->SDKey=='PEND')
				{
					echo '</p>';	
				}				
				
				if($this->SDKey == 'DONT_SUBMIT')
				{
					$this->FScript = 1;
				}else{
					$this->FScript = 0;
				}
			}
			
		}
		if(!(isset($this->FUNSCRIPT)))
		{
			$this->FUNSCRIPT = '';
		}
		echo $this->FXJS_FILE;
		echo $this->CSS_FILE;
		if(isset($this->FScript))
		{
			if($this->FScript == 0)
			{
				$this->FScript = '<script type="text/javascript">
				$(document).ready(function(){
                                $("#GlobalOverlay").fadeOut();
					$("input#close").click(function(){
						$("#facebox_overlay").fadeOut(\'fast\');
					});				   
				   $("#send").click(function(){
											 '.$this->Script.'
											 $.ajax({
												   type:"POST",																		  
												   url:"'. site_url('includes/functions/operations/Add.php') .'",
												   data:{'.substr($this->Post,0,strlen($this->Post)-1).'},
													   success:function(data){
														if(data.trim() == 1)
												   		{
                                                            //window.location.href = redirect;
                                                            '.$this->FUNSCRIPT.'
                                                            window.history.back();
													   }else{
															alert(data);
													   }
												   }					   
												   });																	 
											 });
				});</script>';
				echo $this->FScript;
			}else{
				echo '';// no script
			}
		}
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function EDraw($Form)
	{

		$this->Form = $Form;
		$this->Count =0;
		$this->DB = getDB();
        $this->DB->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_BOTH);

        // var_dump($this->DB->pdo);exit;
		foreach($this->Form as $this->SDTable => $this->Key)
		{
			if($this->Count==0)
			{
                $this->TABLE = $this->Key[0];
                $this->TID = $this->Key[1];
                $this->TIDV = $this->Key[2];
                $this->Post .= 'ID:'.$this->TIDV.',';
                $this->Count++;
			}
			foreach($this->Key as $this->SDValue=>$this->SDKey)
			{
				if($this->SDKey=='TEXT')
				{
                                    $this->FName = $this->Key[1];
                                    $this->Name = $this->Key[2];
                                    $this->Size = $this->Key[3];
                                    $this->Class = $this->Key[4];
                                    $this->ID = $this->Key[5];
                                    if($this->Key[5] == 'password')
                                    {
                                            $this->SQL = 'SELECT `'.$this->FName.'`,`password_salt` FROM '.$this->TABLE.' WHERE '.$this->TID.' ='.$this->TIDV.'';
                                    }else{
                                            $this->SQL = 'SELECT `'.$this->FName.'` FROM '.$this->TABLE.' WHERE '.$this->TID.' ='.$this->TIDV.'';
                                    }
                                    //echo $this->SQL;
                                    if($this->RESULT = $this->DB->pdo->Query($this->SQL))
                                    {
                                        $this->ROW = $this->RESULT->fetch(PDO::FETCH_BOTH);
                                        // var_dump($this->Key);exit;
                                        //echo $this->Key[4];
                                        if(strstr($this->Key[4],"Datepicker"))
                                        {
                                            $this->Value = $this->Dates->END2FRD($this->ROW[0]);
                                        }else{
                                            $this->Value = $this->ROW[0];
                                        }
                                        if(preg_match("/TimePicker/i",$this->Key[4]))
                                        {
                                            //xx:xx
                                            $this->Value = substr($this->ROW[0],0,5);
                                        }
                                        if(isset($this->Key[7]))
                                        {
                                            $this->TAB = $this->Key[7];
                                        }else{
                                            $this->TAB = '';
                                        }
                                        if(isset($this->Key[6]) && $this->Key[6] == 'DISABLE'){
                                            echo '<INPUT TYPE=TEXT name="'.$this->Name.'" class="'.$this->Class.'" id="'.$this->ID.'" maxlength="'.$this->Size.'" value="'.$this->Value.'" disabled="disabled"  tabindex="'.$this->TAB.'">';
                                        }else{
                                            if($this->Key[5]== 'password')
                                            {
                                                require_once('functions/Cryptography.fn.php');
                                                $this->Value = Decrypte($this->ROW[0],$this->ROW[1]);
                                                echo '<INPUT TYPE=TEXT name="'.$this->Name.'" class="'.$this->Class.'" id="'.$this->ID.'" maxlength="'.$this->Size.'" value="'.$this->Value.'" tabindex="'.$this->TAB.'" >';
                                            }else{
                                                echo '<INPUT TYPE=TEXT name="'.$this->Name.'" class="'.$this->Class.'" id="'.$this->ID.'" maxlength="'.$this->Size.'" value="'.$this->Value.'" tabindex="'.$this->TAB.'">';
                                            }
                                        }
                                        $this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n";
                                        $this->Post .= $this->ID.':'.$this->ID.',';
                                    }else{
                                        echo '<span id="Error">Erreur dans l\'edition de '.$this->Name.'</span>';
                                    }
                                    echo '<script>$("#'.$this->ID.'").bind("keypress", function(e){if(e.keyCode==13){$("#send").click();}});</script>';
				}
				//text hidden
				if($this->SDKey=='HIDDEN')
				{		
                    
					$this->FName = $this->Key[1];

					$this->Name = $this->Key[2];
					$this->Size = $this->Key[3];
					$this->Class = $this->Key[4];
					$this->ID = $this->Key[5];
					$this->Value = $this->Key[6];		

					//$this->SQL = 'SELECT `'.$this->FName.'` FROM '.$this->TABLE.' WHERE '.$this->TID.' ='.$this->TIDV.'';
                    
                    echo '<INPUT TYPE=HIDDEN name="'.$this->Name.'" class="'.$this->Class.'" id="'.$this->ID.'" maxlength="'.$this->Size.'" value="'.$this->Value.'" >';

                    /*
					if($this->RESULT = $this->DB->pdo->Query($this->SQL))
					{                                        
						$this->ROW=$this->DB->Farray($this->RESULT);
						echo '<INPUT TYPE=HIDDEN name="'.$this->Name.'" class="'.$this->Class.'" id="'.$this->ID.'" maxlength="'.$this->Size.'" value="'.$this->ROW[0].'" >';
						$this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n"; 						
						$this->Post .= $this->ID.':'.$this->ID.',';
					}else{
						echo '<span id="Error">Erreur dans l\'edition de '.$this->Name.'</span>';	
					}
                    */
                    $this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n";                        
                    $this->Post .= $this->ID.':'.$this->ID.',';
                    

                }
				//Title
				if($this->SDKey == 'TITLE')
				{
                                    $this->Class = $this->Key[1];
                                    $this->ID = $this->Key[2];
                                    $this->STYLE = $this->Key[3];
                                    $this->TITLE = $this->Key[4];
                                    echo '<span id="'.$this->ID.'" class="'.$this->Class.'" style="'.$this->STYLE.'">'.$this->TITLE.'</span>';
                                        
				}
				//PASSWORD
				if($this->SDKey == 'PASSWORD')
				{
					$this->FName = $this->Key[1];
					$this->Name = $this->Key[2];
					$this->Size = $this->Key[3];
					$this->Class = $this->Key[4];
					$this->ID = $this->Key[5];
					$this->SQL = 'SELECT `'.$this->FName.'`,`'.$this->FName.'salt` FROM '.$this->TABLE.' WHERE '.$this->TID.' ='.$this->TIDV.'';							
					if($this->RESULT = $this->DB->pdo->Query($this->SQL))
					{
						$this->PROW=$this->DB->Farray($this->RESULT);
						$NewPassword = Decrypte($this->PROW[0],$this->PROW[1]);
						echo '<INPUT TYPE="text" name="'.$this->Name.'" class="'.$this->Class.'" id="'.$this->ID.'" maxlength="'.$this->Size.'" value="'.$NewPassword.'">';
						
						$this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n"; 
						$this->Post .= $this->ID.':'.$this->ID.',';
					}else{
						echo '<span id="Error">Erreur dans l\'edition de '.$this->Name.'</span>';	
					}
				}
				///
				if($this->SDKey=='LABEL')
				{
					$this->Name = $this->Key[1];
					$this->Class = $this->Key[2];
					$this->ID = $this->Key[3];
					if(isset($this->Key[4]) == 'FORCED')
					{
						$FORCED = '<span style="color:red;margin-left:6px;margin-top:2px;position:absolute;">*</span>';
					}else{
						$FORCED = '';
					}
					echo '<LABEL class="'.$this->Class.'" id="'.$this->ID.'">'.$this->Name.$FORCED.'</label>';
					
				}
                if($this->SDKey=='SPAN')
				{
					$this->Name = $this->Key[1];
					$this->Class = $this->Key[2];
					$this->ID = $this->Key[3];
					if(isset($this->Key[4]) == 'FORCED')
					{
						$FORCED = '<span style="color:red;margin-left:6px;margin-top:2px;position:absolute;">*</span>';
					}else{
						$FORCED = '';
					}
					echo '<SPAN class="'.$this->Class.'" id="'.$this->ID.'">'.$this->Name.$FORCED.'</SPAN>';
				}
				if($this->SDKey=='JS_FUNCTION')
				{
					if(strlen($this->Key[1])>2){
						$this->FUNSCRIPT = $this->Key[1]."()";			
					}	else{
						$this->FUNSCRIPT ='';	
					}
				}				
				if($this->SDKey=='FXJS_FILE')
				{
					if(strlen($this->Key[1])>2){						
						$this->FXJSM_FILE = '<script type="text/javascript" src="'.$this->Key[1].'"></script>';			
					}	else{						
						$this->FXJSM_FILE ='';	
					}
				}
				if($this->SDKey=='TEXTAREA')
				{
                    $this->FName = $this->Key[1];

                    $this->Name = $this->Key[2];
                    $this->Cols = $this->Key[3];
                    $this->Class = $this->Key[4];
                    $this->ID = $this->Key[5];

                    if(isset($this->Key[6]))
                    {
                        $this->TAB = $this->Key[6];
                    }else{
                        $this->TAB = "";
                    }
                    $this->SQL = 'SELECT `'.$this->FName.'` FROM '.$this->TABLE.' WHERE '.$this->TID.' ='.$this->TIDV.'';
                    if($this->RESULT = $this->DB->pdo->Query($this->SQL))
                    {
                            $this->ROW = $this->RESULT->fetch(PDO::FETCH_BOTH);
                            echo '<textarea NAME="'.$this->Name.'" CLASS="'.$this->Class.'" ID="'.$this->ID.'" cols="'.$this->Cols.'" tabindex="'.$this->TAB.'">'.$this->ROW[0].'</textarea>';
                            if(strpos($this->Class, 'summernote') == true)
                            {
                                $this->Script .= "var ".$this->ID." = $('#".$this->ID."').code();\n";    
                            }else{
                                $this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n";
                            }
                            
                            //$this->Script .= "var ".$this->ID." = $('#".$this->ID."').code();\n";
                            $this->Post .= $this->ID.':'.$this->ID.',';
                    }else{
                            echo '<span id="Error">Erreur dans l\'edition de '.$this->Name.'</span>';
                    }
                    echo '<script>$("#'.$this->ID.'").bind("keypress", function(e){if(e.keyCode==13){$("#send").click();}});</script>';
				}
				
				if($this->SDKey=='BUTTON')
				{
					$this->Value = $this->Key[1];
					$this->name = $this->Key[2];
					$this->Class = $this->Key[3];
					$this->ID = $this->Key[4];
					echo '<input type="button" name="'.$this->Name.'" CLASS="'.$this->Class.'" ID="'.$this->ID.'" value="'.$this->Value.'">';
				}		
				
				if($this->SDKey=='CBUTTON')
				{
					$this->Value = $this->Key[1];
					$this->name = $this->Key[2];
					$this->Class = $this->Key[3];
					$this->ID = $this->Key[4];
					$this->ACTION = $this->Key[5];
					echo '<input type="button" name="'.$this->Name.'" CLASS="'.$this->Class.'" ID="'.$this->ID.'" value="'.$this->Value.'" onclick="'.$this->ACTION.'">';
				}	
				if($this->SDKey == 'RADIO' ||$this->SDKey == 'radio')
				{
                    $this->Name = $this->Key[1];
                    $this->Class = $this->Key[2];
                    $this->ID = $this->Key[3];

                    $this->FName = $this->Key[4];
                    $this->Ctrue = $this->Key[5];
                    $this->Cfalse = $this->Key[6];
                    $this->SQL = 'SELECT `'.$this->FName.'` FROM '.$this->TABLE.' WHERE '.$this->TID.' ='.$this->TIDV.'';
                    //echo $this->SQL;
                    if($this->RESULT = $this->DB->pdo->Query($this->SQL))
                    {
                        $this->FROW = $this->RESULT->fetch(PDO::FETCH_BOTH);
                        if($this->FROW[$this->FName] == 1){
                            echo '<div class="radio">';
                            echo '<input type="radio" id="'.$this->ID.'" name="'.$this->Name.'" class='.$this->Class.' value="1" checked="checked"/>';
                            echo '<label class="label">'.$this->Ctrue.'</label>';
                            echo '<input type="radio" id="'.$this->ID.'" name="'.$this->Name.'" class='.$this->Class.' value="0" />';
                            echo '<label class="label">'.$this->Cfalse.'</label></div>';
                        }else{
                            echo '<div class="radio"><input type="radio" id="'.$this->ID.'" name="'.$this->Name.'" class='.$this->Class.' value="1"/><label class="label">'.$this->Ctrue.'</label>';
                            echo '<input type="radio" id="'.$this->ID.'" name="'.$this->Name.'" class='.$this->Class.' value="0"  checked="checked"/><label class="label">'.$this->Cfalse.'</label></div>';
                        }
                    }
                    $this->Script .= "var ".$this->ID." = $('input[type=radio][name=".$this->Name."]:checked').val();\n";
                    $this->Post .= $this->ID.':'.$this->ID.',';
                }
				if($this->SDKey == 'CHECKBOX' ||$this->SDKey == 'checkbox')
				{
                    $this->FName = $this->Key[1];
                    $this->Name = $this->Key[2];
                    $this->Class = $this->Key[3];
                    $this->ID = $this->Key[4];
                    
                    $this->SQL = 'SELECT `'.$this->FName.'` FROM '.$this->TABLE.' WHERE '.$this->TID.' ='.$this->TIDV.'';
                    //echo $this->SQL;
                    //die();
                    if($this->RESULT = $this->DB->pdo->Query($this->SQL))
                    {
                        $this->FROW = $this->RESULT->fetch(PDO::FETCH_BOTH);
                        //var_dump($this->RESULT); 
                        //$this->FROW = $this->DB->Farray($this->RESULT);
                        if($this->FROW[$this->FName] == 1)
                        {
                            echo '<input type="checkbox" id="'.$this->ID.'" name="'.$this->Name.'" class='.$this->Class.' value="1" checked="checked"/>';
                         }else{
                            echo '<input type="checkbox" id="'.$this->ID.'" name="'.$this->Name.'" class='.$this->Class.' value="0"/>';
                         }
                    }
                    $this->Script .= "var ".$this->ID." = $('input[type=checkbox][name=".$this->Name."]:checked').val();\n";
                    $this->Script .= "if(".$this->ID." == undefined){".$this->ID." = 0;}else{".$this->ID." = 1;}\n";
                    $this->Post .= $this->ID.':'.$this->ID.',';
                }
				if($this->SDKey=='AUTOCOMPLETE')
				{
                                    //echo 1;
                                    if(!class_exists('DATABASE'))
                                    {
                                        if(file_exists('../DB/DB.class.php')){
                                            require_once '../DB/DB.class.php';
                                        }elseif(file_exists('../../../../includes/Classes/DB/DB.class.php'))
                                        {
                                            require_once('../../../../includes/Classes/DB/DB.class.php');
                                        }elseif(file_exists('includes/Classes/DB/DB.class.php'))
                                        {
                                            require_once('includes/Classes/DB/DB.class.php');
                                        }elseif(file_exists('../includes/Classes/DB/DB.class.php'))
                                        {
                                            require_once('../includes/Classes/DB/DB.class.php');
                                        }else{
                                            die('Erreur de base de donne�</option>');
                                        }
                                    }
                                    if(sizeof($this->Key) === 11 || sizeof($this->Key) === 12 || sizeof($this->Key) === 13 || sizeof($this->Key) === 14)
                                    {
                                        $this->IDField = $this->Key[1];
                                        list($FID,$FIDSDT,$SFSDT,$TSDT)= preg_split('[\|]',$this->Key[1]);
                                        $this->EditField = $this->Key[1];
                                        $this->SQL = 'SELECT `'.$FID.'` FROM '.$this->TABLE.' WHERE '.$this->TID.' ='.$this->TIDV.'';
                                        //echo $this->SQL;
                                        $this->RES = $this->DB->pdo->Query($this->SQL);
                                        $this->ROW = $this->DB->FArray($this->RES);
                                        $IDROW = $this->ROW[0];
                                        //echo $this->SQL;
                                        $this->SQL = 'SELECT `'.$SFSDT.'` FROM '.$TSDT.' WHERE '.$FIDSDT.' ='.$IDROW.'';
                                        //echo $this->SQL;
                                        $this->RES = $this->DB->pdo->Query($this->SQL);
                                        $this->ROW = $this->DB->FArray($this->RES);
                                        $Field =  $IDROW;
                                        $SField = $this->ROW[0];
                                        //echo $this->SQL;
                                        $this->FirstID = $this->Key[2];
                                        $this->FirstClass = $this->Key[3];
                                        $this->Name = $this->Key[4];
                                        $this->TAB = $this->Key[5];
                                        $this->Class = $this->Key[6];
                                        $this->ID = $this->Key[7];
                                        $this->Size = $this->Key[8];
                                        $this->File = $this->Key[9];
                                        $this->Parm = $this->Key[10];
                                        if(isset($this->Key[11]) && $this->Key[11] != '')
                                        {
                                            $this->SDParm = $this->Key[11];
                                            if($this->SDParm != '')
                                            {
                                                    $SDParm = 'var SDParm  = $("#'.$this->SDParm.'").val();';
                                            }else{
                                                    $SDParm = 'var SDParm = \'Nothing\;';
                                            }
                                        }else{
                                            $SDParm = 'var SDParm = \'Nothing\';';
                                        }
                                        $this->Script .= "var ".$this->ID." = $('#".$this->Name."').val();\n";
                                        $this->Post .= $this->ID.':'.$this->ID.',';
                                        ///function to be executed in select
                                        if(isset($this->Key[12]) && $this->Key[12])
                                        {
                                            if(isset($this->Key[13]) && $this->Key[13] != '')
                                            {
                                                    $this->FunctionParm = ',\''.$this->Key[13].'\'';
                                            }else{
                                                    $this->FunctionParm = '';
                                            }
                                            $this->Funnction = $this->Key[12].'(ui.item.ID'.$this->FunctionParm.');';
                                        }else{
                                            $this->Funnction = '';
                                        }
                                        $this->SQL = 'SELECT `'.$this->EditField.'` FROM '.$this->TABLE.' WHERE '.$this->TID.' ='.$this->TIDV.'';


                                        
                                        echo '<input type="TEXT" maxlength="50" id="'.$this->FirstID.'" class="'.$this->FirstClass.'" tabindex="'.$this->TAB.'" value="'.$SField.'">';
                                        echo '<input type="hidden" value="'.$Field.'" maxlength="'.$this->Size.'" id="'.$this->ID.'" class="'.$this->Class.'" name="'.$this->Name.'">';
                                        echo '<div id="'.$this->FirstID.'_bull" title="Erreur : valeur de champs introuvable"></div>';
                                        echo '<style>#'.$this->FirstID.'_bull{
                                            background: url("images/delete.png") no-repeat scroll 0 0 transparent;
                                            color: red;
                                            display: none;
                                            float: left;
                                            font-size: 10px;
                                            height: 8px;
                                            margin-left: -20px;
                                            margin-top: 11px;
                                            max-width: 9px;
                                            padding: 3px;
                                            width: 14px;
                                            cursor:pointer;
                                        }</style>';
                                        /*echo "<script language=\"javascript\">$(\"#".$this->FirstID."\").keyup(function(){
                                                        $SDParm
                                            $(this).autocomplete({
                                                    minLength: 0,
                                                    source: '".$this->File."?FSTParmOne=".$this->Parm."&SDParm='+SDParm ,
                                                    select: function(event, ui) {
                                                            $(this).val(ui.item.label);
                                                            $('#".$this->ID."').val(ui.item.ID);
                                                            ".$this->Funnction."

                                                    }
                                            })
                                            .data( \"autocomplete\" )._renderItem = function( ul, item ) {
                                                    return $( \"<li></li>\" )
                                                            .data( \"item.autocomplete\", item )
                                                            .append( \"<a>\" + item.label + \"</a>\" )
                                                            .appendTo( ul );
                                            };
                                    });</script>";
                                         * 
                                         */
                                        echo "<script language=\"javascript\">

                                                $(\"#".$this->FirstID."\").keyup(function(){
                                                });
                                                $(\"#".$this->FirstID."\").blur(function(){
                                                        var FSTParm = $(this).val();
                                                        ".$SDParm."
                                                        $.ajax({
                                                            type:'get',
                                                            url:'".$this->File."?FSTParmOne='+FSTParm+'&SDParm='+SDParm,
                                                            success:function(data){
                                                                if(data == 0)
                                                                {
                                                                    $(\"#".$this->ID."\").val('');
                                                                    $(\"#".$this->FirstID."_bull\").show();
                                                                    //$(\"#".$this->FirstID."_bull\").css('border','1px solid red'});
                                                                    //$(\"#".$this->FirstID."\").select();
                                                                }else{
                                                                    $(\"#".$this->ID."\").val(data);
                                                                    $(\"#".$this->FirstID."_bull\").hide();
                                                                    ".$this->Funnction."
                                                                }

                                                                if(data == '')
                                                                {
                                                                    console.log(\"Merci d\'ajouter la fonction blure pour ce champs il y a un ajax qui senvoies dans le blure sur ce champs\");
                                                                }
                                                            }
                                                        });
                                                });
                                        </script>";
                                    }else{
                                        echo '<div class="Error">Erreur de la cr&eacute;ation de l\'autocompl&egrave;tion !</div>';
                                    }
				}
				if($this->SDKey=='UPLOAD')
				{
                                    if(!class_exists('DATABASE'))
                                    {
                                        if(file_exists('../DB/DB.class.php')){
                                            require_once '../DB/DB.class.php';
                                        }elseif(file_exists('../../../../includes/Classes/DB/DB.class.php'))
                                        {
                                            require_once('../../../../includes/Classes/DB/DB.class.php');
                                        }elseif(file_exists('includes/Classes/DB/DB.class.php'))
                                        {
                                            require_once('includes/Classes/DB/DB.class.php');
                                        }elseif(file_exists('../includes/Classes/DB/DB.class.php'))
                                        {
                                            require_once('../includes/Classes/DB/DB.class.php');
                                        }else{
                                            die('Erreur de base de donne&eacute;</option>');
                                        }
                                    }
                                    $this->DIVID = $this->Key[1];
                                    $this->CLASSUPLOAD = $this->Key[2];
                                    $this->IDUPLOAD = $this->Key[3];
                                    $this->VALUPLOAD = $this->Key[4];
                                    $this->IDPICTURE = $this->Key[5];
                                    $this->SRCPICTURE = $this->Key[6];
                                    $this->PICTURECONTROLE = $this->Key[7];
                                    $this->EXTENSION = $this->Key[8];//jpg|png|jpeg|gif|bmp
                                    $this->EXTENSIONSAVE = $this->Key[9];//jpg
                                    $this->DIRTOSAVE = $this->Key[10];//jpg|png|jpeg|gif|bmp
                                    $this->DIRECTORY = $this->Key[11];
                                    $this->FILE = $this->Key[12];
                                    if(isset($this->Key[13]) && $this->Key[13] != '')
                                    {
                                        $this->Function = $this->Key[13].'();';///fonction apres l'upload
                                    }else{
                                        $this->Function = '';
                                    }
                                    echo '<div id="'.$this->DIVID.'" style="float:left"><input type="button" id="'.$this->IDUPLOAD.'" class="'.$this->CLASSUPLOAD.'" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$this->VALUPLOAD.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" style="margin-top:5px">';
                                    echo '<input type="hidden" id="'.$this->IDPICTURE.'" name="'.$this->IDPICTURE.'" value ="" title="'.$this->SRCPICTURE.'" style="width:50px;height:50px"/>';
                                    echo '<img src="images/Loading_File16.gif" id="Loading'.$this->IDPICTURE.'" style="margin-left: 6px;margin-top: 9px;position: absolute;display:none;">';
                                    echo '</div>';
                                    echo '
                                    <script language="javascript">
                                    $().ready(function(){
                                    new AjaxUpload("'.$this->IDUPLOAD.'", {
                                                                    action: "'.$this->DIRECTORY.$this->FILE.'",
                                                                    data: {Dir:"'.$this->DIRTOSAVE.'",EXT:"'.$this->EXTENSIONSAVE.'"},
                                                                    name: \'File\',
                                                                    autoSubmit: true,
                                                                    responseType: false,
                                                                    onSubmit : function(file,ext){
                                                                    if (! (ext && /^('.$this->EXTENSION.')$/i.test(ext))){
                                                                            // extension is not allowed
                                                                            alert(\'Error: invalid file extension\');
                                                                            return false;
                                                                    }
                                                            },
                                                            onSubmit: function('.$this->IDUPLOAD.', file){$("#Loading'.$this->IDPICTURE.'").fadeIn();},
                                                                    onComplete : function(file,response){
                                                                        if(response.match("Error"))
                                                                        {
                                                                            alert(response);
                                                                        }else{
                                                                            $("#Loading'.$this->IDPICTURE.'").attr("src","images/downloaded_finiched.png");
                                                                            $("#'.$this->IDPICTURE.'").attr("title",response);
                                                                            $("#'.$this->IDPICTURE.'").val(response);
                                                                            $("#span'.$this->IDPICTURE.'").html(response);
                                                                            '.$this->Function.'
                                                                        }
                                                                    }
                                                            });
                                    });
                                    </script>';
                                    $this->Script .= "var ".$this->IDPICTURE." = $('#".$this->IDPICTURE."').attr('title');\n";
                                    $this->Post .= $this->IDPICTURE.':'.$this->IDPICTURE.',';

				}
				if($this->SDKey == 'COMBO')
				{

					$this->FName = $this->Key[1];///field  name
					$this->Name = $this->Key[2];//html name
					$this->Class = $this->Key[3];///html class
					$this->ID = $this->Key[4];//html id
                    //$this->TABLE = $this->Key[7];//table name id
                    //echo sizeof($this->Key);
					switch(sizeof($this->Key))
					{
						case 8 :
    					$this->SQL = 'SELECT `'.$this->FName.'` FROM '.$this->TABLE.' WHERE '.$this->TID.' ='.$this->TIDV.'';
						//die('SQL : '.$this->SQL);
						
						if($this->RESULT = $this->DB->pdo->Query($this->SQL))
						{                                                   
							$this->FROW = $this->RESULT->fetch(PDO::FETCH_BOTH);//$this->DB->Farray();
							echo '<select name="'.$this->Name.'" id="'.$this->ID.'" class="form-control '.$this->Class.'">';
							
							//echo '<option>'.$this->SQL.'</option>';
							if(isset($this->Key[5]) && isset($this->Key[6]) && isset($this->Key[7]))
							{
                                $this->Table = $this->Key[5];///table
                                $this->FField = $this->Key[6];///field
                                $this->SField = $this->Key[7];///value
                                //you have to check table existance.
                                ///le nom du champs qui contient la valeur 1
                                if(isset($this->Key[8]))
                                {
                                    $this->Field_Has_One = $this->Key[8];
                                    $this->Where = ' WHERE '.$this->Field_Has_One.'=1' ;
                                    //you have to check table existance.
                                    $this->SQL="select `".$this->FField."`,`".$this->SField."` from ".$this->Table.$this->Where;
                                }else{
                                    //you have to check table existance.
                                    $this->SQL="select `".$this->FField."`,`".$this->SField."` from ".$this->Table.' order by 2';
                                    //echo '<option>'.$this->SQL.'</option>';
                                }
                                //($this->SQL);
                                $this->Result=$this->DB->pdo->Query($this->SQL);
                                while($this->ROW = $this->Result->fetch(PDO::FETCH_BOTH))
                                {
                                    echo $this->FROW[0];
                                    if($this->FROW[0] == $this->ROW[$this->FField])
                                    {
                                        echo '<option value="'.$this->ROW[$this->FField].'" selected="selected">'.$this->ROW[$this->SField].'</option>';
                                    }else{
                                        echo '<option value="'.$this->ROW[$this->FField].'">'.$this->ROW[$this->SField].'</option>';
                                    }
                                }
                                echo '</select>';
                                $this->Script .= "var ".$this->ID." = $('#".$this->ID." :selected').val();\n";
                                $this->Post .= $this->ID.':'.$this->ID.',';
							}else
                                echo '<option>Erreur dans l\'edition de '.$this->Name.'</option>';
							}
						break;
						case 7 :
                        $this->SQL="select `".$this->FName."` from ".$this->TABLE;
                        $this->Result=$this->DB->pdo->Query($this->SQL);
                        $this->ROW = $this->Result->fetch(PDO::FETCH_BOTH);

                            //var_dump($this->ROW[$this->FName] );

                            $this->Ctrue = $this->Key[5];
                            $this->Cfalse = $this->Key[6];
                            echo '<select name="'.$this->Name.'" id="'.$this->ID.'" class="'.$this->Class.'">';
                                    echo '<option value="1"';
                                    if(intval($this->ROW[$this->FName]) == 1){echo ' selected="selected"';}
                                    echo '>'.$this->Ctrue.'</option>';
                                    echo '<option value="0" ';
                                    if(intval($this->ROW[$this->FName]) == 0){echo ' selected="selected"';}
                                    echo '>'.$this->Cfalse.'</option>';
                            echo '</select>';
                            $this->Script .= "var ".$this->ID." = $('#".$this->ID." :selected').val();\n";
                            $this->Post .= $this->ID.':'.$this->ID.',';
                        
					}
						
				}				
				if($this->SDKey == 'COMBOROLLER')
				{													
                                    $login = $session->getSession('ESYA');
                                    $Config = new Config();
                                    $res = $this->DB->pdo->Query("select website from clients where login = '$login'");
                                    $row = $this->DB->FAssoc($res);
                                    $this->WBSite =$row['website'];
                                    $this->Name = $this->Key[1];
                                    $this->Class = $this->Key[2];
                                    $this->ID = $this->Key[3];
                                    $this->FOLDER = $this->Key[4];
                                    $this->DIR = $this->Key[5];
                                    $this->SQL = 'SELECT `'.$this->Name.'` FROM '.$this->TABLE.' WHERE '.$this->TID.' ='.$this->TIDV.'';
                                    //die($this->SQL);
                                    $this->db = new Database();
                                    if($this->RESULT = $this->db->Query($this->SQL))
                                    {
                                        $this->ROW=$this->db->Farray($this->RESULT);
                                        echo '<INPUT TYPE="hidden" NAME="'.$this->Name.'" CLASS="'.$this->Class.'" ID="'.$this->ID.'" value="'.$this->ROW[$this->Name].'">';
                                        echo '<div id="switcher_'.$this->ID.'" style="float:left;height:26px;margin-top:5px;position:relative;width:200px;">';
                                        echo '<a href="#" ><span class="jquery-ui-themeswitcher-icon" ></span><span>Images : </span></a>';
                                        echo '<div id="mdiv_'.$this->ID.'">
                                        <ul>';
                                        foreach(self::get_Pictures($this->FOLDER,$this->DIR) as $cle=>$valeur)
                                        {
                                        echo '<li>
                                        <a href="#" class="Except">
                                        <img title="UI Lightness" alt="UI Lightness" src="http://'.$Config->WS.'/'.$Config->WS_DIR.'/'.$valeur.'" style="float: left; border: 1px solid rgb(51, 51, 51); margin: 0pt 2px;width:100px;height:70px">
                                        </a>
                                        </li>';
                                        }
                                        echo '</ul>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '<img src="" class="switcher_img_name_'.$this->ID.'" style="margin-left:38px">';
                                        /////
                                        if($this->Class == 'summernote')
                                        {
                                            $this->Script .= "var ".$this->ID." = $('#".$this->ID."').code();\n";    
                                        }else{
                                            $this->Script .= "var ".$this->ID." = $('#".$this->ID."').val();\n";
                                        }
                                        
                                        $this->Post .= $this->ID.':'.$this->ID.',';
                                    }else{
                                            echo '<span id="Error">Erreur dans l\'edition de '.$this->Name.'</span>';
                                    }
				}
				//$Config = new Config();

				if($this->SDKey=='CSS_FILE')
				{
					echo '<link rel="stylesheet" href="http://'.$Config->WS.$Config->DS.$Config->WS_DIR.$Config->DS.$this->Key[1].'">';	
				}

				if($this->SDKey=='PEND')
				{
					echo '</p>';	
				}
/*****************************************************************/
				//COMBOSPECIAL
				if($this->SDKey=='COMBOSPECIAL')
				{
					$this->id_mm = $this->Key[1];
					$this->id_menu = $this->Key[2];
					$this->TableD = $this->Key[3];
					$this->TableS = $this->Key[4];
					$this->Link = $this->Key[5];
					$this->SQLD = 'SELECT count(`'.$this->id_menu.'`) as nbre , `module`,`link` FROM '.$this->TableD.' WHERE '.$this->id_menu.' ='.$this->TIDV.'';
					$this->SQLS = 'SELECT count(`id_link`) as nbre ,`link` FROM '.$this->TableS.' WHERE '.$this->id_menu.' ='.$this->TIDV.'';
					$this->RESULTD = $this->DB->pdo->Query($this->SQLD);
					$this->FROWD = $this->DB->Farray($this->RESULTD);
					$this->RESULTS = $this->DB->pdo->Query($this->SQLS);
					$this->FROWS = $this->DB->Farray($this->RESULTS);
					//Dynamic			
					if($this->FROWD['nbre'] != 0){
						$this->Modul = $this->FROWD['module'];	
						$this->Link_ID = $this->FROWD['link'];					
						$this->SQLD = 'SELECT * FROM menu_modules';						
						$this->RESULTD = $this->DB->pdo->Query($this->SQLD);
						echo '<select name="'.$this->id_mm.'" id="'.$this->id_mm.'" class="">';						
						while($this->FROWD = $this->DB->Farray($this->RESULTD)){
							if($this->Modul == $this->FROWD['id_mm']){
								echo '<option value="'.$this->FROWD['id_mm'].'" selected="selected">'.$this->FROWD['name'].'</option>';
							}else{
								echo '<option value="'.$this->FROWD['id_mm'].'">'.$this->FROWD['name'].'</option>';
							}							
						}
						echo '</select>';
						echo '<label id="liste" class="liste">Liste :</label>';												
						switch ($this->Modul) {
							//article simple
							case '1':
								echo '<select name="'.$this->Link.'" id="'.$this->Link.'" class="">';
								$this->SQLAR = 'SELECT id_article,title FROM article';						
								$this->RESULTAR = $this->DB->pdo->Query($this->SQLAR);
								while($this->FROWAR = $this->DB->Farray($this->RESULTAR)){
									if($this->Link_ID == $this->FROWAR['id_article']){
										echo '<option value="'.$this->FROWAR['id_article'].'" selected="selected">'.$this->FROWAR['title'].'</option>';
									}else{
										echo '<option value="'.$this->FROWAR['id_article'].'">'.$this->FROWAR['title'].'</option>';
									}							
								}
								echo '</select>';
							break;
							//awi article avec image
							case '2':
								echo '<select name="'.$this->Link.'" id="'.$this->Link.'" class="">';
								$this->SQLAW = 'SELECT id_awi,title FROM awi';						
								$this->RESULTAW = $this->DB->pdo->Query($this->SQLAW);
								while($this->FROWAW = $this->DB->Farray($this->RESULTAW)){
									if($this->Link_ID == $this->FROWAW['id_awi']){
										echo '<option value="'.$this->FROWAW['id_awi'].'" selected="selected">'.$this->FROWAW['title'].'</option>';
									}else{
										echo '<option value="'.$this->FROWAW['id_awi'].'">'.$this->FROWAW['title'].'</option>';
									}							
								}
								echo '</select>';
							break;
							//produit
							case '3':
								echo '<select name="'.$this->Link.'" id="'.$this->Link.'" class="">';
								$this->SQLPR = 'SELECT id_product,title FROM awi';						
								$this->RESULTPR = $this->DB->pdo->Query($this->SQLPR);
								while($this->FROWPR = $this->DB->Farray($this->RESULTPR)){
									if($this->Link_ID == $this->FROWPR['id_product']){
										echo '<option value="'.$this->FROWPR['id_product'].'" selected="selected">'.$this->FROWPR['title'].'</option>';
									}else{
										echo '<option value="'.$this->FROWPR['id_product'].'">'.$this->FROWPR['title'].'</option>';
									}							
								}
								echo '</select>';
							break;
							//produit
							case '5':
								echo '<select name="'.$this->Link.'" id="'.$this->Link.'" class="">';
								$this->SQLPR = 'SELECT id_contact,name FROM contact';						
								$this->RESULTPR = $this->DB->pdo->Query($this->SQLPR);
								while($this->FROWPR = $this->DB->Farray($this->RESULTPR)){
									if($this->Link_ID == $this->FROWPR['id_contact']){
										echo '<option value="'.$this->FROWPR['id_contact'].'" selected="selected">'.$this->FROWPR['name'].'</option>';
									}else{
										echo '<option value="'.$this->FROWPR['id_contact'].'">'.$this->FROWPR['name'].'</option>';
									}							
								}
								echo '</select>';
							break;
							
							default:
								die('default');
							break;
						}
					//Static								
					}elseif($this->FROWS['nbre']!=0){								
						$this->SQLS = 'SELECT * FROM menu_modules';						
						$this->RESULTS = $this->DB->pdo->Query($this->SQLS);
						echo '<select name="'.$this->id_mm.'" id="'.$this->id_mm.'" class="">';						
						while($this->FROWST = $this->DB->Farray($this->RESULTS)){
							if($this->FROWST['id_mm'] == '4'){
								echo '<option value="'.$this->FROWST['id_mm'].'" selected="selected">'.$this->FROWST['name'].'</option>';
							}else{
								echo '<option value="'.$this->FROWST['id_mm'].'">'.$this->FROWST['name'].'</option>';
							}							
						}
						echo '</select>';
						echo '<label id="liste" class="">Lien :</label>';
						echo '<input type="text" id="link" name="link" maxsize="30" value="'.$this->FROWS['link'].'">';									
					}
					
				}
				
/*********************************************************************/				
				if($this->SDKey=='DIVSTART')
				{
					$this->ID = $this->Key[1];
					$this->Class = $this->Key[2];
                                        if(!isset($this->Key[3]))
                                        {
                                            $this->Style = 'display:block';
                                        }else{
                                            $this->Style = 'disploay:hidden';
                                        }
					echo '<div class="'.$this->Class.'" id="'.$this->ID.'" style="'.$this->Style.'">';
				}
				
				if($this->SDKey=='DIVEND')
				{
					echo '</div>';
				}
				
			}
		}
		if(!(isset($this->FXJSM_FILE)))
		{
			$this->FXJSM_FILE = '';
		}else{
			echo $this->FXJSM_FILE;
		}
		if(!(isset($this->FUNSCRIPT)))
		{
			$this->FUNSCRIPT = '';
		}		
		$this->FScript = '<script type="text/javascript">
		$(document).ready(function(){
									$("input#close").click(function(){
										$("#facebox_overlay").fadeOut(\'fast\');
									});		
								   $("#send").click(function(){
															 '.$this->Script.'															 
															 $.ajax({
																   type:"POST",
																   url:"'. site_url('includes/functions/operations/Edit.php') .'",
																   data:{'.substr($this->Post,0,strlen($this->Post)-1).'},
																   success:function(data){																  
																	   if(data == 1)
																	   {
                                                                            '.$this->FUNSCRIPT.'
                                                                            /*
                                                                            $("#facebox").fadeOut();
                                                                            var L = window.location.href;
                                                                            var reg=new RegExp("[&]+", "g");
                                                                            L = L.split(reg);
                                                                            L = L[0];
                                                                            reg=new RegExp("[?]+", "g");
                                                                            L = L.split(reg);
                                                                            L = L[1];
                                                                            reg=new RegExp("[=]+", "g");
                                                                            L = L.split(reg);
                                                                            Module = L[1];
                                                                            if(window.opner)
                                                                            {
                                                                                window.opener.location.reload();
                                                                            }
                                                                            $("#facebox_overlay").fadeOut();
                                                                            $("#overlay").fadeOut();
                                                                            alert("Modification bien pris en compte");
                                                                            //window.close();
                                                                            window.location.reload();
                                                                            */
                                                                            window.history.back();
																	   }else{
																			alert(data);
																	   }
																   }					   
																   })
															 });
															
		';
		$this->EScript = '});</script>';
		echo $this->FScript.$this->EScript;
	}
public function get_Pictures(){
        $Config = new Config();
	$Return = array();
	$FOLDER = func_get_arg(0);		
	$DIRE = func_get_arg(1);
	$REP = $FOLDER.$DIRE;					
	//pour rendre les imgaes																
		if(is_dir($REP)){				
			if ($dir = opendir($REP)) {
			  while($file = @readdir($dir)) {
			  	if ($file != "." && $file != ".." && (stristr($file,'.gif') 
			  	|| stristr($file,'.jpg') 
			  	|| stristr($file,'.png') 
			  	|| stristr($file,'.bmp')
			  	|| stristr($file,'.JPG') 
			  	|| stristr($file,'.PNG') 
			  	|| stristr($file,'.BMP')
			  	|| stristr($file,'.jpeg') 
			  	|| stristr($file,'.JPEG')		  	
			  	)){	 
			  		$REP = str_replace('../../../','http://'.$Config->WS.'/'.$Config->WS_DIR.'/',$REP);
			  		array_push($Return,$REP.'/'.$file); 
			  	}
			  }
			  closedir($dir);
			}
		}else{				
			$Return .='Repertoir n\'existe pas';	
		}		
		return $Return;	
} 
}
?>