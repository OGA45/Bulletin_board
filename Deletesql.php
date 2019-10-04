<?php
    $dbh = new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4", "OGA", "OGA", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => true,]);
    if($_POST["pass"]=="passw0rd"){
        $stmt = $dbh->prepare('DELETE from keizi where id=:id');
        $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
        $stmt->execute();
        $stmt = $dbh->prepare('DELETE from title where id=:id');
        $stmt->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
        $stmt->execute();
        header('Location:top.php');
    }else{
        header('Location:top.php');
    }
