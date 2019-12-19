<?php
    require 'Menu.php';
    require 'database.php';
    session_cache_expire(30);
    session_start();

    if(!(isset($_SESSION["loginID"])))
      $_SESSION["loginID"] = "";
    if(!(isset($_SESSION["password"])))
      $_SESSION["password"] = "";
    if(!(isset($_SESSION["username"])))
      $_SESSION["username"] = "";
    if(!(isset($_SESSION["email"])))
      $_SESSION["email"] = "";
    if(!(isset($_SESSION["firstname"])))
      $_SESSION["firstname"] = "";
    if(!(isset($_SESSION["lastname"])))
      $_SESSION["lastname"] = "";
    if(!(isset($_SESSION["birthYear"])))
      $_SESSION["birthYear"] = null;
    if(!(isset($_SESSION["birthMonth"])))
      $_SESSION["birthMonth"] = null;
    if(!(isset($_SESSION["birthDay"])))
      $_SESSION["birthDay"] = null;
    if(!(isset($_SESSION["jobid"])))
      $_SESSION["jobid"]=1;
    
?>
<!DOCTYPE html>
    <meta charset="utf-8">
<html>
  <head>
    <title>DartServer</title>
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/Account_Register.css">
    <script>
      var jobid = <?php echo $_SESSION["jobid"]?>;
      function strLength(string){
        return string.length;
      }
    </script>
  </head>
  <body>
  <?php
  Menu(null,null,null); 
    ?>
  <div id="RegisterForm">
    <p>登録</p>
    <p>ProgramViewerのアカウントに登録することができます</p>
    <p warning>赤い入力欄は全て入力が必須となっております</p>
    <form action="Account_Register_Preview.php" method="POST">
    <?php
    printf('<p>ログインID(半角英数字の32文字まで):<input name="loginID" value="%s" maxlength="32" pattern="^[0-9A-Za-z]+$" required></p><span></span>',$_SESSION["loginID"]);
    printf('<p>パスワード(9~15文字以内):<input type="password" name="password" maxlength="15" required></p>');
    printf('<p>ユーザーネーム(32文字まで):<input name="username" value="%s" maxlength="32" required></p>',$_SESSION["username"]);
    printf('<p>Eメールアドレス<input type="E-mail" name="email" value="%s" pattern="[a-z0-9._\x19+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required></p>',$_SESSION["email"]);
    printf('<p>姓(6文字まで):<input name="firstname" value="%s" maxlength="6" required></p>',$_SESSION["firstname"]);
    printf('<p>名(12文字まで):<input name="lastname" value="%s" maxlength="12" required></p>',$_SESSION["lastname"]);
    printf('<p>生年月日:</p>');
    printf('<p>年(1960～2100):<input type="number" name="birthYear" value="%s" min="1960" max="2100" required></p>',$_SESSION["birthYear"]);
    printf('<p>月(1～12):<input type="number" name="birthMonth" value="%s" min="1" max="12" required></p>',$_SESSION["birthMonth"]);
    printf('<p>日(1～31):<input type="number" name="birthDay" value="%s" min="1" max="31" required></p>',$_SESSION["birthDay"]);
    echo '<p>職業:<select name="job">';
    $pdo = new DataBasePDO();
    foreach($pdo->listJobs() as $getJobs){
          printf('<option value="%s">%s</option>',$getJobs[0],$getJobs[1]);
        }
    echo '</select></p>';
    ?>
    <script>
      var getJobSelect = document.getElementsByName("job");
      getJobSelect[0].selectedIndex=jobid-1;
    </script>
    <p><input type="submit" value="送信"></p>
    </form>
  </div>
</body>
</html>