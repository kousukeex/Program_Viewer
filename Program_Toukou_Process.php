<?php
    require 'database.php';
    $pdo = new DataBasePDO();
    session_start();
    $loginID = $_SESSION["loginID"];
    $userid = $pdo->findAccountID($loginID);
    $x = 0;
    $programid = $pdo->uploadProgram($_POST["program_name"],$_POST["description"],$userid,$_POST["Category"]);
    //URL関係の変数群
    $base = "./upload/";
    $useridUrl = $userid."/";
    $programidUrl = $programid."/";
    $uploadUrl = $base.$useridUrl.$programidUrl; ///upload/ユーザーid/Programid/となる
    var_dump($uploadUrl);
    mkdir($uploadUrl,0777,true);
    foreach($_FILES["files"]["tmp_name"] as $file){
        move_uploaded_file($file,$uploadUrl.$_FILES["files"]["name"][$x]);
        $fileid = $pdo->uploadProgramFiles($_FILES["files"]["name"][$x],$uploadUrl,$userid);
        $x += 1;
        $pdo->AssociateSource($programid,$fileid);
    }
    $_SESSION["Success"]=true;
    header("Location:Program_Toukou.php",True);
?>