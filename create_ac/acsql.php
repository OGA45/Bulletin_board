<?php
  session_start();
  if (isset($_POST["csrf_token"]) && $_POST["csrf_token"] === $_SESSION['csrf_token']) {
    $datum = [];
    foreach(['name', 'mail', 'pass','seed'] as $s) {
      $datum[$s] = (string)@$_POST[$s];
    }
    if ( ('' === $datum['name'])||('' === $datum['mail'])||(''===$datum['pass'])||(''===$datum['seed'])){
      $h="./?e=2";
      header('Location: '.$h);
      exit;
    }
    ini_set('display_errors', 1);
    error_reporting(-1);
    ob_start();
    require_once('../common.php');//XSS防ぐ奴
    require '../vendor/autoload.php';//env
    $dotenv = Dotenv\Dotenv::createImmutable('../');
    $dotenv->load();
    $dbh=new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4",$_ENV["TEST_NAME"],$_ENV["TEST_PASS"],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>true,]);
    $stmt=$dbh->prepare('select count(id) as cnt from login where mail=:mail OR seed=:seed ');
    $stmt->bindValue(':mail', $datum['mail'],PDO::PARAM_STR);
    $stmt->bindValue(':seed', h($datum['seed']),PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
    if($row['cnt']==0){
      while(1){
        $id=substr(base64_encode($datum['seed']),0,11);
        $stmt=$dbh->prepare('select count(id) as cnt from login where id=:id');
        $stmt->bindValue(':id', $id,PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch();
        if($row['cnt']==0){
          $stmt=$dbh->prepare('insert into login values (:id,:name,:mail,:pass,:seed,:ena,:time)');
          $stmt->bindValue(':name', h($datum['name']),PDO::PARAM_STR);
          $stmt->bindValue(':mail', $datum['mail'],PDO::PARAM_STR);
          $stmt->bindValue(':pass', password_hash($datum['pass'],PASSWORD_DEFAULT),PDO::PARAM_STR);
          $stmt->bindValue(':seed', $datum['seed'],PDO::PARAM_STR);
          $stmt->bindValue(':ena', "0",PDO::PARAM_STR);
          $stmt->bindValue(':id', $id,PDO::PARAM_STR);
          $date = new DateTime();
          $date = $date->format('Y-m-d H:i:s');
          $stmt->bindValue(':time', $date,PDO::PARAM_STR);
          $stmt->execute();
          mb_language("Japanese");
          mb_internal_encoding("UTF-8");
          $to = $datum['mail'];
          $subject = "oga.f5.si掲示板メールアドレス確認";
          $message = "登録ありがとうございます。\r\nhttps://oga.f5.si/bord/create_ac/enabled/?seed=".$datum['seed'];
          $headers = "From:oga@oga.f5.si";
          mb_send_mail($to,$subject,$message,$headers);
          $h="success";
          header('Location: '.$h);
          exit;
        }
      }
    }else{
      $h="./?e=1";
      header('Location: '.$h);
      exit;
    }
  }else{
    echo "不正なリクエストです";
  }
?>