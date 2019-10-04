<?php
    ini_set('display_errors', 1);
    error_reporting(-1);
    //
    ob_start();
    if ( (false === isset($_COOKIE["seed"]))||('' === $_COOKIE["seed"]) ) {
        /*$seedx="1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPUQRSTUVWXYZ!?_-^|*+-/"
            $seed=substr(str_shuffle($seedx), 0, 10);
            setcookie("seed",$seed);*/
        $seed = substr(base64_encode(openssl_random_pseudo_bytes(32)), 0, 8);
        setcookie("seed", $seed);
        //$seed = bin2hex(random_bytes(12));
        //echo $seed;
        echo substr(base64_encode($seed), 0, 11);
    } else {
        $seed = $_COOKIE["seed"];
    }
    //var_dump($seed, $_COOKIE);
?>
<html lang="ja">
    <head>
        <meta charset="utf8ub4"/>
    </head>
    <body>
        <h1>掲示板</h1>
    </body>
    <form action="sql.php" method="post">
        名前:<input type="name" name="name" size="40" maxlength="15">
        識別番号生成のためのシード:<input type="name" name="seed" size="10" value=<?php echo $seed ?> maxlength="8"><Br>
        内容:<textarea name="text" rows="4" cols="40" maxlength="2147483647"></textarea>
        <input type="radio" name="sort" value="nodesc" checked="checked">昇順
        <input type="radio" name="sort" value="desc">降順
        <br><input type="submit" value="送信" onClick=setcookie("seed",$seed);><input type="reset" value="リセット">
<?php
try {
    $dbh = new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4", "OGA", "OGA", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => true,]);
    print("ステータス=");
    print("接続しました。\n<br>");
    $stmt = $dbh->prepare('SELECT * FROM keizi order by time desc');
    $stmt->execute();
    $i=1;
    require 'template.php';
    foreach ($stmt as $row) {
        //print($row["name"] . "\n<br>");
        //print(substr(base64_encode($row["seed"]), 0, 11) . "\n<br>");
        //echo nl2br($row["text"] . "\n");
        //print($row["time"] . "\n<br>");
        echo template('index.html',$i,$row["name"],substr(base64_encode($row["seed"]), 0, 11),$row["text"],$row["time"] );
        $i++;
    }
} catch (PDOException $e) {
    print("エラー:" . $e->getMessage() . "\n<br>");
    die();
}
$dbh = null;
?>