<?php
session_start();
$_SESSION=[];
session_destroy();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ログアウト</title>
  </head>
  <body>
<a href="login_form.php">トップに戻る</a>
  </body>
</html>
