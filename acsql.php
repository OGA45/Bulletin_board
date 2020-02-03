<?php
  $datum = [];
  foreach(['name', 'mail', 'pass','seed'] as $s) {
    $datum[$s] = (string)@$_POST[$s];
  }
  // validate
  if ( ('' === $datum['name'])||('' === $datum['mail'])||(''===$datum['pass'])||(''===$datum['seed'])){
    $h="createac.php?e=2";
    header('Location: '.$h);
    exit;
  }
  $dbh=new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4","OGA","OGA",[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>true,]);
  $stmt=$dbh->prepare('select count(id) as cnt from login where mail=:mail OR seed=:seed ');
  $stmt->bindValue(':mail', $datum['mail'],PDO::PARAM_STR);
  $stmt->bindValue(':seed', $datum['seed'],PDO::PARAM_STR);
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
        $stmt=$dbh->prepare('insert into login values (:name,:mail,:pass,:seed,:ena,:id,:time)'); 
        $stmt->bindValue(':name', $datum['name'],PDO::PARAM_STR);
        $stmt->bindValue(':mail', $datum['mail'],PDO::PARAM_STR);
        $stmt->bindValue(':pass', password_hash($datum['pass'],PASSWORD_DEFAULT),PDO::PARAM_STR);
        $stmt->bindValue(':seed', $datum['seed'],PDO::PARAM_STR);
        $stmt->bindValue(':ena', "0",PDO::PARAM_STR);
        $stmt->bindValue(':id', $id,PDO::PARAM_STR);
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $stmt->bindValue(':time', $date,PDO::PARAM_STR);
        $stmt->execute();
        //session_start();
        //$_SESSION[substr(base64_encode($datum['seed']),0,11)]=1;
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $to = $datum['mail'];
        $subject = "dev2掲示板メールアドレス確認";
        $message = "登録ありがとうございます。\r\nhttp://dev2.m-fr.net/OGA/T/acenable.php?seed=".$datum['seed'];
        $headers = "From:OGA@dev2.m-fr.net";
        mb_send_mail($to,$subject,$message,$headers);
        $h="acmail.php";
        header('Location: '.$h);
        exit;
      }
    }
  }else{
    $h="createac.php?e=1";
    header('Location: '.$h);
    exit;
  }
  
?>