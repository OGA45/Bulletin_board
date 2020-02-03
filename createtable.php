<?php
    ob_start();
    if ( ('' === $_POST['name'])||('' === $_POST['desc']) ){
        header('Location:top.php');
        exit;
      }
    $dbh=new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4","OGA","OGA",[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>true,]);
    while(1){
        $id=mt_rand(1,999999999999999);
        $stmt=$dbh->prepare('select count(id) as cnt from title where id=:id');
        $stmt->bindValue(':id', $id,PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch();
        if($row['cnt']==0){
            $stmt=$dbh->prepare('insert into title values (:id,:name,:desc)');
            $stmt->bindValue(':id', $id,PDO::PARAM_STR);
            $stmt->bindValue(':name', $_POST['name'],PDO::PARAM_STR);
            $stmt->bindValue(':desc', $_POST['desc'],PDO::PARAM_STR);
            $stmt->execute();
            header('Location: top.php');
        }
    }
?>
