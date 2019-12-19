<!DOCTYPE html><head>
    <meta charset="UTF-8">
</head>
<body>
<?php
    require 'database.php';
    $userID = $_POST["loginID"];
    $password = $_POST["password"];
    $pdo = new DataBasePDO();
    $result = $pdo->AccountAuthrize($userID,$password);
    session_start();
    if(!$result){
        $_SESSION["error"]=100;
        header('Location:./Account_Login.php',true);
    }
    else{
        $_SESSION["UserID"] = $result[2];
        $_SESSION["loginID"] = $result[0];
        $_SESSION["username"] = $result[1];
        header('Location:./index.php',true);
    }
?>
</body>