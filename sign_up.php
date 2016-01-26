<?php
if(isset($_POST["name"]) && isset($_POST["passwd"])){
  $username=$_POST["name"];
  $password=$_POST["passwd"];

  $pdo=new PDO("sqlite:user.sqlite");
  $list=$pdo->prepare("SELECT count(name) as nameList from (SELECT * FROM userList where name=?);");
  $list->execute(array($username));
  $result=$list->fetch();


  if ($result["nameList"]=="0" && $username!=null && $password!=null){
    $stmt=$pdo->prepare("INSERT INTO userList(id,name,password,win,lose,comment) VALUES(?,?,?,?,?,?);");
    $stmt->execute(array(null,$username,$password,0,0,null));

    $list=$pdo->prepare("SELECT * from userList WHERE name=?;");
    $list->execute(array($username));
    $result=$list->fetch();

    $_SESSION["id"]=$result["id"];
    $_SESSION["username"]=$username;

    print "登録完了しました";
    print "<a href='index.php'>ログイン画面へ</a>";
  }
  else if($username==null || $password==null){
    print "<p class='error'>入力不備があります。</p>";
  }
  else{
    print "<p class='error'>すでにそのユーザー名は使用されています。</p>";
  }

}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>新規登録</title>
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
    <h2>新規登録</h2>
    <?php
    print "<form action='sign_up.php' method='POST'>";
    print "<ul>";
    print "<li>";
    print "<label>名前</label><input name='name'>";
    print "</li>";
    print "<li>";
    print "<label>パスワード</label><input name='passwd' type='password'>";
    print "</li>";
    print "</ul>";
    print "<input type='submit' value='登録'>";
    print "</form>";

     ?>

     <a href="login_form.php">戻る</a>
  </body>
</html>
