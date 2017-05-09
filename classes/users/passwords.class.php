<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of passwords
 *
 * @author Moullablad
 */
class passwords {
    public function __construct()
    {
        
    }
    //put your code here
    public function show_foget_password_form(){
        echo '<form action="" method="post">';
        echo '<div>';
        echo '<label id="lbl_forget_password">Forget password</label>';
        echo '<input id="txt_forget_password" type="email" value="" name="email">';
        echo '<input type="hidden" value="forget_password" name="class">';
        echo '<input type="submit">';
        echo '</div>';
        echo '</form>';
    }
    public function SerchUserByEmail($email){
        $DB = Database::getInstance();
        $query = "SELECT * FROM "._DB_PREFIX_."users WHERE email = '$email'";
        if($res = $DB->query($query))
        {
            if($res->rowCount() > 0)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function UpdatePassword($email,$password){
        $DB = Database::getInstance();
        $query = "update "._DB_PREFIX_."users set password = md5('$password') where email = '$email'";
        if($DB->exec($query))
        {
            return true;
        }else{
            return false;
        }
    }
    
    public function SendPassword($email){
        
        if(!passwords::SerchUserByEmail($email))
        {
            return 'D&eacute;sol&eacute;s, nous ne reconnaissons pas les identifiants que vous avez saisis.';
        }else{
            $password = passwords::PWDGEN();
            if($this->UpdatePassword($email,$password))
            {
                passwords::SendNewPassword($email,$password);
                return 'done';
            }else{
                return 'password not updated';
            }
        }
    }
    public function PWDGEN(){
        return substr(md5(time()),0,10);
    }
    public function getUserName($email){
        $DB = Database::getInstance();
        $query = "SELECT first_name,last_name FROM "._DB_PREFIX_."users WHERE email = '$email'";
        $res = $DB->query($query);
        $res = $res->fetchAll();
        return $res;
    }
    public function SendNewPassword($email,$password){
        $user = passwords::getUserName($email);
        $FirstName = $user[0]['first_name'];
        $LastName = $user[0]['last_name'];

        $headers  = "Reply-To: No replay <robot@".$_SERVER['HTTP_HOST'].">\r\n"; 
        $headers .= "Return-Path: a@grid.cool <a@".$_SERVER['HTTP_HOST'].">\r\n"; 
        $headers .= "From: Grid <no-reply@".$_SERVER['HTTP_HOST'].">\r\n"; 


        $headers .= "Content-type: text/html\r\n";
        $headers .= "Organization: grid.cool\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

        $subject = "Nouveau mot de passe pour $FirstName $LastName";
        
        $Message = "<h3>$FirstName $LastName,</h3>";
        $Message .= '<br>';
        $Message .= '<p>Votre nouveau mot de passe est: '.$password.'</p>';
        $Message .= '<br>';
        $Message .= '<p>L\'équipe</p>';
        $Message .= '<hr>';
        $Message .= '<center><a href="http://grid.cool" target="_blank">grid.cool</a> - be part of the active*</center>';

        if(mail($email, $subject, $Message, $headers))
        {
            return 'sent';
        }else{
            return 'not sent';
        }
    }
}

?>
