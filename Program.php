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
  if(isset($_GET["p"])){
      $programid = $_GET["p"];
  }
  $pdo = new DataBasePDO();
?>
<!DOCTYPE html>
    <meta charset="utf-8">
<html>
  <head>
    <title>DartServer</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="Program.css">
  </head>
  <body>
  <?php
    if(isset($_SESSION["UserID"]))
        Menu($logined,$username,$_SESSION["UserID"]); 
    else
        Menu(null,null,null);
    ?>
    <div id="Program">
    <?php
    
    $get = $pdo->AccessProgram($programid);
    printf('<div id="programheader">');
    printf('<h2>%s</h2><span id="author">投稿者:%s</span>',$get[0],$get[6]);
    printf('<div>%s</div>',$get[1]);
    printf('<div id="date"><p><b>更新日</b>:%s</p><p>投稿日%s:</p></div>',$get[3],$get[2]);
    printf('分類:<a href="Program_List.php?Category=%s"><b>%s</b></a>',$get[4],$get[5]);
    printf('</div>');
    //プログラム関連ソースファイル
    printf('<div id="Source">');
    printf('<table id="Files">');
    printf('<th>ファイル名</th><th>使用言語</th><th>更新日</th>');
    $data = $pdo->AccessProgramFile($programid);
    foreach($data as $File){
        printf('<tr><td><a href="./Source.php?f=%s">%s</a></td><td>%s</td><td>%s</td></tr>',$File[0],$File[1],$File[2],$File[3]);
    }
    printf('</table>');
    printf('</div>');
  ?>
  </div>
</body>
</html>
