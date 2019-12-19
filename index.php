<?php
  require 'Menu.php';
  session_start();
  if(isset($_GET["logout"])){
    session_destroy();
    header('Location:./index.php',true);
  }
  if(isset($_SESSION["username"])){
    $logined = true;
    $username = $_SESSION["username"];
  }
  else{
    $logined = false;
    $username = "";
  }
?>
<!DOCTYPE html>
    <meta charset="utf-8">
<html>
  <head>
    <title>ProgrammingViewer -プログラム投稿</title>
    <link rel="stylesheet" href="css/menu.css">
  </head>
  <body>
  <?php
    if(!(isset($_SESSION["UserID"])))
      $_SESSION["UserID"] = null;
    Menu($logined,$username,$_SESSION["UserID"]); 
  ?>

</body>
</html>
