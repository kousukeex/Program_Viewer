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
  if(isset($_SESSION["loginID"]))
    $userid = $pdo->getUserID($_SESSION["loginID"]);
  $authorid = $pdo->getAuthoridbyFile($_GET["f"]);
?>
<!DOCTYPE html>
    <meta charset="utf-8">
<html>
  <head>
    <title>DartServer</title>
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/Source.css">
  </head>
  <body>
  <?php
    if(isset($_SESSION["UserID"]))
        Menu($logined,$username,$_SESSION["UserID"]); 
    else
        Menu(null,null,null);
  ?>
    <div id="SourceCode">
    <?php
        $data = $pdo->AccessSourceFile($_GET["f"]);
        printf('<h1>%s</h1>',$data[0]);
        printf('<span>投稿者:%s</span>',$data[3]);
        if(isset($userid))
            if ($userid[0] == $authorid[0])
                printf('<a href="./Editor.php?f=%s" id="edit">編集</a>',$_GET["f"]);

        printf('<table id="SourceView">');
        $count = 1;
        foreach(file($data[1].$data[0]) as $line){
            $line = str_replace("\r\n","",$line);
            printf("<tr><td>%s</td><td><pre>%s</pre></td></tr>",$count,$line);
            $count +=1;
        }
        printf("</table>");
    ?>
    </div>
</body>
</html>
