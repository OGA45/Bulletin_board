<?php
    ini_set('display_errors', 1);
    error_reporting(-1);
    ob_start();
    require_once('../../common.php');
    require '../../vendor/autoload.php';//env
    $dotenv = Dotenv\Dotenv::createImmutable('../../');
    $dotenv->load();
    try {
        $dbh=new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4",$_ENV["TEST_NAME"],$_ENV["TEST_PASS"],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>true,]);
        $stmt = $dbh->prepare('SELECT * FROM keizi where id=:id and no=:no');
        $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
        $stmt->bindValue(':no', $_GET['no'],PDO::PARAM_STR);
        $stmt->execute();
        require '../../template.php';
        foreach ($stmt as $row) {
            echo template('index_template.html',$_GET['no'],$row["name"],substr(base64_encode($row["seed"]), 0, 11),h($row["texts"]),$row["times"] );
            }
    } catch (PDOException $e) {
        print("エラー:" . $e->getMessage() . "\n<br>");
        die();
    }
    $dbh = null;
?>
<html>
    <head>
        <title>掲示板:<?php echo h($_GET["name"])?></title>
    </head>
</html>