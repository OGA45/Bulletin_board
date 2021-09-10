<?php
    ob_start();
    session_start();
    ini_set('display_errors', 1);
    $toke_byte = openssl_random_pseudo_bytes(16);
    $csrf_token = bin2hex($toke_byte);
    $_SESSION['csrf_token'] = $csrf_token;
    require_once('../../common.php');
    require '../../vendor/autoload.php';//env
    $dotenv = Dotenv\Dotenv::createImmutable('../../');
    $dotenv->load();
    $dbh=new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4",$_ENV["TEST_NAME"],$_ENV["TEST_PASS"],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>true,]);
    $stmt = $dbh->prepare('SELECT count(id) AS cnt FROM title where id=:id');
    $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
    if($row['cnt']==0){
        $h="../../";
        header('Location: '.$h);
        exit;
    }
?>
<html>
    <head>
    <title>削除:<?php echo h($_GET["name"])?></title>
    </head>
    <body background="/bord/img/bac.png">
        <a href="../?id=<?php echo  h($_GET["id"]);?>&name=<?php echo h($_GET["name"])?>&sort=0"><h1>板の削除</h1></a>
        <p><?php echo h($_GET["name"]) ?>を削除します。よろしければパスワードを入力し、続行を押してください。</p>
        <form action="Deletesql.php?id=<?php echo h($_GET["id"]);?>&name=<?php echo h($_GET["name"])?>" method="post">
        <input type="password" name="pass" size="15" maxlength="15">
        <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
        <input type="submit" value="続行";>
    </body>
</html>

