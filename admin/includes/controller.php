<?php
use Core\Security;
use Core\Controllers\Admin\UserController;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostController
 *
 * @author Moullablad
 */
     
//require_once 'initialize.php';
$Security = new Security();
//$passwords = new passwords();
$Users = new UserController();

if( isset($_SESSION['admin']) ){
    $user_info = UserController::getData();
}


if(isset($_POST['class']) && !empty($_POST['class']))
{
    switch($_POST['class'])
    {
        case 'forget_password' : 
            if($Security->check_email($_POST['email']))
            {
                $email = $_POST['email'];
                echo $passwords->SendPassword($email);
                die();
            }else{
                echo ("<script>window.location = 'Login';</script>");
                die();
            }
            break;
        case 'login' : 
            if(isset($_POST['email']) && $Security->check_email($_POST['email']) && isset($_POST['password']) && $Security->check_pwd($_POST['password']))
            {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $login = $Users->login($email, $password);
                //die($login);
            }else{
                echo ("<script>window.location = 'index.php?module=login';</script>");
                die();
            }
            break;
        case 'Subscribe' : 
            if($Security->check_email($_POST['email']))
            {
                $email = $_POST['email'];
                require_once 'includes/plugins/users/subscribe/subscribe.php';
            }
            break;
    }
}
?>