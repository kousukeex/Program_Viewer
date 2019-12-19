<?php
    require 'Menu.php';
    require 'database.php';
    $pdo = new DataBasePDO();
    session_start();
    if(isset($_SESSION["loginID"]) && isset($_SESSION["username"])){
    $key = $_SESSION["loginID"];
    $username = $_SESSION["username"];
    $logined = true;
    }
    else{
        $_SESSION["error"] = 200;
        header("Location:Account_Login.php",true);
    }
?>

<html>
<head>
    <title>DartServer</title>
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/Program_Toukou.css">
</head>
<body>
    <?php
        Menu($logined,$username,$_SESSION["UserID"]);
        if(isset($_SESSION["Success"])) echo "投稿が完了しました";
    ?>
    <div id="ToukouForm">
    <h1>プログラム投稿フォーム</h1>
    *は必須項目です<br>
    <form action="Program_Toukou_Process.php" method="POST" enctype="multipart/form-data">
        <p>プログラム名*:<input type="text" name="program_name" maxlength="255" require></p>
        説明*:
        <p><textarea name="description" rows="20" cols="80" require></textarea></p>
        <p>分類:<select name="Category">
            <?php
                foreach($pdo->listCategories() as $category)
                    printf('<option value="%s">%s</option>',$category[0],$category[1]);
            ?>
        </select></p>
        <p>プログラムファイル*:<input type="file" name="files[]" multiple require></p>
        <p><input type="submit" value="投稿"></p>
    </form>
</div>
</body>
</html>