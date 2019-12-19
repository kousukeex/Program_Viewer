<?php
  require 'Menu.php';
  require 'database.php';
  session_cache_expire(30);
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
  $pdo = new DataBasePDO();
?>
<!DOCTYPE html>
    <meta charset="utf-8">
<html>
  <head>
    <title>DartServer</title>
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/Program_List.css">
  </head>
  <body>
  <?php
    Menu($logined,$username,$_SESSION["UserID"]);
  ?>
  <div id="Content">
    <?php
    $person = $pdo->getProfile($_GET["A"]);
    printf('<p>ユーザーネーム:%s</p>',$person[0]);
    printf('<p>職業:%s</p>',$person[1]); 
    foreach($pdo->listProgramsByAccount($_GET["A"]) as $get){
        printf('<div class="Program">',$get[0]);
        printf('    <h1><a href="./Program.php?p=%s">%s</a></h1>',$get[0],$get[1]);
        printf('    <span>分類:<a href="./Program_List.php?Category=%s">%s</a></span><br>',$get[6],$get[8]);
        printf('    <span id="toukou">投稿日:%s</span><br><span id="update">更新日:%s</span>',$get[4],$get[5]);
        printf('</div>');
    }
   ?>
   </div>

</body>
</html>
