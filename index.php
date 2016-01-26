<?php
session_start();
if(isset($_SESSION["id"])&&isset($_SESSION["username"])){
  $userID=$_SESSION["id"];
  $username=$_SESSION["username"];
}
else{
  header("HTTP/1.1 301 Moved Permanently");
  header("Location: login_form.php");
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>HearthStoneWiki(ホーム)</title>
  </head>
  <body>
    <?php

    print $username;
    print "<a href='logout.php'>ログアウト</a>";
    ?>
    <br><a href="search.php">検索ページ</a>
    <a href="makedeck.php">デッキビルド</a>
    <a href="battle.php">戦績</a>

  </body>
</html>
