<?php
    ob_start();
    session_start();
    ini_set('display_errors', 1);
    error_reporting(-1);
    require_once('./common.php');
    if ( (false === isset($_GET["id"]))||('' === $_GET["name"]) ) {
        $h="top.php";
        header('Location: '.$h);
        exit;
    }
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
    //var_dump($seed, $_COOKIE); onClick=setcookie("seed",$seed)
    if(isset($_SESSION['auth'])){
    require 'loginform.php';
    }else{
    require 'form.php';
    }
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4", "OGA", "OGA", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => true,]);
        //print("ステータス=");
        //print("接続しました。\n<br>");
        if($_GET["sort"]==1){
            $stmt = $dbh->prepare('SELECT * FROM keizi where id=:id order by time desc ');
            $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
            $stmt->execute();
            //$count=$stmt->rowCount();
        }else{
            $stmt = $dbh->prepare('SELECT * FROM keizi where id=:id');
            $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
            $stmt->execute();
        }
        //$i=1;
        require 'template.php';
        foreach ($stmt as $row) {
            if($row['login']==1){
                echo template('index.html',$row["no"],h($row["name"]),substr(base64_encode($row["seed"]), 0, 11)."☆",h($row["text"]),$row["time"] );
            }else{
                echo template('index.html',$row["no"],h($row["name"]),substr(base64_encode($row["seed"]), 0, 11),h($row["text"]),$row["time"] );
            }
            $no=$row["no"];    
        }
            
    }catch(PDOException $e){
        print("エラー:" . $e->getMessage() . "\n<br>");
        die();
    }
$dbh = null;
?>
<html>
    <form action="Delete.php?id=<?php echo h($_GET["id"]);?>&name=<?echo h($_GET["name"])?>" method="post">
    <input type="submit" value="削除";>
</html>