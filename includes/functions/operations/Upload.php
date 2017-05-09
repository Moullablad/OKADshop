<?php
if(isset($_FILES['file']) && isset($_POST['D']) && isset($_POST['T']) && isset($_POST['F']) && isset($_POST['I']) && isset($_POST['E']) && isset($_POST['SI']))
{
	if(file_exists('../../includes/Classes/NET/UPLOADER/UPLOAD.class.php'))
	{
            require_once('../../includes/Classes/NET/UPLOADER/UPLOAD.class.php');
            $FILE = $_FILES['file'];
            $DIR = $_POST['D'];
            $TABLE = $_POST['T'];
            $FIELD = $_POST['F'];
            $ID = $_POST['I'];
            $EXT = $_POST['E'];
            $SI = $_POST['SI'];
            $UPLOADER = new UPLOAD();
            $UPLOADER->UFile($DIR,$FILE,$EXT,$TABLE,$FIELD,$ID,$SI);
	}else{
            echo 'Error : FNF UPLOAD CLS';
	}
}else{
    echo 'Error : Messing Argument';
}
?>