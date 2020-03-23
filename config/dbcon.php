<?php
$conn=mysqli_connect($host,$uname,$pass);
if($conn){
  $sql="CREATE DATABASE IF NOT EXISTS todo";
  mysqli_query($conn,$sql);
  mysqli_select_db($conn, "todo");
  $createUsersTable="CREATE TABLE IF NOT EXISTS users(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    password VARCHAR(255)
  )";
  $createTodosTable="CREATE TABLE IF NOT EXISTS todos(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(60) NOT NULL,
    notes TEXT NOT NULL,
    priority INT,
    created_by VARCHAR(60),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
  if(!mysqli_query($conn,$createUsersTable) || !mysqli_query($conn,$createTodosTable)){
    echo "F".mysqli_error($conn);
  }
}
 ?>
