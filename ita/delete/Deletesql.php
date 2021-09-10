<?php
    ob_start();
    session_start();
    if (isset($_POST["csrf_token"]) && $_POST["csrf_token"] === $_SESSION['csrf_token']) {
        require '../../vendor/autoload.php';//env
        $dotenv = Dotenv\Dotenv::createImmutable('../../');
        $dotenv->load();
        $dbh=new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4",$_ENV["TEST_NAME"],$_ENV["TEST_PASS"],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>true,]);
        if($_POST["pass"]=="p@ssw0rd"){
            $stmt = $dbh->prepare('DELETE from keizi where id=:id');
            $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
            $stmt->execute();
            $stmt = $dbh->prepare('DELETE from title where id=:id');
            $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
            $stmt->execute();
            header('Location:../');
        }else{
            header('Location:../');
        }
    }else{
        echo "不正なリクエストです";
    }
?>
