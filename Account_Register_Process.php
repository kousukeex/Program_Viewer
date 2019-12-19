<?php
    require "database.php";
    session_start();
    $pdo=new DatabasePDO();
    $isSuccess = $pdo->AccountRegister($_SESSION);
    if($isSuccess){
        session_destroy();
        session_start();
        $_SESSION["Success"]=true;
        header("Location:Account_Login.php",true);
    }
    else{
        $_SESSION["Error"]=900;
        header("Location:./Account_Register.php",true);
    }
?>