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
    <link rel="stylesheet" href="css/Editor.css">
  </head>
  <body>
  <?php
    Menu($logined,$username,$_SESSION["UserID"]);
  ?>
  <div id="Editor">
  <?php
    $data = $pdo->AccessSourceFile($_GET["f"]);
    printf('<h1>%sの編集</h1>',$data[0]);
    $_SESSION["savepath"] = $data[1];
    $_SESSION["openpath"] = $data[0];
    $_SESSION["fileid"] = $_GET["f"];
  ?>
    <form action="Save_Process.php" method="POST">
      ファイル名:<input type="input" name="filename" value=<?php echo $data[0]?>>
      <input type="submit" value="保存" id="save">
      <textarea name="pad" multiple rows="25" cols="100">
          <?php
            foreach(file($data[1].$data[0]) as $line){
                echo $line;
            }
          ?>
      </textarea>
  </form>
  </div>
</body>
</html>
