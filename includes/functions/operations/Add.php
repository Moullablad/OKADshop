<?php
require_once '../../../config/bootstrap.php';
require_once('../../../classes/db/dbo.class.php');
$DBO = new DBO;

if(isset($_POST['module']))
{
    $Module = $_POST['module'];
    $DModule = $_POST['mdir'];
}else{
    die('Module indefined in Add');
}
//echo '../../../includes/plugins/'.$DModule.'/'.$Module.'/data.php';
require_once(admin_base('includes/plugins/'.$DModule.'/'.$Module.'/data.php'));
$DBO->INSERT(PADD());       
die();
?>