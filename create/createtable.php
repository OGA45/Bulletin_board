<?php
    session_start();
    ob_start();
    require_once('../common.php');//XSS防ぐ奴
    require '../vendor/autoload.php';//env
    $dotenv = Dotenv\Dotenv::createImmutable('../');
    $dotenv->load();
    if (isset($_POST["csrf_token"]) && $_POST["csrf_token"] === $_SESSION['csrf_token']) {
        try {
            $dbh=new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4",$_ENV["TEST_NAME"],$_ENV["TEST_PASS"],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>true,]);
            if ( ('' === $_POST['name'])||('' === $_POST['desc']) ){
                header('Location:../');
                exit;
            }else{
                $stmt=$dbh->prepare('select count(id) as cnt from title where name=:name');
                $stmt->bindValue(':name', h($_POST['name']),PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch();
                if($row['cnt']>=1){
                    header('Location:../');
                    exit;
                }
            }
            while(1){
                $id=mt_rand(1,999999999999999);
                $stmt=$dbh->prepare('select count(id) as cnt from title where id=:id');
                $stmt->bindValue(':id', $id,PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch();
                if($row['cnt']==0){
                    $stmt=$dbh->prepare('insert into title values (:id,:name,:desc,:time)');
                    $stmt->bindValue(':id', $id,PDO::PARAM_STR);
                    $stmt->bindValue(':name', h($_POST['name']),PDO::PARAM_STR);
                    $stmt->bindValue(':desc', h($_POST['desc']),PDO::PARAM_STR);
                    $date = new DateTime();
                    $date = $date->format('Y-m-d H:i:s');
                    $stmt->bindValue(':time', $date,PDO::PARAM_STR);
                    $stmt->execute();
                    header('Location:../');
                    exit;
                }

            }
        }catch(PDOException $e){
            print("エラー:" . $e->getMessage() . "\n<br>");
            die();
        }
    }else{
        echo "不正なリクエストです";
    }
?>
