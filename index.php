<?php
include 'start.php';
if(!$user->activeUser()){             // Check if user is logged in
    header("Location: login.php");}
if(isset($_POST['add'])){
  $title=$_POST['title'];
  $notes=$_POST['notes'];
  $priority=$_POST['priority'] ?? 0;
  $todos->add($title,$notes,$priority,$user->activeUser());}
if (isset($_GET['compeletedId'])) {
  if(count($todos->getList(null,$_GET['compeletedId']))){
    foreach ($todos->getList(null,$_GET['compeletedId']) as $todo) {  // Set created_by = null, because we are getting list using id
      if($todo['created_by'] != $user->activeUser()){
        header("Location: 404.html");           // If it is another user's item
        exit;
        exit;
      }else{
        if($todos->compeleted($_GET['compeletedId'])){
          header("Location:index.php");
          exit;
        }
      }}
  }else{
    header("Location: 404.html"); // If there is not item with given id
    exit;}
  }
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
  </head>
  <body>
    <div class="dropdown float-right">
      <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= htmlspecialchars($user->activeUser()) ?>
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="login.php?action=logout">Log Out</a>
      </div>
    </div>
        <form class="container" action="index.php" method="post">
      <label> What are you planning to do? </label><br>
      <input minlength="2" maxlength="58" type="text" name="title"><br>
      <label> Notes </label><br>
      <textarea maxlength="135"  name="notes"><?= htmlspecialchars($content) ?></textarea><br>
      <select  name="priority">
        <option value="0" selected disabled>Priority</option>
        <option value="1">Low</option>
        <option value="2">Medium</option>
        <option value="3">High</option>
      </select>
      <input class="btn btn-dark" type="submit" name="add" value="Add to List">
    </form>

    <table class="table table-bordered {{table_theme}}">
    <thead>
      <tr>
        <th scope="col">Title</th>
        <th scope="col">Notes</th>
        <th scope="col">Date</th>
        <th scope="col">Priority</th>
        <th scope="col">Compeleted</th>
      </tr>
    </thead>
    <tbody>
      <?php $priorityDict = array(0 =>'None', 1=>"Low", 2=>"Medium", 3=>"High");?>
      <?php $priorityColorDict = array(0 =>'none', 1=>"#959AE8", 2=>"#FFBF40", 3=>"#E9210E");?>

        <?php foreach($todos->getList($user->activeUser(),null) as $todo) {?>
            <tr>
              <td style="border-left-color:<?= $priorityColorDict[$todo['priority']] ?>;border-left-width:10px;"><?= htmlspecialchars($todo['title']) ?></td>
                <td><?= htmlspecialchars($todo['notes']) ?></td>
                <td><?= htmlspecialchars($todo['created_at']) ?></td>
                <td> <?= $priorityDict[$todo['priority']] ?> </td>
                <td><a  href='index.php?compeletedId=<?= $todo['id']?>'><button class="btn btn-danger">Delete</button></a></td>
            </tr>
          <?php } ?>
                </tbody>
              </table>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
