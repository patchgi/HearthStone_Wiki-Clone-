<?php
session_start();
if(isset($_POST["name"])&&$_POST["passwd"]){
  $username=$_POST["name"];
  $password=$_POST["passwd"];

  $pdo=new PDO("sqlite:user.sqlite");
  $user=$pdo->prepare("SELECT * FROM userList where name=?;");
  $user->execute(array($username));
  $result=$user->fetch();
  if ($result["password"]==$password){
    $_SESSION["id"]=$result["id"];
    $_SESSION["username"]=$result["name"];
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: index.php");
  }
  else{
    print "<p class='error'>ユーザー名またはパスワードが違います。</p>";
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="css/syntax.css">
    <style>
    ul li {
        list-style: none;
    }
    label {
        margin-right: 10px;
        width:100px;
        float: left;
    }

    </style>
  </head>
  <body>
    <div>
      <h2>ログインフォーム</h2>
      <?php
      print "<form action='login_form.php' method='POST'>";
      print "<ul>";
      print "<li>";
      print "<label>名前</label><input name='name'>";
      print "</li>";
      print "<li>";
      print "<label>パスワード</label><input name='passwd' type='password'>";
      print "</li>";
      print "</ul>";
      print "<input type='submit'>";
      print "</form>";

       ?>
      <a href="sign_up.php">新規登録</a>
    </div>


  </body>
</html>
