<?php
include 'start.php';
if(isset($_GET['action']) && $_GET['action']=='logout'){
  $user->logOut();
}
if($user->activeUser()){
  header("Location:index.php");
  exit;
}else{
  if(isset($_POST['register'])){
    header("Location:register.php");
    exit;
  }
  if(isset($_POST['login'])){
    $username=$_POST['username'];
    $password=$_POST['pass'];
    if($user->auth($username,$password,$_POST['remember'])){
      header("Location: index.php");
      exit;
    }
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>To Do login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
  </head>
  <body><br>
  <div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">
    <form class="col-7" method="post" action="login.php">
      <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" name="username" placeholder="username" value="<?= htmlspecialchars($username)?>"><br>
      </div>
      <div class="form-group">
        <label >Password</label>
        <input type="password" class="form-control" name="pass" placeholder="Enter password">
      </div>
      <label> Remember me: </label>
      <input type="checkbox" checked name="remember"><br>
      <span class="error"><?= $user->errors['authE'].$user->errors['empty']; ?></span><br>
      <input class="btn btn-dark " type="submit" name="login" value="Log in">
      <input class="btn btn-secondary" type="submit" name="register" value="Sign Up">
    </form>
  </div>
</div>
  </body>
</html>
