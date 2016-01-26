<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>検索</title>
    <style>
table {
	border-collapse: collapse;
}
td {
	border: solid 1px;
	padding: 0.5em;
}
th {
	border: solid 1px;
	padding: 0.5em;
}
ul li {
    list-style: none;
}
label {
    margin-right: 10px;
    width:100px;
    float: left;
}

.preview{
	position: absolute;
	border: 3px solid #333;
	background: #444;
	padding: 5px;
	display: none;
	color: #FFF;
	text-align: center;
}
</style>
  </head>
  <body>
    <a href="index.php">ホーム</a>
    <h3>検索フォーム</h3>

    <div class ="form">
    <form action="search.php" method="POST">
      <ul>
        <li>
          <label>名前</label><input name="name"><br>
        </li>
        <li>
          <label>コスト</label><input type="number" name="cost"><br>
        </li>
        <li>
          <label>アタック</label><input type="number" name="attack"><br>
        </li>
        <li>
          <label>ヘルス</label><input type="number" name="health"><br>
        </li>
        <li>
          <label>カードタイプ</label><input type="radio" name="type" value="2">ミニオン<input type="radio" name="type" value="1">呪文<br>
        </li>
        <li>
          <label>レア度: </label><input type="radio" name="rarity" value="2">コモン<input type="radio" name="rarity" value="5">レア<input type="radio" name="rarity" value="6">エピック<input type="radio" name="rarity" value="4">レジェンド<br>
        </li>
        <li>
          <label>クラス</label><input type="radio" name="class" value="9">ドルイド<input type="radio" name="class" value="4">ハンター<input type="radio" name="class" value="5">メイジ
          <input type="radio" name="class" value="8">パラディン<input type="radio" name="class" value="3">ブリースト<input type="radio" name="class" value="7">ローグ<input type="radio" name="class" value="2">シャーマン
          <input type="radio" name="class" value="10">ウォーロック<input type="radio" name="class" value="6">ウォリアー<input type="radio" name="class" value="1">中立
        </li>

        <input type="submit" value="検索">
      </ul>
    </form>
  </div>
    <?php
    //検索機能
      if(isset($_POST["name"])||isset($_POST["cost"])||isset($_POST["attack"])||isset($_POST["health"])||isset($_POST["type"])||isset($_POST["rarity"])||isset($_POST["class"])){
        $name=$_POST["name"];
        $cost=$_POST["cost"];
        $attack=$_POST["attack"];
        $health=$_POST["health"];
        $type=$_POST["type"];
        $rarity=$_POST["rarity"];
        $class=$_POST["class"];

        switch ($type) {
          case '1':
            $strtype="呪文";
            break;

          case '2':
            $strtype="ミニオン";
            break;
        }

        switch ($rarity) {
          case '2':
            $strrarity="コモン";
          break;
          case '5':
            $strrarity="レア";
          break;
          case '6':
            $strrarity="エピック";
          break;
          case '4':
            $strrarity="レジェンド";
          break;
        }

        switch ($class) {
          case "1":
            $strclass="中立";
          break;
          case "2":
            $strclass="シャーマン";
          break;
          case "3":
            $strclass="ブリースト";
          break;
          case "4":
            $strclass="ハンター";
          break;
          case "5":
            $strclass="メイジ";
          break;
          case "6":
            $strclass="ウォリアー";
          break;
          case "7":
            $strclass="ローグ";
          break;
          case "8":
            $strclass="パラディン";
          break;
          case "9":
            $strclass="ドロイド";
          break;
          case "10":
            $strclass="ウォーロック";
          break;

        }
        print "<h3>検索条件</h3> 名前: <strong>".$name."</strong> コスト: <strong>".$cost."</strong> アタック: <strong>".$attack."</strong> ヘルス <strong>".$health."</strong> カードタイプ: <strong>".$strtype."</strong> レアリティ: <strong>".$strrarity."</strong> クラス: <strong>".$strclass."</strong>";

        print "<h3>検索結果</h3>";
        $pdo=new PDO("sqlite:sqlhearthstone.db");

        if($name!=null || $cost!=null||$attack!=null||$health!=null ||$type!=null||$rarity!=null ||$class!=null){
          $query="SELECT * FROM cards where";
          $temp_query=array();
          if ($name!=null){
            $query.=" name=? AND";
            array_push($temp_query,$name);
          }
          if ($cost!=null){
            $query.=" cost=? AND";
            array_push($temp_query,$cost);
          }
          if ($attack!=null){
            $query.=" attack=? AND";
            array_push($temp_query,$attack);
          }
          if ($health!=null){
            $query.=" health=? AND";
            array_push($temp_query,$health);
          }
          if ($type!=null){

            if($type=="1"){
              $query.=" (type_id=1 OR type_id=3) AND";
            }
            else{
            $query.=" type_id=? AND";
            array_push($temp_query,$type);
          }
          }
          if($rarity!=null){
            if($rarity=="2"){
              $query.=" (rarity_id=1 OR rarity_id=2 OR rarity_id=3) AND";
            }
            else{
              $query.=" rarity_id=".$rarity." AND";
            }
          }
          if ($class!=null){
            $query.=" player_class_id=? AND";
            array_push($temp_query,$class);
          }
          if ($query[strlen($query)-3].$query[strlen($query)-2].$query[strlen($query)-1]==="AND"){
            $query=substr($query,0,strlen($query)-4);
          }
          $query.=";";
          $search=$pdo->prepare($query);
          $search->execute($temp_query);
        }
        else{
            $query="SELECT * FROM cards";
            $search=$pdo->prepare($query);
            $search->execute();
        }
        print "<form action='search.php' method='POST'>";
        print "<table>";
        print "<th>チェック</th><th>名前</th><th>コスト</th><th>アタック</th><th>ヘルス</th><th>テキスト</th><th>クラス</th><th>プレビュー</th>";
        while($result = $search->fetch(PDO::FETCH_ASSOC)){
          switch ($result["player_class_id"]) {
            case "1":
              $strclass="中立";
              $className="AllClass";
            break;
            case "2":
              $strclass="シャーマン";
              $className="Shaman";
            break;
            case "3":
              $strclass="ブリースト";
              $className="Priest";
            break;
            case "4":
              $strclass="ハンター";
              $className="Hunter";
            break;
            case "5":
              $strclass="メイジ";
              $className="Mage";
            break;
            case "6":
              $strclass="ウォリアー";
              $className="Warrior";
            break;
            case "7":
              $strclass="ローグ";
              $className="Rogue";
            break;
            case "8":
              $strclass="パラディン";
              $className="Paladin";
            break;
            case "9":
              $strclass="ドロイド";
              $className="Druid";
            break;
            case "10":
              $strclass="ウォーロック";
              $className="Warlock";
            break;

          }
          print "<tr>";
          print "<td><input type='checkbox' name='card[]' value='".$result["id"]."'>";
          print "<input type='checkbox' name='card[]' value='".$result["id"]."'></td>";
          print "<td>".$result['name']."</td>";
          print "<td>".$result['cost']."</td>";
          print "<td>".$result['attack']."</td>";
          print "<td>".$result['health']."</td>";
          print "<td>".$result['text']."</td>";
          print "<td>".$strclass."</td>";

            if(strstr($result["id_text"],"FP1")){
              $className="Naxxramas";
              $result["name"]  = preg_replace("/( |　)/", "", $result["name"] );
          }

            $result["name"]  = preg_replace("/( |　)/", "_", $result["name"] );



          //空白除去


          print '<td><img src="http://hearthstone-jp-wiki.com/img/'.$className.'/'.$result["name"].'.png"></td>';
          print "</tr>";
        }
        print "</table>";
        print "<input type='submit'>";
        print "</form>";
      }
     ?>
  </body>
</html>
