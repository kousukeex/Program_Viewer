<?php
    function Menu($logined,$username,$userID){
        echo '
        <div id="menu">
        <a href="Program_List.php"><div>投稿プログラム一覧</div></a>
        <a href="Program_Toukou.php"><div>プログラムを投稿する</div></a>
        <a href="index.php"><div id="logo">ロゴ</div></a>
        <a href="Help.php"><div>ヘルプ</div></a>
        ';

        if($logined){
            printf('<a href="Profile.php?A=%s"><div id="profile">%s</div></a>',$userID,$username);
            echo '<a href="index.php?logout=true"><div id="logout">ログアウト</div></a>';
        }
        else
            echo '<a href="Account_Login.php"><div id="login">ログイン</div></a>';
        echo '</div>';
    }
?>