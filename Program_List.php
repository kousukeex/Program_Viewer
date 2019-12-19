<?php
  require 'Menu.php';
  require 'database.php';
  session_start();
  $keyword = "";
  $order = "default";
  $categoryid = -1;
  
  if(isset($_GET["logout"])){
    session_destroy();
    header('Location:./Program_List.php',true);
  }
  if(isset($_SESSION["username"])){
    $logined = true;
    $username = $_SESSION["username"];
  }
  else{
    $logined = false;
    $username = "";
  }
  if(isset($_GET["keyword"]))
      $keyword = $_GET["keyword"];
  if(isset($_GET["order"]))
      $order = $_GET["order"];
  if(isset($_GET["Category"]))
      $categoryid = $_GET["Category"];
  $pdo=new DataBasePDO();
?>
<!DOCTYPE html>
    <meta charset="utf-8">
<html>
  <head>
    <title>DartServer</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="Program_List.css">
  </head>
  <body>
  <?php
    if(isset($_SESSION["UserID"]))
        Menu($logined,$username,$_SESSION["UserID"]);
    else
        Menu(null,null,null)
  ?>
    <div id="Content">
    <form action="Program_List.php" method="get">
        キーワード:<input type="text" name="keyword">分類:<select name="Category">
            <option value="-1">指定なし</option>
            <?php
                foreach($pdo->ListCategories() as $category)
                    printf('<option value="%s">%s</option>',$category[0],$category[1]);
            ?>
        </select>
        日付順:<select name="order">
                <option value="default">何もしない</option>
                <option value="newer">新着投稿順</option>
                <option value="older">古い投稿順</option>
                <option value="unewer">新着更新順</option>
                <option value="uolder">古い更新順</option>
        </select>
        <input type="submit" value="検索">    
    </form>
    <?php
        if($keyword!="")
            printf("検索キーワード:%s<br>",$keyword);
    ?>
    <div id="ProgramList">
    <?php
    foreach($pdo->listPrograms($order,$keyword,$categoryid)->fetchAll() as $get){
        printf('<div class="Program">',$get[0]);
        printf('    <h1><a href="./Program.php?p=%s">%s</a></h1>',$get[0],$get[1]);
        printf('    <span id="author">投稿者:<a href="./Profile.php?A=%s">%s</a></span>',$get[3],$get[7]);
        printf('    <span id="Category">分類:<a href="./Program_List.php?Category=%s">%s</a></span><br>',$get[6],$get[8]);
        printf('    <span id="toukou">投稿日:%s</span><br><span id="update">更新日:%s</span>',$get[4],$get[5]);
        printf('</div>');
    }
    ?>
    </div>
    </div>

</body>
</html>
