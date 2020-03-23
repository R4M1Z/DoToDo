<?php
require_once 'config/dbcon.php';
class User{
  public function __construct($conn,$errors){
    $this->conn=$conn;
    $this->errors=$errors;
  }
  public function activeUser(){
    if(isset($_SESSION['user']) || isset($_COOKIE['username'])){
      $active_user=$_COOKIE['username'] ?? $_SESSION['user']['username'];
      return $active_user;
    }else {
      return false;
    }
  }

  public function register($name,$username,$email,$password,$confirm){
    if($password!=$confirm){
      $this->errors['dont-match']="Passwords don't match";
    }
    if(trim($name)=='' || trim($email)=='' || trim($username)=='' || trim($password)=='' || trim($confirm)==''){
      $this->errors['empty']="You can't leave empty any of these fields! ";
    }
    if (!preg_match('/[a-zA-Z]/', $password) || !preg_match('/\d/', $password)){
      $this->errors['weakPassword']="Your password must contain numbers and letters";
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $this->errors['emailValidate']='It is not a valid address';
    }
    if(preg_match('/[^\x20-\x7e]/', $password)){
        $this->errors['encode']="Please don't use non-ASCII characters";
    }
    if(preg_match('/[^a-z0-9.]/', $username)){
        $this->errors['usernameValidate']="It is not a valid username";
      }

    $name=mysqli_real_escape_string($this->conn,$name);
    $username=mysqli_real_escape_string($this->conn,$username);
    $email=mysqli_real_escape_string($this->conn,$email);
    $password = mysqli_real_escape_string($this->conn,password_hash($_POST['password'], PASSWORD_DEFAULT));

    // Check if username is taken
    $sql="SELECT * FROM users WHERE username='$username'";
    $result=mysqli_query($this->conn,$sql);
    if(count(mysqli_fetch_all($result))>0){
      $this->errors['usernameTaken']="This username is already taken";
    }

    // Check if email is taken.
    $sql="SELECT * FROM users WHERE email='$email'";
    $result=mysqli_query($this->conn,$sql);
    if(count(mysqli_fetch_all($result))>0){
      $this->errors['emailTaken']="This email is already taken";
    }

    if(!array_filter($this->errors)){
      $sql="INSERT INTO users (name,username,email,password) VALUES('$name','$username','$email','$password')";
      if(mysqli_query($this->conn,$sql)){
        return true;
      }else return false;
    }
  }


  public function auth($username,$password,$remember=true){
    $username=mysqli_real_escape_string($this->conn,$username);
    $sql="SELECT * FROM users WHERE username='$username'";
    $result=mysqli_query($this->conn,$sql);
    $user=mysqli_fetch_assoc($result);
    if(!trim($username)=='' && !trim($password)==''){
      if(password_verify($password,$user['password'])){
        if($remember){
          setcookie('username',$user['username'],time()+86400);}
      $_SESSION['user']=$user;
      return true;

    } else{
    $this->errors['authE']="Username or password is incorrect";
    }
  }
  }

  public function logOut(){
    session_unset();
    setcookie('username','',time()-3600);
    header("Location:login.php");
    exit;
  }
}
class Todos{
  public function __construct($conn){
    $this->conn=$conn;
  }

////////////////////////////////////////////////////////// ADD ///////////////////////////////////////////////////////////////
  public function add($title,$notes,$priority,$created_by){
      $title=mysqli_real_escape_string($this->conn,$title);
      $notes=mysqli_real_escape_string($this->conn,$notes);
      $priority=mysqli_real_escape_string($this->conn,$priority);
      $created_by=mysqli_real_escape_string($this->conn,$created_by);
      $sql="INSERT INTO todos(title,notes,priority,created_by) VALUES ('$title','$notes','$priority','$created_by')";
      if(mysqli_query($this->conn,$sql)){
        return true;
      }else return false;
  }

  public function getList($created_by=null,$id=null){    // So we can get list username and id
    if($created_by){
      $created_by=mysqli_real_escape_string($this->conn,$created_by);
      $sql="SELECT * FROM todos WHERE created_by='$created_by' ORDER BY priority DESC";
    }else if($id){
      $id=mysqli_real_escape_string($this->conn,$id);
      $sql="SELECT * FROM todos WHERE id='$id'";
    }
    $result=mysqli_query($this->conn,$sql);
    $todos=mysqli_fetch_all($result,MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $todos;
  }


  public function compeleted($id){
    $id=mysqli_real_escape_string($this->conn,$id);
    $sql="DELETE FROM todos WHERE id='$id'";
    if(mysqli_query($this->conn,$sql)){
      return true;
    }else return false;
  }
}
?>
