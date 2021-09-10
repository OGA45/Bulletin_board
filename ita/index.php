 <?php
    ob_start();
    session_start();
    ini_set('display_errors', 1);
    error_reporting(-1);
    require_once('../common.php');
    require '../vendor/autoload.php';//env
    $dotenv = Dotenv\Dotenv::createImmutable('../');
    $dotenv->load();
    $toke_byte = openssl_random_pseudo_bytes(16);
    $csrf_token = bin2hex($toke_byte);
    $_SESSION['csrf_token'] = $csrf_token;
    if ( (false === isset($_GET["id"]))||('' === $_GET["name"]) ) {
        $h="../";
        header('Location: '.$h);
        exit;
    }
    if ( (false === isset($_COOKIE["seed"]))||('' === $_COOKIE["seed"]) ) {
        $seed = substr(base64_encode(openssl_random_pseudo_bytes(32)), 0, 8);
        setcookie("seed", $seed);
    } else {
        $seed = $_COOKIE["seed"];
    }
    if(isset($_SESSION['auth'])){
    require 'loginform.php';
    }else{
    require 'form.php';
    }
    try {
        $dbh=new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4",$_ENV["TEST_NAME"],$_ENV["TEST_PASS"],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>true,]);
        if($_GET["sort"]==1){
            $stmt = $dbh->prepare('SELECT * FROM keizi where id=:id order by times desc ');
            $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
            $stmt->execute();
        }else{
            $stmt = $dbh->prepare('SELECT * FROM keizi where id=:id');
            $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
            $stmt->execute();
        }
        require '../template.php';
        foreach ($stmt as $row) {
            if($row['login']==1){
                echo template('index_template.html',$row["no"],h($row["name"]),substr(base64_encode($row["seed"]), 0, 11)."☆",h($row["texts"]),$row["times"] );
            }else{
                echo template('index_template.html',$row["no"],h($row["name"]),substr(base64_encode($row["seed"]), 0, 11),h($row["texts"]),$row["times"] );
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
    <head>
        <title>掲示板:<?php echo h($_GET["name"])?></title>
    </head>
    <form action="delete?id=<?php echo h($_GET["id"]);?>&name=<?php echo h($_GET["name"])?>" method="post">
        <input type="submit" value="削除";>
    </form>
</html>