<?php
session_start();
// Edit theese lines
$host="";
$uname="";
$pass="";
////////////////////
$dbname="todo";
require 'config/dbcon.php';
$errors = array('dont-match' =>'', 'authE' => '' , 'empty' => '' , 'weakPassword' => '' , 'emailValidate'=>'', 'encode'=>'', 'usernameValidate'=>'', 'usernameTaken'=>'', 'emailTaken'=>'');
require 'user.php';
$user= new User($conn,$errors);
$todos = new Todos($conn);
$name=$username=$email=$title=$content="";
 ?>
