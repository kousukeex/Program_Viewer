<?php
  require 'Menu.php';
  session_start();
  session_destroy();
?>
<!DOCTYPE html>
    <meta charset="utf-8">
<html>
  <head>
    <title>DartServer</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="Account_Login.css">
  </head>
  <body>
   <?php
  Menu(null,null,null); 
  ?>
  <div id="Signin">
    <h1>ログイン</h1>
    <?php
      if(isset($_SESSION["error"])){
        if($_SESSION["error"] == 100){
          echo '<span class="error">ログインID、またはパスワードが違います</span>';
        }
        else if($_SESSION["error"] == 200){
          echo '<span class="error">ログインする必要があります</span>';
        }
      }
    ?>
      <form action="Account_Authrize.php" method="POST">
          ログインID:<br> 
          <input type="text" name="loginID" required><br>
          パスワード:<br>
          <input type="password" name="password" required><br>
          <input type="submit" value="ログイン"><br><br><br><br>
          アカウントを登録していない方は登録ボタンをクリックしてください<br>
          <a href="Account_Register.php"><button type="button">登録</button></a>
      </form>
  </div>
</body>
</html>
