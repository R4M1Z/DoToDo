<?php
include 'start.php';
if($user->activeUser()){
  header("Location:index.php");
}else{
  if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $confirm=$_POST['confirm'];
  if($user->register($name,$username,$email,$password,$confirm)){
    header("Location: login.php");
  }
}
}
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Register</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
     <link rel="stylesheet" href="style/style.css">
   </head>
   <body>
     <div class="container h-100">
       <div class="row h-100 justify-content-center align-items-center">

     <form class="col-7" action="register.php" method="post">
       <div class="form-group">
        <?php echo empty($user->errors['empty']) ? "" : "<span class='error'>".$user->errors['empty']."</span><br>"?>
       <label>Full Name</label><br>
       <input type="text" name="name" placeholder="name" value="<?= htmlspecialchars($name)?>"><br>
      </div>
       <label>Username</label><br>
       <?php echo $user->errors['usernameTaken']!='' ? "<span class='error'>".$user->errors['usernameTaken']."</span><br>" : ""?>
       <?php echo $user->errors['usernameValidate']!='' ? "<span class='error'>".$user->errors['usernameValidate']."</span><br>" : ""?>
       <input type="text" name="username" placeholder="username" value="<?= htmlspecialchars($username)?>"><br>
       <label>Email</label><br>
       <?php echo $user->errors['emailTaken']!='' ? "<span class='error'>".$user->errors['emailTaken']."</span><br>" : ""?>
       <?php echo $user->errors['emailValidate']!='' ? "<span class='error'>".$user->errors['emailValidate']."</span><br>" : ""?>
       <input type="text" name="email" placeholder="email" value="<?= htmlspecialchars($email)?>"><br>
       <label>Password</label><br>
       <?php echo $user->errors['weakPassword']!='' ? "<span class='error'>".$user->errors['weakPassword']."</span><br>" : ""?>
       <?php echo $user->errors['encode']!='' ? "<span class='error'>".$user->errors['encode']."</span><br>" : ""?>
       <input type="password" name="password" placeholder="password" ><br>
       <label>Confirm password</label><br>
       <?php echo $user->errors['dont-match']!='' ? "<span class='error'>".$user->errors['dont-match']."</span><br>" : ""?>
       <input type="password" name="confirm" placeholder="confirm password"><br>

       <input class="btn btn-secondary" type="submit" name="submit" value="Sign Up">

     </form>
    </div>
   </div>
   </body>
 </html>
