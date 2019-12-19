<?php
    require 'database.php';
    session_start();
    $loginID = $_POST["loginID"];
    $password = $_POST["password"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $birthYear = $_POST["birthYear"];
    $birthMonth = $_POST["birthMonth"];
    $birthDay = $_POST["birthDay"];
    $jobid = $_POST["job"];
    $_SESSION["loginID"] = $loginID;
    $_SESSION["username"] = $username;
    $_SESSION["email"] = $email;
    $_SESSION["firstname"] = $firstname;
    $_SESSION["lastname"] = $lastname;
    $_SESSION["birthYear"] = $birthYear;
    $_SESSION["birthMonth"] = $birthMonth;
    $_SESSION["birthDay"] = $birthDay;
    $_SESSION["jobid"]=$jobid;
    $_SESSION["needFix"]=0;//左から順にログインID(1),パスワード,生年月日の構成で行う 
    $pdo=new DataBasePDO();
    if($pdo->AccountMatching($loginID)){
      
    }

?>

<!DOCTYPE html>
    <meta charset="utf-8">
<html>
  <head>
    <title>DartServer</title>
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/Account_Register.css">
  </head>
  <body>
  <div id="menu">
    <a href="Program_List.php"><div>ソース</div></a>
    <a href="Program_Toukou.php"><div>投稿</div></a>
    <a href="index.php"><div id="logo">ロゴ</div></a>
    <a href="Help.php"><div>ヘルプ</div></a>
    <a href="Account_Login.php"><div id="login">ログイン</div></a>
  </div>
  <div id="RegisterPreview">
        <p><b>下記をご確認の上、送信してください</b></p>
        <?php
            printf("<p>ログインID:%s</p>",$loginID);
            printf("<p>ユーザーネーム:%s</p>",$username);
            printf("<p>Eメールアドレス:%s</p>",$email);
            printf("<p>姓:%s</p>",$firstname);
            printf("<p>名:%s</p>",$lastname);
            printf("<p>生年月日:%s年 %s月 %s日</p>",$birthYear,$birthMonth,$birthDay);
        ?>
        <a href="Account_Register.php" id="back"><button type="button">戻る<button></a>
        <a href="Account_Register_Process.php" id="submit"><button >送信</button></a>
  </div> 
</body>
</html>
