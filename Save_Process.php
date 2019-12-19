<?php
    session_start();
    require 'database.php';
    $pdo = new DataBasePDO();
    rename($_SESSION["savepath"].$_SESSION["openpath"],$_SESSION["savepath"].$_POST["filename"]);
    $fp = fopen($_SESSION["savepath"].$_POST["filename"],"w");
    fwrite($fp,$_POST["pad"]);
    fclose($fp);
    unset($_SESSION["savepath"]);
    $pdo->updateFile($_SESSION["fileid"],$_POST["filename"]);
    header('Location:./Source.php?f='.$_SESSION["fileid"],true);
?>