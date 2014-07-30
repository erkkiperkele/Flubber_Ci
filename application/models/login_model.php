<?php
Class User extends CI_Model
{
 function login($user, $pass)
 {

   $db2 = new DatabaseAccessObject('127.0.0.1', 'flubber.database', 'root', '');
   $db2->verifyLogin($user, $pass);
 }
}
?>

