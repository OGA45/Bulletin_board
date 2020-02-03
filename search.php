<?php
    ini_set('display_errors', 1);
    error_reporting(-1);
    ob_start();
    require_once('./common.php');
    try {
    $dbh = new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4", "OGA", "OGA", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => true,]);
    //print("ステータス=");
    //print("接続しました。\n<br>");
     $stmt = $dbh->prepare('SELECT * FROM keizi where id=:id and no=:no');
    $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
    $stmt->bindValue(':no', $_GET['no'],PDO::PARAM_STR);
    $stmt->execute();
    require 'template.php';
    foreach ($stmt as $row) {
        echo template('index.html',$_GET['no'],$row["name"],substr(base64_encode($row["seed"]), 0, 11),h($row["text"]),$row["time"] );
        }
    } catch (PDOException $e) {
    print("エラー:" . $e->getMessage() . "\n<br>");
    die();
}
$dbh = null;
?>