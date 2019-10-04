<?php
    ini_set('display_errors', 1);
    error_reporting(-1);
    ob_start();
    require_once('./common.php');
    if ( (false === isset($_COOKIE["seed"]))||('' === $_COOKIE["seed"]) ) {
        /*$seedx="1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPUQRSTUVWXYZ!?_-^|*+-/"
            $seed=substr(str_shuffle($seedx), 0, 10);
            setcookie("seed",$seed);*/
        $seed = substr(base64_encode(openssl_random_pseudo_bytes(32)), 0, 8);
        setcookie("seed", $seed);
        //$seed = bin2hex(random_bytes(12));
        //echo $seed;
        //echo substr(base64_encode($seed), 0, 11);
    } else {
        $seed = $_COOKIE["seed"];
    }
    //var_dump($seed, $_COOKIE);
?>
<html lang="ja">
    <head>
        <meta charset="utf8ub4"/>
    </head>
    <body background="img/bac.png">
        <a href="top.php"><h1>掲示板:<? echo h($_GET["name"])?></h1></a>
    </body>
    <form action="sql.php?id=<?php echo h($_GET["id"]);?>&name=<?echo h($_GET["name"])?>&sort=<?echo h($_GET["sort"])?>" method="post">
        名前:<input type="name" name="name" size="40" maxlength="15">
        識別番号生成のためのシード:<input type="name" name="seed" size="10" value=<?php echo h($seed) ?> maxlength="8"><Br>
        内容:<textarea name="text" rows="4" cols="40" maxlength="2147483647"></textarea>
        <br><input type="submit" value="送信" onClick=setcookie("seed",$seed);><input type="reset" value="リセット">
    </form>
        <form action="index.php"method="get">
            <input type="radio" name="sort" value="0"<?if($_GET["sort"]==0){echo 'checked="checked"';}?>>昇順
            <input type="radio" name="sort" value="1"<?if ($_GET["sort"] == 1){echo 'checked="checked"';} ?>>降順
            <input type="hidden" name="id" value=<?echo h($_GET["id"]);?>>
            <input type="hidden" name="name" value=<?echo h($_GET["name"])?>>
            <input type="submit" value="更新">
        </form>
    </form>
</html>
<?php
try {
    $dbh = new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4", "OGA", "OGA", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => true,]);
    //print("ステータス=");
    //print("接続しました。\n<br>");
    if($_GET["sort"]==1){
        $stmt = $dbh->prepare('SELECT * FROM keizi where id=:id order by time desc ');
        $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
    }else{
        $stmt = $dbh->prepare('SELECT * FROM keizi where id=:id');
        $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
        $stmt->execute();
    }
    $i=1;
    require 'template.php';
    if($_GET["sort"]==1){
        foreach ($stmt as $row) {
            echo template('index.html',$count,$row["name"],substr(base64_encode($row["seed"]), 0, 11),h($row["text"]),$row["time"] );
            $count--;
        }
    }else{
        foreach ($stmt as $row) {
            //print($row["name"] . "\n<br>");
            //print(substr(base64_encode($row["seed"]), 0, 11) . "\n<br>");
            //echo nl2br($row["text"] . "\n");
            //print($row["time"] . "\n<br>");
            echo template('index.html',$i,$row["name"],substr(base64_encode($row["seed"]), 0, 11),h($row["text"]),$row["time"] );
            $i++;
        }
    }
} catch (PDOException $e) {
    print("エラー:" . $e->getMessage() . "\n<br>");
    die();
}
$dbh = null;
?>
<html>
    <form action="Delete.php?id=<?php echo h($_GET["id"]);?>&name=<?echo h($_GET["name"])?>" method="post">
    <input type="submit" value="削除";>
</html>