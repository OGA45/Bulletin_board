<?php
    //
    ob_start();
    session_start();

    $dbh=new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4","OGA","OGA",[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>true,]);

    //$stmt=$dbh->prepare('select count(mail) as cnt from login where mail=:mail AND pass=:pass');
    $stmt=$dbh->prepare('select * from login where mail=:mail;');
    $stmt->bindValue(':mail', $_POST['mail'],PDO::PARAM_STR);
    //$stmt->bindValue(':pass', $_POST['pass'],PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
    if(empty($row)){
        $h="login.php?e=1";
        header('Location: '.$h);
        exit;
    }
    // IDはあった
    // passwordを比較：password_verify
    if(password_verify($_POST['pass'],$row['pass'])==false){
        $h="login.php?e=1";
        header('Location: '.$h);
        exit;
    }
    // XXX ここまできたらログインOK
    session_regenerate_id(true);
    $_SESSION['auth']['name'] = $row['name'];
    $_SESSION['auth']['seed'] = $row['seed'];
    $_SESSION['auth']['id'] = $row['id'];
    header('Location:top.php');
/*
//
ob_start();
session_start();

if (false === isset($_SESSION['auth'])) {
    // ログインしてないからindexに飛ぶ
    header('Location: login.php');
    exit;
}

-------------------
ob_start();
session_start();

unset($_SESSION['auth']);
header('Location: login.php');


*/
?>